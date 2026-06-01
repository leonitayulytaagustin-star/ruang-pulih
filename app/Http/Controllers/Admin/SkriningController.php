<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSkrining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SkriningController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $skrining = JenisSkrining::withCount('pertanyaan')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_skrining', 'like', "%{$search}%")
                    ->orWhere('jenis_penyakit', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.skrining.index', compact('skrining', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_skrining' => 'required|string|max:255',
            'jenis_penyakit' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'panduan_pengelolaan' => 'nullable|string',
            'status' => 'required|in:draft,publish',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $directory = storage_path('uploads/skrining');
            if (! File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $file = $request->file('gambar');
            $filename = 'skrining_'.time().'_'.uniqid().'.'.$file->extension();
            $file->move($directory, $filename);
            $validated['gambar'] = $filename;
        }

        JenisSkrining::create($validated + [
            'dibuat_oleh' => auth()->id(),
        ]);

        return back()->with('success', 'Jenis skrining berhasil ditambahkan.');
    }

    public function update(Request $request, JenisSkrining $skrining)
    {
        $validated = $request->validate([
            'nama_skrining' => 'required|string|max:255',
            'jenis_penyakit' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'panduan_pengelolaan' => 'nullable|string',
            'status' => 'required|in:draft,publish',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $directory = storage_path('uploads/skrining');
            if (! File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            if ($skrining->gambar) {
                $oldPath = storage_path('uploads/skrining/'.$skrining->gambar);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('gambar');
            $filename = 'skrining_'.time().'_'.uniqid().'.'.$file->extension();
            $file->move($directory, $filename);
            $validated['gambar'] = $filename;
        }

        $skrining->update($validated);

        return back()->with('success', 'Jenis skrining berhasil diperbarui.');
    }

    public function destroy(JenisSkrining $skrining)
    {
        if ($skrining->gambar) {
            $path = storage_path('uploads/skrining/'.$skrining->gambar);
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        
        $skrining->delete();

        return back()->with('success', 'Jenis skrining berhasil dihapus.');
    }
}
