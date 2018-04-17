<template>
  <div>
    <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowComptes'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
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
                    <span>Responsable : </span>{{compte.responsable}}
                    <hr>
                    <span>Type compte : </span> <span class="badge badge-pill" style="background-color:#42d202;color:white;font-size:14px"> <b>{{compte.type_compte}}  </b></span> 
                   <hr>
                   <span>Categorie : </span>{{compte.categorie}}
                   <hr>
                   <span>Raison social :  </span>{{compte.raison_social}}
                   <hr>
                   <span>Reference : </span>{{compte.reference}}
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
                   <span>Site_web: </span>{{compte.site_web}}  
                   <hr>
                   <span>Secteur_activite: </span>{{compte.secteur_activite}}  
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
                            <a class="nav-link" data-toggle="tab" href="#messages3" role="tab" aria-controls="messages"><i class="icon-pie-chart"></i> Vente</a>
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
                        <li class="list-group-item">Civilite : {{contact.civilite}}</li>
                        <li class="list-group-item">fonction : {{contact.fonction}}</li>
                        <li class="list-group-item">email: {{contact.email}} </li>
                        <li class="list-group-item">fixe: {{contact.fixe}} </li>
                        <li class="list-group-item">mobile: {{contact.mobile}} </li>
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
                                        
                                        <span>devise : </span>{{condition_facture.devise }}
                                            <hr>
                                            <span>remise : </span>{{condition_facture.remise}}
                                            <hr>
                                        <span>delai_paiement : </span>{{condition_facture.delai_paiement}} 
                                        <hr>
                                        <span>remarques : </span>{{condition_facture.remarques}}
                                        <hr>
                                    
                                        </p>
                                        
                                    </div>
                                    </div>             
                                    </div>
                            </div>
                        </div>

    <div class="tab-pane" id="messages3" role="tabpanel">
     <div class="colBackround2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#devis" role="tab" aria-controls="home" aria-expanded="true"><i class="icon-calculator"></i> Devis</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#bonCommande" role="tab" aria-controls="profile" aria-expanded="false"><i class="far fa-file"></i> Bon Commande</a>
                        </li>
                    </ul>
    </div>
    <div class="tab-content">
                  <div class="tab-pane" id="devis" role="tabpanel" aria-expanded="false">
                        <div class="row">
                            <table border="1">
                                <tr><td>devis</td></tr>
                            </table>
                        </div>

                    </div>
                    <div class="tab-pane" id="bonCommande" role="tabpanel" aria-expanded="false">
                        <div class="row">
                           <app-BCcompte></app-BCcompte>
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


      export default{ 
         components:{
            'app-BCcompte':BCcompte,
         },
          data: () => ({

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
          },
          mounted(){
              this.compte.id_compte = this.$route.params.id_compte;
              this.getCompte(this.compte.id_compte);
              this.getContacts(this.compte.id_compte);
              this.getCondtionFacture(this.compte.id_compte);
          }

      }
</script>
<style scoped>
.card-header{
    background-color: #cac8c8;
}
span{
    color:#007ee4;
}
.fontsize{

    font-size: 1.30rem;
}
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
</style>
