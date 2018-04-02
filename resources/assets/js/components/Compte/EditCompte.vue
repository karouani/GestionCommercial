<template>
    <div>

        <div class="text-center pull-right" >
    <h2>Ajouter Compte</h2>
    <hr>   
    </div>


        <form @submit.prevent="updateCompte">
         <div class="row" > 
         
            <div class="col-md-6">
                <div class="form-group">
                <label for="exampleFormControlSelect1">Nom Compagnie</label>
                <select class="form-control custom-select " id="exampleFormControlSelect1" v-model="compte.fk_compagnie" required>
                    <option selected>Choisir une Compagnie</option>
                    <option v-for="compagnie in compagnies" :key="compagnie.id_compagnie" :value="compagnie.id_compagnie">{{compagnie.nom_societe}}</option>
                </select>
                </div>

                <div class="form-group">
                    <label for="nom_compte"> nom_compte</label>
                    <input type="text" class="form-control" id="nom_compte"  v-model="compte.nom_compte">
                </div>
                <div class="form-group">
                    <label for="responsable"> responsable</label>
                    <input type="text" class="form-control" id="responsable"  v-model="compte.responsable">
                </div>

                <div class="form-group">
                <label for="type_compte">famille</label>
                <select class="form-control custom-select " id="type_compte" v-model="compte.type_compte" >
                    <option selected>Choisir Type du Compte</option>
                    <option value="Client">Client</option>
                    <option value="Fournisseur">Fournisseur</option>                   
                </select>
                </div>
                <div class="form-group">
                    <label for="categorie"> categorie </label>
                    <input type="text" class="form-control" id="categorie" v-model="compte.categorie" >
                </div>
                <div class="form-group">
                    <label for="raison_social"> raison_social </label>
                    <input type="text" class="form-control" id="raison_social" v-model="compte.raison_social" >
                </div>
                <div class="form-group">
                    <label for="reference"> reference </label>
                    <input type="text" class="form-control" id="reference" v-model="compte.reference" >
                </div>
                <div class="form-group">
                    <label for="fixe"> fixe</label>
                    <input type="text" class="form-control" id="fixe" v-model="compte.fixe" >
                </div>
            
            </div>
            <div class="col-md-6"> 
                <div class="form-group">
                    <label for="portable"> portable </label>
                    <input type="text" class="form-control" id="portable" v-model="compte.portable">
                </div>    
                <div class="form-group">
                    <label for="fax"> fax </label>
                    <input type="text" class="form-control" id="fax" v-model="compte.fax">
                </div>
                <div class="form-group">
                    <label for="email"> email </label>
                    <input type="text" class="form-control" id="email" v-model="compte.email">
                </div>
                <div class="form-group">
                    <label for="site_web"> site_web </label>
                    <input type="text" class="form-control" id="site_web" v-model="compte.site_web">
                </div>
                <div class="form-group">
                    <label for="secteur_activite"> secteur_activite </label>
                    <input type="text" class="form-control" id="secteur_activite" v-model="compte.secteur_activite">
                </div>
                <div class="form-group">
                    <label for="taille"> taille </label>
                    <input type="text" class="form-control" id="taille" v-model="compte.taille">
                </div>                                                
                <div class="form-group">
                    <label for="RC">RC </label>
                    <input type="text" class="form-control" id="RC" v-model="compte.RC">
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
                <div class="form-group">
                    <label for="devise"> devise</label>
                    <input type="text" class="form-control" id="devise"  v-model="condition_facture.devise">
                </div>
                <div class="form-group">
                    <label for="remise"> remise</label>
                    <input type="text" class="form-control" id="remise"  v-model="condition_facture.remise">
                </div>
            <div class="form-group">
            <label for="example-date-input">Date</label>
            <div >
                <input class="form-control" type="date" value="2011-08-19" id="example-date-input" v-model="condition_facture.delai_paiement" >
            </div>
            </div>
                 <div class="form-group">
                    <label for="remarques"> remarques </label>
                    <input type="text" class="form-control" id="remarques" v-model="condition_facture.remarques" >
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
                    fk_compte : 0,
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
                    this.$router.push('/ShowComptes/editsuccess');  
                    
                  
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
                                fk_compte: this.contact.fk_compte,
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
                    fk_compte : 0,
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
 
 

</style>
