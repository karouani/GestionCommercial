<template>
  <div>
     <center> <h3>Informations du Devis</h3></center>
     <hr>
        <div class="row">
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
                
                <p class="card-text">
                   
                   <span>Reference : </span>{{devi.reference_d}}
                    <hr>
                    <span>Date : </span>{{devi.date_d}}
                    <hr>
                   <span>Type Operation : </span>{{devi.type_operation}} 
                   <hr>
                   <span>Objet : </span>{{devi.objet_d}}
                   <hr>
                   <span>Date d'émission :  </span>{{devi.date_emission_d}}
                   <hr>
                   <span>Remise Total : </span>{{devi.remise_total_d}}
                   <hr>
                    <span>Majoration :  </span>{{devi.majoration_d}}
                   <hr>
                   <span>Date Limit : </span>{{devi.date_limit_d}}
                </p>
                
            </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
              
                <p class="card-text">
                   <span>Introduction : </span>{{devi.introduction_d}}
                   <hr>
                   <span>Conditions de reglements : </span>{{devi.conditions_reglements_d}}
                   <hr>
                   <span>Notes : </span>{{devi.notes_d}}  
                   <hr>
                   <span>Accompte : </span>{{devi.accompte_d}}  
                   <hr>
                   <span>Status : </span>{{devi.fk_status_d}}  
                   <hr>
                   <span>Compte : </span>{{devi.nom_compte}}  
                </p>
               
            </div>
            </div>
        </div>
        </div>
  
  <hr>
        <div class="text-center">
    <h4>Commandes</h4>
    <hr>
    </div>
  <div>     
        
                     <table class="table table-bordered tableau">
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
                            <th> {{commande.designation}}</th>
                            <th>{{commande.quantite_cmd}}</th>
                            <th>{{commande.remise_cmd}}</th>
                            <th> {{commande.majoration_cmd}}</th>
                            <th>{{commande.prix_ht}}</th>
                            <th>{{commande.taux_tva}} </th> 
                            <th>{{commande.totalHT}} </th> 

                         </tr>              
                        </tbody>


                         </table>
  </div>
   <div class="text-center">
       <hr>
    <h3>Mode Paiement</h3>
    <hr>
    </div>
       
     <div class="row">
         <div class="col-6">
           <div class="card">
            <div class="card-body">
                
                <p class="card-text">
                   
                   <span> Type Paiement : </span>{{modePaiement.type_paiement }}
                    <hr>
                    <span>Reference Paiement : </span>{{modePaiement.reference_paiement}}
                    <hr>
                   <span>Date Paiement : </span>{{modePaiement.date_paiement}} 
                  
                   
              
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
   // devi
              devi: { 
            id_devis:0,
            reference_d:"",
            date_d:"", 
            type_operation:"",
            objet_d:"",
            date_emission_d:"",
            remise_total_d:"",
            majoration_d:"",
            date_limit_d:"",
            introduction_d:"",  
            conditions_reglements_d:"",
            notes_d:"",
            accompte_d:"",
           fk_status_d:"",
           fk_compte_d:"",
            fk_user_d:"",

            designation:"",
            nom_compte:"",
            taux_tva:"",
      
              },
              // tableau des devis 
              devis :[],
              //tables foreign key 
              status:[],
              tvas:[],
              articles:[],
              comptes:[],
            index:0,
            total_prix:0,
            remise_T:0,
              //commandes
           cmd: {},
              commande:{
                  id_cmd:0,
                quantite_cmd:1,
                remise_cmd:0,
                majoration_cmd:0,
                prix_ht:0,
                fk_article:"",
                fk_document:"",
                fk_tva_cmd:"",
               
               //affichage
               
               desig:"",
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
          methods:{

       getDevisD:function(id_devis){
                  axios.get('/getDevisD/'+id_devis).then(
                  response => {
                         //console.log(response.data.articles);

                    this.devi= response.data.devi;

                  });     
        },
        getCommandes:function(id_devis){
                  axios.get('/getCommandes/'+'D'+id_devis).then(
                  response => {
                      // console.log("commandes:  ");
                         //console.log(response.data.commandes);

                    this.commandes= response.data.commandes;
                    // this.commande.fk_article= response.data.articles;

                  });     
        },
        getPaiement:function(id_devis){
                  axios.get('/getPaiement/'+'D'+id_devis).then(
                  response => {
                      // console.log("paiement")
                    this.modePaiement= response.data.modePaiement[0];
                   //console.log(this.modePaiement)
                  });     
        },
          },
           
          mounted(){
              this.devi.id_devis = this.$route.params.id_devis;
              this.getDevisD(this.devi.id_devis);
              this.getCommandes(this.devi.id_devis);
              this.getPaiement(this.devi.id_devis);
          }

      }
</script>
<style scoped>
.card-header{
    background-color: #42a5f5;
}
span{
    color:#4278f5;
}
</style>
