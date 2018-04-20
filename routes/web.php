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
   // return "logout";
});
Route::get('/register', 'RegisterController@create')->name('Registre');

//Route::resource('article', 'ArticleController');
     

          //article
  
Route::get('/register', 'RegisterController@create')->name('Registre');


// articles 
Route::post('/addArticle','ArticleController@store');
Route::get('/getArticles','ArticleController@getArticles');
Route::post('/updateArticle','ArticleController@updateArticle');
Route::delete('/deleteArticle/{id_article}','ArticleController@deleteArticle');
Route::get('/getArticle/{id_article}','ArticleController@getArticle');
Route::get('/searchArticles/{desig}','ArticleController@searchArticles');


        //user
//user 
Route::post('/addUsers','Auth\RegisterController@store')->name('addUsers');
Route::get('/getUsers','Auth\RegisterController@getUsers');
Route::delete('/deleteUser/{id}','Auth\RegisterController@destroy');
Route::get('/editUser/{id}','Auth\RegisterController@editUser');
Route::put('/updateUser','Auth\RegisterController@updateUser');
Route::get('/getProfile','Auth\RegisterController@getProfile');


        //compagnie
Route::post('/addCompagnie','maCompagnieController@store')->name('addCompagnie');
Route::get('/getCompagnies','maCompagnieController@getCompagnies');
Route::delete('/deleteCompagnie/{id_compagnie}','maCompagnieController@deleteCompagnie');
Route::get('/getCompagnie/{id_compagnie}','maCompagnieController@getCompagnie');
Route::post('/updateCompagnie','maCompagnieController@updateCompagnie');
Route::get('/getAllCompagnies','maCompagnieController@getAllCompagnies');

Route::get('/isSuperAdmin','Auth\RegisterController@isSuperAdmin');

//parametres-----------------------------------------------------------
        //famille
Route::post('/addFamille','ParametresController@addFamille');
Route::get('/getfamilles','ParametresController@getfamille');
Route::delete('/deletefamille/{id_famille}','ParametresController@deleteFamille');
        //tva 
Route::post('/addTva','ParametresController@addTva');
Route::get('/getTvas','ParametresController@getTvas');
Route::delete('/deleteTva/{id_tva}','ParametresController@deleteTva');
        //Status 
Route::post('/addStatu','ParametresController@addStatu');
Route::get('/getStatus','ParametresController@getStatus');
Route::get('/getStatu/{id_status}','ParametresController@getStatu');
Route::delete('/deleteStatu/{id_status}','ParametresController@deleteStatu');
        //type paiement
Route::post('/addTypePaiement','ParametresController@addTypePaiement');
Route::get('/getTypePaiement','ParametresController@getTypePaiement');
Route::delete('/deleteTypePaiement/{id_type_paiement}','ParametresController@deleteTypePaiement');
 //---------------------------------------------------------------------       

                //Devis
        // ajouter devis,commande devis, et mode paiement de devis
Route::post('/addDevis','DevisController@addDevis')->name('addDevis');
Route::get('/countDevis','DevisController@countDevis');
Route::get('/getPrixArticle/{fk_article}','DevisController@getPrixArticle');
Route::get('/getDevis','DevisController@getDevis');
Route::get('/getDevisD/{id_devis}','DevisController@getDevisD');
Route::get('/getCommandes/{fk_document}','DevisController@getCommandes');
Route::get('/getPaiement/{fk_document}','DevisController@getPaiement');
Route::get('/tauxTva/{fk_tva_cmd}','DevisController@tauxTva');
Route::post('/updateDevis','DevisController@updateDevis');
Route::delete('/deleteDevis/{id_devis}','DevisController@deleteDevis');
Route::get('/searchDevis/{search_D}','DevisController@searchDevis');
Route::post('/updateStatusDevis','DevisController@updateStatusDevis');

Route::get('/pdf_d/{reference_d}','DevisController@pdf_d');

//----------------------------------------------------------------------
//Compte 
Route::post('/addCompte','CompteController@addCompte');
Route::get('/getComptes','CompteController@getComptes');
Route::post('/updateCompte','CompteController@updateCompte');
Route::delete('/deleteCompte/{id_compte}','CompteController@deleteCompte');
Route::get('/getCompte/{id_compte}','CompteController@getCompte');
Route::get('/searchComptes/{nomCompte}','CompteController@searchComptes');
     
    // compte: client recupere pour les commandes
Route::get('/getClients','CompteController@getClients');
Route::get('/getClient/{id_compte}','CompteController@getClient');

//contact 
Route::post('/addContact','CompteController@addContact');
Route::get('/updateContact','CompteController@updateContact');
Route::get('/getContacts/{fk_compte}','CompteController@getContacts');
Route::get('/getContactPaginate/{fk_compte}','CompteController@getContactPaginate');
// condition facture
Route::post('/addCFacture','CompteController@addCondtionFacture');
Route::post('/updateCFacture','CompteController@updateCondtionFacture');
Route::get('/getCFacture/{fk_compte}','CompteController@getCondtionFacture');

      // compte: remise recupere pour devis
Route::get('/getRemise/{fk_compte}','CompteController@getRemise');


     // bonCommande 
Route::post('/addBonCommande','BonCommandeController@addBonCommande');
Route::get('/countBonCommandes','BonCommandeController@countBonCommandes');
Route::get('/getPrixArticle_bc/{fk_article}','BonCommandeController@getPrixArticle_bc');
Route::get('/getCommandes_bc/{fk_document}','BonCommandeController@getCommandes_bc');
Route::get('/getPaiement_bc/{fk_document}','BonCommandeController@getPaiement_bc');
Route::get('/tauxTva_bc/{id_tva}','BonCommandeController@tauxTva_bc');

Route::get('/getBonCommandes','BonCommandeController@getBonCommandes');
Route::get('/getBonCommande/{id_bc}','BonCommandeController@getBonCommande');
Route::get('/searchBonCommande/{search_BC}','BonCommandeController@searchBonCommande');
Route::get('/getBonCommandesCompte/{idCompte}','BonCommandeController@getBonCommandesCompte');



Route::delete('/deleteBonCommande/{id_bc}','BonCommandeController@deleteBonCommande');
Route::get('/showBonCommande/{reference_bc}','BonCommandeController@showBonCommande');
Route::post('/UpdateBonCommande','BonCommandeController@UpdateBonCommande');


Route::get('/pdf/{reference_bc}','BonCommandeController@pdf');

Route::post('/updateStatusBC','BonCommandeController@updateStatusBC');

Auth::routes();





