
<template>
    <div>
        <div class="text-center">
    <h2>Ajouter Bon de Commande</h2>
    <hr>
    </div>
             <!-- ajouter devis  -->
        <form   @submit.prevent="addDevis">
         <div class="row" > 
         
            <div class="col-md-6">
                <div class="form-group">
                    <label for="reference_d"> Reference</label>
                    <input type="text" class="form-control" id="reference_d" :value="bonCommande.reference_bc" disabled>
                  
                   
                </div>
                <div class="form-group">
                    <label for="date_d"> Date </label>
                    <input type="date" class="form-control" id="date_d" v-model="bonCommande.date_bc" >
                </div>
                <div class="form-group">
                    <label for="type_operation"> Type Operation </label>
                    <input type="text" class="form-control" id="type_operation" v-model="bonCommande.type_operation_bc" >
                </div>
                <div class="form-group">
                    <label for="objet_d"> Objet </label>
                    <input type="text" class="form-control" id="objet_d" v-model="bonCommande.objet_bc" >
                </div>
                <div class="form-group">
                    <label for="date_emission_d"> Date d'émission </label>
                    <input type="date" class="form-control" id="date_emission_d" v-model="bonCommande.date_emission_bc" >
                </div>
                <div class="form-group">
                    <label for="remise_total_d"> Remise Total </label>
                    <input type="text" class="form-control" id="remise_total_d" v-model="bonCommande.remise_total_bc" >
                </div>
                <div class="form-group">
                    <label for="majoration_d"> Majoration </label>
                    <input type="text" class="form-control" id="majoration_d" v-model="bonCommande.majoration_bc">
                </div>
            </div>
            <div class="col-md-6"> 
                
                <div class="form-group">
                    <label for="date_limit_d"> Date Limit </label>
                    <input type="date" class="form-control" id="date_limit_d" v-model="bonCommande.date_limit_bc">
                </div>
                <div class="form-group">
                    <label for="introduction_d">Introduction </label>
                    <input type="text" class="form-control" id="introduction_d" v-model="bonCommande.introduction_bc">
                </div>
                <div class="form-group">
                    <label for="conditions_reglements_d">Conditions de reglements </label>
                    <input type="text" class="form-control" id="conditions_reglements_d" v-model="bonCommande.conditions_reglements_bc">
                </div>
                 <div class="form-group">
                    <label for="notes_d">Notes </label>
                    <input type="text" class="form-control" id="notes_d" v-model="bonCommande.notes_bc">
                </div>
                <div class="form-group">
                    <label for="accompte_d">Accompte </label>
                    <input type="text" class="form-control" id="accompte_d" v-model="bonCommande.accompte_bc">
                </div> 
                <div class="form-group">
                    <label for="fk_status_d"> Status </label>
                <select class="form-control custom-select " id="fk_status_d" v-model="bonCommande.fk_status_bc" >
                    <option selected disabled>Choisir Status</option>
                    <option v-for="statu in status" :key="statu.id_status" :value="statu.id_status">{{statu.type_status}}</option>
                </select>
                </div>
                <div class="form-group">
                    <label for=""> Compte </label>

                <select class="form-control custom-select " id="fk_compte" v-model="bonCommande.fk_compte" @change=" getRemise()" >
                    <option selected disabled>Choisir Status</option>
                    <option v-for="compte in comptes" :key="compte.id_compte" :value="compte.id_compte">{{compte.nom_compte}}</option>
                </select>
                </div>
       
            </div> 
    </div>
    <hr> 
<div class="text-center">
    <h4>Ajouter mode Paiement</h4>
    <hr>
    </div>

                <!-- ajouter mode de paiement -->
     <th>
                             <!--num document: devis -->
                    <input class="mr-4" :value="modePaiement.fk_document"  type="text" disabled hidden>
                        </th>
                    <br>
<div class="row ">
 <div class="col-md-4"> 
                <div class="form-group">
                    <label for="type_paiement"> Type Paiement </label>
                <select class="form-control custom-select " id="type_paiement" v-model="modePaiement.type_paiement" >
                    <option selected disabled>Choisir Type de Paiement</option>
                    <option>Cheque</option>
                    <option>Versement</option>
                    <option>Espece</option>
                </select>
                </div>
 </div>
  <div class="col-md-4"> 
                <div class="form-group">
                    <label for="reference_paiement">Reference Paiement </label>
                    <input type="text" class="form-control" id="reference_paiement" v-model="modePaiement.reference_paiement">
                </div>
  </div>
  <div class="col-md-4"> 

  
                 <div class="form-group">
                    <label for="date_paiement">Date Paiement </label>
                    <input type="date" class="form-control" id="date_paiement" v-model="modePaiement.date_paiement">
                </div>
  </div> 


</div>


  <hr>
        <div class="text-center">
    <h4>Ajouter Commandes</h4>
    <hr>
    </div>
  <div>     
             <!-- ajouter commandes -->
        <th>
                             <!--num document: devis -->
                    <input class="mr-4" :value="commande.fk_document"  type="text" disabled hidden>
                        </th>
                    <br>
                     <table class="table table-bordered tableau">
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
                            <th>  <input class="mr-4"  type="text" v-model="commande.fk_article" disabled hidden>
                           <input class="mr-4"  type="text" v-model="commande.desig" disabled >
                           
                            </th>
                            <th><input class="mr-4"  type="text" v-model="commande.quantite_cmd" ></th>
                            <th>  <input class="mr-4"  type="text" v-model="commande.remise_cmd" ></th> 
                            <th>  <input class="mr-4"  type="text" v-model="commande.majoration_cmd" ></th> 
                            <th>  <input class="mr-4"  type="text" v-model="commande.prix_ht" ></th> 
                            
                            <th>  <input class="mr-4"  type="text" v-model="commande.fk_tva_cmd" disabled hidden>
                              <select class="form-control custom-select " id="fk_tva_cmd" v-model="commande.fk_tva_cmd" >
                    <option selected>Choisir Tva</option>
                    <option v-for="tva in tvas" :key="tva.id_tva" :value="tva.id_tva">{{tva.taux_tva}}</option>
                    </select>
                            
                            </th> 
                            <th>  <input class="mr-4"  type="text" v-model="commande.totalHT">
                           
                            </th>
                            <th><a  class="btn btn-danger" @click="removeRow(index)"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                            </tr>
                    <tr>
                        <th>
                             <!--article -->
                   
                    <select class="form-control custom-select " id="fk_article" v-model="commande.fk_article" @change=" getPrixArticle()">
                    <option selected>Choisir Article</option>
                    <option v-for="article in articles.data" :key="article.id_article" :value="article.id_article">{{article.designation}}</option>
                </select>
                        </th>
                    <th class="form-group">
                            <!--quantite -->
                    <input class="mr-4"  type="text" v-model="commande.quantite_cmd" >
                        </th>
                        <th>
                            <!--Remise -->
                    <input class="mr-4"  type="text" v-model="commande.remise_cmd" >
                        </th>
                        <th>
                             <!--majoration -->
                    <input class="mr-4"  type="text" v-model="commande.majoration_cmd">
                        </th>
                        <th>
                             <!--prix ht-->
                    <input class="mr-4"  type="text" v-model="commande.prix_ht">
                        </th>
                        
                     
                        <th>
                            <!--tva -->
                 <select class="form-control custom-select " id="fk_tva_cmd" v-model="commande.fk_tva_cmd" >
                    <option selected>Choisir Tva</option>
                    <option v-for="tva in tvas" :key="tva.id_tva" :value="tva.id_tva">{{tva.taux_tva}}</option>
                </select>
                             
                        </th>
                      <th>  <input class="mr-4"  type="text" v-model="commande.totalHT">
                           
                            </th>

                        <th>
                             <!--ajouter -->
                         <a  class="btn btn-success" @click="addRow(commande)"><i class="fas fa-plus"></i></a>
                        </th>

                         </tr>
                    
                                            
                            
                      
                       
                        </tbody>


                         </table>
                         <div>
                             Total HT :{{total_prix}}
                             <br>
                             Remise Total (montant) :{{remise_T}}
                         </div>

</div>               










     <button  class="btn btn-primary mr-20 btn-success">Enregister</button>
</form>
    </div>
</template>

<script>

    export default{ 
        
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
</style>


 

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



              console.log('----------------')
            console.log(this.$route.params.id_compte + " / "+ this.$route.params.reference_bc+
            " / "+ this.$route.params.currentDate )
            

          this.getCompte(this.$route.params.id_compte);
          this.getContacts(this.$route.params.id_compte);
          this.getCondtionFacture(this.$route.params.id_compte); 