<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('GameUsers', function (Blueprint $table) {
            $table->id('UserID');
            $table->string('Username', 50)->unique();
            $table->string('PasswordHash', 255);
            $table->string('Email', 100)->unique();
            $table->date('RegisterDate')->default(now());
            $table->dateTime('LastLogin')->default(now());
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('GameUsers');
    }
};
