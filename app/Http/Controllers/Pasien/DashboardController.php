<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\MoodHarian;
use App\Models\Notifikasi;
use App\Models\RiwayatAktivitasPasien;
use App\Models\TbPasien;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pasien = $this->pasien();
        $moodHariIni = MoodHarian::where('id_pasien', $pasien->id_pasien)
            ->whereDate('tanggal_mood', today())
            ->first();

        $aktivitas = RiwayatAktivitasPasien::where('id_pasien', $pasien->id_pasien)
            ->latest('tanggal_aktivitas')
            ->take(5)
            ->get();

        $notifikasi = Notifikasi::where('id_user', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('pasien.dashboard', compact('pasien', 'moodHariIni', 'aktivitas', 'notifikasi'));
    }

    public function mood(Request $request)
    {
        $validated = $request->validate([
            'mood' => 'required|string|max:50',
            'emoji_mood' => 'nullable|string|max:20',
            'catatan' => 'nullable|string|max:500',
        ]);

        $pasien = $this->pasien();

        MoodHarian::updateOrCreate([
            'id_pasien' => $pasien->id_pasien,
            'tanggal_mood' => today()->toDateString(),
        ], $validated);

        RiwayatAktivitasPasien::create([
            'id_pasien' => $pasien->id_pasien,
            'jenis_aktivitas' => 'pemantauan_mental',
            'keterangan' => 'Memperbarui mood harian: '.$validated['mood'],
            'tanggal_aktivitas' => now(),
        ]);

        return back()->with('success', 'Mood harian berhasil disimpan.');
    }

    public function markAsRead(Notifikasi $notifikasi)
    {
        abort_unless($notifikasi->id_user === auth()->id(), 403);

        $notifikasi->update(['status_baca' => true]);

        return back()->with('success', 'Notifikasi ditandai sebagai dibaca.');
    }

    private function pasien(): TbPasien
    {
        return TbPasien::firstOrCreate([
            'id_user' => auth()->id(),
        ], [
            'tanggal_daftar' => now()->toDateString(),
            'status_pasien' => 'aktif',
        ]);
    }
}
