<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Sort;

class BlogController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('blog.index');
    }

    public function list(Request $request)
    {
        $sort_id = $request->sort;
        $articles = Article::where('is_draft', 0)->when(isset($sort_id), function ($query) use ($sort_id) {
            return $query->where('sorts_id', $sort_id);
        })->select('id', 'title', 'cover', 'description', 'created_at', 'is_draft')->orderBy('created_at', 'desc')->paginate($request->page_size);
        return response()->json([
            'articles' => $articles
        ]);
    }

    public function show($id)
    {
        $article = Article::where('is_draft', 0)->select('id', 'title', 'cover', 'sorts_id', 'description', 'created_at', 'content_html')->findOrFail($id);
        return response()->json([
            'article' => $article
        ]);
    }

    public function sorts()
    {
        $sorts = Sort::select('id', 'name')->orderBy('id')->get();
        return response()->json([
            'sorts' => $sorts
        ]);
    }
}
