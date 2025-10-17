@extends('layouts.admin')

@section('page-title', 'Sertifikat: ' . $certificate->certificate_number)

@section('content')
<div class="gemini-grid" style="grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    <div class="gemini-card">
        <div class="gemini-card-header">
            <h3 class="gemini-card-title">Sertifikat Ma'lumotlari</h3>
            <a href="{{ route('admin.certificates.download', $certificate) }}" class="gemini-btn gemini-btn-success">
                <i class="fas fa-download"></i> PDF Yuklab Olish
            </a>
        </div>
        <div class="gemini-card-content">
            <div class="gemini-grid" style="grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div class="gemini-info-group">
                    <div class="gemini-info-item">
                        <span class="gemini-info-label">Sertifikat raqami:</span>
                        <span class="gemini-info-value">{{ $certificate->certificate_number }}</span>
                    </div>
                    <div class="gemini-info-item">
                        <span class="gemini-info-label">O'quvchi:</span>
                        <span class="gemini-info-value">{{ $certificate->student->full_name }}</span>
                    </div>
                    <div class="gemini-info-item">
                        <span class="gemini-info-label">Kurs:</span>
                        <span class="gemini-info-value">{{ $certificate->course->name }}</span>
                    </div>
                    <div class="gemini-info-item">
                        <span class="gemini-info-label">Baho:</span>
                        <span class="gemini-info-value">{{ $certificate->grade ?? 'Muvaffaqiyatli' }}</span>
                    </div>
                </div>
                <div class="gemini-info-group">
                    <div class="gemini-info-item">
                        <span class="gemini-info-label">Tugallangan:</span>
                        <span class="gemini-info-value">{{ $certificate->completion_date->format('d.m.Y') }}</span>
                    </div>
                    <div class="gemini-info-item">
                        <span class="gemini-info-label">Berilgan:</span>
                        <span class="gemini-info-value">{{ $certificate->issued_date->format('d.m.Y') }}</span>
                    </div>
                    <div class="gemini-info-item">
                        <span class="gemini-info-label">Shablon:</span>
                        <span class="gemini-info-value">{{ $certificate->template->name }}</span>
                    </div>
                    <div class="gemini-info-item">
                        <span class="gemini-info-label">Holat:</span>
                        <span class="gemini-badge {{ $certificate->is_sent ? 'gemini-badge-success' : 'gemini-badge-warning' }}">
                            {{ $certificate->is_sent ? 'Yuborilgan' : 'Yuborilmagan' }}
                        </span>
                    </div>
                </div>
            </div>
            
            @if($certificate->additional_info)
            <div class="gemini-section" style="margin-top: 1.5rem;">
                <h4 class="gemini-section-title">Qo'shimcha Ma'lumot</h4>
                <p class="gemini-text">{{ $certificate->additional_info }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="gemini-sidebar">
        <div class="gemini-card">
            <div class="gemini-card-header">
                <h3 class="gemini-card-title">Tezkor Amallar</h3>
            </div>
            <div class="gemini-card-content">
                <div class="gemini-actions">
                    <a href="{{ route('admin.certificates.download', $certificate) }}" class="gemini-btn gemini-btn-success gemini-btn-full">
                        <i class="fas fa-file-pdf"></i> PDF Yuklab Olish
                    </a>
                    
                    <button class="gemini-btn gemini-btn-info gemini-btn-full" onclick="copyVerificationLink()">
                        <i class="fas fa-link"></i> Tekshirish Havolasi
                    </button>
                    
                    <button class="gemini-btn gemini-btn-warning gemini-btn-full" onclick="previewCertificate()">
                        <i class="fas fa-eye"></i> Ko'rib Chiqish
                    </button>
                </div>
            </div>
        </div>

        <div class="gemini-card" style="margin-top: 1.5rem;">
            <div class="gemini-card-header">
                <h3 class="gemini-card-title">O'quvchi Ma'lumotlari</h3>
            </div>
            <div class="gemini-card-content">
                <div class="gemini-info-group">
                    <div class="gemini-info-item">
                        <span class="gemini-info-label">ID:</span>
                        <span class="gemini-info-value">{{ $certificate->student->student_id }}</span>
                    </div>
                    <div class="gemini-info-item">
                        <span class="gemini-info-label">Telefon:</span>
                        <span class="gemini-info-value">{{ $certificate->student->phone }}</span>
                    </div>
                    <div class="gemini-info-item">
                        <span class="gemini-info-label">Email:</span>
                        <span class="gemini-info-value">{{ $certificate->student->email }}</span>
                    </div>
                    <div class="gemini-info-item">
                        <span class="gemini-info-label">Holat:</span>
                        <span class="gemini-badge gemini-badge-success">{{ $certificate->student->status }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyVerificationLink() {
    const link = '{{ route("certificates.verify") }}?number={{ $certificate->certificate_number }}';
    navigator.clipboard.writeText(link).then(function() {
        alert('Tekshirish havolasi nusxalandi!');
    });
}

function previewCertificate() {
    window.open('{{ route("admin.certificates.download", $certificate) }}', '_blank');
}
</script>
@endsection