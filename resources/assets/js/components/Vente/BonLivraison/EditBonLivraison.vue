
<template>
<div>
  <div class="loading" v-if="loading">
          <div class="lds-hourglass"></div>

    </div>
    <div v-if="!loading" >
    <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowBonLivraisons'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
    </div>    

<div class=" container colBackround">
    <form   @submit.prevent="EditBonLivraison">
<div class="row">
    <div class="col">
        <br>
    <h5><i class="far fa-file"></i> Modifier un bon de Livraison</h5>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">compte: </label>
                    <div class="col-sm-10">
            <multiselect v-model="compte" :options="comptes" placeholder="Choisir un client" label="nom_compte" @input="getCompte(compte.id_compte)"></multiselect>
                    
                </div>
            </div> 

            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Devis</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" placeholder="" v-model="bonLivraison.reference_bl" disabled>
                </div>
            </div>
                 <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Date </label>
                    <div class="col-sm-10">
                    <input  type="date" v-model="bonLivraison.date_bl" class="form-control" id="date" />
                    </div>
                </div> 
                <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Objet  </label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword" placeholder="" v-model="bonLivraison.objet_bl" >
                </div>
            </div>
          
    </div>
    <div class="col-md-6 col-sm-12">
        
        <div class="container  infoClient">
            <label for="">{{compte.nom_compte}} </label>
            <div class="form-group row">
            <div class="col-sm-10">
            <textarea placeholder="address client" class="AdressClient" name="" id="" cols="50" rows="4" v-model="bonLivraison.adresse_bl"></textarea>
            </div>
         </div>
        </div>
        <div class="container infoClient">
            <label for="">Adresse de facturation </label>
            <div class="form-group row">
            <div class="col-sm-10">
            <textarea placeholder="" class="AdressClient" name="" id="" cols="50" rows="4" v-model="bonLivraison.adresse_facture_bl" ></textarea>
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
                            <th>  <input class="form-control ThWidth"  type="text" v-model="commande.prix_ht" ></th> 
                                                        <th>  <input class="mr-4"  type="text" v-model="commande.fk_tva_cmd" disabled hidden>
                             <select class="form-control custom-select ThWidth " id="fk_tva_cmd" v-model="commande.fk_tva_cmd"  @change="changeTVA(commande.fk_tva_cmd,commande)"  >
                            <option selected>Choisir Tva</option>
                            <option v-for="tva in tvas" :key="tva.id_tva" :value="tva.id_tva">{{tva.taux_tva}}</option>
                            </select>
                            
                            </th> 
                            <th>  <input class="form-control ThWidth"  type="text" v-model="commande.totalHT" disabled>
                           
                            </th>
                                            <th><a @click="spliceBonLivraison(index,commande)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                                        </tr>
                      
                                    </tbody>
                                </table>
                                    
                            </div>
             </div>
     </div>
    
      <div class="row">
                                            <div class="col-sm-4"> 
                                               <multiselect  :hide-selected="true" v-model="article" :options="articles" placeholder="Choisir un article" label="designation"  track-by="designation" @input="getPrixArticle()"></multiselect>
                                                                  
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
                <label  class="form-control" for="">{{bonLivraison.total_lettre}}</label>
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
                <div v-if="echeance === undefined">
                    {{bonLivraison.date_l}}
                </div>
                <div v-if="echeance != undefined">
                    <br>
                    <div v-if="echeance != 'choix'">
                                 {{bonLivraison.date_limit_bl}} - ({{bonLivraison.date_diff}})
                    </div>
                <div v-if="echeance === 'choix'">
                  <input type="date"  class="form-control" id="inputPassword" placeholder="" v-model="bonLivraison.date_limit_bl" required>
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
                    <input type="text" class="form-control" id="reference_paiement" v-model="bonLivraison.remise_total_bl">
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
            <input type="text" class="form-control " style="width:100px;margin-left: 150px" id="staticEmail" v-model="bonLivraison.accompte_bl">
            </div>
         </div>
         <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Montant Reste (Montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="bonLivraison.montant_reste_bl">
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
            <textarea class="noteCondition" name="" id="" cols="80" rows="3" v-model="bonLivraison.notes_bl"></textarea>
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
            <textarea class="noteCondition" name="" id="" cols="80" rows="3" v-model="bonLivraison.conditions_reglements_bl"></textarea>
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
                           article: { 
                    id_article :0,
                    reference_art :"",
                    type_art :"",
                    designation :"",
                    description :"",
                    prix_ht_achat :"",
                    prix_ht_vente :"",
                    unite :"",
                    quantite :"",
                    quantite_min :"",
                    photo_art :'',
                    fk_tva_applicable :"",
                    fk_famille :"",
              },
              loading: false,
              suppBonLivraisons :[],



               bonLivraison : { 
            id_bl:0,
            reference_bl:"",
            date_bl:"", 
            type_operation_bl:"",
            objet_bl:"",
            date_emission_bl:"",
            remise_total_bl:"",
            majoration_bl:"",
            date_limit_bl:"",
            introduction_bl:"",  
            conditions_reglements_bl:"",
            notes_bl:"",
            adresse_bl:"",
            fk_status_bl:"",
            fk_compte_bl:"",
            fk_user_bl:"",
            total_ht_bl: 0,
            remise_ht_bl: 0,
            montant_net_bl: 0,
            tva_montant_bl: 0,
            montant_ttc_bl: 0,
            total_lettre : "",
            
            date_diff:"",
            date_l:"",
            accompte_bl: 0,
            montant_reste_bl: 0,
            adresse_facture_bl:"",
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
                modePaiements:[],

        typePaiement:{
            id_type_paiement: 0,
            type_paiement: "",
          },
                typePaiements:[],
                
             
      }),
               created () {
           if(this.$route.params.fk_compte_bl== undefined){
             this.$router.push('/ShowBonLivraisons');
        }
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
      

methods: { 

 changeTVA(tvaa,commande){
        console.log(tvaa);
 
                let this1 = this;
                   this.tvas.forEach(function(tva) {
              
               if(tva.id_tva == tvaa){
                    commande.taux_tva = tva.taux_tva;
               }
               
               });

    },
 fetchData () {
      //this.error = this.post = null
      this.loading = true
            this.getTvas();
            this.getClients();
            this.getCompte(this.$route.params.fk_compte_bl);
            this.showBonLivraison(this.$route.params.reference_bl);
            this.getCommandes(this.$route.params.reference_bl);
            //this.getStatus();
           
            this.getarticles();
             
            console.log('-------------- id_Compte ----- ---- ')
            console.log(this.$route.params.fk_compte_bl)
            
           
            this.getRemise(this.$route.params.id_compte)
            this.getTypePaiement();

    },

 

  
        precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
},



     spliceBonLivraison(index,commande){
            this.commandes.splice(index, 1);
           // commande.fk_document = this.$route.params.reference_bl;
                        this.suppBonLivraisons.push(commande);
                        console.log('supp ----------');
                        console.log(this.suppContacts)
        },
    showBonLivraison(reference_bl){

            axios.get('/showBonLivraison/'+reference_bl)
                                .then((response) => {
                                  
                                  this.echeance = 'choix';
                                   console.log('------- date limit ------------')
                                     console.log(this.bonLivraison);
                                    this.bonLivraison = response.data.bonLivraison[0];
                                    this.compte.id_compte = this.bonLivraison.id_compte;
                                    this.compte.nom_compte = this.bonLivraison.nom_compte;
                                   // this.compte.adresse_compte = this.bonLivraison.adresse_bl;
                                    this.modePaiement.id_modeP =this.bonLivraison.id_modeP
                                     // this.modePaiement.type_paiement =this.bonLivraison.type_paiement
                                     
                                    this.typePaiement.type_paiement =this.bonLivraison.type_paiement
                                    this.typePaiement.id_type_paiement =  this.bonLivraison.id_type_paiement 
                                    this.modePaiement.fk_type_paiement = this.bonLivraison.id_type_paiement                       
                                     console.log('--------- id type ')
                                    console.log(this.bonLivraison.id_type_paiement);
                                    console.log('--------------- ')

                                    this.modePaiement.reference_paiement    = this.bonLivraison.reference_paiement
                                     this.modePaiement.date_paiement   =this.bonLivraison.date_paiement
                                     this.modePaiement.fk_document =this.bonLivraison.fk_document
                                     this.bonLivraison.date_l=response.data.bonLivraison[0].date_limit_bl;
                                    
                                })
                                .catch(() => {
                                        console.log('handle server error from here');
                                });
        },

        getCommandes(reference_bl){

         axios.get('/getCommandes_bl/'+reference_bl)
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


    EditBonLivraison(){
             if(this.echeance === undefined){
     this.bonLivraison.date_limit_bl=this.bonLivraison.date_l;
     console.log(this.devi.date_limit_d)
     }
            this.bonLivraison.total_ht_bl =  this.total_prix,
            this.bonLivraison.remise_ht_bl = this.remise_T, 
            this.bonLivraison.montant_net_bl = this.net_HT ,
            this.bonLivraison.tva_montant_bl = this.tva_total ,
            this.bonLivraison.montant_ttc_bl =  this.total_ttc,
            //this.bonLivraison.adresse_bl=  this.compte.adresse_compte
            this.bonLivraison.fk_compte_bl = this.compte.id_compte;
            console.log('verifie fk_document  : ')
            console.log(this.commandes)
            console.log(this.modePaiement)
                  axios.post('/UpdateBonLivraison',{commandes:this.commandes,bonLivraison:this.bonLivraison,modePaiements:this.modePaiement,suppBonLivraisons: this.suppBonLivraisons})
        .then(response => {         
                console.log(response.data)
               // this.$router.push('/ShowBonLivraisons/editsuccess');
                this.$router.push({ name: 'ShowBonLivraisons', params: { success: "editsuccess"  }});
               // this.$router.push('/');
              // this.$router.push('/ShowBonLivraisons/addsuccess');  
        })
        .catch(() => {
                console.log('handle server error from here');
        });
    },


    async addRow (commande) {
       
       var result = await this.getPrixArticle();
       var result2 = await this.commandes.push( {

               quantite_cmd:commande.quantite_cmd,
               remise_cmd:commande.remise_cmd,
               majoration_cmd: commande.majoration_cmd,
               prix_ht: commande.prix_ht,
               fk_article:commande.fk_article,
               fk_document:this.$route.params.reference_bl,
               fk_tva_cmd:commande.fk_tva_cmd,
               designation:commande.designation,
               totalHT:commande.totalHT,
               total_ht:commande.total_ht,
               tva_montant:commande.tva_montant,
               taux_tva:commande.taux_tva,
               description_article:commande.description_article,
        });

            this.commande = {
                id_cmd:0,
                quantite_cmd:1,
                remise_cmd:0,
                majoration_cmd:0,
                prix_ht:0,
                fk_article:"",
                fk_document:this.$route.params.reference_bl,
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
        
        axios.get('/getAllArticles')
            .then((response) => {
                   console.log('-----------------article -------')
                   
                  
                    this.articles = response.data.articles;
                   console.log(this.articles[0])
            })
            .catch(() => {
                    console.log('handle server error from here');
            });
    },
        // recuperer des infos sur un article
   getPrixArticle(){
       // console.log('-------- articles ');
         //  console.log();
          this.commande.fk_article = this.article.id_article;
         let this1=this;
           this.articles.forEach(function(article) {
               console.log('**** article ***') 
               console.log(article) 
               if(article.id_article == this1.commande.fk_article){
                   this1.commande.prix_ht = article.prix_ht_vente;
                   this1.commande.fk_tva_cmd = article.fk_tva_applicable
                   this1.commande.designation = article.designation;
                   this1.commande.description_article = article.description;
                   this1.commande.taux_tva = article.taux_tva;
                  
                   return
                 
               }

});},
        // recuperer remise associe a un compte
    getRemise(id_compte){
                        
        axios.get('/getRemise/'+id_compte)
            .then((response) => {
                if(response.data.conditions_remise[0].remise==null){
                    this.bonLivraison.remise_total_bl=0;
                }
                else
                    this.bonLivraison.remise_total_bl=response.data.conditions_remise[0].remise;
                  
             
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
                    this.bonLivraison.adresse_bl = this.compte.adresse_compte;
                    this.bonLivraison.adresse_facture_bl = this.compte.adresse_compte;

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
                 getTypePaiement(){
                            axios.get('/getTypePaiement')
                            .then((response) => {                        
                                this.typePaiements= response.data.listeTypePaiments;
                            })
                            .catch(() => {
                                console.log('handle server error from here');
                            });
          },
          echeanceDate(){
                        Date.prototype.addDays = function(days) {
                        var dat = new Date(this.valueOf());
                        console.log('--------- date value of ----------')
                        console.log(dat);
                        dat.setDate(dat.getDate() + days);
                        return dat;
                        }
                        if(this.echeance != "choix"){
                        var date_bl=this.bonLivraison.date_bl
                        var dat = new Date(date_bl);
                     console.log('------ date limit bon commande - --- --')
                                console.log(this.echeance)
                        var echeance= +this.echeance;
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

                                    this.bonLivraison.date_limit_bl=yyyy+'-'+mm+'-'+dd;}
                                // return dd+'-'+mm+'-'+yyyy;

                        
                        },
                        diffDate() {
                        //console.log("xaaaaaaaaaaaaaaaaa"+this.devi.date_limit_d)

                            var startDate = Date.parse(this.bonLivraison.date_bl);
                                    var endDate = Date.parse(this.bonLivraison.date_limit_bl);
                                    var timeDiff = endDate - startDate;
                                    var daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                                    this.bonLivraison.date_diff=daysDiff;
                        //alert(daysDiff)
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
            let remise=this.commande.totalHT*(this.bonLivraison.remise_total_bl/100);
                //montant de commande apres remise
            let net=this.commande.totalHT - this.commande.totalHT*(this.bonLivraison.remise_total_bl/100);
                //montant tva par article
            let tva=net*(this.commande.taux_tva/100);
            this.commande.tva_montant=tva;

    },
            
    TotalBonLivraison(){
             let sum=0;
            let sum_tva=0;
        for (let index = 0; index < this.commandes.length; index++) {
                //total de prix de tt commandes
                                this.commandes[index].totalHT  = this.precisionRound( (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd,2);

            sum = this.precisionRound(+sum + (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd,2);
                //montant tva de chaque commande apres remise
            this.tva_montant= this.precisionRound( this.total_prix*(this.bonLivraison.remise_total_bl/100)*(this.commande.taux_tva/100),2);
                //montant de remise
            let remise= this.precisionRound( this.commandes[index].totalHT*(this.bonLivraison.remise_total_bl/100),2);
                //montant apres remise
            let net=this.precisionRound( this.commandes[index].totalHT - this.commandes[index].totalHT*(this.bonLivraison.remise_total_bl/100),2);
                // montant de tva
            let tva=this.precisionRound( net*(this.commandes[index].taux_tva/100),2);
                // total de montant des tvas
            sum_tva= this.precisionRound( +sum_tva + +tva,2);
        }
                // total de prix de tt commandes (affectation)
            this.total_prix = this.precisionRound( sum ,2);
                // total de montant tvas (affectation)
            this.tva_total= this.precisionRound( sum_tva ,2);
                //remise sur le montant total
            this.remise_T= this.precisionRound( this.total_prix*(this.bonLivraison.remise_total_bl/100),2);
                // montant total apres remise
            this.net_HT=this.precisionRound( this.total_prix - this.remise_T,2);
               // montant total final
            this.total_ttc=  this.precisionRound( +this.net_HT + +this.tva_total,2);
            this.bonLivraison.montant_reste_bl=this.precisionRound(  +this.total_ttc - +this.bonLivraison.accompte_bl,2);

            var res = this.bonLivraison.montant_reste_bl.toString().split(".");
           this.bonLivraison.total_lettre = this.$WrittenNumber(res[0], { lang: 'fr'})
             

            if (typeof res[1] !== 'undefined') {
                if(res[1].toString().split("")[0] == "0"){
                    this.bonLivraison.total_lettre += ' et zéro '+this.$WrittenNumber(res[1], { lang: 'fr'})
                }
                else 
                this.bonLivraison.total_lettre += ' et '+this.$WrittenNumber(res[1], { lang: 'fr'})
            }
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
       'bonLivraison.remise_total_bl':{
            handler: function(){
                  
                    this.TotalBonLivraison;

            },
            '$route': 'fetchData',
    },
      


    commandes: {
            handler: function(){
                      
             //   this.totalHTaxe;
                this.TotalBonLivraison;

            },
            deep : true
    },
          'echeance':{
            handler: function(){
                    this.echeancee;
                    this.diff;

            }
    },

            'bonLivraison.date_bl':{
            handler: function(){
                this.echeancee;
                    this.diff;

            }
    },
    'bonLivraison.date_limit_bl':{
        handler: function(){
                this.echeancee;
                    this.diff;
            console.log("watch")

            }
    },
            'bonLivraison.accompte_bl':{
            handler: function(){
                    this.TotalBonLivraison;

            },
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

.ThWidth{

    min-width: 59px;

}
</style>


 