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
            $table->dateTime('MatchDate')->nullable();
            $table->string('Stadium', 100)->nullable();
            $table->unsignedInteger('ScoreHome')->default(0);
            $table->unsignedInteger('ScoreAway')->default(0);
            $table->string('Status')->default('Scheduled');
            $table->string('Result')->default('Pending');
            $table->unsignedInteger('Attendance')->nullable();
            $table->integer('Round')->default(1);
            $table->foreignId('SeasonID')->constrained('Seasons', 'SeasonID')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Matches');
    }
};
