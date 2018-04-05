<template>
    <div>
        <div class="text-center">
    <h2>Ajouter Devis</h2>
    <hr>
    </div>
             <!-- ajouter devis  -->
        <form   @submit.prevent="addDevis">
         <div class="row" > 
         
            <div class="col-md-6">
                <div class="form-group">
                    <label for="reference_d"> Reference</label>
                    <input type="text" class="form-control" id="reference_d" :value="devi.reference_d" disabled>
                  
                   
                </div>
                <div class="form-group">
                    <label for="date_d"> Date </label>
                    <input type="date" class="form-control" id="date_d" v-model="devi.date_d" >
                </div>
                <div class="form-group">
                    <label for="objet_d"> Objet </label>
                    <input type="text" class="form-control" id="objet_d" v-model="devi.objet_d" >
                </div>
                <div class="form-group">
                    <label for="date_emission_d"> Date d'émission </label>
                    <input type="date" class="form-control" id="date_emission_d" v-model="devi.date_emission_d" >
                </div>
                <div class="form-group">
                    <label for="remise_total_d"> Remise Total </label>
                    <input type="text" class="form-control" id="remise_total_d" v-model="devi.remise_total_d" >
                </div>
                <div class="form-group">
                    <label for="majoration_d"> Majoration </label>
                    <input type="text" class="form-control" id="majoration_d" v-model="devi.majoration_d">
                </div>
            </div>
            <div class="col-md-6"> 
                
                <div class="form-group">
                    <label for="date_limit_d"> Date Limit </label>
                    <input type="date" class="form-control" id="date_limit_d" v-model="devi.date_limit_d">
                </div>
                <div class="form-group">
                    <label for="conditions_reglements_d">Conditions de reglements </label>
                    <input type="text" class="form-control" id="conditions_reglements_d" v-model="devi.conditions_reglements_d">
                </div>
                 <div class="form-group">
                    <label for="notes_d">Notes </label>
                    <input type="text" class="form-control" id="notes_d" v-model="devi.notes_d">
                </div>
                <div class="form-group">
                    <label for="accompte_d">Accompte </label>
                    <input type="text" class="form-control" id="accompte_d" v-model="devi.accompte_d">
                </div> 
                <div class="form-group">
                    <label for="fk_status_d"> Status </label>
                <select class="form-control custom-select " id="fk_status_d" v-model="devi.fk_status_d" >
                    <option selected disabled>Choisir Status</option>
                    <option v-for="statu in status" :key="statu.id_status" :value="statu.id_status">{{statu.type_status}}</option>
                </select>
                </div>
                <div class="form-group">
                    <label for=""> Compte </label>

                <select class="form-control custom-select " id="fk_compte" v-model="devi.fk_compte" @change=" getRemise()" >
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
                            <th>  <input class="mr-4"  type="text" v-model="commande.fk_article" disabled hidden>
                           <input class="form-control"  type="text" v-model="commande.desig" disabled >
                           
                            </th>
                            <th><input class="mr-4"  type="text" v-model="commande.quantite_cmd" ></th>
                            <th>  <input class="form-control"  type="text" v-model="commande.remise_cmd" ></th> 
                            <th>  <input class="form-control"  type="text" v-model="commande.majoration_cmd" ></th> 
                            <th>  <input class="form-control"  type="text" v-model="commande.prix_ht" ></th> 
                            
                            <th> 
                              <select class="form-control custom-select " id="fk_tva_cmd" v-model="commande.fk_tva_cmd" >
                    <option selected>Choisir Tva</option>
                    <option v-for="tva in tvas" :key="tva.id_tva" :value="tva.id_tva">{{tva.taux_tva}}</option>
                    </select>

                            </th> 
                            <th>  <input class="form-control"  type="text" v-model="commande.totalHT" disabled></th>
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
                    <input class="form-control"  type="text" v-model="commande.quantite_cmd" >
                        </th>
                        <th>
                            <!--Remise -->
                    <input class="form-control"  type="text" v-model="commande.remise_cmd" >
                        </th>
                        <th>
                             <!--majoration -->
                    <input class="form-control"  type="text" v-model="commande.majoration_cmd">
                        </th>
                        <th>
                             <!--prix ht-->
                    <input class="form-control"  type="text" v-model="commande.prix_ht">
                        </th>
                        
                     
                        <th>
                            <!--tva -->
                 <select class="form-control custom-select " id="fk_tva_cmd" v-model="commande.fk_tva_cmd" @change="tauxTva">
                    <option selected>Choisir Tva</option>
                    <option v-for="tva in tvas" :key="tva.id_tva" :value="tva.id_tva">{{tva.taux_tva}}</option>
                </select>
                        </th>
                      <th>  <input class="form-control"  type="text" v-model="commande.totalHT" disabled> </th>

                        <th>
                             <!--ajouter -->
                         <a  class="btn btn-success" @click="addRow(commande)"><i class="fas fa-plus-circle"></i></a>
                        </th>

                         </tr>
                    
                                            
                            
                      
                       
                        </tbody>


                         </table>
                            </div>
                            </div>
           </div>
                         <div>
                             Total HT :{{total_prix}}
                             <br>
                             Remise Total (montant) :{{remise_T}}
                             <br>
                             Montant Net HT :{{net_HT}}
                             <br>
                             Tva (montant) : {{tva_total}}
                              <br>
                             Montant TTC (montant) : {{total_ttc}}
                         </div>

</div>               

 <button  class="btn btn-primary mr-20 btn-success">Enregister</button>
</form>
    </div>
</template>

<script>

    export default{ 
        
          data: () => ({
           
              // objet test sur affichage , ajout , recherche
              Testopen:{
                testAjout : false,
                testAffiche : false,
              },
              testEdit : false,

              // devi
              devi: { 
            id_devis:0,
            reference_d:"",
            date_d:"", 
            //type_operation:"",
            objet_d:"",
            date_emission_d:"",
            remise_total_d:"",
            majoration_d:"",
            date_limit_d:"",
            //introduction_d:"",  
            conditions_reglements_d:"",
            notes_d:"",
            accompte_d:"",
           fk_status_d:"",
           fk_compte_d:"",
            fk_user_d:"",
      
              },
              // tableau des devis 
              devis :[],
              //tables foreign key 
              status:[],
              tvas:[],
              articles:[],
              comptes:[],
            
            index:0,
            // total de prix de tt les commandes
            total_prix:0,
            // montant de remise total
            remise_T:0,
            //total moin remise
            net_HT:0,
            // montant total de tvas
            tva_total:0,
            // montant final
            total_ttc:0,
              //commandes
              commande:{
                  id_cmd:0,
                quantite_cmd:1,
                remise_cmd:0,
                majoration_cmd:0,
                prix_ht:0,
                fk_article:"",
                fk_document:"",
                fk_tva_cmd:"",
               
               //montant tva de chaque commande
               tva_montant:0,
               //affichage
               // % de tva
               taux_tva:0,
               // designation d'article pr chaque commande
               desig:"",
               // montant total de chaque commande
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
             
      }),
      

methods: { 


    addRow (commande) {
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
               tva_montant:commande.tva_montant,
               taux_tva:commande.taux_tva,
        });

    },

    removeRow(index) {
        this.commandes.splice(index,1);
    
    },


    addDevis(){ 

        axios.post('/addDevis',{commandes:this.commandes,devis:this.devi,modePaiements:this.modePaiement})
        .then(response => {         
                  
                this.$router.push('/');
        })
        .catch(() => {
                console.log('handle server error from here');
        });
            
    },
    
        // Taux de tva
    tauxTva(){
        axios.get('/tauxTva/'+this.commande.fk_tva_cmd)
        .then((response) => {
                this.commande.taux_tva=response.data.taux_tva.taux_tva;
            
                  
        })
        .catch(() => {
                console.log('handle server error from here');
        });
    },
        //recuperer tt les status
    getStatus(){
        axios.get('/getStatus')
        .then((response) => {
                this.status= response.data.status;
                  
        })
        .catch(() => {
                console.log('handle server error from here');
        });
    },
        
        //Reference de devis
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
        // recuperer tvas
    getTvas(){
                
        axios.get('/getTvas')
            .then((response) => {
                    this.tvas= response.data.tvas;
                 
            })
            .catch(() => {
                    console.log('handle server error from here');
            });
    },
        //recuperer tt les articles
    getarticles(){
        
        axios.get('/getArticles')
            .then((response) => {
                 
                    this.articles = response.data.articles;
                  
            })
            .catch(() => {
                    console.log('handle server error from here');
            });
    },
        // recuperer des infos sur un article
    getPrixArticle(){
           
        axios.get('/getPrixArticle/'+this.commande.fk_article)
            .then((response) => {
                        // prix de vente d'article
                    this.commande.prix_ht=response.data.article[0].prix_ht_vente;
                        // fk de tva d'article
                    this.commande.fk_tva_cmd=response.data.article[0].fk_tva_applicable;
                        // designation d'article
                    this.commande.desig=response.data.article[0].designation;
                    this.tauxTva();
                  
            })
            .catch(() => {
                    console.log('handle server error from here');
            });
    },
        // recuperer remise associe a un compte
    getRemise(){

        axios.get('/getRemise/'+this.devi.fk_compte)
            .then((response) => {
                if(response.data.conditions_remise[0].remise==null){
                    this.devi.remise_total_d=0;
                }
                else
                    this.devi.remise_total_d=response.data.conditions_remise[0].remise;
             
            })
            .catch(() => {
                    console.log('handle server error from here');
            });
    },
        // recuperer liste des clients
    getClients(){
                
        axios.get('/getClients')
            .then((response) => {
                    this.comptes = response.data.comptes;
                  
            })
            .catch(() => {
                    console.log('handle server error from here');
        });
    },
    
},
    
    
computed:{
        // calcul
    totalHTaxe(){

            let remise_art=this.commande.remise_cmd;
            let majoration_art=this.commande.majoration_cmd;
            let quantite_art=this.commande.quantite_cmd;
            let prix_v=this.commande.prix_ht;

            this.commande.totalHT=(+prix_v + +majoration_art - remise_art)*quantite_art;

                //montant de remise pour chque commande
            let remise=this.commande.totalHT*(this.devi.remise_total_d/100);
                //montant de commande apres remise
            let net=this.commande.totalHT - this.commande.totalHT*(this.devi.remise_total_d/100);
                //montant tva par article
            let tva=net*(this.commande.taux_tva/100);
            this.commande.tva_montant=tva;

    },
            
    TotalDevis(){
            let sum=0;
            let sum_tva=0;
        for (let index = 0; index < this.commandes.length; index++) {
                //total de prix de tt commandes
            sum = +sum + (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd;
                //montant tva de chaque commande apres remise
            this.tva_montant=this.total_prix*(this.devi.remise_total_d/100)*(this.commande.taux_tva/100);
                //montant de remise
            let remise=this.commandes[index].totalHT*(this.devi.remise_total_d/100);
                //montant apres remise
            let net=this.commandes[index].totalHT - this.commandes[index].totalHT*(this.devi.remise_total_d/100);
                // montant de tva
            let tva=net*(this.commandes[index].fk_tva_cmd/100);
                // total de montant des tvas
            sum_tva= +sum_tva + +tva;
        }
                // total de prix de tt commandes (affectation)
            this.total_prix = +sum + +this.commande.totalHT;
                // total de montant tvas (affectation)
            this.tva_total=+sum_tva + +this.commande.tva_montant ;
                //remise sur le montant total
            this.remise_T=this.total_prix*(this.devi.remise_total_d/100);
                // montant total apres remise
            this.net_HT=this.total_prix - this.remise_T;
               // montant total final
            this.total_ttc=  +this.net_HT + +this.tva_total;
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
                        let sum=0;
                        let sum_tva=0;

                for (let index = 0; index < this.commandes.length; index++) {
                    this.commandes[index].totalHT  = (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd;
                    sum = +sum + (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd;

                    let remise=this.commandes[index].totalHT*(this.devi.remise_total_d/100);
                    let net=this.commandes[index].totalHT - this.commandes[index].totalHT*(this.devi.remise_total_d/100);
                    let tva=net*(this.commandes[index].fk_tva_cmd/100);
                    sum_tva= +sum_tva + +tva;

                }
                    this.total_prix = +sum + +this.commande.totalHT;
                    this.remise_T=this.total_prix*(this.devi.remise_total_d/100);
                    this.net_HT=this.total_prix - this.remise_T;
                    this.tva_total=+sum_tva + +this.commande.tva_montant ;
                    this.total_ttc=  +this.net_HT + +this.tva_total;

            },
            deep : true
    },
            
},

    mounted(){

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