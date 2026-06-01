<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriEdukasi;
use App\Models\KontenEdukasi;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EdukasiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $tipe = $request->string('tipe_konten')->toString();

        $kontens = KontenEdukasi::with(['kategori', 'penulis'])
            ->when($search, function ($query) use ($search) {
                $query->where('judul_konten', 'like', "%{$search}%");
            })
            ->when($tipe, fn ($query) => $query->where('tipe_konten', $tipe))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kategori = KategoriEdukasi::where('status', 'aktif')->orderBy('nama_kategori')->get();

        return view('admin.edukasi.index', compact('kontens', 'kategori', 'search', 'tipe'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe_konten' => 'required|in:artikel,video',
            'judul_konten' => 'required|string|max:255',
            'id_kategori' => 'required|exists:tb_kategori_edukasi,id_kategori',
            'isi_artikel' => 'nullable|required_if:tipe_konten,artikel|string',
            'url_video' => 'nullable|required_if:tipe_konten,video|url',
            'durasi_video' => 'nullable|required_if:tipe_konten,video|string|max:20',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,publish',
        ]);

        $thumbnail = null;
        if ($request->hasFile('thumbnail')) {
            $directory = storage_path('uploads/edukasi');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
            $file = $request->file('thumbnail');
            $filename = 'edu_'.time().'_'.uniqid().'.'.$file->extension();
            $file->move($directory, $filename);
            $thumbnail = $filename;
        }

        $konten = KontenEdukasi::create([
            'id_kategori' => $validated['id_kategori'],
            'id_penulis' => auth()->id(),
            'tipe_konten' => $validated['tipe_konten'],
            'judul_konten' => $validated['judul_konten'],
            'slug' => $this->uniqueSlug($validated['judul_konten']),
            'isi_artikel' => $validated['isi_artikel'] ?? null,
            'url_video' => $validated['url_video'] ?? null,
            'durasi_video' => $validated['durasi_video'] ?? null,
            'thumbnail' => $thumbnail,
            'status' => $validated['status'],
            'tanggal_publish' => $validated['status'] === 'publish' ? now() : null,
        ]);

        if ($konten->status === 'publish') {
            $this->notifyPatients($konten);
        }

        return back()->with('success', 'Konten edukasi berhasil disimpan.');
    }

    public function update(Request $request, KontenEdukasi $edukasi)
    {
        $validated = $request->validate([
            'tipe_konten' => 'required|in:artikel,video',
            'judul_konten' => 'required|string|max:255',
            'id_kategori' => 'required|exists:tb_kategori_edukasi,id_kategori',
            'isi_artikel' => 'nullable|required_if:tipe_konten,artikel|string',
            'url_video' => 'nullable|required_if:tipe_konten,video|url',
            'durasi_video' => 'nullable|required_if:tipe_konten,video|string|max:20',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,publish',
        ]);

        $thumbnail = $edukasi->thumbnail;
        if ($request->hasFile('thumbnail')) {
            $directory = storage_path('uploads/edukasi');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
            
            // Delete old thumbnail
            if ($edukasi->thumbnail) {
                $oldPath = storage_path('uploads/edukasi/'.$edukasi->thumbnail);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('thumbnail');
            $filename = 'edu_'.time().'_'.uniqid().'.'.$file->extension();
            $file->move($directory, $filename);
            $thumbnail = $filename;
        }

        $wasDraft = $edukasi->status !== 'publish';

        $edukasi->update([
            'id_kategori' => $validated['id_kategori'],
            'tipe_konten' => $validated['tipe_konten'],
            'judul_konten' => $validated['judul_konten'],
            'slug' => $this->uniqueSlug($validated['judul_konten'], $edukasi->id_konten),
            'isi_artikel' => $validated['isi_artikel'] ?? null,
            'url_video' => $validated['url_video'] ?? null,
            'durasi_video' => $validated['durasi_video'] ?? null,
            'thumbnail' => $thumbnail,
            'status' => $validated['status'],
            'tanggal_publish' => $validated['status'] === 'publish' ? ($edukasi->tanggal_publish ?? now()) : null,
        ]);

        if ($wasDraft && $edukasi->status === 'publish') {
            $this->notifyPatients($edukasi);
        }

        return back()->with('success', 'Konten edukasi berhasil diperbarui.');
    }

    public function show(KontenEdukasi $edukasi)
    {
        $edukasi->load(['kategori', 'penulis']);

        return view('admin.edukasi.show', compact('edukasi'));
    }

    public function destroy(KontenEdukasi $edukasi)
    {
        $edukasi->delete();

        return back()->with('success', 'Konten edukasi berhasil dihapus.');
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (KontenEdukasi::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id_konten', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function notifyPatients(KontenEdukasi $konten): void
    {
        User::where('role', 'pasien')->chunkById(100, function ($users) use ($konten) {
            foreach ($users as $user) {
                Notifikasi::create([
                    'id_user' => $user->id_user,
                    'judul_notifikasi' => 'Konten edukasi baru',
                    'isi_notifikasi' => $konten->judul_konten,
                    'tipe_notifikasi' => 'edukasi',
                ]);
            }
        }, 'id_user', 'id_user');
    }
}
