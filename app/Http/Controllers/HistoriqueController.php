<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Historique_operation;

class HistoriqueController extends Controller
{
    public function getHistoriques(Request $request){
        $listeHistoriques = Historique_operation::select('historique_operations.*')
        ->where('historique_operations.created_at','like','%'.$request->anneeHistorique.'%')
        ->where('historique_operations.email_user','like','%'.$request->email_user.'%')
        ->orderBy('historique_operations.created_at', 'desc')
        ->paginate(10);
        return Response()->json(['listeHistoriques' => $listeHistoriques ]);
     }
    public function deleteHistorique($id_historique_operation){
        $historique = Historique_operation::find($id_historique_operation);
        $historique->delete();
        return Response()->json(['delete' => true]);
    }
}
