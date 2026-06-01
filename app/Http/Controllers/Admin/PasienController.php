<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilSkrining;
use App\Models\Konsultasi;
use App\Models\PemantauanMental;
use App\Models\TbPasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $gender = $request->string('jenis_kelamin')->toString();

        $pasiens = TbPasien::with('user')
            ->whereHas('user', function ($query) use ($search, $gender) {
                $query->when($search, fn ($inner) => $inner->where('nama_lengkap', 'like', "%{$search}%"))
                    ->when($gender, fn ($inner) => $inner->where('jenis_kelamin', $gender));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pasien.index', compact('pasiens', 'search', 'gender'));
    }

    public function show(TbPasien $pasien)
    {
        $pasien->load('user');

        $hasil = HasilSkrining::with('jenisSkrining')
            ->where('id_pasien', $pasien->id_pasien)
            ->latest('tanggal_skrining')
            ->take(10)
            ->get();

        $konsultasi = Konsultasi::with(['psikolog.user', 'jadwal'])
            ->where('id_pasien', $pasien->id_pasien)
            ->latest()
            ->take(10)
            ->get();

        $pemantauan = PemantauanMental::where('id_pasien', $pasien->id_pasien)
            ->latest('tanggal_pemantauan')
            ->take(10)
            ->get();

        return view('admin.pasien.show', compact('pasien', 'hasil', 'konsultasi', 'pemantauan'));
    }
}
