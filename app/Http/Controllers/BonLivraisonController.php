<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bonlivraison;
use App\Facture;
use App\Statu;
use App\Commande;
use App\Article;
use App\Mode_paiement;
use App\Compte;
use App\Tva;
use Auth;
use PDF;

class BonLivraisonController extends Controller
{
    public $template;

    public function updateStatusBL(Request $request){
        //dd($request->id_devis);
              $bonlivraison = Bonlivraison::find($request->id_bl);
              $bonlivraison->fk_status_bl = $request->fk_status_bl;
              $bonlivraison->save();
              return Response()->json(['etat' => true]);
          }


    public function addBonLivraison(Request $request)
    { 
      
        
        $bonLivraison = new BonLivraison();
 
                $bonLivraison->reference_bl = $request->bonLivraison['reference_bl'];
                $bonLivraison->fk_bonCommande = $request->bonLivraison['fk_bonCommande'];                
                $bonLivraison->date_bl = $request->bonLivraison['date_bl'];
                $bonLivraison->type_operation_bl = "vente";
                $bonLivraison->objet_bl = $request->bonLivraison['objet_bl'];
                $bonLivraison->date_emission_bl = $request->bonLivraison['date_emission_bl'];
                $bonLivraison->remise_total_bl = $request->bonLivraison['remise_total_bl'];
                $bonLivraison->majoration_bl = $request->bonLivraison['majoration_bl'];
                $bonLivraison->date_limit_bl = $request->bonLivraison['date_limit_bl'];
                $bonLivraison->introduction_bl = $request->bonLivraison['introduction_bl'];
                $bonLivraison->conditions_reglements_bl=$request->bonLivraison['conditions_reglements_bl'];
                $bonLivraison->notes_bl = $request->bonLivraison['notes_bl'];
                $bonLivraison->accompte_bl= $request->bonLivraison['accompte_bl'];
                $bonLivraison->fk_status_bl = $request->bonLivraison['fk_status_bl'];
                $bonLivraison->fk_compte_bl = $request->bonLivraison['fk_compte_bl'];
                $bonLivraison->adresse_bl = $request->bonLivraison['adresse_bl'];
                

                $bonLivraison->total_ht_bl = $request->bonLivraison['total_ht_bl'];
                $bonLivraison->remise_ht_bl = $request->bonLivraison['remise_ht_bl'];
                $bonLivraison->montant_net_bl = $request->bonLivraison['montant_net_bl'];
                $bonLivraison->tva_montant_bl = $request->bonLivraison['tva_montant_bl'];
                $bonLivraison->montant_ttc_bl = $request->bonLivraison['montant_ttc_bl'];
                $bonLivraison->total_lettre = $request->bonLivraison['total_lettre'];
                $bonLivraison->montant_reste_bl = $request->bonLivraison['montant_reste_bl'];
                $bonLivraison->adresse_facture_bl = $request->bonLivraison['adresse_facture_bl'];
               
                
                
                
                $bonLivraison->fk_user_bl = Auth::user()->id;
                $bonLivraison->save();

                $this->addCommandes_bl($request);
                $this->addModePaiement_bl($request);
                 return Response()->json(['etat' => true]);
            
    }
    public function UpdateBonLivraison(Request $request)
    { 
        $bonLivraison = BonLivraison::where('reference_bl',$request->bonLivraison['reference_bl'])->update([
        'date_bl' => $request->bonLivraison['date_bl'],
        'type_operation_bl' => "achat",
        'objet_bl' => $request->bonLivraison['objet_bl'],
        'date_emission_bl' => $request->bonLivraison['date_emission_bl'],
        'remise_total_bl' => $request->bonLivraison['remise_total_bl'],
        'majoration_bl' => $request->bonLivraison['majoration_bl'],
        'date_limit_bl' => $request->bonLivraison['date_limit_bl'],
        'introduction_bl' => $request->bonLivraison['introduction_bl'],
        'conditions_reglements_bl' => $request->bonLivraison['conditions_reglements_bl'],
        'notes_bl' => $request->bonLivraison['notes_bl'],
        'accompte_bl' => $request->bonLivraison['accompte_bl'],
        'fk_status_bl' => $request->bonLivraison['fk_status_bl'],
        'fk_compte_bl' => $request->bonLivraison['fk_compte_bl'],
        'adresse_bl' => $request->bonLivraison['adresse_bl'],
        'total_ht_bl' => $request->bonLivraison['total_ht_bl'],
        'remise_ht_bl' => $request->bonLivraison['remise_ht_bl'],
        'montant_net_bl' => $request->bonLivraison['montant_net_bl'],
        'tva_montant_bl' => $request->bonLivraison['tva_montant_bl'],
        'montant_ttc_bl' => $request->bonLivraison['montant_ttc_bl'],
        'total_lettre' => $request->bonLivraison['total_lettre'],
        'montant_reste_bl' => $request->bonLivraison['montant_reste_bl'],
        'adresse_facture_bl' => $request->bonLivraison['adresse_facture_bl'],
        'fk_user_bl' => Auth::user()->id
        ]);
        

                $this->updateCommandes_bl($request);
                $this->updateModePaiement_bl($request);
                return Response()->json(['etat' => true]);
            
    }

    function updateCommandes_bl($request){

        for($i=0;$i<count($request->suppBonLivraisons);$i++){
            $commande = Commande::find($request->suppBonLivraisons[$i]['id_cmd']);
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
            "fk_article" => $request->commandes[$i]['fk_article'],
            "fk_tva_cmd" => $request->commandes[$i]['fk_tva_cmd'],
            "total_ht_cmd" => $request->commandes[$i]['totalHT'],
            "description_article" => $request->commandes[$i]['description_article'],
            ]);
                }
            }

    }

    function updateModePaiement_bl($request){

        $bonLivraison = Mode_paiement::where('id_modeP',$request->modePaiements['id_modeP'])->update([
        "reference_paiement" => $request->modePaiements['reference_paiement'],
        "date_paiement" => $request->modePaiements['date_paiement'],
        "fk_type_paiement" => $request->modePaiements['fk_type_paiement'],   
         ]);


    }






    public function countBonLivraisons(){
        $count = Bonlivraison::withTrashed()->where('type_operation_bl','=','vente')->count();
       
        $count ++;
        return Response()->json(['count' => $count]);
    }




        // ajouter les commandes de devis
    public function addCommandes_bl(Request $request)
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
        $commande->description_article=$request->commandes[$i]['description_article'];
        
                $commande->save();
           }
                // return Response()->json(['etat' => true]);
            
    }
  

    public function getPrixArticle_bl($fk_article){
       $commande=Commande::find($fk_article);
       $article=Article::leftJoin('tvas', 'articles.fk_tva_applicable', '=', 'tvas.id_tva')
       ->select('articles.*', 'tvas.taux_tva')
       ->where('articles.id_article','=',$fk_article)->get();
        return Response()->json(['article' => $article ]);
     }


     
      // ajouter mode de paiement de devis
      public function addModePaiement_bl(Request $request)
      { 
          
          $modeP = new Mode_paiement();
   
                  $modeP->reference_paiement = $request->modePaiements['reference_paiement'];
                  $modeP->date_paiement = $request->modePaiements['date_paiement'];
                  $modeP->fk_type_paiement = $request->modePaiements['fk_type_paiement'];
                  $modeP->fk_document = $request->modePaiements['fk_document'];
                  
                  $modeP->save();
               
                 //  return Response()->json(['etat' => true]);
              
      }


      public function getCommandes_bl($fk_document){
        $commandes= Commande::leftJoin('articles', 'commandes.fk_article', '=', 'articles.id_article')
            ->leftJoin('tvas', 'commandes.fk_tva_cmd', '=', 'tvas.id_tva')
            ->select('commandes.*', 'articles.designation','tvas.taux_tva')
            ->where('fk_document', $fk_document)->get();
        return Response()->json(['commandes' => $commandes]);

     }

     public function getPaiement_bl($fk_document){
        $modePaiement= Mode_paiement::where('fk_document', $fk_document)->get();
        return Response()->json(['modePaiement' => $modePaiement ]);
     }
     public function tauxTva_bl($fk_tva_cmd){
        $taux_tva=Tva::find($fk_tva_cmd);
        return Response()->json(['taux_tva' => $taux_tva ]);

     }

     public function getBonLivraison($id_bl){
        $bonlivraison= Bonlivraison::find($id_bl);
        return Response()->json(['bonLivraison' => $bonlivraison]);
     }

         public function getBonLivraisons(){
           
        $bonlivraisons = Bonlivraison::leftJoin('comptes', 'bonLivraisons.fk_compte_bl', '=', 'comptes.id_compte')
            ->leftJoin('status', 'bonLivraisons.fk_status_bl', '=', 'status.id_status')
            ->select('bonLivraisons.*', 'comptes.*','status.*')
            ->paginate(10);
           
         return Response()->json(['bonLivraisons' => $bonlivraisons ]);
      }
      public function  getBonLivraisonsCompte($idCompte){
           
        $bonlivraisons = Bonlivraison::leftJoin('comptes', 'bonLivraisons.fk_compte_bl', '=', 'comptes.id_compte')
            ->leftJoin('status', 'bonLivraisons.fk_status_bl', '=', 'status.id_status')
            ->select('bonLivraisons.*', 'comptes.nom_compte','status.*')
            ->where('bonLivraisons.fk_compte_bl','=', $idCompte)
            ->paginate(10);
         return Response()->json(['bonLivraisons' => $bonlivraisons , 'idCompte' => $idCompte ]);
      }
     


      public function searchBonLivraison($search_BL){
        $bonlivraisons = Bonlivraison::leftJoin('comptes', 'bonLivraisons.fk_compte_bl', '=', 'comptes.id_compte')
        ->leftJoin('status', 'bonLivraisons.fk_status_bl', '=', 'status.id_status')
        ->select('bonLivraisons.*', 'comptes.nom_compte','status.*')
        ->where('reference_bl','like', '%' .$search_BL . '%')
        ->orWhere('comptes.nom_compte','like', '%' .$search_BL . '%')
        ->paginate(10);
        return Response()->json(['bonlivraisons' => $bonlivraisons ]);
     }

    
     public function deleteBonLivraison($id_bl){

        Bonlivraison::find($id_bl)->delete();
        Commande::where('fk_document','=',$id_bl)->delete();   
        Mode_paiement::where('fk_document','=',$id_bl)->delete(); 
        
        return Response()->json(['delete' => 'true']);
     }
    
     public function showBonLivraison($reference_bl){
        // $devi= Devi::find($id_devis);
         $bonLivraison= Bonlivraison::leftJoin('comptes', 'bonLivraisons.fk_compte_bl', '=', 'comptes.id_compte')
               ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
               ->leftJoin('mode_paiements', 'bonLivraisons.reference_bl', '=', 'mode_paiements.fk_document')
               ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
               ->select('bonLivraisons.*', 'comptes.nom_compte','comptes.id_compte','macompagnies.*','mode_paiements.*','type_paiements.*')
               ->where('reference_bl', $reference_bl)->get();
         return Response()->json(['bonLivraison' => $bonLivraison ]);
      }


// POUR FACTURE
/*public function  getBL_Facture($idCompte){
           
    $bonlivraisons = Bonlivraison::leftJoin('factures', 'bonLivraisons.reference_bl', '=', 'factures.fk_bl')
        ->select('bonLivraisons.*','factures.fk_bl')
        ->where('bonLivraisons.reference_bl','!=','factures.fk_bl')
        ->get();
     return Response()->json(['bonLivraisons' => $bonlivraisons ]);
  }
*/


      public function pdf($reference_bl){
        $bonLivraison= Bonlivraison::leftJoin('comptes', 'bonLivraisons.fk_compte_bl', '=', 'comptes.id_compte')
        ->leftJoin('contacts', 'contacts.fk_compte_comp', '=', 'comptes.id_compte')
        ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
        ->leftJoin('mode_paiements', 'bonLivraisons.reference_bl', '=', 'mode_paiements.fk_document')
        ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
        ->select('bonLivraisons.*', 'comptes.*','macompagnies.*','mode_paiements.*','type_paiements.*','contacts.*')
        ->where('reference_bl', $reference_bl)->where('contacts.type_contact','=','compte')->get();

        $commandes= Commande::leftJoin('articles', 'commandes.fk_article', '=', 'articles.id_article')
        ->leftJoin('tvas', 'commandes.fk_tva_cmd', '=', 'tvas.id_tva')
        ->select('commandes.*', 'articles.designation','articles.unite','tvas.taux_tva','articles.reference_art')
        ->where('fk_document', $reference_bl)->get();
        //dd($bonLivraison);
  
        $logo = public_path().'/storage/images/'.$bonLivraison[0]->logo_comp;
        
        $headerHtml =  '<div>
        <img src="'.$logo.'" alt="test alt attribute" width="180" height="70" border="0" />
   
    </div>
        <br>
      ';



       $objethtml = '<p style="margin-top: 50px;">Objet:'. $bonLivraison[0]->objet_bl.'</p>';
        $commandesHtml ='<table border="1" style="padding: 3px 0px;" cellpadding="2">
        <thead>
                <tr style="color:white; font-size: 10pt;background-color: black;">
                
                    <th width="80">Code article</th>
                    <th  width="170">Description</th>
                    <th width="35">QTÉ</th>
                    <th width="30">UT</th>
                    <th width="60">(DH)remise</th>
                    <th width="70">PU HT</th>
                    <th width="100">TOTAL HT</th>
                    <th width="25">TVA</th>
         
                </tr>
                </thead>';
         $commandesHtml.='<tbody style="">';
        foreach ( $commandes as $commande ){
            $commandesHtml.='
            <tr style="border-bottom: 1px solid;font-size: 10pt; ">                   
                    <th align="center" width="80">'.$commande->reference_art.'</th>
                    <th  align="center"  width="170">'.$commande->description_article.'</th>
                    <th align="center" width="35">'.$commande->quantite_cmd.'</th>
                    <th align="center" width="30">'.$commande->unite.'</th>
                  
                    <th align="center" width="60">'.$commande->remise_cmd.'</th>
                    <th align="center" width="70">'.$commande->prix_ht.'</th>
                    <th align="center" width="100">'.$commande->total_ht_cmd.'</th>
                    <th align="center" width="25">'.$commande->taux_tva.'</th>

                    
                </tr> ';
            };
            $commandesHtml.='</tbody> </table>';
           //dd($commandesHtml);

        







         $infoComp = ''.$bonLivraison[0]->nom_societe_comp.' <span>
        </span>'.$bonLivraison[0]->raison_sociale_comp.'<span> 
        ICE: </span>'.$bonLivraison[0]->ICE_comp.'<span>
        RC N°: </span>'.$bonLivraison[0]->RC_comp.'<span>
        IF: </span>'.$bonLivraison[0]->IF_comp.'<span>
        patente: </span>'.$bonLivraison[0]->patente_comp.'<span>
        cnss: </span>'.$bonLivraison[0]->cnss_comp.'<span>
        compte : </span>'.$bonLivraison[0]->nom_bank_comp.'<span>
        RIB: </span>'.$bonLivraison[0]->RIB_comp.'<span>
        E-mail: </span>'.$bonLivraison[0]->email_comp.'<span>
        Site: </span>'.$bonLivraison[0]->webSite_comp.'<span>
        fax: </span>'.$bonLivraison[0]->fax_comp.'<span>
        fix: </span>'.$bonLivraison[0]->fix_comp.'<span>
        GSM: </span>'.$bonLivraison[0]->GSM_comp.'<span>';

        $calculeHtml =  '<div>
        
        <table style="padding: 3px;padding-right:5pt;">
        
        <tr>
        <td style="width:286px;">Total en lettre : '.$bonLivraison[0]->total_lettre.'</td>
        <td style="width:140px;" align="left">Total</td> <td style="width:140px;" align="right">'.$bonLivraison[0]->total_ht_bl.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Remise</td> <td style="width:140px;" align="right">'.$bonLivraison[0]->remise_ht_bl.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" class="tdC" align="left">Total HT</td> <td style="width:140px;" align="right">'.$bonLivraison[0]->montant_net_bl.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" class="tdC" align="left">TVA</td> <td  style="width:140px;" align="right">'.$bonLivraison[0]->tva_montant_bl.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Montant NET TTC (MAD)</td> <td style="width:140px;" align="right">'.$bonLivraison[0]->montant_ttc_bl.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Acompte</td> <td style="width:140px;" align="right">'.$bonLivraison[0]->accompte_bl.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Net a payer</td> <td style="width:140px;" align="right">'.$bonLivraison[0]->montant_reste_bl.'</td>
        </tr>


        </table>
        <table>
            <tr>
                <td></td>
                <td><hr></td>
            </tr>
        </table>
        
        </div>
     
        CONDITIONS :'.$bonLivraison[0]->conditions_reglements_bl.'<br>  
         NOTES : '.$bonLivraison[0]->notes_bl.'';
        
      

        $testleft = '<div> <h1> lettre </h1></div>';




        PDF::setHeaderCallback(function($pdf) {

            // Set font
            PDF::SetFont('helvetica', 'B', 20);
            // Title
            PDF::Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    
    });
    /*PDF::setData(function($infoComp) {
        $this->template = $infoComp;
    });*/

    
        $this->template = $infoComp;
       
        
    
   
    PDF::setFooterCallback(function($pdf) {
       //dd($infoComp);
      // dd($this->template);
        // Position at 15 mm from bottom
       // $pdf->SetY(-15);
        // Set font
        $pdf->SetFont('helvetica', 'I', 10);
        // Page number
        PDF::writeHTMLCell(0, 0, '',274,'<hr>', 0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0, '',275,$this->template, 0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0, '',290,'<span style="color:blue;text-align:right"> Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages().'</span>', 0, 1, 0, true, '', true);

       // $pdf->Cell(0, 10, $this->template.'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

    });


        PDF::SetMargins(5, 5, 5);
       // PDF::SetHeaderMargin(100);
        PDF::SetFooterMargin(10);

        PDF::SetFont('helvetica', 'I', 10);
        PDF::SetAutoPageBreak(TRUE, 25);

        PDF::AddPage();

        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0)

      /*  $y = PDF::getY();    
        PDF::MultiCell(40, 0, $left_column, 1, 'R', 0, 1, '', $y, true, 0);

        $y = PDF::getY() + 10;
        PDF::MultiCell(40, 0, $right_column, 1, 'R', 0, 1, '', $y, true, 0);*/


        //---------------
      //  $y = PDF::getY();    
       // PDF::MultiCell(40, 0, $headerHtml, 1, 'R', 0, 1, '', $y, true, 0);
       // $y = PDF::getY() + 10;
 //---------------
 //PDF::writeHTMLCell(0, 0, '',0,$page2 ,0, 1, 0, true, 'top', true);

    

 //PDF::writeHTMLCell(0, 0, '', $y,$headerHtml, 0, 1, 0, true, '', true);
//PDF::writeHTMLCell(0, 0, '', $y,$headerHtml, 0, 1, 0, true, '', true);


$left_column = ' <table style="padding: 0px;padding-right:10px">
<tr>
    
    <td>
    <span></span><br>
    <b> EMISSION DE LA COMMANDE </b> <br>
    '.$bonLivraison[0]->nom_societe_comp.'<br>
    Tél: '.$bonLivraison[0]->fax_comp.' /Fax: '.$bonLivraison[0]->fax_comp.'<br>
    '.$bonLivraison[0]->raison_sociale_comp.'<br>
    '.$bonLivraison[0]->adresse_comp.'<br>
    
    </td>

</tr>
</table>

<br><br>

<br><br>';
$right_column = '<br> <br><br><br> <b></b><br>
<table  cellpadding="3" style="padding: 0px;padding-right:10px">
<tr>

    <td style=" border-right:1px solid black;
    border-left:1px solid black;
    border-bottom:1px solid black;
    border-top:1px solid black;
    ">
    
    <b>'.$bonLivraison[0]->nom_compte.'</b><br>
    <span> '.$bonLivraison[0]->adresse_bl.'</span>
    
    </td>
</tr>
</table>
<br><br>

';


// BonLivraison top 
$infosBonLivraison = '<br><br><table cellpadding="3" style="padding: 0px;padding-right:10px">
<tr>
<td  rowspan="2" colspan="3" align="center"
style="
border-right:1px solid black;

border-bottom: 1px solid black;
"><h2> <b> Bon De Livraison</b></h2> </td>
<td  align="center"
style="width:70px;
border-left:1px solid black;
border-bottom: 1px solid black;
" ><h5>Numéro</h5></td>
  </tr>
  <tr>

  <td  align="center"
style="width:70px;
border-left:1px solid black;
border-bottom: 1px solid black;
" ><span style="font-size: 8px;" >'.$bonLivraison[0]->reference_bl.'</span></td>
 
</tr>
<tr>
<td  align="center" colspan="4" 
style="
border-bottom: 1px solid black;
border-top: 1px solid black;
">
<h3>Date : '.$bonLivraison[0]->date_bl.'</h3>
</td>

</tr>

<tr>
<td align="center"
style="
border-right:1px solid black;
border-bottom: 1px solid black;
border-top: 1px solid black;
"><h5>Code Client</h5></td>
<td align="center"
style="
border-right:1px solid black;
border-bottom: 1px solid black;
border-top: 1px solid black;
"><h5> Date validité</h5></td>
<td align="center"
style="
border-right:1px solid black;
border-left:1px solid black;
border-bottom: 1px solid black;
border-top: 1px solid black;
"><h5>Réglement</h5></td>
<td align="center"
style="

border-left:1px solid black;
border-bottom: 1px solid black;
border-top: 1px solid black;
"><h5>Date livraison</h5></td> 

</tr>
<tr>
<td align="center"
style="
border-right:1px solid black;

border-top: 1px solid black;
"><span style="font-size: 8px;">'.$bonLivraison[0]->reference.'</span></td> 
<td align="center"
style="
border-right:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$bonLivraison[0]->date_limit_bl.'</span></td>
<td align="center"
style="
border-right:1px solid black;
border-left:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$bonLivraison[0]->type_paiement.'</span></td>
<td align="center"
style="

border-left:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$bonLivraison[0]->date_bl.'</span></td> 

</tr>
</table>';

//PDF::SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'cap' => 'round' ,'color' => array(255, 0, 255)));
//PDF::SetFillColor(0,255,0);
// Start clipping.      


// Draw clipping rectangle to match html cell.

//PDF::RoundedRect(100, $y, 105, 35, 3.50, '1111', '<h1>test</h1>');

// Output html.
//PDF::writeHTMLCell(10, 10, 100, $y, '<h1>hhkhkhjnnknj</h1><h1>njnkjnk</h1>');

// Stop clipping.


//dd(PDF::GetStringWidth($bonLivraison[0]->reference_bl));
$y = PDF::getY(); 

PDF::writeHTMLCell(0, 0, 100,$y,$infosBonLivraison,0, 0, 0, true, 'right', true);
$y = PDF::getY(); 

if(PDF::GetStringWidth($bonLivraison[0]->reference_bl) > 27.259138888889 || PDF::GetStringWidth($bonLivraison[0]->type_paiement) > 27.259138888889 || PDF::GetStringWidth($bonLivraison[0]->reference) > 27.259138888889)
$height =($y+27.2)+4.1;
else 
$height =($y+27.2);
PDF::RoundedRect(100.8, 9.2, 102.4, $height, 3.50, '1111', '');



//RoundedRect(x, y, width, height, raduis, '1111', 'backroundColor');
//writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

PDF::writeHTMLCell(0, 0, 10,'',$headerHtml ,0, 1, 0, true, 'left', true);
$y = PDF::getY();






PDF::writeHTMLCell(80, '', 110, $y, $right_column, 0, 0, 0, true, 'right', true);
PDF::writeHTMLCell(80, '', 10, '', $left_column, 0, 1, 0, true, 'left', true);
$y = PDF::getY();  

 




 PDF::writeHTMLCell(0, 10, '',$y,$objethtml, 0, 1, 0, true, '', true);
 $y = PDF::getY();
 
 
 
 

 

 //$style2 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));

 //PDF::Line(5, 40, 5, 30, $style2);
 //$this->Line($p1x, $p1y, $p2x, $p2y, $style);



  /*  $border = array(
        'T' => array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 255)),
     );*/



//$y=78 minimum
//chaque ligne = y=6.5 ou 12
// 17 lign 
//PDF::SetLineStyle(array('width' => 0.5,'join' => 'round', 'dash' => 0, 'color' => array(255, 0, 255)));

 PDF::writeHTMLCell(0, 0,'', $y,$commandesHtml,0, 1, 0, true, '', true);

 $y = PDF::getY();
 
 //$height2 = ($y-78.72); // size nb tableau 
 $height2 = ($y-78.72);// $y pointe 78.72 quand commandes vide 
 $resul = $height2/6.5; // le nombre commandes ajouté 
//dd($resul);
 $height3 =  ((18-$resul)*18); // premier 18 nb max commandes page 1
 
 //dd($height3);
  //dd($height3);

 //dd($height2/6.5);
//dd($height2/6.5);
 //



 //dd($y);
//dd($y);

 //$height = 400-$y-12;
//dd($y);
//if($y<130)

/*else if($y<180)
$height = 380-$y*1.5;
else
$height = 300-$y*1.5;*/
 
 $commandesHtml2 = '<table style="padding: 3px 0px;"> 
 
 <thead>
           
 <tr style="color:white;font-size: 10pt; line-height:'.$height3.' px;">
      
 <th width="80" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 "> </th>
 <th  width="170" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 "> </th>
 <th width="35" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 "> </th>
 <th width="30" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 "> </th>
 <th width="60" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 "> </th>
 <th width="70" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 "> </th>
 <th width="100" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 "> </th>
 <th width="25" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 
 "> </th>

</tr>
 
 </thead> 

 </table>';
 PDF::writeHTMLCell(0, 0,'', $y,$commandesHtml2,0, 1, 0, true, '', true);
 $y = PDF::getY();



 if($y>216){ // si page 1 complet les calcule saute vers page 2
 $y = $y+80;

 }
 

 
 //PDF::writeHTMLCell(0, 140,'', $y,$commandesHtml,1, 1, 0, true, '', true);

 
 //if($y>205){
   // PDF::writeHTMLCell(0, 0, '',$y,$page2 ,0, 1, 0, true, '', true);}


  
 PDF::writeHTMLCell(0, 0, '',$y,$calculeHtml , 0, 1, 0, true, '', true);








        //$view = \View::make('pdf', array('bonLivraison' => $bonLivraison[0],'commandes' => $commandes ,'logo' => $logo ));
        //$html_content = $view->render();
   

        
        
        //PDF::SetAutoPageBreak(TRUE, 0);
         // Set font
        
     
        // PDF::SetFooterMargin(0);
         
         //PDF::writeHTML($html_content, true, false, true, false, '');
         //PDF::Cell(0, 100, 'azertyu yuiop fghjklm dfghjkl ', 0, false, 'C', 0, '', 0, false, 'T', 'M');       
         //writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
        //PDF::writeHTMLCell(80, '', '', '290', 'oooook', '', '', '', '', '', '');
       // PDF::writeHTMLCell(0, 0, '',3,$headerHtml , 0, 0, 0, false, '', true);
       
        
       // PDF::writeHTMLCell(0, 0, '',37,$objethtml, 0, 0, 0, false, '', true);
       // PDF::writeHTMLCell(0, 135,'', 70,$commandesHtml, 1, 0, 0, false, '', true);
       // PDF::writeHTMLCell(0, 0, '',130,$calculeHtml.'<br>'.$infoComp , 0, 0, 0, false, '', true);
     
     //  PDF::writeHTMLCell(0,0,'',0,$test1, 1, 0, 0, false, '', true);
       
      // PDF::writeHTMLCell(0,0,'',120,$test2,1, 0, 0, false, '', true);


        //PDF::writeHTMLCell(203, 100, '', 70,$infoComp, 1, 0, 0, false, '', true);





       //  PDF::writeHTMLCell(0, '', '', 290,$infoComp, 0, 0, 0, false, '', true);
         //PDF::SetY(0);
         $style6 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,10', 'color' => array(0, 128, 0));

         //PDF::Text(5, 249, 'Rounded rectangle examples');
         






         
         PDF::Output($reference_bl.'.pdf');
         
      }
   

}
