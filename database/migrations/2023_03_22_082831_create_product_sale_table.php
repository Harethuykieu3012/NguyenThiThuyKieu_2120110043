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
        Schema::create('nttk_product_sale', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id');
            $table->float('price_sale');
            $table->dateTime('date_begin');
            $table->dateTime('date_end');
            $table->unsignedTinyInteger('created_by');
            $table->unsignedTinyInteger('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nttk_product_sale');
    }
};
