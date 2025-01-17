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
        Schema::create('specialties_on_topics', function (Blueprint $table) {
            $table->foreignId('specialty_id')
                ->references('id')
                ->on('specialties')
                ->onDelete('cascade');
            $table->foreignId('topic_id')
                ->references('id')
                ->on('topics')
                ->onDelete('cascade');
            $table->primary(['specialty_id', 'topic_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialties_on_topics');
    }
};
