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
          //dd($id_compte->test);
        $compte= Compte::find($id_compte);
       // $libelle_famille = DB::table('maCompagnies')->select('libelle_famille')->where('id_famille','=',$article->fk_famille)->get();      
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
        $compte->fk_compagnie = $request->compte['fk_compagnie'];

        $compte->save();
       // $contacts = $request->contacts[0]['prenom'];
       $id_compte = $compte->id_compte;
       $this->addContact($request,$id_compte);
       $this->addCondtionFacture($request,$id_compte);
        
        return Response()->json(['etat' => true ]);
        

     }

     public function updateCompte(Request $request){

        $compte = Compte::find($request->id_compte);
        $compte->nom_compte = $request->nom_compte;
        $compte->responsable = $request->responsable;
        $compte->type_compte = $request->type_compte;
        $compte->categorie = $request->categorie;
        $compte->raison_social = $request->raison_social;
        $compte->reference = $request->reference;
        $compte->fixe = $request->fixe;
        $compte->portable = $request->portable;
        $compte->fax = $request->fax;
        $compte->email = $request->email;
        $compte->site_web = $request->site_web;
        $compte->secteur_activite = $request->secteur_activite;
        $compte->taille = $request->taille;
        $compte->RC = $request->RC;
        $compte->fk_compagnie = $request->fk_compagnie;

        $compte->save();
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
     public function updateContact(Request $request){

        $contact = Contact::where('fk_compte', $request->id_compte);
        $contact->prenom = $request->prenom;
        $contact->nom = $request->nom;
        $contact->civilite = $request->civilite;
        $contact->fonction = $request->fonction;
        $contact->email = $request->email;
        $contact->fixe = $request->fixe;
        $contact->mobile = $request->mobile;
        $contact->fk_compte = $request->fk_compte;

        $contact->save();
        return Response()->json(['etat' => true]);

     }

     public function getContact($fk_compte){
        $contact= Contact::where('fk_compte', $fk_compte)->get();
       // $libelle_famille = DB::table('maCompagnies')->select('libelle_famille')->where('id_famille','=',$article->fk_famille)->get();      
        return Response()->json(['contact' => $contact ]);
     }

     public function addCondtionFacture(Request $request, $id_compte){
        
        $CFacture = new Condition_facture();
        $CFacture->devise = $request->condition_facture['devise'];
        $CFacture->remise = $request->condition_facture['remise'];
        $CFacture->delai_paiement = $request->condition_facture['delai_paiement'];
        $CFacture->remarques = $request->condition_facture['remarques'];
        $CFacture->fk_compte = $id_compte;
        $CFacture->save();
       // return Response()->json(['etat' => true]);

     }
     public function updateCondtionFacture(Request $request){
        $CFacture = Condition_facture::find($request->id_condition);
        $CFacture->devise = $request->devise;
        $CFacture->remise = $request->remise;
        $CFacture->delai_paiement = $request->delai_paiement;
        $CFacture->remarques = $request->remarques;
        $CFacture->fk_compte = $request->fk_compte;
        $CFacture->save();
        return Response()->json(['etat' => true]);

     }

}
