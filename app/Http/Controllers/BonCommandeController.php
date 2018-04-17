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

    public $template;

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
                $bonCommande->total_lettre = $request->bonCommande['total_lettre'];
                
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
        'total_lettre' => $request->bonCommande['total_lettre'],
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

    function updateModePaiement_bc($request){

        $bonCommande = Mode_paiement::where('id_modeP',$request->modePaiements['id_modeP'])->update([
        "reference_paiement" => $request->modePaiements['reference_paiement'],
        "date_paiement" => $request->modePaiements['date_paiement'],
        "fk_type_paiement" => $request->modePaiements['fk_type_paiement'],   
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
        $commande->description_article=$request->commandes[$i]['description_article'];
        
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
                  $modeP->fk_type_paiement = $request->modePaiements['fk_type_paiement'];
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
      public function  getBonCommandesCompte($idCompte){
           
        $boncommandes = Boncommande::leftJoin('comptes', 'bonCommandes.fk_compte_bc', '=', 'comptes.id_compte')
            ->leftJoin('status', 'bonCommandes.fk_status_bc', '=', 'status.id_status')
            ->select('bonCommandes.*', 'comptes.nom_compte','status.*')
            ->where('bonCommandes.fk_compte_bc','=', $idCompte)
            ->paginate(10);
         return Response()->json(['bonCommandes' => $boncommandes , 'idCompte' => $idCompte ]);
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
               ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
               ->select('bonCommandes.*', 'comptes.nom_compte','comptes.id_compte','macompagnies.nom_societe','mode_paiements.*','type_paiements.*')
               ->where('reference_bc', $reference_bc)->get();
         return Response()->json(['bonCommande' => $bonCommande ]);
      }


      public function pdf($reference_bc){
        $bonCommande= Boncommande::leftJoin('comptes', 'bonCommandes.fk_compte_bc', '=', 'comptes.id_compte')
        ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
        ->leftJoin('mode_paiements', 'bonCommandes.reference_bc', '=', 'mode_paiements.fk_document')
        ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
        ->select('bonCommandes.*', 'comptes.nom_compte','comptes.id_compte','macompagnies.*','mode_paiements.*','type_paiements.*')
        ->where('reference_bc', $reference_bc)->get();

        $commandes= Commande::leftJoin('articles', 'commandes.fk_article', '=', 'articles.id_article')
        ->leftJoin('tvas', 'commandes.fk_tva_cmd', '=', 'tvas.id_tva')
        ->select('commandes.*', 'articles.designation','articles.unite','tvas.taux_tva','articles.reference_art')
        ->where('fk_document', $reference_bc)->get();
        //dd($bonCommande);
  
        $logo = public_path().'/storage/images/'.$bonCommande[0]->logo_comp;
      
        $headerHtml =  '<div>
        <img src="'.$logo.'" alt="test alt attribute" width="180" height="70" border="0" />
   
    </div>
        <br>
       <table style="padding: 0px;padding-right:10px">
       <tr>
           <td>
           <span></span><br>
           <b>Bon Commande: '.$bonCommande[0]->reference_bc.'</b> <br>
           Date: '.$bonCommande[0]->date_bc.'<br>
           Réglement: '.$bonCommande[0]->type_paiement.'<br>
           Validité: '.$bonCommande[0]->date_limit_bc.'<br>
          
           </td>
           <td style=" border-right:1px solid black;
           border-left:1px solid black;
           border-bottom:1px solid black;
           border-top:1px solid black;">
           <br>
           <b>'.$bonCommande[0]->nom_compte.'</b>
           <p> '.$bonCommande[0]->adresse_bc.'</p>
           
           </td>
       </tr>
       </table>';



       $objethtml = '<p style="margin-top: 50px;">Objet:'. $bonCommande[0]->objet_bc.'</p>';
        $commandesHtml ='<table border="1" style="padding: 3px 0px;">
        <thead>
                <tr style="color:white; font-size: 10pt;background-color: black;">
                
                    <th width="80">Code article</th>
                    <th  width="214">Description</th>
                    <th width="35">QTÉ</th>
                    <th width="30">UT</th>
                    <th width="80">PU HT</th>
                    <th width="100">TOTAL HT</th>
                    <th width="25">TVA</th>
         
                </tr>
                </thead>';
         $commandesHtml.='<tbody style="">';
        foreach ( $commandes as $commande ){
            $commandesHtml.='
            <tr style="border-bottom: 1px solid;font-size: 10pt; ">                   
                    <th align="center" width="80">'.$commande->reference_art.'</th>
                    <th  align="center"  width="214">'.$commande->description_article.'</th>
                    <th align="center" width="35">'.$commande->quantite_cmd.'</th>
                    <th align="center" width="30">'.$commande->unite.'</th>
                    <th align="center" width="80">'.$commande->prix_ht.'</th>
                    <th align="center" width="100">'.$commande->total_ht_cmd.'</th>
                    <th align="center" width="25">'.$commande->taux_tva.'</th>
                </tr> ';
            };
            $commandesHtml.='</tbody> </table>';
           //dd($commandesHtml);

        







         $infoComp = ''.$bonCommande[0]->nom_societe.' <span>
        </span>'.$bonCommande[0]->raison_sociale.'<span> 
        ICE: </span>'.$bonCommande[0]->ICE.'<span>
        RC N°: </span>'.$bonCommande[0]->RC.'<span>
        IF: </span>'.$bonCommande[0]->IF.'<span>
        patente: </span>'.$bonCommande[0]->patente.'<span>
        cnss: </span>'.$bonCommande[0]->cnss.'<span>
        compte : </span>'.$bonCommande[0]->nom_bank.'<span>
        RIB: </span>'.$bonCommande[0]->RIB.'<span>
        E-mail: </span>'.$bonCommande[0]->email.'<span>
        Site: </span>'.$bonCommande[0]->webSite_comp.'<span>
        fax: </span>'.$bonCommande[0]->fax_comp.'<span>
        fix: </span>'.$bonCommande[0]->fix_comp.'<span>
        GSM: </span>'.$bonCommande[0]->GSM_comp.'<span>';

        $calculeHtml =  '<div>
        
        <table style="padding: 3px;padding-right:5pt;">
        
        <tr>
        <td style="width:286px;">Total en lettre : '.$bonCommande[0]->total_lettre.'</td>
        <td style="width:140px;" align="left">Total</td> <td style="width:140px;" align="right">'.$bonCommande[0]->total_ht_bc.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Remise</td> <td style="width:140px;" align="right">'.$bonCommande[0]->remise_ht_bc.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" class="tdC" align="left">Total HT</td> <td style="width:140px;" align="right">'.$bonCommande[0]->montant_net_bc.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" class="tdC" align="left">TVA</td> <td  style="width:140px;" align="right">'.$bonCommande[0]->tva_montant_bc.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Acompte</td> <td style="width:140px;" align="right"></td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Montant NET TTC (MAD)</td> <td style="width:140px;" align="right">'.$bonCommande[0]->montant_ttc_bc.'</td>
        </tr>
        
        </table>
        <table>
            <tr>
                <td></td>
                <td><hr></td>
            </tr>
        </table>
        
        </div>
     
        CONDITIONS :'.$bonCommande[0]->conditions_reglements_bc.'<br>  
         NOTES : '.$bonCommande[0]->notes_bc.'';
        
      

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

 $y = PDF::getY();    
 
 PDF::writeHTMLCell(0, 0, '',$y,$headerHtml ,0, 1, 0, true, '', true);
 $y = PDF::getY();



 PDF::writeHTMLCell(0, 10, '',$y,$objethtml, 0, 1, 0, true, '', true);
 $y = PDF::getY();
 
 //PDF::SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 255)));

 //$style2 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));

 //PDF::Line(5, 40, 5, 30, $style2);
 //$this->Line($p1x, $p1y, $p2x, $p2y, $style);
 /*$border = array(
    'L' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0)),
    'R' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 255)),
    'T' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 255, 0)),
    'B' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 255)));*/


  /*  $border = array(
        'T' => array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 255)),
     );*/



//$y=78 minimum
//chaque ligne = y=6.5 ou 12
// 17 lign 

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
 "> </th>
 <th  width="214" style="
 border-right:1px solid black;
 border-left:1px solid black;
 "> </th>
 <th width="35" style="
 border-right:1px solid black;
 border-left:1px solid black;
 "> </th>
 <th width="30" style="
 border-right:1px solid black;
 border-left:1px solid black;
 "> </th>
 <th width="80" style="
 border-right:1px solid black;
 border-left:1px solid black;
 "> </th>
 <th width="100" style="
 border-right:1px solid black;
 border-left:1px solid black;
 "> </th>
 <th width="25" style="
 border-right:1px solid black;
 border-left:1px solid black;
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








        //$view = \View::make('pdf', array('bonCommande' => $bonCommande[0],'commandes' => $commandes ,'logo' => $logo ));
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
         
         
         PDF::Output($reference_bc.'.pdf');
         
      }
   


  
}
