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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('عنوان سایت');
            $table->string('email')->nullable()->comment('ایمیل شرکت');
            $table->string('address')->nullable()->comment('ادرس شرکت');
            $table->string('phone')->nullable()->comment('تلفن شرکت');
            $table->string('service_commission')->nullable()->comment('کارمزد خدمات');
            $table->string('product_count')->nullable()->comment('نعداد محصولات رایگان');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
