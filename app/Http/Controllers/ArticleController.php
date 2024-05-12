<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;


class ArticleController extends Controller
{
    public function store(Request $request)
    {
        if ($request->header('Authorization') !== 'Bearer ' . env('API_TOKEN')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validatedData = $request->validate([
            'slug' => 'required|string|unique:articles',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'body' => 'required|string',
            'author_full_name' => 'nullable|string',
            'cover_img_src' => 'nullable|string',
            'cover_img_alt' => 'nullable|string',
            'is_active' => 'boolean',
            'published_date' => 'required|date',
        ]);

        try {
            $validatedData['published_date'] = Carbon::parse($validatedData['published_date'])->toDateString();
            $article = Article::create($validatedData);
            return response()->json(['message' => 'Article added successfully', 'article_id' => $article->id], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create article', 'details' => $e->getMessage()], 400);
        }
    }

    public function index()
    {
        $articles = Article::all();
        return response()->json(['articles' => $articles], 200)
            ->header('Cache-Control', 'public, max-age=31536000');
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return response()->json($article);
    }

    public function update(Request $request, $id)
    {
        if ($request->header('Authorization') !== 'Bearer ' . env('API_TOKEN')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $article = Article::findOrFail($id);

        $data = $request->validate([
            'slug' => 'required|string|unique:articles,slug,' . $article->id,
            'title' => 'required|string',
            'description' => 'nullable|string',
            'body' => 'required|string',
            'author_full_name' => 'nullable|string',
            'cover_img_src' => 'nullable|string',
            'cover_img_alt' => 'nullable|string',
            'is_active' => 'boolean',
            'published_date' => 'required|date',
        ]);

        $data['published_date'] = Carbon::parse($data['published_date'])->toDateString();

        $article->update($data);        
        return response()->json(['message' => 'Article updated successfully'], 200);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->header('Authorization') !== 'Bearer ' . env('API_TOKEN')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $article = Article::findOrFail($id);

        $article->delete();

        return response()->json(['message' => 'Article deleted successfully'], 204);
    }
}
