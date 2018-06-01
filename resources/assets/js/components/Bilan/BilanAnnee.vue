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
          
    <h3>Bilan Par Annee</h3>
    <hr>   
    </div> 

   

    <div class="row" >
             <div class="card">
                        

                        <div class="card-body">
                            <div class="form-group row">
                        <label for="stagiaire" class="col-sm-4" >Annee :</label>
                        <div class="col-sm-8">
    
                            <select class="form-control custom-select " id="fk_compte" v-model="anneeS" @change="Bilan" >
                                        <option value="" selected disabled>Choisir mois</option>
                                        <option v-for="(a,index) of annee" :key="index" :value="a"> {{a}} </option>
                            </select>  

                        
                                </div>
                            </div>
                            <h4>Bilan d'Année : {{this.anneeS}}</h4>
                            <div class="table-responsive" >
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                       
                                        <th>mois</th>
                                        <th>débit</th>
                                        <th>crédit</th>
                                        <th>difference</th>
                                        <th>solde depart</th>
                                        <th>etat</th>
                                    </tr>
                                    </thead>
                                    <tbody >
                                           
                                    <tr v-for="(m,index) of mois" :key="index" v-if="anneeS != ''">
                                      
                                       
                                         <td>{{m}} - {{anneeS}} </td>
                                   
                                    
                                            
                                            <td>
                                                
                                           <div v-for="sortie of sorties" :key="sortie.index">
                                              
                                                    {{sortie}}
                                           </div>
                                    
                                                     </td> 
                                            <td>
                                            <div v-for="(vente,index) of totalVente" :key="index" v-if="vente.month === m">                                              
                                                 {{vente.totalV}}
                                                 
                                            </div> 
                                                 </td> 
                                            <td> 
                                                <div v-for="(diff,index) of difference" :key="index" >
                                     
                                                {{diff}} 
                                                </div>  
                                                </td>
                                            <td>
                                             <div v-for="(solde,index) of soldeDepart" :key="index" >
                                             
                                                 {{solde}}
                                             </div>  
                                                  </td>
                                            <td>
                                             <div v-for="(et,index) of etat" :key="index" >
                                            
                                                 {{et}}
                                              </div>  
                                                  </td>
                                   
                                               
                                    </tr>
                                  
                                
                                    
                                
                                          
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    </div>
                                     </tbody>
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
            // mois:['01','02','03','04','05','06','07','08','09','10','11','12'],
             annee:['2016','2017','2018'],
 mois:[1,2,3,4,5,6,7,8,9,10,11,12],
             //search
              search : '',
              //name file 
              nameFile : "Choose file",
              // objet test sur affichage , ajout , recherche
              Testopen:{
                testnotifAdd : false,
             
              },
              
                offset: 4,
                currentDate:"",

            
             anneeS:"",
             moisS:"",

  
             sorties:[],
             totalVente:[],
             difference:[],
             etat:[],
             soldeDepart:[],

  

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
  watch: {
    // call again the method if the route changes
    '$route': 'fetchData'
  },


      methods: {
        
 

            fetchData () {
      //this.error = this.post = null
     // this.loading = true
      //this.BilanAnnee();
 //this.Bilan(this.annee);
   //this.getBilan();
    },
       Bilan(){
                axios.get('/Bilan/'+this.anneeS)
 .then((response) => {
                  console.log('shiiiiiiiiiiit');
                  console.log(response.data.sortie);
                  
                    this.sorties = response.data.sortie;
                    this.totalVente = response.data.totalVente;
                    this.difference = response.data.difference;
                    this.soldeDepart = response.data.soldeDepart;
                    this.etat = response.data.etat;
                   
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },



  /*  getBilan(){
                axios.get('/getBilan',{params:{annee:this.anneeS}})
 .then((response) => {
                  console.log('shiiiiiiiiiiit');
                  console.log(response.data.bilanA);
                  
                    this.bilanAnnee = response.data.bilanA;
                   
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },*/
          BilanAnnee(){
             

                axios.get('/BilanAnnee',{params: {annee:this.anneeS}})
                .then((response) => {
                  console.log('shiiiiiiiiiiit');
                //  console.log(response.data.totalCharge);
                        this.totalVente=response.data.totalVente;

                        this.totalCharges=response.data.totalCharge;
                        //console.log(this.totalCharges)
                        this.totalAchat=response.data.totalAchat;
                             let this1=this;
                             let this2=this;
                             let this0=this;
                                         let mois=[1,2,3,4,5,6,7,8,9,10,11,12];
       

     for(let k=0;k<this.totalCharges.length;k++){ 
         for(let p=0;p<this.totalVente.length;p++){
                      //  console.log(this.totalCharges[k].month)
                        for(let j=0;j<this.totalAchat.length;j++){
          /* this.totalCharges.forEach(function(totalCharge) {
               //console.log("waaaaaaaaaaaaaaaaaa3")
               this1.totalAchat.forEach(function(totalAchat) {*/
                  // console.log("waaaaaaaaaaaaaaaaa")
                   for(let i=0;i<mois.length;i++){

                   
               if(this.totalCharges[k].month === mois[i] || this.totalAchat[j].month === mois[i]){
                   console.log('yeeeeeeeeeeeeeeeeeeeeeeees')
                     console.log(mois[i])
                                             this.totalVente[p].totalV=this.totalVente[p].totalV;

                   // this.totalSortie[i].month=mois[i];
                    this.totalSortie[i]=this.totalCharges[k].total + this.totalAchat[j].totalA;
                    this.difference[i]=this.totalVente[p].totalV + this.totalSortie[i];
               // console.log(this.totalSortie[i].month)
                console.log(this.totalSortie[i])
                console.log(this.difference[i])
               // console.log(totalAchat)
               }  
               
            /*   else if(this.totalCharges[k].month === mois[i] && this.totalAchat[j].month != mois[i]){
                   console.log('nooooooooooooooooooooooo')
                                                          console.log(mois[i])
                                                          //console.log(this.totalCharges[k].month)
                                             this.totalVente[p].totalV=this.totalVente[p].totalV;

                     this.totalSortie[i]=this.totalCharges[k].total;
                                   this.difference[i]=this.totalVente[p].totalV + this.totalSortie[i];

                console.log(this.totalSortie[i])

               // console.log(totalAchat)
                }
                else if(this.totalCharges[k].month != mois[i] && this.totalAchat[j].month === mois[i]){
                   console.log('yep')
                                                          console.log(mois[i])
                                                          //console.log(this.totalCharges[k].month)
                                             this.totalVente[p].totalV=this.totalVente[p].totalV;

                     this.totalSortie[i]=this.totalAchat[j].totalA;
                                   this.difference[i]=this.totalVente[p].totalV + this.totalSortie[i];

                console.log(this.totalSortie[i])

               // console.log(totalAchat)
                } */
                
               } 
                   }
         }
                   }
                                   // console.log(this2.totalSortie)

            /*   if(totalAchat.length === 0){
                   console.log('nooooooooooooooooooo')
                        console.log(totalCharge)

                        console.log(totalAchat)
                                  this2.totalSortie=totalCharge.total;

               }*/
             //  console.log("wiiiiiiiiiiiiiiiiiiiiiiiiiiiii")

                 /*  })

           })*/
          
             
                 /*
                    for(i=0;i<this.totalCharges.length;i++){
                        console.log(this.totalCharges[i].month)
                        for(j=0;j<this.totalAchat.length;j++){
                            console.log(this.totalAchat[j].month)
                            if(this.totalCharges[i].month === this.totalAchat[j].month){
                                this.totalSortie=this.totalCharges[i].total+this.totalAchat[j].totalA;
                            }
                        }
                    }
                    */
                    //this.totalSortie=this.totalCharges+this.totalAchat;
                  /*  this.difference=this.totalVente - this.totalSortie;

                    let tvaA= response.data.totalAchat.tvaA;
                    let tvaC=response.data.totalMois.tvaC;
                    this.tvaAchat= tvaA + tvaC;
                    this.tvaVente=response.data.totalVente.tvaV;
                    this.diffTVA=this.tvaVente - this.tvaAchat;
                    
                    this.benifice=this.difference - this.diffTVA;*/
/*this.loading = false
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },*/

               
      })

 

},

      }
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



