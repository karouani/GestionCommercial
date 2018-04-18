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
        <router-link class="btn btn-primary mb-3  float-right " :to="'/getDevis'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
    </div>
<div class=" container colBackround">
          <form   @submit.prevent="updateDevis">
<div class="row">
    <div class="col">
        <br>
    <h5><i class="far fa-file"></i> Modifier un devis : <strong>{{devi.reference_d}}</strong></h5>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Compte  </label>
                <div class="col-sm-10">
    <select class="form-control custom-select " id="id_compte" v-model="devi.fk_compte_d" @click="getClient(devi.fk_compte_d)" @change="getClient(devi.fk_compte_d)">
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
            <label for="">{{devi.nom_compte}} </label>
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
                            <th>  <input class="form-control"  type="text" v-model="commande.majoration_cmd" ></th> 
                            <th>  <input class="form-control"  type="text" v-model="commande.prix_ht" ></th> 
                            
                            <th> 
                              <select class="form-control custom-select " id="fk_tva_cmd" v-model="commande.fk_tva_cmd" >
                    <option selected>Choisir Tva</option>
                    <option v-for="tva in tvas" :key="tva.id_tva" :value="tva.id_tva">{{tva.taux_tva}}</option>
                    </select>

                            </th> 
                            <th>  <input class="form-control"  type="text" v-model="commande.total_ht_cmd" disabled></th>
                            <th><a  class="btn btn-danger" @click="spliceCommande(index,commande)"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
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
                <label for="inputPassword" class="col-sm-4 col-form-label">Total en lettre</label>
                <div class="col-sm-8">
                <label  class="form-control" for="">{{devi.total_lettre_d}}</label>
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
                    <br>
                    {{devi.date_l}}
                </div>
                <div v-if="echeance != undefined">
                    <br>
                    <div v-if="echeance != 'choix'">
                                 {{devi.date_limit_d}} - ({{devi.date_diff}})
                    </div>
                <div v-if="echeance === 'choix'">
                  <input type="date"  class="form-control" id="inputPassword" placeholder="" v-model="devi.date_limit_d" required>
                </div>
                </div>
                
                 
                    <!--
                <input type="number" class="form-control" id="inputPassword" placeholder="" v-model="echeance">
                {{devi.date_limit_d}}

                <input type="date" class="form-control" id="inputPassword" placeholder="" v-model="devi.date_limit_d">
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
                    <label for="remise_total_d"  class="col-sm-4 col-form-label" >Remise Total </label>
                    <div class="col-sm-8">
                        <div class="form-group row">
                    <input type="text" class="form-control" id="remise_total_d" v-model="devi.remise_total_d">
                    <input type="text" class="form-control" disabled placeholder="%">
                        </div>
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
         <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Acompte </label>
            <div class="col-sm-8">
            <input type="text" class="form-control " style="width:100px;margin-left: 150px" id="staticEmail" v-model="devi.accompte_d">
            </div>
         </div>
         <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Net à payer (Montant) </label>
            <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext calculePadding" id="staticEmail" v-model="devi.montant_reste_d">
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
</div>
</template>

<script>

    export default{ 
        
          data: () => ({
                                loading: false,
error: null,
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
            accompte_d:0,
           fk_status_d:"",
           fk_compte_d:"",
            fk_user_d:"",

            total_ht_d:0,
            remise_ht_d:0,
            montant_net_d:0,
            tva_montant_d:0,
            montant_ttc_d:0,
            montant_reste_d:0,

            
      nom_compte:"",

      
      date_diff:"",
      date_echeance_choix:"",
      total_lettre_d : ""
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
            suppCommandes :[],
            index:0,
            echeance:0,
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
               // designationnation d'article pr chaque commande
               designation:"",
               // montant total de chaque commande
                total_ht_cmd:0,
                description_article:"",
                echeance:0,
      date_diff:"",
      date_echeance_choix:"",
      date_l:"",
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
      

methods: { 


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
               // designationnation d'article pr chaque commande
               designation:"",
               description_article:"",
               // montant total de chaque commande
                total_ht_cmd:0,
                };
    },

    removeRow(index) {
        this.commandes.splice(index,1);
    
    },

 updateDevis: function(){
      if(this.echeance === undefined){
     this.devi.date_limit_d=this.devi.date_l;
     console.log(this.devi.date_limit_d)
     }

        axios.post('/updateDevis',{devis:this.devi,commandes:this.commandes,modePaiements:this.modePaiement,suppCommandes: this.suppCommandes}).then( response => {             
                    this.$router.push('/getDevis/edit');  
                    
                  
                  });
                  
           
        },
                         fetchData () {
      //this.error = this.post = null
      this.loading = true
       console.log('----------------')
  
            this.devi.id_devis = this.$route.params.id_devis;
            this.devi.reference_d = this.$route.params.reference_d;
 this.getDevisD(this.devi.id_devis);
            this.getStatus();
            //this.countDevis();
            this.getTvas();
            this.getarticles();
       // console.log("++++++++++++++++"+this.devi.fk_compte_d);
          // this.getClient(this.devi.fk_compte_d)
            this.getClients();
            console.log(this.devi.id_devis);
             
              
              this.getPaiement(this.devi.reference_d);
              this.getCommandes(this.devi.reference_d);
              this.getTypePaiement();
      // replace `getPost` with your data fetching util / API wrapper
   //this.getDevisD(this.$route.params.id_devis);

    },
        spliceCommande(index,commande){
            this.commandes.splice(index, 1);
                        this.suppCommandes.push(commande);
                       // console.log('supp ----------');
                        //console.log(this.suppCommandes)
        },  

    getPaiement(reference_d){
        //console.log("referennnce")
        
     axios.get('/getPaiement/'+reference_d).then(
                  response => {
                         //console.log(response.data.modePaiement);

                    this.modePaiement= response.data.modePaiement[0];

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
 getClients(){
                
        axios.get('/getClients')
            .then((response) => {
                    this.comptes = response.data.comptes;
                  
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
   
    getClient(fk_compte_d){
                console.log("compteee "+fk_compte_d);
        axios.get('/getClient/'+fk_compte_d)
            .then((response) => {
                    this.compte = response.data.compte;

                    this.getRemise(fk_compte_d)
                                                        //console.log("adresse ----------- "+this.devi.adresse_d)

                  this.devi.adresse_d=response.data.compte.adresse_compte;
                  this.devi.nom_compte =response.data.compte.nom_compte;
                             })
            .catch(() => {
                    console.log('handle server error from here');
        });
    },

        // recuperer des infos sur un article
    getPrixArticle(){
           
           let this1=this;
           this.articles.data.forEach(function(article) {
               if(article.id_article == this1.commande.fk_article){
                   this1.commande.prix_ht = article.prix_ht_vente;
                   this1.commande.fk_tva_cmd = article.fk_tva_applicable
                   this1.commande.designation = article.designation;
                   this1.commande.description_article = article.description;
                   this1.tauxTva();
                  // console.log('truuuuue');
               }
                
                // console.log('-------- articles ');
 // console.log(article);
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
  getDevisD:function(id_devis){
                  axios.get('/getDevisD/'+id_devis).then(
                  response => {
                         //console.log(response.data.devi.fk_compte_d);
                   
                    this.echeance = 'choix';
                    this.devi= response.data.devi[0];
                    this.devi.date_l=response.data.devi[0].date_limit_d;
                    //console.log("devi date..."+this.devi.date_d)
                  });     
        },
        getCommandes:function(reference_d){
                  axios.get('/getCommandes/'+reference_d).then(
                  response => {
                      //console.log("commandes:  ");
                         //console.log(response.data.commandes);

                    this.commandes= response.data.commandes;
                     this.loading = false
                    // this.commande.fk_article= response.data.articles;

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

    echeanceDate(){
        Date.prototype.addDays = function(days) {
            var dat = new Date(this.valueOf());
            dat.setDate(dat.getDate() + days);
            return dat;
        }
        if(this.echeance != "choix"){
        var dat = new Date(this.devi.date_d);
        var today =dat.addDays(+this.echeance);
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
            // console.log(dd+'-'+mm+'-'+yyyy)

            this.devi.date_limit_d=yyyy+'-'+mm+'-'+dd;}
   
    },
diffDate() {
//console.log("xaaaaaaaaaaaaaaaaa"+this.devi.date_limit_d)

            var startDate = Date.parse(this.devi.date_d);
            var endDate = Date.parse(this.devi.date_limit_d);
            var timeDiff = endDate - startDate;
            var daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
            this.devi.date_diff=daysDiff;

}
},
    
    
computed:{
        // calcul
   TotalDevis(){
            let sum=0;
            let sum_tva=0;
        for (let index = 0; index < this.commandes.length; index++) {
             this.commandes[index].total_ht_cmd  = this.precisionRound( (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd,2);

                //total de prix de tt commandes
            sum =this.precisionRound(  +sum + (+this.commandes[index].prix_ht + +this.commandes[index].majoration_cmd - this.commandes[index].remise_cmd)*this.commandes[index].quantite_cmd,2);
                //montant tva de chaque commande apres remise
            this.tva_montant=this.precisionRound( this.total_prix*(this.devi.remise_total_d/100)*(this.commande.taux_tva/100),2);
                //montant de remise
            let remise=this.precisionRound( this.commandes[index].total_ht_cmd*(this.devi.remise_total_d/100),2);
                //montant apres remise
            let net=this.precisionRound( this.commandes[index].total_ht_cmd - this.commandes[index].total_ht_cmd*(this.devi.remise_total_d/100),2);
                // montant de tva
            let tva=this.precisionRound( net*(this.commandes[index].fk_tva_cmd/100),2);
                // total de montant des tvas
            sum_tva=this.precisionRound(  +sum_tva + +tva,2);
        }
                // total de prix de tt commandes (affectation)
            this.total_prix = this.precisionRound( +sum + +this.commande.total_ht_cmd,2);
            this.devi.total_ht_d= this.total_prix;
                // total de montant tvas (affectation)
            this.tva_total=this.precisionRound( +sum_tva + +this.commande.tva_montant ,2);
            this.devi.tva_montant_d=this.tva_total;
                //remise sur le montant total
            this.remise_T=this.precisionRound( this.total_prix*(this.devi.remise_total_d/100),2);
            this.devi.remise_ht_d=this.remise_T;
                // montant total apres remise
            this.net_HT=this.precisionRound( this.total_prix - this.remise_T,2);
            this.devi.montant_net_d=this.net_HT;
               // montant total final
            this.total_ttc= this.precisionRound(  +this.net_HT + +this.tva_total,2);
            this.devi.montant_ttc_d=this.total_ttc;

            this.devi.montant_reste_d=this.precisionRound(  +this.total_ttc - +this.devi.accompte_d,2);

            var res = this.devi.montant_reste_d.toString().split(".");
           this.devi.total_lettre_d = this.$WrittenNumber(res[0], { lang: 'fr'})
             

            if (typeof res[1] !== 'undefined') {
                if(res[1].toString().split("")[0] == "0"){
                    this.devi.total_lettre_d += ' et zéro '+this.$WrittenNumber(res[1], { lang: 'fr'})
                }
                else 
                this.devi.total_lettre_d += ' et '+this.$WrittenNumber(res[1], { lang: 'fr'})
            }
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
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  }, 
watch:{
    'devi.remise_total_d':{
            handler: function(){
                    this.TotalDevis;

            },
    },
  'devi.accompte_d':{
            handler: function(){
                    this.TotalDevis;

            },
    },
    'commande': {
            handler: function(){
                    this.TotalDevis;

            },
            deep:true
    },

    commandes: {
            handler: function(){
                      this.TotalDevis;
                     

            },
            deep : true
    },
    'echeance':{
            handler: function(){
                    this.echeancee;
                    this.diff;

            }
    },

            'devi.date_d':{
            handler: function(){
                this.echeancee;
                    this.diff;

            }
    },
    'devi.date_limit_d':{
        handler: function(){
                this.echeancee;
                    this.diff;
            console.log("watch")

            }
    },
    
    // call again the method if the route changes
    '$route': 'fetchData', 
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