<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Article;
use App\Sort;

class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $search = $request->search;
        $articles = Article::when(isset($search), function($query) use ($search) {
          return $query->where('title', 'like', '%'.$search.'%');
        })->select('id', 'title', 'cover', 'description', 'created_at', 'is_draft')->orderBy('created_at', 'desc')->paginate($request->page_size);

        foreach ($articles as $article) {
          $article->content = str_limit(strip_tags($article->content_raw), 30);
          $article->created_at_date = $article->created_at->toDateString();
        }

        return $articles;
    }
    /**
     * return detail of article
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::select('id', 'title', 'cover', 'sorts_id', 'description', 'created_at', 'content_raw', 'is_draft')->findOrFail($id);
        $sorts = Sort::select('id', 'name')->orderBy('id')->get();
        return response()->json([
          'article' => $article,
          'sorts' => $sorts
        ]);
    }

    /**
     * return detail of article
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $article = new Article;
      $article->title = $request->title;
      $article->cover = $request->cover;
      $article->description = $request->description;
      $article->content_raw = $request->content_raw;
      $article->sorts_id = $request->sort;
      $article->is_draft = $request->is_draft;
      $article->save();

      $message = '创建成功！';
      return response()->json([
        'message' => $message
      ]);
    }
    
    /**
     * 更新文章 [API]
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $article = Article::findOrFail($request->id);
      $article->title = $request->title;
      $article->cover = $request->cover;
      $article->description = $request->description;
      $article->content_raw = $request->content_raw;
      $article->sorts_id = $request->sort;
      $article->is_draft = $request->is_draft ? 1 : 0;
      $article->save();

      $message = '更新成功！';
      return response()->json([
        'message' => $message
      ]);
    }
    /**
     * 删除文章 [API]
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return response()->json([
            'message' => '删除成功!'
        ]);
    }
    /**
     * 发表（或隐藏）文章 [API]
     *
     * @return \Illuminate\Http\Response
     */
    public function publish($id)
    {
        $article = Article::findOrFail($id);
        $article->is_draft = $article->is_draft ? 0 : 1;
        $article->save();
        $message = $article->is_draft ? '已切换为草稿！' : '已发表！';
        return response()->json([
            'message' => $message
        ]);
    }

    // private function handleUpdate() {}
}
