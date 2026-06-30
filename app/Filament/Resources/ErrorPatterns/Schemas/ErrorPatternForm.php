<?php

namespace App\Filament\Resources\ErrorPatterns\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ErrorPatternForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información general')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn (Set $set, ?string $state) =>
                                $set('slug', Str::slug($state))
                            ),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Select::make('category')
                            ->label('Categoría')
                            ->options([
                                'grammar' => 'Grammar',
                                'vocabulary' => 'Vocabulary',
                                'comprehension' => 'Comprehension',
                                'word_order' => 'Word Order',
                                'pronunciation' => 'Pronunciation',
                            ])
                            ->searchable(),

                        Select::make('severity')
                            ->label('Severidad')
                            ->options([
                                'low' => 'Low',
                                'medium' => 'Medium',
                                'high' => 'High',
                            ])
                            ->default('medium')
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Activo')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Inteligencia pedagógica')
                    ->schema([
                        Textarea::make('description')
                            ->label('Descripción interna')
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('student_message')
                            ->label('Mensaje para el alumno')
                            ->rows(4)
                            ->columnSpanFull(),

                        Textarea::make('teacher_hint')
                            ->label('Sugerencia pedagógica')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Section::make('Adaptive Learning')
                    ->schema([
                        Select::make('recommended_lesson_id')
                            ->label('Lesson recomendada')
                            ->relationship('recommendedLesson', 'title')
                            ->searchable()
                            ->preload(),
                    ]),
            ]);
    }
}
