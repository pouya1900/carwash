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
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id");
            $table->unsignedSmallInteger("total")->comment("تعداد کل سفارش مورد نیاز");
            $table->unsignedSmallInteger("number")->comment("تعداد انجام شده");
            $table->unsignedInteger("value")->comment("ارزش هدیه");
            $table->enum("status", ["pending", "completed", "received"])->default("pending");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gifts');
    }
};
