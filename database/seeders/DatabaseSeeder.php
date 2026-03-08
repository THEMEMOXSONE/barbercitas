<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BarberSetting;
use App\Models\BusinessHour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Barber',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        BarberSetting::create([
            'name' => 'The Best Barber Shop',
            'bio' => 'A great place to get your haircut. We bring you the best styles and classic cuts.',
            'experience_years' => 5,
            'base_price' => 15.00,
        ]);

        for ($i = 0; $i < 7; $i++) {
            BusinessHour::create([
                'day_of_week' => $i,
                'open_time' => '09:00:00',
                'close_time' => '18:00:00',
                'is_closed' => $i == 0 ? true : false, // Closed on Sundays
            ]);
        }
    }
}
