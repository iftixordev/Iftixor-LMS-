@extends('layouts.admin')

@section('page-title', 'Potensial Mijozni Tahrirlash')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>{{ $lead->full_name }} - Ma'lumotlarni Tahrirlash</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.leads.update', $lead) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Ism *</label>
                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $lead->first_name) }}" required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Familiya *</label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $lead->last_name) }}" required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Telefon *</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $lead->phone) }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Qiziqish bildirgan kurs</label>
                        <select name="course_id" class="form-select @error('course_id') is-invalid @enderror">
                            <option value="">Kurs tanlang</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', $lead->course_id) == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Holat *</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="new" {{ old('status', $lead->status) == 'new' ? 'selected' : '' }}>Yangi</option>
                            <option value="contacted" {{ old('status', $lead->status) == 'contacted' ? 'selected' : '' }}>Aloqaga chiqilgan</option>
                            <option value="interested" {{ old('status', $lead->status) == 'interested' ? 'selected' : '' }}>Qiziqish bildirgan</option>
                            <option value="enrolled" {{ old('status', $lead->status) == 'enrolled' ? 'selected' : '' }}>Ro'yxatdan o'tgan</option>
                            <option value="rejected" {{ old('status', $lead->status) == 'rejected' ? 'selected' : '' }}>Rad etgan</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Manba *</label>
                        <select name="source" class="form-select @error('source') is-invalid @enderror" required>
                            <option value="website" {{ old('source', $lead->source) == 'website' ? 'selected' : '' }}>Veb-sayt</option>
                            <option value="phone" {{ old('source', $lead->source) == 'phone' ? 'selected' : '' }}>Telefon qo'ng'irog'i</option>
                            <option value="social_media" {{ old('source', $lead->source) == 'social_media' ? 'selected' : '' }}>Ijtimoiy tarmoq</option>
                            <option value="referral" {{ old('source', $lead->source) == 'referral' ? 'selected' : '' }}>Tavsiya</option>
                            <option value="walk_in" {{ old('source', $lead->source) == 'walk_in' ? 'selected' : '' }}>Tashrif</option>
                            <option value="other" {{ old('source', $lead->source) == 'other' ? 'selected' : '' }}>Boshqa</option>
                        </select>
                        @error('source')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Kuzatuv sanasi</label>
                        <input type="date" name="follow_up_date" class="form-control @error('follow_up_date') is-invalid @enderror" value="{{ old('follow_up_date', $lead->follow_up_date?->format('Y-m-d')) }}">
                        @error('follow_up_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Izohlar</label>
                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $lead->notes) }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.leads.show', $lead) }}" class="btn btn-secondary">Bekor qilish</a>
                <button type="submit" class="btn btn-primary">Saqlash</button>
            </div>
        </form>
    </div>
</div>
@endsection