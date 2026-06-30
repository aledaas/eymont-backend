<?php

namespace App\Filament\Resources\Exercises\Tables;

use App\Domain\Content\Models\Exercise;
use App\Modules\AI\Application\UseCases\GenerateExerciseVariants;
use App\Modules\AI\Domain\DTOs\ExerciseVariantRequest;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExercisesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lesson_id')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('content_block_id')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('exercise_template_id')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('type')
                    ->searchable(),

                TextColumn::make('difficulty')
                    ->searchable(),

                TextColumn::make('skill')
                    ->searchable(),

                IconColumn::make('ai_evaluable')
                    ->boolean(),
                IconColumn::make('generated_by_ai')
                    ->label('AI Generated')
                    ->boolean(),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('order')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                //
            ])

            ->recordActions([
                ViewAction::make(),

                EditAction::make(),

                Action::make('generate_ai_variants')
                    ->label('Generar variantes con IA')
                    ->icon('heroicon-o-sparkles')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Generar y guardar variantes con IA')
                    ->modalDescription(
                        'Se generarán variantes controladas del ejercicio y se guardarán como nuevos ejercicios en estado draft. El ejercicio original no será modificado.'
                    )
                    ->modalSubmitActionLabel('Generar y guardar drafts')
                    ->action(function (Exercise $record): void {
                        $record->loadMissing('neuroTags');

                        $exerciseText = $record->question
                            ?: $record->title
                                ?: 'Exercise without question';

                        $neuroTags = $record->neuroTags
                            ->pluck('name')
                            ->values()
                            ->toArray();

                        $useCase = app(GenerateExerciseVariants::class);

                        $request = new ExerciseVariantRequest(
                            instruction: 'Create controlled variants for this English exercise. Keep the same exercise type and pedagogical objective.',
                            exerciseText: $exerciseText,
                            grammarPattern: $record->skill,
                            difficulty: $record->difficulty,
                            neuroTags: $neuroTags,
                            variantsCount: 3,
                        );

                        $variants = $useCase->execute($request);

                        $baseOrder = (int) Exercise::query()
                            ->where('lesson_id', $record->lesson_id)
                            ->max('order');

                        $createdExercises = [];

                        foreach ($variants as $index => $variant) {
                            $createdExercises[] = Exercise::create([
                                'lesson_id' => $record->lesson_id,
                                'content_block_id' => $record->content_block_id,
                                'exercise_template_id' => $record->exercise_template_id,
                                'title' => $variant->title ?: ($record->title ?: 'AI Generated Exercise'),
                                'type' => $record->type,
                                'question' => $variant->question,
                                'options' => $variant->options,
                                'expected_answer' => $variant->expectedAnswer,
                                'explanation' => $variant->explanation,
                                'difficulty' => $variant->difficulty ?: $record->difficulty,
                                'skill' => $variant->skill ?: $record->skill,
                                'evaluation_criteria' => $record->evaluation_criteria,
                                'ai_evaluable' => $record->ai_evaluable,
                                'status' => 'draft',
                                'order' => $baseOrder + $index + 1,
                                'generated_by_ai' => true,
                                'parent_exercise_id' => $record->id,
                            ]);
                        }

                        $body = collect($createdExercises)
                            ->map(fn (Exercise $exercise) => "#{$exercise->id} - {$exercise->question}")
                            ->implode("\n");

                        Notification::make()
                            ->title('Variantes guardadas como drafts')
                            ->body($body)
                            ->success()
                            ->persistent()
                            ->send();
                    }),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
