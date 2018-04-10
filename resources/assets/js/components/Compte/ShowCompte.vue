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
                   
                   <span>nom compte : </span>{{compte.nom_compte}}
                    <hr>
                    <span>responsable : </span>{{compte.responsable}}
                    <hr>
                   <span>type_compte : </span>{{compte.type_compte}} 
                   <hr>
                   <span>compte.categorie : </span>{{compte.categorie}}
                   <hr>
                   <span>raison_social :  </span>{{compte.raison_social}}
                   <hr>
                   <span>reference : </span>{{compte.reference}}
                   <hr>
                    <span>fixe :  </span>{{compte.fixe}}
                   <hr>
                   <span>portable : </span>{{compte.portable}}
                </p>
                
            </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
              
                <p class="card-text">
                   <span>fax : </span>{{compte.fax}}
                   <hr>
                   <span>email: </span>{{compte.email}}
                   <hr>
                   <span>site_web: </span>{{compte.site_web}}  
                   <hr>
                   <span>secteur_activite: </span>{{compte.secteur_activite}}  
                   <hr>
                   <span>taille: </span>{{compte.taille}}  
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
                            3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                            dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </div>
                    </div>
                </div>
   </div>
  
</template>
<script>
    


      export default{ 
        
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
