<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticketable_type')->comment('تعیین مدل ارسال کننده تیکت (کاربر ، کارواش)');
            $table->unsignedInteger('ticketable_id')->comment('تعیین رکورد');
            $table->string('title')->comment('عنوان تیکت پشتیبانی');
            $table->enum('status', ['pending', 'answered', 'closed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
