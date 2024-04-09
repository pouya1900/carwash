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
            $table->string("remember_token")->after("message")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carwashes', function (Blueprint $table) {
            $table->dropColumn("remember_token");
        });
    }
};
