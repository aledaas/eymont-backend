<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_interactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('provider')->nullable();
            $table->string('model')->nullable();
            $table->string('use_case');

            $table->json('input')->nullable();
            $table->json('output')->nullable();

            $table->string('status')->default('success');
            $table->text('error_message')->nullable();

            $table->unsignedInteger('tokens_input')->nullable();
            $table->unsignedInteger('tokens_output')->nullable();
            $table->unsignedInteger('latency_ms')->nullable();

            $table->timestamps();

            $table->index(['use_case', 'status']);
            $table->index(['provider', 'model']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_interactions');
    }
};
