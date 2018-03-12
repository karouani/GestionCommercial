<?php

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
    return view('auth/login');
});

Route::get('/index', function () {
    return view('auth/index');
});

Route::get('/logout', function() {
    Auth::logout();

        return redirect('/');
});


Route::get('/login', 'HomeController@index')->name('login');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
