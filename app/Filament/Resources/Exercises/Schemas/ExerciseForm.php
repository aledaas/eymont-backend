<?php

namespace App\Filament\Resources\Exercises\Schemas;

use App\Models\ContentBlock;
use App\Models\ErrorPattern;
use App\Models\ExerciseTemplate;
use App\Models\Lesson;
use App\Models\NeuroTag;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExerciseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('lesson_id')
                    ->relationship('lesson', 'title')
                    ->required(),

                Select::make('content_block_id')
                    ->relationship('contentBlock', 'title'),

                Select::make('exercise_template_id')
                    ->relationship('template', 'name'),

                TextInput::make('title')
                    ->required(),

                TextInput::make('type')
                    ->required(),

                RichEditor::make('question')
                    ->required()
                    ->columnSpanFull(),

                Repeater::make('options')
                    ->simple(
                        TextInput::make('value')
                    ),

                Repeater::make('expected_answer')
                    ->simple(
                        TextInput::make('value')
                    ),

                RichEditor::make('explanation')
                    ->columnSpanFull(),

                Select::make('difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ]),

                TextInput::make('skill'),

                Select::make('neuroTags')
                    ->multiple()
                    ->relationship('neuroTags', 'name'),

                Select::make('errorPatterns')
                    ->multiple()
                    ->relationship('errorPatterns', 'name'),

                Toggle::make('ai_evaluable')
                    ->default(false),

                KeyValue::make('evaluation_criteria'),

                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),

                TextInput::make('order')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
