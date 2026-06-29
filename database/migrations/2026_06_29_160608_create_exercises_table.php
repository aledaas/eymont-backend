<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lesson_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('content_block_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('exercise_template_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title')->nullable();

            $table->string('type');

            $table->longText('question');

            $table->json('options')->nullable();

            $table->json('expected_answer')->nullable();

            $table->longText('explanation')->nullable();

            $table->string('difficulty')
                ->default('easy');

            $table->string('skill')
                ->nullable();

            $table->json('evaluation_criteria')
                ->nullable();

            $table->boolean('ai_evaluable')
                ->default(false);

            $table->enum('status', [
                'draft',
                'published',
                'archived'
            ])->default('draft');

            $table->unsignedInteger('order')
                ->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
