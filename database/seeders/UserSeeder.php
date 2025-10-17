<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Administrator',
            'phone' => '+998901111111',
            'password' => Hash::make('password'),
            'birth_date' => '1990-01-01',
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Teacher user
        User::create([
            'first_name' => 'Aziz',
            'last_name' => 'O\'qituvchi',
            'phone' => '+998902222222',
            'password' => Hash::make('password'),
            'birth_date' => '1985-05-15',
            'role' => 'teacher',
            'teacher_id' => 1,
            'is_active' => true,
        ]);

        // Student user
        User::create([
            'first_name' => 'Ali',
            'last_name' => 'O\'quvchi',
            'phone' => '+998903333333',
            'password' => Hash::make('password'),
            'birth_date' => '2000-03-20',
            'role' => 'student',
            'student_id' => 1,
            'is_active' => true,
        ]);

        // Cashier user
        User::create([
            'first_name' => 'Nargiza',
            'last_name' => 'Kassir',
            'phone' => '+998904444444',
            'password' => Hash::make('password'),
            'birth_date' => '1992-07-10',
            'role' => 'cashier',
            'is_active' => true,
        ]);

        // Receptionist user
        User::create([
            'first_name' => 'Dilnoza',
            'last_name' => 'Qabulxona',
            'phone' => '+998905555555',
            'password' => Hash::make('password'),
            'birth_date' => '1995-12-05',
            'role' => 'receptionist',
            'is_active' => true,
        ]);
    }
}
