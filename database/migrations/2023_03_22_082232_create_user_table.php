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
        Schema::create('nttk_user', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('Họ');
            $table->string('username', 255);
            $table->string('password', 255);
            $table->string('email', 255);
            $table->string('phone', 255);
            $table->string('address', 255);
            $table->string('gender', 255);
            $table->string('roles', 255);
            $table->string('image', 255);
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
        Schema::dropIfExists('nttk_user');
    }
};
