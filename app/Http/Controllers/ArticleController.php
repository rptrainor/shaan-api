<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'string',
            'body' => 'required|string',
            'author_full_name' => 'string',
            'cover_img_src' => 'string',
            'cover_img_alt'=> 'string',
            'is_active'=> 'boolean',
            'published_date' => 'required|string',
        ]);

        try {
            $published_date = Carbon::parse($data['published_date'])->toDateString();
            $data['published_date'] = $published_date;
        } catch (\Exception $e) {
            return response()->json(['Error' => 'Bad Request'], 400);
        }

        $article = new Article($data);

        $article->save();

        return response()->json(['message' => 'Article added successfully'], 201);
    }

    public function index()
    {
        $articles = Article::all();

        return response()->json(['articles' => $articles], 200);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $data = $request->all();

        try {
            $published_date = Carbon::parse($data['published_date'])->toDateString();
            $data['published_date'] = $published_date;
            $data['id'] = $article->id;
        } catch (\Throwable $th) {
            Log::error('Error ');
            return response()->json(['Error' => 'Bad Request'], 400);
        }

        $article->update($data);

        return response()->json(['message' => 'Article updated successfully'], 200);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        $article->delete();

        return response()->json(['message' => 'Article deleted successfully'], 200);
    }
}