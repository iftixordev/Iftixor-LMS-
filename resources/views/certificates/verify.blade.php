<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat Tekshirish</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Sertifikat Haqiqiyligini Tekshirish</h3>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('certificates.verify') }}" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="number" class="form-control" placeholder="Sertifikat raqamini kiriting..." value="{{ $certificateNumber }}" required>
                                <button type="submit" class="btn btn-primary">Tekshirish</button>
                            </div>
                        </form>

                        @if($certificateNumber)
                            @if($certificate)
                            <div class="alert alert-success">
                                <h5><i class="fas fa-check-circle"></i> Sertifikat Haqiqiy</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Sertifikat raqami:</strong> {{ $certificate->certificate_number }}</p>
                                        <p><strong>O'quvchi:</strong> {{ $certificate->student->full_name }}</p>
                                        <p><strong>Kurs:</strong> {{ $certificate->course->name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Baho:</strong> {{ $certificate->grade ?? 'Muvaffaqiyatli' }}</p>
                                        <p><strong>Tugallangan:</strong> {{ $certificate->completion_date->format('d.m.Y') }}</p>
                                        <p><strong>Berilgan:</strong> {{ $certificate->issued_date->format('d.m.Y') }}</p>
                                    </div>
                                </div>
                                @if($certificate->additional_info)
                                <p><strong>Qo'shimcha:</strong> {{ $certificate->additional_info }}</p>
                                @endif
                            </div>
                            @else
                            <div class="alert alert-danger">
                                <h5><i class="fas fa-times-circle"></i> Sertifikat Topilmadi</h5>
                                <p>Kiritilgan raqam bo'yicha sertifikat topilmadi. Raqamni to'g'ri kiritganingizga ishonch hosil qiling.</p>
                            </div>
                            @endif
                        @endif

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                Bu tizim orqali faqat O'quv Markazi tomonidan berilgan sertifikatlarning haqiqiyligini tekshirish mumkin.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>