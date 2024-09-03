<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $articles = Article::select('id', 'title', 'topic', 'content', 'created_at')->get();
        $articles = Article::select('id', 'title', 'topic', 'content', 'created_at')
            ->with('tags')
            ->paginate(10);
        $tags = Tag::select('name')->get();

        return view('articles.index', compact('articles', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.createEdit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $tags = json_decode($request->input('tags'), true);

        $article = Article::create([
            'title' => $request->title,
            'topic' => $request->topic,
            'content' => $request->content,
        ]);

        foreach ($tags as $tag) {
            Tag::firstOrCreate([
                'name' => $tag
            ]);
        }

        return to_route('articles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::find($id);

        $comments = DB::table('comments')
            ->where('article_id', $id)
            ->select('comments.comment')
            ->get();

        //タグ取得
        $tags = DB::table('article_tags')
            ->join('tags', 'id', '=', 'tag_id')
            ->where('article_tags.article_id', $id)
            ->select('tags.name')
            ->distinct()
            ->get();

        return view('articles.article', compact('article', 'comments', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::find($id);

        //タグ取得
        $tags = DB::table('article_tags')
            ->join('tags', 'id', '=', 'tag_id')
            ->where('article_tags.article_id', $id)
            ->select('tags.name')
            ->distinct()
            ->get();

        return view('articles.createEdit', compact('article', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::find($id);
        $article->title = $request->title;
        $article->topic = $request->topic;
        $article->content = $request->content;
        $article->save();

        $article->tags()->sync($request->tags);

        return to_route('articles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::find($id);
        $article->delete();

        return to_route('articles.index');
    }
}
