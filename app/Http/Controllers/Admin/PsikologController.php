<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPsikolog;
use App\Models\TbAdmin;
use App\Models\TbPsikolog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class PsikologController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $spesialisasi = $request->string('spesialisasi')->toString();

        $psikologs = TbPsikolog::with('user')
            ->where('status_psikolog', 'aktif')
            ->when($spesialisasi, fn ($query) => $query->where('spesialisasi', $spesialisasi))
            ->whereHas('user', fn ($query) => $query->where('status_akun', 'aktif'))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('nomor_sipa', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($user) use ($search) {
                            $user->where('nama_lengkap', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $spesialisasiList = TbPsikolog::whereNotNull('spesialisasi')
            ->distinct()
            ->pluck('spesialisasi');

        return view('admin.psikolog.index', compact('psikologs', 'spesialisasiList', 'search', 'spesialisasi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tb_user,email',
            'password' => 'required|string|min:6',
            'nomor_telepon' => 'nullable|string|max:30',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'spesialisasi' => 'nullable|string|max:120',
            'nomor_sipa' => 'required|string|max:120|unique:tb_psikolog,nomor_sipa',
            'pendidikan' => 'nullable|string|max:255',
            'pengalaman' => 'nullable|integer|min:0|max:80',
            'bio' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $user = User::create([
                'nama_lengkap' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'nomor_telepon' => $validated['nomor_telepon'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                'role' => 'psikolog',
                'status_akun' => 'aktif',
            ]);

            if ($request->hasFile('foto_profil')) {
                $user->foto_profil = $this->uploadPhoto($request->file('foto_profil'), $user);
                $user->save();
            }

            $admin = TbAdmin::where('id_user', auth()->id())->first();

            $psikolog = TbPsikolog::create([
                'id_user' => $user->id_user,
                'spesialisasi' => $validated['spesialisasi'] ?? null,
                'nomor_sipa' => $validated['nomor_sipa'],
                'pendidikan' => $validated['pendidikan'] ?? null,
                'pengalaman' => $validated['pengalaman'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'status_psikolog' => 'aktif',
                'dibuat_oleh' => $admin?->id_admin,
            ]);

            $this->buatJadwalDefault($psikolog);
        });

        return back()->with('success', 'Psikolog berhasil ditambahkan.');
    }

    public function update(Request $request, TbPsikolog $psikolog)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tb_user,email,'.$psikolog->id_user.',id_user',
            'password' => 'nullable|string|min:6',
            'nomor_telepon' => 'nullable|string|max:30',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'spesialisasi' => 'nullable|string|max:120',
            'nomor_sipa' => 'required|string|max:120|unique:tb_psikolog,nomor_sipa,'.$psikolog->id_psikolog.',id_psikolog',
            'pendidikan' => 'nullable|string|max:255',
            'pengalaman' => 'nullable|integer|min:0|max:80',
            'bio' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $psikolog, $request) {
            $user = $psikolog->user;
            $userData = [
                'nama_lengkap' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'nomor_telepon' => $validated['nomor_telepon'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            ];

            if (filled($validated['password'] ?? null)) {
                $userData['password'] = Hash::make($validated['password']);
            }

            if ($request->hasFile('foto_profil')) {
                $this->deletePhoto($user->foto_profil);
                $userData['foto_profil'] = $this->uploadPhoto($request->file('foto_profil'), $user);
            }

            $user->update($userData);

            $psikolog->update([
                'spesialisasi' => $validated['spesialisasi'] ?? null,
                'nomor_sipa' => $validated['nomor_sipa'],
                'pendidikan' => $validated['pendidikan'] ?? null,
                'pengalaman' => $validated['pengalaman'] ?? null,
                'bio' => $validated['bio'] ?? null,
            ]);
        });

        return back()->with('success', 'Data psikolog berhasil diperbarui.');
    }

    public function destroy(TbPsikolog $psikolog)
    {
        $psikolog->update(['status_psikolog' => 'nonaktif']);
        $psikolog->user?->update(['status_akun' => 'nonaktif']);

        return back()->with('success', 'Akun psikolog berhasil dinonaktifkan.');
    }

    public function show(TbPsikolog $psikolog)
    {
        $psikolog->load(['user', 'jadwal' => fn ($query) => $query->where('tanggal', '>=', now()->toDateString())->orderBy('tanggal')->orderBy('jam_mulai')]);

        return view('admin.psikolog.show', compact('psikolog'));
    }

    private function buatJadwalDefault(TbPsikolog $psikolog): void
    {
        $slots = [
            ['08:00', '09:00'],
            ['09:00', '10:00'],
            ['10:00', '11:00'],
            ['13:00', '14:00'],
            ['14:00', '15:00'],
        ];

        for ($day = 1; $day <= 14; $day++) {
            $tanggal = now()->addDays($day);

            if ($tanggal->isSunday()) {
                continue;
            }

            foreach ($slots as [$mulai, $selesai]) {
                JadwalPsikolog::firstOrCreate([
                    'id_psikolog' => $psikolog->id_psikolog,
                    'tanggal' => $tanggal->toDateString(),
                    'jam_mulai' => $mulai,
                ], [
                    'jam_selesai' => $selesai,
                    'status_jadwal' => 'tersedia',
                ]);
            }
        }
    }

    private function uploadPhoto($file, $user): string
    {
        $directory = storage_path('uploads/profiles/psikolog');

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $filename = 'profile_'.$user->id_user.'_'.time().'_'.uniqid().'.'.$file->extension();
        $file->move($directory, $filename);

        return 'psikolog/'.$filename;
    }

    private function deletePhoto(?string $filename): void
    {
        if (! $filename) {
            return;
        }

        $path = storage_path('uploads/profiles/'.$filename);

        if (File::exists($path) && File::isFile($path)) {
            File::delete($path);
        }
    }
}
