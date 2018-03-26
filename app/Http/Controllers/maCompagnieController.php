<?php

namespace App\Http\Controllers;

use App\Macompagnie;
use Illuminate\Http\Request;

class maCompagnieController extends Controller
{
           //ajouter compagnie
           public function store(Request $request){
                
             $compagnie = new Macompagnie();
             $compagnie->raison_sociale = $request->raison_sociale;
             $compagnie->taille_comp=$request->taille_comp;
             $compagnie->secteur_activite=$request->secteur_activite;
             $compagnie->adresse_comp=$request->adresse_comp;
             $compagnie->cp_comp=$request->cp_comp;
             $compagnie->ville_comp=$request->ville_comp;
             $compagnie->pays_comp=$request->pays_comp;
             $compagnie->tel_comp=$request->tel_comp;
             $compagnie->fix_comp=$request->fix_comp;
             $compagnie->webSite_comp=$request->webSite_comp;


             
             if($request->get('logo_comp'))
             {
                  $logo_comp = $request->get('logo_comp');
                  $namePhoto = time().'.' . explode('/', explode(':', substr($logo_comp, 0, strpos($logo_comp, ';')))[1])[1];
                  \Image::make($request->get('logo_comp'))->save(public_path('logo_comps/').$namePhoto);
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
          \Image::make($request->get('logo_comp'))->save(public_path('images/').$name);
         
          $compagnie->logo_comp = $name;
        }
        }
        else  {
            $compagnie->logo_comp = "";
        }
                

        
        $compagnie->raison_sociale = $request->raison_sociale;
        $compagnie->taille_comp=$request->taille_comp;
        $compagnie->secteur_activite=$request->secteur_activite;
        $compagnie->adresse_comp=$request->adresse_comp;
        $compagnie->cp_comp=$request->cp_comp;
        $compagnie->ville_comp=$request->ville_comp;
        $compagnie->pays_comp=$request->pays_comp;
        $compagnie->tel_comp=$request->tel_comp;
        $compagnie->fix_comp=$request->fix_comp;
        $compagnie->webSite_comp=$request->webSite_comp;

                $compagnie->save();
                 return Response()->json(['etat' => true]);
    }



    public function deleteCompagnie($id_compagnie){
        $compagnie=Macompagnie::find($id_compagnie);
        $compagnie->delete();
    return Response()->json(['delete'=>true]);        
}
         
}
