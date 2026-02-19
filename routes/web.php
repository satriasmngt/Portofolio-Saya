<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
| Kalau belum login → ke login
| Kalau sudah login → ke products
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('products.index');
    }
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| GUEST (BELUM LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [LoginController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [LoginController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| AUTH (SUDAH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    Route::resource('products', ProductController::class);


    // halaman user
    Route::get('/users', function () {
        return view('users.index');
    })->name('users.index');

    // datatable
    Route::get('/users/datatable', [UserController::class, 'datatable'])
        ->name('users.datatable');

    // store
    Route::post('/users', [UserController::class, 'store'])
        ->name('users.store');

    // update
    Route::put('/users/{id}', [UserController::class, 'update'])
        ->name('users.update');

    Route::delete('/users/{id}', [UserController::class, 'destroy'])
        ->name('users.destroy');

    Route::get(
        '/products-datatable',
        [ProductController::class, 'datatable']
    )->name('products.datatable');
});
