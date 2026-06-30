<?php

namespace App\Modules\AI\Domain\DTOs;

class ExerciseVariantResponse
{
    public function __construct(
        public readonly string $title,
        public readonly string $question,
        public readonly array $options,
        public readonly array $expectedAnswer,
        public readonly string $explanation,
        public readonly string $difficulty,
        public readonly ?string $skill = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: self::toString($data['title'] ?? ''),
            question: self::toString($data['question'] ?? $data['text'] ?? ''),
            options: self::toArray($data['options'] ?? []),
            expectedAnswer: self::toArray($data['expected_answer'] ?? []),
            explanation: self::toString($data['explanation'] ?? ''),
            difficulty: self::toString($data['difficulty'] ?? ''),
            skill: isset($data['skill'])
                ? self::toString($data['skill'])
                : self::toString($data['grammar_pattern'] ?? ''),
        );
    }

    private static function toString(mixed $value): string
    {
        if (is_array($value)) {
            return implode(' / ', $value);
        }

        return (string) $value;
    }

    private static function toArray(mixed $value): array
    {
        if (is_array($value)) {
            return array_values($value);
        }

        if ($value === null || $value === '') {
            return [];
        }

        return [$value];
    }
}
