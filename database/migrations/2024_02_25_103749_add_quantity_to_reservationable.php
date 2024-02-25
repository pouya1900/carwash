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
        Schema::table('reservationable', function (Blueprint $table) {
            $table->smallInteger("quantity")->default(1)->after("reservationable_type");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservationable', function (Blueprint $table) {
            $table->dropColumn("quantity");
        });
    }
};
