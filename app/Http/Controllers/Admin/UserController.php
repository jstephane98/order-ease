<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiers;
use App\Models\User;
use Illuminate\Http\Request;

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
}
