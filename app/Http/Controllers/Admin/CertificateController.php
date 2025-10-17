<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\CertificateTemplate;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;


class CertificateController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Certificate::with(['student', 'course']);
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('certificate_number', 'like', "%{$search}%")
                      ->orWhereHas('student', function($sq) use ($search) {
                          $sq->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                      });
                });
            }
            
            $certificates = $query->latest()->paginate(20);
            $students = Student::where('status', 'active')->get();
            $courses = Course::where('status', 'active')->get();
            
            return view('admin.certificates.index', compact('certificates', 'students', 'courses'));
        } catch (\Exception $e) {
            $certificates = collect()->paginate();
            $students = collect();
            $courses = collect();
            return view('admin.certificates.index', compact('certificates', 'students', 'courses'));
        }
    }

    public function create()
    {
        $students = Student::where('status', 'active')->get();
        $courses = Course::where('status', 'active')->get();
        $templates = CertificateTemplate::where('is_active', true)->get();
        return view('admin.certificates.create', compact('students', 'courses', 'templates'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_id' => 'required|exists:students,id',
                'course_id' => 'required|exists:courses,id',
                'certificate_number' => 'nullable|string|max:100',
                'grade' => 'nullable|string|max:10',
                'issued_date' => 'required|date',
                'notes' => 'nullable|string',
            ]);

            if (empty($validated['certificate_number'])) {
                $validated['certificate_number'] = $this->generateCertificateNumber();
            }

            Certificate::create($validated);
            return redirect()->route('admin.certificates.index')->with('success', 'Sertifikat muvaffaqiyatli yaratildi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, Certificate $certificate)
    {
        try {
            $validated = $request->validate([
                'student_id' => 'required|exists:students,id',
                'course_id' => 'required|exists:courses,id',
                'certificate_number' => 'required|string|max:100',
                'grade' => 'nullable|string|max:10',
                'issued_date' => 'required|date',
                'is_sent' => 'boolean',
                'notes' => 'nullable|string',
            ]);

            $certificate->update($validated);
            return redirect()->route('admin.certificates.index')->with('success', 'Sertifikat ma\'lumotlari yangilandi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xatolik: ' . $e->getMessage())->withInput();
        }
    }

    private function generateCertificateNumber()
    {
        $year = date('Y');
        $lastCertificate = Certificate::whereYear('created_at', $year)->latest()->first();
        $number = $lastCertificate ? (int)substr($lastCertificate->certificate_number, -4) + 1 : 1;
        return 'CERT-' . $year . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function show(Certificate $certificate)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'id' => $certificate->id,
                'student_id' => $certificate->student_id,
                'course_id' => $certificate->course_id,
                'certificate_number' => $certificate->certificate_number,
                'grade' => $certificate->grade,
                'issued_date' => $certificate->issued_date?->format('Y-m-d'),
                'is_sent' => (bool)$certificate->is_sent,
                'notes' => $certificate->notes,
            ]);
        }
        
        $certificate->load(['student', 'course']);
        return view('admin.certificates.show', compact('certificate'));
    }

    public function download(Certificate $certificate)
    {
        $certificate->load(['student', 'course', 'template']);
        $certificateHtml = $this->generateCertificateHtml($certificate);
        
        return view('admin.certificates.download', compact('certificate', 'certificateHtml'));
    }

    public function verify(Request $request)
    {
        $certificateNumber = $request->get('number');
        $certificate = Certificate::with(['student', 'course'])
            ->where('certificate_number', $certificateNumber)
            ->first();
            
        return view('certificates.verify', compact('certificate', 'certificateNumber'));
    }

    private function generateCertificateHtml(Certificate $certificate)
    {
        $template = $certificate->template->html_template;
        
        $replacements = [
            '{{student_name}}' => $certificate->student->full_name,
            '{{course_name}}' => $certificate->course->name,
            '{{completion_date}}' => $certificate->completion_date->format('d.m.Y'),
            '{{issued_date}}' => $certificate->issued_date->format('d.m.Y'),
            '{{certificate_number}}' => $certificate->certificate_number,
            '{{grade}}' => $certificate->grade ?? 'Muvaffaqiyatli',
            '{{additional_info}}' => $certificate->additional_info ?? '',
        ];
        
        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }

    // Template Management
    public function templates()
    {
        $templates = CertificateTemplate::latest()->paginate(20);
        return view('admin.certificates.templates.index', compact('templates'));
    }

    public function createTemplate()
    {
        return view('admin.certificates.templates.create');
    }

    public function storeTemplate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'html_template' => 'required|string',
        ]);

        CertificateTemplate::create($validated);
        return redirect()->route('admin.certificates.templates')->with('success', 'Shablon yaratildi.');
    }

    public function previewTemplate(CertificateTemplate $template)
    {
        $html = $template->html_template;
        
        $sampleData = [
            '{{student_name}}' => 'Ali Valiyev',
            '{{course_name}}' => 'Ingliz tili kursi',
            '{{completion_date}}' => '15.12.2024',
            '{{issued_date}}' => '20.12.2024',
            '{{certificate_number}}' => 'CERT-2024-0001',
            '{{grade}}' => 'A+',
            '{{additional_info}}' => 'Namuna sertifikat',
        ];
        
        $previewHtml = str_replace(array_keys($sampleData), array_values($sampleData), $html);
        
        return response($previewHtml)->header('Content-Type', 'text/html');
    }
}
