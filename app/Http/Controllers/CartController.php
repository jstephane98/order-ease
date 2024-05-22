<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
            'USR_NAME' => ['required', 'exists:USERS,USR_NAME'],
            'QUANTITY' => ['required', 'integer'],
            'INCREMENT' => ['required', 'bool']
        ], [

        ]);

        $panier = Panier::where('USR_NAME', $request->post('USR_NAME'))
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
                'USR_NAME' => $request->post('USR_NAME'),
                'QUANTITY' => $request->post('QUANTITY'),
            ]);
        }

        $paniers = Panier::with('article')
            ->where('USR_NAME', $request->post('USR_NAME'))
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
            'USR_NAME' => ['required', 'exists:USERS,USR_NAME'],
        ]);

        $artPanier = Panier::where('ART_CODE', $request->post('ART_CODE'))
            ->where('USR_NAME', $request->post('USR_NAME'))
            ->where('STATUS', FALSE)
            ->first();

        $artPanier->delete();

        $paniers = Panier::with('article')
            ->where('USR_NAME', $request->post('USR_NAME'))
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

        $paniers = Panier::with('article')->where('USR_NAME', $user->USR_NAME)
            ->where('STATUS', FALSE)
            ->get();

        $totalPanier = 0;
        $quantity = $paniers->sum('QUANTITY');

        foreach ($paniers as $panier) {
            $totalPanier += $panier->QUANTITY * $panier->article->ART_P_EURO;
        }

        return view('cart', compact('paniers', 'totalPanier', 'quantity', 'step'));
    }
}
