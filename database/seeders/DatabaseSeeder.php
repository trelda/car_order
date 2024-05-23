<?php

namespace Database\Seeders;

use App\Models\Car;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Driver;
use App\Models\CarCategory;
use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Driver::factory(10)->create();
        CarCategory::factory(5)->create();
        Car::factory(10)->create();
        Position::factory(5)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user1@user1.com',
            'password' => Hash::make('user1user1')
        ]);
    }
}
