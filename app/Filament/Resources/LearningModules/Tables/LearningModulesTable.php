<?php

namespace App\Filament\Resources\LearningModules\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Table;

class LearningModulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('level')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])

            ->filters([
                //
            ])

            ->recordActions([

                Action::make('lessons')
                    ->label('Lessons')
                    ->icon('heroicon-o-academic-cap')
                    ->slideOver()
                    ->modalWidth('3xl')
                    ->modalHeading(
                        fn ($record) => 'Lessons: ' . $record->title
                    )
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalContent(function ($record) {

                        return view(
                            'filament.content.learning-modules.lessons-slide-over',
                            [
                                'module' => $record,
                                'lessons' => $record->lessons()
                                    ->orderBy('order')
                                    ->get(),
                            ]
                        );
                    }),

                ViewAction::make(),

                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
