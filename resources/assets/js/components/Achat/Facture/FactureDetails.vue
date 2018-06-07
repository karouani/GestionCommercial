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
        <a href="#"  v-if="profile.role !='Expert Comptable'"  @click="redirect_To_AddFactureAvoir(facture)"  class="btn btn-secondary mb-3  float-right" ><i class="fas fa-exchange-alt"></i> Convertir </a>
        <a href="#"    @click="PdfFacture(facture.reference_f)"  class="btn btn-secondary mb-3  float-right" ><i class="far fa-file-pdf"></i> Imprimer</a>

        <router-link v-if="profile.role !='Expert Comptable'" class="btn btn-primary mb-3 retour float-right " :to="'/getFacturesA'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
        <router-link v-if="profile.role =='Expert Comptable'" class="btn btn-primary mb-3 retour float-right " :to="'/FactureComptableA'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
        </div>
    </div>
<div class="container colBackround">
          
<div class="row">
    <div class="col">
        <br>
    <h5><i class="far fa-file"></i> Informations sur la Facture : <strong>{{facture.reference_f}}</strong></h5>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label"><strong>Facture {{facture.reference_f}} [{{facture.montant_ttc_f}} DH]</strong> </label>

            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Date : {{facture.date_f}}</label>
            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Validité : {{facture.date_limit_f}}  </label>
            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Acheteur : {{facture.nom_societe_comp}}  </label>
            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Vendeur : {{facture.nom_compte}}  </label>
            </div>
          
    </div>
    <div class="col-md-6 col-sm-12">
        
        <div class="container  infoClient">
            <label class="" for=""><b>{{facture.nom_societe_comp}} </b></label>
            <div class="form-group row">
            <div class="col-sm-10">
            {{facture.adresse_f}}
            </div>
         </div>
        </div>
        <br>
        <div class="form-group row" v-if="profile.role !='Expert Comptable'">
                 <div class="col-sm-4"> 
                <select class="form-control custom-select " id="fk_status_f" v-model="facture.fk_status_f" @change="getStatu()">
                    <option value="Brouillon" selected disabled>Brouillon</option>
                    <option v-for="statu in status" :key="statu.id_status" :value="statu.id_status">{{statu.type_status}}</option>
                </select>
                 </div>
                 <div class="col-sm-2"> 
                    <a href="#" @click="updateStatusFacture()"  class="btn btn-secondary badge badge-pill" style="background-color:black" :style="{'background-color': facture.colorStatu ,'color':fontStatu.white , 'font-size':fontStatu.size}"><i class="fa fa-undo"></i></a>                                
                 </div>
        </div>
    </div>
</div>
<hr>

  <div>     
        
                     <table class="table table-bordered">
                            <thead>
                          <tr class="trHead">
                            <th>Article</th>
                            <th>Quantite</th>
                            <th>Remise</th>
                           
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
        <div class="form-group2 row">
                <label for="inputPassword" class="col-sm-4 col-form-label">Total en lettre</label>
                <div class="col-sm-8 col-form-label ">
                <label>{{facture.total_lettre_f}}</label>
                </div>
            </div>
            <div class="form-group2 row">
                <label for="inputPassword" class="col-sm-4 col-form-label">Date Limit</label>
                <div class="col-sm-8 col-form-label">
                {{facture.date_limit_f}}
                </div>
            </div>
            <div class="form-group2 row">
                    <label for="type_paiement" class="col-sm-4 col-form-label" > Type Paiement </label>
                <div class="col-sm-8 col-form-label">
                {{facture.type_paiement}}
                   
                </div>
            </div>
                <div class="form-group2 row">
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Reference Paiement </label>
                    <div class="col-sm-8 col-form-label">
                    {{facture.reference_paiement}}
                    </div>
                </div> 
                 <div class="form-group2 row">
                    <label for="date_paiement"  class="col-sm-4 col-form-label" >Date Paiement </label>
                    <div class="col-sm-8 col-form-label">
                    
                    {{facture.date_paiement}} 
                    </div>
                </div>  
                <div class="form-group2 row">
                    <label for="remise_total_f"  class="col-sm-4 col-form-label" >Remise Total </label>
                    <div class="col-sm-8 col-form-label">
                    {{facture.remise_total_f}}
                    </div>
                </div>                  
                      

                                 
    </div>
    <div class="col-md-6 col-sm-12">
          <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Total HT </label>
            <div class="col-sm-8 cal col-form-label">
            {{facture.total_ht_f}}
            </div>
         </div>
   
       
          <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Remise Total (montant) </label>
            <div class="col-sm-8 cal col-form-label">
            {{facture.remise_ht_f}}
            </div>
         </div>
          <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-4 col-form-label"> Montant Net HT  </label>
            <div class="col-sm-8 cal col-form-label">
            {{facture.montant_net_f}}
            </div>
         </div>
          <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">TVA (Montant) </label>
            <div class="col-sm-8 cal col-form-label">
            {{facture.tva_montant_f}}
            </div>
         </div>
          <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Montant TTC (Montant) </label>
            <div class="col-sm-8 cal col-form-label">
            {{facture.montant_ttc_f}}
            </div>
         </div>
         <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Acompte </label>
            <div class="col-sm-8 cal col-form-label">
            {{facture.accompte_f}}
            </div>
         </div>
         <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-4 col-form-label" style="padding-right: 0px;">Net à payer (Montant) </label>
            <div class="col-sm-8 cal col-form-label" >
            {{facture.montant_reste_f}}
            </div>
         </div>
   
 </div>

        
</div>
<br>
<div class="row">
  <div class="col">
                <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Notes </label>
            <div class="col-sm-10 col-form-label">
            <label>{{facture.notes_f}}</label>
            </div>
         </div>
  </div>
</div>
<br>
<div class="row">
   <div class="col">
          <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Conditions </label>
            <div class="col-sm-10 col-form-label">
            <label>{{facture.conditions_reglements_f}}</label>
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
   // facture
        facture: { 
            id_facture:0,
            reference_f:"",
            date_f:"", 
            adresse_f:"",
            type_operation_f:"",
            objet_f:"",
            date_emission_f:"",
            remise_total_f:"",
            majoration_f:"",
            date_limit_f:"",
            introduction_f:"",  
            conditions_reglements_f:"",
            notes_f:"",
            accompte_f:"",
           fk_status_f:"",
           fk_compte_f:"",
            fk_user_f:"",

            designation:"",
            nom_compte:"",
            taux_tva:"",

            total_ht_f:0,
            remise_ht_f:0,
            montant_net_f:0,
            tva_montant_f:0,
            montant_ttc_f:0,
            total_lettre_f:"",
            montant_reste_f:0,
            
            nom_societe:"",
            },

            statu :{
              type_status:"",
              colorStatu:"",
            },

              // tableau des factures 
              factures :[],
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
updateStatusFacture(){
                axios.post('/updateStatusFacture',this.facture)
                .then(response => {
                        console.log("updateStatusFacture")

                    if(response.data.etat){
              this.$router.push({ name: 'getFacturesA', params: { success: "editStatusuccess"  }});

                      /*  this.$router.push('/FactureDetailsA/editS/'+this.facture.id_facture);
                         if(this.$route.params.success == "editS"){
                            console.log("methode");
                            this.Testopen.testEditS =true; 
                            }*/
                    }
                })
                .catch(error => {
                })
    },
     PdfFacture(reference_f){
                           
                //   window.location.href='/pdf/'+reference_bc
                  window.open('/pdf_f_a/'+reference_f,'_blank');
          },
                        fetchData () {
      //this.error = this.post = null
      this.loading = true
      console.log("loading+++++++++++++++++++++")
      this.getProfile()
      // replace `getPost` with your data fetching util / API wrapper
             this.facture.id_facture = this.$route.params.id_facture;
             this.facture.reference_f=this.$route.params.reference_f;
              this.getFactureF(this.facture.id_facture);
              
              this.getStatus();
              this.getCommandes(this.facture.reference_f);
   //this.getFactureF(this.$route.params.id_Facture);

    },
       getFactureF:function(id_facture){
                  axios.get('/getFactureF/'+id_facture).then(
                  response => {
                         //console.log(response.data.facture.fk_compte_f);
                    //this.loading = false;

                    this.facture= response.data.facture[0];
                    this.facture.colorStatu=response.data.facture[0].colorStatu;
                    console.log("color facture2222 +++++++"+this.facture.colorStatu);
console.log(this.facture);
                  });     
        },
        getCommandes:function(reference_f){
                  axios.get('/getCommandes/'+reference_f).then(
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
        axios.get('/getStatu/'+this.facture.fk_status_f)
            .then((response) => {

                    this.statu = response.data.statu;
                    console.log("facture"+this.facture.fk_status_f)
                    console.log("color   "+response.data.statu.colorStatu)

                     this.facture.colorStatu=response.data.statu.colorStatu;

                 // this.facture.fk_status_f=response.data.statu.adresse_compte;
            })
            .catch(() => {
                    console.log('handle server error from here');
        });
    },
       redirect_To_AddFactureAvoir(facture){
                   //  this.$router.push('/ShowBonCommande/'+reference_bc);
                   console.log("facture details=========>>>>>>")
                   console.log(this.facture)
                     this.$router.push({ name: 'addAvoirFactureA', params: {facture: this.facture}});

            }, 
                 getProfile(){
this.loading = true
                        axios.get('/getProfile')
                        .then(response => {
                                             console.log('errrrrrrrror')
                        console.log(response)
                        if(response.data.error == "Unauthenticated"){
                     window.location.href="/login"}
                            // recuperé ensemble des articles sous format json
                         //  console.log("11")
                           this.profile = response.data.user[0];
                           this.loading = false;
                        //console.log(response.data.user[0]);
                      //  console.log(this.profile)

                        })
                        .catch(function (error) {
                           
                        });                
                         
                               
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
    border: 1px solid #ddd;
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
.trHead{

    background-color: #d8e9f5;

}
.form-group2{
    margin-bottom:0rem;
}
</style>
