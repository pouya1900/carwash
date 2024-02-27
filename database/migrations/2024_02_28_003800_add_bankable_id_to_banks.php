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
        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn("carwash_id");
            $table->unsignedInteger("bankable_id")->after("id");
            $table->string("bankable_type")->after("bankable_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn("bankable_id");
            $table->dropColumn("bankable_type");
            $table->unsignedInteger("carwash_id");
        });
    }
};
