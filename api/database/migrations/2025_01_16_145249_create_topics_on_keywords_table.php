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
        Schema::create('topics_on_keywords', function (Blueprint $table) {
            $table->foreignId('topic_id')
                ->references('id')
                ->on('topics')
                ->onDelete('cascade');
            $table->foreignId('keyword_id')
                ->references('id')
                ->on('keywords')
                ->onDelete('cascade');
            $table->primary(['topic_id', 'keyword_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics_on_keywords');
    }
};
