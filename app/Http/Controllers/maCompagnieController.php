<?php

namespace App\Http\Controllers;

use App\Macompagnie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Contact;

class maCompagnieController extends Controller
{
           //ajouter compagnie
           public function store(Request $request){
            //dd($request);
             $compagnie = new Macompagnie();
             $compagnie->nom_societe_comp = $request->compagnie['nom_societe_comp'];
             $compagnie->raison_sociale_comp = $request->compagnie['raison_sociale_comp'];
             $compagnie->RC_comp = $request->compagnie['RC_comp'];
             $compagnie->IF_comp = $request->compagnie['IF_comp'];
             $compagnie->patente_comp = $request->compagnie['patente_comp'];
             $compagnie->cnss_comp = $request->compagnie['cnss_comp'];
             $compagnie->ICE_comp = $request->compagnie['ICE_comp'];
             $compagnie->capitale_comp = $request->compagnie['capitale_comp'];
             $compagnie->taille_comp=$request->compagnie['taille_comp'];
             $compagnie->secteur_activite_comp=$request->compagnie['secteur_activite_comp'];
             // details bancaires
             $compagnie->nom_bank_comp=$request->compagnie['nom_bank_comp'];
             $compagnie->RIB_comp=$request->compagnie['RIB_comp'];
             //$compagnie->cp_comp=$request->compagnie['cp_comp'];
             //$compagnie->ville_comp=$request->compagnie['ville_comp'];
             //$compagnie->pays_comp=$request->compagnie['pays_comp'];
             $compagnie->adresse_comp=$request->compagnie['adresse_comp'];
             $compagnie->email_comp=$request->compagnie['email_comp'];
             $compagnie->GSM_comp=$request->compagnie['GSM_comp'];
             $compagnie->fix_comp=$request->compagnie['fix_comp'];
             $compagnie->fax_comp=$request->compagnie['fax_comp'];
             $compagnie->webSite_comp=$request->compagnie['webSite_comp'];


             
             if($request->compagnie['logo_comp'])
             {
                // dd("logo");
                  $logo_comp = $request->compagnie['logo_comp'];
                  $namePhoto = time().'.' . explode('/', explode(':', substr($logo_comp, 0, strpos($logo_comp, ';')))[1])[1];
                  $image2 = \Image::make($request->compagnie['logo_comp']);     
                  Storage::put('images/'.$namePhoto, (string) $image2->encode());
                  $compagnie->logo_comp = $namePhoto;
             }
             else {
                 $compagnie->logo_comp = '';
             }
                 $compagnie->save();
                 $id_compagnie = $compagnie->id_compagnie;
                 $this->addContact($request,$id_compagnie);
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
        $compagnie = Macompagnie::find($request->compagnie['id_compagnie']);
        //$compagnie = new Article();
        if($request->compagnie['logo_comp'])
       {  
           if(strlen($request->compagnie['logo_comp']) < 40 ){
            $compagnie->logo_comp = $request->compagnie['logo_comp'];
           }
           else {
          $logo_comp = $request->compagnie['logo_comp'];
          $name = time().'.' . explode('/', explode(':', substr($logo_comp, 0, strpos($logo_comp, ';')))[1])[1];
          if( $compagnie->logo_comp !=""){
            Storage::disk('local')->delete('images/'.$compagnie->logo_comp);
            }
  
            $image2 = \Image::make($request->compagnie['logo_comp']);     
            Storage::put('images/'.$name, (string) $image2->encode());         
          $compagnie->logo_comp = $name;
        }
        }
        else  {
            $compagnie->logo_comp = "";
        }
                
        $compagnie->nom_societe_comp = $request->compagnie['nom_societe_comp'];
        $compagnie->raison_sociale_comp = $request->compagnie['raison_sociale_comp'];
        $compagnie->RC_comp = $request->compagnie['RC_comp'];
        $compagnie->IF_comp = $request->compagnie['IF_comp'];
        $compagnie->patente_comp = $request->compagnie['patente_comp'];
        $compagnie->cnss_comp = $request->compagnie['cnss_comp'];
        $compagnie->ICE_comp = $request->compagnie['ICE_comp'];
        $compagnie->capitale_comp = $request->compagnie['capitale_comp'];
        $compagnie->taille_comp=$request->compagnie['taille_comp'];
        $compagnie->secteur_activite_comp=$request->compagnie['secteur_activite_comp'];
        // details bancaires
        $compagnie->nom_bank_comp=$request->compagnie['nom_bank_comp'];
        $compagnie->RIB_comp=$request->compagnie['RIB_comp'];
        //$compagnie->cp_comp=$request->compagnie['cp_comp'];
        //$compagnie->ville_comp=$request->compagnie['ville_comp'];
        //$compagnie->pays_comp=$request->compagnie['pays_comp'];
        $compagnie->adresse_comp=$request->compagnie['adresse_comp'];
        $compagnie->email_comp=$request->compagnie['email_comp'];
        $compagnie->GSM_comp=$request->compagnie['GSM_comp'];
        $compagnie->fix_comp=$request->compagnie['fix_comp'];
        $compagnie->fax_comp=$request->compagnie['fax_comp'];
        $compagnie->webSite_comp=$request->compagnie['webSite_comp'];


                $compagnie->save();
                $id_compagnie = $compagnie->id_compagnie;
        $this->updateContact($request,$id_compagnie);
                 return Response()->json(['etat' => true]);
    }



    public function deleteCompagnie($id_compagnie){
        $compagnie=Macompagnie::find($id_compagnie);
        if( $compagnie->logo_comp !=""){
            Storage::disk('local')->delete('images/'.$compagnie->logo_comp);}
        $compagnie->delete();
        $contact = Contact::where('type_contact','=','Compagnie')
        ->where('fk_compte_comp','=',$id_compagnie);  
        $contact->delete(); 
    return Response()->json(['delete'=>true]);        
}
         

public function addContact(Request $request , $id_compagnie){
    for($i=0;$i<count($request->contacts);$i++){
    $contact = new Contact();
    $contact->prenom = $request->contacts[$i]['prenom'];
    $contact->nom = $request->contacts[$i]['nom'];
    $contact->civilite = $request->contacts[$i]['civilite'];
    $contact->fonction = $request->contacts[$i]['fonction'];
    $contact->email = $request->contacts[$i]['email'];
    $contact->fixe = $request->contacts[$i]['fixe'];
    $contact->mobile = $request->contacts[$i]['mobile'];
    $contact->type_contact = "Compagnie";
    $contact->fk_compte_comp = $id_compagnie;

    $contact->save();
    }
    //return Response()->json(['etat' => true]);

 }

 public function updateContact(Request $request , $id_compagnie){

    for($i=0;$i<count($request->suppContacts);$i++){
     $contact = Contact::find($request->suppContacts[$i]['id_contact']);
     $contact->delete();

     }
     for($i=0;$i<count($request->contacts);$i++){
         if (!isset($request->contacts[$i]['id_contact'])) {
             $contact = new Contact();
             $contact->prenom = $request->contacts[$i]['prenom'];
             $contact->nom = $request->contacts[$i]['nom'];
             $contact->civilite = $request->contacts[$i]['civilite'];
             $contact->fonction = $request->contacts[$i]['fonction'];
             $contact->email = $request->contacts[$i]['email'];
             $contact->fixe = $request->contacts[$i]['fixe'];
             $contact->mobile = $request->contacts[$i]['mobile'];
             $contact->type_contact = "Compagnie";
             $contact->fk_compte_comp = $id_compagnie;
             $contact->save();
         }    
     }
     for($i=0;$i<count($request->contacts);$i++){
         if (isset($request->contacts[$i]['id_contact'])) {
     Contact::where('id_contact','=', $request->contacts[$i]['id_contact'])->update([
         "prenom" => $request->contacts[$i]['prenom'],
     "nom" => $request->contacts[$i]['nom'],
     "civilite" => $request->contacts[$i]['civilite'],
     "fonction" => $request->contacts[$i]['fonction'],
     "email" => $request->contacts[$i]['email'],
     "fixe" => $request->contacts[$i]['fixe'],
     "mobile" => $request->contacts[$i]['mobile'],
     "type_contact" => $request->contacts[$i]['type_contact']
     ]);
         }
     }

  }
}
