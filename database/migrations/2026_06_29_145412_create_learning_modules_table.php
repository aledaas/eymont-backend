<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_modules', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            $table->string('level')->nullable();
            $table->string('status')->default('draft');

            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_modules');
    }
};
