<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/','\\'.\App\Http\Controllers\HomeController::class);

Route::get('fb_callback','\\'.\App\Http\Controllers\HomeController::class.'@fb_callback');

Route::get('logout',function(){
    \Illuminate\Support\Facades\Auth::logout();
    return back();
});

Route::group(['middleware' => ['auth']],function(){
    Route::get('/private',function(){
        print "Private Page";
    });
});
