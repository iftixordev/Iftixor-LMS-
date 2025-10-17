@extends('layouts.admin')

@section('page-title', 'Sertifikat Shablonlari')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Sertifikat Shablonlari</h4>
    <a href="{{ route('admin.certificates.templates.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Yangi Shablon
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Tavsif</th>
                        <th>Holat</th>
                        <th>Yaratilgan</th>
                        <th>Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($templates as $template)
                    <tr>
                        <td><strong>{{ $template->name }}</strong></td>
                        <td>{{ $template->description }}</td>
                        <td>
                            <span class="badge bg-{{ $template->is_active ? 'success' : 'secondary' }}">
                                {{ $template->is_active ? 'Faol' : 'Nofaol' }}
                            </span>
                        </td>
                        <td>{{ $template->created_at->format('d.m.Y') }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="previewTemplate({{ $template->id }})">
                                <i class="fas fa-eye"></i> Ko'rish
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Shablonlar topilmadi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $templates->links() }}
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shablon Ko'rinishi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- Template preview will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function previewTemplate(templateId) {
    document.getElementById('previewContent').innerHTML = '<p>Shablon ko\'rinishi yuklanmoqda...</p>';
    new bootstrap.Modal(document.getElementById('previewModal')).show();
    
    // Load template preview
    fetch(`/admin/certificates-templates/${templateId}/preview`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('previewContent').innerHTML = `
                <div style="transform: scale(0.6); transform-origin: top left; width: 166%; height: 166%; overflow: hidden;">
                    ${html}
                </div>
            `;
        })
        .catch(error => {
            document.getElementById('previewContent').innerHTML = '<p class="text-danger">Xatolik yuz berdi.</p>';
        });
}
</script>
@endsection