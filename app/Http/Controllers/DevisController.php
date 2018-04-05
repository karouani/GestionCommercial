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
        //compter le numero de reference devis
    public function countDevis(){
        $count = Devi::withTrashed()->count();
        $count ++;
        return Response()->json(['count' => $count]);
    }


        // ajouter les commandes de devis
    public function addCommandes(Request $request)
    { 
        
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

                $commande->save();
           }
                 return Response()->json(['etat' => true]);
            
    }
    public function getDevisD($id_devis){
      $devi= Devi::find($id_devis);
     /* $devi= Devi::leftJoin('comptes', 'devis.fk_compte_d', '=', 'comptes.id_compte')
            ->select('devis.*', 'comptes.nom_compte')
            ->where('id_devis', $id_devis)->get();*/
      return Response()->json(['devi' => $devi ]);
   }
    public function getDevis(){
     
$devis = Devi::leftJoin('comptes', 'devis.fk_compte_d', '=', 'comptes.id_compte')
            ->select('devis.*', 'comptes.nom_compte')
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
      public function addModePaiement(Request $request)
      { 
          
          $modeP = new Mode_paiement();
   
                  $modeP->reference_paiement = $request->modePaiements['reference_paiement'];
                  $modeP->date_paiement = $request->modePaiements['date_paiement'];
                  $modeP->type_paiement = $request->modePaiements['type_paiement'];
                  $modeP->fk_document = $request->modePaiements['fk_document'];
                  $modeP->save();
               
                   return Response()->json(['etat' => true]);
              
      }


      public function getCommandes($fk_document){
        $commandes= Commande::leftJoin('articles', 'commandes.fk_article', '=', 'articles.id_article')
            ->select('commandes.*', 'articles.designation')
            ->where('fk_document', $fk_document)->get();
        return Response()->json(['commandes' => $commandes]);

     }

     public function getPaiement($fk_document){
        $modePaiement= Mode_paiement::where('fk_document', $fk_document)->get();
        return Response()->json(['modePaiement' => $modePaiement ]);
     }
     public function tauxTva($fk_tva_cmd){
        $taux_tva=Tva::find($fk_tva_cmd);
        return Response()->json(['taux_tva' => $taux_tva ]);

     }
     

}
