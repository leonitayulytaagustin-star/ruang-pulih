<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-lg);">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ $action }}" method="POST">
                    @csrf
                    @if ($method !== 'POST') @method($method) @endif
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input class="form-control bg-light border-0" name="nama_lengkap" value="{{ old('nama_lengkap', $admin?->user?->nama_lengkap) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Email</label>
                            <input class="form-control bg-light border-0" type="email" name="email" value="{{ old('email', $admin?->user?->email) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Password <small class="text-muted fw-normal">{{ $admin ? '(kosongkan jika tetap)' : '' }}</small></label>
                            <input class="form-control bg-light border-0" type="password" name="password" {{ $admin ? '' : 'required' }}>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nomor Telepon</label>
                            <input class="form-control bg-light border-0" name="nomor_telepon" value="{{ old('nomor_telepon', $admin?->user?->nomor_telepon) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                            <select class="form-select bg-light border-0" name="jenis_kelamin">
                                <option value="">Pilih</option>
                                <option value="laki-laki" @selected(old('jenis_kelamin', $admin?->user?->jenis_kelamin) === 'laki-laki')>Laki-laki</option>
                                <option value="perempuan" @selected(old('jenis_kelamin', $admin?->user?->jenis_kelamin) === 'perempuan')>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-secondary me-2 border-0 bg-light text-dark" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary px-4 shadow-sm" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
