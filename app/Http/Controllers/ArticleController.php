<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\ArticleLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::select([
            'title',
            'slug',
            'thumbnail_image',
            'status',
            'created_at',
        ])
        ->where('status', '=', 'published')
        ->orderBy('id', 'DESC')
        ->get();

        return view('pages.article.index', [
            'articles' => $articles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $article = Article::select([
            'id',
            'title',
            'slug',
            'thumbnail_image',
            'content',
            'status',
            'created_at',
        ])
        ->where('slug', '=', $slug)
        ->first();

        if (!$article) {
            return redirect()->back();
        }

        return view('pages.article.detail', [
            'article' => $article,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_like($slug)
    {
        $article = Article::select([
            'id',
            'title',
            'thumbnail_image',
            'content',
            'status',
            'created_at',
        ])
        ->where('slug', '=', $slug)
        ->first();

        $article_like = ArticleLike::create([
            'user_id' => Auth::user()->id,
            'article_id' => $article->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil melakukan like!');
    }
}
