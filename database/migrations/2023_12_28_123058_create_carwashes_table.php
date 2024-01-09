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
        Schema::create('carwashes', function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable();
            $table->string("lat")->nullable();
            $table->string("long")->nullable();
            $table->string("address")->nullable();
            $table->unsignedInteger("city_id")->nullable();
            $table->unsignedInteger("state_id")->nullable();
            $table->string('mobile')->unique();
            $table->string('uuid')->nullable();
            $table->string('platform')->nullable();
            $table->string('model')->nullable();
            $table->string('os')->nullable();
            $table->unsignedInteger("product_count")->default(0);
            $table->enum("payment", ["cash", "online"])->default("online");
            $table->enum("status", ["pending", "accepted"])->default("pending");
            $table->enum("type", ["manual", "automatic", "semi_automatic"])->default("manual");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carwashes');
    }
};
