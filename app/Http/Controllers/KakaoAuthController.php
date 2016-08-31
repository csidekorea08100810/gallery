<?php
namespace App\Http\Controllers;

use App\User;
use Auth;
use Socialite;
use Response;
use Illuminate\Routing\Controller;

class KakaoAuthController extends Controller
{
    public function index()
    {
        return Auth::user();
    }

    public function redirectToProvider()
    {
        return Socialite::with('kakao')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::with('kakao')->user();
        $userToLogin = User::where([
            'provider' => 'kakao',
            'socialid' => $user->getId(),
        ])->first();
        if (!$userToLogin) {
            $userToLogin = new User([
                'provider' => 'kakao',
                'socialid' => $user->getId(),
                'token' => $user->token,
                'name' => $user->getName(),
            ]);
            $userToLogin->save();
        }

        Auth::login($userToLogin);
        return redirect('/');
    }
}