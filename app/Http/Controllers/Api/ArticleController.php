<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = \App\Models\Article::all();
 
        return $articles->toJson();
    }
 
    public function store(Request $request)
    {
        $validatedData = $request->validate([
          'title' => 'required',
          'content' => 'required',
        ]);
 
        $project = \App\Models\Article::create([
          'title' => $validatedData['title'],
          'content' => $validatedData['content'],
        ]);
 
        $msg = [
            'success' => true,
            'message' => 'Article created successfully!'
        ];
 
        return response()->json($msg);
    }
 
    public function getArticle($id) // for edit and show
    {
        $article = \App\Models\Article::findOrFail($id);
 
        return $article->toJson();
    }
 
    public function update(Request $request, $id)
    {
        $article = \App\Models\Article::findOrFail($id);

        $validatedData = $request->validate([
          'title' => 'required',
          'content' => 'required',
        ]);

        $article->title = $validatedData['title'];
        $article->content = $validatedData['content'];
        $article->save();
 
        $msg = [
            'success' => true,
            'message' => 'Article updated successfully'
        ];
 
        return response()->json($msg);
    }
 
    public function delete($id)
    {
        $article = \App\Models\Article::findOrFail($id);
        if(!empty($article)){
            $article->delete();
            $msg = [
                'success' => true,
                'message' => 'Article deleted successfully!'
            ];
            return response()->json($msg);
        } else {
            $msg = [
                'success' => false,
                'message' => 'Article deleted failed!'
            ];
            return response()->json($msg);
        }
    }
}
