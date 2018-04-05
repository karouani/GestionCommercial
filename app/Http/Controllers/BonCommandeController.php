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

class BonCommandeController extends Controller
{
    public function addBonCommande(Request $request)
    { 
        
        $bonCommande = new BonCommande();
 
                $bonCommande->reference_bc = $request->bonCommande['reference_bc'];
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
            ->select('commandes.*', 'articles.designation')
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
     

    
}
