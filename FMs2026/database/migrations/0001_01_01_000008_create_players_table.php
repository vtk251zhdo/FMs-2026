<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Players', function (Blueprint $table) {
            $table->id('PlayerID');
            $table->string('FullName', 100);
            $table->unsignedInteger('Age');
            $table->string('Position', 15);
            $table->string('Nationality', 50)->default('Україна');
            $table->unsignedInteger('Number');
            $table->decimal('Rating', 4, 2);
            $table->decimal('Value', 15, 2);
            $table->unsignedInteger('Appearances')->default(0);
            $table->unsignedInteger('Goals')->default(0);
            $table->unsignedInteger('Assists')->default(0);
            $table->foreignId('ClubID')->constrained('Clubs', 'ClubID')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Players');
    }
};
