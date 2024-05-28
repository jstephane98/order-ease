<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Order;
use App\Models\Panier;
use App\Models\User;
use Auth;
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
            ->where('STATUS', FALSE)
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
            ]);
        }

        $paniers = Panier::with('article')
            ->where('user_id', $request->post('user_id'))
            ->where('STATUS', FALSE)
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
            ->where('STATUS', FALSE)
            ->first();

        $artPanier->delete();

        $paniers = Panier::with('article')
            ->where('user_id', $request->post('user_id'))
            ->where('STATUS', FALSE)
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

        $paniers = Panier::with('article')->where('user_id', $user->id)
            ->where('STATUS', FALSE)
            ->get();

        $totalPanier = 0;
        $quantity = $paniers->sum('QUANTITY');

        foreach ($paniers as $panier) {
            $totalPanier += $panier->QUANTITY * $panier->article->ART_P_EURO;
        }

        if ($paniers->isEmpty() and $step) {
            return redirect()->route('panier');
        }

        if ($step === "completed") {
            Auth::user()->orders()->create([
                "NBR_ART" => $quantity,
                "status" => "INCOMPLETE",
                "price" => $totalPanier
            ]);

            $paniers->each(function (Panier $panier) {
                return $panier->update(['STATUS' => TRUE]);
            });
        }

        return view('cart', compact('paniers', 'totalPanier', 'quantity', 'step'));
    }
}
