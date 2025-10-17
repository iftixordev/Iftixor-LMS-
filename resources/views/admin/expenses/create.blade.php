@extends('layouts.admin')

@section('page-title', 'Yangi Xarajat')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Yangi Xarajat Qo'shish</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.expenses.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Sarlavha</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Kategoriya</label>
                        <select name="category" class="form-control" required>
                            @foreach($categories as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Miqdor (so'm)</label>
                        <input type="number" name="amount" class="form-control" step="0.01" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Sana</label>
                        <input type="date" name="expense_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Tavsif</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Kvitansiya raqami</label>
                <input type="text" name="receipt_number" class="form-control">
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.expenses.index') }}" class="btn btn-secondary">Bekor qilish</a>
                <button type="submit" class="btn btn-primary">Saqlash</button>
            </div>
        </form>
    </div>
</div>
@endsection