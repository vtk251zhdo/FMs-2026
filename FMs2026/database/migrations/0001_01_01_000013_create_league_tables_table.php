<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('LeagueTable', function (Blueprint $table) {
            $table->id('TableID');
            $table->foreignId('SeasonID')->constrained('Seasons', 'SeasonID')->onDelete('cascade');
            $table->foreignId('ClubID')->constrained('Clubs', 'ClubID')->onDelete('cascade');
            $table->unsignedInteger('Position')->default(1);
            $table->unsignedInteger('Played')->default(0);
            $table->unsignedInteger('Wins')->default(0);
            $table->unsignedInteger('Draws')->default(0);
            $table->unsignedInteger('Losses')->default(0);
            $table->unsignedInteger('GoalsFor')->default(0);
            $table->unsignedInteger('GoalsAgainst')->default(0);
            $table->integer('GoalDifference')->default(0);
            $table->unsignedInteger('Points')->default(0);
            $table->unique(['SeasonID', 'ClubID']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('LeagueTable');
    }
};
