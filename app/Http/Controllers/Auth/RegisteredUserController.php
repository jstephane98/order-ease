<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tiers;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'type' => ['required', 'in:' . implode(",", User::TYPE_ACCOUNT)],
            "tiers" => ["nullable", "array", "in:" . Tiers::implode("PCF_CODE", ',')]
        ], [
            'email.unique' => "Cet email est déjà existant, veillez vous connecter."
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->post('type'),
            'name' => $request->post('name')
        ]);

        if ($request->has('tiers')) {
            Tiers::whereIn('PCF_CODE', $request->post('tiers'))
                ->get()
                ->each(function (Tiers $tiers) use ($user){
                    return $tiers->update(['user_id' => $user->id]);
                });
        }

//        event(new Registered($user));

        return redirect()->back()->with('success', 'Utilisateur créé avec succès !');
    }
}
