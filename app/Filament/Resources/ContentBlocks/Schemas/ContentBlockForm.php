<?php

namespace App\Filament\Resources\ContentBlocks\Schemas;

use App\Modules\Content\Domain\Models\Lesson;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContentBlockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('lesson_id')
                    ->label('Lesson')
                    ->options(
                        Lesson::query()
                            ->orderBy('title')
                            ->pluck('title', 'id')
                            ->toArray()
                    )
                    ->searchable()
                    ->required(),

                Select::make('type')
                    ->options([
                        'reading' => 'Reading',
                        'grammar_pattern' => 'Grammar Pattern',
                        'example' => 'Example',
                        'exercise' => 'Exercise',
                        'feedback' => 'Feedback',
                        'review' => 'Review',
                        'audio' => 'Audio',
                        'image' => 'Image',
                        'micro_lesson' => 'Micro Lesson',
                    ])
                    ->required(),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('content')
                    ->label('Content')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'bulletList',
                        'orderedList',
                        'blockquote',
                        'h2',
                        'h3',
                        'link',
                        'undo',
                        'redo',
                    ])
                    ->columnSpanFull(),

                TextInput::make('order')
                    ->numeric()
                    ->default(1)
                    ->required(),

                Select::make('difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ])
                    ->default('easy')
                    ->required(),

                TagsInput::make('neuro_tags')
                    ->suggestions([
                        'memoria',
                        'atencion',
                        'comprension',
                        'produccion',
                        'reconocimiento',
                        'transferencia',
                        'repeticion',
                        'carga_cognitiva',
                    ]),

                KeyValue::make('metadata')
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
