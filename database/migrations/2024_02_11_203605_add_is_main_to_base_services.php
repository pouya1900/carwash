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
        Schema::table('base_services', function (Blueprint $table) {
            $table->tinyInteger("is_main")->default(0)->after("description");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('base_services', function (Blueprint $table) {
            $table->dropColumn("is_main");
        });
    }
};
