<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Clubs', function (Blueprint $table) {
            $table->id('ClubID');
            $table->string('ClubName', 100)->unique();
            $table->string('Country', 50)->default('Україна');
            $table->string('City', 50);
            $table->decimal('Budget', 15, 2)->default(50000000);
            $table->string('Stadium', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Clubs');
    }
};
