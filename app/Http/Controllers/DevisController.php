<?php

namespace App\Http\Controllers;

use App\Devi;
use App\Statu;
use App\Commande;
use App\Article;
use App\Mode_paiement;
use App\Compte;
use App\Tva;
use Auth;
use PDF;
use Illuminate\Http\Request;



class DevisController extends Controller
{       // ajouter un devis
    public function addDevis(Request $request)
    { 
        
        $devi = new Devi();
 
                $devi->reference_d = $request->devis['reference_d'];
                $devi->date_d = $request->devis['date_d'];
                $devi->type_operation = $request->devis['type_operation'];
                $devi->objet_d = $request->devis['objet_d'];
                $devi->date_emission_d = $request->devis['date_emission_d'];
                $devi->remise_total_d = $request->devis['remise_total_d'];
                $devi->majoration_d = $request->devis['majoration_d'];
                $devi->date_limit_d = $request->devis['date_limit_d'];
                $devi->introduction_d = $request->devis['introduction_d'];
                $devi->conditions_reglements_d=$request->devis['conditions_reglements_d'];
                $devi->notes_d = $request->devis['notes_d'];
                $devi->adresse_d = $request->devis['adresse_d'];
                $devi->accompte_d = $request->devis['accompte_d'];
                $devi->fk_status_d = $request->devis['fk_status_d'];
                $devi->fk_compte_d = $request->devis['fk_compte_d'];
                $devi->fk_user_d = Auth::user()->id;
                
                $devi->total_ht_d = $request->devis['total_ht_d'];
                $devi->remise_ht_d = $request->devis['remise_ht_d'];
                $devi->montant_net_d = $request->devis['montant_net_d'];
                $devi->tva_montant_d = $request->devis['tva_montant_d'];
                $devi->montant_ttc_d = $request->devis['montant_ttc_d'];
                $devi->save();

                $this->addCommandes($request);
                $this->addModePaiement($request);
                 return Response()->json(['etat' => true]);
            
    }

    public function updateDevis(Request $request){

        $devi = Devi::find($request->devis['id_devis']);

                $devi->reference_d = $request->devis['reference_d'];
                $devi->date_d = $request->devis['date_d'];
                $devi->type_operation = $request->devis['type_operation'];
                $devi->objet_d = $request->devis['objet_d'];
                $devi->date_emission_d = $request->devis['date_emission_d'];
                $devi->remise_total_d = $request->devis['remise_total_d'];
                $devi->majoration_d = $request->devis['majoration_d'];
                $devi->date_limit_d = $request->devis['date_limit_d'];
                $devi->introduction_d = $request->devis['introduction_d'];
                $devi->conditions_reglements_d=$request->devis['conditions_reglements_d'];
                $devi->notes_d = $request->devis['notes_d'];
                $devi->adresse_d = $request->devis['adresse_d'];
                $devi->accompte_d = $request->devis['accompte_d'];
                $devi->fk_status_d = $request->devis['fk_status_d'];
                $devi->fk_compte_d = $request->devis['fk_compte_d'];
                $devi->fk_user_d = Auth::user()->id;
                
                $devi->total_ht_d = $request->devis['total_ht_d'];
                $devi->remise_ht_d = $request->devis['remise_ht_d'];
                $devi->montant_net_d = $request->devis['montant_net_d'];
                $devi->tva_montant_d = $request->devis['tva_montant_d'];
                $devi->montant_ttc_d = $request->devis['montant_ttc_d'];
        

        $devi->save();
        $reference_d = $devi->reference_d;
        $this->updateCommandes($request,$reference_d);
        $this->updateModePaiement($request,$reference_d);

        return Response()->json(['etat' => true]);
     }
        //compter le numero de reference devis
    public function countDevis(){
        $count = Devi::withTrashed()->count();
        $count ++;
        return Response()->json(['count' => $count]);
    }


    public function updateStatusDevis(Request $request){
  //dd($request->id_devis);
        $devi = Devi::find($request->id_devis);
                $devi->fk_status_d = $request->fk_status_d;
                $devi->save();
        return Response()->json(['etat' => true]);
    }

        // ajouter les commandes de devis
    public function addCommandes(Request $request){ 
        
           for($i=0;$i<count($request->commandes);$i++) {    
        $commande = new Commande();  
        $commande->quantite_cmd=$request->commandes[$i]['quantite_cmd'];
        $commande->remise_cmd=$request->commandes[$i]['remise_cmd'];
        $commande->majoration_cmd=$request->commandes[$i]['majoration_cmd'];
        $commande->prix_ht=$request->commandes[$i]['prix_ht'];
        $commande->total_ht_cmd=$request->commandes[$i]['total_ht_cmd'];
        $commande->fk_article=$request->commandes[$i]['fk_article'];
        $commande->fk_document=$request->commandes[$i]['fk_document'];
        $commande->fk_tva_cmd=$request->commandes[$i]['fk_tva_cmd'];
        $commande->description_article=$request->commandes[$i]['description_article'];

                $commande->save();
           }
                 return Response()->json(['etat' => true]);
            
    }

    public function updateCommandes(Request $request , $reference_d){

        for($i=0;$i<count($request->suppCommandes);$i++){
         $commande = Commande::find($request->suppCommandes[$i]['id_cmd']);
         $commande->delete();
 
         }
         for($i=0;$i<count($request->commandes);$i++){
             if (!isset($request->commandes[$i]['id_cmd'])) {
                $commande = new Commande();  
                $commande->quantite_cmd=$request->commandes[$i]['quantite_cmd'];
                $commande->remise_cmd=$request->commandes[$i]['remise_cmd'];
                $commande->majoration_cmd=$request->commandes[$i]['majoration_cmd'];
                $commande->prix_ht=$request->commandes[$i]['prix_ht'];
                $commande->total_ht_cmd=$request->commandes[$i]['total_ht_cmd'];
                $commande->fk_article=$request->commandes[$i]['fk_article'];
                $commande->fk_document=$reference_d;
                $commande->fk_tva_cmd=$request->commandes[$i]['fk_tva_cmd'];
                $commande->description_article=$request->commandes[$i]['description_article'];

                
                $commande->save();
             }    
         }
         for($i=0;$i<count($request->commandes);$i++){
             if (isset($request->commandes[$i]['id_cmd'])) {
         Commande::where('id_cmd','=', $request->commandes[$i]['id_cmd'])->update([
            "quantite_cmd" => $request->commandes[$i]['quantite_cmd'],
            "remise_cmd" => $request->commandes[$i]['remise_cmd'],
            "majoration_cmd" => $request->commandes[$i]['majoration_cmd'],
            "prix_ht" => $request->commandes[$i]['prix_ht'],
            "total_ht_cmd" => $request->commandes[$i]['total_ht_cmd'],
            "fk_article" => $request->commandes[$i]['fk_article'],
            "fk_document" => $request->commandes[$i]['fk_document'],
            "fk_tva_cmd" => $request->commandes[$i]['fk_tva_cmd'],
            "description_article" => $request->commandes[$i]['description_article'],
            ]);
             }
         }
  
      }

    
    public function getDevisD($id_devis){
     // $devi= Devi::find($id_devis);
      $devi= Devi::leftJoin('comptes', 'devis.fk_compte_d', '=', 'comptes.id_compte')
            ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
            ->leftJoin('mode_paiements', 'devis.reference_d', '=', 'mode_paiements.fk_document')
            ->leftJoin('status', 'devis.fk_status_d', '=', 'status.id_status')
            ->select('devis.*', 'comptes.nom_compte','status.*', 'macompagnies.nom_societe','mode_paiements.reference_paiement','mode_paiements.date_paiement','mode_paiements.type_paiement')
            ->where('id_devis', $id_devis)->get();
      return Response()->json(['devi' => $devi ]);
   }
    public function getDevis(){
     
$devis = Devi::leftJoin('comptes', 'devis.fk_compte_d', '=', 'comptes.id_compte')
->leftJoin('status', 'devis.fk_status_d', '=', 'status.id_status')
            ->select('devis.*', 'comptes.nom_compte','status.*')
            ->paginate(10);
           
         return Response()->json(['devis' => $devis ]);
      }


    public function getPrixArticle($fk_article){
       $commande=Commande::find($fk_article);
       $article=Article::leftJoin('tvas', 'articles.fk_tva_applicable', '=', 'tvas.id_tva')
       ->select('articles.*', 'tvas.taux_tva')
       ->where('articles.id_article','=',$fk_article)->get();
        return Response()->json(['article' => $article ]);
     }

      // ajouter mode de paiement de devis
    public function addModePaiement(Request $request) { 
          
          $modeP = new Mode_paiement();
   
                  $modeP->reference_paiement = $request->modePaiements['reference_paiement'];
                  $modeP->date_paiement = $request->modePaiements['date_paiement'];
                  $modeP->type_paiement = $request->modePaiements['type_paiement'];
                  $modeP->fk_document = $request->modePaiements['fk_document'];
                  $modeP->save();
               
                   return Response()->json(['etat' => true]);
              
    }

    public function updateModePaiement(Request $request , $reference_d){
        $modeP = Mode_paiement::find($request->modePaiements['id_modeP']);
        $modeP->reference_paiement = $request->modePaiements['reference_paiement'];
        $modeP->date_paiement = $request->modePaiements['date_paiement'];
        $modeP->type_paiement = $request->modePaiements['type_paiement'];
        $modeP->fk_document = $reference_d;
        $modeP->save();

    }


      public function deleteDevis($id_devis){

        $devis = Devi::find($id_devis);
        $devis->delete();
        $commande = Commande::where('fk_document','=',$id_devis);  
        $commande->delete();   
        $modePaiement = Mode_paiement::where('fk_document','=',$id_devis)->delete(); 
        return Response()->json(['delete' => 'true']);
     }

      public function getCommandes($fk_document){
        $commandes= Commande::leftJoin('articles', 'commandes.fk_article', '=', 'articles.id_article')
            ->leftJoin('tvas', 'commandes.fk_tva_cmd', '=', 'tvas.id_tva')
            ->select('commandes.*', 'articles.designation','tvas.taux_tva')
            ->where('fk_document', $fk_document)->get();
            //dd($commandes);
        return Response()->json(['commandes' => $commandes]);

     }
     public function searchDevis($search_D){
        $devis = Devi::leftJoin('comptes', 'devis.fk_compte_d', '=', 'comptes.id_compte')->where('reference_d','like', '%' .$search_D . '%')->orWhere('comptes.nom_compte','like', '%' .$search_D . '%')->paginate(10);
        return Response()->json(['devis' => $devis ]);
     }
     public function getPaiement($fk_document){
        $modePaiement= Mode_paiement::where('fk_document', $fk_document)->get();
        return Response()->json(['modePaiement' => $modePaiement ]);
     }
     public function tauxTva($id_tva){
        $taux_tva=Tva::find($id_tva);
        return Response()->json(['taux_tva' => $taux_tva ]);

     }

     public function pdf_d($reference_d){
        $devi= Devi::leftJoin('comptes', 'devis.fk_compte_d', '=', 'comptes.id_compte')
        ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
        ->leftJoin('mode_paiements', 'devis.reference_d', '=', 'mode_paiements.fk_document')
        ->select('devis.*', 'comptes.nom_compte','comptes.id_compte','macompagnies.nom_societe','macompagnies.logo_comp','mode_paiements.*')
        ->where('reference_d', $reference_d)->get();

        $commandes= Commande::leftJoin('articles', 'commandes.fk_article', '=', 'articles.id_article')
        ->leftJoin('tvas', 'commandes.fk_tva_cmd', '=', 'tvas.id_tva')
        ->select('commandes.*', 'articles.designation','articles.unite','tvas.taux_tva')
        ->where('fk_document', $reference_d)->get();
        //dd($bonCommande);
  
        $logo = public_path().'/storage/images/'.$devi[0]->logo_comp;
        //dd($filename);
        //return view('pdf', ['bonCommande' => $bonCommande[0],'commandes' => $commandes]);
       /*  $options = new PDF\Options();
        $options->setDpi(150);
        $pdf= new PDF($options);*/
       // $pdf = PDF::loadView('pdf',['bonCommande' => $bonCommande[0],'commandes' => $commandes]);

        //return  $pdf->stream($reference_bc.'.pdf',array('Attachment'=>0));
       // $pdf = PDF::loadView('pdf', ['bonCommande' => $bonCommande[0],'commandes' => $commandes]);
         // return $pdf->download('invoice.pdf');
         $view = \View::make('pdf_d', array('devi' => $devi[0],'commandes' => $commandes ,'logo' => $logo ));
         $html_content = $view->render();
         
    

         //PDF::SetHeaderData('PDF_HEADER_LOGO', 'PDF_HEADER_LOGO_WIDTH', 'PDF_HEADER_TITLE'.' 001', 'PDF_HEADER_STRING', array(0,64,255), array(0,64,128));
         PDF::SetY(0, true, true);
         PDF::SetMargins(5, 0, 5);
         PDF::SetHeaderMargin(0);
  
         //PDF::SetTitle('Sample PDF');
         PDF::AddPage();
         PDF::writeHTML($html_content, true, false, true, false, '');
  
         PDF::Output($reference_d.'.pdf');
      }
     

}
