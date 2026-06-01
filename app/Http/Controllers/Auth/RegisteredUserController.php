<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TbPasien;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        if (! $request->has('nama_lengkap') && $request->has('name')) {
            $request->merge(['nama_lengkap' => $request->input('name')]);
        }

        // VALIDASI
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tb_user,email',
            'password' => 'required|string|min:6|confirmed',
            'nomor_telepon' => 'nullable|string|max:30',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'umur' => 'nullable|integer|min:1|max:120',
        ]);

        // BUAT USER
        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nomor_telepon' => $request->nomor_telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'role' => 'pasien',
            'status_akun' => 'aktif',
        ]);

        TbPasien::create([
            'id_user' => $user->id_user,
            'umur' => $request->umur,
            'tanggal_daftar' => now()->toDateString(),
            'status_pasien' => 'aktif',
        ]);

        // EVENT REGISTER
        event(new Registered($user));

        // AUTO LOGIN
        Auth::login($user);

        // REDIRECT
        return redirect()->route('dashboard');
    }
}
