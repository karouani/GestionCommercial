
<template>
<div>
    <div class="row">
        <div class="col">
     <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowBonCommandes'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
    </div>
    </div>
<div class=" container colBackround">


<div class="row">
    <div class="col">
        <br>
    <h5><i class="far fa-file"></i> Information sur le bon de commande</h5>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="row">
                    <label for="inputPassword" class="col-sm-2">compte </label>
                    <div class="col-sm-10">         
                    <label>{{bonCommande.nom_compte}}</label>
                </div>
            </div> 

            <div class="row">
                <label for="inputPassword" class="col-sm-2">Devis</label>
                <div class="col-sm-10">
                <label>{{bonCommande.reference_bc}} [ {{bonCommande.montant_ttc_bc}} DH ]</label>
                </div>
            </div>
                 <div class="row">
                    <label for="inputPassword" class="col-sm-2">Date </label>
                    <div class="col-sm-10">
                     <label>{{bonCommande.date_bc}}</label>
                    </div>
                </div> 
                <div class="row">
                <label for="inputPassword" class="col-sm-2">Objet  </label>
                <div class="col-sm-10">
                 <label>{{bonCommande.objet_bc}}</label>

                </div>
            </div>
          
    </div>
    <div class="col-md-6 col-sm-12">
        
        <div class="container  infoClient">
            <label for="">{{bonCommande.nom_compte}} </label>
            <div class="form-group row">
            <div class="col-sm-10 col-form-label">
            <label>{{bonCommande.adresse_bc}}</label>

            </div>
         </div>
        </div>
               <div class="form-group row">
                 <div class="col-sm-4"> 
                <select class="form-control custom-select " id="fk_status_d"  v-model="bonCommande.fk_status_bc" >
                    <option value="Brouillon">Brouillon</option>
                    <option v-for="statu in status" :key="statu.id_status" :value="statu.id_status">{{statu.type_status}}</option>
                </select>
                 </div>
                 <div class="col-sm-2"> 
                <a href="#" @click="updateStatusBC()"  class="btn btn-info" style="font-size:10px"><i class="fa fa-undo"></i></a>                                
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
                            <th>  
                            <label>{{commande.designation}}</label>
                            </th>   
                            <th>  <label>{{commande.quantite_cmd}}</label></th>
                            <th>  <label>{{commande.remise_cmd}}</label></th> 
                            <th>  <label>{{commande.majoration_cmd}}</label></th> 
                            <th> <label>{{commande.prix_ht}}</label></th> 
                                             <th>  
                            <label>{{commande.taux_tva}}</label>
                            
                            </th> 
                            <th>  
                           <label>{{commande.total_ht_cmd}}</label>
                            </th>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
             </div>
     </div>
    
    
    
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-4 col-form-label">Date Limit</label>
                <div class="col-sm-8 col-form-label ">
                <label>{{bonCommande.date_limit_bc}}</label>
                </div>
            </div>
            <div class="form-group row">
                    <label for="type_paiement" class="col-sm-4 col-form-label" > Type Paiement </label>
                <div class="col-sm-8 col-form-label">
                <label>{{bonCommande.type_paiement}}</label>
                </div>
            </div>
                <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Reference Paiement </label>
                    <div class="col-sm-8 col-form-label">
                    <label>{{bonCommande.reference_paiement}}</label>
                    </div>
                </div> 
                 <div class="form-group row">
                    <label for="date_paiement"  class="col-sm-4 col-form-label" >Date Paiement </label>
                    <div class="col-sm-8 col-form-label">
                    <label>{{bonCommande.date_paiement}}</label>
                    </div>
                </div>  
                <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Remise Total </label>
                    <div class="col-sm-8 col-form-label">
                    <label>{{bonCommande.remise_total_bc}}</label>
                    </div>
                </div>                  
                      

                                 
    </div>
    <div class="col-md-6 col-sm-12">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Total HT </label>
            <div class="col-sm-8 col-form-label">
            <label>{{bonCommande.total_ht_bc}}</label>
            </div>
         </div>
   
       
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Remise Total (montant) </label>
            <div class="col-sm-8 col-form-label">
            <label>{{bonCommande.remise_total_bc}}</label>
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label"> Montant Net HT  </label>
            <div class="col-sm-8 col-form-label">
                <label>{{bonCommande.montant_net_bc}}</label>
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">TVA (Montant) </label>
            <div class="col-sm-8 col-form-label">
                <label>{{bonCommande.tva_montant_bc}}</label>
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Montant TTC (Montant) </label>
            <div class="col-sm-8 col-form-label">
                <label>{{bonCommande.montant_ttc_bc}}</label>
            </div>
         </div>
   
 </div>

        
</div>
<br>
<div class="row">
  <div class="col">
                <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Notes </label>
            <div class="col-sm-10 col-form-label">
            <label>{{bonCommande.notes_bc}}</label>
            </div>
         </div>
  </div>
</div>
<br>
<div class="row">
   <div class="col">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Conditions </label>
            <div class="col-sm-10 col-form-label">
            <label>{{bonCommande.conditions_reglements_bc}}</label>
            </div>
         </div>
   </div>
</div>
<hr>


   
</div>
</div>
</template>

<script>

   
    export default{ 
        
          data: () => ({
              bonCommandes : [],
            bonCommande : {},
                commandes : [],
                status : []

               
      }),
      

methods: { 
    updateStatusBC(){
                axios.post('/updateStatusBC',this.bonCommande)
                .then(response => {
                        console.log("updateStatusDevis")

                    if(response.data.etat){
                        this.$router.push({ name: 'ShowBonCommandes', params: { success: "editsuccess"  }});
                    }
                })
                .catch(error => {
                })
    },

         getStatus(){
        axios.get('/getStatus')
        .then((response) => {
                this.status= response.data.status;
               
        })
        .catch(() => {
                console.log('handle server error from here');
        });
    },
    getStatu(devi){
                
        axios.get('/getStatu/'+devi.fk_status_d)
            .then((response) => {
                    this.statu = response.data.statu;
                 // this.devi.fk_status_d=response.data.statu.adresse_compte;
            })
            .catch(() => {
                    console.log('handle server error from here');
        });
    },

        showBonCommande(reference_bc){

            axios.get('/showBonCommande/'+reference_bc)
                                .then((response) => {
                                   
                                    this.bonCommande = response.data.bonCommande[0];
                                    console.log("recup Bon Commande")
                                    console.log(this.bonCommande)
                                })
                                .catch(() => {
                                        console.log('handle server error from here');
                                });
        },

        getCommandes(reference_bc){

         axios.get('/getCommandes_bc/'+reference_bc)
                        .then((response) => {
                            console.log("recup commandessss ")
                            console.log(response.data)
                               this.commandes = response.data.commandes;
                            
                                
                                
                        })
                        .catch(() => {
                                console.log('handle server error from here');
                        });

        },








   


    
    

            
},

    mounted(){

            this.getCommandes(this.$route.params.reference_bc);
            this.showBonCommande(this.$route.params.reference_bc);
            this.getStatus();
         
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
</style>


 