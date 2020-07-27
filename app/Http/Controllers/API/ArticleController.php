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

    public function get_article_by_url($url)
    {
        $article = Article::where('url', '=', $url)->first(['id', 'title', 'url', 'description', 'content', 'meta_title', 'meta_description', 'banner', 'created_at']);
        
        $prev_article = Article::where('id', '>', $article->id)->first(['id', 'title', 'url']);

        $next_article = Article::where('id', '<', $article->id)->first(['id', 'title', 'url']);

        if (isset($article->id)) {
            return response()->json([
                'success' => TRUE,
                'article' => $article,
                'prevArticle' => $prev_article,
                'nextArticle' => $next_article
            ]);
        } else {
            return response()->json([
                'success' => FALSE
            ]);
        }
    }

    public function check_article_for_premium($url)
    {
        $article = Article::where('url', '=', $url)->first(['id', 'is_premium']);

        if ( isset( $article->id ) ) {
            return response()->json([
                'success' => TRUE,
                'is_premium' => $article->is_premium
            ]);
        } else {
            return response()->json([
                'success' => FALSE
            ]);
        }        
    }
}
