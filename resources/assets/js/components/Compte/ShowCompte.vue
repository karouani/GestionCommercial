<template>
  <div>


    <div class="loading" v-if="loading">
     <div class="lds-hourglass"></div>
    </div>
    

<div v-if="!loading">
    <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3 retour float-right " :to="'/ShowComptes'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
    </div>   
     <div class=" container colBackround">


<div class="row">
    <div class="col">
        <br>
    <h5><i class="fas fa-address-book"></i> Compte de {{compte.nom_compte}} </h5>
    </div>
</div>
<hr>
    
        <div class="row">
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
                
                <p class="card-text">
                   
                   <span>Nom compte : </span>{{compte.nom_compte}}
                    <hr>
                    <span>Résponsable : </span>{{compte.responsable}}
                    <hr>
                    <span>Type Compte : </span> <span class="badge badge-pill" style="background-color:#42d202;color:white;font-size:14px"> <b>{{compte.type_compte}}  </b></span> 
                   <hr>
                   <span>Catégorie : </span>{{compte.categorie}}
                   <hr>
                   <span>Raison Social :  </span>{{compte.raison_social}}
                   <hr>
                   <span>Référence : </span>{{compte.reference}}
                   <hr>
                    <span>Fixe :  </span>{{compte.fixe}}
                   <hr>
                   <span>Portable : </span>{{compte.portable}}
                </p>
                
            </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
              
                <p class="card-text">
                   <span>Fax : </span>{{compte.fax}}
                   <hr>
                   <span>Email: </span>{{compte.email}}
                   <hr>
                   <span>Site Web: </span>{{compte.site_web}}  
                   <hr>
                   <span>Secteur Activité: </span>{{compte.secteur_activite}}  
                   <hr>
                   <span>Taille: </span>{{compte.taille}}  
                   <hr>
                   <span>RC: </span>{{compte.RC}}  

                </p>
               
            </div>
            </div>
        </div>
        </div>
    
   
  </div>
   <br>
   <div class="col colBackround2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-expanded="true"><i class="icon-calculator"></i> Contacts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-expanded="false"><i class="far fa-file"></i> Conditions Facture</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#messages3" role="tab" aria-controls="messages"><i class="fas fa-shopping-cart"></i> Vente</a>
                        </li>
                    </ul>

                    <div class="tab-content">
     <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                                <div class="row">
                                    <div class="col-auto" v-for="(contact,index) in contacts" :key="index" >
                                    <div class="card" style="width: 18rem;">
                    <div class="card-header">
                    {{contact.prenom}} {{contact.nom}}
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Civilité : {{contact.civilite}}</li>
                        <li class="list-group-item">Fonction : {{contact.fonction}}</li>
                        <li class="list-group-item">Email: {{contact.email}} </li>
                        <li class="list-group-item">Fixe: {{contact.fixe}} </li>
                        <li class="list-group-item">GSM: {{contact.mobile}} </li>
                    </ul>
                    </div>
                    </div>
                            </div>
                        </div>
   <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                        <div class="row">
                                <div class="col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <p class="card-text">
                                        
                                        <span>Devise : </span>{{condition_facture.devise }}
                                            <hr>
                                            <span>Demise : </span>{{condition_facture.remise}}
                                            <hr>
                                        <span>Delai Paiement : </span>{{condition_facture.delai_paiement}} 
                                        <hr>
                                        <span>Remarques : </span>{{condition_facture.remarques}}
                                        <hr>
                                    
                                        </p>
                                        
                                    </div>
                                    </div>             
                                    </div>
                            </div>
                        </div>

    <div class="tab-pane" id="messages3" role="tabpanel">
     <div class="colBackround3">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#devis" role="tab" aria-controls="home" aria-expanded="true"><i class="far fa-file"></i> Devis <span class="badge badge-light"><span class="badgeSize">{{CountD}}</span></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#bonCommande" role="tab" aria-controls="profile" aria-expanded="false"><i class="far fa-file"></i> Bon Commande <span class="badge badge-light"><span class="badgeSize">{{CountBc}}</span></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#bonLivraison" role="tab" aria-controls="profile" aria-expanded="false"><i class="far fa-file"></i> Bon de Livraison <span class="badge badge-light"><span class="badgeSize">{{CountBL}}</span></span></a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#facture" role="tab" aria-controls="profile" aria-expanded="false"><i class="far fa-file"></i> Factures <span class="badge badge-light"><span class="badgeSize">{{CountF}}</span></span></a>
                        </li>
                    </ul>
    </div>
    <div class="tab-content">  
                  <div class="tab-pane" id="devis" role="tabpanel" aria-expanded="false">

                    <app-Devis :idCompte="compte.id_compte" @CountD="getCountD($event)" ></app-Devis>

                    </div>
                    <div class="tab-pane" id="bonCommande" role="tabpanel" aria-expanded="false">
                          
                           <app-BCcompte :idCompte="compte.id_compte" @CountBC="getCountBc($event)"></app-BCcompte>
                    </div>
                    <div class="tab-pane" id="bonLivraison" role="tabpanel" aria-expanded="false">
                          
                           <app-BLcompte :idCompte="compte.id_compte" @CountBL="getCountBL($event)" ></app-BLcompte>
                    </div>
                    <div class="tab-pane" id="facture" role="tabpanel" aria-expanded="false">
                          
                           <app-Facture :idCompte="compte.id_compte" @CountF="getCountF($event)" ></app-Facture>
                    </div>                    
    </div>
     </div>
     </div>
    </div>
   </div>
  </div>
</template>
<script>
    
import  BCcompte from './BonCommandesCompte.vue';
import  Deviscompte from './DevisCompte.vue';
import  BonLivraisons from './BonLivraisonsCompte.vue';
import  FactureComptes from './FacturesCompte.vue';


      export default{ 
         components:{
            'app-BCcompte':BCcompte,
            'app-Devis':Deviscompte,
            'app-BLcompte':BonLivraisons,
            'app-Facture':FactureComptes
         },
          data: () => ({
               loading: false,
              CountBc : 0,
              CountD:0,
              CountBL:0,
              CountF:0,
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
  
          methods:{
 fetchData () {
                             this.compte.id_compte = this.$route.params.id_compte;

               this.getCompte(this.compte.id_compte);
              this.getCondtionFacture(this.compte.id_compte);
               this.getContacts(this.compte.id_compte);
              console.log('--------- id compte ');
              console.log(this.compte.id_compte);
 },
       getCompte:function(id_compte){
                  axios.get('/getCompte/'+id_compte).then(
                  response => {
                       
                    this.compte= response.data.compte;
                   
                  });     
        },
        getContacts:function(id_compte){
                  axios.get('/getContacts/'+id_compte).then(
                  response => {
                       
                    this.contacts= response.data.contacts;
                    this.loading = false;
             
                  });     
        },
        getCondtionFacture:function(id_compte){
                  axios.get('/getCFacture/'+id_compte).then(
                  response => {
                       console.log("Cfacture")
                    this.condition_facture= response.data.condition_facture[0];
                    
                    console.log('---- condition facture ---- ')
                    console.log(id_compte);
                   console.log(response)
                  });     
        },
        getCountBc(CountBc){
            this.CountBc = CountBc;
            console.log('-------- count bc22222 ------- ok ----')
            console.log(CountBc)
        },
        getCountD(CountD){
            this.CountD = CountD;
            console.log('-------- count D ------- ok ----')
            console.log(CountD)
        },
        getCountBL(CountBL){
            this.CountBL = CountBL;
            console.log('-------- count BLLLL ------- ok ----')
            console.log(CountD)
        },
        getCountF(CountF){
            this.CountF = CountF;
            console.log('-------- count BLLLL ------- ok ----')
            console.log(CountF)
        },
          },

          created(){
              this.fetchData()
          },

      }
</script>
<style scoped>
.card-header{
    background-color: #cac8c8;
}
span{
    color:#007ee4;
}
/*.fontsize{

    font-size: 1.30rem;
}*/
a {
  color: #999;
  color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    
}
.colBackround{
    background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
}


.colBackround2{
    background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
    padding-left:  0px;
    margin-left:  0px;
    padding-right: 0px;
}
.colBackround3{
    background-color: #d8edff;
    padding-left:  0px;
    margin-left:  0px;
    padding-right: 0px;
}
.badgeSize{
    font-size: 14px;
}
.retour {
    border-left-color:#0000009e;
    border-left-width: 3px;
}
</style>
