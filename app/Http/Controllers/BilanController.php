<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charge;
use App\Facture;
use App\Bilan;
use App\Avoir_facture;
use App\Solde_init;
use App\Type_paiement;
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

    public function BilanA(Request $request){
        // dd($mois);
       
       // for($i=0;$i<$mois.length;$i++) { 
       // DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
         $totalCharge = Charge::select( DB::raw('SUM(charges.montant_ttc_ch) as total,MONTH(date_limit_ch) month'))
         ->where('charges.date_limit_ch','like',$request->annee.'-%')
         ->groupBy('month')
         ->get();
      //  }
        
      $totalAchat = Facture::select(DB::raw("SUM(factures.montant_ttc_f) as totalA, SUM(factures.tva_montant_f) as tvaA, MONTH(factures.date_limit_f) month"))
      ->where('factures.date_limit_f','like',$request->annee.'-%')
      ->where('factures.type_operation_f','=','achat')
      ->groupBy('month')     
      ->get();

     
      $totalVente = Facture::select(DB::raw("SUM(factures.montant_ttc_f) as totalV , SUM(factures.tva_montant_f) as tvaV , MONTH(factures.date_limit_f) month"))
        ->where('factures.date_limit_f','like',$request->annee.'-%')
        ->where('factures.type_operation_f','=','vente')
        ->groupBy('month')
        ->get();
       // dd($totalCharge);
        return Response()->json(['totalCharge' => $totalCharge,'totalAchat' => $totalAchat,'totalVente' => $totalVente]);
     }


     public function BilanAnnee($annee){
   // dd($mois);
   
   // for($i=0;$i<$mois.length;$i++) { 
   // DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
   $totalCharge = Charge::select( DB::raw('SUM(charges.montant_ttc_ch) as total,MONTH(charges.date_paiement_ch) month'))
   ->where('charges.date_paiement_ch','like',$annee.'-%')
   ->groupBy('month')
   ->get();
   //dd($totalCharge);
//  }
//  dd($totalCharge);
$totalAchat = Facture::leftJoin('status', 'factures.fk_status_f', '=', 'status.id_status')
->leftJoin('mode_paiements', 'factures.reference_f', '=', 'mode_paiements.fk_document')
->select(DB::raw("SUM(factures.montant_ttc_f) as totalA, SUM(factures.tva_montant_f) as tvaA, MONTH(factures.date_limit_f) month"),'status.type_status','mode_paiements.date_paiement')
->where('mode_paiements.date_paiement','like',$annee.'-%')
->where('status.type_status','=','validé')
->where('factures.type_operation_f','=','achat')
->groupBy('month')     
->get();
//dd($totalAchat);
$totalVente = Facture::leftJoin('status', 'factures.fk_status_f', '=', 'status.id_status')
->leftJoin('mode_paiements', 'factures.reference_f', '=', 'mode_paiements.fk_document')
->select(DB::raw("SUM(factures.montant_ttc_f) as totalV, SUM(factures.tva_montant_f) as tvaV, MONTH(factures.date_limit_f) month"),'status.type_status','mode_paiements.date_paiement')
->where('mode_paiements.date_paiement','like',$annee.'-%')
->where('status.type_status','=','validé')
->where('factures.type_operation_f','=','vente')
->groupBy('month')
->get();

$totalAchatAvoir = Avoir_facture::leftJoin('status', 'avoir_factures.fk_status_af', '=', 'status.id_status')
->leftJoin('mode_paiements', 'avoir_factures.reference_af', '=', 'mode_paiements.fk_document')
->select(DB::raw("SUM(avoir_factures.montant_ttc_af) as totalAA, SUM(avoir_factures.tva_montant_af) as tvaAA , MONTH(avoir_factures.date_limit_af) month"),'status.type_status','mode_paiements.date_paiement')
->where('mode_paiements.date_paiement','like',$annee.'-%')
      ->where('status.type_status','=','validé')
      ->where('avoir_factures.type_operation_af','=','achat')
      ->groupBy('month')
      ->get();

$totalVenteAvoir = Avoir_facture::leftJoin('status', 'avoir_factures.fk_status_af', '=', 'status.id_status')
->leftJoin('mode_paiements', 'avoir_factures.reference_af', '=', 'mode_paiements.fk_document')
->select(DB::raw("SUM(avoir_factures.montant_ttc_af) as totalVA, SUM(avoir_factures.tva_montant_af) as tvaVA , MONTH(avoir_factures.date_limit_af) month"),'status.type_status','mode_paiements.date_paiement')
->where('mode_paiements.date_paiement','like',$annee.'-%')
      ->where('status.type_status','=','validé')
      ->where('avoir_factures.type_operation_af','=','vente')
      ->groupBy('month')
      ->get();
      //->groupBy('charges.date_limit_ch')

$solde=Solde_init::where('solde_inits.annee_init','=',$annee)
->get();  
//dd($solde);

dd($totalAchat);
$mois=[1,2,3,4,5,6,7,8,9,10,11,12];
$sortie=array();
$test =0;
for($k=0;$k<count($mois);$k++){

for($i=0;$i<count($totalCharge);$i++){
 
  for($j=0;$j<count($totalAchat);$j++){

  $test++;
  //dd($mois[$k]);
 // dd($totalCharge[$i]->month);

  if($totalCharge[$i]->month === $mois[$k] && $totalAchat[$j]->month === $mois[$k]){
    $sortie[$mois[$k]]=$totalCharge[$i]->total + $totalAchat[$j]->totalA;

   // dd($sortie[$mois[$k]]);
   // $test++;
   //dd($sortie[$mois[$k]].'i: '.$i.' j: '.$j);
   //break 2;
   
  } 
  else if($totalCharge[$i]->month === $mois[$k] && $totalAchat[$j]->month != $mois[$k]){
    $sortie[$mois[$k]]=$totalCharge[$i]->total;
   // $test++;
   // if($k == 2){
     // dd( $sortie[$mois[$k]]);
      //dd($totalCharge[$i]->month .'==='. $mois[$k].' &&'. $totalAchat[$j]->month.' === '.$mois[$k]);
    //}
  // break 2;
  }
  //prooooooooooooooob
 /* else if($totalCharge[$i]->month !=$mois[$k] && $totalAchat[$j]->month === $mois[$k]){
    $sortie[$mois[$k]]=$totalAchat[$j]->totalA;
   // if($k == 4){
    //  dd($totalCharge[$i]->month .'==='. $mois[$k].' &&'. $totalAchat[$j]->month.' === '.$mois[$k]);
    //}
   // dd($sortie[$mois[$k]].'i: '.$i.' j: '.$j);
   
    //break 2;
  
  }*/
  else {
    if(!isset($sortie[$mois[$k]])){
      $sortie[$mois[$k]]=0;
    }
  }
   // $sortie[$mois[$k]]=0;
   // if($k == 4){
    //  dd($totalCharge[$i]->month .'==='. $mois[$k].' &&'. $totalAchat[$j]->month.' === '.$mois[$k]);
    //}
   // dd($sortie[$mois[$k]].'i: '.$i.' j: '.$j);
   
   // break 2;
  
  

}
}              }
//dd($sortie);
//dd(count($totalAchat));
//dd($test);
$sortieS=array();
for($i=1;$i<13;$i++){
for($j=0;$j<count($totalAchatAvoir);$j++){
  if($totalAchatAvoir[$j]->month === $i ){
    $sortieS[$i]= $sortie[$i] - $totalAchatAvoir[$j]->totalAA;

   break;
   
  } 
    else {
      $sortieS[$i] = $sortie[$i];
    }

}
}
$entreeE=array();
for($i=1;$i<13;$i++){
for($k=0;$k<count($totalVenteAvoir);$k++){
  
  for($j=0;$j<count($totalVente);$j++){  
  if($totalVente[$j]->month === $i && $totalVenteAvoir[$k]->month === $i ){
    $entreeE[$i]=$totalVente[$j]->totalV - $totalVenteAvoir[$k]->totalVA;

   break 2;
   
  } 
  else if($totalVente[$j]->month != $i && $totalVenteAvoir[$k]->month === $i ){
    $entreeE[$i]=$totalVenteAvoir[$k]->totalVA;

   //break;
   
  } 
  else if($totalVente[$j]->month === $i && $totalVenteAvoir[$k]->month != $i ){
    $entreeE[$i]=$totalVenteAvoir[$k]->totalVA;

   //break;
   
  } 
    else {
      if(!isset($entreeE[$i])){
      $entreeE[$i] = 0;
      }
    }

}
}
}
//dd($sortieS);
$difference=array();
for($i=1;$i<13;$i++){
    $difference[$i]=$entreeE[$i] - $sortieS[$i];



}
dd($sortie);
//dd($difference);

$soldeDepart=array();
$etat=array();
for($i=1;$i<13;$i++){
if($i === 1 ){
 // dd($solde);
  $soldeDepart[$i]=$solde[0]->solde_init;
  $etat[$i]=$soldeDepart[$i] + $difference[$i];
  
}
else{
  $soldeDepart[$i]=$etat[$i-1];
  $etat[$i]=$soldeDepart[$i] + $difference[$i];
}

}
//dd($etat);
dd($entreeE);
//dd(implode(" ",$difference));
 // dd($sortie[0].'-'.$totalVente[0]->totalV.'-'.$difference[0].'-'.$soldeDepart[0].'-'.$etat[0]);
  return Response()->json(['sortieS' => $sortieS,'entreeE' => $entreeE,'difference' => $difference,'soldeDepart' => $soldeDepart,'etat' => $etat]);

 
    }



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


   public function Bilan($annee){
    // dd($mois);
   
   // for($i=0;$i<$mois.length;$i++) { 
   // DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
     $totalCharge = Charge::select( DB::raw('SUM(charges.montant_ttc_ch) as total,MONTH(charges.date_paiement_ch) month, YEAR(charges.date_paiement_ch) year'))
     ->where('charges.date_paiement_ch','like','%2018%')
     ->groupBy('month','year')
     ->get();
     //dd($totalCharge);
  //  }
 //  dd($totalCharge);
  $totalAchat = Facture::select(DB::raw("SUM(factures.montant_ttc_f) as totalA, SUM(factures.tva_montant_f) as tvaA, MONTH(factures.date_limit_f) month, YEAR(factures.date_limit_f) year"))
  ->where('factures.date_limit_f','like',$annee.'-%')
  ->where('factures.type_operation_f','=','achat')
  ->groupBy('month','year')     
  ->get();
//dd($totalAchat);
$totalVente = Facture::select(DB::raw("SUM(factures.montant_ttc_f) as totalV , SUM(factures.tva_montant_f) as tvaV , MONTH(factures.date_limit_f) month, YEAR(factures.date_limit_f) year"))
->where('factures.date_limit_f','like',$annee.'-%')
->where('factures.type_operation_f','=','vente')
->groupBy('month','year')
->get();


$solde=Solde_init::select('solde_init')
->where('solde_init.annee_init','like',$annee.'-%')
->get();  

$mois=[1,2,3,4,5,6,7,8,9,10,11,12];
$sortie=array();
$test =0;
for($k=0;$k<count($mois);$k++){
 
  for($i=0;$i<count($totalCharge);$i++){
   
  for($j=0;$j<count($totalAchat);$j++){
    $test++;
    //dd($mois[$k]);
   // dd($totalCharge[$i]->month);

    if($totalCharge[$i]->month === $mois[$k] && $totalAchat[$j]->month === $mois[$k]){
      $sortie[$mois[$k]]=$totalCharge[$i]->total + $totalAchat[$j]->totalA;
  
     // dd($sortie[$mois[$k]]);
     // $test++;
     //dd($sortie[$mois[$k]].'i: '.$i.' j: '.$j);
     break 2;
     
    } 
    else if($totalCharge[$i]->month === $mois[$k] && $totalAchat[$j]->month != $mois[$k]){
      $sortie[$mois[$k]]=$totalCharge[$i]->total;
     // $test++;
     // if($k == 2){
       // dd( $sortie[$mois[$k]]);
        //dd($totalCharge[$i]->month .'==='. $mois[$k].' &&'. $totalAchat[$j]->month.' === '.$mois[$k]);
      //}
    // break 2;
    }
    else if($totalCharge[$i]->month !=$mois[$k] && $totalAchat[$j]->month === $mois[$k]){
      $sortie[$mois[$k]]=$totalAchat[$j]->totalA;
     // if($k == 4){
      //  dd($totalCharge[$i]->month .'==='. $mois[$k].' &&'. $totalAchat[$j]->month.' === '.$mois[$k]);
      //}
     // dd($sortie[$mois[$k]].'i: '.$i.' j: '.$j);
     
     // break 2;
    
    }
    else {
      if(!isset($sortie[$mois[$k]])){
        $sortie[$mois[$k]]=0;
      }
    }
     // $sortie[$mois[$k]]=0;
     // if($k == 4){
      //  dd($totalCharge[$i]->month .'==='. $mois[$k].' &&'. $totalAchat[$j]->month.' === '.$mois[$k]);
      //}
     // dd($sortie[$mois[$k]].'i: '.$i.' j: '.$j);
     
     // break 2;
    
    
  
  }
}              }
//dd(count($totalAchat));
//dd($test);
//dd($sortie);
$difference=array();
for($i=1;$i<13;$i++){
  for($j=0;$j<count($totalVente);$j++){
    if($totalVente[$j]->month === $i ){
      $difference[$i]=$totalVente[$j]->totalV - $sortie[$i];
  
     break;
     
    } 
      else {
        $difference[$i] = $sortie[$i];
      }
 
  }
}
//dd($totalVente);
//dd($difference);

$soldeDepart=array();
$etat=array();
for($i=1;$i<13;$i++){
  if($i === 1 ){
   // dd($solde);
    $soldeDepart[$i]=$solde[0]->solde_init;
    $etat[$i]=$soldeDepart[$i] + $difference[$i];
    
  }
  else{
    $soldeDepart[$i]=$etat[$i-1];
    $etat[$i]=$soldeDepart[$i] + $difference[$i];
  }

}
//dd($etat);
//dd($totalVente);
//dd(implode(" ",$difference));
   // dd($sortie[0].'-'.$totalVente[0]->totalV.'-'.$difference[0].'-'.$soldeDepart[0].'-'.$etat[0]);
    return Response()->json(['sortie' => $sortie,'totalVente' => $totalVente,'difference' => $difference,'soldeDepart' => $soldeDepart,'etat' => $etat]);
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
       public function getEtatChequeAchat(Request $request){
        $etatCheque = Facture::select('factures.montant_reste_f','mode_paiements.*')
        ->leftJoin('mode_paiements', 'mode_paiements.fk_document', '=', 'factures.reference_f')
        ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
        ->where('type_paiements.type_paiement','=','cheque')
        ->where('mode_paiements.date_paiement','like',$request->anneeCheque.'-%')
        ->where('factures.type_operation_f','=','achat')
        ->where('mode_paiements.reference_paiement','like','%'.$request->searchAchat.'%')
       /* ->where(function($query)use ($request)
        {
            $query->where('factures.type_operation_f','=','achat')
            ->orWhere('mode_paiements.reference_paiement','like',$request->searchAchat.'-%');
        })*/
        ->groupBy('factures.reference_f')
        ->paginate(10);
        return Response()->json(['etatCheque' => $etatCheque ]);
       }

        public function getEtatChequeCharge(Request $request){
          $charges = Charge::select('charges.*')
          ->where('charges.mode_paiement_ch','=','cheque')
          ->where('charges.date_limit_ch','like',$request->anneeCheque.'-%')
          ->where('charges.reference_ch','like','%'.$request->searchCharge.'%')
          ->paginate(10);
          return Response()->json(['charges' => $charges ]);
        }
       public function getEtatCheque(Request $request){
        
        $etatCheque = Facture::select('factures.montant_reste_f','mode_paiements.*')
        ->leftJoin('mode_paiements', 'mode_paiements.fk_document', '=', 'factures.reference_f')
        ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
        ->where('type_paiements.type_paiement','=','cheque')
        ->where('mode_paiements.date_paiement','like',$request->anneeCheque.'-%')
        
       // ->where('factures.date_limit_f','like',$request->annee.'-'.$request->mois.'-%')
        ->where('factures.type_operation_f','=','achat')
        ->groupBy('factures.reference_f')
        ->paginate(10);
      
                    
        $totalAchats = Facture::select(DB::raw("SUM(factures.montant_reste_f) as total"))
        ->leftJoin('mode_paiements', 'mode_paiements.fk_document', '=', 'factures.reference_f')
        ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
        ->where('type_paiements.type_paiement','=','cheque')
        ->where('mode_paiements.date_paiement','like',$request->anneeCheque.'-%')
       // ->where('factures.date_limit_f','like',$request->annee.'-'.$request->mois.'-%')
        ->where('factures.type_operation_f','=','achat')
        ->groupBy('factures.reference_f')
        ->get();
       
          $charges = Charge::select('charges.*')
          ->where('charges.mode_paiement_ch','=','cheque')
          ->where('charges.date_limit_ch','like',$request->anneeCheque.'-%')
          ->paginate(10);

          $totalCharge = Charge::select(DB::raw("SUM(charges.montant_ttc_ch) as total"))
          ->where('charges.mode_paiement_ch','=','cheque')
          ->where('charges.date_limit_ch','like',$request->anneeCheque.'-%')
          ->get();
          //dd($charges);
        //  return Response()->json(['charges' => $charges ]);
     
        return Response()->json(['etatCheque' => $etatCheque,'charges' => $charges ,'totalAchats' => $totalAchats,'totalCharge' => $totalCharge]);
       }
}
