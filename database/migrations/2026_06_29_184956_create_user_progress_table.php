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
        Schema::create('user_progress', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('lesson_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('status')
                ->default('not_started');

            $table->unsignedInteger('score')
                ->default(0);

            $table->unsignedInteger('attempts')
                ->default(0);

            $table->timestamp('completed_at')
                ->nullable();

            $table->timestamp('last_activity_at')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'user_id',
                'lesson_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};
