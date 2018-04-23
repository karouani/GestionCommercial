
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

    <form   @submit.prevent="addBonCommande">
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
         <select class="form-control custom-select " id="fk_compte" v-model="compte.id_compte" @click="getCompte(compte.id_compte)" @change="getCompte(compte.id_compte)">
                    <option selected disabled>Choisir Client</option>
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
            <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Contact: </label>
                    <div class="col-sm-10">
         <select class="form-control custom-select " id="fk_compte" v-model="bonCommande.fk_contact">
                    <option selected disabled>Choisir un contact</option>
                    <option v-for="contact of contacts" :key="contact.id_compte" :value="contact.id_contact"> {{contact.nom}}--{{contact.prenom}}</option>
                </select>  

                
                </div>
            </div> 
          
    </div>
    <div class="col-md-6 col-sm-12">
        
        <div class="container  infoClient">
            <label for="">{{compte.nom_compte}} </label>
            <div class="form-group row">
            <div class="col-sm-10">
             <span>Adresse de livraison</span>
            <textarea placeholder="address client" class="AdressClient" name="" id="" cols="50" rows="4" v-model="bonCommande.adresse_bc"></textarea>
            </div>
         </div>
        </div>
        <div class="container infoClient">
            <label for="">Adresse de facturation </label>
            <div class="form-group row">
            <div class="col-sm-10">
            <textarea placeholder="" class="AdressClient" name="" id="" cols="50" rows="4" v-model="bonCommande.adresse_facture_bc" ></textarea>
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
                                    <th>Qté</th>
                                    <th>Remise</th>
                                    <th>Maj</th>
                                    <th>Prix HT</th>
                                    <th>TVA</th>
                                    <th>Total HT</th>
                                    </tr>  
                                    </thead>
                                    <tbody>
                                       
                             <tr v-for="(commande,index) in commandes" :key="index" >
                                <input class="form-control"  type="text" v-model="commande.fk_article" disabled hidden>
                            <th>
                            <div class="row">  
                                <div class="col">
                                    <input  class="mb-2" type="text" v-model="commande.designation" disabled >
                                </div>
                                <div class="col">
                                    <textarea placeholder="Description article"  name="" id="description" cols="22" rows="4"  v-model="commande.description_article"></textarea> 
                                   
                                 </div>
                           </div>  
                            </th> 
                            <th><input class="form-control ThWidth"  type="text" v-model="commande.quantite_cmd" ></th>
                            <th>  <input class="form-control ThWidth"  type="text" v-model="commande.remise_cmd" ></th> 
                            <th>  <input class="form-control ThWidth"  type="text" v-model="commande.majoration_cmd" ></th> 
                            <th>  <input class="form-control ThWidth "  type="text" v-model="commande.prix_ht" ></th> 
                              <th>  <input  type="text" v-model="commande.fk_tva_cmd" disabled hidden>
                             <select class="form-control ThWidth custom-select " id="fk_tva_cmd" v-model="commande.fk_tva_cmd" >
                            <option selected>Choisir Tva</option>
                            <option v-for="tva in tvas" :key="tva.id_tva" :value="tva.id_tva">{{tva.taux_tva}}</option>
                            </select>
                            
                            </th> 
                            <th>  <input class="form-control ThWidth"  type="text" v-model="commande.totalHT" disabled>
                           
                            </th>

                                            <th><a @click="removeRow(index)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                                        </tr>
                                    
                                    </tbody>
                                </table>
                                                
                            </div>
             </div>
     </div>
    <div class="row">
                                            <div class="col-sm-4"> 
                                                <select class="custom-select " id="fk_article" v-model="commande.fk_article" >
                                                 <option selected disabled>Choisir Article</option>
                                                <option v-for="article in articles.data" :key="article.id_article" :value="article.id_article">{{article.reference_art}}--{{article.designation}}</option>
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
                <label for="inputPassword" class="col-sm-4 col-form-label">Total en lettre</label>
                <div class="col-sm-8">
                <label  class="form-control" for="">{{bonCommande.total_lettre}}</label>
                </div>
            </div>

             <div class="form-group row">
               
<label for="inputPassword" class="col-sm-4 col-form-label">Échéance </label>
                <div class="col-sm-8">
                    <select class="form-control custom-select " id="echeance" v-model="echeance" >
                    <option selected disabled>nombre de jour</option>
                    <option value="7">une semaine</option>
                    <option value="14">deux semaine</option>
                    <option value="30">30 jours</option>
                    <option value="60">60 jours</option>
                    <option value="90">90 jours</option>
                    <option value="choix">choisir une date</option>

                </select>
                 
                <div v-if="echeance != undefined">
                    <br>
                    <div v-if="echeance != 'choix'">
                                 {{bonCommande.date_limit_bc}} - ({{bonCommande.date_diff}})
                    </div>
                <div v-if="echeance === 'choix'">
                  <input type="date"  class="form-control" id="inputPassword" placeholder="" v-model="bonCommande.date_limit_bc" required>
                </div>
                </div>
                
                </div>           
            </div>
            <div class="form-group row">
                    <label for="type_paiement" class="col-sm-4 col-form-label" > Type Paiement </label>
                <div class="col-sm-8">
                  <select class="custom-select " id="fk_" v-model="modePaiement.fk_type_paiement" >
                 <option selected disabled>Choisir type paiement</option>
                <option v-for="typePaiement in typePaiements" :key="typePaiement.id_type_paiement" :value="typePaiement.id_type_paiement">{{typePaiement.type_paiement}}</option>
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
                    <input type="number" class="form-control" id="reference_paiement" v-model="bonCommande.remise_total_bc">
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
         <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Acompte </label>
            <div class="col-sm-8">
            <input type="number" class="form-control " style="width:100px;margin-left: 150px" id="staticEmail" v-model="bonCommande.accompte_bc">
            </div>
         </div>
         <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Montant Reste (Montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="bonCommande.montant_reste_bc">
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
               bonCommande : { 
            id_bc:0,
            reference_bc:"",
            fk_devis:"",
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
            
            
            fk_status_bc:"",
            fk_compte_bc:"",
            fk_user_bc:"",
            total_ht_bc: 0,
            remise_ht_bc: 0,
            montant_net_bc: 0,
            tva_montant_bc: 0,
            montant_ttc_bc: 0,
            total_lettre : "zéro",
            echeance:0,
            date_diff:"",
            accompte_bc: 0,
            montant_reste_bc: 0,
            fk_contact:0,
            adresse_bc:"",
            adresse_facture_bc:"",

              },
 echeance:0,
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
           fk_document_cmd:"",
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
            id_type_paiement:0,
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
                description_article:"",
              },
             
              commandes:[],
              
                //mode paiement
                modePaiement:{
                        id_modeP:0,
                        reference_paiement:"",
                        date_paiement:"",
                        fk_document:"",
                        fk_type_paiement:0,

                },
                typePaiement:{
                    id_type_paiement: 0,
                    type_paiement:"",
                },
                modePaiements:[],
                typePaiements:[],
                contacts :{},
             
      }),
        created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
      

methods: { 

    fetchData () { 
        this.loading = true
    
    if(this.$route.params.id_devis != null){
        this.countBonCommandes();
        this.id_devis = this.$route.params.id_devis;
        this.reference_d=this.$route.params.reference_d;
        this.getDevisD(this.$route.params.id_devis);
       
       this.echeance = 'choix';
        this.getarticles();
        this.getClients();
        this.getTvas();
        this.getTypePaiement();
        
     
        this.getCommandes(this.$route.params.reference_d);
        this.getCompte(this.$route.params.id_compte);
        this.getContacts(this.$route.params.id_compte);
    }
    else{



              console.log('----------------')
            console.log(this.$route.params.id_compte + " / "+ this.$route.params.reference_bc+
            " / "+ this.$route.params.currentDate )

            this.fk_document_cmd = this.$route.params.reference_bc
            this.bonCommande.reference_bc = this.$route.params.reference_bc
            this.bonCommande.date_bc = this.$route.params.currentDate
            //this.commande.fk_document=this.$route.params.reference_bc
            this.modePaiement.fk_document=this.$route.params.reference_bc
            this.getCompte(this.$route.params.id_compte);
            this.getCondtionFacture(this.$route.params.id_compte); 
            this.getStatus();
            this.getTvas();
            this.getarticles();
            this.getRemise(this.$route.params.id_compte);
            this.getClients();
            this.getTypePaiement();
            this.getContacts(this.$route.params.id_compte);

         
          




    }  
    },


    precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
},




    addBonCommande(){
            this.bonCommande.total_ht_bc =  this.total_prix 
            this.bonCommande.remise_ht_bc = this.remise_T 
            this.bonCommande.montant_net_bc = this.net_HT  
            this.bonCommande.tva_montant_bc = this.tva_total  
            this.bonCommande.montant_ttc_bc =  this.total_ttc 
           // this.bonCommande.adresse_bc=  this.compte.adresse_compte
            this.bonCommande.fk_compte_bc = this.compte.id_compte;
            this.bonCommande.fk_status_bc = "Brouillon"
            
            
             console.log('-------------BonCommandes---------------')
            console.log(this.bonCommande)
            console.log('-------------Commandes---------------')
            console.log(this.commandes)
            console.log(this.compte.id_compte)
            
                axios.post('/addBonCommande',{commandes:this.commandes,bonCommande:this.bonCommande,modePaiements:this.modePaiement})
        .then(response => {         
                  console.log("bonCommande Bien ajouter ")
               // this.$router.push('/');
               this.$router.push({ name: 'ShowBonCommandes', params: { success: "addsuccess"  }});
        })
        .catch(() => {
                console.log('handle server error from here');
        });
    },


    async addRow (commande) {
        console.log("addrowwwwww")
        console.log(this.fk_document_cmd)
        console.log('--------')
       var result = await this.getPrixArticle();
       var result2 = await this.commandes.push( {
             
               quantite_cmd:commande.quantite_cmd,
               remise_cmd:commande.remise_cmd,
               majoration_cmd: commande.majoration_cmd,
               prix_ht: commande.prix_ht,
               fk_article:commande.fk_article,
               fk_document: this.fk_document_cmd,
               fk_tva_cmd:commande.fk_tva_cmd,
                description_article:commande.description_article,
              
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
                //fk_document:this.$route.params.reference_bc,
                fk_document:this.fk_document_cmd,
                fk_tva_cmd:"",
               
               //montant tva de chaque commande
               tva_montant:0,
               //affichage
               // % de tva
               taux_tva:0,
               // designation d'article pr chaque commande
               designation:"",
               description_article:"",
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
       // console.log('-------- articles ');
         //  console.log();
         let this1=this;
           this.articles.data.forEach(function(article) {
               if(article.id_article == this1.commande.fk_article){
                   this1.commande.prix_ht = article.prix_ht_vente;
                   this1.commande.fk_tva_cmd = article.fk_tva_applicable
                   this1.commande.designation = article.designation;
                   this1.commande.description_article = article.description;
                   return
                 
               }

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
                    console.log('getRemiseeeeee2222')
             
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
                  this.loading= false;
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
                    this.bonCommande.adresse_facture_bc = this.compte.adresse_compte;
                    this.getContacts(this.compte.id_compte);
                    console.log(this.compte)
                  });
                  this.getRemise(id_compte);     
        },
        getCondtionFacture:function(id_compte){
                  axios.get('/getCFacture/'+id_compte).then(
                  response => {
                       console.log("Cfacture")
                    this.condition_facture= response.data.condition_facture[0];
                   console.log(this.condition_facture)
                  });     
        }, 
// pour convert
 getDevisD(id_devis){
                  axios.get('/getDevisD/'+id_devis).then(
                  response => {
                         console.log("deviiiiiiiis");
                        // console.log(id_devis);
                         console.log(response.data.devi[0]);
                         

            
                    this.bonCommande.objet_bc= response.data.devi[0].objet_d;
                    this.bonCommande.date_bc= response.data.devi[0].date_d;

                    this.bonCommande.remise_total_bc= response.data.devi[0].remise_total_d;
                    this.bonCommande.date_limit_bc= response.data.devi[0].date_limit_d;
                    this.bonCommande.conditions_reglements_bc= response.data.devi[0].conditions_reglements_d;
                    this.bonCommande.notes_bc= response.data.devi[0].notes_d;
                    this.bonCommande.fk_devis= response.data.devi[0].reference_d;

                    this.bonCommande.adresse_bc= response.data.devi[0].adresse_d;
                    this.bonCommande.accompte_bc= response.data.devi[0].accompte_d;
                    this.compte.nom_compte= response.data.devi[0].nom_compte;
                    this.compte.id_compte= response.data.devi[0].fk_compte_d;

                    this.modePaiement.reference_paiement=response.data.devi[0].reference_paiement;
                    this.modePaiement.date_paiement=response.data.devi[0].date_paiement;
                    this.typePaiement.id_type_paiement = response.data.devi[0].id_type_paiement; 
                    this.modePaiement.fk_type_paiement = response.data.devi[0].id_type_paiement;                       
                    this.typePaiement.type_paiement=response.data.devi[0].type_paiement;
                    console.log(">>>>>>>>>>"+this.typePaiement.type_paiement)                                     

                         console.log(this.fk_document_cmd);

                  });     
        },
         getCommandes:function(reference_d){
                  axios.get('/getCommandes/'+reference_d).then(
                  response => {
                      console.log("commandes:  ");
                         console.log(response.data.commandes);

                    this.commandes= response.data.commandes;
                      for (let index = 0; index < this.commandes.length; index++) {
            console.log("compuuuuuted")
            this.commandes[index].fk_document=this.fk_document_cmd;
                      }
                    // this.commande.fk_article= response.data.articles;
                this.loading= false;
                  });     
        },
        countBonCommandes(){

                axios.get('/countBonCommandes')
                .then((response) => {
 var today = new Date();
                    var yyyy = today.getFullYear();             
                    var year  = yyyy;
                    this.bonCommande.reference_bc='BC-'+year+'-'+response.data.count;
                    this.modePaiement.fk_document='BC-'+year+'-'+response.data.count;
                    this.fk_document_cmd='BC-'+year+'-'+response.data.count;


                    /*this.commande.fk_document='D'+response.data.count;
                    this.modePaiement.fk_document='D'+response.data.count;*/

                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
         getTypePaiement(){
                            axios.get('/getTypePaiement')
                            .then((response) => {                        
                                this.typePaiements= response.data.listeTypePaiments;
                            })
                            .catch(() => {
                                console.log('handle server error from here');
                            });
          },//// -------- date echeance 

             echeanceDate(){
                        Date.prototype.addDays = function(days) {
                        var dat = new Date(this.valueOf());
                        console.log('--------- date value of ----------')
                        console.log(dat);
                        dat.setDate(dat.getDate() + days);
                        return dat;
                        }
                         if(this.echeance != "choix"){   
                        var date_bc=this.bonCommande.date_bc
                        var dat = new Date(date_bc);

                        var echeance= +this.bonCommande.echeance;
                        //console.log("echeance-------- "+echeance)
                                if(typeof(echeance) === 'number'){
                            console.log("echeance is number            "+typeof(echeance) )
                        }
                        var today =dat.addDays(echeance);
                        var dd = today.getDate();
                        var mm = today.getMonth()+1; 
                        var yyyy = today.getFullYear();
                        if(dd<10) 
                                        {
                                            dd='0'+dd;
                                        } 

                                        if(mm<10) 
                                        {
                                            mm='0'+mm;
                                        } 
                        console.log(dd+'-'+mm+'-'+yyyy)

                                    this.bonCommande.date_limit_bc=yyyy+'-'+mm+'-'+dd;}
                                // return dd+'-'+mm+'-'+yyyy;
                        
                        },
                        diffDate() {
                        //console.log("xaaaaaaaaaaaaaaaaa"+this.devi.date_limit_d)

                            var startDate = Date.parse(this.bonCommande.date_bc);
                                    var endDate = Date.parse(this.bonCommande.date_limit_bc);
                                    var timeDiff = endDate - startDate;
                                    var daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                                    this.bonCommande.date_diff=daysDiff;
                        //alert(daysDiff)
                        },
                getContacts:function(id_compte){
                  axios.get('/getContacts/'+id_compte).then(
                  response => {
                       
                    this.contacts= response.data.contacts;
                    this.loading = false;
             
                  });     
        },
},
    
    
computed:{
    TotalBonCommande(){
            let sum=0;
            let sum_tva=0;
           
        for (let index = 0; index < this.commandes.length; index++) {
       
            this.commandes[index].totalHT  = (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd;

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
           
            this.bonCommande.montant_reste_bc=this.precisionRound(  +this.total_ttc - +this.bonCommande.accompte_bc,2);

            var res = this.bonCommande.montant_reste_bc.toString().split(".");



           this.bonCommande.total_lettre = this.$WrittenNumber(res[0], { lang: 'fr'})
             

            if (typeof res[1] !== 'undefined') {
                if(res[1].toString().split("")[0] == "0"){
                    this.bonCommande.total_lettre += ' et zéro '+this.$WrittenNumber(res[1], { lang: 'fr'})
                }
                else 
                this.bonCommande.total_lettre += ' et '+this.$WrittenNumber(res[1], { lang: 'fr'})
            }
            
            console.log('------ calucul virgule ')
            console.log(res[0].toString().split(""))

            
    },
       echeancee(){
            this.echeanceDate();

   },
   diff(){
            this.diffDate();
            console.log("computed")

   },  
          
},

watch:{
    'bonCommande.remise_total_bc':{
            handler: function(){
                   
                    this.TotalBonCommande;

            },

    
    },
commandes: {
            handler: function(){
                     
                    this.TotalBonCommande;
            },
            deep : true
    },
      'echeance':{
            handler: function(){
                    this.echeancee;
                    this.diff;

            }
    },

            'bonCommande.date_bc':{
            handler: function(){
                this.echeancee;
                    this.diff;

            }
    },
    'bonCommande.date_limit_bc':{
        handler: function(){
                this.echeancee;
                    this.diff;
            console.log("watch")

            }
    },
        'bonCommande.accompte_bc':{
            handler: function(){
                    this.TotalBonCommande;

            },
    },
            
},

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
.ThWidth{

    min-width: 59px;

}
</style>


 