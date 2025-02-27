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
        Schema::create('areas_on_specialties', function (Blueprint $table) {
            $table->foreignId('know_area_id')
                ->references('id')
                ->on('know_areas')
                ->onDelete('cascade');
            $table->foreignId('specialty_id')
                ->references('id')
                ->on('specialties')
                ->onDelete('cascade');
            $table->primary(['know_area_id', 'specialty_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas_on_specialties');
    }
};
