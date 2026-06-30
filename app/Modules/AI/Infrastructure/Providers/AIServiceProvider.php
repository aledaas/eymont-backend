<?php

namespace App\Modules\AI\Infrastructure\Providers;

use App\Modules\AI\Domain\Contracts\AITextGeneratorInterface;
use Illuminate\Support\ServiceProvider;

class AIServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AITextGeneratorInterface::class,
            PrismAITextGenerator::class
        );
    }
}
