<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'first_name' => 'Aziza',
                'last_name' => 'Karimova',
                'email' => 'aziza@markaz.uz',
                'phone' => '+998901234567',
                'address' => 'Toshkent sh., Yunusobod t.',
                'specializations' => 'Ingliz tili, IELTS',
                'education' => 'Toshkent Davlat Pedagogika Universiteti',
                'hourly_rate' => 50000,
                'hire_date' => '2023-01-15',
                'status' => 'active'
            ],
            [
                'first_name' => 'Bobur',
                'last_name' => 'Rahimov',
                'email' => 'bobur@markaz.uz',
                'phone' => '+998901234568',
                'address' => 'Toshkent sh., Mirzo Ulug\'bek t.',
                'specializations' => 'Matematika, Fizika',
                'education' => 'Toshkent Davlat Universiteti',
                'hourly_rate' => 45000,
                'hire_date' => '2023-02-01',
                'status' => 'active'
            ],
            [
                'first_name' => 'Dilnoza',
                'last_name' => 'Tosheva',
                'email' => 'dilnoza@markaz.uz',
                'phone' => '+998901234569',
                'address' => 'Toshkent sh., Shayxontohur t.',
                'specializations' => 'Kompyuter savodxonligi, IT',
                'education' => 'TATU',
                'hourly_rate' => 60000,
                'hire_date' => '2023-03-10',
                'status' => 'active'
            ]
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }
    }
}
