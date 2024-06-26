<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Panier;
use App\Models\Tiers;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page') ?? 50;
        $page = $request->get('page') ?? 1;
        $ordersId = [];

        if (Auth::user()->type === "PARTENAIRE") {
            $ordersId = Auth::user()->tier->orders()->pluck('id')->toArray();
        }

        $orders = Order::with(['user', "tier"])
            ->when(Auth::user()->type === "PARTENAIRE", function (Builder $builder) use ($ordersId) {
                $builder->whereIn('id', $ordersId);
            })
            ->latest()
            ->paginate(perPage: $perPage, page: $page);

        return view('Admin.orders.index', compact('orders'));
    }

    public function show(int $order_id)
    {
        $order = Order::with(['panier', 'panier.article:ART_CODE,ART_LIB,ART_P_EURO,ART_IMAGE,FAR_CODE'])->find($order_id);
        return response()->json($order->toArray());
    }

    public function cancel()
    {
        $order = Auth::user()->orders()->where('status', "CREATED")->first();
        $order->update(['status' => "CANCELED"]);

        $order->panier->each(function (Panier $panier) {
            return $panier->update(['STATUS' => -1]);
        });
        return redirect('/articles');
    }

    public function validOrder(Request $request)
    {
        $request->validate([
            'order_id' => ['required', 'exists:orders,id']
        ]);

        $order = Order::find($request->order_id);
        $order->update(['status' => "COMPLETED"]);
        $order->panier->each(function (Panier $panier) {
            $panier->update(['STATUS' => 2]);
        });

        return redirect()->back()->with('success', 'La commande a bien été validée !');
    }
}
