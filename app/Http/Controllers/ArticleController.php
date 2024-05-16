<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string|unique:articles',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'body' => 'required|string',
            'author_full_name' => 'nullable|string',
            'cover_img_src' => 'nullable|string',
            'cover_img_alt' => 'nullable|string',
            'is_active' => 'boolean',
            'published_date' => 'required|date',
            'read_time' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $validatedData = $validator->validated();
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
        $article = Article::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'slug' => 'required|string|unique:articles,slug,' . $article->id,
            'title' => 'required|string',
            'description' => 'nullable|string',
            'body' => 'required|string',
            'author_full_name' => 'nullable|string',
            'cover_img_src' => 'nullable|string',
            'cover_img_alt' => 'nullable|string',
            'is_active' => 'boolean',
            'published_date' => 'required|date',
            'read_time' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $data = $validator->validated();
            $data['published_date'] = Carbon::parse($data['published_date'])->toDateString();
            $article->update($data);
            return response()->json(['message' => 'Article updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update article', 'details' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        try {
            $article->delete();
            return response()->json(['message' => 'Article deleted successfully'], 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete article', 'details' => $e->getMessage()], 400);
        }
    }
}

