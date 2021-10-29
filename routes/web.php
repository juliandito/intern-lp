<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\{
    ArticleController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/',[
    ArticleController::class, 'index'
])->name('articles.all');

Route::group(['prefix'=>'articles'], function () {
    Route::get('/{slug}',[
        ArticleController::class, 'show'
    ])->name('articles.detail');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/{slug}/like',[
            ArticleController::class, 'store_like'
        ])->name('articles.like.store');
    });
});
