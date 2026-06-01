<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TbAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $admins = TbAdmin::with('user')
            ->whereHas('user', function ($query) use ($search) {
                $query->where('status_akun', 'aktif')
                    ->when($search, fn ($inner) => $inner->where('nama_lengkap', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.admin.index', compact('admins', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tb_user,email',
            'password' => 'required|string|min:6',
            'nomor_telepon' => 'nullable|string|max:30',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'nama_lengkap' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'nomor_telepon' => $validated['nomor_telepon'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                'role' => 'admin',
                'status_akun' => 'aktif',
            ]);

            $currentAdmin = TbAdmin::where('id_user', auth()->id())->first();

            TbAdmin::create([
                'id_user' => $user->id_user,
                'dibuat_oleh' => $currentAdmin?->id_admin,
            ]);
        });

        return back()->with('success', 'Admin berhasil ditambahkan.');
    }

    public function update(Request $request, TbAdmin $admin)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tb_user,email,'.$admin->id_user.',id_user',
            'password' => 'nullable|string|min:6',
            'nomor_telepon' => 'nullable|string|max:30',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
        ]);

        $payload = [
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'nomor_telepon' => $validated['nomor_telepon'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
        ];

        if (filled($validated['password'] ?? null)) {
            $payload['password'] = Hash::make($validated['password']);
        }

        $admin->user->update($payload);

        return back()->with('success', 'Data admin berhasil diperbarui.');
    }

    public function show(TbAdmin $admin)
    {
        $admin->load('user');

        return view('admin.admin.show', compact('admin'));
    }

    public function destroy(TbAdmin $admin)
    {
        if ($admin->id_user === auth()->id()) {
            return back()->with('error', 'Admin tidak dapat menghapus akun sendiri.');
        }

        $admin->user?->update(['status_akun' => 'nonaktif']);

        return back()->with('success', 'Akun admin berhasil dinonaktifkan.');
    }
}
