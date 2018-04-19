<template>
  <div>


    <div class="loading" v-if="loading">
     <div class="lds-hourglass"></div>
    </div>
    

<div v-if="!loading">
    <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowComptes'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
    </div>   
     <div class=" container colBackround">


<div class="row">
    <div class="col">
        <br>
    <h5><i class="fas fa-address-book"></i> compagnie de {{compagnie.nom_compagnie}} </h5>
    </div>
</div>
<hr>
    
        <div class="row">
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
                
                <p class="card-text">
                   
                   <span>Nom compagnie : </span>{{compagnie.nom_compagnie}}
                    <hr>
                    <span>Responsable : </span>{{compagnie.responsable}}
                    <hr>
                    <span>Type compagnie : </span> <span class="badge badge-pill" style="background-color:#42d202;color:white;font-size:14px"> <b>{{compagnie.type_compagnie}}  </b></span> 
                   <hr>
                   <span>Categorie : </span>{{compagnie.categorie}}
                   <hr>
                   <span>Raison social :  </span>{{compagnie.raison_social}}
                   <hr>
                   <span>Reference : </span>{{compagnie.reference}}
                   <hr>
                    <span>Fixe :  </span>{{compagnie.fixe}}
                   <hr>
                   <span>Portable : </span>{{compagnie.portable}}
                </p>
                
            </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
              
                <p class="card-text">
                   <span>Fax : </span>{{compagnie.fax}}
                   <hr>
                   <span>Email: </span>{{compagnie.email}}
                   <hr>
                   <span>Site_web: </span>{{compagnie.site_web}}  
                   <hr>
                   <span>Secteur_activite: </span>{{compagnie.secteur_activite}}  
                   <hr>
                   <span>Taille: </span>{{compagnie.taille}}  
                   <hr>
                   <span>RC: </span>{{compagnie.RC}}  

                </p>
               
            </div>
            </div>
        </div>
        </div>
        
    
   
  </div>
   <br>
  
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
               loading: false,
              CountBc : 0,

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
            console.log('-------- count bc ------- ok ----')
            console.log(CountBc)
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
.colBackround3{
    background-color: #d8edff;
    padding-left:  0px;
    margin-left:  0px;
    padding-right: 0px;
}
.badgeSize{
    font-size: 14px;
}
</style>
