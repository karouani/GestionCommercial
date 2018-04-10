<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Boncommande;
use App\Statu;
use App\Commande;
use App\Article;
use App\Mode_paiement;
use App\Compte;
use App\Tva;
use Auth;
use PDF;

class BonCommandeController extends Controller
{
    public function updateStatusBC(Request $request){
        //dd($request->id_devis);
              $boncommande = Boncommande::find($request->id_bc);
              $boncommande->fk_status_bc = $request->fk_status_bc;
              $boncommande->save();
              return Response()->json(['etat' => true]);
          }


    public function addBonCommande(Request $request)
    { 
      
        
        $bonCommande = new BonCommande();
 
                $bonCommande->reference_bc = $request->bonCommande['reference_bc'];
                $bonCommande->fk_devis = $request->bonCommande['fk_devis'];                
                $bonCommande->date_bc = $request->bonCommande['date_bc'];
                $bonCommande->type_operation_bc = "achat";//$request->bonCommande['type_operation_bc'];
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
                $bonCommande->adresse_bc = $request->bonCommande['adresse_bc'];
                

                $bonCommande->total_ht_bc = $request->bonCommande['total_ht_bc'];
                $bonCommande->remise_ht_bc = $request->bonCommande['remise_ht_bc'];
                $bonCommande->montant_net_bc = $request->bonCommande['montant_net_bc'];
                $bonCommande->tva_montant_bc = $request->bonCommande['tva_montant_bc'];
                $bonCommande->montant_ttc_bc = $request->bonCommande['montant_ttc_bc'];
                
                $bonCommande->fk_user_bc = Auth::user()->id;
                $bonCommande->save();

                $this->addCommandes_bc($request);
                $this->addModePaiement_bc($request);
                 return Response()->json(['etat' => true]);
            
    }
    public function UpdateBonCommande(Request $request)
    { 
        $bonCommande = BonCommande::where('reference_bc',$request->bonCommande['reference_bc'])->update([
        'date_bc' => $request->bonCommande['date_bc'],
        'type_operation_bc' => "achat",
        'objet_bc' => $request->bonCommande['objet_bc'],
        'date_emission_bc' => $request->bonCommande['date_emission_bc'],
        'remise_total_bc' => $request->bonCommande['remise_total_bc'],
        'majoration_bc' => $request->bonCommande['majoration_bc'],
        'date_limit_bc' => $request->bonCommande['date_limit_bc'],
        'introduction_bc' => $request->bonCommande['introduction_bc'],
        'conditions_reglements_bc' => $request->bonCommande['conditions_reglements_bc'],
        'notes_bc' => $request->bonCommande['notes_bc'],
        'accompte_bc' => $request->bonCommande['accompte_bc'],
        'fk_status_bc' => $request->bonCommande['fk_status_bc'],
        'fk_compte_bc' => $request->bonCommande['fk_compte_bc'],
        'adresse_bc' => $request->bonCommande['adresse_bc'],
        'total_ht_bc' => $request->bonCommande['total_ht_bc'],
        'remise_ht_bc' => $request->bonCommande['remise_ht_bc'],
        'montant_net_bc' => $request->bonCommande['montant_net_bc'],
        'tva_montant_bc' => $request->bonCommande['tva_montant_bc'],
        'montant_ttc_bc' => $request->bonCommande['montant_ttc_bc'],
        'fk_user_bc' => Auth::user()->id
        ]);
            

                $this->updateCommandes_bc($request);
                $this->updateModePaiement_bc($request);
                return Response()->json(['etat' => true]);
            
    }

    function updateCommandes_bc($request){

        for($i=0;$i<count($request->suppBonCommandes);$i++){
            $commande = Commande::find($request->suppBonCommandes[$i]['id_cmd']);
            $commande->delete();
    
            }

            for($i=0;$i<count($request->commandes);$i++){
                if (!isset($request->commandes[$i]['id_cmd'])) {
                    $commande = new Commande();  
                    $commande->quantite_cmd=$request->commandes[$i]['quantite_cmd'];
                    $commande->remise_cmd=$request->commandes[$i]['remise_cmd'];
                    $commande->majoration_cmd=$request->commandes[$i]['majoration_cmd'];
                    $commande->prix_ht=$request->commandes[$i]['prix_ht'];
                    $commande->fk_article=$request->commandes[$i]['fk_article'];
                    $commande->fk_document=$request->commandes[$i]['fk_document'];
                    $commande->fk_tva_cmd=$request->commandes[$i]['fk_tva_cmd'];
                    $commande->total_ht_cmd=$request->commandes[$i]['totalHT'];
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
            "fk_article" => $request->commandes[$i]['fk_article'],
            "fk_tva_cmd" => $request->commandes[$i]['fk_tva_cmd'],
            "total_ht_cmd" => $request->commandes[$i]['totalHT']]);
                }
            }

    }

    function updateModePaiement_bc($request){

        $bonCommande = Mode_paiement::where('id_modeP',$request->modePaiements['id_modeP'])->update([
        "reference_paiement" => $request->modePaiements['reference_paiement'],
        "date_paiement" => $request->modePaiements['date_paiement'],
        "type_paiement" => $request->modePaiements['type_paiement'],   
         ]);


    }






    public function countBonCommandes(){
        $count = Boncommande::withTrashed()->count();
       
        $count ++;
        return Response()->json(['count' => $count]);
    }




        // ajouter les commandes de devis
    public function addCommandes_bc(Request $request)
    { 
        
           for($i=0;$i<count($request->commandes);$i++) {    
        $commande = new Commande();  
        $commande->quantite_cmd=$request->commandes[$i]['quantite_cmd'];
        $commande->remise_cmd=$request->commandes[$i]['remise_cmd'];
        $commande->majoration_cmd=$request->commandes[$i]['majoration_cmd'];
        $commande->prix_ht=$request->commandes[$i]['prix_ht'];
        $commande->fk_article=$request->commandes[$i]['fk_article'];
        $commande->fk_document=$request->commandes[$i]['fk_document'];
        $commande->fk_tva_cmd=$request->commandes[$i]['fk_tva_cmd'];
        $commande->total_ht_cmd=$request->commandes[$i]['totalHT'];

        
                $commande->save();
           }
                // return Response()->json(['etat' => true]);
            
    }
  

    public function getPrixArticle_bc($fk_article){
       $commande=Commande::find($fk_article);
       $article=Article::leftJoin('tvas', 'articles.fk_tva_applicable', '=', 'tvas.id_tva')
       ->select('articles.*', 'tvas.taux_tva')
       ->where('articles.id_article','=',$fk_article)->get();
        return Response()->json(['article' => $article ]);
     }


     
      // ajouter mode de paiement de devis
      public function addModePaiement_bc(Request $request)
      { 
          
          $modeP = new Mode_paiement();
   
                  $modeP->reference_paiement = $request->modePaiements['reference_paiement'];
                  $modeP->date_paiement = $request->modePaiements['date_paiement'];
                  $modeP->type_paiement = $request->modePaiements['type_paiement'];
                  $modeP->fk_document = $request->modePaiements['fk_document'];
                  $modeP->save();
               
                 //  return Response()->json(['etat' => true]);
              
      }


      public function getCommandes_bc($fk_document){
        $commandes= Commande::leftJoin('articles', 'commandes.fk_article', '=', 'articles.id_article')
            ->leftJoin('tvas', 'commandes.fk_tva_cmd', '=', 'tvas.id_tva')
            ->select('commandes.*', 'articles.designation','tvas.taux_tva')
            ->where('fk_document', $fk_document)->get();
        return Response()->json(['commandes' => $commandes]);

     }

     public function getPaiement_bc($fk_document){
        $modePaiement= Mode_paiement::where('fk_document', $fk_document)->get();
        return Response()->json(['modePaiement' => $modePaiement ]);
     }
     public function tauxTva_bc($fk_tva_cmd){
        $taux_tva=Tva::find($fk_tva_cmd);
        return Response()->json(['taux_tva' => $taux_tva ]);

     }

     public function getBonCommande($id_bc){
        $boncommande= Boncommande::find($id_bc);
        return Response()->json(['bonCommande' => $boncommande]);
     }

         public function getBonCommandes(){
           
        $boncommandes = Boncommande::leftJoin('comptes', 'bonCommandes.fk_compte_bc', '=', 'comptes.id_compte')
            ->leftJoin('status', 'bonCommandes.fk_status_bc', '=', 'status.id_status')
            ->select('bonCommandes.*', 'comptes.nom_compte','status.*')
            ->paginate(10);
           
         return Response()->json(['bonCommandes' => $boncommandes ]);
      }


      public function searchBonCommande($search_BC){
        $boncommandes = Boncommande::leftJoin('comptes', 'bonCommandes.fk_compte_bc', '=', 'comptes.id_compte')
        ->leftJoin('status', 'bonCommandes.fk_status_bc', '=', 'status.id_status')
        ->select('bonCommandes.*', 'comptes.nom_compte','status.*')
        ->where('reference_bc','like', '%' .$search_BC . '%')
        ->orWhere('comptes.nom_compte','like', '%' .$search_BC . '%')
        ->paginate(10);
        return Response()->json(['boncommandes' => $boncommandes ]);
     }

    
     public function deleteBonCommande($id_bc){

        Boncommande::find($id_bc)->delete();
        Commande::where('fk_document','=',$id_bc)->delete();   
        Mode_paiement::where('fk_document','=',$id_bc)->delete(); 
        
        return Response()->json(['delete' => 'true']);
     }
    
     public function showBonCommande($reference_bc){
        // $devi= Devi::find($id_devis);
         $bonCommande= Boncommande::leftJoin('comptes', 'bonCommandes.fk_compte_bc', '=', 'comptes.id_compte')
               ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
               ->leftJoin('mode_paiements', 'bonCommandes.reference_bc', '=', 'mode_paiements.fk_document')
               ->select('bonCommandes.*', 'comptes.nom_compte','comptes.id_compte','macompagnies.nom_societe','mode_paiements.*')
               ->where('reference_bc', $reference_bc)->get();
         return Response()->json(['bonCommande' => $bonCommande ]);
      }


      public function pdf($reference_bc){
        $bonCommande= Boncommande::leftJoin('comptes', 'bonCommandes.fk_compte_bc', '=', 'comptes.id_compte')
        ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
        ->leftJoin('mode_paiements', 'bonCommandes.reference_bc', '=', 'mode_paiements.fk_document')
        ->select('bonCommandes.*', 'comptes.nom_compte','comptes.id_compte','macompagnies.nom_societe','macompagnies.logo_comp','mode_paiements.*')
        ->where('reference_bc', $reference_bc)->get();

        $commandes= Commande::leftJoin('articles', 'commandes.fk_article', '=', 'articles.id_article')
        ->leftJoin('tvas', 'commandes.fk_tva_cmd', '=', 'tvas.id_tva')
        ->select('commandes.*', 'articles.designation','articles.unite','tvas.taux_tva')
        ->where('fk_document', $reference_bc)->get();
        //dd($bonCommande);
  
        $logo = public_path().'/storage/images/'.$bonCommande[0]->logo_comp;
        //dd($filename);
        //return view('pdf', ['bonCommande' => $bonCommande[0],'commandes' => $commandes]);
       /*  $options = new PDF\Options();
        $options->setDpi(150);
        $pdf= new PDF($options);*/
       // $pdf = PDF::loadView('pdf',['bonCommande' => $bonCommande[0],'commandes' => $commandes]);

        //return  $pdf->stream($reference_bc.'.pdf',array('Attachment'=>0));
       // $pdf = PDF::loadView('pdf', ['bonCommande' => $bonCommande[0],'commandes' => $commandes]);
         // return $pdf->download('invoice.pdf');
         $view = \View::make('pdf', array('bonCommande' => $bonCommande[0],'commandes' => $commandes ,'logo' => $logo ));
         $html_content = $view->render();
         
    

         //PDF::SetHeaderData('PDF_HEADER_LOGO', 'PDF_HEADER_LOGO_WIDTH', 'PDF_HEADER_TITLE'.' 001', 'PDF_HEADER_STRING', array(0,64,255), array(0,64,128));
         PDF::SetY(0, true, true);
         PDF::SetMargins(5, 0, 5);
         PDF::SetHeaderMargin(0);
  
         //PDF::SetTitle('Sample PDF');
         PDF::AddPage();
         PDF::writeHTML($html_content, true, false, true, false, '');
  
         PDF::Output($reference_bc.'.pdf');
      }

}
