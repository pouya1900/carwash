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
        Schema::create('reservationable', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('reservation_id');
            $table->unsignedInteger('reservationable_id');
            $table->unsignedInteger('reservationable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservationable');
    }
};
