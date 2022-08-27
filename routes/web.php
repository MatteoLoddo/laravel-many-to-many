<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
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

    Route::get('users', 'UserController@index')->name('users.index');
    Route::get('users/{user}edit', 'UserController@edit')->name('users.edit');
    Route::get('users/{user}', 'UserController@show')->name('users.show');
    
    Route::get('users/{user}destroy' , 'UserController@destroy')->name('users.destroy');
    Route::patch("/users/{user}", "UserController@update")->name("users.update");


    // Route::resource('users', 'UserController');



});









