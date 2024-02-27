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
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn("carwash_id");
            $table->unsignedInteger("depositable_id")->after("bank_id");
            $table->string("depositable_type")->after("depositable_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn("depositable_id");
            $table->dropColumn("depositable_type");
            $table->unsignedInteger("carwash_id");
        });
    }
};
