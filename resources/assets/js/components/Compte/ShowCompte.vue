<template>
  <div>
     <center> <h3>Informations du Compte</h3></center>
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
                   <hr>
                   <span>fk_compagnie: </span>{{compte.fk_compagnie}}  
                </p>
               
            </div>
            </div>
        </div>
        </div>
    <hr>
    <h3>Contacts</h3>
    <hr>
    
     
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
            <hr>
    <h3>Conditions Facture</h3>
     <hr>
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
</style>
