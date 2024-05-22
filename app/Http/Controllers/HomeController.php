<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $perpage = $request->get('per_page') ?? 10;
        $page = $request->get('page') ?? 1;

        $articles = Article::paginate(perPage: $perpage, page: $page);

        return view('home', compact('articles'));
    }

    public function showArticle(Article $article)
    {
        return view('article', compact('article'));
    }
}
