<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('MatchStats', function (Blueprint $table) {
            $table->id('StatID');
            $table->unsignedInteger('Goals')->default(0);
            $table->unsignedInteger('Assists')->default(0);
            $table->unsignedInteger('YellowCards')->default(0);
            $table->unsignedInteger('RedCards')->default(0);
            $table->decimal('Rating', 3, 1);
            $table->foreignId('MatchID')->constrained('Matches', 'MatchID')->onDelete('cascade');
            $table->foreignId('PlayerID')->constrained('Players', 'PlayerID')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('MatchStats');
    }
};
