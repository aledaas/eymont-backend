<?php

namespace Database\Seeders;


use App\Domain\Content\Models\ExerciseTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

    {

        $templates = [

            [

                'name' => 'Multiple Choice',

                'slug' => 'multiple_choice',

                'type' => 'multiple_choice',

                'description' => 'Learner selects one correct answer from several options.',

                'schema' => [

                    'question' => 'string',

                    'options' => 'array',

                    'expected_answer' => 'string',

                ],

            ],

            [

                'name' => 'True or False',

                'slug' => 'true_false',

                'type' => 'true_false',

                'description' => 'Learner decides whether a statement is true or false.',

                'schema' => [

                    'question' => 'string',

                    'expected_answer' => 'boolean',

                ],

            ],

            [

                'name' => 'Fill in the Blank',

                'slug' => 'fill_in_the_blank',

                'type' => 'fill_in_the_blank',

                'description' => 'Learner completes a sentence with the missing word or phrase.',

                'schema' => [

                    'question' => 'string',

                    'expected_answer' => 'string',

                ],

            ],

            [

                'name' => 'Sentence Transformation',

                'slug' => 'sentence_transformation',

                'type' => 'sentence_transformation',

                'description' => 'Learner rewrites a sentence following a target grammar pattern.',

                'schema' => [

                    'question' => 'string',

                    'expected_answer' => 'string',

                    'evaluation_criteria' => 'array',

                ],

            ],

            [

                'name' => 'Sentence Ordering',

                'slug' => 'sentence_ordering',

                'type' => 'sentence_ordering',

                'description' => 'Learner orders words or phrases to create a correct sentence.',

                'schema' => [

                    'items' => 'array',

                    'expected_order' => 'array',

                ],

            ],

            [

                'name' => 'Listening Exercise',

                'slug' => 'listening_exercise',

                'type' => 'listening',

                'description' => 'Learner answers based on an audio input.',

                'schema' => [

                    'audio_url' => 'string',

                    'question' => 'string',

                    'expected_answer' => 'string',

                ],

            ],

        ];

        foreach ($templates as $template) {

            ExerciseTemplate::updateOrCreate(

                ['slug' => $template['slug']],

                [

                    'name' => $template['name'],

                    'type' => $template['type'],

                    'description' => $template['description'],

                    'schema' => $template['schema'],

                    'is_active' => true,

                ]

            );

        }

    }
}
