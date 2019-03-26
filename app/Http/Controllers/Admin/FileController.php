<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Article;

class FileController extends Controller
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
    static function uploadImage(Request $request)
    {
        $id = $request->id;
        $file = $request->file;
        $file_name = md5_file($file).'.'.$file->extension();
        //使用：默认 Storage local 存储
        $path = $file->storeAs('public/images', $file_name);

        if($id) {
            $article = Article::findOrFail($id);
            $article->cover = $file_name;
            $article->save();
        }
        return response()->json([
            'file_name' => $file_name,
            'path' => $path
        ]);
    }

    //
    static function deleteImage(Request $request)
    {
        $id = $request->query('id', null);
        $file_name = $request->query('file_name', null);
        $path = 'public/images/'.$file_name;
        $isExists = Storage::exists($path);
        if (!$isExists) {
            if($id) {
                $article = Article::findOrFail($id);
                $article->cover = null;
                $article->save();
            }
            return response()->json([
                'status' => 1,
                'message' => 'File is not exists.'
            ]);
        }
        $result = Storage::delete($path);
        if ($result) {
            if($id) {
                $article = Article::findOrFail($id);
                $article->cover = null;
                $article->save();
            }
            return response()->json([
                'status' => 1,
                'message' => 'success.'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'fail.'
            ]);
        }
    }
}
