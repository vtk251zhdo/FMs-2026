<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Coaches', function (Blueprint $table) {
            $table->id('CoachID');
            $table->string('FullName', 100);
            $table->string('Role', 50);
            $table->unsignedInteger('Age');
            $table->foreignId('ClubID')->constrained('Clubs', 'ClubID')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Coaches');
    }
};
