@extends('layouts.student')

@section('page-title', 'Mening Profilim')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $user->photo_url }}" width="120" height="120" class="rounded-circle mb-3" alt="{{ $user->full_name }}">
                <h4>{{ $user->full_name }}</h4>
                @if($student)
                    <p class="text-muted">ID: {{ $student->student_id }}</p>
                    <span class="badge bg-{{ $student->status == 'active' ? 'success' : 'warning' }} mb-3">
                        {{ $student->status == 'active' ? 'Faol O\'quvchi' : 'Nofaol' }}
                    </span>
                @endif
                <div class="d-grid">
                    <a href="{{ route('student.profile.edit') }}" class="btn btn-primary">
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
                    <div class="col-sm-8">{{ $user->first_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Familiya:</strong></div>
                    <div class="col-sm-8">{{ $user->last_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Telefon:</strong></div>
                    <div class="col-sm-8">{{ $user->phone }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Tug'ilgan sana:</strong></div>
                    <div class="col-sm-8">{{ $user->birth_date ? $user->birth_date->format('d.m.Y') : 'Kiritilmagan' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Ro'yxatdan o'tgan:</strong></div>
                    <div class="col-sm-8">{{ $user->created_at->format('d.m.Y H:i') }}</div>
                </div>
            </div>
        </div>

        @if($student)
        <div class="card mt-3">
            <div class="card-header">
                <h5>O'quv Ma'lumotlari</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>O'quvchi ID:</strong></div>
                    <div class="col-sm-8">{{ $student->student_id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Guruhlar:</strong></div>
                    <div class="col-sm-8">
                        @if($student->groups->count() > 0)
                            @foreach($student->groups as $group)
                                <span class="badge bg-primary me-1">{{ $group->name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">Guruhga biriktirilmagan</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Holat:</strong></div>
                    <div class="col-sm-8">
                        <span class="badge bg-{{ $student->status == 'active' ? 'success' : 'warning' }}">
                            {{ $student->status == 'active' ? 'Faol' : 'Nofaol' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection