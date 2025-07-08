<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_monitorings', function (Blueprint $table) {
            $table->id();
            $table->string('part_of_page');
            $table->timestamp('timestamp');
            $table->string('token')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('reference_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_monitorings');
    }
};
