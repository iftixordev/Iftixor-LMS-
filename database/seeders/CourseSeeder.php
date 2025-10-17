<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'name' => 'Ingliz tili (Boshlang\'ich)',
                'description' => 'Ingliz tilini noldan o\'rganish kursi',
                'duration_months' => 6,
                'price' => 300000,
                'min_students' => 5,
                'max_students' => 15,
                'status' => 'active',
                'curriculum' => 'Alphabet, Basic Grammar, Simple Conversations'
            ],
            [
                'name' => 'Matematika (5-6 sinf)',
                'description' => '5-6 sinf o\'quvchilari uchun matematika kursi',
                'duration_months' => 9,
                'price' => 250000,
                'min_students' => 8,
                'max_students' => 20,
                'status' => 'active',
                'curriculum' => 'Arifmetika, Geometriya asoslari, Algebraga kirish'
            ],
            [
                'name' => 'Kompyuter savodxonligi',
                'description' => 'Kompyuter va internet asoslari',
                'duration_months' => 3,
                'price' => 200000,
                'min_students' => 6,
                'max_students' => 12,
                'status' => 'active',
                'curriculum' => 'Windows, MS Office, Internet'
            ],
            [
                'name' => 'IELTS tayyorgarlik',
                'description' => 'IELTS imtihoniga tayyorgarlik kursi',
                'duration_months' => 4,
                'price' => 500000,
                'min_students' => 4,
                'max_students' => 10,
                'status' => 'active',
                'curriculum' => 'Reading, Writing, Listening, Speaking'
            ]
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
