<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('UserClubs', function (Blueprint $table) {
            $table->id('UserClubID');
            $table->foreignId('UserID')->constrained('GameUsers', 'UserID')->onDelete('cascade');
            $table->foreignId('ClubID')->constrained('Clubs', 'ClubID');
            $table->foreignId('SeasonID')->constrained('Seasons', 'SeasonID')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('UserClubs');
    }
};
