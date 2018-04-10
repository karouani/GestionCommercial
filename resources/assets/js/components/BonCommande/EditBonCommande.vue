
<template>
<div>
  <div class="loading" v-if="loading">
          <div class="lds-hourglass"></div>

    </div>
    <div v-if="!loading" >
    <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowBonCommandes'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
    </div>    

<div class=" container colBackround">
    <form   @submit.prevent="EditBonCommande">
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
                    <label for="inputPassword" class="col-sm-2 col-form-label">compte: </label>
                    <div class="col-sm-10">
                <select class="form-control custom-select " id="fk_compte" v-model="compte.id_compte" @click="getCompte(compte.id_compte)"  @change="getCompte(compte.id_compte)">
                    <option selected >Choisir Client</option>
                    <option v-for="compte of comptes" :key="compte.id_compte" :value="compte.id_compte"> {{compte.nom_compte}} </option>
                </select>                    
                </div>
            </div> 

            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Devis</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" placeholder="" v-model="bonCommande.reference_bc" disabled>
                </div>
            </div>
                 <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Date </label>
                    <div class="col-sm-10">
                    <input  type="date" v-model="bonCommande.date_bc" class="form-control" id="date" />
                    </div>
                </div> 
                <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Objet  </label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" placeholder="" v-model="bonCommande.objet_bc" >
                </div>
            </div>
          
    </div>
    <div class="col-md-6 col-sm-12">
        
        <div class="container  infoClient">
            <label for="">{{compte.nom_compte}} </label>
            <div class="form-group row">
            <div class="col-sm-10">
            <textarea placeholder="address client" class="AdressClient" name="" id="" cols="50" rows="4" v-model="bonCommande.adresse_bc"></textarea>
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
                           <input class="form-control"  type="text" v-model="commande.designation" disabled >
                           
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
                            <th>  <input class="form-control"  type="text" v-model="commande.totalHT" disabled>
                           
                            </th>
                                            <th><a @click="spliceBonCommande(index,commande)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                                        </tr>
                      
                                    </tbody>
                                </table>
                                    
                            </div>
             </div>
     </div>
    
      <div class="row">
                                            <div class="col-sm-4"> 
                                                <select class="custom-select " id="fk_article" v-model="commande.fk_article" @change=" getPrixArticle()">
                                                 <option selected>Choisir Article</option>
                                                <option v-for="article in articles.data" :key="article.id_article" :value="article.id_article">{{article.designation}}</option>
                                                </select>                                                                     
                                            </div>
                                            <div class="col-sm-6">
                                            <a  @click="addRow(commande)" class="btn btn-success"  ><i class="fas fa-plus-circle"></i> Ajouter un article </a>
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
                <input type="date" class="form-control" id="inputPassword" placeholder="" v-model="bonCommande.date_limit_bc">
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
                    <input type="text" class="form-control" id="reference_paiement" v-model="bonCommande.remise_total_bc">
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
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="net_HT">
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">TVA (Montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="tva_total">
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Montant TTC (Montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="total_ttc">
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
            <textarea class="noteCondition" name="" id="" cols="80" rows="3" v-model="bonCommande.notes_bc"></textarea>
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
            <textarea class="noteCondition" name="" id="" cols="80" rows="3" v-model="bonCommande.conditions_reglements_bc"></textarea>
            </div>
         </div>
   </div>
</div>
<hr>
<div class="row">
    <div class="col">
        <input type="submit" value="Enregistrer" class="btn btn-primary float-right mb-3">
    </div>
</div>

    </form>
</div>
</div>
</div>
</template>

<script>

   
    export default{ 
        
          data: () => ({
              loading: false,
              suppBonCommandes :[],



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
            adresse_bc:"",
            fk_status_bc:"",
            fk_compte_bc:"",
            fk_user_bc:"",
            total_ht_bc: 0,
            remise_ht_bc: 0,
            montant_net_bc: 0,
            tva_montant_bc: 0,
            montant_ttc_bc: 0,
      
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
                    adresse_compte:"",
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
               designation:"",
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
               created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
      

methods: { 


 fetchData () {
      //this.error = this.post = null
      this.loading = true
            this.getTvas();
            this.getClients();
            this.getCompte(this.$route.params.fk_compte_bc);
            this.showBonCommande(this.$route.params.reference_bc);
            this.getCommandes(this.$route.params.reference_bc);
           /* this.bonCommande.reference_bc = this.$route.params.reference_bc
            this.bonCommande.date_bc = this.$route.params.currentDate
            this.commande.fk_document=this.$route.params.reference_bc
            this.modePaiement.fk_document=this.$route.params.reference_bc
            this.getCompte(this.$route.params.id_compte);
            this.getContacts(this.$route.params.id_compte);
            this.getCondtionFacture(this.$route.params.id_compte); */
            this.getStatus();
           
            this.getarticles();
             
            console.log('-------------- id_Compte ----- ---- ')
            console.log(this.$route.params.fk_compte_bc)
            
           
            this.getRemise(this.$route.params.id_compte)


    },

 

  
        precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
},



     spliceBonCommande(index,commande){
            this.commandes.splice(index, 1);
           // commande.fk_document = this.$route.params.reference_bc;
                        this.suppBonCommandes.push(commande);
                        console.log('supp ----------');
                        console.log(this.suppContacts)
        },
    showBonCommande(reference_bc){

            axios.get('/showBonCommande/'+reference_bc)
                                .then((response) => {
                                   
                                    this.bonCommande = response.data.bonCommande[0];
                                    this.compte.id_compte = this.bonCommande.id_compte;
                                    this.compte.nom_compte = this.bonCommande.nom_compte;
                                   // this.compte.adresse_compte = this.bonCommande.adresse_bc;
                                    this.modePaiement.id_modeP =this.bonCommande.id_modeP
                                      this.modePaiement.type_paiement =this.bonCommande.type_paiement
                                    this.modePaiement.reference_paiement    = this.bonCommande.reference_paiement
                                     this.modePaiement.date_paiement   =this.bonCommande.date_paiement
                                     this.modePaiement.fk_document =this.bonCommande.fk_document
                                    
                                })
                                .catch(() => {
                                        console.log('handle server error from here');
                                });
        },

        getCommandes(reference_bc){

         axios.get('/getCommandes_bc/'+reference_bc)
                        .then((response) => {
                                console.log("getCommande ------ ")
                                console.log(response.data.commandes)
                               this.commandes = response.data.commandes;
                            this.loading= false;
                        })
                        .catch(() => {
                                console.log('handle server error from here');
                        });

        },


    EditBonCommande(){
            this.bonCommande.total_ht_bc =  this.total_prix,
            this.bonCommande.remise_ht_bc = this.remise_T, 
            this.bonCommande.montant_net_bc = this.net_HT ,
            this.bonCommande.tva_montant_bc = this.tva_total ,
            this.bonCommande.montant_ttc_bc =  this.total_ttc,
            //this.bonCommande.adresse_bc=  this.compte.adresse_compte
            this.bonCommande.fk_compte_bc = this.compte.id_compte;
            console.log('verifie fk_document  : ')
            console.log(this.commandes)
            console.log(this.modePaiement)
                  axios.post('/UpdateBonCommande',{commandes:this.commandes,bonCommande:this.bonCommande,modePaiements:this.modePaiement,suppBonCommandes: this.suppBonCommandes})
        .then(response => {         
                console.log(response.data)
               // this.$router.push('/ShowBonCommandes/editsuccess');
                this.$router.push({ name: 'ShowBonCommandes', params: { success: "editsuccess"  }});
               // this.$router.push('/');
              // this.$router.push('/ShowBonCommandes/addsuccess');  
        })
        .catch(() => {
                console.log('handle server error from here');
        });
    },


    addRow (commande) {
       
        this.commandes.push( {
            
               quantite_cmd:commande.quantite_cmd,
               remise_cmd:commande.remise_cmd,
               majoration_cmd: commande.majoration_cmd,
               prix_ht: commande.prix_ht,
               fk_article:commande.fk_article,
               fk_document:this.$route.params.reference_bc,
               fk_tva_cmd:commande.fk_tva_cmd,
               designation:commande.designation,
               totalHT:commande.totalHT,
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
                fk_document:this.$route.params.reference_bc,
                fk_tva_cmd:"",
               
               //montant tva de chaque commande
               tva_montant:0,
               //affichage
               // % de tva
               taux_tva:0,
               // designation d'article pr chaque commande
               designation:"",
               // montant total de chaque commande
                totalHT:0,
              };

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
           
        axios.get('/getPrixArticle_bc/'+this.commande.fk_article)
            .then((response) => {
                        // prix de vente d'article
                    this.commande.prix_ht=response.data.article[0].prix_ht_vente;
                        // fk de tva d'article
                    this.commande.fk_tva_cmd=response.data.article[0].fk_tva_applicable;
                        // designation d'article
                    this.commande.designation=response.data.article[0].designation;
                    this.tauxTva();
                  
            })
            .catch(() => {
                    console.log('handle server error from here');
            });
    },
        // recuperer remise associe a un compte
    getRemise(id_compte){
                        
        axios.get('/getRemise/'+id_compte)
            .then((response) => {
                if(response.data.conditions_remise[0].remise==null){
                    this.bonCommande.remise_total_bc=0;
                }
                else
                    this.bonCommande.remise_total_bc=response.data.conditions_remise[0].remise;
                  
             
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
     getCompte:function(id_compte){
                  axios.get('/getCompte/'+id_compte).then(
                  response => {
                       
                    this.compte= response.data.compte;
                    this.bonCommande.adresse_bc = this.compte.adresse_compte;
                  });
                  this.getRemise(id_compte);     
        },
        getContacts:function(id_compte){
                  axios.get('/getContacts/'+id_compte).then(
                  response => {
                       
                    this.contacts= response.data.contacts;
                     
                  });     
        },
        getCondtionFacture:function(id_compte){
                  axios.get('/getCFacture/'+id_compte).then(
                  response => {
                      
                    this.condition_facture= response.data.condition_facture[0];
                  
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
            let remise=this.commande.totalHT*(this.bonCommande.remise_total_bc/100);
                //montant de commande apres remise
            let net=this.commande.totalHT - this.commande.totalHT*(this.bonCommande.remise_total_bc/100);
                //montant tva par article
            let tva=net*(this.commande.taux_tva/100);
            this.commande.tva_montant=tva;

    },
            
    TotalBonCommande(){
             let sum=0;
            let sum_tva=0;
        for (let index = 0; index < this.commandes.length; index++) {
                //total de prix de tt commandes
                                this.commandes[index].totalHT  = this.precisionRound( (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd,2);

            sum = this.precisionRound(+sum + (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd,2);
                //montant tva de chaque commande apres remise
            this.tva_montant= this.precisionRound( this.total_prix*(this.bonCommande.remise_total_bc/100)*(this.commande.taux_tva/100),2);
                //montant de remise
            let remise= this.precisionRound( this.commandes[index].totalHT*(this.bonCommande.remise_total_bc/100),2);
                //montant apres remise
            let net=this.precisionRound( this.commandes[index].totalHT - this.commandes[index].totalHT*(this.bonCommande.remise_total_bc/100),2);
                // montant de tva
            let tva=this.precisionRound( net*(this.commandes[index].fk_tva_cmd/100),2);
                // total de montant des tvas
            sum_tva= this.precisionRound( +sum_tva + +tva,2);
        }
                // total de prix de tt commandes (affectation)
            this.total_prix = this.precisionRound( sum ,2);
                // total de montant tvas (affectation)
            this.tva_total= this.precisionRound( sum_tva ,2);
                //remise sur le montant total
            this.remise_T= this.precisionRound( this.total_prix*(this.bonCommande.remise_total_bc/100),2);
                // montant total apres remise
            this.net_HT=this.precisionRound( this.total_prix - this.remise_T,2);
               // montant total final
            this.total_ttc=  this.precisionRound( +this.net_HT + +this.tva_total,2);
    },
          
},

watch:{
       'bonCommande.remise_total_bc':{
            handler: function(){
                  
                    this.TotalBonCommande;

            },
            '$route': 'fetchData',
    },
      


    commandes: {
            handler: function(){
                      
             //   this.totalHTaxe;
                this.TotalBonCommande;

            },
            deep : true
    },
            
},

    mounted(){

          
         
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
.fontsize{

    font-size: 1.30rem;
}




.lds-hourglass {
  display: inline-block;
  position: relative;
  width: 0px;
  height: 20px;
}
.lds-hourglass:after {
  content: " ";
  display: block;
  border-radius: 50%;
  width: 0;
  height: 0;
  margin: 6px;
  box-sizing: border-box;
  border: 15px solid #fff;
  border-color: rgb(0, 0, 0) transparent rgb(0, 0, 0) transparent;
  animation: lds-hourglass 1.2s infinite;
}
@keyframes lds-hourglass {
  0% {
    transform: rotate(0);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
  }
  50% {
    transform: rotate(900deg);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
  }
  100% {
    transform: rotate(1800deg);
  }
}
</style>


 