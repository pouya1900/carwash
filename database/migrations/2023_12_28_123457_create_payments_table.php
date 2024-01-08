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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('reservation_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('wallet');
            $table->unsignedInteger('online');
            $table->unsignedInteger('cash');
            $table->unsignedInteger('total');
            $table->unsignedInteger('coupon_value');
            $table->string("coupon_code");
            $table->enum('status', ['pending', 'canceled', 'failed', 'approved', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
