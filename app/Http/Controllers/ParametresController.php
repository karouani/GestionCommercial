<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Famille_article;
use App\Tva;
use App\Statu;

class ParametresController extends Controller
{

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
    $statu->save();
    return Response()->json(['etat' => true]);
}


function  getStatus(){
$listeStatus = Statu::all();
return Response()->json(['status' => $listeStatus  ]);
}

public function deleteStatu($id_status){
$statu = Statu::find($id_status);
$statu->delete();
return Response()->json(['delete' => true]);
}



}
