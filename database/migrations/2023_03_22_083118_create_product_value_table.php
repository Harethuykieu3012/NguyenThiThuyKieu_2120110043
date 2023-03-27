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
        Schema::create('nttk_product_value', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('product_id');
            $table->unsignedInteger('sort_order');
            $table->unsignedInteger('option_id');
            $table->string('value', 255);
            $table->unsignedTinyInteger('created_by');
            $table->unsignedTinyInteger('updated_by');
            $table->unsignedTinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nttk_product_value');
    }
};
