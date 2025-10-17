@extends('layouts.admin')

@section('page-title', 'Yangi O\'qituvchi')

@push('styles')
<link href="{{ asset('css/centered-form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="centered-form-container">
    <div class="centered-form-card">
        <div class="centered-form-header">
            <h5>Yangi O'qituvchi Qo'shish</h5>
        </div>
        <div class="centered-form-body">
            <form method="POST" action="{{ route('admin.teachers.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">Ism</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">Familiya</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">Telefon</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">Profil rasmi</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Manzil</label>
                    <textarea name="address" class="form-control" rows="2"></textarea>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">Mutaxassislik</label>
                            <input type="text" name="specializations" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">Ta'lim</label>
                            <input type="text" name="education" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">Soatlik maosh (so'm)</label>
                            <input type="number" name="hourly_rate" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">Ishga qabul qilingan sana</label>
                            <input type="date" name="hire_date" class="form-control" value="{{ today()->format('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Bekor qilish
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        O'qituvchini Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection