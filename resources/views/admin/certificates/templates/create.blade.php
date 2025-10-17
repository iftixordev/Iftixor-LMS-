@extends('layouts.admin')

@section('page-title', 'Yangi Sertifikat Shabloni')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Yangi Sertifikat Shabloni Yaratish</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.certificates.templates.store') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Shablon nomi</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tavsif</label>
                        <input type="text" name="description" class="form-control">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">HTML Shablon</label>
                <div class="alert alert-info">
                    <strong>Mavjud o'zgaruvchilar:</strong>
                    <code>{{student_name}}</code>, <code>{{course_name}}</code>, <code>{{completion_date}}</code>, 
                    <code>{{issued_date}}</code>, <code>{{certificate_number}}</code>, <code>{{grade}}</code>, <code>{{additional_info}}</code>
                </div>
                <textarea name="html_template" class="form-control" rows="15" required><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .certificate { border: 10px solid #0066cc; padding: 50px; margin: 20px; }
        .title { font-size: 48px; color: #0066cc; margin-bottom: 20px; }
        .subtitle { font-size: 24px; margin-bottom: 30px; }
        .content { font-size: 18px; line-height: 1.6; }
        .signature { margin-top: 50px; }
    </style>
</head>
<body>
    <div class="certificate">
        <h1 class="title">SERTIFIKAT</h1>
        <h2 class="subtitle">Muvaffaqiyatli Tugallash Sertifikati</h2>
        
        <div class="content">
            <p>Ushbu sertifikat quyidagi shaxsga beriladi:</p>
            <h3 style="color: #0066cc; font-size: 32px;">{{student_name}}</h3>
            
            <p><strong>{{course_name}}</strong> kursini muvaffaqiyatli tugallagani uchun</p>
            
            <p>Tugallangan sana: <strong>{{completion_date}}</strong></p>
            <p>Baho: <strong>{{grade}}</strong></p>
            
            <div class="signature">
                <p>Sertifikat raqami: {{certificate_number}}</p>
                <p>Berilgan sana: {{issued_date}}</p>
                
                <div style="margin-top: 40px;">
                    <div style="display: inline-block; width: 200px; border-bottom: 1px solid #000; margin: 0 50px;">
                        Direktor imzosi
                    </div>
                    <div style="display: inline-block; width: 200px; border-bottom: 1px solid #000; margin: 0 50px;">
                        Muhr o'rni
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.certificates.templates') }}" class="btn btn-secondary">Bekor qilish</a>
                <button type="submit" class="btn btn-primary">Shablonni Saqlash</button>
            </div>
        </form>
    </div>
</div>
@endsection