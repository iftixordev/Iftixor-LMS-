@extends('layouts.admin')

@section('page-title', 'Yangi Mahsulot')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Yangi Shop Mahsuloti Qo'shish</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.gamification.store-item') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Mahsulot nomi</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Kategoriya</label>
                        <select name="category" class="form-select" required>
                            <option value="merchandise">Brendli mahsulotlar</option>
                            <option value="stationery">Kantselyariya</option>
                            <option value="books">Kitoblar</option>
                            <option value="electronics">Elektronika</option>
                            <option value="other">Boshqa</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Tavsif</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Coin narxi</label>
                        <input type="number" name="coin_price" class="form-control" min="1" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Zaxira miqdori</label>
                        <input type="number" name="stock" class="form-control" min="0" value="10" required>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.gamification.shop') }}" class="btn btn-secondary">Bekor qilish</a>
                <button type="submit" class="btn btn-primary">Mahsulotni Saqlash</button>
            </div>
        </form>
    </div>
</div>
@endsection