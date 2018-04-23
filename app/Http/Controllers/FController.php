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

class FController extends Controller
{
      
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

border-bottom: 1px solid black;
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
