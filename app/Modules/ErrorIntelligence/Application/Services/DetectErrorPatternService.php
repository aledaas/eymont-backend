<?php

namespace App\Modules\ErrorIntelligence\Application\Services;

use App\Domain\Content\Models\ErrorPattern;
use App\Domain\Content\Models\Exercise;

class DetectErrorPatternService
{
    public function detect(
        Exercise $exercise,
        string $answer
    ): ?ErrorPattern {
        $answer = mb_strtolower(trim($answer));

        /*
         * DO / DOES confusion:
         * Do she...
         * Do he...
         * Do it...
         */
        if (
            str_contains($answer, 'do she')
            || str_contains($answer, 'do he')
            || str_contains($answer, 'do it')
        ) {
            return ErrorPattern::query()
                ->where('slug', 'do_does_confusion')
                ->first();
        }

        /*
         * Omit auxiliary:
         * She like coffee?
         */
        if (
            ! str_contains($answer, 'do ')
            && ! str_contains($answer, 'does ')
        ) {
            return ErrorPattern::query()
                ->where('slug', 'omit_auxiliary')
                ->first();
        }

        /*
         * Wrong WH order:
         * Where you live?
         */
        if (
            str_contains($answer, 'where you live')
            || str_contains($answer, 'what she do')
        ) {
            return ErrorPattern::query()
                ->where('slug', 'wrong_word_order')
                ->first();
        }

        return null;
    }
}
