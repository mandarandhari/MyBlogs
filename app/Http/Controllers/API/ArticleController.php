<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Article;

class ArticleController extends Controller
{
    public function get_latest_articles()
    {
        $articles = Article::orderBy('id', 'desc')->limit(5)->get(['id', 'title', 'url', 'description', 'is_premium', 'created_at']);

        return response()->json([
            'articles' => $articles
        ]);
    }

    public function get_articles()
    {
        $articles = Article::select(['id', 'title', 'url', 'description', 'is_premium', 'created_at'])->orderBy('id', 'desc')->paginate(5);

        return response()->json([
            'articles' => $articles
        ]);
    }
}
