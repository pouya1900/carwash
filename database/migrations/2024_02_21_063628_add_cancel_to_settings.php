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
        Schema::table('settings', function (Blueprint $table) {
            $table->unsignedSmallInteger("free_cancellation_time")->after("gift_value")->comment("حداقل زمان کنسلی بدون ضرر به ساعت");
            $table->unsignedSmallInteger("cancellation_time")->after("free_cancellation_time")->comment("حداقل زمان کنسلی ممکن به ساعت");
            $table->unsignedSmallInteger("cancellation_charge")->after("cancellation_time")->comment("درصد هزینه کنسلی");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn("free_cancellation_time");
            $table->dropColumn("cancellation_time");
            $table->dropColumn("cancellation_charge");
        });
    }
};
