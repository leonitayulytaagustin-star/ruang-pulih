<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontenEdukasi;
use App\Models\Konsultasi;
use App\Models\TbPasien;
use App\Models\TbPsikolog;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'artikel' => KontenEdukasi::where('tipe_konten', 'artikel')->count(),
            'video' => KontenEdukasi::where('tipe_konten', 'video')->count(),
            'pasien' => TbPasien::count(),
            'psikolog' => TbPsikolog::count(),
            'konsultasi' => Konsultasi::count(),
        ];

        $artikels = KontenEdukasi::with('kategori')
            ->where('tipe_konten', 'artikel')
            ->latest()
            ->take(5)
            ->get();

        $videos = KontenEdukasi::with('kategori')
            ->where('tipe_konten', 'video')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'artikels', 'videos'));
    }
}
