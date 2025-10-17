@extends('layouts.admin')

@section('title', 'Sliderlar')
@section('page-title', 'Sliderlar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sliderlar boshqaruvi</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSliderModal">
                        <i class="fas fa-plus me-2"></i>Yangi slider
                    </button>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Rasm</th>
                                    <th>Sarlavha</th>
                                    <th>Tavsif</th>
                                    <th>Tartib</th>
                                    <th>Holat</th>
                                    <th>Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sliders as $slider)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="img-thumbnail" style="width: 80px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>{{ $slider->title }}</td>
                                    <td>{{ Str::limit($slider->description, 50) }}</td>
                                    <td>{{ $slider->order }}</td>
                                    <td>
                                        <span class="badge {{ $slider->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $slider->is_active ? 'Faol' : 'Nofaol' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="editSlider({{ $slider->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline" onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Hech qanday slider topilmadi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Slider Modal -->
<div class="modal fade" id="addSliderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Yangi slider qo'shish</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Sarlavha *</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tavsif</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rasm *</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Havola</label>
                        <input type="url" name="link" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tartib raqami</label>
                        <input type="number" name="order" class="form-control" value="0">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" checked>
                            <label class="form-check-label" for="is_active">Faol</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="submit" class="btn btn-primary">Saqlash</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Slider Modal -->
<div class="modal fade" id="editSliderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editSliderForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Sliderni tahrirlash</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Sarlavha *</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tavsif</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rasm</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Yangi rasm tanlash ixtiyoriy</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Havola</label>
                        <input type="url" name="link" id="edit_link" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tartib raqami</label>
                        <input type="number" name="order" id="edit_order" class="form-control">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="edit_is_active" class="form-check-input">
                            <label class="form-check-label" for="edit_is_active">Faol</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="submit" class="btn btn-primary">Yangilash</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const sliders = @json($sliders);

function editSlider(id) {
    const slider = sliders.find(s => s.id === id);
    if (!slider) return;
    
    document.getElementById('edit_title').value = slider.title;
    document.getElementById('edit_description').value = slider.description || '';
    document.getElementById('edit_link').value = slider.link || '';
    document.getElementById('edit_order').value = slider.order;
    document.getElementById('edit_is_active').checked = slider.is_active;
    
    document.getElementById('editSliderForm').action = `/admin/sliders/${id}`;
    
    new bootstrap.Modal(document.getElementById('editSliderModal')).show();
}
</script>
@endsection