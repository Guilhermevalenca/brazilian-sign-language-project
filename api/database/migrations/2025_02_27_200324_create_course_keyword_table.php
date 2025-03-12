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
        Schema::create('course_keyword', function (Blueprint $table) {
            $table->foreignId('course_id')
                ->references('id')
                ->on('courses')
                ->onDelete('cascade');
            $table->foreignId('keyword_id')
                ->references('id')
                ->on('keywords')
                ->onDelete('cascade');
            $table->primary(['course_id', 'keyword_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_keyword');
    }
};
