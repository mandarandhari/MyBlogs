<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Article;
use App\Comment;

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
        $article = Article::where('url', '=', $url)
                    ->first(['id', 'title', 'url', 'description', 'content', 'meta_title', 'meta_description', 'banner', 'created_at']);
        
        $prev_article = Article::where('id', '>', $article->id)
                        ->first(['id', 'title', 'url']);

        $next_article = Article::where('id', '<', $article->id)
                        ->first(['id', 'title', 'url']);

        $comments = Comment::leftJoin('customers', 'articles_has_comments.customer_id', '=', 'customers.id')
                    ->where('articles_has_comments.article_id', '=', $article->id)
                    ->orderBy('articles_has_comments.id', 'desc')
                    ->get(['articles_has_comments.id', 'articles_has_comments.article_id', 'articles_has_comments.customer_id', 'articles_has_comments.comment', 'articles_has_comments.created_at', 'customers.name']);

        if (isset($article->id)) {
            return response()->json([
                'success' => TRUE,
                'article' => $article,
                'prevArticle' => $prev_article,
                'nextArticle' => $next_article,
                'comments' => $comments
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

    public function add_comment(Request $request)
    {
        if (Auth::guard('api')->user()->id) {
            $request->validate([
                'comment' => ['required', 'string', 'max:1000']
            ]);

            $comment = new Comment;

            $comment->article_id = $request->article_id;
            $comment->customer_id = Auth::guard('api')->user()->id;
            $comment->comment = $request->comment;

            if ($comment->save()) {
                return response()->json([
                    'success' => TRUE,
                    'comment' => $comment
                ]);
            } else {
                return response()->json([
                    'success' => FALSE,
                    'message' => 'An unexpected error occured'
                ]);
            }            
        } else {
            return response()->json([
                'success' => FALSE,
                'message' => 'You are not logged in'
            ]);
        }        
    }
}
