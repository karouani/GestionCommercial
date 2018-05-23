<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Famille_article;
use App\Tva;
use App\Statu;
use App\Type_paiement;
class ParametresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //----------------------------------------famille
    function addFamille(Request $request){
            $famille  = new  Famille_article();
            $famille->libelle_famille = $request->libelle_famille;
            $famille->save();
            return Response()->json(['etat' => true]);
    }

   function  getfamille(){
    $listeFamilles = Famille_article::all();
    
    //dd($listeArticles);
    return Response()->json(['famille_articles' => $listeFamilles ]);
   }

   public function deleteFamille($id_famille){
    // dd($id_article);
     $famille = Famille_article::find($id_famille);
     $famille->delete();
     return Response()->json(['delete' => true]);
 }




//----------------------------------------TVA

function addTva(Request $request){
    $tva  = new  Tva();
    $tva->taux_tva = $request->taux_tva;
    $tva->save();
    return Response()->json(['etat' => true]);
}


function  getTvas(){
$listeTvas = Tva::all();
return Response()->json(['tvas' => $listeTvas ]);
}

public function deleteTva($id_tva){
$tva = Tva::find($id_tva);
$tva->delete();
return Response()->json(['delete' => true]);
}

//----------------------------------------Status

function addStatu(Request $request){
    $statu  = new  Statu();
    $statu->type_status = $request->type_status;
    $statu->colorStatu = $request->colorStatu;
    $statu->save();
    return Response()->json(['etat' => true]);
}


public function  getStatus(){
$listeStatus = Statu::all();
return Response()->json(['status' => $listeStatus  ]);
}

public function getStatu($id_status){

    $statu = Statu::find($id_status);
    return Response()->json(['statu' => $statu ]);
}

public function deleteStatu($id_status){
$statu = Statu::find($id_status);
$statu->delete();
return Response()->json(['delete' => true]);
}

// type paiement 

function addTypePaiement (Request $request){
    $typePaiment  = new  Type_paiement();
    $typePaiment->type_paiement = $request->type_paiement;
    $typePaiment->save();
    return Response()->json(['etat' => true]);
}


function  getTypePaiement(){
    $listeTypePaiments = Type_paiement::all();
    
    //dd($listeArticles);
    return Response()->json(['listeTypePaiments' => $listeTypePaiments ]);
   }

   public function deleteTypePaiement($id_type_paiement){
    // dd($id_article);
     $typePaiment = Type_paiement::find($id_type_paiement);
     $typePaiment->delete();
     return Response()->json(['delete' => true]);
 }

}
