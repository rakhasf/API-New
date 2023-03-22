<?php

namespace App\Http\Middleware;

use App\Models\Article;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd("ini menggunakan middleware");

        $currentUser  = Auth::user();
        $article = Article::findOrFail($request->id);

        if ($article -> author != $currentUser->id) {
            return response()->json([
                'message' => 'data not found'
            ], 404);
        }

        // return response()->json($currentUser);

        return $next($request);
    }
}
