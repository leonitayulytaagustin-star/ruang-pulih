<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TbPasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FirebaseAuthController extends Controller
{
    public function handleGoogleLogin(Request $request)
    {
        try {
            $idToken = $request->id_token;
            if (!$idToken) {
                return response()->json(['success' => false, 'message' => 'Token tidak ditemukan'], 400);
            }

            $auth = Firebase::auth();
            
            // Diagnostik: Log project ID, cuplikan token, dan waktu server
            Log::info('Google Login Diagnostic', [
                'credentials_path' => config('firebase.projects.app.credentials'),
                'token_preview' => substr($idToken, 0, 20) . '...',
                'server_time' => date('Y-m-d H:i:s T'),
                'php_timezone' => date_default_timezone_get(),
            ]);

            // 1. Verifikasi Token dari Firebase
            Log::info('Step 1: Verifying ID Token');
            try {
                // Menambahkan leeway 5 menit
                $verifiedIdToken = $auth->verifyIdToken($idToken, false, 300);
                Log::info('Step 1 Success: Token Verified');
            } catch (\Exception $e) {
                Log::error('Step 1 Failure: verifyIdToken failed', ['error' => $e->getMessage()]);
                throw $e;
            }

            // 2. Ambil data user dari Token Claims (lebih efisien daripada getUser)
            $claims = $verifiedIdToken->claims();
            $email = $claims->get('email');
            $name = $claims->get('name') ?? $claims->get('display_name');
            $photoUrl = $claims->get('picture') ?? $claims->get('photo_url');
            
            Log::info('Data from claims', [
                'email' => $email,
                'name' => $name,
            ]);

            if (!$email) {
                return response()->json(['success' => false, 'message' => 'Email tidak ditemukan dalam token'], 400);
            }

            // 2. Cari atau Buat User
            $user = User::where('email', $email)->first();

            if (!$user) {
                // Register sebagai Pasien Baru jika email belum terdaftar
                $user = User::create([
                    'nama_lengkap' => $name,
                    'email' => $email,
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'pasien',
                    'status_akun' => 'aktif',
                    'foto_profil' => $photoUrl,
                ]);

                TbPasien::create([
                    'id_user' => $user->id_user,
                    'tanggal_daftar' => now()->toDateString(),
                    'status_pasien' => 'aktif',
                ]);
            } else {
                // Jika user ada tapi rolenya bukan pasien (opsional: tergantung kebijakan sistem)
                if ($user->role !== 'pasien') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email ini terdaftar sebagai ' . $user->role . '. Silakan gunakan login manual.',
                    ], 403);
                }
                
                // Update foto profil jika berubah dan belum ada foto manual (lokal)
                if ($photoUrl && $user->foto_profil !== $photoUrl) {
                    // Hanya update jika foto saat ini kosong atau juga merupakan URL (bukan path lokal)
                    if (!$user->foto_profil || filter_var($user->foto_profil, FILTER_VALIDATE_URL)) {
                        $user->update(['foto_profil' => $photoUrl]);
                    }
                }
            }

            // 3. Check for 2FA before login
            if ($user->two_factor_enabled) {
                $request->session()->put('2fa_user_id', $user->id_user);
                $request->session()->put('2fa_remember', true); // Or however you want to handle Google remember

                return response()->json([
                    'success' => true,
                    'redirect' => route('two-factor.login'),
                ]);
            }

            // 4. Login-kan di Laravel
            Auth::login($user);

            return response()->json([
                'success' => true,
                'redirect' => route('dashboard'),
            ]);

        } catch (\Exception $e) {
            Log::error('Google Login Error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            $message = $e->getMessage();
            if (str_contains($message, 'invalid_grant')) {
                $message = 'Gagal autentikasi (invalid_grant). Pastikan jam komputer Anda sudah sinkron (akurat) dan file kredensial Firebase sudah benar.';
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal autentikasi Google: ' . $message,
            ], 401);
        }
    }
}
