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
        Schema::create('movesets', function (Blueprint $table) {
            $table->string('right');
            $table->string('left');
            $table->foreignId('sign_id')
                ->references('id')
                ->on('signs');
            $table->primary('sign_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movesets');
    }
};
