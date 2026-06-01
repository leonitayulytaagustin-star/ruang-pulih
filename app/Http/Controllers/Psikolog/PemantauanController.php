<?php

namespace App\Http\Controllers\Psikolog;

use App\Http\Controllers\Controller;
use App\Models\HasilSkrining;
use App\Models\Konsultasi;
use App\Models\PemantauanMental;
use App\Models\RingkasanPasien;
use App\Models\TbPasien;
use App\Models\TbPsikolog;

class PemantauanController extends Controller
{
    public function index()
    {
        $pasienIds = $this->pasienIds();

        $stats = [
            'dipantau' => $pasienIds->count(),
            'membaik' => RingkasanPasien::whereIn('id_pasien', $pasienIds)->where('perubahan', 'membaik')->count(),
            'memburuk' => RingkasanPasien::whereIn('id_pasien', $pasienIds)->where('perubahan', 'memburuk')->count(),
            'stabil' => RingkasanPasien::whereIn('id_pasien', $pasienIds)->where('perubahan', 'stabil')->count(),
        ];

        $ringkasan = RingkasanPasien::with('pasien.user')
            ->whereIn('id_pasien', $pasienIds)
            ->latest('tanggal_update')
            ->paginate(10);

        return view('psikolog.pemantauan.index', compact('stats', 'ringkasan'));
    }

    public function show(TbPasien $pasien)
    {
        abort_unless($this->pasienIds()->contains($pasien->id_pasien), 403);

        $pasien->load('user');

        $ringkasan = RingkasanPasien::where('id_pasien', $pasien->id_pasien)->first();
        $skrining = HasilSkrining::with('jenisSkrining')->where('id_pasien', $pasien->id_pasien)->latest('tanggal_skrining')->take(10)->get();
        $pemantauan = PemantauanMental::where('id_pasien', $pasien->id_pasien)->orderBy('tanggal_pemantauan')->take(14)->get();

        return view('psikolog.pemantauan.show', compact('pasien', 'ringkasan', 'skrining', 'pemantauan'));
    }

    private function pasienIds()
    {
        $psikolog = TbPsikolog::where('id_user', auth()->id())->firstOrFail();

        return Konsultasi::where('id_psikolog', $psikolog->id_psikolog)
            ->pluck('id_pasien')
            ->unique()
            ->values();
    }
}
