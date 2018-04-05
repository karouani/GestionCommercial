<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compte;
use App\Contact;
use App\Condition_facture;
use Illuminate\Support\Facades\DB;

class CompteController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getComptes(){

         $listeComptes = Compte::paginate(10);
         return Response()->json(['comptes' => $listeComptes ]);
      }

      public function getCompte($id_compte){
        $compte= Compte::find($id_compte);
        return Response()->json(['compte' => $compte ]);
     }

     public function addCompte(Request $request){
        $compte = new Compte();
        $compte->nom_compte = $request->compte['nom_compte'];
        $compte->responsable = $request->compte['responsable'];
        $compte->type_compte = $request->compte['type_compte'];
        $compte->categorie = $request->compte['categorie'];
        $compte->raison_social = $request->compte['raison_social'];
        $compte->reference = $request->compte['reference'];
        $compte->fixe = $request->compte['fixe'];
        $compte->portable = $request->compte['portable'];
        $compte->fax = $request->compte['fax'];
        $compte->email = $request->compte['email'];
        $compte->site_web = $request->compte['site_web'];
        $compte->secteur_activite = $request->compte['secteur_activite'];
        $compte->taille = $request->compte['taille'];
        $compte->RC = $request->compte['RC'];
        $compte->adresse_compte = $request->compte['adresse_compte'];
        $compte->fk_compagnie = $request->compte['fk_compagnie'];

        $compte->save();
       // $contacts = $request->contacts[0]['prenom'];
       $id_compte = $compte->id_compte;
       $this->addContact($request,$id_compte);
      $this->addCondtionFacture($request,$id_compte);
        
        return Response()->json(['etat' => true ]);
        

     }

     public function updateCompte(Request $request){

        $compte = Compte::find($request->compte['id_compte']);
        $compte->nom_compte = $request->compte['nom_compte'];
        $compte->responsable = $request->compte['responsable'];
        $compte->type_compte = $request->compte['type_compte'];
        $compte->categorie = $request->compte['categorie'];
        $compte->raison_social = $request->compte['raison_social'];
        $compte->reference = $request->compte['reference'];
        $compte->fixe = $request->compte['fixe'];
        $compte->portable = $request->compte['portable'];
        $compte->fax = $request->compte['fax'];
        $compte->email = $request->compte['email'];
        $compte->site_web = $request->compte['site_web'];
        $compte->secteur_activite = $request->compte['secteur_activite'];
        $compte->taille = $request->compte['taille'];
        $compte->RC = $request->compte['RC'];
        $compte->adresse_compte = $request->compte['adresse_compte'];
        $compte->fk_compagnie = $request->compte['fk_compagnie'];
        

        $compte->save();
        $id_compte = $compte->id_compte;
        $this->updateContact($request,$id_compte);
        $this->updateCondtionFacture($request,$id_compte);

        return Response()->json(['etat' => true]);
     }

     public function deleteCompte($id_compte){

        $compte = Compte::find($id_compte);
        $compte->delete();
        $contact = Contact::where('fk_compte','=',$id_compte);  
        $contact->delete();   
        $Condition_facture = Condition_facture::where('fk_compte','=',$id_compte)->delete(); 
        return Response()->json(['delete' => 'true']);
     }

     public function searchComptes($nomCompte){
        $listeComptes = Compte::where('nom_compte','like', '%' .$nomCompte . '%')->orWhere('responsable','like', '%' .$nomCompte . '%')->paginate(10);
        return Response()->json(['comptes' => $listeComptes ]);
     }


     public function addContact(Request $request , $id_compte){
        for($i=0;$i<count($request->contacts);$i++){
        $contact = new Contact();
        $contact->prenom = $request->contacts[$i]['prenom'];
        $contact->nom = $request->contacts[$i]['nom'];
        $contact->civilite = $request->contacts[$i]['civilite'];
        $contact->fonction = $request->contacts[$i]['fonction'];
        $contact->email = $request->contacts[$i]['email'];
        $contact->fixe = $request->contacts[$i]['fixe'];
        $contact->mobile = $request->contacts[$i]['mobile'];
        $contact->fk_compte = $id_compte;

        $contact->save();
        }
        //return Response()->json(['etat' => true]);

     }
     public function updateContact(Request $request , $id_compte){

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
                $contact->fk_compte = $id_compte;
                $contact->save();
            }    
        }
        for($i=0;$i<count($request->contacts);$i++){
            if (isset($request->contacts[$i]['id_contact'])) {
        Contact::where('id_contact','=', $request->contacts[$i]['id_contact'])->update(["prenom" => $request->contacts[$i]['prenom'],
        "nom" => $request->contacts[$i]['nom'],
        "civilite" => $request->contacts[$i]['civilite'],
        "fonction" => $request->contacts[$i]['fonction'],
        "email" => $request->contacts[$i]['email'],
        "fixe" => $request->contacts[$i]['fixe'],
        "mobile" => $request->contacts[$i]['mobile']]);
            }
        }
 
     }
     public function getContacts($fk_compte){
        $contacts= Contact::where('fk_compte', $fk_compte)->get();
       // $libelle_famille = DB::table('maCompagnies')->select('libelle_famille')->where('id_famille','=',$article->fk_famille)->get();      
        return Response()->json(['contacts' => $contacts ]);

     }
     public function addCondtionFacture(Request $request, $id_compte){
        
        $CFacture = new Condition_facture();
        $CFacture->devise = $request->condition_facture['devise'];
        $CFacture->remise = $request->condition_facture['remise'];
        $CFacture->delai_paiement = $request->condition_facture['delai_paiement'];
        $CFacture->remarques = $request->condition_facture['remarques'];
        $CFacture->fk_compte = $id_compte;
        $CFacture->save();

     }
     public function updateCondtionFacture(Request $request , $id_compte){
        $CFacture = Condition_facture::find($request->condition_facture['id_condition']);
        $CFacture->devise = $request->condition_facture['devise'];
        $CFacture->remise = $request->condition_facture['remise'];
        $CFacture->delai_paiement = $request->condition_facture['delai_paiement'];
        $CFacture->remarques = $request->condition_facture['remarques'];
        $CFacture->fk_compte = $id_compte;
        $CFacture->save();

     }

     public function getCondtionFacture($fk_compte){
        $condition_facture= Condition_facture::where('fk_compte', $fk_compte)->get();
        return Response()->json(['condition_facture' => $condition_facture ]);
     }


       //------------------------ pour deviiis
     public function getClients(){

        $listeClients = Compte::where('type_compte','=','Client')->get();
        return Response()->json(['comptes' => $listeClients ]);
     }
     public function getClient($id_compte){

        $compte = Compte::find($id_compte);
        return Response()->json(['compte' => $compte ]);
     }

     public function getRemise($fk_compte){

        $remise = Condition_facture::where('fk_compte','=',$fk_compte)->get();

        return Response()->json(['conditions_remise' => $remise ]);
     }

}
