<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sort;

class SortController extends Controller
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

    //
    public function index(Request $request)
    {
        $sorts = Sort::select('id', 'name', 'article_num', 'created_at')->orderBy('id')->get();
        return response()->json([
            'sorts' => $sorts
        ]);
    }

    //
    public function create(Request $request)
    {
        $sort = new Sort;
        $sort->name = $request->name;
        $sort->save();

        $message = '创建成功！';
        return response()->json([
            'message' => $message
        ]);
    }

    //
    public function update(Request $request)
    {
        $sort = Sort::findOrFail($request->id);
        $sort->name = $request->name;
        $sort->save();

        $message = '更新成功！';
        return response()->json([
            'message' => $message
        ]);
    }

    //
    public function destroy($id)
    {
        $sort = Sort::findOrFail($id);
        $sort->delete();
        return response()->json([
            'message' => '删除成功!'
        ]);
    }
}
