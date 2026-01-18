<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Seasons', function (Blueprint $table) {
            $table->id('SeasonID');
            $table->date('StartDate');
            $table->date('EndDate')->nullable();
            $table->unsignedInteger('TotalRounds')->default(38);
            $table->unsignedInteger('CurrentRound')->default(0);
            $table->foreignId('TournamentID')->constrained('Tournaments', 'TournamentID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Seasons');
    }
};
