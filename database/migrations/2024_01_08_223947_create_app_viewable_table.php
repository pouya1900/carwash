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
        Schema::create('app_viewable', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("view_id");
            $table->unsignedInteger("viewable_id");
            $table->string("viewable_type");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_viewable');
    }
};
