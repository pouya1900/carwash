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
        Schema::create('lock_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('carwash_id')->comment('تعیین کارواش');
            $table->unsignedInteger('product_id')->comment('تعیین محصول');
            $table->string('title')->comment('عنوان');
            $table->text('description')->comment('توضیحات');
            $table->unsignedInteger('price')->comment('قیمت');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lock_products');
    }
};
