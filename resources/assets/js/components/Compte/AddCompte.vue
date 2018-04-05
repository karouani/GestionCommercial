<template>
    <div>

        <div class="text-center pull-right" >
    <h2>Ajouter Compte</h2>
    <hr>   
    </div>


        <form @submit.prevent="addCompte">
         <div class="row" > 
         
            <div class="col-md-6">
                <div class="form-group row">
                <label for="exampleFormControlSelect1" class="col-sm-4">Nom Compagnie</label>
                <div class="col-sm-8">
                <select class="form-control custom-select " id="exampleFormControlSelect1" v-model="compte.fk_compagnie" required>
                    <option selected>Choisir une Compagnie</option>
                    <option v-for="compagnie in compagnies" :key="compagnie.id_compagnie" :value="compagnie.id_compagnie">{{compagnie.nom_societe}}</option>
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
                      <textarea name="" id="" cols="40" rows="3" v-model="compte.adresse_compte"></textarea>
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
     </form>
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
                                            <th><a @click="spliceContact(index)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
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
          <button @click="addCompte" class="btn btn-primary mr-20 btn-success">Enregister</button>

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

             
      }),
      

      methods: { 
          testAjoutCompte(){

          },
          addCompte:function(){ 
           console.log(this.compte);
               
              axios.post('/addCompte',{compte: this.compte, contacts: this.contacts, condition_facture: this.condition_facture}).then(response => {  
                    console.log(response.data.id_compte);   
                    console.log('Compte Bien ajouter !');
                     //this.$router.push('/ShowComptes/addsuccess');
                    // this.$router.push('/AddContact/'+response.data.id_compte);
                     this.$router.push('/ShowComptes/addsuccess');  

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
        spliceContact(index){
            this.contacts.splice(index, 1);
        },
        getAllCompagnies(){
            axios.get('/getAllCompagnies').then(
                  response => {
                       
                    this.compagnies= response.data.compagnies;
                    console.log("allCompagnies");
                  });  

        },
 
                     
      },
      mounted(){
            this.getAllCompagnies();
      }

     
       
        
      

    }
    
</script>

<style scoped>
 .btnMarge{
     padding-bottom: 10px;
 }
 .widthCard{
     width: 270px;
     height: 350px;
     
 }
 .widthTextCard{
     width  : 236px;
     height: 13px;
 }
 a {
  color: #999;
  color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    
}
.current {
  color: red;
}
ul {
  padding: 0;
  list-style-type: none;
}
li {
  display: inline;
  margin: 5px 5px;
}

a.first::after {
  content:'...'
}

a.last::before {
  content:'...'
}
.cardbox:hover{
 box-shadow: 1px 2px 2px 2px #c9ced2;
}
ul{
  margin: 0;
  padding: 0;
  list-style: none;
}

</style>
