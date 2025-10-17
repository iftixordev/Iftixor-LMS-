<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Group;

class BulkController extends Controller
{
    public function export(Request $request)
    {
        $ids = $request->ids;
        $type = $request->type;
        
        $data = match($type) {
            'students' => Student::whereIn('id', $ids)->get(),
            'teachers' => Teacher::whereIn('id', $ids)->get(),
            'courses' => Course::whereIn('id', $ids)->get(),
            'groups' => Group::whereIn('id', $ids)->get(),
            default => collect()
        };

        $filename = $type . '_export_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data, $type) {
            $file = fopen('php://output', 'w');
            
            // Headers
            $headers = match($type) {
                'students' => ['ID', 'Ism', 'Telefon', 'Email', 'Holat'],
                'teachers' => ['ID', 'Ism', 'Telefon', 'Email', 'Mutaxassislik'],
                'courses' => ['ID', 'Nomi', 'Narx', 'Davomiyligi'],
                'groups' => ['ID', 'Nomi', 'Kurs', 'O\'qituvchi'],
                default => ['ID', 'Ma\'lumot']
            };
            
            fputcsv($file, $headers);
            
            foreach ($data as $item) {
                $row = match($type) {
                    'students' => [$item->id, $item->full_name, $item->phone, $item->email, $item->status],
                    'teachers' => [$item->id, $item->full_name, $item->phone, $item->email, $item->specialization],
                    'courses' => [$item->id, $item->name, $item->price, $item->duration_months],
                    'groups' => [$item->id, $item->name, $item->course->name ?? '', $item->teacher->full_name ?? ''],
                    default => [$item->id, $item->name ?? $item->title ?? 'N/A']
                };
                fputcsv($file, $row);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function delete(Request $request)
    {
        $ids = $request->ids;
        $type = $request->type;
        
        $count = match($type) {
            'students' => Student::whereIn('id', $ids)->delete(),
            'teachers' => Teacher::whereIn('id', $ids)->delete(),
            'courses' => Course::whereIn('id', $ids)->delete(),
            'groups' => Group::whereIn('id', $ids)->delete(),
            default => 0
        };

        return response()->json([
            'success' => true,
            'message' => "$count ta element o'chirildi"
        ]);
    }
}