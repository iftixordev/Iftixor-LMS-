@extends('layouts.admin')

@section('page-title', 'Moliyaviy Hisobotlar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Moliyaviy Hisobotlar</h4>
</div>

<!-- Date Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.finance.financial-reports') }}">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Boshlanish sanasi</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date', $startDate->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tugash sanasi</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date', $endDate->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Hisobotni Yangilash</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>Jami Daromad</h5>
                <h3>{{ number_format($income) }} so'm</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5>Jami Xarajat</h5>
                <h3>{{ number_format($expenses) }} so'm</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-{{ $balance >= 0 ? 'primary' : 'warning' }} text-white">
            <div class="card-body">
                <h5>Balans</h5>
                <h3>{{ number_format($balance) }} so'm</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5>Foyda Foizi</h5>
                <h3>{{ $income > 0 ? number_format(($balance / $income) * 100, 1) : 0 }}%</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Income by Category -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6>Daromad Kategoriyalar Bo'yicha</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Kategoriya</th>
                                <th>Summa</th>
                                <th>Foiz</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incomeByCategory as $item)
                            <tr>
                                <td>
                                    @php
                                        $transaction = new \App\Models\Transaction(['category' => $item->category]);
                                    @endphp
                                    {{ $transaction->category_label }}
                                </td>
                                <td>{{ number_format($item->total) }} so'm</td>
                                <td>{{ $income > 0 ? number_format(($item->total / $income) * 100, 1) : 0 }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Expenses by Category -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6>Xarajatlar Kategoriyalar Bo'yicha</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Kategoriya</th>
                                <th>Summa</th>
                                <th>Foiz</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expensesByCategory as $item)
                            <tr>
                                <td>
                                    @php
                                        $transaction = new \App\Models\Transaction(['category' => $item->category]);
                                    @endphp
                                    {{ $transaction->category_label }}
                                </td>
                                <td>{{ number_format($item->total) }} so'm</td>
                                <td>{{ $expenses > 0 ? number_format(($item->total / $expenses) * 100, 1) : 0 }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Trend (if showing yearly data) -->
@if(request('start_date') && request('end_date'))
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6>Moliyaviy Xulosalar</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Eng Yuqori Daromad Kategoriyasi:</h6>
                        @if($incomeByCategory->count() > 0)
                            @php $topIncome = $incomeByCategory->sortByDesc('total')->first(); @endphp
                            <p>{{ (new \App\Models\Transaction(['category' => $topIncome->category]))->category_label }} - {{ number_format($topIncome->total) }} so'm</p>
                        @else
                            <p>Ma'lumot yo'q</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>Eng Yuqori Xarajat Kategoriyasi:</h6>
                        @if($expensesByCategory->count() > 0)
                            @php $topExpense = $expensesByCategory->sortByDesc('total')->first(); @endphp
                            <p>{{ (new \App\Models\Transaction(['category' => $topExpense->category]))->category_label }} - {{ number_format($topExpense->total) }} so'm</p>
                        @else
                            <p>Ma'lumot yo'q</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection