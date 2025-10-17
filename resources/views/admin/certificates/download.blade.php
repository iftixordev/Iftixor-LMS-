<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat - {{ $certificate->certificate_number }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f5f5f5; 
        }
        .no-print { 
            margin-bottom: 20px; 
            text-align: center; 
        }
        .certificate-container { 
            background: white; 
            padding: 0; 
            box-shadow: 0 0 20px rgba(0,0,0,0.1); 
        }
        @media print { 
            .no-print { display: none; } 
            body { background: white; padding: 0; }
            .certificate-container { box-shadow: none; }
        }
        @page { 
            size: A4 landscape; 
            margin: 0; 
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-primary" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; margin: 0 10px;">
            <i class="fas fa-print"></i> Chop Etish
        </button>
        <button onclick="downloadPDF()" class="btn btn-success" style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; margin: 0 10px;">
            <i class="fas fa-download"></i> PDF Yuklab Olish
        </button>
        <button onclick="window.close()" class="btn btn-secondary" style="padding: 10px 20px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; margin: 0 10px;">
            <i class="fas fa-times"></i> Yopish
        </button>
    </div>

    <div class="certificate-container">
        {!! $certificateHtml !!}
    </div>

    <script>
        function downloadPDF() {
            // Simple solution: open print dialog which allows saving as PDF
            window.print();
        }
    </script>
</body>
</html>