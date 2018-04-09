<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

  

</head>
<body>

 <div>
     <img src="{{$logo}}" alt="test alt attribute" width="180" height="70" border="0" />

 </div>
     <br>
    <table style="padding: 0px;padding-right:10px">
    <tr>
        <td>
        <span></span><br>
        <b>Bon Commande {{$bonCommande->reference_bc}}</b> <br>
        date: {{$bonCommande->date_bc}}<br>
        Validité: {{$bonCommande->date_limit_bc}}<br>
       
        </td>
        <td>
        
        <b>{{$bonCommande->nom_compte}}</b>
           <p>{{$bonCommande->adresse_bc}}</p>
        
        </td>
    </tr>
    </table>





   

<div class="tableBc">
<p class="objet">Objet: {{$bonCommande->objet_bc}}</p>
    <table style="padding: 3px 0px;">
        <tr class="sizee" style="">
        
            <th>RÉFÉRENCE</th>
            <th>DÉSIGNATION</th>
            <th>QTÉ</th>
            <th>UNITÉ</th>
            <th>PU HT</th>
            <th>TOTAL HT</th>
            
        </tr>
        
@foreach ($commandes as $commande)       
        <tr>
            
            <td>P{{$commande->id_cmd}}</td>
            <td>{{$commande->designation}}</td>
            <td>{{$commande->quantite_cmd}}</td>
            <td>{{$commande->unite}}</td>
            <td>{{$commande->prix_ht}}</td>
            <td>{{$commande->total_ht_cmd}}</td>
        </tr>
@endforeach        
    </table>
    <hr>
    
   <div class="calcule">
    <table style="padding: 3px;padding-right:5pt;">

     
    <tr>
    <td class="tdC1"></td>
    <td class="tdC" align="left">Total</td> <td class="tdC" align="right">{{$bonCommande->total_ht_bc}}</td>
    </tr>
    <tr>
    <td class="tdC1"></td>
    <td class="tdC" align="left">Remise</td> <td class="tdC" align="right">{{$bonCommande->remise_ht_bc}}</td>
    </tr>
    <tr>
    <td class="tdC1"></td>
    <td class="tdC" align="left">Total HT</td> <td class="tdC" align="right">{{$bonCommande->montant_net_bc}}</td>
    </tr>
    <tr>
    <td class="tdC1"></td>
    <td class="tdC" align="left">TVA</td> <td class="tdC" align="right">{{$bonCommande->tva_montant_bc}}</td>
    </tr>
    <tr>
    <td class="tdC1"></td>
    <td class="tdC" align="left">Montant NET TTC (MAD)</td> <td class="tdC" align="right">{{$bonCommande->montant_ttc_bc}}</td>
    </tr>
    
    </table>
    <table>
        <tr>
            <td></td>
            <td><hr></td>
        </tr>
    </table>
    
    </div>
    </div>
    <div>
    CONDITIONS <br>
    {{$bonCommande->conditions_reglements_bc}}<br><br>
    NOTES<br>
    {{$bonCommande->notes_bc}}<br>
    
  
    
</body>

  <style>
.tdC1{
    width:286px;
}
  .tdC{
      
      width:140px;
  }
  .sizee{
       
        color : white;
        background-color: black;

         font-size: 10pt;
  }
  .table1{
      width: 350px;
  }
    table{
        border-collapse: collapse;
        
    }
   
   
    
    
    .tableBc{
        margin-top: 20px;
    }
    p {
        margin-bottom:0rem;
    }
  
    .objet{
        margin-top: 50px;
    }
    hr{
        border-top: 30px solid;
        border-width: 3px;
        
    }
    
 

    </style>
</html>