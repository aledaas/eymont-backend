<?php

namespace Database\Seeders;

use App\Domain\Content\Models\NeuroTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NeuroTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

    {

        $tags = [

            ['name' => 'Memory', 'description' => 'Supports retention and recall.'],

            ['name' => 'Attention', 'description' => 'Focuses learner attention on key language patterns.'],

            ['name' => 'Comprehension', 'description' => 'Supports understanding of meaning and structure.'],

            ['name' => 'Production', 'description' => 'Requires the learner to produce language.'],

            ['name' => 'Recognition', 'description' => 'Requires identifying correct forms or meanings.'],

            ['name' => 'Transfer', 'description' => 'Applies knowledge in a new context.'],

            ['name' => 'Repetition', 'description' => 'Supports spaced or repeated practice.'],

            ['name' => 'Cognitive Load', 'description' => 'Controls mental effort and complexity.'],

        ];

        foreach ($tags as $tag) {

            NeuroTag::updateOrCreate(

                ['slug' => Str::slug($tag['name'])],

                [

                    'name' => $tag['name'],

                    'description' => $tag['description'],

                    'is_active' => true,

                ]

            );

        }

    }
}
