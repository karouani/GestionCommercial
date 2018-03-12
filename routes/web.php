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
 
Route::get('/login', 'HomeController@login')->name('login');

Route::get('/', 'HomeController@index')->name('Gcommerce');



Route::get('/logout', function() {
    Auth::logout();

        return redirect('/login');
});

Auth::routes();




