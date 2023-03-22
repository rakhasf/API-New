<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleDetails;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(){
        $articles = Article::all();

        return ArticleDetails::collection($articles->loadMissing('writer:id,username',
        'comments:id,article_id,user_id,comment_content'));
    }

    public function show($id){
        $article = Article::with('writer:id,username', 'comments:id,article_id,user_id,comment_content')->findOrFail($id);
        return new ArticleDetails($article);
    }
    public function show2($id){
        $articlet = Article::findOrFail($id);
        return new ArticleDetails($article);
    }

    public function store(Request $request){
        $request -> validate([
            'title' => 'required|max:255',
            'article_content' => 'required',
        ]);

        $image = null;
        if ($request -> file) {
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            $image = $fileName. '.' .$extension;
            Storage::putFileAs('image', $request->file, $image);
        }

        $request['author'] = Auth::user()->id;

        $article = Article::create($request->all());
        return new ArticleDetails($article->loadMissing('writer:id,username'));

        
    }

    public function update(Request $request, $id){
    $request -> validate([
        'title' => 'required|max:255',
        'article_content' => 'required',
    ]);

     $image = null;
        if ($request -> file) {
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            $image = $fileName. '.' .$extension;
            Storage::putFileAs('image', $request->file, $image);
        }

    $request['image'] = $image;

    $article = Article::findOrFail($id);
    $article->update($request->all());

    return new ArticleDetails($article->loadMissing('writer:id,username'));

    }

    public function delete($id){
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json([
        'message' => "data successfully deleted"
        ]);
    }

     // https://stackoverflow.com/questions/4356289/php-random-string-generator
    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
