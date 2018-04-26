<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Facture;
use App\Commande;
class DashboardController extends Controller
{
   public function getArticlePlusVente(){

    $listeArticles = Article::leftJoin('commandes','commandes.fk_article','=','articles.id_article')
    ->select('articles.designation')
    ->where('commandes.fk_document','like', '%' .'F'. '%')
    ->get();
    return Response()->json(['articles' => $listeArticles ]);
    
   }//where('designation','like', '%' .$desig . '%')
}
