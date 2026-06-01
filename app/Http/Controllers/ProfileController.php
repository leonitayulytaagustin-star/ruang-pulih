<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\TbPsikolog;
use App\Models\TbPasien;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $role = $user->role;
        $view = $role === 'admin' ? 'admin.profile.edit' : 
               ($role === 'psikolog' ? 'psikolog.profile.edit' : 'pasien.profile.edit');

        $data = ['user' => $user];

        if ($role === 'psikolog') {
            $data['psikolog'] = TbPsikolog::where('id_user', $user->id_user)->first();
        } elseif ($role === 'pasien') {
            $data['pasien'] = TbPasien::where('id_user', $user->id_user)->first();
        }

        return view($view, $data);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        unset($validated['foto_profil'], $validated['hapus_foto_profil']);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $this->syncProfilePhoto($request, $user);

        $user->save();

        // Handle role-specific fields
        if ($user->role === 'psikolog') {
            $psikologData = $request->validate([
                'spesialisasi' => ['nullable', 'string', 'max:255'],
                'nomor_sipa' => ['nullable', 'string', 'max:50'],
                'pendidikan' => ['nullable', 'string', 'max:255'],
                'pengalaman' => ['nullable', 'integer', 'min:0'],
                'bio' => ['nullable', 'string'],
            ]);
            TbPsikolog::where('id_user', $user->id_user)->update($psikologData);
        } elseif ($user->role === 'pasien') {
            $pasienData = $request->validate([
                'umur' => ['nullable', 'integer', 'min:1'],
            ]);
            TbPasien::where('id_user', $user->id_user)->update($pasienData);
        }

        $role = $user->role;
        $target = $role === 'admin' ? route('admin.profile.edit') : 
                 ($role === 'psikolog' ? route('psikolog.profile.edit') : route('pasien.profile.edit'));

        return Redirect::to($target)->with('success', 'Profil berhasil diperbarui.');
    }

    public function toggleTwoFactor(Request $request): RedirectResponse
    {
        $user = $request->user();
        $user->two_factor_enabled = !$user->two_factor_enabled;
        $user->save();

        $status = $user->two_factor_enabled ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Autentikasi 2 Langkah berhasil {$status}.");
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $this->deleteProfilePhotoFile($user->foto_profil);
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    private function syncProfilePhoto(ProfileUpdateRequest $request, User $user): void
    {
        if ($request->hasFile('foto_profil')) {
            $directory = storage_path('uploads/profiles/'.$user->role);

            if (! File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $this->deleteProfilePhotoFile($user->foto_profil);

            $file = $request->file('foto_profil');
            $filename = 'profile_'.$user->id_user.'_'.time().'_'.uniqid().'.'.$file->extension();
            $file->move($directory, $filename);

            $user->foto_profil = $user->role.'/'.$filename;
            return;
        }

        if ($request->boolean('hapus_foto_profil')) {
            $this->deleteProfilePhotoFile($user->foto_profil);
            $user->foto_profil = null;
        }
    }

    private function deleteProfilePhotoFile(?string $filename): void
    {
        if (! $filename) {
            return;
        }

        $filename = str_replace('\\', '/', $filename);
        $segments = explode('/', $filename);

        if (count($segments) === 1) {
            $path = storage_path('uploads/profiles/'.$segments[0]);
        } elseif (
            count($segments) === 2
            && in_array($segments[0], ['admin', 'psikolog', 'pasien'], true)
            && $segments[1] === basename($segments[1])
        ) {
            $path = storage_path('uploads/profiles/'.$segments[0].'/'.$segments[1]);
        } else {
            return;
        }

        if (File::exists($path) && File::isFile($path)) {
            File::delete($path);
        }
    }
}
