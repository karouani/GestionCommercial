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
                                <canvas id="myLine"></canvas>
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
        labels2 :[],
        votes2:[],
        message: "Vue.js & Chart.js",
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
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
    var ctxP =    document.getElementById("PieChart");
    
    var myPieChart = new Chart(ctxP ,{
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
});


var stackedLine = new Chart(ctxL, {
    type: 'line',
    data: {
        labels: this.labels,
                    datasets: [
                        {
                            label: "# articles",
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
});
 this.getArticlePlusVente(ctx);
  
            console.log('---- test labels 2 ')
            console.log(this.labels2)
           
        
        },
         methods: {
             
             

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