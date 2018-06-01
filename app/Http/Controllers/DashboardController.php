<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Facture;
use App\Commande;
use App\Compte;
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

   }
   public function getClientPlusVente(){

   /* $listeArticles = Article::leftJoin('commandes','commandes.fk_article','=','articles.id_article')
    ->select('articles.designation',DB::raw("SUM(commandes.quantite_cmd) as count"))
    ->where('commandes.fk_document','like', '%' .'F'. '%')
    ->groupBy('articles.designation')->orderBy('count', 'desc')->limit(6)->get();*/
   

    $listeClient = Compte::leftJoin('factures','factures.fk_compte_f','=','comptes.id_compte')
    ->select('comptes.nom_compte',DB::raw("SUM(factures.montant_reste_f) as total"))
    ->where('comptes.type_compte','=','Client')
    ->groupBy('comptes.nom_compte')->orderBy('total', 'desc')->limit(6)
    ->get();
    return Response()->json(['listeClient' => $listeClient ]);

   }
   public function getMontantFactureVenteAchat(){
    $MontantFactureVenteAchat = Facture::leftJoin('status', 'status.id_status', '=', 'factures.fk_status_f')
    ->select('factures.type_operation_f',DB::raw("SUM(factures.montant_reste_f) as total"))
    ->where('status.type_status','=','validé')
    ->groupBy('factures.type_operation_f')
    ->get();
    return Response()->json(['MontantFactureVenteAchat' => $MontantFactureVenteAchat ]);
   }
}
