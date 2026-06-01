<?php

namespace App\Http\Controllers\Psikolog;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use App\Models\Notifikasi;
use App\Models\RingkasanPasien;
use App\Models\TbPsikolog;

class DashboardController extends Controller
{
    public function index()
    {
        $psikolog = $this->psikolog();

        $stats = [
            'hari_ini' => Konsultasi::where('id_psikolog', $psikolog->id_psikolog)->whereDate('tanggal_konsultasi', today())->count(),
            'pasien' => Konsultasi::where('id_psikolog', $psikolog->id_psikolog)->distinct('id_pasien')->count('id_pasien'),
            'chat_aktif' => Konsultasi::where('id_psikolog', $psikolog->id_psikolog)->where('status_konsultasi', 'berlangsung')->count(),
            'risiko_tinggi' => RingkasanPasien::where('prioritas', 'tinggi')->count(),
        ];

        $jadwalHariIni = Konsultasi::with(['pasien.user', 'jadwal'])
            ->where('id_psikolog', $psikolog->id_psikolog)
            ->whereDate('tanggal_konsultasi', today())
            ->orderBy('waktu_mulai')
            ->get();

        $pasienIds = Konsultasi::where('id_psikolog', $psikolog->id_psikolog)->pluck('id_pasien')->unique();

        $ringkasan = RingkasanPasien::with('pasien.user')
            ->whereIn('id_pasien', $pasienIds)
            ->latest('tanggal_update')
            ->take(5)
            ->get();

        $perhatian = RingkasanPasien::with('pasien.user')
            ->whereIn('id_pasien', $pasienIds)
            ->whereIn('prioritas', ['tinggi', 'sedang'])
            ->orderByRaw("case prioritas when 'tinggi' then 1 when 'sedang' then 2 else 3 end")
            ->take(5)
            ->get();

        $notifikasi = Notifikasi::where('id_user', auth()->id())->latest()->take(5)->get();

        return view('psikolog.dashboard', compact('psikolog', 'stats', 'jadwalHariIni', 'ringkasan', 'perhatian', 'notifikasi'));
    }

    private function psikolog(): TbPsikolog
    {
        return TbPsikolog::with('user')->where('id_user', auth()->id())->firstOrFail();
    }
}
