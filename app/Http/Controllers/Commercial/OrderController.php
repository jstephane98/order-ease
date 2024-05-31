<?php

namespace App\Http\Controllers\Commercial;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page') ?? 50;
        $page = $request->get('page') ?? 1;

        $orders = \Auth::user()->orders()->with('tier')->latest()->paginate(perPage: $perPage, page: $page);

        return view("commercial.orders.index", compact("orders"));
    }
}
