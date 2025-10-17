@extends('layouts.admin')

@section('page-title', 'Maosh Hisoboti')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Maosh Hisoboti - {{ \Carbon\Carbon::parse($currentMonth)->format('F Y') }}</h4>
    <div>
        <button class="btn btn-success" onclick="exportToExcel()">
            <i class="fas fa-file-excel"></i> Excel
        </button>
        <button class="btn btn-danger" onclick="exportToPDF()">
            <i class="fas fa-file-pdf"></i> PDF
        </button>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3>{{ $salaries->count() }}</h3>
                <p class="mb-0">Jami O'qituvchilar</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3>{{ number_format($totalSalary) }}</h3>
                <p class="mb-0">Jami Maosh (so'm)</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h3>{{ number_format($salaries->avg('final_amount')) }}</h3>
                <p class="mb-0">O'rtacha Maosh (so'm)</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3>{{ $salaries->sum('total_hours') }}</h3>
                <p class="mb-0">Jami Soatlar</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Tafsiliy Hisobot</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="salaryTable">
                <thead>
                    <tr>
                        <th>O'qituvchi</th>
                        <th>Asosiy Maosh</th>
                        <th>Bonus</th>
                        <th>Chegirma</th>
                        <th>Jami Maosh</th>
                        <th>Soatlar</th>
                        <th>Soatlik Tarif</th>
                        <th>Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salaries as $salary)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $salary->teacher->photo_url }}" width="30" height="30" class="rounded-circle me-2">
                                {{ $salary->teacher->full_name }}
                            </div>
                        </td>
                        <td>{{ number_format($salary->base_salary) }}</td>
                        <td>{{ number_format($salary->bonus) }}</td>
                        <td>{{ number_format($salary->deduction) }}</td>
                        <td><strong>{{ number_format($salary->final_amount) }}</strong></td>
                        <td>{{ $salary->total_hours }}h</td>
                        <td>{{ number_format($salary->hourly_rate) }}</td>
                        <td>
                            <a href="{{ route('admin.teachers.salary', $salary->teacher) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <th>JAMI</th>
                        <th>{{ number_format($salaries->sum('base_salary')) }}</th>
                        <th>{{ number_format($salaries->sum('bonus')) }}</th>
                        <th>{{ number_format($salaries->sum('deduction')) }}</th>
                        <th><strong>{{ number_format($totalSalary) }}</strong></th>
                        <th>{{ $salaries->sum('total_hours') }}h</th>
                        <th>-</th>
                        <th>-</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
function exportToExcel() {
    // Excel export logic
    window.location.href = "{{ route('admin.teachers.salary-export', ['format' => 'excel', 'month' => $currentMonth]) }}";
}

function exportToPDF() {
    // PDF export logic
    window.location.href = "{{ route('admin.teachers.salary-export', ['format' => 'pdf', 'month' => $currentMonth]) }}";
}
</script>
@endsection