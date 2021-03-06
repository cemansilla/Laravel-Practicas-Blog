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
    /*
    // Ejemplo de llamado de comandos Artisan (módulo 12.3)
    Artisan::call('user:mail', [
        'id' => 3,
        '--flag' => 'Test'
    ]);
    */

    return view('welcome');
})->middleware('language');

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'verified'], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('posts', 'PostController');
    Route::get('/my/posts', 'PostController@myPosts')->name('posts.my');
});

use App\Jobs\UserEmailWelcome;
Route::get('/mail', function(){
    UserEmailWelcome::dispatch(App\User::find(1));

    return "Done!";
});