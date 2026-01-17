<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Matches', function (Blueprint $table) {
            $table->id('MatchID');
            $table->foreignId('HomeClubID')->constrained('Clubs', 'ClubID');
            $table->foreignId('AwayClubID')->constrained('Clubs', 'ClubID');
            $table->date('MatchDate');
            $table->string('Stadium', 100);
            $table->unsignedInteger('ScoreHome')->default(0);
            $table->unsignedInteger('ScoreAway')->default(0);
            $table->foreignId('SeasonID')->constrained('Seasons', 'SeasonID')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Matches');
    }
};
