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
        Schema::create('nttk_topic', function (Blueprint $table) {
            $table->id();
            $table->string('title', 1000);
            $table->string('slug', 1000);
            $table->unsignedTinyInteger('parent_id');
            $table->unsignedTinyInteger('sort_order');
            $table->string('image', 1000);
            $table->string('metakey', 255);
            $table->string('metadesc', 255);
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
        Schema::dropIfExists('nttk_topic');
    }
};
