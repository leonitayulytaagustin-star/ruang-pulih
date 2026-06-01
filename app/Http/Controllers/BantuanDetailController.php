<?php

namespace App\Http\Controllers;

use App\Models\LaporanMasalah;
use App\Models\SaranMasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BantuanDetailController extends Controller
{
    public function darurat()
    {
        return view('bantuan.darurat');
    }

    public function keamanan()
    {
        return view('bantuan.keamanan');
    }

    public function pusatBantuan()
    {
        return view('bantuan.pusat-bantuan');
    }

    public function lapor()
    {
        return view('bantuan.lapor');
    }

    public function saran()
    {
        return view('bantuan.saran');
    }

    public function simpanLaporan(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string',
        ]);

        LaporanMasalah::create([
            'id_user' => Auth::id(), // Can be null if guest, based on migration
            'kategori' => $validated['kategori'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'status_laporan' => 'pending',
        ]);

        return back()->with('success', 'Laporan Anda telah kami terima. Terima kasih atas laporannya.');
    }

    public function simpanSaran(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'pesan' => 'required|string',
        ]);

        SaranMasukan::create([
            'id_user' => Auth::id(),
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'pesan' => $validated['pesan'],
        ]);

        return back()->with('success', 'Terima kasih atas saran dan masukan Anda!');
    }
}
