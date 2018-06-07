<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charge;

class ChargeController extends Controller
{
    public function addCharge(Request $request)
    { //dd($request);
        
                $charge = new Charge();
                
                $charge->num_facture_ch = $request->num_facture_ch;
                $charge->date_facture_ch = $request->date_facture_ch;
                $charge->nom_fournisseur_ch = $request->nom_fournisseur_ch;
                $charge->designation_ch = $request->designation_ch;
                $charge->montant_ht_ch = $request->montant_ht_ch;
                $charge->taux_tva_ch = $request->taux_tva_ch;
                $charge->tva_ch = $request->tva_ch;
                $charge->montant_ttc_ch = $request->montant_ttc_ch;
                
                $charge->mode_paiement_ch = $request->mode_paiement_ch;
                $charge->reference_ch = $request->reference_ch;
                $charge->date_paiement_ch = $request->date_paiement_ch;
                
                $charge->support_ch = $request->support_ch;
                $charge->objet_ch = $request->objet_ch;
                $charge->type_delai_ch = $request->type_delai_ch;
                $charge->date_limit_ch = $request->date_limit_ch;
              /*  $user = Auth::user();
                \Notification::send($user, new RepliedToThread($charge));*/
                $charge->save();
   
                 return Response()->json(['etat' => true]);
            
    }


    
    public function updateCharge(Request $request)
    {
        $charge = Charge::find($request->id_charge);
      
        $charge->num_facture_ch = $request->num_facture_ch;
        $charge->date_facture_ch = $request->date_facture_ch;
        $charge->nom_fournisseur_ch = $request->nom_fournisseur_ch;
        $charge->designation_ch = $request->designation_ch;
        $charge->montant_ht_ch = $request->montant_ht_ch;
        $charge->taux_tva_ch = $request->taux_tva_ch;
        $charge->tva_ch = $request->tva_ch;
        $charge->montant_ttc_ch = $request->montant_ttc_ch;
        
        $charge->mode_paiement_ch = $request->mode_paiement_ch;
        $charge->reference_ch = $request->reference_ch;
        $charge->date_paiement_ch = $request->date_paiement_ch;
        
        $charge->support_ch = $request->support_ch;
        $charge->objet_ch = $request->objet_ch;
        $charge->type_delai_ch = $request->type_delai_ch;
        $charge->date_limit_ch = $request->date_limit_ch;
  
        $charge->save();
                 return Response()->json(['etat' => true]);
    }

    public function getCharges(Request $request){
       
         $charges = Charge::where('date_facture_ch','like',$request->anneeC.'-%')
         ->orderBy('charges.created_at', 'desc')->paginate(10);
         //dd($charges);
         return Response()->json(['charges' => $charges ]);
    }
    public function getAllCharges(){
        $AllCharges = Charge::all();
        return Response()->json(['AllCharges' => $AllCharges ]);
       }

    public function getcharge($id_charge){
        $charge = Charge::find($id_charge);
       
        return Response()->json(['charge' => $charge]);
    }

    
    public function searchCharges($desig,Request $request){
      $listeCharges = Charge::where('date_facture_ch','like',$request->anneeC.'-%')
      ->where('designation_ch','like', '%' .$desig . '%')->paginate(10);
      //dd($listeCharges);
      return Response()->json(['charges' => $listeCharges ]);
    }

    public function deleteCharge($id_charge){
     
        $charge = Charge::find($id_charge);
        $charge->delete();
         
        return Response()->json(['delete' => 'ooook']);
    }
}
