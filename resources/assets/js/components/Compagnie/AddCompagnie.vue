
<template>
 <div>
    
 <div>
      <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
    <!-- button pour afficher tous les users-->
        <router-link class="btn btn-primary mb-3 retour float-right " :to="'/getCompagnies'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>

        </div>
  
    </div>
    <h2>Ajouter Compagnie</h2>
    <hr>   
    </div>
   <div class=" container colBackround">
<br>
<div class="text-center">
    <h4>Informations Compagnie</h4>
</div>
<hr>
  <!-- formulaire pour Ajouter un user -->
  <form @submit.prevent="store">
         <div class="row" > 
         
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="reference_art" class="col-sm-4">Raison Sociale</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="reference_art"  v-model="compagnie.raison_sociale_comp">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4" for="type_art"> Nom Compagnie </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="type_art" v-model="compagnie.nom_societe_comp" >
                </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4" for="designation"> RC </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="designation" v-model="compagnie.RC_comp" >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4" for="IF"> I.F </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="IF" v-model="compagnie.IF_comp" >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4" for="prix_ht_achat"> Patente </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="prix_ht_achat" v-model="compagnie.patente_comp" >
                    </div>
                </div>
                
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                    <label class="col-sm-4" for="cnss"> C.N.S.S</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="cnss" v-model="compagnie.cnss_comp" >
                    </div>
                </div> 
                <div class="form-group row">
                    <label class="col-sm-4" for="ICE"> I.C.E </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="ICE" v-model="compagnie.ICE_comp">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4" for="capitale"> Capitale </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="capitale" v-model="compagnie.capitale_comp">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4" for="taille_comp"> Taille Compagnie </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="taille_comp" v-model="compagnie.taille_comp">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4" for="secteur_activite"> Secteur D'activité </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="secteur_activite" v-model="compagnie.secteur_activite_comp">
                    </div>
                </div>
           
    </div>
    </div>
    <hr>
 <div class="text-center ">
                  
                    <h4>Details bancaires </h4>
                    
                </div>
                <hr>
     <div class="row" > 
         
            <div class="col-md-6">
                 <div class="form-group row">
                    <label class="col-sm-4" for="nom_bank"> Nom de Banque </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="nom_bank" v-model="compagnie.nom_bank_comp">
                    </div>
                </div>
            </div>
            <div class="col-md-6">

                <div class="form-group row">
                    <label class="col-sm-4" for="RIB"> R.I.B </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="RIB" v-model="compagnie.RIB_comp">
                    </div>
                </div>
            </div>
     </div>
<hr>
      <div class="text-center ">
                  
                    <h4>Contact </h4>
                    
                </div>
                <hr>
     <div class="row" > 
         
            <div class="col-md-6">
                 <div class="form-group row">
                    <label class="col-sm-4" for="email"> E-mail </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="email" v-model="compagnie.email_comp">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4" for="fix_comp">Fix </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="fix_comp" v-model="compagnie.fix_comp">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4" for="fax_comp">Fax </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="fax_comp" v-model="compagnie.fax_comp">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4" for="GSM_comp">GSM </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="GSM_comp" v-model="compagnie.GSM_comp">
                    </div>
                </div>
            </div>
            <div class="col-md-6">

                <div class="form-group row">
                    <label class="col-sm-4" for="webSite_comp">Site Web </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="webSite_comp" v-model="compagnie.webSite_comp">
                    </div>
                </div>
                 <div class="form-group row">
      <label for="inputPassword4" class="col-sm-4">Logo</label>
 <div class="input-group mb-3 col-sm-8">
  <div class="input-group-prepend">
    <span class="input-group-text">Upload</span>
  </div>
  <div class="custom-file">
    <input type="file" class="custom-file-input"  v-on:change="onImageChange"  id="inputGroupFile01">
    <label class="custom-file-label"  for="inputGroupFile01">{{fileName}}</label>
  </div>
</div>
 </div>
 
                 <div class="form-group row">
                    <label class="col-sm-4" for="adresse_comp">Adresse</label>
                    <div class="col-sm-8">
                      <textarea name="" id="" class="form-control" rows="3" v-model="compagnie.adresse_comp"></textarea>
                   
                    </div>
                </div>
            </div>
     </div>
        <hr>
     <h4 class="text-center">Ajouter Contacts</h4>
     <hr>
     <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Civilité</th>
                                        <th>Prénom</th>
                                        <th>Nom</th>                                       
                                        <th>Fonction</th>
                                        <th>Email</th>
                                        <th>Fix</th>
                                        <th>Téléphone</th> 
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(contact,index) in contacts" :key="index">
                                         <th> 
                                            <select class="form-control custom-select " id="exampleFormControlSelect1" v-model="contact.civilite" >
                                            <option selected>Choisir une Civilité</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mme">Mme</option>
                                            <option value="Mlle">Mlle</option>
                                            </select>
                                        </th>
                                        <th><input type="text" class="form-control" id="prenom"  v-model="contact.prenom"></th>
                                        <th><input type="text" class="form-control" id="nom"  v-model="contact.nom"></th>

                                        <th><input type="text" class="form-control" id="fonction" v-model="contact.fonction" ></th>
                                        <th><input type="text" class="form-control" id="email" v-model="contact.email" ></th>
                                        <th><input type="text" class="form-control" id="fixe" v-model="contact.fixe" ></th>
                                        <th><input type="text" class="form-control" id="mobile" v-model="contact.mobile"></th> 
                                            <th><a @click="spliceContact(index)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                                        </tr>
                                         <th> 
                                            <select class="form-control custom-select " id="exampleFormControlSelect1" v-model="contact.civilite" >
                                            <option selected>Choisir une civilite</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mme">Mme</option>
                                            <option value="Mlle">Mlle</option>
                                            </select>
                                        </th>
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
     <button  class="btn btn-primary mr-20 btn-success">Enregister</button>
     
     </form>
<br>
 </div>
 </div>
  <!-- fin formulaire -->
 </div>
</template>

<script>
export default {
  
  data : () => ({
    fileName : "Choose File",
    compagnie: {
      id_compagnie:0,
      nom_societe_comp:"",
      raison_sociale_comp:"",
      RC_comp:"",
      IF_comp:"",
      patente_comp:"",
      cnss_comp:"",
      ICE_comp:"",
      capitale_comp:"",
      taille_comp:"",
      secteur_activite_comp:"",


      nom_bank_comp:"",
      RIB_comp:"",
      //cp_comp:"",
      //ville_comp:"",
      //pays_comp:"",
      adresse_comp:"",
      email_comp:"",
      GSM_comp:"",
      fix_comp:"",
      fax_comp:"",
      webSite_comp:"",
      logo_comp:"",
      
    },
contact: { 
                    id_contact : 0,
                    prenom : "",
                    nom : "",
                    civilite : "",
                    fonction : "",
                    email : "",
                    fixe : "",
                    mobile : "",
                    type_contact:"",
                    fk_compte_comp : 0,
              },
               contacts :[],
    macompagnies:[],
  }),

  methods:{
     // upload image
    onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                this.fileName=files[0].name;

                if (!files.length)
                    return;
                this.createImage(files[0]);
    },

    createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.compagnie.logo_comp = e.target.result;
                };
                reader.readAsDataURL(file);
    },
     // ajouter un user
    store() {
console.log(this.compagnie.logo_comp)
                axios.post('/addCompagnie',{compagnie: this.compagnie, contacts: this.contacts}) 
                
                    .then(response => {
                         // console.log("test");
                        this.$router.push('/getCompagnies/add');
                    })
                    .catch(function (resp) {
                       
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
        spliceContact(index){
            this.contacts.splice(index, 1);
        },
   
       
  fetchData () {
      this.store();
  },
  created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
  watch:{
          // call again the method if the route changes
    '$route': 'fetchData', 
  }

  },


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
/*.fontsize{

    font-size: 1.30rem;
}*/
.colBackround{
    background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
}
.retour {
    border-left-color:#0000009e;
    border-left-width: 3px;
}
</style>