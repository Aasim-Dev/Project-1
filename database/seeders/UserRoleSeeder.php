<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1'),
            'user_type' => 'Admin',
        ]);

        // Publisher 1
        $publisher1 = User::create([
            'name' => 'John Smith',
            'email' => 'johnsmith@publisher.com',
            'password' => Hash::make('Test@123'),
            'user_type' => 'Publisher',
        ]);

        // Publisher 2
        $publisher2 = User::create([
            'name' => 'Emily Johnson',
            'email' => 'emilyjohnson@publisher.com',
            'password' => Hash::make('Test@123'),
            'user_type' => 'Publisher',
        ]);

        // Publisher 3
        $publisher3 = User::create([
            'name' => 'Michael Chen',
            'email' => 'michaelchen@publisher.com',
            'password' => Hash::make('Test@123'),
            'user_type' => 'Publisher',
        ]);

        // Publisher 4
        $publisher4 = User::create([
            'name' => 'Sarah Williams',
            'email' => 'sarahwilliams@publisher.com',
            'password' => Hash::make('Test@123'),
            'user_type' => 'Publisher',
        ]);

        // Publisher 5
        $publisher5 = User::create([
            'name' => 'David Rodriguez',
            'email' => 'davidrodriguez@publisher.com',
            'password' => Hash::make('Test@123'),
            'user_type' => 'Publisher',
        ]);

        // Publisher 6
        $publisher6 = User::create([
            'name' => 'Jessica Lee',
            'email' => 'jessicalee@publisher.com',
            'password' => Hash::make('Test@123'),
            'user_type' => 'Publisher',
        ]);

        // Publisher 7
        $publisher7 = User::create([
            'name' => 'Robert Garcia',
            'email' => 'robertgarcia@publisher.com',
            'password' => Hash::make('Test@123'),
            'user_type' => 'Publisher',
        ]);

        // Publisher 8
        $publisher8 = User::create([
            'name' => 'Laura Thompson',
            'email' => 'laurathompson@publisher.com',
            'password' => Hash::make('Test@123'),
            'user_type' => 'Publisher',
        ]);

        // Publisher 9
        $publisher9 = User::create([
            'name' => 'James Wilson',
            'email' => 'jameswilson@publisher.com',
            'password' => Hash::make('Test@123'),
            'user_type' => 'Publisher',
        ]);

        // Publisher 10
        $publisher10 = User::create([
            'name' => 'Sophia Martinez',
            'email' => 'sophiamartinez@publisher.com',
            'password' => Hash::make('Test@123'),
            'user_type' => 'Publisher',
        ]);
    }
}
