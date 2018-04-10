<template>
<div>
     <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/getDevis'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
    </div> 
<div class=" container colBackround">
   
          <form   @submit.prevent="addDevis">
<div class="row">
    <div class="col">
        <br>
    <h5><i class="far fa-file"></i> Ajouter un devis : <strong>{{devi.reference_d}}</strong></h5>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Compte  </label>
                <div class="col-sm-10">
                    <select class="form-control custom-select " id="id_compte" v-model="compte.id_compte" @click="getClient(compte.id_compte)" @change="getClient(compte.id_compte)">
                    <option selected disabled>Choisir Compte</option>
                    <option v-for="compte in comptes" :key="compte.id_compte" :value="compte.id_compte">{{compte.nom_compte}}</option>
                </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Date</label>
                <div class="col-sm-10">
                <input type="date" class="form-control" v-model="devi.date_d" id="inputPassword" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Objet  </label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" placeholder="" v-model="devi.objet_d">
                </div>
            </div>
          
    </div>
    <div class="col-md-6 col-sm-12">
        
        <div class="container  infoClient">
            <label for="">{{compte.nom_compte}} </label>
            <div class="form-group row">
            <div class="col-sm-10">
            <textarea placeholder="address client" class="AdressClient" name="" id="" cols="50" rows="4" v-model="devi.adresse_d"></textarea>
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
                            <th>  <input class="form-control"  type="text" v-model="commande.total_ht_cmd" disabled></th>
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
                      <th>  <input class="form-control"  type="text" v-model="commande.total_ht_cmd" disabled> </th>

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
    
    
    
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-4 col-form-label">Date Limit</label>
                <div class="col-sm-8">
                <input type="date" class="form-control" id="inputPassword" placeholder="" v-model="devi.date_limit_d">
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
                    <label for="remise_total_d"  class="col-sm-4 col-form-label" >Remise Total </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="remise_total_d" v-model="devi.remise_total_d">
                    </div>
                </div>                  
                      

                                 
    </div>
    <div class="col-md-6 col-sm-12">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Total HT </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding " id="staticEmail" v-model="devi.total_ht_d">
            </div>
         </div>
   
       
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Remise Total (montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding " id="staticEmail" v-model="devi.remise_ht_d">
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label"> Montant Net HT  </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="devi.montant_net_d">
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">TVA (Montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="devi.tva_montant_d">
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Montant TTC (Montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="devi.montant_ttc_d">
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
            <textarea class="noteCondition" name="" id="" cols="80" rows="3" v-model="devi.notes_d"></textarea>
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
            <textarea class="noteCondition" name="" id="" cols="80" rows="3" v-model="devi.conditions_reglements_d"></textarea>
            </div>
         </div>
   </div>
</div>
<hr>
<div class="row">            
<div class="col">
 <button  class="btn mb-3 float-right btn-success">Enregister</button>
</div>
</div>
          </form>
</div>
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
            adresse_d:"",
            type_operation:"",
            objet_d:"",
            date_emission_d:"",
            remise_total_d:"",
            majoration_d:"",
            date_limit_d:"",
            introduction_d:"",  
            conditions_reglements_d:"",
            notes_d:"",
            accompte_d:"",
           fk_status_d:"",
           fk_compte_d:"",
            fk_user_d:"",

            total_ht_d:0,
            remise_ht_d:0,
            montant_net_d:0,
            tva_montant_d:0,
            montant_ttc_d:0,
      
              },
              compte:{
                  id_compte:0,
                  nom_compte:"",
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
                total_ht_cmd:0,
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
               total_ht_cmd:commande.total_ht_cmd,
               total_ht:commande.total_ht,
               tva_montant:commande.tva_montant,
               taux_tva:commande.taux_tva,
        });
this.commande = {
                     id_cmd:0,
                quantite_cmd:1,
                remise_cmd:0,
                majoration_cmd:0,
                prix_ht:0,
                fk_article:"",
                fk_tva_cmd:"",
               fk_document: commande.fk_document,
               //montant tva de chaque commande
               tva_montant:0,
               //affichage
               // % de tva
               taux_tva:0,
               // designation d'article pr chaque commande
               desig:"",
               // montant total de chaque commande
                total_ht_cmd:0,
                };
    },

    removeRow(index) {
        this.commandes.splice(index,1);
    
    },


    addDevis(){ 

        axios.post('/addDevis',{commandes:this.commandes,devis:this.devi,modePaiements:this.modePaiement})
        .then(response => {         
                  
                this.$router.push('/getDevis/add');
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
                 this.devi.fk_status_d="Brouillon"; 
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
    getRemise(id_compte){
        console.log("remise"+id_compte);

        axios.get('/getRemise/'+id_compte)
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
    getClient(id_compte){
                
        axios.get('/getClient/'+id_compte)
            .then((response) => {
                    this.compte = response.data.compte;
                    this.getRemise(id_compte)
                  this.devi.adresse_d=response.data.compte.adresse_compte;
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

            this.commande.total_ht_cmd=(+prix_v + +majoration_art - remise_art)*quantite_art;

                //montant de remise pour chque commande
            let remise=this.commande.total_ht_cmd*(this.devi.remise_total_d/100);
                //montant de commande apres remise
            let net=this.commande.total_ht_cmd - this.commande.total_ht_cmd*(this.devi.remise_total_d/100);
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
            let remise=this.commandes[index].total_ht_cmd*(this.devi.remise_total_d/100);
                //montant apres remise
            let net=this.commandes[index].total_ht_cmd - this.commandes[index].total_ht_cmd*(this.devi.remise_total_d/100);
                // montant de tva
            let tva=net*(this.commandes[index].fk_tva_cmd/100);
                // total de montant des tvas
            sum_tva= +sum_tva + +tva;
        }
                // total de prix de tt commandes (affectation)
            this.total_prix = +sum + +this.commande.total_ht_cmd;
            this.devi.total_ht_d=this.total_prix;
                // total de montant tvas (affectation)
            this.tva_total=+sum_tva + +this.commande.tva_montant ;
            this.devi.tva_montant_d=this.tva_total;
                //remise sur le montant total
            this.remise_T=this.total_prix*(this.devi.remise_total_d/100);
            this.devi.remise_ht_d=this.remise_T;
                // montant total apres remise
            this.net_HT=this.total_prix - this.remise_T;
            this.devi.montant_net_d=this.net_HT;
               // montant total final
            this.total_ttc=  +this.net_HT + +this.tva_total;
            this.devi.montant_ttc_d=this.total_ttc;
    },
          
},

watch:{
    'devi.remise_total_d':{
            handler: function(){
                    this.totalHTaxe;
                    this.TotalDevis;

            },
    },

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
                    this.commandes[index].total_ht_cmd  = (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd;
                    sum = +sum + (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd;

                    let remise=this.commandes[index].total_ht_cmd*(this.devi.remise_total_d/100);
                    let net=this.commandes[index].total_ht_cmd - this.commandes[index].total_ht_cmd*(this.devi.remise_total_d/100);
                    let tva=net*(this.commandes[index].fk_tva_cmd/100);
                    sum_tva= +sum_tva + +tva;

                }
                    this.total_prix = +sum + +this.commande.total_ht_cmd;
                    this.devi.total_ht_d=this.total_prix;
                    this.remise_T=this.total_prix*(this.devi.remise_total_d/100);
                    this.devi.remise_ht_d=this.remise_T;
                    this.net_HT=this.total_prix - this.remise_T;
                    this.devi.montant_net_d=this.net_HT;
                    this.tva_total=+sum_tva + +this.commande.tva_montant ;
                    this.devi.tva_montant_d=this.tva_total;
                    this.total_ttc=  +this.net_HT + +this.tva_total;
                    this.devi.montant_ttc_d=this.total_ttc;

            },
            deep : true
    },
            
},

    mounted(){
 console.log('----------------')
            console.log(this.$route.params.id_compte + " / "+ this.$route.params.reference_d+
            " / " + this.$route.params.currentDate)
            this.devi.date_d=this.$route.params.currentDate;
            this.devi.reference_d=this.$route.params.reference_d;
            this.commande.fk_document=this.$route.params.reference_d;
            this.modePaiement.fk_document=this.$route.params.reference_d;
            this.devi.fk_compte_d=this.$route.params.id_compte;

            this.getStatus();
            //this.countDevis();
            this.getTvas();
            this.getarticles();
            this.getClients();
            this.getClient(this.$route.params.id_compte);
            this.getRemise(this.$route.params.id_compte);
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