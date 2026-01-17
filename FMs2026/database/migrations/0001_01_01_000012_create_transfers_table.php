<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Transfers', function (Blueprint $table) {
            $table->id('TransferID');
            $table->date('TransferDate')->default(now());
            $table->decimal('TransferFee', 15, 2);
            $table->foreignId('PlayerID')->constrained('Players', 'PlayerID')->onDelete('cascade');
            $table->foreignId('FromClubID')->constrained('Clubs', 'ClubID');
            $table->foreignId('ToClubID')->constrained('Clubs', 'ClubID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Transfers');
    }
};
