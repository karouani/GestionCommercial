<?php

namespace App\Http\Controllers;

use App\Macompagnie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class maCompagnieController extends Controller
{
           //ajouter compagnie
           public function store(Request $request){
            
             $compagnie = new Macompagnie();
             $compagnie->nom_societe = $request->nom_societe;
             $compagnie->raison_sociale = $request->raison_sociale;
             $compagnie->RC = $request->RC;
             $compagnie->IF = $request->IF;
             $compagnie->patente = $request->patente;
             $compagnie->cnss = $request->cnss;
             $compagnie->ICE = $request->ICE;
             $compagnie->capitale = $request->capitale;
             $compagnie->taille_comp=$request->taille_comp;
             $compagnie->secteur_activite=$request->secteur_activite;
             // details bancaires
             $compagnie->nom_bank=$request->nom_bank;
             $compagnie->RIB=$request->RIB;
             //$compagnie->cp_comp=$request->cp_comp;
             //$compagnie->ville_comp=$request->ville_comp;
             //$compagnie->pays_comp=$request->pays_comp;
             $compagnie->adresse_comp=$request->adresse_comp;
             $compagnie->email=$request->email;
             $compagnie->GSM_comp=$request->GSM_comp;
             $compagnie->fix_comp=$request->fix_comp;
             $compagnie->fax_comp=$request->fax_comp;
             $compagnie->webSite_comp=$request->webSite_comp;


             
             if($request->get('logo_comp'))
             {
                  $logo_comp = $request->get('logo_comp');
                  $namePhoto = time().'.' . explode('/', explode(':', substr($logo_comp, 0, strpos($logo_comp, ';')))[1])[1];
                  $image2 = \Image::make($request->get('logo_comp'));     
                  Storage::put('images/'.$namePhoto, (string) $image2->encode());
                  $compagnie->logo_comp = $namePhoto;
             }
             else {
                 $compagnie->logo_comp = '';
             }
                 $compagnie->save();
             
          return Response()->json(['etat'=>true]);
         }

     // afficher compagnie 
     public function getCompagnies(){
        
        $compagnies = Macompagnie::paginate(6);

        return Response()->json(['compagnies'=>$compagnies]);
        
    }
    public function getAllCompagnies(){
        
        $compagnies = Macompagnie::all();

        return Response()->json(['compagnies'=>$compagnies]);
        
    }
    public function getCompagnie($id_compagnie){
        //dd($id_compagnie);
        $compagnie = Macompagnie::find($id_compagnie);
     
         return Response()->json(['compagnie' => $compagnie]);
      }

      public function updateCompagnie(Request $request)
    {
        $compagnie = Macompagnie::find($request->id_compagnie);
        //$compagnie = new Article();
        if($request->get('logo_comp'))
       {  
           if(strlen($request->get('logo_comp')) < 40 ){
            $compagnie->logo_comp = $request->get('logo_comp');
           }
           else {
          $logo_comp = $request->get('logo_comp');
          $name = time().'.' . explode('/', explode(':', substr($logo_comp, 0, strpos($logo_comp, ';')))[1])[1];
          if( $compagnie->logo_comp !=""){
            Storage::disk('local')->delete('images/'.$compagnie->logo_comp);
            }
  
            $image2 = \Image::make($request->get('logo_comp'));     
            Storage::put('images/'.$name, (string) $image2->encode());         
          $compagnie->logo_comp = $name;
        }
        }
        else  {
            $compagnie->logo_comp = "";
        }
                
        $compagnie->nom_societe = $request->nom_societe;
        $compagnie->raison_sociale = $request->raison_sociale;
        $compagnie->RC = $request->RC;
        $compagnie->IF = $request->IF;
        $compagnie->patente = $request->patente;
        $compagnie->cnss = $request->cnss;
        $compagnie->ICE = $request->ICE;
        $compagnie->capitale = $request->capitale; 
        $compagnie->taille_comp=$request->taille_comp;
        $compagnie->secteur_activite=$request->secteur_activite;
        $compagnie->nom_bank=$request->nom_bank;
        $compagnie->RIB=$request->RIB;
         $compagnie->adresse_comp=$request->adresse_comp;
        $compagnie->email=$request->email;
        $compagnie->GSM_comp=$request->GSM_comp;
        $compagnie->fix_comp=$request->fix_comp;
        $compagnie->fax_comp=$request->fax_comp;
        $compagnie->webSite_comp=$request->webSite_comp;


                $compagnie->save();
                 return Response()->json(['etat' => true]);
    }



    public function deleteCompagnie($id_compagnie){
        $compagnie=Macompagnie::find($id_compagnie);
        if( $compagnie->logo_comp !=""){
            Storage::disk('local')->delete('images/'.$compagnie->logo_comp);}
        $compagnie->delete();
    return Response()->json(['delete'=>true]);        
}
         
}
