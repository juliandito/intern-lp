<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\Auth\AdminLoginController;

use App\Http\Controllers\Admin\{
    AdminDashboardController,
    AdminArticleController,
};

Auth::routes();

// ADMIN: NO AUTH
Route::group(['middleware' => 'guest:admin'], function () {

    Route::group(['prefix'=>'auth'], function () {
        Route::get('/',[
            AdminLoginController::class, 'show_login_form'
        ])->name('admin.auth.show');
        Route::post('/login', [
            AdminLoginController::class, 'login'
        ])->name('admin.auth.login');
    });

});

// ADMIN: AUTH
Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/logout',[
        AdminLoginController::class, 'logout'
    ])->name('admin.logout');

    Route::get('/dashboard', [
        AdminDashboardController::class, 'index'
    ])->name('admin.dashboard');

    Route::group(['prefix'=>'articles'], function () {
        Route::get('/',[
            AdminArticleController::class, 'index'
        ])->name('admin.articles.all');
        Route::get('/create',[
            AdminArticleController::class, 'create'
        ])->name('admin.articles.create');
        Route::post('/store',[
            AdminArticleController::class, 'store'
        ])->name('admin.articles.store');
        Route::get('/edit/{id}',[
            AdminArticleController::class, 'edit'
        ])->name('admin.articles.edit');
        Route::post('/update/{id}',[
            AdminArticleController::class, 'update'
        ])->name('admin.articles.update');
        Route::get('/delete/{id}',[
            AdminArticleController::class, 'destroy'
        ])->name('admin.articles.delete');
    });

});

// ADMIN: APIs
Route::group(['prefix'=>'api'], function () {

    Route::group(['prefix'=>'articles', 'middleware' => 'auth:admin'], function () {
        Route::post('/store-tinymce-image', [
            AdminArticleController::class, 'handle_tinymce_image_upload'
        ])->name('admin.api.articles.store-tinymce-image');
    });

});


