@php $tipeValue = old('tipe_konten', $konten->tipe_konten ?? $tipeDefault); @endphp
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
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tipe Konten</label>
                            <select class="form-select bg-light border-0" name="tipe_konten">
                                <option value="artikel" @selected($tipeValue === 'artikel')>Artikel</option>
                                <option value="video" @selected($tipeValue === 'video')>Video</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kategori</label>
                            <select class="form-select bg-light border-0" name="id_kategori" required>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}" @selected(old('id_kategori', $konten?->id_kategori) == $kat->id_kategori)>{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Judul</label>
                            <input class="form-control bg-light border-0" name="judul_konten" value="{{ old('judul_konten', $konten?->judul_konten) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Isi Artikel</label>
                            <textarea class="form-control bg-light border-0" name="isi_artikel" rows="4">{{ old('isi_artikel', $konten?->isi_artikel) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">URL Video</label>
                            <input class="form-control bg-light border-0" type="url" name="url_video" value="{{ old('url_video', $konten?->url_video) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Durasi Video</label>
                            <input class="form-control bg-light border-0" name="durasi_video" placeholder="08:30" value="{{ old('durasi_video', $konten?->durasi_video) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Thumbnail</label>
                            @if($konten?->thumbnail_url)
                                <div class="mb-2">
                                    <img src="{{ $konten->thumbnail_url }}" alt="Thumbnail" class="rounded shadow-sm" style="height: 60px; width: 100px; object-fit: cover;">
                                </div>
                            @endif
                            <input class="form-control bg-light border-0" type="file" name="thumbnail" accept=".jpg,.jpeg,.png">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select bg-light border-0" name="status">
                                <option value="draft" @selected(old('status', $konten?->status ?? 'draft') === 'draft')>Draft</option>
                                <option value="publish" @selected(old('status', $konten?->status) === 'publish')>Publish</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-secondary me-2 border-0 bg-light text-dark" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary px-4 shadow-sm" type="submit">Simpan Konten</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
