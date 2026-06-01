<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\ChatKonsultasi;
use App\Models\JadwalPsikolog;
use App\Models\Konsultasi;
use App\Models\Notifikasi;
use App\Models\PendaftaranKonsultasi;
use App\Models\RiwayatAktivitasPasien;
use App\Models\TbPasien;
use App\Models\TbPsikolog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KonsultasiController extends Controller
{
    public function index()
    {
        $pasien = $this->pasien();
        $konsultasi = Konsultasi::with(['psikolog.user', 'jadwal'])
            ->where('id_pasien', $pasien->id_pasien)
            ->latest()
            ->take(5)
            ->get();

        return view('pasien.konsultasi.index', compact('pasien', 'konsultasi'));
    }

    public function storePendaftaran(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'umur' => 'required|integer|min:1|max:120',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'email' => 'required|email|max:255',
            'keluhan' => 'required|string|min:10',
            'tingkat_urgensi' => 'required|in:rendah,sedang,tinggi',
            'persetujuan_syarat' => 'accepted',
        ]);

        $pendaftaran = PendaftaranKonsultasi::create($validated + [
            'id_pasien' => $this->pasien()->id_pasien,
            'persetujuan_syarat' => true,
            'status_pendaftaran' => 'menunggu',
        ]);

        session(['pendaftaran_konsultasi_id' => $pendaftaran->id_pendaftaran_konsultasi]);

        return redirect()->route('pasien.konsultasi.psikolog');
    }

    public function pilihPsikolog(Request $request)
    {
        $search = $request->string('search')->toString();

        $psikologs = TbPsikolog::with('user')
            ->where('status_psikolog', 'aktif')
            ->whereHas('user', fn ($query) => $query->where('status_akun', 'aktif'))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('spesialisasi', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($user) => $user->where('nama_lengkap', 'like', "%{$search}%"));
                });
            })
            ->paginate(9)
            ->withQueryString();

        return view('pasien.konsultasi.pilih_psikolog', compact('psikologs', 'search'));
    }

    public function jadwal(TbPsikolog $psikolog)
    {
        $psikolog->load('user');

        $jadwal = JadwalPsikolog::where('id_psikolog', $psikolog->id_psikolog)
            ->where('status_jadwal', 'tersedia')
            ->where('tanggal', '>=', today()->toDateString())
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy(fn ($slot) => $slot->tanggal->format('Y-m-d'));

        return view('pasien.konsultasi.jadwal', compact('psikolog', 'jadwal'));
    }

    public function simpanJadwal(Request $request, TbPsikolog $psikolog)
    {
        $validated = $request->validate([
            'id_jadwal' => 'required|exists:tb_jadwal_psikolog,id_jadwal',
        ]);

        $pasien = $this->pasien();
        $pendaftaran = $this->pendingPendaftaran($pasien);

        if (! $pendaftaran) {
            return redirect()->route('pasien.konsultasi.index')->with('error', 'Lengkapi data konsultasi terlebih dahulu.');
        }

        $konsultasi = DB::transaction(function () use ($validated, $psikolog, $pasien, $pendaftaran) {
            $jadwal = JadwalPsikolog::where('id_jadwal', $validated['id_jadwal'])
                ->where('id_psikolog', $psikolog->id_psikolog)
                ->where('status_jadwal', 'tersedia')
                ->lockForUpdate()
                ->firstOrFail();

            $jadwal->update(['status_jadwal' => 'terpakai']);

            $konsultasi = Konsultasi::create([
                'id_pendaftaran_konsultasi' => $pendaftaran->id_pendaftaran_konsultasi,
                'id_pasien' => $pasien->id_pasien,
                'id_psikolog' => $psikolog->id_psikolog,
                'id_jadwal' => $jadwal->id_jadwal,
                'tanggal_konsultasi' => $jadwal->tanggal->toDateString(),
                'waktu_mulai' => $jadwal->jam_mulai,
                'waktu_selesai' => $jadwal->jam_selesai,
                'status_konsultasi' => 'permintaan_baru',
            ]);

            Notifikasi::create([
                'id_user' => $psikolog->id_user,
                'judul_notifikasi' => 'Permintaan konsultasi baru',
                'isi_notifikasi' => $pasien->user->nama_lengkap.' meminta konsultasi pada '.$jadwal->tanggal->format('d M Y'),
                'tipe_notifikasi' => 'konsultasi',
            ]);

            RiwayatAktivitasPasien::create([
                'id_pasien' => $pasien->id_pasien,
                'jenis_aktivitas' => 'konsultasi',
                'keterangan' => 'Mendaftar konsultasi dengan '.$psikolog->user->nama_lengkap,
                'tanggal_aktivitas' => now(),
            ]);

            return $konsultasi;
        });

        session()->forget('pendaftaran_konsultasi_id');

        return redirect()->route('pasien.konsultasi.menunggu', $konsultasi);
    }

    public function menunggu(?Konsultasi $konsultasi = null)
    {
        $pasien = $this->pasien();
        $konsultasi ??= Konsultasi::with(['psikolog.user', 'jadwal'])
            ->where('id_pasien', $pasien->id_pasien)
            ->latest()
            ->firstOrFail();

        abort_unless($konsultasi->id_pasien === $pasien->id_pasien, 403);

        $konsultasi->load(['psikolog.user', 'jadwal']);

        return view('pasien.konsultasi.menunggu', compact('konsultasi'));
    }

    public function riwayat()
    {
        $konsultasi = Konsultasi::with(['psikolog.user', 'jadwal'])
            ->where('id_pasien', $this->pasien()->id_pasien)
            ->latest()
            ->paginate(10);

        return view('pasien.konsultasi.riwayat', compact('konsultasi'));
    }

    public function chat(Konsultasi $konsultasi)
    {
        abort_unless($konsultasi->id_pasien === $this->pasien()->id_pasien, 403);

        $konsultasi->load(['psikolog.user', 'pasien.user', 'chat.pengirim']);

        return view('pasien.konsultasi.chat', compact('konsultasi'));
    }

    public function send(Request $request, Konsultasi $konsultasi)
    {
        abort_unless($konsultasi->id_pasien === $this->pasien()->id_pasien, 403);

        $validated = $request->validate([
            'pesan' => 'required_without:file_lampiran|nullable|string',
            'file_lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $file = $request->file('file_lampiran')?->store('chat', 'public');

        if (in_array($konsultasi->status_konsultasi, ['disetujui', 'terjadwal'], true)) {
            $konsultasi->update(['status_konsultasi' => 'berlangsung']);
        }

        ChatKonsultasi::create([
            'id_konsultasi' => $konsultasi->id_konsultasi,
            'id_pengirim' => auth()->id(),
            'pesan' => $validated['pesan'] ?? null,
            'tipe_pesan' => $file ? 'file' : 'teks',
            'file_lampiran' => $file,
            'waktu_kirim' => now(),
        ]);

        return back();
    }

    private function pendingPendaftaran(TbPasien $pasien): ?PendaftaranKonsultasi
    {
        $id = session('pendaftaran_konsultasi_id');

        return PendaftaranKonsultasi::where('id_pasien', $pasien->id_pasien)
            ->when($id, fn ($query) => $query->where('id_pendaftaran_konsultasi', $id))
            ->where('status_pendaftaran', 'menunggu')
            ->latest()
            ->first();
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
