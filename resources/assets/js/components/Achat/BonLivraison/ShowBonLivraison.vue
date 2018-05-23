
<template>
<div>

      <div class="loading" v-if="loading">
          <div class="lds-hourglass"></div>

    </div>
    <div v-if="!loading" >
    <div class="row">
        <div class="col">
            <a href="#"    @click="redirect_To_AddFacture(bonLivraison)"  class="btn btn-secondary mb-3  float-right" ><i class="fas fa-exchange-alt"></i> Convertir </a>
           <a href="#"    @click="PdfBonLivraison(bonLivraison.reference_bl)"  class="btn btn-secondary mb-3  float-right" ><i class="far fa-file-pdf"></i></a>

     <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowBonLivraisonsA'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
      

    </div>
    </div>
<div class=" container colBackround">


<div class="row">
    <div class="col">
        <br>
    <h5><i class="far fa-file"></i> Information sur le bon de livraison</h5>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">

          <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label"><strong>Bon Livraison {{bonLivraison.reference_bl}} [{{bonLivraison.montant_ttc_bl}} DH]</strong> </label>

            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Date : {{bonLivraison.date_bl}}</label>
            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Validité : {{bonLivraison.date_limit_bl}}  </label>
            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Vendeur : {{bonLivraison.nom_compte}}  </label>
            </div>

        
            
            </div>
          
    
    <div class="col-md-6 col-sm-12">
        
        <div class="container  infoClient">
            <label for="">{{bonLivraison.nom_compte}} </label>
            <div class="form-group row">
            <div class="col-sm-10 col-form-label">
            <label>{{bonLivraison.adresse_bl}}</label>

            </div>
         </div>
        </div>
               <div class="form-group row">
                 <div class="col-sm-4"> 
                <select class="form-control custom-select " id="fk_status_d"  v-model="bonLivraison.fk_status_bl" >
                    <option value="Brouillon">Brouillon</option>
                    <option v-for="statu in status" :key="statu.id_status" :value="statu.id_status">{{statu.type_status}}</option>
                </select>
                 </div>
                 <div class="col-sm-2"> 
                <a href="#" @click="updateStatusBL()"  class="btn btn-info refresh" style="font-size:10px"><i class="fa fa-undo"></i></a>                                
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
                                    <tr class="trHead">
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
                <label for="inputPassword" class="col-sm-4 col-form-label">Total en lettre</label>
                <div class="col-sm-8 col-form-label ">
                <label>{{bonLivraison.total_lettre}}</label>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-4 col-form-label">Date Limit</label>
                <div class="col-sm-8 col-form-label ">
                <label>{{bonLivraison.date_limit_bl}}</label>
                </div>
            </div>
            <div class="form-group row">
                    <label for="type_paiement" class="col-sm-4 col-form-label" > Type Paiement </label>
                <div class="col-sm-8 col-form-label">
                <label>{{bonLivraison.type_paiement}}</label>
                </div>
            </div>
                <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Reference Paiement </label>
                    <div class="col-sm-8 col-form-label">
                    <label>{{bonLivraison.reference_paiement}}</label>
                    </div>
                </div> 
                 <div class="form-group row">
                    <label for="date_paiement"  class="col-sm-4 col-form-label" >Date Paiement </label>
                    <div class="col-sm-8 col-form-label">
                    <label>{{bonLivraison.date_paiement}}</label>
                    </div>
                </div>  
                <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Remise Total </label>
                    <div class="col-sm-8 col-form-label">
                    <label>{{bonLivraison.remise_total_bl}}</label>
                    </div>
                </div>                  
                      

                                 
    </div>
    <div class="col-md-6 col-sm-12">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Total HT </label>
            <div class="col-sm-8 col-form-label">
            <label>{{bonLivraison.total_ht_bl}}</label>
            </div>
         </div>
   
       
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Remise Total (montant) </label>
            <div class="col-sm-8 col-form-label">
            <label>{{bonLivraison.remise_total_bl}}</label>
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label"> Montant Net HT  </label>
            <div class="col-sm-8 col-form-label">
                <label>{{bonLivraison.montant_net_bl}}</label>
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">TVA (Montant) </label>
            <div class="col-sm-8 col-form-label">
                <label>{{bonLivraison.tva_montant_bl}}</label>
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Montant TTC (Montant) </label>
            <div class="col-sm-8 col-form-label">
                <label>{{bonLivraison.montant_ttc_bl}}</label>
            </div>
         </div>
         <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Acompte </label>
            <div class="col-sm-8 col-form-label">
                <label>{{bonLivraison.accompte_bl}}</label>
            </div>
         </div>
         <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Montant Reste (Montant) </label>
            <div class="col-sm-8 col-form-label">
                <label>{{bonLivraison.montant_reste_bl}}</label>
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
            <label>{{bonLivraison.notes_bl}}</label>
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
            <label>{{bonLivraison.conditions_reglements_bl}}</label>
            </div>
         </div>
   </div>
</div>
<hr>


   </div>
</div>
</div>
</template>

<script>

   
    export default{ 
        
          data: () => ({
              loading: false,
              bonLivraisons : [],
            bonLivraison : {


                id_compte:0,
            },
                commandes : [],
                status : []

               
      }),
                     created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
     

methods: {
     

          PdfBonLivraison(reference_bl){
                           
                //   window.location.href='/pdf/'+reference_bl
                  window.open('/pdf/'+reference_bl,'_blank');
          },
    fetchData () { 
        this.loading = true
        this.getStatus();
            this.showBonLivraison(this.$route.params.reference_bl);
             this.getCommandes(this.$route.params.reference_bl);
    },

    
    updateStatusBL(){
                axios.post('/updateStatusBL',this.bonLivraison)
                .then(response => {
                        console.log("updateStatusDevis")

                    if(response.data.etat){
                        this.$router.push({ name: 'ShowBonLivraisonsA', params: { success: "editsuccess"  }});
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

        showBonLivraison(reference_bl){

            axios.get('/showBonLivraison/'+reference_bl)
                                .then((response) => {
                                   
                                    this.bonLivraison = response.data.bonLivraison[0];
                                    console.log("recup Bon Livraison")
                                    console.log(this.bonLivraison.id_compte)
                                })
                                .catch(() => {
                                        console.log('handle server error from here');
                                });
        },
 redirect_To_AddFacture(bonLivraison){
           console.log("=======================================redirect id compte"+this.bonLivraison.id_compte)
                   //  this.$router.push('/ShowBonCommande/'+reference_bc);
                     this.$router.push({ name: 'addFactureA', params: {bonLivraison: this.bonLivraison}});
},
        getCommandes(reference_bl){

         axios.get('/getCommandes_bl/'+reference_bl)
                        .then((response) => {
                            console.log("recup commandessss ")
                            console.log(response.data)
                               this.commandes = response.data.commandes;
                            
                                this.loading= false;
                                
                        })
                        .catch(() => {
                                console.log('handle server error from here');
                        });

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

.top{
        margin-left: 100px;
    margin-bottom: 0rem;
}

.table {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

.trHead{

    background-color: #d8e9f5;

}
.table td {
    border: 0px solid #ddd;
    padding: 8px;
}

.table tr:nth-child(even){background-color: rgb(236, 236, 236);}


.heade {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    color: #898585;
    background-color: #d8e9f6;
}

.refresh{
background-color: #eaeacd 
}
</style>


 