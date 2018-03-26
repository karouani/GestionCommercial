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

Route::get('/login', 'HomeController@login');

Route::get('/', 'HomeController@index')->name('Gcommerce');

Route::get('/logout', function(){
    Auth::logout();
    
    return "logout";
});
Route::get('/register', 'RegisterController@create')->name('Registre');


// articles 
Route::post('/addArticle','ArticleController@store');
Route::get('/getArticles','ArticleController@getArticles');
Route::post('/updateArticle','ArticleController@updateArticle');
Route::delete('/deleteArticle/{id_article}','ArticleController@deleteArticle');
Route::get('/getArticle/{id_article}','ArticleController@getArticle');
Route::get('/searchArticles/{desig}','ArticleController@searchArticles');


//user 
Route::post('/addUsers','Auth\RegisterController@store')->name('addUsers');
Route::get('/getUsers','Auth\RegisterController@getUsers');
Route::delete('/deleteUser/{id}','Auth\RegisterController@destroy');
Route::get('/editUser/{id}','Auth\RegisterController@editUser');
Route::put('/updateUser','Auth\RegisterController@updateUser');


//parametres
        //famille
Route::post('/addFamille','ParametresController@addFamille');
Route::get('/getfamilles','ParametresController@getfamille');
Route::delete('/deletefamille/{id_famille}','ParametresController@deleteFamille');
        //tva 
Route::post('/addTva','ParametresController@addTva');
Route::get('/getTvas','ParametresController@getTvas');
Route::delete('/deleteTva/{id_tva}','ParametresController@deleteTva');
        //tva 
Route::post('/addStatu','ParametresController@addStatu');
Route::get('/getStatus','ParametresController@getStatus');
Route::delete('/deleteStatu/{id_status}','ParametresController@deleteStatu');




Auth::routes();





