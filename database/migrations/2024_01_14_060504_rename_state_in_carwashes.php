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
            $table->dropColumn('state');
            $table->unsignedInteger("state_id")->after("city_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carwashes', function (Blueprint $table) {
            $table->string('state');
            $table->dropColumn("state_id");
        });
    }
};
