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
        Schema::create('course_subject', function (Blueprint $table) {
            $table->foreignId('course_id')
                ->references('id')
                ->on('courses')
                ->onDelete('cascade');
            $table->foreignId('subject_id')
                ->references('id')
                ->on('subjects')
                ->onDelete('cascade');
            $table->primary(['course_id', 'subject_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_subject');
    }
};
