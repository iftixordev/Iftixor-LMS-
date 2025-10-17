@extends('layouts.admin')

@section('page-title', 'Yangi Kurs')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Yangi Kurs Yaratish</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Kurs nomi</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Davomiylik (oy)</label>
                        <input type="number" name="duration_months" class="form-control" min="1" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Kurs rasmi</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Tavsif</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Narx (so'm)</label>
                        <input type="number" name="price" class="form-control" min="0" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Min o'quvchilar</label>
                        <input type="number" name="min_students" class="form-control" min="1" value="5" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Max o'quvchilar</label>
                        <input type="number" name="max_students" class="form-control" min="1" value="15" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Darslar soni</label>
                        <input type="number" name="total_lessons" class="form-control" min="1">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Holat</label>
                        <select name="status" class="form-select" required>
                            <option value="active">Faol</option>
                            <option value="inactive">Nofaol</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Talablar</label>
                <textarea name="requirements" class="form-control" rows="2" placeholder="Kursga kirish uchun talablar..."></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Bekor qilish</a>
                <button type="submit" class="btn btn-primary">Kursni Yaratish</button>
            </div>
        </form>
    </div>
</div>
@endsection