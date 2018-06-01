<template>
<div>
          
    <div class="loading" v-if="loading">
          <div class="lds-hourglass"></div>
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
     <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/getFacturesA'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
    </div> 
<div class=" container colBackround">
   
          <form   @submit.prevent="addFacture">
<div class="row">
    <div class="col">
        <br>
    <h5><i class="far fa-file"></i> Ajouter une facture : <strong>{{facture.reference_f}}</strong></h5>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Compte  </label>
                <div class="col-sm-10">
 <multiselect v-model="compte" :options="comptes" placeholder="Choisir un Fournisseur" label="nom_compte" @input="getClient(compte.id_compte)"></multiselect>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Date</label>
                <div class="col-sm-10">
                <input type="date" class="form-control" v-model="facture.date_f" id="inputPassword" placeholder="">
                </div>
            </div>
             <div class="form-group row" v-if="TestConvert">
                <label for="inputPassword" class="col-sm-2 col-form-label" v-if="TestConvertD">Réf Devis</label>
                 <label for="inputPassword" class="col-sm-2 col-form-label" v-if="TestConvertBC" >Réf BC</label>
                <label for="inputPassword" class="col-sm-2 col-form-label" v-if="TestConvertBL" >Réf BL</label>
                <div class="col-sm-10">
                <input type="text" readonly class="form-control" id="inputPassword" placeholder="" v-model="facture.fk_bl">
                </div>
            </div>
          
    </div>
    <div class="col-md-6 col-sm-12">
        
        <div class="container  infoClient">
            <label for="">{{compagnie.nom_societe_comp}} </label>
            <div class="form-group row">
            <div class="col-sm-10">
            <textarea placeholder="address fournisseur" class="AdressClient" name="" id="" cols="50" rows="4" v-model="facture.adresse_f"></textarea>
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
                              <input class="mr-4"  type="text" v-model="commande.fk_article" disabled hidden>
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
                            <th><input class="mr-4"  type="text" v-model="commande.quantite_cmd" ></th>
                            <th>  <input class="form-control"  type="text" v-model="commande.remise_cmd" ></th> 
                            <th>  <input class="form-control"  type="text" v-model="commande.prix_ht" ></th> 
                            
                            <th> 
                              <select class="form-control custom-select " id="fk_tva_cmd" v-model="commande.fk_tva_cmd" @change="changeTVA(commande.fk_tva_cmd,commande)" >
                    <option selected>Choisir Tva</option>
                    <option v-for="tva in tvas" :key="tva.id_tva" :value="tva.id_tva">{{tva.taux_tva}}</option>
                    </select>

                            </th> 
                            <th>  <input class="form-control"  type="text" v-model="commande.total_ht_cmd" disabled></th>
                            <th><a  class="btn btn-danger" @click="removeRow(index)"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
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
                <label  class="form-control" for="total_lettre_f">{{facture.total_lettre_f}}</label>
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
                                 {{facture.date_limit_f}} - ({{facture.date_diff}})
                    </div>
                <div v-if="echeance === 'choix'">
                  <input type="date"  class="form-control" id="inputPassword" placeholder="" v-model="facture.date_limit_f" required>
                </div>
                </div>
                
                 
                    <!--
                <input type="number" class="form-control" id="inputPassword" placeholder="" v-model="facture.echeance">
                {{facture.date_limit_f}}

                <input type="date" class="form-control" id="inputPassword" placeholder="" v-model="facture.date_limit_f">
               -->
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
                    <label for="remise_total_f"  class="col-sm-4 col-form-label" >Remise Total </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="remise_total_f" v-model="facture.remise_total_f">
                    </div>
                </div>                  
                      

                                 
    </div>
    <div class="col-md-6 col-sm-12">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Total HT </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding " id="staticEmail" v-model="facture.total_ht_f">
            </div>
         </div>
   
       
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Remise Total (montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding " id="staticEmail" v-model="facture.remise_ht_f">
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label"> Montant Net HT  </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="facture.montant_net_f">
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">TVA (Montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="facture.tva_montant_f">
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Montant TTC (Montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="facture.montant_ttc_f">
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Acompte </label>
            <div class="col-sm-8">
            <input type="text" class="form-control " style="width:100px;margin-left: 150px" id="staticEmail" v-model="facture.accompte_f">
            </div>
         </div>
         <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Net à payer (Montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="facture.montant_reste_f">
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
            <textarea class="noteCondition" name="" id="" cols="80" rows="3" v-model="facture.notes_f"></textarea>
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
            <textarea class="noteCondition" name="" id="" cols="80" rows="3" v-model="facture.conditions_reglements_f"></textarea>
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
            TestConvert:false,
            TestConvertD:false,
            TestConvertBC:false,
            TestConvertBL:false,
            loading: false,
            error: null,
              // objet test sur affichage , ajout , recherche
              Testopen:{
                testAjout : false,
                testAffiche : false,
              },
              testEdit : false,

              // facture
              facture: { 
            id_facture:0,
            reference_f:"",
            date_f:"", 
            adresse_f:"",
            type_operation_f:"",
            objet_f:"",
            date_emission_f:"",
            remise_total_f:"",
            majoration_f:"",
            date_limit_f:"",
            introduction_f:"",  
            conditions_reglements_f:"",
            notes_f:"",
            accompte_f:"",
           fk_status_f:"",
           fk_compte_f:"",
            fk_user_f:"",

            total_ht_f:0,
            remise_ht_f:0,
            montant_net_f:0,
            tva_montant_f:0,
            montant_ttc_f:0,
            montant_reste_f:0,

            //echeance:0,
            date_diff:"",
            total_lettre_f:"",
              },
              echeance:0,
              compte:{
                  id_compte:0,
                  nom_compte:"",
              },
              // tableau des factures 
              factures :[],
              //tables foreign key 
              status:[],
              tvas:[],
              articles:[],
              comptes:[],
              typePaiements:[],
            typePaiement:{
                id_type_paiement:0,
                type_paiement:"",
            },
           compagnie:{},
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
            //montant final en lettre
            total_lettre:"",
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
               description_article:"",
               //montant tva de chaque commande
               tva_montant:0,
               //affichage
               // % de tva
               taux_tva:0,
               // designation d'article pr chaque commande
               designation:"",
               // montant total de chaque commande
                total_ht_cmd:0,
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
             
      }),
      

methods: { 
         getCompte:function(id_compte){
                  axios.get('/getCompte/'+id_compte).then(
                  response => {
                       
                    this.compte= response.data.compte;
        
                    console.log(this.compte)
                  });
               
        },
        getCompagnie(fk_compagnie){
                  axios.get('/getCompagnie/'+fk_compagnie).then(
                  response => {
                       
                    this.compagnie= response.data.compagnie;
                    this.facture.adresse_f = this.compagnie.adresse_comp;
                    //this.bonCommande.adresse_facture_bc = this.compagnie.adresse_comp;
                   // this.getContacts(this.compte.id_compte);
                   // console.log(this.compte)
                  });
                 // this.getRemise(id_compte);     
        },
    DataCourant(){
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() +1; 
            var yyyy = today.getFullYear();
             if(dd<10) 
                {
                    dd='0'+dd;
                } 

                if(mm<10) 
                {
                    mm='0'+mm;
                } 
           return  yyyy+'-'+mm+'-'+dd;
          },

async  addRow (commande) {
      var result = await this.getPrixArticle();
      var result2 = await this.commandes.push( {
             
               quantite_cmd:commande.quantite_cmd,
               remise_cmd:commande.remise_cmd,
               majoration_cmd: commande.majoration_cmd,
               prix_ht: commande.prix_ht,
               fk_article:commande.fk_article,
               fk_document: commande.fk_document,
               fk_tva_cmd:commande.fk_tva_cmd,

               description_article:commande.description_article,
               designation:commande.designation,
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
               description_article:"",
               // designation d'article pr chaque commande
               designation:"",
               // montant total de chaque commande
                total_ht_cmd:0,
                };
    },

    removeRow(index) {
        this.commandes.splice(index,1);
    
    },


    addFacture(){ 
                        console.log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>")

console.log(this.facture.total_lettre_f)    
        this.facture.type_operation_f="achat";
        
        axios.post('/addFacture',{commandes:this.commandes,factures:this.facture,modePaiements:this.modePaiement})
        .then(response => {         
                this.$router.push('/getFacturesA/add');
        })
        .catch(() => {
                console.log('handle server error from here');
        });
            
    },
    
  changeTVA(tvaa,commande){
        console.log(tvaa);
 
                let this1 = this;
                   this.tvas.forEach(function(tva) {
              
               if(tva.id_tva == tvaa){
                    commande.taux_tva = tva.taux_tva;
               }
               
               });

    },
        //recuperer tt les status
    getStatus(){
        axios.get('/getStatus')
        .then((response) => {
                this.status= response.data.status;
                 this.facture.fk_status_f="Brouillon"; 
                  this.loading = false;
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
 this.commande.fk_article = this.article.id_article;
           let this1=this;
           this.articles.forEach(function(article) {
               if(article.id_article == this1.commande.fk_article){
                   this1.commande.prix_ht = article.prix_ht_achat;
                   this1.commande.fk_tva_cmd = article.fk_tva_applicable
                   this1.commande.designation = article.designation;
                   this1.commande.description_article = article.description;
                    this1.commande.taux_tva = article.taux_tva;
                   console.log('truuuuue');
               }
                
                 console.log('-------- articles ');
  console.log(article);
});
     
    },
        // recuperer remise associe a un compte
    getRemise(id_compte){
        console.log("remise"+id_compte);

        axios.get('/getRemise/'+id_compte)
            .then((response) => {
                if(response.data.conditions_remise[0].remise==null){
                    this.facture.remise_total_f=0;
                }
                else
                    this.facture.remise_total_f=response.data.conditions_remise[0].remise;
             
            })
            .catch(() => {
                    console.log('handle server error from here');
            });
    },
        // recuperer liste des fournisseurs
    getFournisseur(){
                
        axios.get('/getFournisseur')
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
                  this.facture.adresse_f=response.data.compte.adresse_compte;
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
          },
                   precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
},
countFactures(){

                axios.get('/countFactures',{params: { type_operation_f: 'achat' } })
                .then((response) => {

                   var today = new Date();
                    var yyyy = today.getFullYear();             
                    var year  = yyyy;
                    this.facture.reference_f='F-'+year+'-'+response.data.count;
                    this.modePaiement.fk_document='F-'+year+'-'+response.data.count;
                    this.commande.fk_document='F-'+year+'-'+response.data.count;
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          }, 
      
 getCommandes(reference_d){
                  axios.get('/getCommandes/'+reference_d).then(
                  response => {
                      console.log("commandes:  ");
                         console.log(response.data.commandes);

                    this.commandes= response.data.commandes;
                    console.log('-----commandes ---------------------')
                    console.log(this.commandes);
                      for (let index = 0; index < this.commandes.length; index++) {
            console.log("compuuuuuted")
            this.commandes[index].fk_document=this.facture.reference_f;
                      }
                    // this.commande.fk_article= response.data.articles;
                this.loading= false;
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
var date_f=this.facture.date_f
var dat = new Date(date_f);

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

            this.facture.date_limit_f=yyyy+'-'+mm+'-'+dd;}
           // return dd+'-'+mm+'-'+yyyy;
   
},
diffDate() {

    var startDate = Date.parse(this.facture.date_f);
            var endDate = Date.parse(this.facture.date_limit_f);
            var timeDiff = endDate - startDate;
            var daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
            this.facture.date_diff=daysDiff;
},

       fetchData () {
      this.loading = true
        //convert bon livraison to facture
      
    if(this.$route.params.bonCommande != null){
        this.countFactures();
    
    this.getFournisseur();
    this.getCompte(this.$route.params.bonCommande.id_compte);
    this.facture.fk_bl = this.$route.params.bonCommande.objet_bc;
    
    this.getarticles();      
    

    
    this.facture.fk_compte_f=this.$route.params.bonCommande.id_compte;
    this.modePaiement.reference_paiement = this.$route.params.bonCommande.reference_paiement;
    this.modePaiement.date_paiement = this.$route.params.bonCommande.date_paiement ;
    this.modePaiement.fk_document = this.$route.params.bonCommande.fk_document ;
    this.modePaiement.fk_type_paiement = this.$route.params.bonCommande.fk_type_paiement ;
    this.typePaiement.type_paiement = this.$route.params.bonCommande.type_paiement;
    this.facture.accompte_f= this.$route.params.bonCommande.accompte_bc;
    this.facture.conditions_reglements_f = this.$route.params.bonCommande.conditions_reglements_bc
    this.facture.notes_f =  this.$route.params.bonCommande.notes_bc;
    this.facture.adresse_f = this.$route.params.bonCommande.adresse_facture_bc ;
    this.facture.remise_total_f = this.$route.params.bonCommande.remise_total_bc ;
    this.echeance = 'choix';
    this.facture.date_limit_f = this.$route.params.bonCommande.date_limit_bc;
    console.log('limitttt-------')
    console.log(this.$route.params.bonCommande.date_limit_bc)
    this.facture.date_f = this.DataCourant();
    this.facture.fk_bl = this.$route.params.bonCommande.reference_bc;
        this.getCommandes(this.$route.params.bonCommande.reference_bc);

//this.Testopen.testRefBC = true;
//this.bonLivraison.fk_bonCommande= this.$route.params.bonCommande.reference_bc;

this.getTypePaiement();
console.log('-------------------- test ------------------------')
           this.TestConvert = true
          
           this. TestConvertBC = true
          
          
    }
       else if(this.$route.params.bonLivraison != null){
           console.log("fetchdata=======>")
           console.log(this.$route.params.bonLivraison)
        this.countFactures();
        
        this.id_bl = this.$route.params.bonLivraison.id_bl;
        this.facture.fk_bl=this.$route.params.bonLivraison.reference_bl;
        this.facture.fk_compte_f=this.$route.params.bonLivraison.id_compte;
        
        this.compte.nom_compte= this.$route.params.bonLivraison.nom_compte;
        this.compte.id_compte= this.$route.params.bonLivraison.id_compte;
        
        this.modePaiement.reference_paiement=this.$route.params.bonLivraison.reference_paiement;
        this.modePaiement.date_paiement=this.$route.params.bonLivraison.date_paiement;
        this.typePaiement.id_type_paiement = this.$route.params.bonLivraison.id_type_paiement; 
        this.modePaiement.fk_type_paiement =this.$route.params.bonLivraison.id_type_paiement;                       
        this.typePaiement.type_paiement=this.$route.params.bonLivraison.type_paiement;
        
        this.facture.objet_f= this.$route.params.bonLivraison.objet_bl;
        this.facture.date_f= this.$route.params.bonLivraison.date_bl;
        this.facture.remise_total_f= this.$route.params.bonLivraison.remise_total_bl;
        this.facture.date_limit_f= this.$route.params.bonLivraison.date_limit_bl;
        this.facture.conditions_reglements_f= this.$route.params.bonLivraison.conditions_reglements_bl;
        this.facture.notes_f= this.$route.params.bonLivraison.notes_bl;
        this.facture.fk_bl= this.$route.params.bonLivraison.reference_bl;
        this.facture.adresse_f= this.$route.params.bonLivraison.adresse_facture_bl;
        this.facture.accompte_f= this.$route.params.bonLivraison.accompte_bl;
        this.compte.nom_compte= this.$route.params.bonLivraison.nom_compte;
        this.compte.id_compte= this.$route.params.bonLivraison.fk_compte_bl;
        
        this.echeance = 'choix';
        this.getarticles();
        this.getFournisseur();
        this.getTvas();
        this.getTypePaiement();
        this.getCommandes(this.$route.params.bonLivraison.reference_bl);
        //this.getCompagnie(this.$route.params.fk_compagnie);
           this.TestConvert = true
           this. TestConvertBL = true
    }
    //convert devis to facture
    else if(this.$route.params.devi != null){
           console.log("devis convert=======>")
           console.log(this.$route.params.devi)
        this.countFactures();
        
        this.id_devis = this.$route.params.devi.id_devis;
        this.facture.fk_bl=this.$route.params.devi.reference_d;
        this.facture.fk_compte_f=this.$route.params.devi.id_compte;

        this.compte.nom_compte= this.$route.params.devi.nom_compte;
        this.compte.id_compte= this.$route.params.devi.id_compte;
        
        this.modePaiement.reference_paiement=this.$route.params.devi.reference_paiement;
        this.modePaiement.date_paiement=this.$route.params.devi.date_paiement;
        this.typePaiement.id_type_paiement = this.$route.params.devi.id_type_paiement; 
        this.modePaiement.fk_type_paiement =this.$route.params.devi.id_type_paiement;                       
        this.typePaiement.type_paiement=this.$route.params.devi.type_paiement;

        this.facture.objet_f= this.$route.params.devi.objet_d;
        this.facture.date_f= this.$route.params.devi.date_d;
        this.facture.remise_total_f=this.$route.params.devi.remise_total_d;
        this.facture.date_limit_f= this.$route.params.devi.date_limit_d;
        this.facture.conditions_reglements_f= this.$route.params.devi.conditions_reglements_d;
        this.facture.notes_f= this.$route.params.devi.notes_d;
        this.facture.fk_devis= this.$route.params.devi.reference_d;
        this.facture.adresse_f= this.$route.params.devi.adresse_d;
        this.facture.accompte_f= this.$route.params.devi.accompte_d;

        this.echeance = 'choix';
        this.getarticles();
        this.getFournisseur();
        this.getTvas();
        this.getTypePaiement();
        this.getCommandes(this.$route.params.devi.reference_d);
           this.TestConvert = true
          
           this. TestConvertD = true
       }
    else{
      // replace `getPost` with your data fetching util / API wrapper
            this.facture.date_f=this.$route.params.currentDate;
            this.facture.reference_f=this.$route.params.reference_f;
            this.commande.fk_document=this.$route.params.reference_f;
            this.modePaiement.fk_document=this.$route.params.reference_f;
            this.facture.fk_compte_f=this.$route.params.id_compte;
            this.facture.id_compte=this.$route.params.id_compte;

          
           
            this.getTvas();
            this.getarticles();
            this.getFournisseur();
            this.getClient(this.$route.params.id_compte);
            this.getRemise(this.$route.params.id_compte);
            this.getStatus();
            this.getTypePaiement();
            this.getCompagnie(this.$route.params.fk_compagnie);

    }
},
    
},    
computed:{
        // calcul
    TotalFacture(){
            let sum=0;
            let sum_tva=0;
        for (let index = 0; index < this.commandes.length; index++) {
             this.commandes[index].total_ht_cmd  = this.precisionRound( (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd,2);

                //total de prix de tt commandes
            sum =this.precisionRound(  +sum + (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd,2);
                //montant tva de chaque commande apres remise
            this.tva_montant=this.precisionRound( this.total_prix*(this.facture.remise_total_f/100)*(this.commande.taux_tva/100),2);
                //montant de remise
            let remise=this.precisionRound( this.commandes[index].total_ht_cmd*(this.facture.remise_total_f/100),2);
                //montant apres remise
            let net=this.precisionRound( this.commandes[index].total_ht_cmd - this.commandes[index].total_ht_cmd*(this.facture.remise_total_f/100),2);
                // montant de tva
        let tva=this.precisionRound( net*(this.commandes[index].taux_tva/100),2);
        // let tva=this.precisionRound( net*(this.commandes[index].fk_tva_cmd/100),2);
                // total de montant des tvas
            sum_tva=this.precisionRound(  +sum_tva + +tva,2);
        }
                // total de prix de tt commandes (affectation)
            this.total_prix = this.precisionRound( +sum + +this.commande.total_ht_cmd,2);
            this.facture.total_ht_f= this.total_prix;
                // total de montant tvas (affectation)
            this.tva_total=this.precisionRound( +sum_tva + +this.commande.tva_montant ,2);
            this.facture.tva_montant_f=this.tva_total;
                //remise sur le montant total
            this.remise_T=this.precisionRound( this.total_prix*(this.facture.remise_total_f/100),2);
            this.facture.remise_ht_f=this.remise_T;
                // montant total apres remise
            this.net_HT=this.precisionRound( this.total_prix - this.remise_T,2);
            this.facture.montant_net_f=this.net_HT;
               // montant total final
            this.total_ttc= this.precisionRound(  +this.net_HT + +this.tva_total,2);
            this.facture.montant_ttc_f=this.total_ttc;

            this.facture.montant_reste_f=this.precisionRound(  +this.total_ttc - +this.facture.accompte_f,2);

            var res = this.facture.montant_reste_f.toString().split(".");
           this.total_lettre = this.$WrittenNumber(res[0], { lang: 'fr'})
            

            if (typeof res[1] !== 'undefined') {
                if(res[1].toString().split("")[0] == "0"){
                    this.total_lettre += ' et zéro '+this.$WrittenNumber(res[1], { lang: 'fr'})
                }
                else 
                this.total_lettre += ' et '+this.$WrittenNumber(res[1], { lang: 'fr'})
            }
             this.facture.total_lettre_f=this.total_lettre;
    },
    echeancee(){
            this.echeanceDate();

   },
   diff(){
            this.diffDate();
            console.log("computed")

   }      
},
     created () {
            console.log('les routes')
            console.log(this.$route.params)
                if(this.$route.params.reference_f == undefined && this.$route.params.bonCommande == undefined && this.$route.params.devi == undefined && this.$route.params.bonLivraison == undefined){
             this.$router.push('/getFacturesA');
        }
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
watch:{
    'facture.tva_montant_f':{
            handler: function(){
                    this.TotalFacture;

            },
    },
     'facture.remise_total_f':{
            handler: function(){
                    this.TotalFacture;

            },
    },
  'facture.accompte_f':{
            handler: function(){
                    this.TotalFacture;

            },
    },
    'commande': {
            handler: function(){
                    this.TotalFacture;

            },
            deep:true
    },

    commandes: {
            handler: function(){
                this.TotalFacture;

            },
            deep : true
    },
    'echeance':{
            handler: function(){
                    this.echeancee;
                    this.diff;

            }
    },

            'facture.date_f':{
            handler: function(){
                this.echeancee;
                    this.diff;

            }
    },
    'facture.date_limit_f':{
        handler: function(){
                this.echeancee;
                    this.diff;
            console.log("watch")

            }
    },
       // call again the method if the route changes
    '$route': 'fetchData',     
},

    mounted(){
 console.log('----------------')
            console.log(this.$route.params.id_compte + " / "+ this.$route.params.reference_f+
            " / " + this.$route.params.currentDate)
           
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


    /*loading*/
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