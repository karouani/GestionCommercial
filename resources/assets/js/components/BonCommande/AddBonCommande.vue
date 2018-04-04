
<template>
<div class=" container colBackround">
<div class="row">
    <div class="col">
        <br>
    <h5><i class="far fa-file"></i> Ajouter un bon de commande</h5>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Compte  </label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" placeholder="">
                </div>
            </div>
                <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Devis</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" placeholder="">
                </div>
            </div>
                <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Date</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" placeholder="">
                </div>
            </div>
                <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Validité  </label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" placeholder="">
                </div>
            </div>
                <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Objet  </label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" placeholder="">
                </div>
            </div>
          
    </div>
    <div class="col-md-6 col-sm-12">
        
        <div class="container  infoClient">
            <label for="">infogerence </label>
            <div class="form-group row">
            <div class="col-sm-10">
            <textarea placeholder="address client" class="AdressClient" name="" id="" cols="50" rows="4"></textarea>
            </div>
         </div>
        </div>
    </div>
</div>
<hr>
<div class="row"> 
    <div class="col">
       <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                    <th>Article</th>
                                    <th>Quantite</th>
                                    <th>Remise</th>
                                    <th>majoration</th>
                                    <th>Prix HT</th>
                                    <th>TVA</th>
                                    <th>Total HT</th>
                                    </tr>  
                                    </thead>
                                    <tbody>
                             <tr v-for="(commande,index) in commandes" :key="index" >
                            <th>  <input class="form-control"  type="text" v-model="commande.fk_article" disabled hidden>
                           <input class="form-control"  type="text" v-model="commande.desig" disabled >
                           
                            </th>
                            <th><input class="form-control"  type="text" v-model="commande.quantite_cmd" ></th>
                            <th>  <input class="form-control"  type="text" v-model="commande.remise_cmd" ></th> 
                            <th>  <input class="form-control"  type="text" v-model="commande.majoration_cmd" ></th> 
                            <th>  <input class="form-control"  type="text" v-model="commande.prix_ht" ></th> 
                                                        <th>  <input class="mr-4"  type="text" v-model="commande.fk_tva_cmd" disabled hidden>
                             <select class="form-control custom-select " id="fk_tva_cmd" v-model="commande.fk_tva_cmd" >
                            <option selected>Choisir Tva</option>
                            <option v-for="tva in tvas" :key="tva.id_tva" :value="tva.id_tva">{{tva.taux_tva}}</option>
                            </select>
                            
                            </th> 
                            <th>  <input class="form-control"  type="text" v-model="commande.totalHT">
                           
                            </th>
                                            <th><a @click="removeRow(index)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                                        </tr>
                                        <th>
                                        <select class="form-control custom-select " id="fk_article" v-model="commande.fk_article" @change=" getPrixArticle()">
                                        <option selected>Choisir Article</option>
                                        <option v-for="article in articles.data" :key="article.id_article" :value="article.id_article">{{article.designation}}</option>
                                         </select>
                                        </th>
                                        <th><input class="form-control"  type="text" v-model="commande.quantite_cmd"></th>
                                        <th><input class="form-control"  type="text" v-model="commande.remise_cmd" ></th>
                                        <th><input class="form-control"  type="text" v-model="commande.majoration_cmd"></th>
                                        <th><input class="form-control"  type="text" v-model="commande.prix_ht"></th>
                                        <th>
                                        <select class="form-control custom-select " id="fk_tva_cmd" v-model="commande.fk_tva_cmd" >
                                            <option selected>Choisir Tva</option>
                                            <option v-for="tva in tvas" :key="tva.id_tva" :value="tva.id_tva">{{tva.taux_tva}}</option>
                                        </select>   
                                        </th>
                                        <th><input class="mr-4"  type="text" v-model="commande.totalHT"></th>
                                        <th><a     @click="addRow(commande)" class="btn btn-success"  ><i class="fas fa-plus-circle"></i></a></th>
                                    </tbody>
                                </table>
                            </div>
             </div>
     </div>
    
    
    
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-4 col-form-label">Date Limit</label>
                <div class="col-sm-8">
                <input type="text" class="form-control" id="inputPassword" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                    <label for="type_paiement" class="col-sm-4 col-form-label" > Type Paiement </label>
                <div class="col-sm-8">
                <select class="form-control custom-select " id="type_paiement" v-model="modePaiement.type_paiement" >
                    <option selected disabled>Choisir Type de Paiement</option>
                    <option>Cheque</option>
                    <option>Versement</option>
                    <option>Espece</option>
                </select>
                </div>
            </div>
                <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Reference Paiement </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="reference_paiement" v-model="modePaiement.reference_paiement">
                    </div>
                </div> 
                 <div class="form-group row">
                    <label for="date_paiement"  class="col-sm-4 col-form-label" >Date Paiement </label>
                    <div class="col-sm-8">
                    <input type="date" class="form-control" id="date_paiement" v-model="modePaiement.date_paiement">
                    </div>
                </div>  
                <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Remise Total </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="reference_paiement">
                    </div>
                </div>                  
                      

                                 
    </div>
    <div class="col-md-6 col-sm-12">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Total HT </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding " id="staticEmail" v-model="total_prix">
            </div>
         </div>
   
       
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Remise Total (montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding " id="staticEmail" v-model="remise_T">
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label"> Montant Net HT  </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="remise_T">
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">TVA (Montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="remise_T">
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Montant TTC (Montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="remise_T">
            </div>
         </div>
   
 </div>

        
</div>
<br>
<div class="row">
  <div class="col">
                <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Notes </label>
            <div class="col-sm-10">
            <textarea class="noteCondition" name="" id="" cols="80" rows="3"></textarea>
            </div>
         </div>
  </div>
</div>
<br>
<div class="row">
   <div class="col">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Conditions </label>
            <div class="col-sm-10">
            <textarea class="noteCondition" name="" id="" cols="80" rows="3"></textarea>
            </div>
         </div>
   </div>
</div>
<br>


</div>
</template>

<script>

    export default{ 
        contacts: [],
        
          data: () => ({
           
              nameFile : "Choose file",
              // objet test sur affichage , ajout , recherche
              Testopen:{
                testAjout : false,
                testAffiche : false,
              },
              testEdit : false,
              count:"",
              // devi
             bonCommande : { 
            id_bc:0,
            reference_bc:"",
            date_bc:"", 
            type_operation_bc:"",
            objet_bc:"",
            date_emission_bc:"",
            remise_total_bc:"",
            majoration_bc:"",
            date_limit_bc:"",
            introduction_bc:"",  
            conditions_reglements_bc:"",
            notes_bc:"",
            accompte_bc:"",
           fk_status_bc:"",
           fk_compte_bc:"",
            fk_user_bc:"",
      
              },
              // tableau des devis 
              devis :[],
              //tables foreign key 
              status:[],
              tvas:[],
              articles:[],
              comptes:[],
                index:0,
                total_prix:0,
                remise_T:0,
              //commandes
           cmd: {},
              commande:{
                  id_cmd:0,
                quantite_cmd:1,
                remise_cmd:0,
                majoration_cmd:0,
                prix_ht:0,
                fk_article:"",
                fk_document:"",
                fk_tva_cmd:"",
               
               //affichage
               
               desig:"",
                totalHT:0,


                
              },
              commandes:[],
                //mode paiement
                modePaiement:{
                        id_modeP:0,
                        type_paiement:"",
                        reference_paiement:"",
                        date_paiement:"",
                        fk_document:"",

                },
                modePaiements:[],

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
              condition_facture : { 
                    id_condition : 0,
                    devise: "",
                    remise: "",
                    delai_paiement : "",
                    remarques: "",
                    fk_compte : 0,

              },
              contacts : [],
             
      }),
      

      methods: {
                 getCompte:function(id_compte){
                  axios.get('/getCompte/'+id_compte).then(
                  response => {
                       
                    this.compte= response.data.compte;
                    console.log(this.compte)
                  });     
        },
        getContacts:function(id_compte){
                  axios.get('/getContacts/'+id_compte).then(
                  response => {
                       
                    this.contacts= response.data.contacts;
                     console.log(this.contacts)
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


addRow (commande) {
   // console.log(commandes);
    this.commandes.push( {
             
               quantite_cmd:commande.quantite_cmd,
               remise_cmd:commande.remise_cmd,
               majoration_cmd: commande.majoration_cmd,
               prix_ht: commande.prix_ht,
               fk_article:commande.fk_article,
               fk_document: commande.fk_document,
               fk_tva_cmd:commande.fk_tva_cmd,

               desig:commande.desig,
               totalHT:commande.totalHT,
               total_ht:commande.total_ht,
               
    });

},
removeRow(index) {
    this.commandes.splice(index,1);
    //this.$delete(this.commande, index);
    
},


          addDevis(){ 

                
              axios.post('/addDevis',{commandes:this.commandes,devis:this.devi,modePaiements:this.modePaiement}).then(response => {         
                  
                    this.$router.push('/');
                  });
            
        },
       
      getStatus(){

                axios.get('/getStatus')
                .then((response) => {
                    this.status= response.data.status;
                  //  console.log(this.tvas);
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
        countDevis(){

                axios.get('/countDevis')
                .then((response) => {

                    this.devi.reference_d='D'+response.data.count;
                    this.commande.fk_document='D'+response.data.count;
                    this.modePaiement.fk_document='D'+response.data.count;

                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          }, 
            getTvas(){
                axios.get('/getTvas')
                .then((response) => {
                    this.tvas= response.data.tvas;
                 
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          }, 
           getarticles(){
                axios.get('/getArticles')
                .then((response) => {
                 
                    //this.commande.prix_ht=response.data.articles.prix_ht;
                    this.articles = response.data.articles;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
       getPrixArticle(){
           
                axios.get('/getPrixArticle/'+this.commande.fk_article)
                .then((response) => {
                                      //console.log(this.commande.fk_article)


                    this.commande.prix_ht=response.data.article[0].prix_ht_vente;
                    this.commande.fk_tva_cmd=response.data.article[0].fk_tva_applicable;
                    this.commande.desig=response.data.article[0].designation;

                    console.log("yyyy: "+response.data.article[0].designation);
                    //this.articles = response.data.articles;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
           getRemise(){

                axios.get('/getRemise/'+this.devi.fk_compte)
                .then((response) => {
                               //console.log(this.devi.fk_compte)
if(response.data.conditions_remise[0].remise==null){
    this.devi.remise_total_d=0;
}
else
                    this.devi.remise_total_d=response.data.conditions_remise[0].remise;
                    

                    console.log("remise: "+response.data.conditions_remise[0].remise);
                    //this.articles = response.data.articles;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
           getClients(){
                axios.get('/getClients')
                .then((response) => {
                 
                    //this.commande.prix_ht=response.data.articles.prix_ht;
                    this.comptes = response.data.comptes;
                    //console.log('clients:'+this.comptes);
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
          testt(){
              console.log('ooook')
          }
      

    },
    computed:{

            totalHTaxe(){
                            console.log('calcuuul');

             let remise_art=this.commande.remise_cmd;
             let majoration_art=this.commande.majoration_cmd;
             let quantite_art=this.commande.quantite_cmd;
              let prix_v=this.commande.prix_ht;
             let test=(prix_v - remise_art) + majoration_art;
             console.log('test:'+majoration_art)
this.commande.totalHT=(+prix_v + +majoration_art - remise_art)*quantite_art;
            // return  this.commande.total_ht;

          },
            TotalDevis(){
                let sum=0;
                for (let index = 0; index < this.commandes.length; index++) {
                      sum = +sum + (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd;
                     // sum= +this.commandes[index].totalHT ;
                         console.log('pushhh : '+index)
                    }
            this.total_prix = +sum + +this.commande.totalHT;
                                     console.log('sum : '+this.total_prix)

this.remise_T=this.total_prix*(this.devi.remise_total_d/100);
            },
          
    },
    watch:{
      
        'commande': {
                handler: function(){
                    this.totalHTaxe;
                    this.TotalDevis;

                    },
                deep:true
        },
            commandes: {
                handler: function(){
                    console.log('pushhh')
                                    let sum=0;

                    for (let index = 0; index < this.commandes.length; index++) {
                     this.commandes[index].totalHT  = (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd;
                          sum = +sum + (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd;
                     // sum= +this.commandes[index].totalHT ;
                         console.log('pushhh : '+index)
                    }
            this.total_prix = +sum + +this.commande.totalHT;
                },
                deep : true
            },
            
    },

     mounted(){
           

            console.log('----------------')
            console.log(this.$route.params.id_compte + " / "+ this.$route.params.reference_bc+
            " / "+ this.$route.params.currentDate )
            

          this.getCompte(this.$route.params.id_compte);
          this.getContacts(this.$route.params.id_compte);
          this.getCondtionFacture(this.$route.params.id_compte); 

          this.getStatus();
          this.countDevis();
          this.getTvas();
          this.getarticles();
          this.getClients();
         
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
.mr-4{
    margin-right: 0rem!important;
    width:100px;
}
.colBackround{
    background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
}
.infoClient{

    background-color:  #42a5f529;

}
.AdressClient{
    width: 121%;
}

.noteCondition{
    width: 77%;
}
.calculePadding{
    padding-left: 50%;
}
</style>


 