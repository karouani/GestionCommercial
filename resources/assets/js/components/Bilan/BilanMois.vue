<template>
    <div class="post" >
      <!-- au cas ajout bien passé afficher ce message -->   
     
           
    <div class="loading" v-if="loading">
           <div class="lds-hourglass"></div>
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
            <div class="text-center pull-right" >
          
    <h2>Bilan Par Mois</h2>
    <hr>   
    </div> 

   

    <div class="row" >
             <div class="card">
                        

                        <div class="card-body">
                            <div class="form-group row">
                        <label for="stagiaire" class="col-sm-4" >mois :</label>
                        <div class="col-sm-8">
    
                            <select class="form-control custom-select " id="fk_compte" v-model="moisS" @change="BilanCharge" >
                                        <option value="" selected disabled>Choisir mois</option>
                                        <option v-for="(m,index) of mois" :key="index" :value="m"> {{m}} </option>
                            </select>  

                        
                                </div>
                            </div>
                              <div class="form-group row">
                        <label for="stagiaire" class="col-sm-4" >annee :</label>
                        <div class="col-sm-8">
    
                            <select class="form-control custom-select " id="fk_compte" v-model="anneeS" @change="BilanCharge" >
                                        <option value="" selected disabled>Choisir année</option>
                                        <option v-for="(a,index) of annee" :key="index" :value="a"> {{a}} </option>
                            </select>  

                        
                                </div>
                            </div>
                            <div v-if="moisS != ''">
                                    <div v-if="anneeS != ''">
                            <h4>Bilan de mois : {{this.moisS}} - {{this.anneeS}}</h4>
                                    </div>
                            </div>
                            <div class="table-responsive" >
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                       
                                        <th>Nom Fournisseur</th>
                                        <th>date</th>
                                     <th>montant</th>
                                    </tr>
                                    </thead>
                                    <tbody >
                                    <tr  v-for="(charge,index) of charges" :key="index" >
                                      
                                        
                                         <td>{{charge.nom_fournisseur_ch}} </td>
                                           <td>{{charge.date_limit_ch}} </td>
                                       
                                         <td>{{charge.montant_ttc_ch}} </td>
                                      </tr>
                                       </tbody>
                                </table> 
                                 <vue-pagination  :pagination="charges"
                     @paginate="this.getChargeMois()"
                     :offset="4">
                                 </vue-pagination>
                            </div>

                                </div>


                        </div>
                    </div>


                    <div class="row" >
             <div class="card">

                        <div class="card-body">

                                <div v-if="moisS != ''">
                                    <div v-if="anneeS != ''">
                                         <div class="table-responsive" >

                                        <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                          <th>Type</th>
                                          <th>Calcul</th>
                                        </tr>
                                        </thead>
                                      <tr>
                                          <th>Total Charges</th>
                                          
                                          <th> {{totalMois}}</th>
                                          </tr>
                                    
                                     <tr>

                                          <th>Total achat</th>
                                          
                                          <th> {{totalAchat}}</th>
                                          </tr>  
                                </table> 
                                         <table class="table table-bordered">  
                                          <tr>
                                          <th>Total Sortie</th>
                                          
                                          <th> {{totalSortie}}</th>
                                          </tr> 
                                          
                                           <tr>
                                          <th>Total Vente</th>
                                          
                                          <th> {{totalVente}}</th>
                                          </tr>
                                          
                                          <tr>
                                          <th>Difference</th>
                                          
                                          <th> {{difference}}</th>
                                          </tr>
                                          </table> 
                                           <table class="table table-bordered">
                                          <tr>
                                          <th>TVA Achat</th>
                                          
                                          <th> {{tvaAchat}}</th>
                                          </tr>
                                          
                                          <tr>
                                          <th>TVA Vente</th>
                                          
                                          <th> {{tvaVente}}</th>
                                          </tr>
                                          
                                          <tr>
                                          <th>Différence TVA</th>
                                          
                                          <th> {{diffTVA}}</th>
                                          </tr>
                                          </table> 
                                           <table class="table table-bordered">
                                          <tr>
                                          <th>Revenu Net</th>
                                         
                                          <th> {{benifice}}</th>
                                          </tr>
                                          
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    </div>
                                </table>
                              
                                         </div>

 <form   @submit.prevent="addBilan">
                                <table class="table table-bordered">  
                                    <thead>
                                          <tr>
                                          <th>Debit</th>
                                          <th>Crédit</th>
                                          <th>Difference</th>
                                          <th>Solde Depart</th>
                                          <th>Etat</th>

                                          </tr> 
                                    </thead>    
                                           <tr>
                                          
                                          <th> {{totalSortie}}</th>
                                          <th> {{totalVente}}</th>
                                           <th> {{difference}}</th>
                                           <th> {{soldeDepart}}</th>
                                           <th> {{etat}}</th>

                                          </tr>
                                </table>
                    <div v-if="test == true">
                         <div v-if="testP == false">
                     <button  class="btn mb-3 float-right btn-success">Enregister</button>
                    </div>
                                             <div v-if="testP == true">
                                                 il faut enregistrer le mois precedent
                                             </div>

                    </div>
 </form>
                            </div>

                              </div>
             </div>
             </div>
                    </div>
                    <div>
              
           
            </div>
    </div>
    
    </div>
    <!-- fin affiche -->
   
</template>

<script>
import  Pagination from '../Pagination.vue';

    export default{
         components:{
            'vue-pagination':Pagination,
         },

          data: () => ({
                     loading: false,
      post: null,
      error: null,
             modalShow: false,
             mois:['01','02','03','04','05','06','07','08','09','10','11','12'],
              //search
              search : '',
              //name file 
              nameFile : "Choose file",
              // objet test sur affichage , ajout , recherche
              Testopen:{
                testnotifAdd : false,
             
              },
                charges:{
                      
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
                offset: 4,
                currentDate:"",

              charge: { 
                    
                    id_charge :0,
                    num_facture_ch:"",
                    date_facture_ch:"",
                    nom_fournisseur_ch:"",
                    designation_ch:"",
                    montant_ht_ch:"",
                    taux_tva_ch:"",
                    tva_ch:"",
                    montant_ttc_ch:"",
                    mode_paiement_ch:"",
                    reference_ch:"",
                    date_paiement_ch:"",
                    support_ch:"",
                    objet_ch:"",
                    type_delai_ch:"",
                    date_limit_ch:"",


                    date_diff:"",

              },
             annee:['2017','2018'],
             anneeS:"",

             moisS:"",
             total:0,

             totalMois:0,
             totalAchat:0,
             totalSortie:0,
             totalVente:0,
             difference:0,

             tvaAchat:0,
             tvaVente:0,
             diffTVA:0,

             benifice:0,

             verifie:0,
             test:false,
             soldeDepart:0,
             etat:0,
             testP:false,
             
      }),
   
        mounted(){
            console.log("moisSSSSSSSS")
            console.log(this.moisS)
             var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; 
            var yyyy = today.getFullYear();
            console.log("month"+today)
             if(dd<10) 
                {
                    dd='0'+dd;
                } 

                if(mm<10) 
                {
                    mm='0'+mm;
                } 
            this.currentDate  = yyyy+'-'+mm+'-'+dd;
                       console.log("current date ******************")
                       console.log(this.currentDate); 
        
        
        },
    
        created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },


      methods: {
        getChargeMois(){
                axios.get('/getCharges?page='+this.charges.current_page+'',{params:{mois:this.moisS,annee:this.anneeS}})
                .then((response) => {
                  console.log('shiiiiiiiiiiit');
                  console.log(response.data.charges)
                   // this.charges = response.data.charges;
                   
this.loading = false
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
       

            fetchData () {
      //this.error = this.post = null
      this.loading = true
    //this.getChargeMois();
      this.BilanCharge();

   
    },
          BilanCharge(){
                axios.get('/BilanCharge',{params:{mois:this.moisS,annee:this.anneeS}})
                .then((response) => {
                  console.log('shiiiiiiiiiiit');
                  console.log(response.data.totalMois[0].total);
                  
                    this.charges = response.data.charges;
                    this.totalMois=response.data.totalMois[0].total;
                    let totalAchatF=response.data.totalAchat[0].totalA;
                    let totalAchatFAvoir=response.data.totalAchatAvoir[0].totalAA;
                    this.totalAchat=totalAchatF - totalAchatFAvoir;

                    this.totalSortie=this.totalMois+this.totalAchat;
                    let totalVenteF=response.data.totalVente[0].totalV;
                    let totalVenteFAvoir=response.data.totalVenteAvoir[0].totalVA;

                    this.totalVente=totalVenteF - totalVenteFAvoir;
                    this.difference=this.totalVente - this.totalSortie;

                    let tvaA= response.data.totalAchat[0].tvaA;
                    let tvaC=response.data.totalMois[0].tvaC;
                    this.tvaAchat= tvaA + tvaC;
                    this.tvaVente=response.data.totalVente[0].tvaV;
                    this.diffTVA=this.tvaVente - this.tvaAchat;
                    
                    this.benifice=this.difference - this.diffTVA;
//this.soldeDepart=0;
                    this.etat=+this.soldeDepart + +this.difference;
this.getChargeMois();
                     this.verifiee();
                    // this.verifieeP();
                     this.verifieSize();
                     
this.loading = false
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },

           verifiee(){
                axios.get('/verifie',{params:{mois:this.moisS,annee:this.anneeS}})
                    .then((response) => {
                        console.log('verifie')
                        console.log(response.data.verifie)
                        this.verifie = response.data.verifie;
                        if(this.verifie.length === 0){
                            console.log("teeeeest")
                            this.test = true;
                        }
                        else{
                            this.test=false;
                        }

                    })
                .catch(() => {
                    console.log('handle server error from here');
                });

           },  
        getSolde(){
                axios.get('/solde')
                    .then((response) => {
                                                    console.log("sooooooooooooooolde")

                        console.log(response.data.solde)
                        this.solde = response.data.solde[0];
                      
                            this.soldeDepart=this.solde.solde_init;
                            console.log(this.soldeDepart)
                      
              
            })
        },
        verifieSize(){
            
            axios.get('/verifieSize')
                    .then((response) => {
                        console.log('verifie size')
                        console.log(response.data.verifie)
                        this.verifie = response.data.verifie;
                        if(this.verifie === 0){
                            console.log("teeeeestppppppppppppppp")
                            this.getSolde();
                            this.testP=true;
                        }
                        else if(this.verifie != 0){
                            this.verifieeP();
                            this.testP=false;
                          
                        }
              
            })
        },

            verifieeP(){
                let moisP=this.moisS - 1;
                let annee;
                if(moisP<10) 
                {
                    moisP='0'+moisP;
                    annee=this.anneeS;
                }
                if(this.moisS == 1) 
                {
                    moisP='12';
                    annee=this.anneeS - 1;
                }
               console.log(moisP)
                axios.get('/verifie',{params:{mois:moisP,annee:annee}})
                    .then((response) => {
                        console.log('verifie add')
                        console.log(response.data.verifie)
                        this.verifie = response.data.verifie;
                        if(this.verifie.length === 0){
                            console.log("teeeeestppppppppppppppp")
                            this.testP = true;
                        }
                        else{
                             console.log("siiiiiiiiiiiiiiiiiiiiiii")
                            this.soldeDepart=response.data.verifie[0].etat_b;
                            this.testP=false;
                          
                        }
              
})
           }, 
           
           
           addBilan(){
               
                             axios.post('/addBilan',{params:{mois:this.moisS,annee:this.anneeS,debit:this.totalSortie,credit:this.totalVente,difference:this.difference,soldeDepart:this.soldeDepart,etat:this.etat}})
                .then((response) => {
                                    this.$router.push('/BilanAnnee');

            })
                .catch(() => {
                    console.log('handle server error from here');
                });
                        }

                  
              
 
      },

      

    }
    
</script>

<style scoped>
.shadawTr:hover {
  box-shadow: 1px 1px 1px 1px #888888;
    }
thead{
    background-color: #efefef;
}
.optionsWidth{
width : 171px;

}
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
span {
    color: #42a5f5;
}
thead{
    background-color: #e9ecef;
}
table{
    background-color: white;
}
.card-body{
    background-color: #f8f9fa
}

.notifArticle{
    opacity:0.9;
    width: 233px;
    z-index: 100;
    top: 61px;
    right: 0;
    position:  absolute;
    position :fixed;
}
th{
        width: 200px;
}
.card{
    width:100%;
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


</style>



