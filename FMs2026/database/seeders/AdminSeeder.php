<?php

namespace Database\Seeders;

use App\Models\GameUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Перевіряємо чи адмін вже існує
        $existingAdmin = GameUser::where('role', 'admin')->first();

        if (!$existingAdmin) {
            GameUser::create([
                'Username' => 'admin',
                'Email' => 'admin@fms2026.local',
                'PasswordHash' => Hash::make('admin123'), // Пароль для тестування
                'RegisterDate' => now()->toDateString(),
                'LastLogin' => now(),
                'role' => 'admin',
            ]);

            echo "✅ Адміністратор створений! \n";
            echo "   Логін: admin \n";
            echo "   Пароль: admin123 \n";
        } else {
            echo "⚠️ Адміністратор уже існує! \n";
        }
    }
}
