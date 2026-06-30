<?php

namespace App\Modules\AI\Domain\Contracts;

interface AITextGeneratorInterface
{
    public function generate(string $prompt): string;
}
