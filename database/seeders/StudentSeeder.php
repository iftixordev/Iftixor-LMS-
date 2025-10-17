<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'student_id' => 'STD0001',
                'first_name' => 'Ali',
                'last_name' => 'Valiyev',
                'birth_date' => '2005-03-15',
                'gender' => 'male',
                'phone' => '+998901111111',
                'email' => 'ali@example.com',
                'address' => 'Toshkent sh., Chilonzor t.',
                'parent_name' => 'Vali Valiyev',
                'parent_phone' => '+998901111110',
                'parent_email' => 'vali@example.com',
                'enrollment_date' => '2024-01-15',
                'status' => 'active'
            ],
            [
                'student_id' => 'STD0002',
                'first_name' => 'Malika',
                'last_name' => 'Tosheva',
                'birth_date' => '2006-07-22',
                'gender' => 'female',
                'phone' => '+998902222222',
                'email' => 'malika@example.com',
                'address' => 'Toshkent sh., Yashnobod t.',
                'parent_name' => 'Tosh Toshev',
                'parent_phone' => '+998902222220',
                'parent_email' => 'tosh@example.com',
                'enrollment_date' => '2024-01-20',
                'status' => 'active'
            ],
            [
                'student_id' => 'STD0003',
                'first_name' => 'Sardor',
                'last_name' => 'Karimov',
                'birth_date' => '2004-11-08',
                'gender' => 'male',
                'phone' => '+998903333333',
                'email' => 'sardor@example.com',
                'address' => 'Toshkent sh., Sergeli t.',
                'parent_name' => 'Karim Karimov',
                'parent_phone' => '+998903333330',
                'parent_email' => 'karim@example.com',
                'enrollment_date' => '2024-02-01',
                'status' => 'active'
            ]
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
