@extends('layouts.admin')

@section('page-title', 'Moliyaviy Tranzaksiyalar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Moliyaviy Tranzaksiyalar</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
        <i class="fas fa-plus"></i> Yangi Tranzaksiya
    </button>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.finance.transactions') }}">
            <div class="row">
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">Barcha turlar</option>
                        <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Daromad</option>
                        <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Xarajat</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Barcha kategoriyalar</option>
                        <option value="student_payment" {{ request('category') == 'student_payment' ? 'selected' : '' }}>O'quvchi to'lovi</option>
                        <option value="teacher_salary" {{ request('category') == 'teacher_salary' ? 'selected' : '' }}>O'qituvchi maoshi</option>
                        <option value="rent" {{ request('category') == 'rent' ? 'selected' : '' }}>Ijara haqi</option>
                        <option value="utilities" {{ request('category') == 'utilities' ? 'selected' : '' }}>Kommunal to'lovlar</option>
                        <option value="marketing" {{ request('category') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="supplies" {{ request('category') == 'supplies' ? 'selected' : '' }}>Jihozlar</option>
                        <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Boshqa</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-outline-primary">Filtr</button>
                    <a href="{{ route('admin.finance.transactions') }}" class="btn btn-outline-secondary">Tozalash</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Transactions Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Sana</th>
                        <th>Turi</th>
                        <th>Kategoriya</th>
                        <th>Tavsif</th>
                        <th>Summa</th>
                        <th>Bog'liq shaxs</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->transaction_date->format('d.m.Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $transaction->type == 'income' ? 'success' : 'danger' }}">
                                {{ $transaction->type == 'income' ? 'Daromad' : 'Xarajat' }}
                            </span>
                        </td>
                        <td>{{ $transaction->category_label }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td class="text-{{ $transaction->type == 'income' ? 'success' : 'danger' }}">
                            {{ $transaction->type == 'income' ? '+' : '-' }}{{ number_format($transaction->amount) }} so'm
                        </td>
                        <td>
                            @if($transaction->student)
                                {{ $transaction->student->full_name }}
                            @elseif($transaction->teacher)
                                {{ $transaction->teacher->full_name }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tranzaksiyalar topilmadi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $transactions->links() }}
    </div>
</div>

<!-- Add Transaction Modal -->
<div class="modal fade" id="addTransactionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.finance.store-transaction') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Yangi Tranzaksiya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Turi</label>
                                <select name="type" class="form-select" required>
                                    <option value="">Tanlang</option>
                                    <option value="income">Daromad</option>
                                    <option value="expense">Xarajat</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kategoriya</label>
                                <select name="category" class="form-select" required>
                                    <option value="">Tanlang</option>
                                    <option value="student_payment">O'quvchi to'lovi</option>
                                    <option value="teacher_salary">O'qituvchi maoshi</option>
                                    <option value="rent">Ijara haqi</option>
                                    <option value="utilities">Kommunal to'lovlar</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="supplies">Jihozlar</option>
                                    <option value="other">Boshqa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Summa</label>
                        <input type="number" name="amount" class="form-control" min="0" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tavsif</label>
                        <input type="text" name="description" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sana</label>
                        <input type="date" name="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ma'lumotnoma raqami</label>
                        <input type="text" name="reference_number" class="form-control">
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
@endsection