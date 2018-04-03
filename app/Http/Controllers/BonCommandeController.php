<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BonCommande;


class BonCommandeController extends Controller
{
    public function addBonCaommande(Request $request)
    { 
        
        $bonCommande = new BonCommande();
 
                $bonCommande->reference_bc = $request->bonCommande['reference_bc'];
                $bonCommande->date_bc = $request->bonCommande['date_bc'];
                $bonCommande->type_operation_bc = $request->bonCommande['type_operation_bc'];
                $bonCommande->objet_bc = $request->bonCommande['objet_bc'];
                $bonCommande->date_emission_bc = $request->bonCommande['date_emission_bc'];
                $bonCommande->remise_total_bc = $request->bonCommande['remise_total_bc'];
                $bonCommande->majoration_bc = $request->bonCommande['majoration_bc'];
                $bonCommande->date_limit_bc = $request->bonCommande['date_limit_bc'];
                $bonCommande->introduction_bc = $request->bonCommande['introduction_bc'];
                $bonCommande->conditions_reglements_bc=$request->bonCommande['conditions_reglements_bc'];
                $bonCommande->notes_bc = $request->bonCommande['notes_bc'];
                $bonCommande->accompte_bc= $request->bonCommande['accompte_bc'];
                $bonCommande->fk_status_bc = $request->bonCommande['fk_status_bc'];
                $bonCommande->fk_compte_bc = $request->bonCommande['fk_compte_bc'];
                $bonCommande->fk_user_bc = Auth::user()->id;
                $bonCommande->save();

              //  $this->addCommandes($request);
               // $this->addModePaiement($request);
                 return Response()->json(['etat' => true]);
            
    }
}
