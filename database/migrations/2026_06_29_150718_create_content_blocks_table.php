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
        Schema::create('content_blocks', function (Blueprint $table) {

            $table->id();

            $table->foreignId('lesson_id')
                ->constrained('lessons')
                ->cascadeOnDelete();

            $table->string('type');

            $table->string('title')->nullable();

            $table->json('content')->nullable();

            $table->unsignedInteger('order')
                ->default(1);

            $table->string('difficulty')
                ->default('easy');

            $table->json('neuro_tags')
                ->nullable();

            $table->json('metadata')
                ->nullable();

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->index('type');
            $table->index('difficulty');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};
