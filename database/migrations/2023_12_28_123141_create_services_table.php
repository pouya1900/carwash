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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('carwash_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('items')->nullable();
            $table->tinyInteger('time')->default(1)->comment('مدت زمان تقریبی انجام خدمت به ساعت');
            $table->tinyInteger('status')->default(1)->comment('وضعیت فعال بودن سرویس');
            $table->unsignedInteger('price');
            $table->unsignedInteger('discount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
