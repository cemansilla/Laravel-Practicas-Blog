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

Route::get('/', function () {
    return view('welcome');
})->middleware('language');

Route::resource('posts', 'PostController');

Route::get('/users', function(){
    dd(App\User::with(['posts'])->first()->posts->first()->id);
});

// Importación para trabajo con query builder
use Illuminate\Support\Facades\DB;

Route::get('/query', function(){
    $users = DB::table('users')->where('id', '<', 8)->get();
    dd($users);
});
