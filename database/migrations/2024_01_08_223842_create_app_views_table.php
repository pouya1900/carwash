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
        Schema::create('app_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("type_id");
            $table->string("title")->nullable();
            $table->string("title_color")->nullable();
            $table->string("description")->nullable();
            $table->string("description_color")->nullable();
            $table->string("background_color")->nullable();
            $table->string("action")->nullable();
            $table->string("action_color")->nullable();
            $table->integer("order")->nullable();
            $table->tinyInteger("need_space")->default(0);
            $table->enum("status", ["active", "inactive"])->default("active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_views');
    }
};
