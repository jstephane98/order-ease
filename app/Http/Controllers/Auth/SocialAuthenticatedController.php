<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthenticatedController extends Controller
{
    public function create(string $driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function store(string $driver)
    {
        try {
            $socialUser = Socialite::driver($driver)->user();
        } catch (\Exception|ClientException $e) {
            return '';
        }

        $user = User::where(function (Builder $query) use ($socialUser, $driver) {
            $query->where('social_id', $socialUser->id)
                ->where('social_name', $driver);
        })->first();

        $userEmail = User::whereEmail($socialUser->email)->first();

        if (! is_null($userEmail)) {
            $user = $userEmail;

            $user->update([
                'name' => $socialUser->name,
                'social_name' => $driver,
                'social_id' => $socialUser->id,
                'social_token' => $socialUser->token,
                'social_refresh_token' => $socialUser->refreshToken,
            ]);
        }

        if (is_null($user)) {
            $user = User::create([
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'social_name' => $driver,
                'social_id' => $socialUser->id,
                'social_token' => $socialUser->token,
                'social_refresh_token' => $socialUser->refreshToken,
            ]);
        }

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
