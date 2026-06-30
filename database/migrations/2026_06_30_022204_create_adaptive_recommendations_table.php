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
        Schema::create('adaptive_recommendations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('error_pattern_id')->nullable()->constrained('error_patterns')->nullOnDelete();
            $table->foreignId('recommended_lesson_id')->nullable()->constrained('lessons')->nullOnDelete();

            $table->string('reason')->nullable();
            $table->string('status')->default('shown');

            $table->timestamp('shown_at')->nullable();
            $table->timestamp('clicked_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adaptive_recommendations');
    }
};
