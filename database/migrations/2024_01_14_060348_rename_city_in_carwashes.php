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
        Schema::table('carwashes', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->unsignedInteger("city_id")->after("address");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carwashes', function (Blueprint $table) {
            $table->string('city');
            $table->dropColumn("city_id");
        });
    }
};
