@extends('layouts.admin')

@section('page-title', 'Xaridlar Boshqaruvi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>O'quvchilar Xaridlari</h4>
    <div>
        <span class="badge bg-warning">{{ $purchases->where('status', 'pending')->count() }} kutilmoqda</span>
        <span class="badge bg-success">{{ $purchases->where('status', 'delivered')->count() }} yetkazilgan</span>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Sana</th>
                        <th>O'quvchi</th>
                        <th>Mahsulot</th>
                        <th>Miqdor</th>
                        <th>Coin</th>
                        <th>Holat</th>
                        <th>Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <strong>{{ $purchase->student->full_name }}</strong><br>
                            <small class="text-muted">{{ $purchase->student->student_id }}</small>
                        </td>
                        <td>{{ $purchase->shopItem->name }}</td>
                        <td>{{ $purchase->quantity }}</td>
                        <td><span class="badge bg-primary">{{ $purchase->coin_cost }} coin</span></td>
                        <td>
                            <span class="badge bg-{{ $purchase->status == 'pending' ? 'warning' : ($purchase->status == 'delivered' ? 'success' : 'danger') }}">
                                {{ ucfirst($purchase->status) }}
                            </span>
                        </td>
                        <td>
                            @if($purchase->status == 'pending')
                            <div class="btn-group">
                                <form method="POST" action="{{ route('admin.gamification.update-purchase', $purchase) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="delivered">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-check"></i> Yetkazildi
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.gamification.update-purchase', $purchase) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-times"></i> Bekor qilish
                                    </button>
                                </form>
                            </div>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Xaridlar yo'q</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $purchases->links() }}
    </div>
</div>
@endsection