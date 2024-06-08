<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page') ?? 50;
        $page = $request->get('page') ?? 1;

        $users = User::with("tier")
            ->latest()->paginate(perPage: $perPage, page: $page);

        $tiers = Tiers::where('PCF_TYPE', 'c')->get();
        return view('Admin.users.index', compact("users", 'tiers'));
    }

    public function activate(Request $request)
    {
        $request->validate([
            "activate" => ['required', 'in:0,1'],
            "users" => ['required', 'array']
        ]);

        $users = User::findMany($request->post('users'));

        $users->each(function (User $user) use ($request){
            $user->update(['active' => $request->post('activate')]);
        });

        return redirect()->back()->with('success', "Ces utilisateurs ont été " . ($request->activate ? "Activé(s)" : "Désactivé(s)"));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:WEB_USERS,id']
        ]);

        $user = User::find($request->post('id'));

        $user->update([
            'type' => $request->post('type'),
            'name' => $request->post('name'),
            'TIER_CODE' => $request->post('tier'),
        ]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->back()->with('success', __("La mise à jour de l'utilisateur a été effectuée avec succès !"));
    }
}
