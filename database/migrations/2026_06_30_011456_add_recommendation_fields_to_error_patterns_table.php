<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('error_patterns', function (Blueprint $table) {
            if (! Schema::hasColumn('error_patterns', 'student_message')) {
                $table->text('student_message')->nullable()->after('description');
            }

            if (! Schema::hasColumn('error_patterns', 'teacher_hint')) {
                $table->text('teacher_hint')->nullable()->after('student_message');
            }

            if (! Schema::hasColumn('error_patterns', 'recommended_lesson_id')) {
                $table->foreignId('recommended_lesson_id')
                    ->nullable()
                    ->after('teacher_hint')
                    ->constrained('lessons')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('error_patterns', 'severity')) {
                $table->string('severity')->default('medium')->after('recommended_lesson_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('error_patterns', function (Blueprint $table) {
            if (Schema::hasColumn('error_patterns', 'recommended_lesson_id')) {
                $table->dropConstrainedForeignId('recommended_lesson_id');
            }

            foreach ([
                         'student_message',
                         'teacher_hint',
                         'severity',
                     ] as $column) {
                if (Schema::hasColumn('error_patterns', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
