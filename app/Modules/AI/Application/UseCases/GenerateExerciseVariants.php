<?php

namespace App\Modules\AI\Application\UseCases;

use App\Modules\AI\Domain\Contracts\AITextGeneratorInterface;
use App\Modules\AI\Domain\DTOs\ExerciseVariantRequest;
use App\Modules\AI\Domain\DTOs\ExerciseVariantResponse;
use App\Modules\AI\Domain\Models\AIInteraction;
use Illuminate\Support\Facades\Auth;
use RuntimeException;
use Throwable;

class GenerateExerciseVariants
{
    public function __construct(
        private readonly AITextGeneratorInterface $aiTextGenerator
    ) {
    }

    /**
     * @return array<int, ExerciseVariantResponse>
     */
    public function execute(ExerciseVariantRequest $request): array
    {
        $startedAt = microtime(true);

        $input = [
            'instruction' => $request->instruction,
            'exercise_text' => $request->exerciseText,
            'grammar_pattern' => $request->grammarPattern,
            'difficulty' => $request->difficulty,
            'neuro_tags' => $request->neuroTags,
            'variants_count' => $request->variantsCount,
        ];

        try {
            $prompt = $this->buildPrompt($request);

            $rawResponse = $this->aiTextGenerator->generate($prompt);

            $decoded = json_decode($rawResponse, true);

            if (! is_array($decoded)) {
                throw new RuntimeException('AI response is not valid JSON.');
            }

            $variants = array_map(
                fn (array $item) => ExerciseVariantResponse::fromArray($item),
                $decoded
            );

            AIInteraction::create([
                'user_id' => Auth::id(),
                'provider' => config('eymont-ai.provider'),
                'model' => config('eymont-ai.model'),
                'use_case' => 'exercise_variant_generator',
                'input' => $input,
                'output' => $decoded,
                'status' => 'success',
                'latency_ms' => (int) ((microtime(true) - $startedAt) * 1000),
            ]);

            return $variants;
        } catch (Throwable $e) {
            AIInteraction::create([
                'user_id' => Auth::id(),
                'provider' => config('eymont-ai.provider'),
                'model' => config('eymont-ai.model'),
                'use_case' => 'exercise_variant_generator',
                'input' => $input,
                'output' => null,
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'latency_ms' => (int) ((microtime(true) - $startedAt) * 1000),
            ]);

            throw $e;
        }
    }

    private function buildPrompt(ExerciseVariantRequest $request): string
    {
        $neuroTags = implode(', ', $request->neuroTags);

        return <<<PROMPT
You are an expert English learning assistant for Eymont.

Generate {$request->variantsCount} candidate exercise variants based on the original exercise.

Original exercise:
{$request->exerciseText}

Instruction:
{$request->instruction}

Skill or grammar pattern:
{$request->grammarPattern}

Difficulty:
{$request->difficulty}

Neuro tags:
{$neuroTags}

Return only a valid JSON array.

Each item must be compatible with this Laravel Exercise structure:

{
 {
  "title": "Short pedagogical title for the exercise",
  "question": "Question text shown to the student",
  "options": ["Option A", "Option B", "Option C"],
  "expected_answer": ["Correct answer"],
  "explanation": "Short explanation for the correct answer",
  "difficulty": "{$request->difficulty}",
  "skill": "{$request->grammarPattern}"
}
}

Rules:
- title must be short, pedagogical and useful for teachers.
- Do not modify the original exercise.
- Generate new candidate exercises only.
- Keep the same pedagogical objective.
- Keep the same difficulty.
- Keep the same exercise type when possible.
- Use simple vocabulary for beginner levels.
- expected_answer must always be an array.
- options must always be an array.
- Return JSON only. No markdown. No comments.

PROMPT;
    }
}
