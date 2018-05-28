<?php

namespace App\Http\Controllers;

use App\Facture;
use App\BonLivraison;
use App\Statu;
use App\Commande;
use App\Article;
use App\Mode_paiement;
use App\Compte;
use App\Tva;
use DB;
use Auth;
use PDF;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function deleteNotification($reference_f){
        Auth::user()->notifications()->where('data','like', '%' .$reference_f.' va'. '%')->delete();
   
    }

    public function getAllFactures(){
        $AllFactures = Facture::all();
        return Response()->json(['AllFactures' => $AllFactures ]);
    }
       // ajouter un facture
       public function searchFactures($search_f,Request $request ){
        $factures = Facture::leftJoin('comptes', 'factures.fk_compte_f', '=', 'comptes.id_compte')
        ->where('type_operation_f','=',$request->type_operation_f)
        ->where(function($query)use ($search_f)
        {
            $query->where('reference_f','like', '%' .$search_f . '%')
            ->orWhere('comptes.nom_compte','like', '%' .$search_f . '%');
        })->paginate(10);

        return Response()->json(['factures' => $factures ]);
     }



       public function getFacturesCompte($idCompte){
     
        $factures = Facture::leftJoin('comptes', 'factures.fk_compte_f', '=', 'comptes.id_compte')
        ->leftJoin('bonLivraisons','factures.fk_bl', '=', 'bonLivraisons.reference_bl')
        ->leftJoin('status', 'factures.fk_status_f', '=', 'status.id_status')
                    ->select('factures.*', 'comptes.nom_compte','status.*','bonLivraisons.*')
                    ->where('factures.fk_compte_f','=', $idCompte)
                    ->paginate(10);
                   
                 return Response()->json(['factures' => $factures ]);
              }



       public function addFacture(Request $request)
       { 
        
           $facture = new Facture();
    
                   $facture->reference_f = $request->factures['reference_f'];
                   $facture->date_f = $request->factures['date_f'];
                   $facture->type_operation_f = $request->factures['type_operation_f'];
                   $facture->objet_f = $request->factures['objet_f'];
                   $facture->date_emission_f = $request->factures['date_emission_f'];
                   $facture->remise_total_f = $request->factures['remise_total_f'];
                   $facture->majoration_f = $request->factures['majoration_f'];
                   $facture->date_limit_f = $request->factures['date_limit_f'];
                   $facture->introduction_f = $request->factures['introduction_f'];
                   $facture->conditions_reglements_f=$request->factures['conditions_reglements_f'];
                   $facture->notes_f = $request->factures['notes_f'];
                   $facture->adresse_f = $request->factures['adresse_f'];
                   $facture->accompte_f = $request->factures['accompte_f'];
                   $facture->fk_status_f = $request->factures['fk_status_f'];
                   $facture->fk_compte_f = $request->factures['fk_compte_f'];
                   
                   $facture->fk_user_f = Auth::user()->id;
                   
                   $facture->total_lettre_f = $request->factures['total_lettre_f'];
                   $facture->total_ht_f = $request->factures['total_ht_f'];
                   $facture->remise_ht_f = $request->factures['remise_ht_f'];
                   $facture->montant_net_f = $request->factures['montant_net_f'];
                   $facture->tva_montant_f = $request->factures['tva_montant_f'];
                   $facture->montant_ttc_f = $request->factures['montant_ttc_f'];
                   $facture->montant_reste_f = $request->factures['montant_reste_f'];
                   if (isset($request->factures['fk_bl'])) {
                   $facture->fk_bl= $request->factures['fk_bl'];
                   }
                   $facture->save();
   
                   $this->addCommandes_f($request);
                   $this->addModePaiement_f($request);
                    return Response()->json(['etat' => true]);
               
       }

       public function updateFacture(Request $request){

        $facture = Facture::find($request->factures['id_facture']);

                $facture->reference_f = $request->factures['reference_f'];
                $facture->date_f = $request->factures['date_f'];
                $facture->type_operation_f = $request->factures['type_operation_f'];
                $facture->objet_f = $request->factures['objet_f'];
                $facture->date_emission_f = $request->factures['date_emission_f'];
                $facture->remise_total_f = $request->factures['remise_total_f'];
                $facture->majoration_f = $request->factures['majoration_f'];
                $facture->date_limit_f = $request->factures['date_limit_f'];
                $facture->introduction_f = $request->factures['introduction_f'];
                $facture->conditions_reglements_f=$request->factures['conditions_reglements_f'];
                $facture->notes_f = $request->factures['notes_f'];
                $facture->adresse_f = $request->factures['adresse_f'];
                $facture->accompte_f = $request->factures['accompte_f'];
                $facture->fk_status_f = $request->factures['fk_status_f'];
                $facture->fk_compte_f = $request->factures['fk_compte_f'];
                $facture->fk_user_f = Auth::user()->id;
                
                $facture->total_lettre_f = $request->factures['total_lettre_f'];
                $facture->total_ht_f = $request->factures['total_ht_f'];
                $facture->remise_ht_f = $request->factures['remise_ht_f'];
                $facture->montant_net_f = $request->factures['montant_net_f'];
                $facture->tva_montant_f = $request->factures['tva_montant_f'];
                $facture->montant_ttc_f = $request->factures['montant_ttc_f'];
                $facture->montant_reste_f = $request->factures['montant_reste_f'];

        $facture->save();
        $reference_f = $facture->reference_f;
        $this->updateCommandes_f($request,$reference_f);
        $this->updateModePaiement_f($request,$reference_f);
        $this->deleteNotification($request->factures['reference_f']);

        return Response()->json(['etat' => true]);
    }

      //compter le numero de reference facture
      public function countFactures(Request $request){
        $count = Facture::withTrashed()
        ->where('type_operation_f','=',$request->type_operation_f)
        ->count();
        $count ++;
        return Response()->json(['count' => $count]);
    }
    public function countAllFactures(Request $request){
        $count = Facture::All()
        ->count();
        return Response()->json(['count' => $count]);
    }

    
    public function updateStatusFacture(Request $request){
        //dd($request->id_factures);
              $facture = Facture::find($request->id_facture);
                      $facture->fk_status_f = $request->fk_status_f;
                      $facture->save();
              return Response()->json(['etat' => true]);
    }

     // ajouter les commandes de facture
     public function addCommandes_f(Request $request){ 
        
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

    public function updateCommandes_f(Request $request , $reference_f){

        for($i=0;$i<count($request->suppCommandes);$i++){
            if (isset($request->suppCommandes[$i]['id_cmd'])) {
         $commande = Commande::find($request->suppCommandes[$i]['id_cmd']);
         $commande->delete();
            }
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
                $commande->fk_document=$reference_f;
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

public function getBonLivraisonBL($id_bl){
        // $bonLivraison= BonLivraison::find($id_bl);
         $bonLivraison= bonLivraison::leftJoin('boncommandes', 'bonLivraisons.fk_bonCommande', '=', 'boncommandes.reference_bc')
         ->leftJoin('comptes', 'bonLivraisons.fk_compte_bl', '=', 'comptes.id_compte')
               ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
               ->leftJoin('mode_paiements', 'bonLivraisons.reference_bl', '=', 'mode_paiements.fk_document')
               ->leftJoin('status', 'bonLivraisons.fk_status_bl', '=', 'status.id_status')
               ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
               ->select('bonLivraisons.*','comptes.*','status.*', 'macompagnies.*','mode_paiements.*','type_paiements.*','boncommandes.*')
               ->where('id_bl', $id_bl)->get();
         return Response()->json(['bonLivraison' => $bonLivraison ]);
    }


        
    public function getFactureF($id_facture){
        // $facture= Facture::find($id_facture);
         $facture= Facture::leftJoin('comptes', 'factures.fk_compte_f', '=', 'comptes.id_compte')
               ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
               ->leftJoin('mode_paiements', 'factures.reference_f', '=', 'mode_paiements.fk_document')
               ->leftJoin('status', 'factures.fk_status_f', '=', 'status.id_status')
               ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
               ->select('factures.*', 'comptes.*','status.*', 'macompagnies.*','mode_paiements.*','type_paiements.*')
               ->where('id_facture', $id_facture)->get();
         return Response()->json(['facture' => $facture ]);
    }

    public function getFactures(Request $request){
     
        $factures = Facture::leftJoin('comptes', 'factures.fk_compte_f', '=', 'comptes.id_compte')
        ->leftJoin('bonLivraisons','factures.fk_bl', '=', 'bonLivraisons.reference_bl')
        ->leftJoin('status', 'factures.fk_status_f', '=', 'status.id_status')
                    ->select('factures.*', 'comptes.nom_compte','status.*','bonLivraisons.*')
                    ->where('type_operation_f','=',$request->type_operation_f)
                    ->paginate(10);
                   
                 return Response()->json(['factures' => $factures ]);
              }

              public function getPrixArticle_f($fk_article){
                $commande=Commande::find($fk_article);
                $article=Article::leftJoin('tvas', 'articles.fk_tva_applicable', '=', 'tvas.id_tva')
                ->select('articles.*', 'tvas.taux_tva')
                ->where('articles.id_article','=',$fk_article)->get();
                 return Response()->json(['article' => $article ]);
              }

                // ajouter mode de paiement de devis
    public function addModePaiement_f(Request $request) { 
          
        $modeP = new Mode_paiement();
 
                $modeP->reference_paiement = $request->modePaiements['reference_paiement'];
                $modeP->date_paiement = $request->modePaiements['date_paiement'];
                $modeP->fk_type_paiement = $request->modePaiements['fk_type_paiement'];
                $modeP->fk_document = $request->modePaiements['fk_document'];
                $modeP->save();
             
                 return Response()->json(['etat' => true]);
            
    }

    public function updateModePaiement_f(Request $request , $reference_f){
        $modeP = Mode_paiement::find($request->modePaiements['id_modeP']);
        $modeP->reference_paiement = $request->modePaiements['reference_paiement'];
        $modeP->date_paiement = $request->modePaiements['date_paiement'];
        $modeP->fk_type_paiement = $request->modePaiements['fk_type_paiement'];
        $modeP->fk_document = $reference_f;
        $modeP->save();

    }

    public function deleteFacture($id_facture){

        $facture = Facture::find($id_facture);
        $facture->delete();
        $commande = Commande::where('fk_document','=',$facture->reference_f);  
        $commande->delete();   
        $modePaiement = Mode_paiement::where('fk_document','=',$facture->reference_f)->delete(); 
        return Response()->json(['delete' => 'true']);
    }



    public function getsum($fk_article){
        $commande=Commande::leftJoin('articles', 'articles.id_article', '=', 'commandes.fk_article')
   ->where('commandes.fk_article', '=', $fk_article)
   ->where('commandes.fk_document','like', 'F%')
   ->groupBy('commandes.fk_article')
   ->get(['commandes.fk_article', DB::raw('sum(quantite_cmd) as value')])
   ->sum('value');
       // $commande=Commande::find($fk_article) ->SUM('quantite_cmd');
       /* $article=Article::leftJoin('tvas', 'articles.fk_tva_applicable', '=', 'tvas.id_tva')
        ->select('articles.*', 'tvas.taux_tva')
        ->where('articles.id_article','=',$fk_article)->get();*/
         return Response()->json(['commande' => $commande ]);
      }




   
    public function pdf_f($reference_f){
        $facture= Facture::leftJoin('comptes', 'factures.fk_compte_f', '=', 'comptes.id_compte')
        ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
        ->leftJoin('mode_paiements', 'factures.reference_f', '=', 'mode_paiements.fk_document')
        ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
        ->select('factures.*', 'comptes.*','macompagnies.*','mode_paiements.*','type_paiements.*')
        ->where('reference_f', $reference_f)->get();

        $commandes= Commande::leftJoin('articles', 'commandes.fk_article', '=', 'articles.id_article')
        ->leftJoin('tvas', 'commandes.fk_tva_cmd', '=', 'tvas.id_tva')
        ->select('commandes.*', 'articles.designation','articles.unite','tvas.taux_tva','articles.reference_art')
        ->where('fk_document', $reference_f)->get();
        //dd($facture);
  
        $logo = public_path().'/storage/images/'.$facture[0]->logo_comp;
      
        $headerHtml =  '<div>
        <img src="'.$logo.'" alt="test alt attribute" width="180" height="70" border="0" />
   
    </div>
        <br>
      ';


      if (isset($facture[0]->fk_bl)) {
        if(strpos($facture[0]->fk_bl,"D") === 0){
        $objethtml = '<p style="margin-top: 50px;">Réf  Devis: '. $facture[0]->fk_bl.'</p>';

        }
       else  if(strpos($facture[0]->fk_bl,"C") === 0){
            $objethtml = '<p style="margin-top: 50px;">Réf Bon de Commande : '. $facture[0]->fk_bl.'</p>';
    
            }
       else  if(strpos($facture[0]->fk_bl,"BL") === 0){
                $objethtml = '<p style="margin-top: 50px;">Réf Bon de livraison : '. $facture[0]->fk_bl.'</p>';
        
        }
    }
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

        







         $infoComp = ''.$facture[0]->nom_societe_comp.' <span>
        </span>'.$facture[0]->raison_sociale_comp.'<span> 
        ICE: </span>'.$facture[0]->ICE_comp.'<span>
        RC N°: </span>'.$facture[0]->RC_comp.'<span>
        IF: </span>'.$facture[0]->IF_comp.'<span>
        patente: </span>'.$facture[0]->patente_comp.'<span>
        cnss: </span>'.$facture[0]->cnss_comp.'<span>
        compte : </span>'.$facture[0]->nom_bank_comp.'<span>
        RIB: </span>'.$facture[0]->RIB_comp.'<span>
        E-mail: </span>'.$facture[0]->email_comp.'<span>
        Site: </span>'.$facture[0]->webSite_comp.'<span>
        fax: </span>'.$facture[0]->fax_comp.'<span>
        fix: </span>'.$facture[0]->fix_comp.'<span>
        GSM: </span>'.$facture[0]->GSM_comp.'<span>';

        $calculeHtml =  '<div>
        
        <table style="padding: 3px;padding-right:5pt;">
        
        <tr>
        <td style="width:286px;">Total en lettre : '.$facture[0]->total_lettre_f.'</td>
        <td style="width:140px;" align="left">Total</td> <td style="width:140px;" align="right">'.$facture[0]->total_ht_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Remise</td> <td style="width:140px;" align="right">'.$facture[0]->remise_ht_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" class="tdC" align="left">Total HT</td> <td style="width:140px;" align="right">'.$facture[0]->montant_net_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" class="tdC" align="left">TVA</td> <td  style="width:140px;" align="right">'.$facture[0]->tva_montant_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Montant NET TTC (MAD)</td> <td style="width:140px;" align="right">'.$facture[0]->montant_ttc_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Acompte</td> <td style="width:140px;" align="right">'.$facture[0]->accompte_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Net a payer</td> <td style="width:140px;" align="right">'.$facture[0]->montant_reste_f.'</td>
        </tr>


        </table>
        <table>
            <tr>
                <td></td>
                <td><hr></td>
            </tr>
        </table>
        
        </div>
     
        CONDITIONS :'.$facture[0]->conditions_reglements_f.'<br>  
         NOTES : '.$facture[0]->notes_f.'';
        
      

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
    <b> '.$facture[0]->nom_societe_comp.' </b> <br><span> 
    </span>'.$facture[0]->secteur_activite_comp.'<br><span> 
    Tél: </span>'.$facture[0]->fix_comp.'<span>
    /Fax: </span> '.$facture[0]->fax_comp.'<br><span> 
    GSM: </span>'.$facture[0]->GSM_comp.'<br>
    '.$facture[0]->adresse_comp.'<br>
    
    </td>

</tr>
</table>
<br><br>';
$right_column = '<br> <br><br>
<b>Adresse de facturation </b> <br>
<table  cellpadding="3" style="padding: 0px;padding-right:10px">
<tr>

    <td style=" border-right:1px solid black;
    border-left:1px solid black;
    border-bottom:1px solid black;
    border-top:1px solid black;
    ">
    
    <b>'.$facture[0]->nom_compte.'</b><br>
    <span> '.$facture[0]->adresse_f.'</span>
    
    </td>
</tr>
</table>
';


// facture top 
$facture[0]->reference_f=  $facture[0]->reference_f;
$infosfacture = '<br><br><table cellpadding="3" style="padding: 0px;padding-right:10px">
<tr>
<td  rowspan="2" colspan="3" align="center"
style="
border-right:1px solid black;

border-bottom: 1px solid black;
"><h2> <b> Facture </b></h2> </td>
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
" ><span style="font-size: 8px;" >'.$facture[0]->reference_f.'</span></td>
 
</tr>
<tr>
<td  align="center" colspan="4" 
style="
border-bottom: 1px solid black;
border-top: 1px solid black;
">
<h3>Date : '.$facture[0]->date_f.'</h3>
</td>

</tr>

<tr>
<td align="center"
style="
border-right:1px solid black;
border-bottom: 1px solid black;
border-top: 1px solid black;
"><h5> Code Client</h5></td>
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
border-top: 1px solid black;
"><h5>Date livraison</h5></td> 

</tr>
<tr>
<td align="center"
style="
border-right:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$facture[0]->reference.'</span></td>
<td align="center"
style="
border-right:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$facture[0]->date_limit_f.'</span></td>
<td align="center"
style="
border-right:1px solid black;
border-left:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$facture[0]->type_paiement.'</span></td>
<td align="center"
style="
border-left:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$facture[0]->date_f.'</span></td> 

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


//dd(PDF::GetStringWidth($facture[0]->reference_f));
$y = PDF::getY(); 

PDF::writeHTMLCell(0, 0, 100,$y,$infosfacture,0, 0, 0, true, 'right', true);
$y = PDF::getY(); 

if(PDF::GetStringWidth($facture[0]->reference_f) > 27.259138888889)
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

 



if (isset($facture[0]->fk_bl)) {
 PDF::writeHTMLCell(0, 10, '',$y,$objethtml, 0, 1, 0, true, '', true);
 $y = PDF::getY();
}
 
 
 
 

 

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








        //$view = \View::make('pdf', array('facture' => $facture[0],'commandes' => $commandes ,'logo' => $logo ));
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
         






         
         PDF::Output($reference_f.'.pdf');
         
      }


      public function pdf_f_a($reference_f){
        $facture= Facture::leftJoin('comptes', 'factures.fk_compte_f', '=', 'comptes.id_compte')
        ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
        ->leftJoin('mode_paiements', 'factures.reference_f', '=', 'mode_paiements.fk_document')
        ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
        ->select('factures.*', 'comptes.*','macompagnies.*','mode_paiements.*','type_paiements.*')
        ->where('reference_f', $reference_f)->get();

        $commandes= Commande::leftJoin('articles', 'commandes.fk_article', '=', 'articles.id_article')
        ->leftJoin('tvas', 'commandes.fk_tva_cmd', '=', 'tvas.id_tva')
        ->select('commandes.*', 'articles.designation','articles.unite','tvas.taux_tva','articles.reference_art')
        ->where('fk_document', $reference_f)->get();
        //dd($facture);
  
        $logo = public_path().'/storage/images/'.$facture[0]->logo_comp;
      
        $headerHtml =  '<div>
        <img src="'.$logo.'" alt="test alt attribute" width="180" height="70" border="0" />
   
    </div>
        <br>
      ';


      if (isset($facture[0]->fk_bl)) {
        if(strpos($facture[0]->fk_bl,"D") === 0){
        $objethtml = '<p style="margin-top: 50px;">Réf  Devis: '. $facture[0]->fk_bl.'</p>';

        }
       else  if(strpos($facture[0]->fk_bl,"C") === 0){
            $objethtml = '<p style="margin-top: 50px;">Réf Bon de Commande : '. $facture[0]->fk_bl.'</p>';
    
            }
       else  if(strpos($facture[0]->fk_bl,"BL") === 0){
                $objethtml = '<p style="margin-top: 50px;">Réf Bon de livraison : '. $facture[0]->fk_bl.'</p>';
        
        }
    }
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

        







       
           $infoComp = ''.$facture[0]->nom_compte.' <span>
           </span>'.$facture[0]->raison_social.'<span> 
           RC N°: </span>'.$facture[0]->RC.'<span>
           Secteur Activité: </span>'.$facture[0]->secteur_activite.'<span>
           E-mail: </span>'.$facture[0]->email.'<span>
           Site: </span>'.$facture[0]->site_web.'<span>
           fax: </span>'.$facture[0]->fax.'<span>
           fix: </span>'.$facture[0]->fixe.'<span>
           GSM: </span>'.$facture[0]->portable.'<span>';
   

        $calculeHtml =  '<div>
        
        <table style="padding: 3px;padding-right:5pt;">
        
        <tr>
        <td style="width:286px;">Total en lettre : '.$facture[0]->total_lettre_f.'</td>
        <td style="width:140px;" align="left">Total</td> <td style="width:140px;" align="right">'.$facture[0]->total_ht_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Remise</td> <td style="width:140px;" align="right">'.$facture[0]->remise_ht_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" class="tdC" align="left">Total HT</td> <td style="width:140px;" align="right">'.$facture[0]->montant_net_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" class="tdC" align="left">TVA</td> <td  style="width:140px;" align="right">'.$facture[0]->tva_montant_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Montant NET TTC (MAD)</td> <td style="width:140px;" align="right">'.$facture[0]->montant_ttc_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Acompte</td> <td style="width:140px;" align="right">'.$facture[0]->accompte_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Net a payer</td> <td style="width:140px;" align="right">'.$facture[0]->montant_reste_f.'</td>
        </tr>


        </table>
        <table>
            <tr>
                <td></td>
                <td><hr></td>
            </tr>
        </table>
        
        </div>
     
        CONDITIONS :'.$facture[0]->conditions_reglements_f.'<br>  
         NOTES : '.$facture[0]->notes_f.'';
        
      

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
    <b> '.$facture[0]->nom_compte.' </b> <br><span> 
    </span>'.$facture[0]->secteur_activite.'<br><span> 
    Fix: </span>'.$facture[0]->fixe.'<span>
    /Fax: </span> '.$facture[0]->fax.'<br><span> 
    GSM: </span>'.$facture[0]->portable.'<br>
    '.$facture[0]->adresse.'<br>
    
    </td>

</tr>
</table>
<br><br>';
$right_column = '<br> <br><br>
<b>Adresse de facturation </b> <br>
<table  cellpadding="3" style="padding: 0px;padding-right:10px">
<tr>

    <td style=" border-right:1px solid black;
    border-left:1px solid black;
    border-bottom:1px solid black;
    border-top:1px solid black;
    ">
    
    <b>'.$facture[0]->nom_societe_comp.'</b><br>
    <span> '.$facture[0]->adresse_f.'</span>
    
    </td>
</tr>
</table>
';


// facture top 
$facture[0]->reference_f=  $facture[0]->reference_f;
$infosfacture = '<br><br><table cellpadding="3" style="padding: 0px;padding-right:10px">
<tr>
<td  rowspan="2" colspan="3" align="center"
style="
border-right:1px solid black;

border-bottom: 1px solid black;
"><h2> <b> Facture </b></h2> </td>
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
" ><span style="font-size: 8px;" >'.$facture[0]->reference_f.'</span></td>
 
</tr>
<tr>
<td  align="center" colspan="4" 
style="
border-bottom: 1px solid black;
border-top: 1px solid black;
">
<h3>Date : '.$facture[0]->date_f.'</h3>
</td>

</tr>

<tr>
<td align="center"
style="
border-right:1px solid black;
border-bottom: 1px solid black;
border-top: 1px solid black;
"><h5> Code Client</h5></td>
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
border-top: 1px solid black;
"><h5>Date livraison</h5></td> 

</tr>
<tr>
<td align="center"
style="
border-right:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$facture[0]->reference.'</span></td>
<td align="center"
style="
border-right:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$facture[0]->date_limit_f.'</span></td>
<td align="center"
style="
border-right:1px solid black;
border-left:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$facture[0]->type_paiement.'</span></td>
<td align="center"
style="
border-left:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$facture[0]->date_f.'</span></td> 

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


//dd(PDF::GetStringWidth($facture[0]->reference_f));
$y = PDF::getY(); 

PDF::writeHTMLCell(0, 0, 100,$y,$infosfacture,0, 0, 0, true, 'right', true);
$y = PDF::getY(); 

if(PDF::GetStringWidth($facture[0]->reference_f) > 27.259138888889)
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

 



if (isset($facture[0]->fk_bl)) {
 PDF::writeHTMLCell(0, 10, '',$y,$objethtml, 0, 1, 0, true, '', true);
 $y = PDF::getY();
}
 
 
 
 

 

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








        //$view = \View::make('pdf', array('facture' => $facture[0],'commandes' => $commandes ,'logo' => $logo ));
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
         






         
         PDF::Output($reference_f.'.pdf');
         
      }
    
    
}
