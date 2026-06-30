<?php

namespace Database\Seeders;

use App\Domain\Content\Models\ErrorPattern;
use Illuminate\Database\Seeder;

class ErrorPatternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patterns = [

            [
                'name' => 'Omit Auxiliary',
                'slug' => 'omit_auxiliary',
                'category' => 'grammar',
                'description' => 'The student omits the auxiliary verb when building questions.',
                'student_message' => 'Detectamos que frecuentemente omites el auxiliar en preguntas. Te recomendamos repasar cómo formar preguntas utilizando DO y DOES.',
                'teacher_hint' => 'El alumno intenta construir preguntas utilizando el orden de una oración afirmativa. Reforzar la estructura: auxiliar + sujeto + verbo.',
                'severity' => 'high',
            ],

            [
                'name' => 'DO / DOES Confusion',
                'slug' => 'do_does_confusion',
                'category' => 'grammar',
                'description' => 'The student confuses DO and DOES in Present Simple questions.',
                'student_message' => 'Detectamos confusión entre DO y DOES. Practicá cuándo utilizar DO con I/you/we/they y DOES con he/she/it.',
                'teacher_hint' => 'El alumno reconoce la necesidad del auxiliar, pero no logra seleccionar correctamente la forma según la persona gramatical.',
                'severity' => 'high',
            ],

            [
                'name' => 'Wrong Word Order',
                'slug' => 'wrong_word_order',
                'category' => 'word_order',
                'description' => 'The student uses an incorrect word order in questions.',
                'student_message' => 'Detectamos dificultades con el orden de las palabras en preguntas. Repasá la estructura: auxiliar + sujeto + verbo.',
                'teacher_hint' => 'El alumno altera el orden esperado en la construcción de preguntas.',
                'severity' => 'medium',
            ],

            [
                'name' => 'WH Question Confusion',
                'slug' => 'wh_question_confusion',
                'category' => 'grammar',
                'description' => 'The student confuses WH question words.',
                'student_message' => 'Detectamos dificultades utilizando preguntas WH. Practicá cuándo utilizar WHAT, WHERE, WHEN, WHO y WHY.',
                'teacher_hint' => 'Reforzar el significado y uso contextual de las palabras interrogativas.',
                'severity' => 'medium',
            ],

            [
                'name' => 'Vocabulary Error',
                'slug' => 'vocabulary_error',
                'category' => 'vocabulary',
                'description' => 'The student selected or produced incorrect vocabulary.',
                'student_message' => 'Detectamos errores frecuentes de vocabulario. Te recomendamos revisar las palabras nuevas de esta unidad.',
                'teacher_hint' => 'Puede existir desconocimiento léxico o interferencia con la lengua materna.',
                'severity' => 'low',
            ],

            [
                'name' => 'Comprehension Error',
                'slug' => 'comprehension_error',
                'category' => 'comprehension',
                'description' => 'The student shows difficulties understanding the content.',
                'student_message' => 'Detectamos dificultades de comprensión. Te recomendamos releer el contenido y volver a intentarlo.',
                'teacher_hint' => 'Puede requerir más exposición al contenido o reducción de la carga cognitiva.',
                'severity' => 'high',
            ],

        ];

        foreach ($patterns as $pattern) {

            ErrorPattern::updateOrCreate(

                ['slug' => $pattern['slug']],

                [
                    'name' => $pattern['name'],
                    'category' => $pattern['category'],
                    'description' => $pattern['description'],
                    'student_message' => $pattern['student_message'],
                    'teacher_hint' => $pattern['teacher_hint'],
                    'severity' => $pattern['severity'],
                    'is_active' => true,
                ]

            );
        }
    }
}
