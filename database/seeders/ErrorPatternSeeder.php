<?php

namespace Database\Seeders;


use App\Domain\Content\Models\ErrorPattern;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ErrorPatternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

    {

        $patterns = [

            ['name' => 'Omit Auxiliary', 'slug' => 'omit_auxiliary', 'category' => 'grammar'],

            ['name' => 'DO / DOES Confusion', 'slug' => 'do_does_confusion', 'category' => 'grammar'],

            ['name' => 'Wrong Word Order', 'slug' => 'wrong_word_order', 'category' => 'word_order'],

            ['name' => 'WH Question Confusion', 'slug' => 'wh_question_confusion', 'category' => 'grammar'],

            ['name' => 'Vocabulary Error', 'slug' => 'vocabulary_error', 'category' => 'vocabulary'],

            ['name' => 'Comprehension Error', 'slug' => 'comprehension_error', 'category' => 'comprehension'],

        ];

        foreach ($patterns as $pattern) {

            ErrorPattern::updateOrCreate(

                ['slug' => $pattern['slug']],

                [

                    'name' => $pattern['name'],

                    'category' => $pattern['category'],

                    'description' => null,

                    'is_active' => true,

                ]

            );

        }

    }
}
