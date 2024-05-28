<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page');
        $page = $request->get('page');

        $orders = Order::with(['user'])->latest()->paginate(perPage: $perPage, page: $page);

        return view('Admin.orders.index', compact('orders'));
    }

    public function show(int $order_id)
    {
        $order = Order::with(['panier', 'panier.article:ART_CODE,ART_LIB,ART_P_EURO,ART_IMAGE'])->find($order_id);
        return response()->json($order->toArray());
    }
}
