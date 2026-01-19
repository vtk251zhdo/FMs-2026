<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('GameUsers', function (Blueprint $table) {
            $table->string('role', 20)->default('player')->after('Email');
            // 'player' - звичайний гравець
            // 'admin' - адміністратор
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('GameUsers', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
