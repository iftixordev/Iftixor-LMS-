@extends('layouts.teacher')

@section('page-title', 'Mening Profilim')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ Auth::user()->photo_url }}" width="120" height="120" class="rounded-circle mb-3" alt="{{ Auth::user()->full_name }}">
                <h4>{{ Auth::user()->full_name }}</h4>
                <p class="text-muted">{{ Auth::user()->teacher->specialization ?? 'O\'qituvchi' }}</p>
                <span class="badge bg-success mb-3">Faol O'qituvchi</span>
                <div class="d-grid">
                    <a href="{{ route('teacher.profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Profilni Tahrirlash
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Shaxsiy Ma'lumotlar</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Ism:</strong></div>
                    <div class="col-sm-8">{{ Auth::user()->first_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Familiya:</strong></div>
                    <div class="col-sm-8">{{ Auth::user()->last_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Telefon:</strong></div>
                    <div class="col-sm-8">{{ Auth::user()->phone }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Tug'ilgan sana:</strong></div>
                    <div class="col-sm-8">{{ Auth::user()->birth_date ? Auth::user()->birth_date->format('d.m.Y') : 'Kiritilmagan' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Mutaxassislik:</strong></div>
                    <div class="col-sm-8">{{ Auth::user()->teacher->specialization ?? 'Kiritilmagan' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Tajriba:</strong></div>
                    <div class="col-sm-8">{{ Auth::user()->teacher->experience ?? 'Kiritilmagan' }}</div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>O'qituvchilik Ma'lumotlari</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Guruhlar:</strong></div>
                    <div class="col-sm-8">{{ Auth::user()->teacher->groups->count() }} ta</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>O'quvchilar:</strong></div>
                    <div class="col-sm-8">
                        {{ Auth::user()->teacher->groups->sum(function($group) { return $group->students->count(); }) }} kishi
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Fanlar:</strong></div>
                    <div class="col-sm-8">
                        @foreach(Auth::user()->teacher->groups->pluck('course.name')->unique() as $course)
                            <span class="badge bg-primary me-1">{{ $course }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection