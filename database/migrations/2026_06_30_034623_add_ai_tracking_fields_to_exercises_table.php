<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->boolean('generated_by_ai')
                ->default(false)
                ->after('ai_evaluable');

            $table->foreignId('parent_exercise_id')
                ->nullable()
                ->after('generated_by_ai')
                ->constrained('exercises')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->dropConstrainedForeignId('parent_exercise_id');
            $table->dropColumn('generated_by_ai');
        });
    }
};
