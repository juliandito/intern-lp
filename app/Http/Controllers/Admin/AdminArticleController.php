<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\ArticleLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class AdminArticleController extends Controller
{

    private $nav_tree = "articles";


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::select([
            'id',
            'admin_id',
            'title',
            'slug',
            'status',
            'created_at',
        ])
        ->orderBy('id', 'DESC')
        ->get();

        $data = [
            'nav_tree' => $this->nav_tree,
            'articles' => $articles,
        ];

        return view('admin.pages.article.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'nav_tree' => $this->nav_tree,
        ];

        return view('admin.pages.article.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => 'kolom :attribute harus diisi',
            'unique' => ':attribute sudah terpakai',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:articles,slug',
            'header_image' => 'required',
            'content' => 'required',
            'save_as' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $header_image = $request->file('header_image');
            $file_name = time() . '-' . $header_image->getClientOriginalName();

            $storage = Storage::putFileAs('public/articles/assets', $header_image, $file_name, 'public');
            $storage_path = 'storage/articles/assets/' . time() . '-' . $header_image->getClientOriginalName();
            $asset_full_path = asset($storage_path);

            $article = Article::create([
                'admin_id' => Auth::user()->id,
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'thumbnail_image' => $asset_full_path,
                'content' => $request->input('content'),
                'status' => $request->input('save_as'),
            ]);

            $success_message = 'Artikel disimpan dengan status ' . strtoupper($request->input('save_as'));
            return redirect()->route('admin.articles.all')->with('success', $success_message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);

        $data = [
            'nav_tree' => $this->nav_tree,
            'article' => $article,
        ];

        return view('admin.pages.article.edit', $data);
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
        $article = Article::findOrFail($id);

        $messages = [
            'required' => 'kolom :attribute harus diisi',
            'unique' => ':attribute sudah terpakai',
        ];

        if ($article->slug == $request->input('slug')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required',
                'save_as' => 'required',
            ], $messages);
        } else {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'slug' => 'required|unique:articles,slug',
                'content' => 'required',
                'save_as' => 'required',
            ], $messages);
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $header_image = $request->file('header_image');

            if (isset($header_image)) {
                $file_name = time() . '-' . $header_image->getClientOriginalName();

                $storage = Storage::putFileAs('public/articles/assets', $header_image, $file_name, 'public');
                $storage_path = 'storage/articles/assets/' . time() . '-' . $header_image->getClientOriginalName();
                $asset_full_path = asset($storage_path);

                $article = Article::where('id', '=', $id)->update([
                    'title' => $request->input('title'),
                    'slug' => $request->input('slug'),
                    'thumbnail_image' => $asset_full_path,
                    'content' => $request->input('content'),
                    'status' => $request->input('save_as'),
                ]);
            } else {
                $article = Article::where('id', '=', $id)->update([
                    'title' => $request->input('title'),
                    'slug' => $request->input('slug'),
                    'content' => $request->input('content'),
                    'status' => $request->input('save_as'),
                ]);
            }

            $success_message = 'Artikel diupdate dengan status ' . strtoupper($request->input('save_as'));
            return redirect()->back()->with('success', $success_message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $delete_article_like = ArticleLike::destroy($article->like->toArray());
        $delete_article_comment = ArticleComment::destroy($article->comment->toArray());

        $article->delete();
        return redirect()->back()->with('success', 'Artikel berhasil dihapus!');
    }

    /**
     * Handle upload article content images from tinyMCE editor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handle_tinymce_image_upload(Request $request)
    {
        $image = $request->file('file');
        $file_name = time() . '-' . $image->getClientOriginalName();

        $storage = Storage::putFileAs('public/articles/assets', $image, $file_name, 'public');
        $storage_path = 'storage/articles/assets/' . time() . '-' . $image->getClientOriginalName();

        $asset_full_path = asset($storage_path);
        return response()->json([
            'location' => $asset_full_path
        ]);
    }
}
