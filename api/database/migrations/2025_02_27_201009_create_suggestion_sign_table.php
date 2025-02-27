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
        Schema::create('suggestion_sign', function (Blueprint $table) {
            $table->foreignId('suggestion_id')
                ->references('id')
                ->on('suggestions')
                ->onDelete('cascade');
            $table->foreignId('sign_id')
                ->references('id')
                ->on('signs')
                ->onDelete('cascade');
            $table->primary(['suggestion_id', 'sign_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestion_sign');
    }
};
