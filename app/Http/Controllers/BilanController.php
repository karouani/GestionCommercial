<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charge;
use App\Facture;
use App\Bilan;
use App\Avoir_facture;
use App\Solde_init;
use Illuminate\Support\Facades\DB;

class BilanController extends Controller
{
  public function getChargeMois(Request $request){
    // dd($mois);
     $charges = Charge::where('charges.date_limit_ch','like',$request->annee.'-'.$request->mois.'-%')
     ->groupBy('charges.date_limit_ch')
     ->paginate(5);

     return Response()->json(['charges' => $charges]);
  }
    public function BilanCharge(Request $request){
       // dd($mois);
        $charges = Charge::where('charges.date_limit_ch','like',$request->annee.'-'.$request->mois.'-%')
        ->groupBy('charges.date_limit_ch')
        ->get();
        $totalMois = Charge::select(DB::raw("SUM(charges.montant_ttc_ch) as total , SUM(charges.tva_ch) as tvaC"))
        ->where('charges.date_limit_ch','like',$request->annee.'-'.$request->mois.'-%')
        //->groupBy('charges.date_limit_ch')
        ->get();

        $totalAchat = Facture::select(DB::raw("SUM(factures.montant_ttc_f) as totalA, SUM(factures.tva_montant_f) as tvaA"))
        ->where('factures.date_limit_f','like',$request->annee.'-'.$request->mois.'-%')
        ->where('factures.type_operation_f','=','achat')
        //->groupBy('charges.date_limit_ch')
        ->get();

        $totalAchatAvoir = Avoir_facture::select(DB::raw("SUM(avoir_factures.montant_ttc_af) as totalAA, SUM(avoir_factures.tva_montant_af) as tvaAA"))
        ->where('avoir_factures.date_limit_af','like',$request->annee.'-'.$request->mois.'-%')
        ->where('avoir_factures.type_operation_af','=','achat')
        //->groupBy('charges.date_limit_ch')
        ->get();

        $totalVente = Facture::select(DB::raw("SUM(factures.montant_ttc_f) as totalV , SUM(factures.tva_montant_f) as tvaV"))
        ->where('factures.date_limit_f','like',$request->annee.'-'.$request->mois.'-%')
        ->where('factures.type_operation_f','=','vente')
        //->groupBy('charges.date_limit_ch')
        ->get();

        $totalVenteAvoir = Avoir_facture::select(DB::raw("SUM(avoir_factures.montant_ttc_af) as totalVA , SUM(avoir_factures.tva_montant_af) as tvaVA"))
        ->where('avoir_factures.date_limit_af','like',$request->annee.'-'.$request->mois.'-%')
        ->where('avoir_factures.type_operation_af','=','vente')
        //->groupBy('charges.date_limit_ch')
        ->get();
  //dd($totalAchat);
       
       /* $mois = Charge::where('charges.date_limit_ch','like','2018-%'.$mois)
        ->groupBy('charges.date_limit_ch')
        ->get();
        */
    

        return Response()->json(['charges' => $charges,'totalMois' => $totalMois,'totalAchat' => $totalAchat,'totalAchatAvoir'=>$totalAchatAvoir,'totalVente' => $totalVente,'totalVenteAvoir'=>$totalVenteAvoir]);
    }

  /*  public function BilanAnnee(Request $request){
        // dd($mois);
       
       // for($i=0;$i<$mois.length;$i++) { 
       // DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
         $totalCharge = Charge::select( DB::raw('SUM(charges.montant_ttc_ch) as total,MONTH(date_limit_ch) month'))
        // where('charges.date_limit_ch','like','%-'.$mois.'-%')
         ->groupBy('month')
         ->get();
      //  }
        
      $totalAchat = Facture::select(DB::raw("SUM(factures.montant_ttc_f) as totalA, SUM(factures.tva_montant_f) as tvaA, MONTH(factures.date_limit_f) month"))
      //->where('factures.date_limit_f','like','%-03-%')
      ->where('factures.type_operation_f','=','achat')
      ->groupBy('month')     
      ->get();

     
      $totalVente = Facture::select(DB::raw("SUM(factures.montant_ttc_f) as totalV , SUM(factures.tva_montant_f) as tvaV , MONTH(factures.date_limit_f) month"))
        //->where('factures.date_limit_f','like','%-'.$request->mois.'-%')
        ->where('factures.type_operation_f','=','vente')
        ->groupBy('month')
        ->get();
        return Response()->json(['totalCharge' => $totalCharge,'totalAchat' => $totalAchat,'totalVente' => $totalVente]);
     }
*/
public function verifie(Request $request){
  // dd($request->annee);
 
 // for($i=0;$i<$mois.length;$i++) { 
 // DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
   $verifie = Bilan::where('mois_b','=',$request->mois)
   ->where('annee_b','=',$request->annee)
   ->get();
   //dd($verifie);
   return Response()->json(['verifie' => $verifie]);
 }
 
 public function verifieSize(){
  // dd($request->annee);
 
 // for($i=0;$i<$mois.length;$i++) { 
 // DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
   $verifie = Bilan::count();
 
   
   return Response()->json(['verifie' => $verifie]);

  }
  
  public function solde(){
    // dd($request->annee);
   
   // for($i=0;$i<$mois.length;$i++) { 
   // DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
   $solde=Solde_init::all();   
     
     return Response()->json(['solde' => $solde]);
  
    }
  

   public function getBilan(Request $request){
    // dd($request->annee);
   
   // for($i=0;$i<$mois.length;$i++) { 
   // DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
     $bilanA = Bilan::where('annee_b','=',$request->annee)
     ->get();
     //dd($verifie);
     return Response()->json(['bilanA' => $bilanA]);
   }


       public function addBilan(Request $request)
       { 
         /*  $s=$request->params['mois'] - 1;
           $moisP = Bilan::where('mois_b','=',$s)
        ->where('annee_b','=',$request->params['annee'])
        ->get();
        dd($moisP);*/
           $bilan = new Bilan();
    
                   $bilan->mois_b = $request->params['mois'];
                   $bilan->annee_b = $request->params['annee'];
                   $bilan->credit_b = $request->params['credit'];
                   $bilan->debit_b = $request->params['debit'];
                   $bilan->difference_b = $request->params['difference'];
                   $bilan->solde_depart_b = $request->params['soldeDepart'];
                   $bilan->etat_b = $request->params['etat'];
                    
                   $bilan->save();
                    return Response()->json(['etat' => true]);
               
       }
}
