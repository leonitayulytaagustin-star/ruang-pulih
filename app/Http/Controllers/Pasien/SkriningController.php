<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DetailHasilSkrining;
use App\Models\HasilSkrining;
use App\Models\JawabanSkrining;
use App\Models\JenisSkrining;
use App\Models\Notifikasi;
use App\Models\PendaftaranSkrining;
use App\Models\PertanyaanSkrining;
use App\Models\RingkasanPasien;
use App\Models\RiwayatAktivitasPasien;
use App\Models\TbPasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SkriningController extends Controller
{
    public function index()
    {
        $pasien = $this->pasien();

        return view('pasien.skrining.index', compact('pasien'));
    }

    public function riwayat()
    {
        $pasien = $this->pasien();
        $riwayats = HasilSkrining::with('jenisSkrining')
            ->where('id_pasien', $pasien->id_pasien)
            ->latest('tanggal_skrining')
            ->latest('id_hasil_skrining')
            ->paginate(10);

        return view('pasien.skrining.riwayat', compact('riwayats'));
    }

    public function storePendaftaran(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'umur' => 'required|integer|min:1|max:120',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'email' => 'required|email|max:255',
            'pernah_gangguan_mental' => 'required|boolean',
            'jenis_gangguan' => 'nullable|string|max:255',
            'sedang_konsumsi_obat' => 'required|boolean',
            'nama_obat_dosis' => 'nullable|string|max:255',
            'riwayat_penyakit_fisik' => 'nullable|string',
            'catatan_tambahan' => 'nullable|string',
        ]);

        $pasien = $this->pasien();
        $pendaftaran = PendaftaranSkrining::create($validated + [
            'id_pasien' => $pasien->id_pasien,
        ]);

        session(['pendaftaran_skrining_id' => $pendaftaran->id_pendaftaran_skrining]);

        return redirect()->route('pasien.skrining.pilih');
    }

    public function pilih()
    {
        $jenis = JenisSkrining::withCount('pertanyaan')
            ->where('status', 'publish')
            ->latest()
            ->get();

        return view('pasien.skrining.pilih', compact('jenis'));
    }

    public function tes(JenisSkrining $skrining)
    {
        abort_unless($skrining->status === 'publish', 404);

        $existing = HasilSkrining::where('id_pasien', $this->pasien()->id_pasien)
            ->where('id_jenis_skrining', $skrining->id_jenis_skrining)
            ->whereDate('tanggal_skrining', today())
            ->first();

        if ($existing) {
            return redirect()->route('pasien.skrining.hasil', $existing)->with('info', 'Kamu sudah mengisi tes ini hari ini.');
        }

        $skrining->load('pertanyaan.jawaban');

        return view('pasien.skrining.tes', compact('skrining'));
    }

    public function submit(Request $request, JenisSkrining $skrining)
    {
        $skrining->load('pertanyaan.jawaban');

        $request->validate([
            'jawaban' => 'required|array',
            'jawaban.*' => 'required|integer|exists:tb_jawaban_skrining,id_jawaban',
        ]);

        $pasien = $this->pasien();

        if (HasilSkrining::where('id_pasien', $pasien->id_pasien)
            ->where('id_jenis_skrining', $skrining->id_jenis_skrining)
            ->whereDate('tanggal_skrining', today())
            ->exists()) {
            return back()->with('error', 'Tes ini hanya dapat disubmit satu kali per hari.');
        }

        $hasil = DB::transaction(function () use ($request, $skrining, $pasien) {
            $jawabanIds = collect($request->input('jawaban'));
            $jawaban = JawabanSkrining::whereIn('id_jawaban', $jawabanIds)->get()->keyBy('id_jawaban');
            $total = $jawaban->sum('nilai_jawaban');
            [$kategori, $keterangan] = $this->kategoriHasil($skrining, $total);

            $hasil = HasilSkrining::create([
                'id_pasien' => $pasien->id_pasien,
                'id_jenis_skrining' => $skrining->id_jenis_skrining,
                'total_skor' => $total,
                'kategori_hasil' => $kategori,
                'keterangan_hasil' => $keterangan,
                'tanggal_skrining' => today()->toDateString(),
            ]);

            foreach ($request->input('jawaban') as $idPertanyaan => $idJawaban) {
                $selected = $jawaban[$idJawaban];

                DetailHasilSkrining::create([
                    'id_hasil_skrining' => $hasil->id_hasil_skrining,
                    'id_pertanyaan' => $idPertanyaan,
                    'id_jawaban' => $idJawaban,
                    'nilai_jawaban' => $selected->nilai_jawaban,
                ]);
            }

            RingkasanPasien::updateOrCreate([
                'id_pasien' => $pasien->id_pasien,
            ], [
                'kondisi_terakhir' => $skrining->jenis_penyakit.' '.$kategori,
                'skor_terakhir' => $total,
                'perubahan' => in_array($kategori, ['berat', 'tinggi'], true) ? 'memburuk' : 'stabil',
                'prioritas' => in_array($kategori, ['berat', 'tinggi'], true) ? 'tinggi' : 'sedang',
                'keterangan' => $keterangan,
                'tanggal_update' => today()->toDateString(),
            ]);

            RiwayatAktivitasPasien::create([
                'id_pasien' => $pasien->id_pasien,
                'jenis_aktivitas' => 'skrining',
                'keterangan' => 'Menyelesaikan skrining '.$skrining->nama_skrining,
                'tanggal_aktivitas' => now(),
            ]);

            if (in_array($kategori, ['berat', 'tinggi'], true)) {
                User::where('role', 'admin')->get()->each(function ($admin) use ($pasien, $skrining, $total) {
                    Notifikasi::create([
                        'id_user' => $admin->id_user,
                        'judul_notifikasi' => 'Skor skrining tinggi',
                        'isi_notifikasi' => $pasien->user->nama_lengkap.' mendapatkan skor '.$total.' pada '.$skrining->nama_skrining,
                        'tipe_notifikasi' => 'skrining',
                    ]);
                });
            }

            return $hasil;
        });

        return redirect()->route('pasien.skrining.hasil', $hasil);
    }

    public function hasil(HasilSkrining $hasil)
    {
        abort_unless($hasil->id_pasien === $this->pasien()->id_pasien, 403);

        $hasil->load(['jenisSkrining', 'detail.pertanyaan', 'detail.jawaban']);

        return view('pasien.skrining.hasil', compact('hasil'));
    }

    public function downloadPdf(HasilSkrining $hasil)
    {
        abort_unless($hasil->id_pasien === $this->pasien()->id_pasien, 403);

        $pasien = $this->pasien();
        $hasil->load(['jenisSkrining', 'detail.pertanyaan', 'detail.jawaban']);

        $pdf = Pdf::loadView('pasien.skrining.pdf', compact('hasil', 'pasien'));
        
        $filename = 'Hasil_Skrining_' . str_replace(' ', '_', $hasil->jenisSkrining->nama_skrining) . '_' . $hasil->tanggal_skrining->format('Ymd') . '.pdf';
        
        return $pdf->download($filename);
    }

    private function kategoriHasil(JenisSkrining $skrining, int $total): array
    {
        $max = max(1, PertanyaanSkrining::where('id_jenis_skrining', $skrining->id_jenis_skrining)->count() * 4);

        if ($total <= $max * 0.33) {
            return ['ringan', 'Gejala masih ringan. Pertahankan kebiasaan sehat dan lakukan pemantauan berkala.'];
        }

        if ($total <= $max * 0.66) {
            return ['sedang', 'Gejala berada pada tingkat sedang. Pertimbangkan konsultasi bila mengganggu aktivitas.'];
        }

        return ['berat', 'Gejala cukup tinggi. Disarankan segera berkonsultasi dengan psikolog.'];
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
