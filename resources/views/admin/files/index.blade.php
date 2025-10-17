@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Fillar boshqaruvi</h3>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        Fayl yuklash
                    </button>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Fayl nomi</th>
                                    <th>Hajmi</th>
                                    <th>Turi</th>
                                    <th>Yuklagan</th>
                                    <th>Sana</th>
                                    <th>Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $file)
                                <tr>
                                    <td>{{ $file->original_name }}</td>
                                    <td>{{ number_format($file->size / 1024, 2) }} KB</td>
                                    <td>{{ $file->mime_type }}</td>
                                    <td>{{ $file->uploader->name }}</td>
                                    <td>{{ $file->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.files.download', $file) }}" class="btn btn-sm btn-info">Yuklab olish</a>
                                        <form method="POST" action="{{ route('admin.files.destroy', $file) }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')">O'chirish</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $files->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.files.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Fayl yuklash</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Fayl tanlang</label>
                        <input type="file" name="file" class="form-control" required>
                        <small class="text-muted">Maksimal hajm: 10MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="submit" class="btn btn-primary">Yuklash</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection