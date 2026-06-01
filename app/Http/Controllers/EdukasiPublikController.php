<?php

namespace App\Http\Controllers;

use App\Models\KategoriEdukasi;
use App\Models\KontenEdukasi;
use Illuminate\Http\Request;

class EdukasiPublikController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->string('filter')->toString();
        $search = $request->string('search')->toString();
        $categories = KategoriEdukasi::where('status', 'aktif')->get();

        $baseQuery = KontenEdukasi::with(['kategori', 'penulis'])
            ->where('status', 'publish')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('judul_konten', 'like', "%{$search}%")
                        ->orWhere('isi_artikel', 'like', "%{$search}%")
                        ->orWhereHas('kategori', fn ($kategori) => $kategori->where('nama_kategori', 'like', "%{$search}%"));
                });
            })
            ->when($filter && is_numeric($filter), fn ($query) => $query->where('id_kategori', $filter))
            ->when($filter === 'artikel', fn ($query) => $query->where('tipe_konten', 'artikel'))
            ->when($filter === 'video', fn ($query) => $query->where('tipe_konten', 'video'));

        $artikels = (clone $baseQuery)
            ->where('tipe_konten', 'artikel')
            ->latest('tanggal_publish')
            ->paginate(6, ['*'], 'artikel_page');

        $videos = (clone $baseQuery)
            ->where('tipe_konten', 'video')
            ->latest('tanggal_publish')
            ->take(6)
            ->get();

        return view('edukasi.index', compact('artikels', 'videos', 'filter', 'search', 'categories'));
    }

    public function show(string $slug)
    {
        $konten = KontenEdukasi::with(['kategori', 'penulis'])
            ->where('slug', $slug)
            ->where('status', 'publish')
            ->where('tipe_konten', 'artikel')
            ->firstOrFail();

        $terkait = KontenEdukasi::with('kategori')
            ->where('status', 'publish')
            ->where('tipe_konten', 'artikel')
            ->where('id_konten', '!=', $konten->id_konten)
            ->where('id_kategori', $konten->id_kategori)
            ->latest('tanggal_publish')
            ->take(4)
            ->get();

        return view('edukasi.show', compact('konten', 'terkait'));
    }

    public function video(string $slug)
    {
        $konten = KontenEdukasi::with(['kategori', 'penulis'])
            ->where('slug', $slug)
            ->where('status', 'publish')
            ->where('tipe_konten', 'video')
            ->firstOrFail();

        return view('edukasi.video', compact('konten'));
    }
}
