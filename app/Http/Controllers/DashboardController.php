<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Facture;
use App\Commande;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   public function getArticlePlusVente(){

    $listeArticles = Article::leftJoin('commandes','commandes.fk_article','=','articles.id_article')
    ->select('articles.designation',DB::raw("SUM(commandes.quantite_cmd) as count"))
    ->where('commandes.fk_document','like', '%' .'F'. '%')
    ->groupBy('articles.designation')->orderBy('count', 'desc')->limit(6)->get();
    
    return Response()->json(['articles' => $listeArticles ]);



    //,Commande::raw("SUM(commandes.quantite_cmd) as count")
   }//where('designation','like', '%' .$desig . '%')
}
