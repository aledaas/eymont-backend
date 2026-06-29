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
        Schema::create('lessons', function (Blueprint $table) {

            $table->id();

            $table->foreignId('learning_module_id')
                ->constrained('learning_modules')
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->text('description')->nullable();

            $table->unsignedInteger('order')->default(1);

            $table->string('difficulty')->default('easy');

            $table->unsignedInteger('estimated_minutes')
                ->default(5);

            $table->string('status')
                ->default('draft');

            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('difficulty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
