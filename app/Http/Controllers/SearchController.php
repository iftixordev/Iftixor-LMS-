<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Group;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        $results = [];

        if (strlen($query) >= 2) {
            // Students
            $students = Student::where('full_name', 'LIKE', "%{$query}%")
                ->orWhere('phone', 'LIKE', "%{$query}%")
                ->limit(3)->get();
            
            foreach ($students as $student) {
                $results[] = [
                    'title' => $student->full_name,
                    'subtitle' => $student->phone,
                    'url' => route('admin.students.show', $student),
                    'icon' => 'fas fa-user-graduate'
                ];
            }

            // Teachers
            $teachers = Teacher::where('full_name', 'LIKE', "%{$query}%")
                ->orWhere('phone', 'LIKE', "%{$query}%")
                ->limit(3)->get();
            
            foreach ($teachers as $teacher) {
                $results[] = [
                    'title' => $teacher->full_name,
                    'subtitle' => 'O\'qituvchi',
                    'url' => route('admin.teachers.show', $teacher),
                    'icon' => 'fas fa-chalkboard-teacher'
                ];
            }

            // Courses
            $courses = Course::where('name', 'LIKE', "%{$query}%")
                ->limit(3)->get();
            
            foreach ($courses as $course) {
                $results[] = [
                    'title' => $course->name,
                    'subtitle' => 'Kurs',
                    'url' => route('admin.courses.show', $course),
                    'icon' => 'fas fa-book'
                ];
            }
        }

        return response()->json($results);
    }
}