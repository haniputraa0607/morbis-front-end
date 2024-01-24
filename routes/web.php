<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('logout', function(){
    session()->flush();
    return redirect('login');
});

Route::prefix('/')->group(function () {

    Route::get('login', function(){
        if(!session()->has('email')) return view('login'); else return redirect('home');
    });
    Route::post('login', [Controller::class, 'login']);

    Route::middleware(['validate_session'])->group(function () {
        Route::get('home', [Controller::class, 'home']);
        Route::get('queue/{type}', [Controller::class, 'change']);
    });
});

