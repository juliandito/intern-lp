<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\Auth\AdminLoginController;

use App\Http\Controllers\Admin\{
    AdminDashboardController,
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
});

// ADMIN: APIs
Route::group(['prefix'=>'api'], function () {


});


