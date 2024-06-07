<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Famille;
use App\Models\SousFamille;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function home(Request $request)
    {
        $famille = $request->input('FAR_CODE');
        $s_famille = $request->input('SFA_CODE');
        $type_art = $request->input('ART_CODE');
        $cat_art = $request->input('ART_CAT');
        $available = $request->input('available');

        $perPage = $request->input('per_page') ?? 10;
        $page = $request->input('page') ?? 1;

        $articles = Article::with(['stock'])
            ->when($famille, function (Builder $query) use ($famille) {
                $query->where('FAR_CODE', $famille);
            })
            ->when($s_famille, function (Builder $query) use ($s_famille) {
                $query->where('SFA_CODE', $s_famille);
            })
            ->when($type_art, function (Builder $query) use ($type_art)  {
                $query->where('ART_TYPE', $type_art);
            })
            ->when($cat_art, function (Builder $query) use ($cat_art){
                $query->where('ART_CATEG', $cat_art);
            })
            ->when($available, function (Builder $query){
                $query->whereHas('stock', fn ($q) => $q->where('STK_REEL', '>', 0));
            })
            ->paginate(perPage: $perPage, page: $page);

        $current_page = $articles->currentPage();

        $filtersData = [
            "ART_TYPE" => config("search.ART_TYPE"),
            "ART_CATEG" => config("search.ART_CATEG"),
            "FART_CODE" => Famille::pluck('FAR_LIB', 'FAR_CODE')->toArray(),
            "SFA_CODE" => SousFamille::pluck('SFA_LIB', 'SFA_CODE')->toArray(),
        ];

        return view('home', compact('articles', 'filtersData', 'famille', 's_famille', 'type_art', 'cat_art', 'current_page'));
    }

    public function showArticle(Article $article)
    {
        $article->load('stock');
        $sameFamilyArticles = Article::where('FAR_CODE', $article->FAR_CODE)
            ->where('ART_CODE', '!=', $article->ART_CODE)
            ->whereHas('stock', fn ($q) => $q->where('STK_REEL', '>', 0))
            ->take(4)->get();

        return view('article', compact('article', 'sameFamilyArticles'));
    }
}
