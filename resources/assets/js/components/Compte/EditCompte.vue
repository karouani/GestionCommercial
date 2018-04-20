<template>
    <div>
    <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowComptes'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
    </div>   
        <div class="text-center pull-right" >
    <h2>Ajouter Compte</h2>
    <hr>   
    </div>


        <form @submit.prevent="updateCompte">
        <div class="row" > 
         
            <div class="col-md-6">
                <div class="form-group row">
                <label for="exampleFormControlSelect1" class="col-sm-4">Nom Compagnie</label>
                <div class="col-sm-8">
                <select class="form-control custom-select " id="exampleFormControlSelect1" v-model="compte.fk_compagnie" required>
                    <option selected>Choisir une Compagnie</option>
                    <option v-for="compagnie in compagnies" :key="compagnie.id_compagnie" :value="compagnie.id_compagnie">{{compagnie.nom_societe_comp}}</option>
                </select>
                </div>
                </div>

                <div class="form-group row">
                    <label for="nom_compte" class="col-sm-4"> Nom_compte</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="nom_compte"  v-model="compte.nom_compte">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Responsable</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="responsable"  v-model="compte.responsable">
                    </div>
                </div>

                <div class="form-group row ">
                <label for="type_compte" class="col-sm-4" >Famille</label>
                <div class="col-sm-8">
                <select class="form-control custom-select " id="type_compte" v-model="compte.type_compte" >
                    <option selected>Choisir Type du Compte</option>
                    <option value="Client">Client</option>
                    <option value="Fournisseur">Fournisseur</option>                   
                </select>
                </div>
                </div>
                <div class="form-group row ">
                    <label for="categorie" class="col-sm-4" > Categorie </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="categorie" v-model="compte.categorie" >
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="raison_social" class="col-sm-4" > Raison_social </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="raison_social" v-model="compte.raison_social" >
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="reference" class="col-sm-4" > Reference </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="reference" v-model="compte.reference" >
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="fixe" class="col-sm-4" >Adresse</label>
                    <div class="col-sm-8">
                      <textarea name="" id="" class="form-control" rows="3" v-model="compte.adresse_compte"></textarea>
                    </div>
                </div>
                
            
            </div>
            <div class="col-md-6"> 
                <div class="form-group row ">
                    <label for="fixe" class="col-sm-4" > Fixe</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="fixe" v-model="compte.fixe" >
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="portable" class="col-sm-4" > Portable </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="portable" v-model="compte.portable">
                    </div>
                </div>    
                <div class="form-group row ">
                    <label for="fax" class="col-sm-4" > Fax </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="fax" v-model="compte.fax">
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="email" class="col-sm-4" > Email </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="email" v-model="compte.email">
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="site_web" class="col-sm-4" > Site_web </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="site_web" v-model="compte.site_web">
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="secteur_activite" class="col-sm-4" > Secteur_activite </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="secteur_activite" v-model="compte.secteur_activite">
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="taille" class="col-sm-4" > Taille </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="taille" v-model="compte.taille">
                    </div>
                </div>                                                
                <div class="form-group row ">
                    <label for="RC" class="col-sm-4" >RC </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="RC" v-model="compte.RC">
                    </div>
                </div>   

                

            </div> 
    </div>
     
     <hr>
     <h4>Ajouter Contacts</h4>
     <hr>
     <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>civilite</th>
                                        <th>prenom</th>
                                        <th>nom</th>                                       
                                        <th>fonction</th>
                                        <th>email</th>
                                        <th>fixe</th>
                                        <th>mobile</th> 
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(contact,index) in contacts" :key="index">
                                        <th><input type="text" class="form-control" id="civilite"  v-model="contact.civilite"></th>
                                        <th><input type="text" class="form-control" id="prenom"  v-model="contact.prenom"></th>
                                        <th><input type="text" class="form-control" id="nom"  v-model="contact.nom"></th>

                                        <th><input type="text" class="form-control" id="fonction" v-model="contact.fonction" ></th>
                                        <th><input type="text" class="form-control" id="email" v-model="contact.email" ></th>
                                        <th><input type="text" class="form-control" id="fixe" v-model="contact.fixe" ></th>
                                        <th><input type="text" class="form-control" id="mobile" v-model="contact.mobile"></th> 
                                            <th><a @click="spliceContact(index,contact)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                                        </tr>
                                        <th><input type="text" class="form-control" id="civilite"  v-model="contact.civilite"></th>
                                        <th><input type="text" class="form-control" id="prenom"  v-model="contact.prenom"></th>
                                        <th><input type="text" class="form-control" id="prenom"  v-model="contact.nom"></th>
                                        <th><input type="text" class="form-control" id="fonction" v-model="contact.fonction" ></th>
                                        <th><input type="text" class="form-control" id="email" v-model="contact.email" ></th>
                                        <th><input type="text" class="form-control" id="fixe" v-model="contact.fixe" ></th>
                                        <th><input type="text" class="form-control" id="mobile" v-model="contact.mobile"></th> 
                                        <th><a    @click="pushContact()"  class="btn btn-success"  ><i class="fas fa-plus-circle"></i></a></th>
                                    </tbody>
                                </table>
                            </div>
             </div>
     </div>
        <hr>
     <h4>Ajouter Conditions facture</h4>
     <hr>
               <div class="row" > 
             
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="devise" class="col-sm-4"> devise</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="devise"  v-model="condition_facture.devise">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="remise" class="col-sm-4"> remise</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="remise"  v-model="condition_facture.remise">
                    </div>
                </div>
                 <div class="form-group row">
                <label for="delai_paiement" class="col-sm-4">delai_paiement</label>
                <div class="col-sm-8">
                
                    <input class="form-control" type="date" value="2011-08-19" id="delai_paiement" v-model="condition_facture.delai_paiement">
                    </div>
                
                </div>
                 <div class="form-group row">
                    <label for="remarques" class="col-sm-4"> remarques </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="remarques" v-model="condition_facture.remarques" >
                    </div>
                </div>
            </div>
            <div class="col-md-6"> 
  
   
            </div> 
    </div>
          <button  class="btn btn-primary mr-20 btn-success">Enregister</button>
</form>
    </div>
</template>

<script>

    export default{ 
        
          data: () => ({
             isActive: true,
              breadcrumbstree : "breadcrumbs-tree",

            
            
            
              // objet test sur affichage , ajout , recherche
              Testopen:{
                testAjout : false,
                testAffiche : false,
              },
              testEdit : false,
        
              compte: { 
                    id_compte : 0,
                    nom_compte : "",
                    responsable : "",
                    type_compte : "",
                    categorie : "",
                    raison_social : "",
                    reference : "",
                    fixe : "",
                    portable : "",
                    fax : "",
                    email : "",
                    site_web  : "",
                    secteur_activite : "",
                    taille : "",
                    RC : "",
                    fk_compagnie : "",
                    adresse_compte:""
              },



              // tableau des articles 
              comptes :[],

              contact: { 
                    id_contact : 0,
                    prenom : "",
                    nom : "",
                    civilite : "",
                    fonction : "",
                    email : "",
                    fixe : "",
                    mobile : "",
                    fk_compte_comp : 0,
              },
              condition_facture : { 
                    id_condition : 0,
                    devise: "",
                    remise: "",
                    delai_paiement : "",
                    remarques: "",
                    fk_compte : 0,

              },
              
              
              // tableau des articles 
              contacts :[],
              compagnies :[],
              suppContacts :[],
             
      }),
      

      methods: {
         updateCompte: function(){
              /*  console.log(this.compte)
                console.log('----- contact')
                console.log(this.contacts)
                console.log('condition_facture')
                console.log(this.condition_facture)*/

                  axios.post('/updateCompte',{compte: this.compte, contacts: this.contacts, condition_facture: this.condition_facture,suppContacts: this.suppContacts}).then( response => {             
                    this.$router.push({ name: 'ShowComptes', params: { success: "editsuccess"  }});
                  
                  });
                  
           
        },           
          testAjoutCompte(){

          },
          addCompte:function(){ 
           
               
              axios.post('/addCompte',{compte: this.compte, contacts: this.contacts, condition_facture: this.condition_facture,}).then(response => {  
                    console.log(response.data.id_compte);   
                    console.log('Compte Bien ajouter !');
                     //this.$router.push('/ShowComptes/addsuccess');
                     this.$router.push('/AddContact/'+response.data.id_compte);

                  });
            
        },
        pushContact(){
            console.log(this.contact);
                  
            this.contacts.push({prenom:this.contact.prenom,
                                nom : this.contact.nom,
                                civilite : this.contact.civilite,
                                fonction : this.contact.fonction,
                                email : this.contact.fonction,
                                fixe : this.contact.email,
                                mobile : this.contact.mobile,
                                fk_compte_comp: this.contact.fk_compte_comp,
            });
            console.log('-----addContacts')
            console.log(this.contacts)

            this.contact =  { 
                    id_contact : 0,
                    prenom : "",
                    nom : "",
                    civilite : "",
                    fonction : "",
                    email : "",
                    fixe : "",
                    mobile : "",
                    fk_compte_comp : 0,
              };
            
        },
        spliceContact(index,contact){
            this.contacts.splice(index, 1);
                        this.suppContacts.push(contact);
                        console.log('supp ----------');
                        console.log(this.suppContacts)
        },
        getAllCompagnies(){
            axios.get('/getAllCompagnies').then(
                  response => {
                       
                    this.compagnies= response.data.compagnies;
                    console.log("allCompagnies");
                  });  

        },
        getCompte:function(id_compte){
                  axios.get('/getCompte/'+id_compte).then(
                  response => {
                       
                    this.compte= response.data.compte;
                   
                  });     
        },
        getContacts:function(id_compte){
                  axios.get('/getContacts/'+id_compte).then(
                  response => {
                       
                    this.contacts= response.data.contacts;
                    console.log('-------------------');
                    console.log(this.contacts);
                  });     
        },
        getCondtionFacture:function(id_compte){
                  axios.get('/getCFacture/'+id_compte).then(
                  response => {
                       console.log("Cfacture")
                    this.condition_facture= response.data.condition_facture[0];
                   console.log(this.condition_facture)
                  });     
        },
 
                     
      },
      mounted(){
            this.getAllCompagnies();
            this.compte.id_compte = this.$route.params.id_compte;
            this.getCompte(this.compte.id_compte);
            this.getContacts(this.compte.id_compte);
            this.getCondtionFacture(this.compte.id_compte);
      }

     
       
        
      

    }
    
</script>

<style scoped>
 
 a {
  color: #999;
  color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    
}
.fontsize{

    font-size: 1.30rem;
}
</style>
