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
        Schema::create('error_pattern_exercise', function (Blueprint $table) {

            $table->id();

            $table->foreignId('exercise_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('error_pattern_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_pattern_exercise');
    }
};
