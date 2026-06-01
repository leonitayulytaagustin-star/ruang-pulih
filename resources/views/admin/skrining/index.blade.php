@extends('layouts.dashboard', ['title' => 'Manajemen Skrining'])

@section('content')
<section class="hero-panel">
    <h1><i class="fa-solid fa-clipboard-question me-2"></i> Manajemen Skrining</h1>
    <p>Kelola jenis skrining, panduan, pertanyaan, dan jawaban skoring.</p>
</section>

<div class="card border-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <form class="d-flex flex-wrap gap-2 align-items-center" method="GET">
            <div class="input-group" style="max-width:300px;">
                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input class="form-control border-0 bg-light" name="search" value="{{ $search }}" placeholder="Cari jenis penyakit...">
            </div>
            <button class="btn btn-primary shadow-sm" type="submit">Cari</button>
        </form>
        <div class="d-flex gap-2">
            <a class="btn btn-secondary border-0 bg-light text-dark shadow-sm" href="#panduan" data-bs-toggle="modal" data-bs-target="#panduan">
                <i class="fa-solid fa-book-open me-1"></i> Panduan Pengelolaan
            </a>
            <a class="btn btn-primary shadow-sm" href="#tambah-skrining" data-bs-toggle="modal" data-bs-target="#tambah-skrining">
                <i class="fa-solid fa-plus me-1"></i> Tambah Penyakit
            </a>
        </div>
    </div>

    <div class="table-responsive rounded-3 border">
        <table class="table table-hover table-borderless align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="py-3 px-4 text-center" style="width: 5%">No</th>
                    <th class="py-3 px-4">Jenis Skrining</th>
                    <th class="py-3 px-4">Penyakit</th>
                    <th class="py-3 px-4" style="width: 25%">Deskripsi</th>
                    <th class="py-3 px-4 text-center">Pertanyaan</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center" style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($skrining as $item)
                <tr class="border-bottom">
                    <td class="px-4 text-center fw-medium">{{ $skrining->firstItem() + $loop->index }}</td>
                    <td class="px-4">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $item->gambar_url ?: asset('assets/no-image.png') }}" 
                                 onerror="this.onerror=null;this.src='{{ asset('assets/no-image.png') }}';"
                                 class="rounded-2 object-fit-cover border" 
                                 style="width: 45px; height: 45px;">
                            <span class="fw-bold text-dark">{{ $item->nama_skrining }}</span>
                        </div>
                    </td>
                    <td class="px-4">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">{{ $item->jenis_penyakit }}</span>
                    </td>
                    <td class="px-4 text-muted small">{{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}</td>
                    <td class="px-4 text-center">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">{{ $item->pertanyaan_count }} Qs</span>
                    </td>
                    <td class="px-4 text-center">
                        @if($item->status === 'publish')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill"><i class="fa-solid fa-check-circle me-1"></i> Publish</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill"><i class="fa-solid fa-clock me-1"></i> Draft</span>
                        @endif
                    </td>
                    <td class="px-4">
                        <div class="d-flex gap-2 justify-content-center">
                            <a class="btn btn-sm btn-light text-primary rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" href="{{ route('admin.skrining.pertanyaan.edit', $item) }}" title="Kelola Pertanyaan">
                                <i class="fa-solid fa-list-check"></i>
                            </a>
                            <a class="btn btn-sm btn-light text-warning rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" href="#edit-skrining-{{ $item->id_jenis_skrining }}" data-bs-toggle="modal" data-bs-target="#edit-skrining-{{ $item->id_jenis_skrining }}" title="Edit Skrining">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.skrining.destroy', $item) }}" method="POST" onsubmit="confirmDelete(event, 'Hapus skrining ini secara permanen?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-light text-danger rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" type="submit" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-clipboard-question fs-3 text-secondary opacity-50"></i>
                        </div>
                        <br>Belum ada jenis skrining.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    
    @if ($skrining->hasPages())
        <div class="mt-4 d-flex justify-content-end">
            {{ $skrining->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

<!-- Modal Panduan -->
<div class="modal fade" id="panduan" tabindex="-1" aria-labelledby="panduanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-lg);">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="panduanLabel"><i class="fa-solid fa-book-open text-primary me-2"></i> Panduan Pengelolaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="p-3 bg-light rounded-3 text-muted" style="line-height:1.7;">
                    Buat jenis skrining terlebih dahulu, lalu kelola pertanyaan dan jawaban bernilai angka. Setiap pasien hanya dapat mengirim satu hasil per jenis skrining dalam satu hari. Gunakan status <strong>publish</strong> hanya untuk skrining yang sudah lengkap dan siap digunakan.
                </div>
                <div class="mt-4 text-end">
                    <button type="button" class="btn btn-secondary border-0 bg-light text-dark px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.skrining.partials.form-modal', ['id' => 'tambah-skrining', 'title' => 'Tambah Jenis Skrining', 'action' => route('admin.skrining.store'), 'method' => 'POST', 'item' => null])
@foreach ($skrining as $item)
    @include('admin.skrining.partials.form-modal', ['id' => 'edit-skrining-'.$item->id_jenis_skrining, 'title' => 'Edit Jenis Skrining', 'action' => route('admin.skrining.update', $item), 'method' => 'PUT', 'item' => $item])
@endforeach
@endsection
