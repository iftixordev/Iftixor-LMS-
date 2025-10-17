@extends('layouts.admin')

@section('page-title', 'Maosh - ' . $teacher->full_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>{{ $teacher->full_name }} - Maosh Boshqaruvi</h4>
    <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Orqaga
    </a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Yangi Maosh Hisoblash</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.teachers.calculate-salary', $teacher) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Oy</label>
                        <input type="month" name="salary_month" class="form-control" value="{{ $currentMonth }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Bonus</label>
                        <input type="number" name="bonus" class="form-control" step="0.01" min="0">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Chegirma</label>
                        <input type="number" name="deduction" class="form-control" step="0.01" min="0">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Izoh</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-calculator"></i> Hisoblash
                    </button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5>Ish Yuklama Ma'lumotlari</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <h4 class="text-primary">{{ $totalWorkload }}</h4>
                    <p class="mb-0">Haftalik soatlar</p>
                </div>
                
                <div class="text-center">
                    <h5 class="text-success">{{ number_format($totalWorkload * 4 * $teacher->hourly_rate) }} so'm</h5>
                    <p class="mb-0">Taxminiy oylik maosh</p>
                </div>
                
                <hr>
                <p><strong>Soatlik tarif:</strong> {{ number_format($teacher->hourly_rate) }} so'm</p>
                <p><strong>Oylik soatlar:</strong> {{ $totalWorkload * 4 }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Maosh Tarixi</h5>
                <a href="{{ route('admin.teachers.salary-report') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-chart-bar"></i> Umumiy Hisobot
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Oy</th>
                                <th>Asosiy Maosh</th>
                                <th>Bonus</th>
                                <th>Chegirma</th>
                                <th>Jami</th>
                                <th>Soatlar</th>
                                <th>Amallar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($salaries as $salary)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($salary->salary_month)->format('M Y') }}</td>
                                <td>{{ number_format($salary->base_salary) }} so'm</td>
                                <td>{{ number_format($salary->bonus) }} so'm</td>
                                <td>{{ number_format($salary->deduction) }} so'm</td>
                                <td><strong>{{ number_format($salary->final_amount) }} so'm</strong></td>
                                <td>{{ $salary->total_hours }}h</td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#salaryModal{{ $salary->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Salary Details Modal -->
                            <div class="modal fade" id="salaryModal{{ $salary->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Maosh Tafsilotlari - {{ \Carbon\Carbon::parse($salary->salary_month)->format('M Y') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p><strong>Asosiy maosh:</strong></p>
                                                    <p><strong>Soatlik tarif:</strong></p>
                                                    <p><strong>Jami soatlar:</strong></p>
                                                    <p><strong>Bonus:</strong></p>
                                                    <p><strong>Chegirma:</strong></p>
                                                    <hr>
                                                    <p><strong>Jami maosh:</strong></p>
                                                </div>
                                                <div class="col-6">
                                                    <p>{{ number_format($salary->base_salary) }} so'm</p>
                                                    <p>{{ number_format($salary->hourly_rate) }} so'm</p>
                                                    <p>{{ $salary->total_hours }} soat</p>
                                                    <p>{{ number_format($salary->bonus) }} so'm</p>
                                                    <p>{{ number_format($salary->deduction) }} so'm</p>
                                                    <hr>
                                                    <p class="text-success"><strong>{{ number_format($salary->final_amount) }} so'm</strong></p>
                                                </div>
                                            </div>
                                            @if($salary->notes)
                                            <div class="mt-3">
                                                <strong>Izoh:</strong>
                                                <p>{{ $salary->notes }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Maosh ma'lumotlari topilmadi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $salaries->links() }}
            </div>
        </div>
    </div>
</div>
@endsection