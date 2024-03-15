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
        Schema::table('reservations', function (Blueprint $table) {
            $table->unsignedInteger("payment_id")->after("type_id")->nullable();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn("reservation_id");
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn("payment_id");
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedInteger("reservation_id");
        });

    }
};
