<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Tournaments', function (Blueprint $table) {
            $table->id('TournamentID');
            $table->string('TournamentName', 100)->unique();
            $table->string('Level', 20);
            $table->string('Country', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Tournaments');
    }
};
