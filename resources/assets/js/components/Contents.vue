<template>
        <div>
            
   <div class="loading" v-show="loading">
          <div class="lds-hourglass"></div>
    </div>
     <div v-show="!loading" >
                <div class="row">
                    <div class="col-md-3">
                        <div class="card p-2">
                            <div class=" card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h4 d-block font-weight-normal mb-2">{{nbrFactures}}</span>
                                    <span class="font-weight-light">Factures</span>
                                </div>

                                <div class="h2 text-muted">
                                    <i class="far fa-file"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-2">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h4 d-block font-weight-normal mb-2">{{nbrBonCommande}}</span>
                                    <span class="font-weight-light">Bon de Commandes</span>
                                </div>

                                <div class="h2 text-muted">
                                    <i class="far fa-file"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-2">
                            <div class=" card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h4 d-block font-weight-normal mb-2">{{nbrBonlivraisons}}</span>
                                    <span class="font-weight-light">Bon de livraison</span>
                                </div>

                                <div class="h2 text-muted">
                                    <i class="far fa-file"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-2">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h4 d-block font-weight-normal mb-2">{{nbrDevis}}</span>
                                    <span class="font-weight-light">Devis</span>
                                </div>

                                <div class="h2 text-muted">
                                   <i class="far fa-file"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                        
                   
                <div class="row">
                     <div class="col-md-6">
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <canvas id="myChart"></canvas>
                            </div> 
                        </div>
                     </div>
                      <div class="col-md-6">
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <canvas id="myChartClient"></canvas>
                            </div> 
                        </div>
                     </div>
                     <div class="col-md-12">
                             
                            <select class="form-control custom-select " id="fk_compte" v-model="anneeS" @change="Bilan(testt)" >
                                        <option value="" selected disabled>Choisir année</option>
                                        <option v-for="(a,index) of annee" :key="index" :value="a"> {{a}} </option>
                            </select> 
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <canvas style="display: block;width: 864px;height: 328px;" id="myLine"></canvas>
                            </div> 
                        </div>
                     </div>                     
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <canvas id="PieChart"></canvas>
                            </div> 
                        </div>
                    </div>
                </div>
                      

     </div>     
     </div> 
</template>
<script>
//import { Line } from 'vue-chartjs'
import Chart from 'chart.js';


export default {
data: () => ({
    nbrDevis: 0,
    nbrBonCommande:0,
    nbrBonlivraisons:0,
    nbrFactures:0,
     loading: false,
    articles: [],
    listeClient:[],
    MontantFactureVenteAchat:[],
        labels2 :[],
        votes2:[],
        labels3 :[],
        votes3:[],
        labels4 :[],
        votes4:[],
        moisA:[],
        etat:[],
        testt :"",
         annee:['2016','2017','2018'],
        anneeS:"2018",
        message: "Vue.js & Chart.js",
        labels: ["client1", "client2", "client3", "client4", "client5", "client6"],
        votes: [12, 19, 3, 5, 40, 70],
        type : "bar"
  }),
  created(){
   

  },
   mounted () {
       this.countAllDevis();
       this.countAllBonCommandes();
       this.countAllFactures();
       this.countAllBonLivraisons();
       
    var ctx =    document.getElementById("myChart");
    var ctxL =    document.getElementById("myLine");
    //var ctxP =    document.getElementById("PieChart");
     var ctxClient=    document.getElementById("myChartClient");
      var ctxVenteAchat=    document.getElementById("PieChart");
      this.testt =ctxL;
   /* var myPieChart = new Chart(ctxP ,{
    type: 'pie',
    data: {
                labels: this.labels,
                    datasets: [
                        {
                            label: "# Clients",
                            data: this.votes,
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.6)",
                                "rgba(54, 162, 235, 0.6)",
                                "rgba(255, 206, 86, 0.6)",
                                "rgba(75, 192, 192, 0.6)",
                                "rgba(153, 102, 255, 0.6)",
                                "rgba(255, 159, 64, 0.6)"
                            ],
                            borderColor: [
                                "rgba(255,99,132,1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)"
                            ],
                            borderWidth: 1
                        }
                    ] 
    },
    options: {
        scales: {
            yAxes: [{
                stacked: true
            }]
        }
    }
});*/



 this.getArticlePlusVente(ctx);
  this.getClientPlusVente(ctxClient)
  this.getMontantFactureVenteAchat(ctxVenteAchat)

   this.Bilan(ctxL);
            console.log('---- test labels 2 ')
            console.log(this.labels2)
           
        
        },
         methods: {

                   Bilan(){
     
    },
             
             

            countAllFactures(){
                 
                 axios.get('/countAllFactures')
                .then((response) => { 
                        console.log("nombre facture ========= ")
                        console.log(response.data.count)
                        this.nbrFactures = response.data.count;
                 });
             },
             countAllBonLivraisons(){
                 
                 axios.get('/countAllBonLivraisons')
                .then((response) => { 
                        console.log("nombre BonCommande ========= ")
                        console.log(response.data.count)
                        this.nbrBonlivraisons = response.data.count;
                 });
             },
             countAllBonCommandes(){
                 
                 axios.get('/countAllCommandes')
                .then((response) => { 
                        console.log("nombre BonCommande ========= ")
                        console.log(response.data.count)
                        this.nbrBonCommande = response.data.count;
                 });
             },
             countAllDevis(){
                 
                 axios.get('/countAllDevis')
                .then((response) => { 
                        console.log("nombre devis ========= ")
                        console.log(response.data.count)
                        this.nbrDevis = response.data.count;
                 });
             },

                       async getArticlePlusVente(ctx){
                            this.loading= true;
               let art = await  axios.get('/getArticlePlusVente')
                .then((response) => {
                 // console.log('shit');
                

                    this.articles = response.data.articles;
      
                    for(var i=0;i<this.articles.length;i++){
                         this.labels2[i] = this.articles[i].designation
                      this.votes2[i]= this.articles[i].count
                    
                     
                    }  
                    this.loading = false
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
                  var stackedChart = await  new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: this.labels2,
                    datasets: [
                        {
                            label: "# articles",
                            data: this.votes2,
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.6)",
                                "rgba(54, 162, 235, 0.6)",
                                "rgba(255, 206, 86, 0.6)",
                                "rgba(75, 192, 192, 0.6)",
                                "rgba(153, 102, 255, 0.6)",
                                "rgba(255, 159, 64, 0.6)"
                            ],
                            borderColor: [
                                "rgba(255,99,132,1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)"
                            ],
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true
                                }
                            }
                        ]
                    }
                }
            }); 
            
          },
 async getClientPlusVente(ctxClient){
                            this.loading= true;
               let art = await  axios.get('/getClientPlusVente')
                .then((response) => {
                 // console.log('shit');
                

                    this.listeClient = response.data.listeClient;
      
                    for(var i=0;i<this.listeClient.length;i++){
                         this.labels3[i] = this.listeClient[i].nom_compte
                      this.votes3[i]= this.listeClient[i].total
                    
                     
                    }  
                    this.loading = false
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
                  var stackedChart = await  new Chart(ctxClient, {
                type: 'bar',
                data: {
                    labels: this.labels3,
                    datasets: [
                        {
                            label: "# Clients",
                            data: this.votes3,
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.6)",
                                "rgba(54, 162, 235, 0.6)",
                                "rgba(255, 206, 86, 0.6)",
                                "rgba(75, 192, 192, 0.6)",
                                "rgba(153, 102, 255, 0.6)",
                                "rgba(255, 159, 64, 0.6)"
                            ],
                            borderColor: [
                                "rgba(255,99,132,1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)"
                            ],
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true
                                }
                            }
                        ]
                    }
                }
            }); 
            
          },
        async getMontantFactureVenteAchat(ctxVenteAchat){
                            this.loading= true;
               let art = await  axios.get('/getMontantFactureVenteAchat')
                .then((response) => {
                 // console.log('shit');
                

                    this.MontantFactureVenteAchat = response.data.MontantFactureVenteAchat;
      
                    for(var i=0;i<this.MontantFactureVenteAchat.length;i++){
                         this.labels4[i] = this.MontantFactureVenteAchat[i].type_operation_f
                      this.votes4[i]= this.MontantFactureVenteAchat[i].total
                    
                     
                    }  
                    this.loading = false
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
                  var stackedChart = await  new Chart(ctxVenteAchat, {
                type: 'pie',
                data: {
                    labels: this.labels4,
                    datasets: [
                        {
                            label: "# Clients",
                            data: this.votes4,
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.6)",
                                "rgba(54, 162, 235, 0.6)",
                                "rgba(255, 206, 86, 0.6)",
                                "rgba(75, 192, 192, 0.6)",
                                "rgba(153, 102, 255, 0.6)",
                                "rgba(255, 159, 64, 0.6)"
                            ],
                            borderColor: [
                                "rgba(255,99,132,1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)"
                            ],
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true
                                }
                            }
                        ]
                    }
                }
            }); 
            
          },

           async Bilan(ctxL){
                         //   this.loading= true;
               let art = await   axios.get('/BilanAnnee/'+this.anneeS)
 .then((response) => {
                  console.log('shiiiiiiiiiiit');
                  console.log(response.data.moisA);
                  console.log('testtttttttt')
                    this.moisA = Object.values(response.data.moisA);
                    this.etat = Object.values(response.data.etat);
                    console.log('-----============')
                   // console.log(this.moisA)
                    for(let i=0;i<this.moisA.length;i++){
                        //console.log("les mois ")
                        console.log(this.moisA[i]+" : "+this.etat[i]);
                    }
                   
                  console.log("kkkk")
                })
                .catch(() => {
                    console.log('handle server error from here');
                });

                  var stackedChart = await  new Chart(ctxL, {
                type: 'line',
                data: {
                    labels: this.moisA,
                    datasets: [
                        {
                            label: "# Bilan Par année ",
                            data: this.etat,
                            backgroundColor: [
                                "rgba(54, 162, 235, 0.6)",
                                "rgba(255, 99, 132, 0.6)",
                                
                                "rgba(255, 206, 86, 0.6)",
                                "rgba(75, 192, 192, 0.6)",
                                "rgba(153, 102, 255, 0.6)",
                                "rgba(255, 159, 64, 0.6)"
                            ],
                            borderColor: [
                                "rgba(255,99,132,1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)"
                            ],
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true
                                }
                            }
                        ]
                    }
                }
            }); 
            
          },
         },
        

 

}
</script>
<style scoped>
.widthcards{

    width: 192px;

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