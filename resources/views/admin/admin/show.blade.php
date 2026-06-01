@extends('layouts.dashboard', ['title' => 'Detail Admin'])

@section('content')
<section class="hero-panel d-flex justify-content-between align-items-center">
    <div style="position: relative; z-index: 2;">
        <h1 class="mb-2"><i class="fa-solid fa-user-shield me-2"></i> {{ $admin->user->nama_lengkap }}</h1>
        <div class="d-flex align-items-center gap-2 mt-2">
            <span class="badge bg-light bg-opacity-25 text-white px-3 py-2 rounded-pill"><i class="fa-solid fa-envelope me-1"></i> {{ $admin->user->email }}</span>
        </div>
    </div>
    <a href="{{ route('admin.admin.index') }}" class="btn btn-light shadow-sm fw-bold" style="position: relative; z-index: 2;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</section>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 h-100 p-4 d-flex flex-row align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-venus-mars fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Jenis Kelamin</small>
                <h5 class="mb-0 fw-bold text-capitalize">{{ $admin->user->jenis_kelamin ?? '-' }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 h-100 p-4 d-flex flex-row align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-phone fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Nomor Telepon</small>
                <h5 class="mb-0 fw-bold">{{ $admin->user->nomor_telepon ?? '-' }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 h-100 p-4 d-flex flex-row align-items-center gap-3">
            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-circle-check fs-3"></i>
            </div>
            <div>
                <small class="text-muted fw-semibold d-block mb-1">Status Akun</small>
                <h5 class="mb-0 fw-bold text-capitalize text-success">{{ $admin->user->status_akun }}</h5>
            </div>
        </div>
    </div>
</div>
@endsection
