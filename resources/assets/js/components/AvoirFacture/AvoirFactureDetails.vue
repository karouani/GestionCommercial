<template>
<div>
            
    <div class="loading" v-if="loading">
          <div class="lds-hourglass"></div>
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
  <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testEditS">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Status Bien Modifier !</strong>
</div>
     <div class="row">
        <div class="col">
        <a href="#"    @click="redirect_To_AddAvoirFacture(avoirFacture)"  class="btn btn-secondary mb-3  float-right" ><i class="fas fa-exchange-alt"></i> Convertir </a>
        <a href="#"    @click="PdfAvoirFacture(avoirFacture.reference_af)"  class="btn btn-secondary mb-3  float-right" ><i class="far fa-file-pdf"></i> Imprimer</a>

        <router-link class="btn btn-primary mb-3 retour float-right " :to="'/getAvoirFactures'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
        </div>
    </div>
<div class="container colBackround">
          
<div class="row">
    <div class="col">
        <br>
    <h5><i class="far fa-file"></i> Informations du Avoir Facture : <strong>{{avoirFacture.reference_af}}</strong></h5>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label"><strong>Avoir Facture {{avoirFacture.reference_af}} [{{avoirFacture.montant_ttc_af}} DH]</strong> </label>

            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Date : {{avoirFacture.date_af}}</label>
            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Validité : {{avoirFacture.date_limit_af}}  </label>
            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Vendeur : {{avoirFacture.nom_societe}}  </label>
            </div>
          
    </div>
    <div class="col-md-6 col-sm-12">
        
        <div class="container  infoClient">
            <label class="compte" for="">{{avoirFacture.nom_compte}} </label>
            <div class="form-group row">
            <div class="col-sm-10">
            {{avoirFacture.adresse_af}}
            </div>
         </div>
        </div>
        <br>
        <div class="form-group row">
                 <div class="col-sm-4"> 
                <select class="form-control custom-select " id="fk_status_af" v-model="avoirFacture.fk_status_af" @change="getStatu()">
                    <option value="Brouillon" selected disabled>Brouillon</option>
                    <option v-for="statu in status" :key="statu.id_status" :value="statu.id_status">{{statu.type_status}}</option>
                </select>
                 </div>
                 <div class="col-sm-2"> 
                    <a href="#" @click="updateStatusAvoirFacture()"  class="btn btn-secondary badge badge-pill" style="background-color:black" :style="{'background-color': avoirFacture.colorStatu ,'color':fontStatu.white , 'font-size':fontStatu.size}"><i class="fa fa-undo"></i></a>                                
                 </div>
        </div>
    </div>
</div>
<hr>

  <div>     
        
                     <table class="table table-bordered tableau">
                            <thead>
                          <tr class="heade">
                            <th>Article</th>
                            <th>Quantite</th>
                            <th>Remise</th>
                            <th>majoration</th>
                            <th>Prix HT</th>
                            <th>TVA</th>
                            <th>Total HT</th>
                          </tr>                           
                        </thead>
                         <tbody class="boby-table">
                          <tr v-for="(commande,index) in commandes" :key="index" >
                            <th> {{commande.designation}}</th>
                            <th>{{commande.quantite_cmd}}</th>
                            <th>{{commande.remise_cmd}}</th>
                            <th> {{commande.majoration_cmd}}</th>
                            <th>{{commande.prix_ht}}</th>
                            <th>{{commande.taux_tva}} </th> 
                            <th>{{commande.total_ht_cmd}} </th> 

                         </tr>              
                        </tbody>


                         </table>
  </div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="form-group row">
                <label for="inputPassword" class="col-sm-4 col-form-label">Total en lettre</label>
                <div class="col-sm-8 col-form-label ">
                <label>{{avoirFacture.total_lettre_af}}</label>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-4 col-form-label">Date Limit</label>
                <div class="col-sm-8 cam">
                {{avoirFacture.date_limit_af}}
                </div>
            </div>
            <div class="form-group row">
                    <label for="type_paiement" class="col-sm-4 col-form-label" > Type Paiement </label>
                <div class="col-sm-8">
                {{avoirFacture.type_paiement}}
                   
                </div>
            </div>
                <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Reference Paiement </label>
                    <div class="col-sm-8">
                    {{avoirFacture.reference_paiement}}
                    </div>
                </div> 
                 <div class="form-group row">
                    <label for="date_paiement"  class="col-sm-4 col-form-label" >Date Paiement </label>
                    <div class="col-sm-8">
                    
                    {{avoirFacture.date_paiement}} 
                    </div>
                </div>  
                <div class="form-group row">
                    <label for="remise_total_af"  class="col-sm-4 col-form-label" >Remise Total </label>
                    <div class="col-sm-8">
                    {{avoirFacture.remise_total_af}}
                    </div>
                </div>                  
                      

                                 
    </div>
    <div class="col-md-6 col-sm-12">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Total HT </label>
            <div class="col-sm-8 cal">
            {{avoirFacture.total_ht_af}}
            </div>
         </div>
   
       
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Remise Total (montant) </label>
            <div class="col-sm-8 cal">
            {{avoirFacture.remise_ht_af}}
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label"> Montant Net HT  </label>
            <div class="col-sm-8 cal">
            {{avoirFacture.montant_net_af}}
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">TVA (Montant) </label>
            <div class="col-sm-8 cal">
            {{avoirFacture.tva_montant_af}}
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Montant TTC (Montant) </label>
            <div class="col-sm-8 cal">
            {{avoirFacture.montant_ttc_af}}
            </div>
         </div>
         <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Acompte </label>
            <div class="col-sm-8 cal">
            {{avoirFacture.accompte_af}}
            </div>
         </div>
         <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label" style="padding-right: 0px;">Net à payer (Montant) </label>
            <div class="col-sm-8 cal" >
            {{avoirFacture.montant_reste_af}}
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
            <label>{{avoirFacture.notes_af}}</label>
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
            <label>{{avoirFacture.conditions_reglements_af}}</label>
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
              fontStatu : {
                    white : "white",
                    size: "14px",
              },
                    loading: false,
                    error: null,
                     Testopen:{
                testEditS : false,
              },
   // avoirFacture
        avoirFacture: { 
            id_af:0,
            reference_af:"",
            date_af:"", 
            adresse_af:"",
            type_operation_af:"",
            objet_af:"",
            date_emission_af:"",
            remise_total_af:"",
            majoration_af:"",
            date_limit_af:"",
            introduction_af:"",  
            conditions_reglements_af:"",
            notes_af:"",
            accompte_af:"",
           fk_status_af:"",
           fk_compte_af:"",
            fk_user_af:"",

            designation:"",
            nom_compte:"",
            taux_tva:"",

            total_ht_af:0,
            remise_ht_af:0,
            montant_net_af:0,
            tva_montant_af:0,
            montant_ttc_af:0,
            total_lettre_af:"",
            montant_reste_af:0,
            
            nom_societe:"",
            },

            statu :{
              type_status:"",
              colorStatu:"",
            },

              // tableau des avoirFactures 
              avoirFactures :[],
              //tables foreign key 
              status:[],
              tvas:[],
              articles:[],
              comptes:[],
              index:0,
              total_prix:0,
              remise_T:0,
              
              
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
               
               //affichage
               
                desig:"",
                total_ht_cmd:0,
                taux_tva:0,
            },
            
            commandes:[],
    }),
          methods:{
updateStatusAvoirFacture(){
                axios.post('/updateStatusAvoirFacture',this.avoirFacture)
                .then(response => {
                        console.log("updateStatusAvoirFacture")

                    if(response.data.etat){
                        this.$router.push('/AvoirFactureDetails/editS/'+this.avoirFacture.id_af);
                         if(this.$route.params.success == "editS"){
                            console.log("methode");
                            this.Testopen.testEditS =true; 
                            }
                    }
                })
                .catch(error => {
                })
    },
     PdfAvoirFacture(reference_af){
                           
                //   window.location.href='/pdf/'+reference_bc
                  window.open('/pdf_af/'+reference_af,'_blank');
          },
                        fetchData () {
      //this.error = this.post = null
      this.loading = true
      console.log("loading+++++++++++++++++++++")
      // replace `getPost` with your data fetching util / API wrapper
             this.avoirFacture.id_af = this.$route.params.id_af;
             this.avoirFacture.reference_af=this.$route.params.reference_af;
              this.getAvoirFactureAF(this.avoirFacture.id_af);
              
              this.getStatus();
              this.getCommandes(this.avoirFacture.reference_af);
   //this.getFactureF(this.$route.params.id_af);

    },
       getAvoirFactureAF:function(id_af){
                  axios.get('/getAvoirFactureAF/'+id_af).then(
                  response => {
                         //console.log(response.data.facture.fk_compte_af);
                    //this.loading = false;

                    this.avoirFacture= response.data.avoirFacture[0];
                    this.avoirFacture.colorStatu=response.data.avoirFacture[0].colorStatu;
                    console.log("color avoirFacture +++++++"+this.avoirFacture.colorStatu);
console.log(this.avoirFacture);
                  });     
        },
        getCommandes:function(reference_af){
                  axios.get('/getCommandes/'+reference_af).then(
                  response => {
                      console.log("commandes:  ");
                         console.log(response.data.commandes);

                    this.commandes= response.data.commandes;
                    this.loading = false;
                    // this.commande.fk_article= response.data.articles;

                  });     
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
    getStatu(){
        axios.get('/getStatu/'+this.avoirFacture.fk_status_af)
            .then((response) => {

                    this.statu = response.data.statu;
                    console.log("avoirFacture"+this.avoirFacture.fk_status_af)
                    console.log("color   "+response.data.statu.colorStatu)

                     this.avoirFacture.colorStatu=response.data.statu.colorStatu;

                 // this.avoirFacture.fk_status_af=response.data.statu.adresse_compte;
            })
            .catch(() => {
                    console.log('handle server error from here');
        });
    },
       redirect_To_AddAvoirFacture(avoirFacture){
                   //  this.$router.push('/ShowBonCommande/'+reference_bc);
                     this.$router.push({ name: 'addBonCommande', params: {id_af: avoirFacture.id_af, reference_af: avoirFacture.reference_af}});

            }, 
    },
                created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },  
 
          mounted(){
                          
       
            },
              updated(){
        if( this.$route.params.success == "editS"){
          let that = this
                            console.log("updated");
              setTimeout(function(){that.Testopen.testEditS = false;}, 2000);
        }
              },
           watch: {
    // call again the method if the route changes
    '$route': 'fetchData',
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
.top{
        margin-left: 100px;
    margin-bottom: 0rem;
}
.compte{
        color: blue;
    font-size: large;
}


.table {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

.table td, .table th {
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

.form-group{
    margin-bottom: 0rem;
}
.cal{
padding-right: 0px;
padding-left: 120px;
}

.retour {
    border-left-color:#0000009e;
    border-left-width: 3px;
}
.convert{
    background-color: #3f51b5;
}
.show{
     opacity:0.9;
    width: 233px;
    z-index: 100;
    top: 61px;
    right: 0;
    position:  absolute;
    position :fixed;}


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
