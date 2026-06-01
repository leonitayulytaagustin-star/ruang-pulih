<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-lg);">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($method !== 'POST') @method($method) @endif
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Foto Profil</label>
                            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-4">
                                @if($psikolog?->user?->foto_profil)
                                    <img src="{{ $psikolog->user->foto_profil_url }}" alt="Preview" class="rounded-circle object-fit-cover shadow-sm" style="width: 60px; height: 60px;">
                                @else
                                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px;">
                                        <i class="fa-solid fa-user-doctor fs-3"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <input type="file" name="foto_profil" class="form-control bg-white border-0" accept="image/jpeg,image/png,image/webp">
                                    <small class="text-muted d-block mt-1">JPG, PNG, atau WebP. Maksimal 2MB.</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input class="form-control bg-light border-0" name="nama_lengkap" value="{{ old('nama_lengkap', $psikolog?->user?->nama_lengkap) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input class="form-control bg-light border-0" type="email" name="email" value="{{ old('email', $psikolog?->user?->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password <small class="text-muted fw-normal">{{ $psikolog ? '(kosongkan jika tetap)' : '' }}</small></label>
                            <input class="form-control bg-light border-0" type="password" name="password" {{ $psikolog ? '' : 'required' }}>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nomor Telepon</label>
                            <input class="form-control bg-light border-0" name="nomor_telepon" value="{{ old('nomor_telepon', $psikolog?->user?->nomor_telepon) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                            <select class="form-select bg-light border-0" name="jenis_kelamin">
                                <option value="">Pilih</option>
                                <option value="laki-laki" @selected(old('jenis_kelamin', $psikolog?->user?->jenis_kelamin) === 'laki-laki')>Laki-laki</option>
                                <option value="perempuan" @selected(old('jenis_kelamin', $psikolog?->user?->jenis_kelamin) === 'perempuan')>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Spesialisasi</label>
                            <input class="form-control bg-light border-0" name="spesialisasi" value="{{ old('spesialisasi', $psikolog?->spesialisasi) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nomor SIPA</label>
                            <input class="form-control bg-light border-0" name="nomor_sipa" value="{{ old('nomor_sipa', $psikolog?->nomor_sipa) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pendidikan</label>
                            <input class="form-control bg-light border-0" name="pendidikan" value="{{ old('pendidikan', $psikolog?->pendidikan) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Pengalaman (tahun)</label>
                            <input class="form-control bg-light border-0" type="number" min="0" name="pengalaman" value="{{ old('pengalaman', $psikolog?->pengalaman) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Bio</label>
                            <textarea class="form-control bg-light border-0" name="bio" rows="3">{{ old('bio', $psikolog?->bio) }}</textarea>
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
