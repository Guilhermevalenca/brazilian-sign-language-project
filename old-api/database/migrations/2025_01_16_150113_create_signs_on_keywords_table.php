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
        Schema::create('signs_on_keywords', function (Blueprint $table) {
            $table->foreignId('sign_id')
                ->references('id')
                ->on('signs')
                ->onDelete('cascade');
            $table->foreignId('keyword_id')
                ->references('id')
                ->on('keywords')
                ->onDelete('cascade');
            $table->primary(['sign_id', 'keyword_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signs_on_keywords');
    }
};
