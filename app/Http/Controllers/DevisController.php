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

use App\Notifications\RepliedToThread;


class DevisController extends Controller

{     
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function gettNotification(){
        $reference_d = "D-2018-1";
        $reference_d =$reference_d." va";
       $notifss = Auth::user()->notifications()->where('data','like', '%' .$reference_d.'%')->get();
        return Response()->json(['notifss' => $notifss ]);
        
    }

    public function deleteNotification($reference_d){

        $reference_t =$reference_d." va";
        Auth::user()->notifications()->where('data','like', '%' .$reference_t.'%')->delete();
   
    }

    // partis pour afficher les devis d un compte exacte
          public function getDevisCompte($idCompte){
     
        $devis = Devi::leftJoin('comptes', 'devis.fk_compte_d', '=', 'comptes.id_compte')
        ->leftJoin('status', 'devis.fk_status_d', '=', 'status.id_status')
                    ->select('devis.*', 'comptes.nom_compte','status.*')
                    ->where('devis.fk_compte_d','=', $idCompte)
                    ->paginate(10);
                   
                 return Response()->json(['devis' => $devis ]);
              }
    
    
    
    // ajouter un devis
    public function addDevis(Request $request)
    { 
       // dd($request->devi['total_lettre_d']);
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
                
                $devi->total_lettre_d = $request->devis['total_lettre_d'];
                $devi->total_ht_d = $request->devis['total_ht_d'];
                $devi->remise_ht_d = $request->devis['remise_ht_d'];
                $devi->montant_net_d = $request->devis['montant_net_d'];
                $devi->tva_montant_d = $request->devis['tva_montant_d'];
                $devi->montant_ttc_d = $request->devis['montant_ttc_d'];
                $devi->montant_reste_d = $request->devis['montant_reste_d'];

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
                
                $devi->total_lettre_d = $request->devis['total_lettre_d'];
                $devi->total_ht_d = $request->devis['total_ht_d'];
                $devi->remise_ht_d = $request->devis['remise_ht_d'];
                $devi->montant_net_d = $request->devis['montant_net_d'];
                $devi->tva_montant_d = $request->devis['tva_montant_d'];
                $devi->montant_ttc_d = $request->devis['montant_ttc_d'];
                $devi->montant_reste_d = $request->devis['montant_reste_d'];

        $devi->save();
        $reference_d = $devi->reference_d;

        $this->deleteNotification($request->devis['reference_d']);
        $this->updateCommandes($request,$reference_d);
        $this->updateModePaiement($request,$reference_d);

        return Response()->json(['etat' => true]);
     }
        //compter le numero de reference devis
    public function countDevis(Request $request){
        $count = Devi::withTrashed()
        ->where('type_operation','=',$request->type_operation)
        ->count();
        $count ++;
        return Response()->json(['count' => $count]);
    }

    public function countAllDevis(Request $request){
        $count = Devi::All()
        ->count();
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

    public function getAllDevis(){
        $AllDevis = Devi::all();
        return Response()->json(['AllDevis' => $AllDevis ]);
    }
    public function getDevisD($id_devis){
     // $devi= Devi::find($id_devis);
      $devi= Devi::leftJoin('comptes', 'devis.fk_compte_d', '=', 'comptes.id_compte')
            ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
            ->leftJoin('mode_paiements', 'devis.reference_d', '=', 'mode_paiements.fk_document')
            ->leftJoin('status', 'devis.fk_status_d', '=', 'status.id_status')
            ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
            ->select('devis.*', 'comptes.*','status.*', 'macompagnies.*','mode_paiements.*','type_paiements.*')
            ->where('id_devis', $id_devis)->get();
      return Response()->json(['devi' => $devi ]);
   }
    public function getDevis(Request $request){
     
$devis = Devi::leftJoin('comptes', 'devis.fk_compte_d', '=', 'comptes.id_compte')
->leftJoin('status', 'devis.fk_status_d', '=', 'status.id_status')
            ->select('devis.*', 'comptes.nom_compte','status.*')
            ->where('type_operation','=',$request->type_operation)
            ->paginate(10);
           
         return Response()->json(['devis' => $devis ]);
      }


    public function getPrixArticle($fk_article){
       $commande=Commande::find($fk_article);
       $article=Article::leftJoin('tvas', 'articles.fk_tva_applicable', '=', 'tvas.id_tva')
       ->select('articles.*', 'tvas.*')
       ->where('articles.id_article','=',$fk_article)->get();
        return Response()->json(['article' => $article ]);
     }

      // ajouter mode de paiement de devis
    public function addModePaiement(Request $request) { 
          
          $modeP = new Mode_paiement();
   
                  $modeP->reference_paiement = $request->modePaiements['reference_paiement'];
                  $modeP->date_paiement = $request->modePaiements['date_paiement'];
                  $modeP->fk_type_paiement = $request->modePaiements['fk_type_paiement'];
                  $modeP->fk_document = $request->modePaiements['fk_document'];
                  $modeP->save();
               
                   return Response()->json(['etat' => true]);
              
    }

    public function updateModePaiement(Request $request , $reference_d){
        $modeP = Mode_paiement::find($request->modePaiements['id_modeP']);
        $modeP->reference_paiement = $request->modePaiements['reference_paiement'];
        $modeP->date_paiement = $request->modePaiements['date_paiement'];
        $modeP->fk_type_paiement = $request->modePaiements['fk_type_paiement'];
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
     public function searchDevis($search_D,Request $request ){
        $devis = Devi::leftJoin('comptes', 'devis.fk_compte_d', '=', 'comptes.id_compte')
        ->where('type_operation','=',$request->type_operation)
        ->where(function($query)use ($search_D)
        {
            $query->where('reference_d','like', '%' .$search_D . '%')
            ->orWhere('comptes.nom_compte','like', '%' .$search_D . '%');
        })->paginate(10);

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

   /*  public function pdf_d($reference_d){
        $devi= Devi::leftJoin('comptes', 'devis.fk_compte_d', '=', 'comptes.id_compte')
        ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
        ->leftJoin('mode_paiements', 'devis.reference_d', '=', 'mode_paiements.fk_document')
        ->select('devis.*', 'comptes.nom_compte','comptes.id_compte','macompagnies.nom_societe','macompagnies.logo_comp','mode_paiements.*')
        ->where('reference_d', $reference_d)->get();

        $commandes= Commande::leftJoin('articles', 'commandes.fk_article', '=', 'articles.id_article')
        ->leftJoin('tvas', 'commandes.fk_tva_cmd', '=', 'tvas.id_tva')
        ->select('commandes.*', 'articles.designation','articles.unite','tvas.taux_tva')
        ->where('fk_document', $reference_d)->get();
        //dd($devi);
  
        $logo = public_path().'/storage/images/'.$devi[0]->logo_comp;
        //dd($filename);
        //return view('pdf', ['devi' => $devi[0],'commandes' => $commandes]);
       /*  $options = new PDF\Options();
        $options->setDpi(150);
        $pdf= new PDF($options);*/
       // $pdf = PDF::loadView('pdf',['devi' => $devi[0],'commandes' => $commandes]);

        //return  $pdf->stream($reference_d.'.pdf',array('Attachment'=>0));
       // $pdf = PDF::loadView('pdf', ['devi' => $devi[0],'commandes' => $commandes]);
         // return $pdf->download('invoice.pdf');
      /*   $view = \View::make('pdf_d', array('devi' => $devi[0],'commandes' => $commandes ,'logo' => $logo ));
         $html_content = $view->render();
         
    

         //PDF::SetHeaderData('PDF_HEADER_LOGO', 'PDF_HEADER_LOGO_WIDTH', 'PDF_HEADER_TITLE'.' 001', 'PDF_HEADER_STRING', array(0,64,255), array(0,64,128));
         PDF::SetY(0, true, true);
         PDF::SetMargins(5, 0, 5);
         PDF::SetHeaderMargin(0);
  
         //PDF::SetTitle('Sample PDF');
         PDF::AddPage();
         PDF::writeHTML($html_content, true, false, true, false, '');
  
         PDF::Output($reference_d.'.pdf');
}*/
  
    public function pdf_d($reference_d){
        $devi= Devi::leftJoin('comptes', 'devis.fk_compte_d', '=', 'comptes.id_compte')
        ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
        ->leftJoin('mode_paiements', 'devis.reference_d', '=', 'mode_paiements.fk_document')
        ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
        ->select('devis.*', 'comptes.*','macompagnies.*','mode_paiements.*','type_paiements.*')
        ->where('reference_d', $reference_d)->get();

        $commandes= Commande::leftJoin('articles', 'commandes.fk_article', '=', 'articles.id_article')
        ->leftJoin('tvas', 'commandes.fk_tva_cmd', '=', 'tvas.id_tva')
        ->select('commandes.*', 'articles.designation','articles.unite','tvas.taux_tva','articles.reference_art')
        ->where('fk_document', $reference_d)->get();
        //dd($devi);
  
        $logo = public_path().'/storage/images/'.$devi[0]->logo_comp;
      
        $headerHtml =  '<div>
        <img src="'.$logo.'" alt="test alt attribute" width="180" height="70" border="0" />
   
    </div>
        <br>
      ';



       $objethtml = '<p style="margin-top: 50px;">Objet: '. $devi[0]->objet_d.'</p>';
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

        







         $infoComp = ''.$devi[0]->nom_societe_comp.' <span>
        </span>'.$devi[0]->raison_sociale_comp.'<span> 
        ICE: </span>'.$devi[0]->ICE_comp.'<span>
        RC N°: </span>'.$devi[0]->RC_comp.'<span>
        IF: </span>'.$devi[0]->IF_comp.'<span>
        patente: </span>'.$devi[0]->patente_comp.'<span>
        cnss: </span>'.$devi[0]->cnss_comp.'<span>
        compte : </span>'.$devi[0]->nom_bank_comp.'<span>
        RIB: </span>'.$devi[0]->RIB_comp.'<span>
        E-mail: </span>'.$devi[0]->email_comp.'<span>
        Site: </span>'.$devi[0]->webSite_comp.'<span>
        fax: </span>'.$devi[0]->fax_comp.'<span>
        fix: </span>'.$devi[0]->fix_comp.'<span>
        GSM: </span>'.$devi[0]->GSM_comp.'<span>';

        $calculeHtml =  '<div>
        
        <table style="padding: 3px;padding-right:5pt;">
        
        <tr>
        <td style="width:286px;">Total en lettre : '.$devi[0]->total_lettre_d.'</td>
        <td style="width:140px;" align="left">Total</td> <td style="width:140px;" align="right">'.$devi[0]->total_ht_d.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Remise</td> <td style="width:140px;" align="right">'.$devi[0]->remise_ht_d.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" class="tdC" align="left">Total HT</td> <td style="width:140px;" align="right">'.$devi[0]->montant_net_d.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" class="tdC" align="left">TVA</td> <td  style="width:140px;" align="right">'.$devi[0]->tva_montant_d.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Montant NET TTC (MAD)</td> <td style="width:140px;" align="right">'.$devi[0]->montant_ttc_d.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Acompte</td> <td style="width:140px;" align="right">'.$devi[0]->accompte_d.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Net a payer</td> <td style="width:140px;" align="right">'.$devi[0]->montant_reste_d.'</td>
        </tr>


        </table>
        <table>
            <tr>
                <td></td>
                <td><hr></td>
            </tr>
        </table>
        
        </div>
     
        CONDITIONS :'.$devi[0]->conditions_reglements_d.'<br>  
         NOTES : '.$devi[0]->notes_d.'';
        
      

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
    <b> '.$devi[0]->nom_societe_comp.' </b> <br><span> 
    </span>'.$devi[0]->secteur_activite_comp.'<br><span> 
    Tél: </span>'.$devi[0]->fix_comp.'<span>
    /Fax: </span> '.$devi[0]->fax_comp.'<br><span> 
    GSM: </span>'.$devi[0]->GSM_comp.'<br>
    '.$devi[0]->adresse_comp.'<br>
    
    </td>

</tr>
</table>
<br><br>';
$right_column = '<br> <br><br>
<b>Adresse de devis </b> <br>
<table  cellpadding="3" style="padding: 0px;padding-right:10px">
<tr>

    <td style=" border-right:1px solid black;
    border-left:1px solid black;
    border-bottom:1px solid black;
    border-top:1px solid black;
    ">
    
    <b>'.$devi[0]->nom_compte.'</b><br>
    <span> '.$devi[0]->adresse_d.'</span>
    
    </td>
</tr>
</table>
';


// devi top 
$devi[0]->reference_d=  $devi[0]->reference_d;
$infosdevi = '<br><br><table cellpadding="3" style="padding: 0px;padding-right:10px">
<tr>
<td  rowspan="2" colspan="3" align="center"
style="
border-right:1px solid black;

border-bottom: 1px solid black;
"><h2> <b> Devis </b></h2> </td>
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
" ><span style="font-size: 8px;" >'.$devi[0]->reference_d.'</span></td>
 
</tr>
<tr>
<td  align="center" colspan="4" 
style="
border-bottom: 1px solid black;
border-top: 1px solid black;
">
<h3>Date : '.$devi[0]->date_d.'</h3>
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
"><span style="font-size: 8px;">'.$devi[0]->reference.'</span></td>
<td align="center"
style="
border-right:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$devi[0]->date_limit_d.'</span></td>
<td align="center"
style="
border-right:1px solid black;
border-left:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$devi[0]->type_paiement.'</span></td>
<td align="center"
style="
border-left:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$devi[0]->date_d.'</span></td> 

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


//dd(PDF::GetStringWidth($devi[0]->reference_d));
$y = PDF::getY(); 

PDF::writeHTMLCell(0, 0, 100,$y,$infosdevi,0, 0, 0, true, 'right', true);
$y = PDF::getY(); 

if(PDF::GetStringWidth($devi[0]->reference_d) > 27.259138888889)
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








        //$view = \View::make('pdf', array('devi' => $devi[0],'commandes' => $commandes ,'logo' => $logo ));
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
         






         
         PDF::Output($reference_d.'.pdf');
         
      }




      public function pdf_d_a($reference_d){
        $devi= Devi::leftJoin('comptes', 'devis.fk_compte_d', '=', 'comptes.id_compte')
        ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
        ->leftJoin('mode_paiements', 'devis.reference_d', '=', 'mode_paiements.fk_document')
        ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
        ->select('devis.*', 'comptes.*','macompagnies.*','mode_paiements.*','type_paiements.*')
        ->where('reference_d', $reference_d)->get();

        $commandes= Commande::leftJoin('articles', 'commandes.fk_article', '=', 'articles.id_article')
        ->leftJoin('tvas', 'commandes.fk_tva_cmd', '=', 'tvas.id_tva')
        ->select('commandes.*', 'articles.designation','articles.unite','tvas.taux_tva','articles.reference_art')
        ->where('fk_document', $reference_d)->get();
        //dd($devi);
  
        $logo = public_path().'/storage/images/'.$devi[0]->logo_comp;
      
        $headerHtml =  '<div>
        <img src="'.$logo.'" alt="test alt attribute" width="180" height="70" border="0" />
   
    </div>
        <br>
      ';



       $objethtml = '<p style="margin-top: 50px;">Objet: '. $devi[0]->objet_d.'</p>';
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

        







           $infoComp = ''.$devi[0]->nom_compte.' <span>
           </span>'.$devi[0]->raison_social.'<span> 
           RC N°: </span>'.$devi[0]->RC.'<span>
           Secteur Activité: </span>'.$devi[0]->secteur_activite.'<span>
           E-mail: </span>'.$devi[0]->email.'<span>
           Site: </span>'.$devi[0]->site_web.'<span>
           fax: </span>'.$devi[0]->fax.'<span>
           fix: </span>'.$devi[0]->fixe.'<span>
           GSM: </span>'.$devi[0]->portable.'<span>';

        $calculeHtml =  '<div>
        
        <table style="padding: 3px;padding-right:5pt;">
        
        <tr>
        <td style="width:286px;">Total en lettre : '.$devi[0]->total_lettre_d.'</td>
        <td style="width:140px;" align="left">Total</td> <td style="width:140px;" align="right">'.$devi[0]->total_ht_d.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Remise</td> <td style="width:140px;" align="right">'.$devi[0]->remise_ht_d.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" class="tdC" align="left">Total HT</td> <td style="width:140px;" align="right">'.$devi[0]->montant_net_d.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" class="tdC" align="left">TVA</td> <td  style="width:140px;" align="right">'.$devi[0]->tva_montant_d.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Montant NET TTC (MAD)</td> <td style="width:140px;" align="right">'.$devi[0]->montant_ttc_d.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Acompte</td> <td style="width:140px;" align="right">'.$devi[0]->accompte_d.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Net a payer</td> <td style="width:140px;" align="right">'.$devi[0]->montant_reste_d.'</td>
        </tr>


        </table>
        <table>
            <tr>
                <td></td>
                <td><hr></td>
            </tr>
        </table>
        
        </div>
     
        CONDITIONS :'.$devi[0]->conditions_reglements_d.'<br>  
         NOTES : '.$devi[0]->notes_d.'';
        
      

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
    <b> '.$devi[0]->nom_compte.' </b> <br><span> 
    </span>'.$devi[0]->secteur_activite.'<br><span> 
    Tél: </span>'.$devi[0]->fixe.'<span>
    /Fax: </span> '.$devi[0]->fax.'<br><span> 
    GSM: </span>'.$devi[0]->portable.'<br>
    '.$devi[0]->adresse_comp.'<br>
    
    </td>

</tr>
</table>
<br><br>';
$right_column = '<br> <br><br>
<b>Adresse de devis </b> <br>
<table  cellpadding="3" style="padding: 0px;padding-right:10px">
<tr>

    <td style=" border-right:1px solid black;
    border-left:1px solid black;
    border-bottom:1px solid black;
    border-top:1px solid black;
    ">
    
    <b>'.$devi[0]->nom_societe_comp.'</b><br>
    <span> '.$devi[0]->adresse_d.'</span>
    
    </td>
</tr>
</table>
';


// devi top 
$devi[0]->reference_d=  $devi[0]->reference_d;
$infosdevi = '<br><br><table cellpadding="3" style="padding: 0px;padding-right:10px">
<tr>
<td  rowspan="2" colspan="3" align="center"
style="
border-right:1px solid black;

border-bottom: 1px solid black;
"><h2> <b> Devis </b></h2> </td>
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
" ><span style="font-size: 8px;" >'.$devi[0]->reference_d.'</span></td>
 
</tr>
<tr>
<td  align="center" colspan="4" 
style="
border-bottom: 1px solid black;
border-top: 1px solid black;
">
<h3>Date : '.$devi[0]->date_d.'</h3>
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
"><span style="font-size: 8px;">'.$devi[0]->reference.'</span></td>
<td align="center"
style="
border-right:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$devi[0]->date_limit_d.'</span></td>
<td align="center"
style="
border-right:1px solid black;
border-left:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$devi[0]->type_paiement.'</span></td>
<td align="center"
style="
border-left:1px solid black;
border-top: 1px solid black;
"><span style="font-size: 8px;">'.$devi[0]->date_d.'</span></td> 

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


//dd(PDF::GetStringWidth($devi[0]->reference_d));
$y = PDF::getY(); 

PDF::writeHTMLCell(0, 0, 100,$y,$infosdevi,0, 0, 0, true, 'right', true);
$y = PDF::getY(); 

if(PDF::GetStringWidth($devi[0]->reference_d) > 27.259138888889)
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








        //$view = \View::make('pdf', array('devi' => $devi[0],'commandes' => $commandes ,'logo' => $logo ));
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
         






         
         PDF::Output($reference_d.'.pdf');
         
      }


}
