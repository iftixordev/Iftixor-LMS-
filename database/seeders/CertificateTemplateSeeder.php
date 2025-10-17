<?php

namespace Database\Seeders;

use App\Models\CertificateTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificateTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Klassik Sertifikat',
                'description' => 'An\'anaviy klassik dizayn',
                'html_template' => '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: "Times New Roman", serif; margin: 0; padding: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .certificate { background: white; border: 15px solid #2c3e50; padding: 60px; text-align: center; box-shadow: 0 0 30px rgba(0,0,0,0.3); }
        .header { border-bottom: 3px solid #e74c3c; padding-bottom: 20px; margin-bottom: 30px; }
        .title { font-size: 48px; color: #2c3e50; margin: 0; font-weight: bold; }
        .subtitle { font-size: 20px; color: #7f8c8d; margin: 10px 0; }
        .student-name { font-size: 36px; color: #e74c3c; margin: 30px 0; font-weight: bold; }
        .course-info { font-size: 18px; margin: 20px 0; }
        .details { display: flex; justify-content: space-between; margin: 40px 0; }
        .signature-area { margin-top: 60px; }
        .signature-line { display: inline-block; width: 200px; border-bottom: 2px solid #2c3e50; margin: 0 30px; }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <h1 class="title">SERTIFIKAT</h1>
            <p class="subtitle">Muvaffaqiyatli Tugallash Sertifikati</p>
        </div>
        
        <p style="font-size: 18px; margin: 20px 0;">Ushbu sertifikat quyidagi shaxsga beriladi:</p>
        
        <h2 class="student-name">{{student_name}}</h2>
        
        <div class="course-info">
            <p><strong>{{course_name}}</strong> kursini {{grade}} baho bilan muvaffaqiyatli tugallagani uchun</p>
        </div>
        
        <div class="details">
            <div>Tugallangan: <strong>{{completion_date}}</strong></div>
            <div>Sertifikat №: <strong>{{certificate_number}}</strong></div>
            <div>Berilgan: <strong>{{issued_date}}</strong></div>
        </div>
        
        <div class="signature-area">
            <div class="signature-line">Direktor</div>
            <div class="signature-line">Muhr</div>
        </div>
    </div>
</body>
</html>',
                'is_active' => true
            ],
            [
                'name' => 'Zamonaviy Sertifikat',
                'description' => 'Zamonaviy gradient dizayn',
                'html_template' => '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: "Arial", sans-serif; margin: 0; padding: 30px; background: #f8f9fa; }
        .certificate { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 50px; text-align: center; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .logo-area { margin-bottom: 30px; }
        .title { font-size: 42px; margin: 0; font-weight: 300; letter-spacing: 3px; }
        .subtitle { font-size: 16px; opacity: 0.9; margin: 10px 0; }
        .student-section { background: rgba(255,255,255,0.1); padding: 30px; margin: 30px 0; border-radius: 15px; }
        .student-name { font-size: 32px; margin: 15px 0; font-weight: bold; }
        .course-name { font-size: 20px; margin: 15px 0; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin: 30px 0; }
        .info-item { background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; }
        .footer { margin-top: 40px; font-size: 14px; opacity: 0.8; }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="logo-area">
            <h1 class="title">CERTIFICATE</h1>
            <p class="subtitle">of Achievement</p>
        </div>
        
        <div class="student-section">
            <p>This certificate is proudly presented to</p>
            <h2 class="student-name">{{student_name}}</h2>
            <p class="course-name">for successfully completing <strong>{{course_name}}</strong></p>
        </div>
        
        <div class="info-grid">
            <div class="info-item">
                <strong>Grade</strong><br>{{grade}}
            </div>
            <div class="info-item">
                <strong>Completed</strong><br>{{completion_date}}
            </div>
            <div class="info-item">
                <strong>Certificate №</strong><br>{{certificate_number}}
            </div>
        </div>
        
        <div class="footer">
            <p>Issued on {{issued_date}} | O\'quv Markazi</p>
        </div>
    </div>
</body>
</html>',
                'is_active' => true
            ],
            [
                'name' => 'Elegant Sertifikat',
                'description' => 'Nafis va elegant dizayn',
                'html_template' => '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: "Georgia", serif; margin: 0; padding: 40px; background: #f5f5f5; }
        .certificate { background: white; border: 2px solid #d4af37; padding: 60px; text-align: center; position: relative; }
        .certificate::before { content: ""; position: absolute; top: 15px; left: 15px; right: 15px; bottom: 15px; border: 1px solid #d4af37; }
        .ornament { font-size: 48px; color: #d4af37; margin: 20px 0; }
        .title { font-size: 40px; color: #2c3e50; margin: 20px 0; font-weight: normal; }
        .subtitle { font-size: 18px; color: #7f8c8d; font-style: italic; }
        .student-name { font-size: 28px; color: #d4af37; margin: 30px 0; font-weight: bold; text-decoration: underline; }
        .course-text { font-size: 16px; line-height: 1.6; margin: 25px 0; }
        .details-table { margin: 30px auto; border-collapse: collapse; }
        .details-table td { padding: 10px 20px; border-bottom: 1px solid #eee; }
        .seal-area { margin-top: 50px; }
        .seal { display: inline-block; width: 80px; height: 80px; border: 3px solid #d4af37; border-radius: 50%; margin: 0 40px; position: relative; }
        .seal::after { content: "MUHR"; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 12px; }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="ornament">❦</div>
        
        <h1 class="title">SERTIFIKAT</h1>
        <p class="subtitle">Muvaffaqiyat Sertifikati</p>
        
        <div class="ornament" style="font-size: 24px;">✦ ✦ ✦</div>
        
        <p style="font-size: 16px;">Ushbu sertifikat hurmat bilan taqdim etiladi</p>
        
        <h2 class="student-name">{{student_name}}</h2>
        
        <div class="course-text">
            <p><em>{{course_name}}</em> kursini {{grade}} natija bilan</p>
            <p><strong>muvaffaqiyatli tugallagani uchun</strong></p>
        </div>
        
        <table class="details-table">
            <tr>
                <td><strong>Tugallangan sana:</strong></td>
                <td>{{completion_date}}</td>
            </tr>
            <tr>
                <td><strong>Sertifikat raqami:</strong></td>
                <td>{{certificate_number}}</td>
            </tr>
            <tr>
                <td><strong>Berilgan sana:</strong></td>
                <td>{{issued_date}}</td>
            </tr>
        </table>
        
        <div class="seal-area">
            <div style="display: inline-block; margin: 0 30px; text-align: center;">
                <div style="border-bottom: 2px solid #d4af37; width: 150px; margin-bottom: 5px;"></div>
                <small>Direktor imzosi</small>
            </div>
            <div class="seal"></div>
        </div>
    </div>
</body>
</html>',
                'is_active' => true
            ]
        ];

        foreach ($templates as $template) {
            CertificateTemplate::create($template);
        }
    }
}
