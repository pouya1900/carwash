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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id");
            $table->string("type_id")->nullable();
            $table->string("model_id")->nullable();
            $table->string("color_id")->nullable();
            $table->unsignedInteger("year")->nullable();
            $table->tinyInteger("is_default")->default(0);
            $table->string('plate1')->nullable();
            $table->string('plate2')->nullable();
            $table->string('region')->nullable();
            $table->string('index')->nullable();
            $table->string('symbol')->nullable();
            $table->string('custom')->nullable();
            $table->enum("plate_type", ["standard", "motor", "free", "custom"])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
