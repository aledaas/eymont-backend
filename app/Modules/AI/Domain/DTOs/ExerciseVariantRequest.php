<?php

namespace App\Modules\AI\Domain\DTOs;

class ExerciseVariantRequest
{
    public function __construct(
        public readonly string $instruction,
        public readonly string $exerciseText,
        public readonly ?string $grammarPattern = null,
        public readonly ?string $difficulty = null,
        public readonly array $neuroTags = [],
        public readonly int $variantsCount = 3,
    ) {
    }
}
