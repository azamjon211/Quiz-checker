<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->string('correct_answer', 255)->change();
        });

        Schema::table('submission_answers', function (Blueprint $table) {
            $table->string('correct_answer', 255)->change();
            $table->string('student_answer', 255)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->string('correct_answer', 1)->change();
        });

        Schema::table('submission_answers', function (Blueprint $table) {
            $table->string('correct_answer', 1)->change();
            $table->string('student_answer', 1)->nullable()->change();
        });
    }
};
