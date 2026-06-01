<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\JawabanPemantauan;
use App\Models\Notifikasi;
use App\Models\PemantauanMental;
use App\Models\PertanyaanPemantauan;
use App\Models\RingkasanPasien;
use App\Models\RiwayatAktivitasPasien;
use App\Models\TbPasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemantauanController extends Controller
{
    public function index()
    {
        $pasien = $this->pasien();
        $pertanyaan = PertanyaanPemantauan::where('status', 'aktif')->orderBy('urutan')->get();
        $hariIni = PemantauanMental::where('id_pasien', $pasien->id_pasien)
            ->whereDate('tanggal_pemantauan', today())
            ->first();

        return view('pasien.pemantauan.index', compact('pasien', 'pertanyaan', 'hariIni'));
    }

    public function riwayat()
    {
        $pasien = $this->pasien();
        $riwayats = PemantauanMental::where('id_pasien', $pasien->id_pasien)
            ->latest('tanggal_pemantauan')
            ->latest('id_pemantauan')
            ->paginate(15);

        return view('pasien.pemantauan.riwayat', compact('riwayats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jawaban' => 'required|array',
            'jawaban.*' => 'required|integer|min:0|max:3',
            'emoji' => 'nullable|array',
            'emoji.*' => 'nullable|string|max:20',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $pasien = $this->pasien();

        if (PemantauanMental::where('id_pasien', $pasien->id_pasien)->whereDate('tanggal_pemantauan', today())->exists()) {
            return redirect()->route('pasien.pemantauan.hasil')->with('info', 'Pemantauan hari ini sudah tersimpan.');
        }

        $pemantauan = DB::transaction(function () use ($validated, $pasien) {
            $total = array_sum($validated['jawaban']);
            [$kondisi, $emoji] = $this->kondisi($total);

            $pemantauan = PemantauanMental::create([
                'id_pasien' => $pasien->id_pasien,
                'tanggal_pemantauan' => today()->toDateString(),
                'total_skor' => $total,
                'kondisi_mental' => $kondisi,
                'emoji_kondisi' => $emoji,
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            foreach ($validated['jawaban'] as $idPertanyaan => $nilai) {
                JawabanPemantauan::create([
                    'id_pemantauan' => $pemantauan->id_pemantauan,
                    'id_pertanyaan_pemantauan' => $idPertanyaan,
                    'emoji_jawaban' => $validated['emoji'][$idPertanyaan] ?? null,
                    'nilai_jawaban' => $nilai,
                ]);
            }

            RingkasanPasien::updateOrCreate([
                'id_pasien' => $pasien->id_pasien,
            ], [
                'kondisi_terakhir' => 'Pemantauan '.$kondisi,
                'skor_terakhir' => $total,
                'perubahan' => $kondisi === 'parah' ? 'memburuk' : ($kondisi === 'baik' ? 'membaik' : 'stabil'),
                'prioritas' => $kondisi === 'parah' ? 'tinggi' : ($kondisi === 'sedang' ? 'sedang' : 'rendah'),
                'keterangan' => $validated['keterangan'] ?? null,
                'tanggal_update' => today()->toDateString(),
            ]);

            RiwayatAktivitasPasien::create([
                'id_pasien' => $pasien->id_pasien,
                'jenis_aktivitas' => 'pemantauan_mental',
                'keterangan' => 'Mengisi pemantauan kondisi mental harian',
                'tanggal_aktivitas' => now(),
            ]);

            if ($kondisi === 'parah') {
                User::where('role', 'admin')->get()->each(function ($admin) use ($pasien, $total) {
                    Notifikasi::create([
                        'id_user' => $admin->id_user,
                        'judul_notifikasi' => 'Pemantauan pasien parah',
                        'isi_notifikasi' => $pasien->user->nama_lengkap.' mendapatkan skor pemantauan '.$total,
                        'tipe_notifikasi' => 'pemantauan',
                    ]);
                });
            }

            return $pemantauan;
        });

        return redirect()->route('pasien.pemantauan.hasil', $pemantauan);
    }

    public function hasil(?PemantauanMental $pemantauan = null)
    {
        $pasien = $this->pasien();
        $pemantauan ??= PemantauanMental::where('id_pasien', $pasien->id_pasien)
            ->latest('tanggal_pemantauan')
            ->firstOrFail();

        abort_unless($pemantauan->id_pasien === $pasien->id_pasien, 403);

        $pemantauan->load('jawaban.pertanyaan');

        $riwayat = PemantauanMental::where('id_pasien', $pasien->id_pasien)
            ->orderBy('tanggal_pemantauan')
            ->take(14)
            ->get();

        return view('pasien.pemantauan.hasil', compact('pemantauan', 'riwayat'));
    }

    private function kondisi(int $total): array
    {
        if ($total <= 3) {
            return ['baik', ':)'];
        }

        if ($total <= 7) {
            return ['sedang', ':|'];
        }

        return ['parah', ':('];
    }

    private function pasien(): TbPasien
    {
        return TbPasien::with('user')->firstOrCreate([
            'id_user' => auth()->id(),
        ], [
            'tanggal_daftar' => now()->toDateString(),
            'status_pasien' => 'aktif',
        ]);
    }
}
