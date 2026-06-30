<?php

namespace App\Modules\AI\Infrastructure\Providers;

use App\Modules\AI\Domain\Contracts\AITextGeneratorInterface;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Facades\Prism;

class PrismAITextGenerator implements AITextGeneratorInterface
{
    public function generate(string $prompt): string
    {
        $provider = Provider::from(
            config('eymont-ai.provider')
        );

        $response = Prism::text()
            ->using(
                provider: $provider,
                model: config('eymont-ai.model')
            )
            ->withPrompt($prompt)
            ->asText();

        return $response->text;
    }
}
