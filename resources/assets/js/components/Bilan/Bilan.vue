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
          
    <h3>Bilan Par Mois</h3>
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
                            <h4>Bilan de mois : {{this.moisS}}</h4>
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
                                <div v-if="moisS != ''">
                                        <table class="table table-bordered">

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
                            </div>
                        </div>
                    </div>
                    <div>
              
           
            </div>
    </div>
    <!--
    <vue-pagination  :pagination="charges"
                     @paginate="getCharges()"
                     :offset="4">
    </vue-pagination>
    -->
    </div>
    <!-- fin affiche -->
    </div>
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
      updated(){
         
      },
        created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
  watch: {
    // call again the method if the route changes
    '$route': 'fetchData'
  },


      methods: {
        
          searchCharges(event){
             console.log(this.search);
             this.charges.current_page=1;
             if(this.search === ""){
                //console.log('test2');
                    this.getCharges();}
                else {
                     // console.log('test1');
                axios.get('/searchCharges/'+this.search+'?page='+this.charges.current_page+'')
                .then((response) => {
                  
                    this.charges = response.data.charges;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
          },

            fetchData () {
      //this.error = this.post = null
      this.loading = true
      this.BilanCharge();
   
    },
          BilanCharge(){
                axios.get('/BilanCharge',{params:{mois:this.moisS}})
                .then((response) => {
                  console.log('shiiiiiiiiiiit');
                  console.log(response.data.totalMois[0].total);
                  
                    this.charges = response.data.charges;
                    this.totalMois=response.data.totalMois[0].total;
                    this.totalAchat=response.data.totalAchat[0].totalA;
                    this.totalSortie=this.totalMois+this.totalAchat;
                    this.totalVente=response.data.totalVente[0].totalV;
                    this.difference=this.totalVente - this.totalSortie;

                    let tvaA= response.data.totalAchat[0].tvaA;
                    let tvaC=response.data.totalMois[0].tvaC;
                    this.tvaAchat= tvaA + tvaC;
                    this.tvaVente=response.data.totalVente[0].tvaV;
                    this.diffTVA=this.tvaVente - this.tvaAchat;
                    
                    this.benifice=this.difference - this.diffTVA;
this.loading = false
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },

               
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



