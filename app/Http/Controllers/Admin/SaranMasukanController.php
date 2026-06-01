<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaranMasukan;
use Illuminate\Http\Request;

class SaranMasukanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $sarans = SaranMasukan::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('pesan', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('nama_lengkap', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('admin.saran.index', compact('sarans', 'search'));
    }

    public function destroy(SaranMasukan $saran)
    {
        $saran->delete();
        return back()->with('success', 'Saran/masukan berhasil dihapus.');
    }
}
