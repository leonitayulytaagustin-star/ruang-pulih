<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TwoFactorController extends Controller
{
    public function showChallenge(Request $request)
    {
        $userId = $request->session()->get('2fa_user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        // Generate CAPTCHA only if it doesn't exist or is expired (to avoid re-generating on page refresh immediately, though timeout is 10s)
        $this->generateCaptcha($request);

        return view('auth.two-factor-challenge');
    }

    public function generateCaptchaImage(Request $request)
    {
        $code = $request->session()->get('2fa_captcha_code', 'ERROR');
        
        $width = 150;
        $height = 50;
        $image = imagecreatetruecolor($width, $height);
        
        // Background color
        $bg = imagecolorallocate($image, 240, 240, 240);
        imagefill($image, 0, 0, $bg);
        
        // Add some noise (lines)
        for ($i = 0; $i < 5; $i++) {
            $lineColor = imagecolorallocate($image, rand(100, 200), rand(100, 200), rand(100, 200));
            imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lineColor);
        }
        
        // Add some noise (dots)
        for ($i = 0; $i < 50; $i++) {
            $dotColor = imagecolorallocate($image, rand(100, 200), rand(100, 200), rand(100, 200));
            imagesetpixel($image, rand(0, $width), rand(0, $height), $dotColor);
        }
        
        // Text color
        $textColor = imagecolorallocate($image, rand(0, 100), rand(0, 100), rand(0, 100));
        
        // Use built-in font
        $font = 5; 
        $x = ($width - imagefontwidth($font) * strlen($code)) / 2;
        $y = ($height - imagefontheight($font)) / 2;
        
        // Add text with slight random positioning for obfuscation
        for ($i = 0; $i < strlen($code); $i++) {
            $charX = $x + ($i * imagefontwidth($font) * 1.5) + rand(-2, 2);
            $charY = $y + rand(-5, 5);
            imagechar($image, $font, $charX, $charY, $code[$i], $textColor);
        }

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return response($imageData)->header('Content-Type', 'image/png');
    }

    private function generateCaptcha(Request $request)
    {
        $code = Str::upper(Str::random(6));
        $request->session()->put('2fa_captcha_code', $code);
        $request->session()->put('2fa_captcha_time', now()->timestamp);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'captcha' => 'required|string',
        ]);

        $userId = $request->session()->get('2fa_user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $expectedCode = $request->session()->get('2fa_captcha_code');
        $generatedTime = $request->session()->get('2fa_captcha_time');

        // Force clear to prevent reuse
        $request->session()->forget(['2fa_captcha_code', '2fa_captcha_time']);

        if (!$expectedCode || !$generatedTime) {
            return redirect()->route('login')->withErrors(['email' => 'Sesi verifikasi tidak valid.']);
        }

        // Check if 15 seconds have passed
        if (now()->timestamp - $generatedTime > 15) {
            $request->session()->forget(['2fa_user_id', '2fa_remember']);
            return redirect()->route('login')->withErrors(['email' => 'Waktu verifikasi telah habis (15 detik). Silakan login kembali.']);
        }

        if (strtoupper($request->captcha) !== $expectedCode) {
            // Failed, send back to login
            $request->session()->forget(['2fa_user_id', '2fa_remember']);
            return redirect()->route('login')->withErrors(['email' => 'CAPTCHA salah. Silakan login kembali.']);
        }

        // Success
        $user = User::findOrFail($userId);
        
        Auth::login($user, $request->session()->get('2fa_remember', false));

        $request->session()->forget(['2fa_user_id', '2fa_remember']);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function resend(Request $request)
    {
        // Resend isn't really applicable with a strict 10s timeout that kicks them out, 
        // but we'll leave it to redirect to login if accessed.
        return redirect()->route('login');
    }
}
