<?php

namespace App\Http\Controllers\Psikolog;

use App\Http\Controllers\Controller;
use App\Models\ChatKonsultasi;
use App\Models\Konsultasi;
use App\Models\Notifikasi;
use App\Models\TbPsikolog;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function index()
    {
        $psikolog = $this->psikolog();

        $stats = [
            'baru' => Konsultasi::where('id_psikolog', $psikolog->id_psikolog)->where('status_konsultasi', 'permintaan_baru')->count(),
            'selesai_hari_ini' => Konsultasi::where('id_psikolog', $psikolog->id_psikolog)->where('status_konsultasi', 'selesai')->whereDate('updated_at', today())->count(),
            'semua' => Konsultasi::where('id_psikolog', $psikolog->id_psikolog)->count(),
        ];

        $konsultasi = Konsultasi::with(['pasien.user', 'pendaftaran', 'jadwal'])
            ->where('id_psikolog', $psikolog->id_psikolog)
            ->latest()
            ->paginate(10);

        return view('psikolog.konsultasi.index', compact('stats', 'konsultasi'));
    }

    public function approve(Konsultasi $konsultasi)
    {
        $this->authorizeKonsultasi($konsultasi);

        $konsultasi->update(['status_konsultasi' => 'disetujui']);
        $konsultasi->pendaftaran?->update(['status_pendaftaran' => 'disetujui']);

        Notifikasi::create([
            'id_user' => $konsultasi->pasien->id_user,
            'judul_notifikasi' => 'Konsultasi disetujui',
            'isi_notifikasi' => 'Permintaan konsultasi kamu telah disetujui.',
            'tipe_notifikasi' => 'konsultasi',
        ]);

        return back()->with('success', 'Permintaan konsultasi disetujui.');
    }

    public function reject(Request $request, Konsultasi $konsultasi)
    {
        $this->authorizeKonsultasi($konsultasi);

        $validated = $request->validate([
            'catatan_psikolog' => 'nullable|string|max:1000',
        ]);

        $konsultasi->update([
            'status_konsultasi' => 'ditolak',
            'catatan_psikolog' => $validated['catatan_psikolog'] ?? null,
        ]);
        $konsultasi->pendaftaran?->update(['status_pendaftaran' => 'ditolak']);
        $konsultasi->jadwal?->update(['status_jadwal' => 'tersedia']);

        Notifikasi::create([
            'id_user' => $konsultasi->pasien->id_user,
            'judul_notifikasi' => 'Konsultasi ditolak',
            'isi_notifikasi' => $validated['catatan_psikolog'] ?? 'Permintaan konsultasi belum dapat diterima.',
            'tipe_notifikasi' => 'konsultasi',
        ]);

        return back()->with('success', 'Permintaan konsultasi ditolak.');
    }

    public function start(Konsultasi $konsultasi)
    {
        $this->authorizeKonsultasi($konsultasi);

        $konsultasi->update(['status_konsultasi' => 'berlangsung']);

        return redirect()->route('psikolog.konsultasi.chat', $konsultasi);
    }

    public function finish(Request $request, Konsultasi $konsultasi)
    {
        $this->authorizeKonsultasi($konsultasi);

        $validated = $request->validate([
            'status_konsultasi' => 'required|in:selesai,follow_up',
            'catatan_psikolog' => 'nullable|string',
        ]);

        $konsultasi->update($validated);
        $konsultasi->pendaftaran?->update(['status_pendaftaran' => 'selesai']);

        Notifikasi::create([
            'id_user' => $konsultasi->pasien->id_user,
            'judul_notifikasi' => $validated['status_konsultasi'] === 'follow_up' ? 'Follow-up konsultasi' : 'Konsultasi selesai',
            'isi_notifikasi' => $validated['catatan_psikolog'] ?? 'Psikolog memperbarui status konsultasi kamu.',
            'tipe_notifikasi' => 'konsultasi',
        ]);

        return back()->with('success', 'Status konsultasi diperbarui.');
    }

    public function chat(Konsultasi $konsultasi)
    {
        $this->authorizeKonsultasi($konsultasi);

        $konsultasi->load(['pasien.user', 'psikolog.user', 'chat.pengirim']);

        return view('psikolog.konsultasi.chat', compact('konsultasi'));
    }

    public function send(Request $request, Konsultasi $konsultasi)
    {
        $this->authorizeKonsultasi($konsultasi);

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

    private function psikolog(): TbPsikolog
    {
        return TbPsikolog::where('id_user', auth()->id())->firstOrFail();
    }

    private function authorizeKonsultasi(Konsultasi $konsultasi): void
    {
        abort_unless($konsultasi->id_psikolog === $this->psikolog()->id_psikolog, 403);
    }
}
