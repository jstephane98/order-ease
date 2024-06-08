<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Order;
use App\Models\Panier;
use App\Models\Tiers;
use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addCart(Request $request)
    {
        $this->validate($request, [
            'ART_CODE' => ['required', 'exists:ARTICLES,ART_CODE'],
            'user_id' => ['required', 'exists:WEB_USERS,id'],
            'QUANTITY' => ['required', 'integer'],
            'INCREMENT' => ['required', 'bool']
        ], [

        ]);

        $panier = Panier::where('user_id', $request->post('user_id'))
            ->where('ART_CODE', $request->post('ART_CODE'))
            ->where('STATUS', 0)
            ->first();

        if ($panier) {
            if ($request->post('INCREMENT')) {
                $panier->increment('QUANTITY', $request->post('QUANTITY'));
            }
            else {
                $panier->update(['QUANTITY' => $request->post('QUANTITY')]);
            }
        }
        else {
            $panier = Panier::create([
                'ART_CODE' => $request->post('ART_CODE'),
                'user_id' => $request->post('user_id'),
                'QUANTITY' => $request->post('QUANTITY'),
                "STATUS" => 0
            ]);
        }

        $paniers = Panier::with('article')
            ->where('user_id', $request->post('user_id'))
            ->where('STATUS', 0)
            ->get();

        $totalPanier = 0;
        $quantity = $paniers->sum('QUANTITY');

        foreach ($paniers as $panier) {
            $totalPanier += $panier->QUANTITY * $panier->article->ART_P_EURO;
        }

        return response()->json([
            "message" => "Cet article a été ajouter avec succès ! ",
            'totalPanier' => $totalPanier,
            'quantity' => $quantity
        ], Response::HTTP_CREATED);
    }

    public function removeCart(Request $request)
    {
        $this->validate($request, [
            'ART_CODE' => ["required", "exists:ARTICLES,ART_CODE"],
            'user_id' => ['required', 'exists:WEB_USERS,id'],
        ]);

        $artPanier = Panier::where('ART_CODE', $request->post('ART_CODE'))
            ->where('user_id', $request->post('user_id'))
            ->where('STATUS', 0)
            ->first();

        $artPanier->delete();

        $paniers = Panier::with('article')
            ->where('user_id', $request->post('user_id'))
            ->where('STATUS', 0)
            ->get();

        $totalPanier = 0;
        $quantity = $paniers->sum('QUANTITY');

        foreach ($paniers as $panier) {
            $totalPanier += $panier->QUANTITY * $panier->article->ART_P_EURO;
        }

        return response()->json([
            "message" => "Article rétiré du panier",
            'totalPanier' => $totalPanier,
            'quantity' => $quantity
        ]);
    }

    public function showCart(?string $step = null)
    {
        $user = Auth::user();

        $paniers = Panier::with('article')
            ->where('user_id', $user->id)
            ->where('STATUS', 0)
            ->get();

        $totalPanier = 0;
        $quantity = $paniers->sum('QUANTITY');

        foreach ($paniers as $panier) {
            $totalPanier += $panier->QUANTITY * $panier->article->ART_P_EURO;
        }

        $orderCreated = Auth::user()->orders()
            ->where("status", "CREATED")
            ->orWhere("status", "UPDATED")
            ->orWhere("status", "CART")
            ->first();

        $tiers = collect();
        $tier = null;

        if (! $orderCreated) {

            if ($step === "livraison") {
                if ($user->type === "PARTENAIRE") {
                    return redirect()->route('panier', ['step' => 'confirmation', 'partner' => $user->tier->PCF_CODE]);
                }
                $tiers = Tiers::where('PCF_TYPE', "c")->get();
            }

            if ($step === "confirmation") {
                $order = Auth::user()->orders()->create([
                    "NBR_ART" => $quantity,
                    "status" => "CREATED",
                    "price" => $totalPanier,
                    "PCF_CODE" => \request()->get('partner')
                ]);

                foreach ($paniers as $panier) {
                    $panier->update([
                        "order_id" => $order->id
                    ]);
                }

                $tier = $order->tier;
            }
        }
        else {
            if ($step === "completed") {
                Auth::user()->orders()
                    ->where('status', "CREATED")
                    ->first()
                    ->update(['status' => "INPROGRESS"]);

                $paniers->each(function (Panier $panier) use ($orderCreated) {
                    return $panier->update([
                        'STATUS' => 1,
                    ]);
                });
            }
            elseif ($step === "confirmation") {
                $orderCreated->update([
                    "status" => "CREATED",
                    "PCF_CODE" => request()->get('partner')
                ]);

                $tier = $orderCreated->tier;
            }
            elseif ($step === "livraison") {
                $orderCreated->update(["status" => "UPDATED"]);
                $tiers = Tiers::where('PCF_TYPE', "c")->get();
                $tier = $orderCreated->tier;
            }
            else {
                if (request()->get('update')) {
                    $orderCreated->update(["status" => "CART"]);
                    $step = null;
                }
                else {
                    if ($orderCreated->status === Order::STATUS["UPDATED"]) {
                        $step = "livraison";
                        $tiers = Tiers::where('PCF_TYPE', "c")->get();
                    }
                    else {
                        $step = "confirmation";
                        $tier = $orderCreated->tier;
                    }
                }
            }
        }

        return view('cart', compact('paniers', 'totalPanier', 'quantity', 'step', 'tiers', 'tier'));
    }
}
