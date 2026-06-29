<?php

namespace Database\Seeders;

use App\Domain\Content\Models\ContentBlock;
use App\Domain\Content\Models\ErrorPattern;
use App\Domain\Content\Models\Exercise;
use App\Domain\Content\Models\ExerciseTemplate;
use App\Domain\Content\Models\LearningModule;
use App\Domain\Content\Models\Lesson;
use App\Domain\Content\Models\NeuroTag;
use Illuminate\Database\Seeder;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $recognition = NeuroTag::where('slug', 'recognition')->firstOrFail();
        $attention = NeuroTag::where('slug', 'attention')->firstOrFail();
        $memory = NeuroTag::where('slug', 'memory')->firstOrFail();
        $comprehension = NeuroTag::where('slug', 'comprehension')->firstOrFail();
        $production = NeuroTag::where('slug', 'production')->firstOrFail();
        $transfer = NeuroTag::where('slug', 'transfer')->firstOrFail();

        $doDoes = ErrorPattern::where('slug', 'do_does_confusion')->firstOrFail();
        $wordOrder = ErrorPattern::where('slug', 'wrong_word_order')->firstOrFail();
        $whQuestion = ErrorPattern::where('slug', 'wh_question_confusion')->firstOrFail();
        $vocabulary = ErrorPattern::where('slug', 'vocabulary_error')->firstOrFail();

        $multipleChoice = ExerciseTemplate::where('slug', 'multiple_choice')->first();
        $fillBlank = ExerciseTemplate::where('slug', 'fill_in_the_blank')->first();
        $sentenceTransformation = ExerciseTemplate::where('slug', 'sentence_transformation')->first();

        /*
        |--------------------------------------------------------------------------
        | MODULE 1
        |--------------------------------------------------------------------------
        */

        $module1 = LearningModule::create([
            'title' => 'English Starter',
            'slug' => 'english-starter',
            'description' => 'Introduction to basic English questions.',
            'level' => 'A1',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $lesson1 = Lesson::create([
            'learning_module_id' => $module1->id,
            'title' => 'Present Simple Questions',
            'slug' => 'present-simple-questions',
            'description' => 'Learn how to ask questions using DO and DOES.',
            'difficulty' => 'easy',
            'status' => 'published',
            'estimated_minutes' => 10,
            'order' => 1,
        ]);

        $block1 = ContentBlock::create([
            'lesson_id' => $lesson1->id,
            'type' => 'grammar_pattern',
            'title' => 'How to ask questions with DO and DOES',
            'content' => '
                <h2>Present Simple Questions</h2>

                <p>Use <strong>DO</strong> with:</p>

                <ul>
                    <li>I</li>
                    <li>You</li>
                    <li>We</li>
                    <li>They</li>
                </ul>

                <p>Use <strong>DOES</strong> with:</p>

                <ul>
                    <li>He</li>
                    <li>She</li>
                    <li>It</li>
                </ul>
            ',
            'order' => 1,
        ]);

        ContentBlock::create([
            'lesson_id' => $lesson1->id,
            'type' => 'example',
            'title' => 'Examples',
            'content' => '
                <ul>
                    <li>Do you like coffee?</li>
                    <li>Does she play football?</li>
                    <li>Do they study English?</li>
                </ul>
            ',
            'order' => 2,
        ]);

        $exercise1 = Exercise::create([
            'lesson_id' => $lesson1->id,
            'content_block_id' => $block1->id,
            'exercise_template_id' => $multipleChoice?->id,
            'title' => 'Choose the correct question',
            'type' => 'multiple_choice',
            'question' => 'Choose the correct sentence.',
            'options' => [
                'Do she like coffee?',
                'Does she like coffee?',
                'Is she like coffee?',
            ],
            'expected_answer' => [
                'Does she like coffee?',
            ],
            'explanation' => 'Use DOES with she, he and it.',
            'difficulty' => 'easy',
            'skill' => 'grammar',
            'evaluation_criteria' => [
                'checks' => [
                    'auxiliary_usage',
                    'subject_verb_order'
                ]
            ],
            'ai_evaluable' => true,
            'status' => 'published',
            'order' => 1,
        ]);

        $exercise1->neuroTags()->sync([
            $recognition->id,
            $attention->id,
            $memory->id,
        ]);

        $exercise1->errorPatterns()->sync([
            $doDoes->id,
            $wordOrder->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | MODULE 2
        |--------------------------------------------------------------------------
        */

        $module2 = LearningModule::create([
            'title' => 'Daily Routines',
            'slug' => 'daily-routines',
            'description' => 'Vocabulary and reading about daily activities.',
            'level' => 'A1',
            'status' => 'published',
            'sort_order' => 2,
        ]);

        $lesson2 = Lesson::create([
            'learning_module_id' => $module2->id,
            'title' => 'Talking about Daily Habits',
            'slug' => 'talking-about-daily-habits',
            'description' => 'Describe everyday routines.',
            'difficulty' => 'easy',
            'status' => 'published',
            'estimated_minutes' => 10,
            'order' => 1,
        ]);

        $block2 = ContentBlock::create([
            'lesson_id' => $lesson2->id,
            'type' => 'reading',
            'title' => 'John Daily Routine',
            'content' => '
                <p>John wakes up at 7 AM.</p>

                <p>He drinks coffee.</p>

                <p>He goes to work at 8 AM.</p>
            ',
            'order' => 1,
        ]);

        $exercise2 = Exercise::create([
            'lesson_id' => $lesson2->id,
            'content_block_id' => $block2->id,
            'exercise_template_id' => $fillBlank?->id,
            'title' => 'Complete the sentence',
            'type' => 'fill_in_the_blank',
            'question' => 'John _____ up at 7 AM.',
            'options' => [
                'wake',
                'wakes',
                'waking',
            ],
            'expected_answer' => [
                'wakes',
            ],
            'explanation' => 'John = He, therefore use wakes.',
            'difficulty' => 'easy',
            'skill' => 'vocabulary',
            'ai_evaluable' => true,
            'status' => 'published',
            'order' => 1,
        ]);

        $exercise2->neuroTags()->sync([
            $comprehension->id,
            $memory->id,
            $recognition->id,
        ]);

        $exercise2->errorPatterns()->sync([
            $vocabulary->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | MODULE 3
        |--------------------------------------------------------------------------
        */

        $module3 = LearningModule::create([
            'title' => 'WH Questions',
            'slug' => 'wh-questions',
            'description' => 'Learn information questions.',
            'level' => 'A1',
            'status' => 'published',
            'sort_order' => 3,
        ]);

        $lesson3 = Lesson::create([
            'learning_module_id' => $module3->id,
            'title' => 'Asking Information Questions',
            'slug' => 'asking-information-questions',
            'description' => 'Practice WHO, WHAT, WHERE and WHEN.',
            'difficulty' => 'medium',
            'status' => 'published',
            'estimated_minutes' => 12,
            'order' => 1,
        ]);

        $block3 = ContentBlock::create([
            'lesson_id' => $lesson3->id,
            'type' => 'grammar_pattern',
            'title' => 'WH Question Structure',
            'content' => '
                <h3>Structure</h3>

                <p>WH + Auxiliary + Subject + Verb</p>

                <ul>
                    <li>Where do you live?</li>
                    <li>What do you study?</li>
                    <li>When does she work?</li>
                </ul>
            ',
            'order' => 1,
        ]);

        $exercise3 = Exercise::create([
            'lesson_id' => $lesson3->id,
            'content_block_id' => $block3->id,
            'exercise_template_id' => $sentenceTransformation?->id,
            'title' => 'Transform the sentence',
            'type' => 'sentence_transformation',
            'question' => 'Transform: You live in Buenos Aires.',
            'expected_answer' => [
                'Where do you live?'
            ],
            'explanation' => 'Use WHERE because Buenos Aires is a place.',
            'difficulty' => 'medium',
            'skill' => 'grammar',
            'ai_evaluable' => true,
            'status' => 'published',
            'order' => 1,
        ]);

        $exercise3->neuroTags()->sync([
            $production->id,
            $comprehension->id,
            $transfer->id,
        ]);

        $exercise3->errorPatterns()->sync([
            $whQuestion->id,
            $wordOrder->id,
        ]);
    }
}
