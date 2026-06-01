<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanMasalah;
use Illuminate\Http\Request;

class LaporanMasalahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();

        $laporans = LaporanMasalah::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('nama_lengkap', 'like', "%{$search}%");
                    });
            })
            ->when($status, fn ($query) => $query->where('status_laporan', $status))
            ->latest()
            ->paginate(10);

        return view('admin.laporan.index', compact('laporans', 'search', 'status'));
    }

    public function updateStatus(Request $request, LaporanMasalah $laporan)
    {
        $request->validate([
            'status_laporan' => 'required|in:pending,diproses,selesai',
        ]);

        $laporan->update([
            'status_laporan' => $request->status_laporan,
        ]);

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function destroy(LaporanMasalah $laporan)
    {
        $laporan->delete();
        return back()->with('success', 'Laporan berhasil dihapus.');
    }
}
