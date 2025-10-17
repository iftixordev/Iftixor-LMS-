@extends('layouts.student')

@section('page-title', 'Dars Jadvali')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Haftalik Dars Jadvali</h5>
        <div class="btn-group" role="group">
            <button class="btn btn-outline-primary btn-sm active">Hafta</button>
            <button class="btn btn-outline-primary btn-sm">Oy</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Vaqt</th>
                        <th>Dushanba</th>
                        <th>Seshanba</th>
                        <th>Chorshanba</th>
                        <th>Payshanba</th>
                        <th>Juma</th>
                        <th>Shanba</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold">09:00-10:30</td>
                        <td></td>
                        <td class="bg-primary bg-opacity-10">
                            <div class="p-2">
                                <strong>JavaScript</strong><br>
                                <small>Xona: 101</small><br>
                                <small>A.Karimov</small>
                            </div>
                        </td>
                        <td></td>
                        <td class="bg-primary bg-opacity-10">
                            <div class="p-2">
                                <strong>JavaScript</strong><br>
                                <small>Xona: 101</small><br>
                                <small>A.Karimov</small>
                            </div>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">11:00-12:30</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="bg-success bg-opacity-10">
                            <div class="p-2">
                                <strong>React</strong><br>
                                <small>Xona: 102</small><br>
                                <small>B.Toshev</small>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">14:00-15:30</td>
                        <td class="bg-warning bg-opacity-10">
                            <div class="p-2">
                                <strong>HTML/CSS</strong><br>
                                <small>Xona: 103</small><br>
                                <small>C.Rahimov</small>
                            </div>
                        </td>
                        <td></td>
                        <td class="bg-warning bg-opacity-10">
                            <div class="p-2">
                                <strong>HTML/CSS</strong><br>
                                <small>Xona: 103</small><br>
                                <small>C.Rahimov</small>
                            </div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Today's Classes -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Bugungi Darslar</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 bg-primary bg-opacity-10 rounded mb-3">
                            <div class="me-3">
                                <i class="fas fa-clock fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">JavaScript Asoslari</h6>
                                <p class="mb-1">14:00 - 15:30</p>
                                <small class="text-muted">Xona: 101 | A.Karimov</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 bg-success bg-opacity-10 rounded mb-3">
                            <div class="me-3">
                                <i class="fas fa-clock fa-2x text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">React Loyiha</h6>
                                <p class="mb-1">16:00 - 17:30</p>
                                <small class="text-muted">Xona: 102 | B.Toshev</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection