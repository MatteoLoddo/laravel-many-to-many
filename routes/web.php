<?php

use App\Http\Controllers\Admin\PostController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
// ROUTE PUBBLICHE
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

// ROUTE ADMIN
Route::middleware('auth')
->name('admin.')
->namespace('Admin')
->prefix('admin')
->group(function(){

    Route::get('/','HomeController@index')->name('index');

    Route::resource('posts','PostController');

});









