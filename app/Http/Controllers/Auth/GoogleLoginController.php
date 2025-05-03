<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['access_type' => 'offline', 'prompt' => 'consent'])
            ->scopes(['https://www.googleapis.com/auth/calendar.events']) // カレンダーのスコープを追加
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::firstOrNew(['email' => $googleUser->getEmail()]);
        $user->name = $googleUser->getName();
        $user->password = $user->password ?? bcrypt(str()->random(16)); // 初回のみセット

        // トークン情報の保存
        $user->google_access_token = $googleUser->token;
        $user->google_token_expires_in = now()->addSeconds($googleUser->expiresIn);

        // refreshToken があるときだけ保存（nullの上書きを防ぐ）
        if ($googleUser->refreshToken) {
            $user->google_refresh_token = $googleUser->refreshToken;
        }

        $user->save();

        Auth::login($user);

        return redirect('/');
    }
}

