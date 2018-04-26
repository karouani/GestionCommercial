<template>
        <div>
            
   <div class="loading" v-show="loading">
          <div class="lds-hourglass"></div>
    </div>
     <div v-show="!loading" >
                <div class="row">
                    <div class="col-md-3">
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h4 d-block font-weight-normal mb-2">54</span>
                                    <span class="font-weight-light">Total Users</span>
                                </div>

                                <div class="h2 text-muted">
                                    <i class="icon icon-people"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h4 d-block font-weight-normal mb-2">$32,400</span>
                                    <span class="font-weight-light">Income</span>
                                </div>

                                <div class="h2 text-muted">
                                    <i class="icon icon-wallet"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h4 d-block font-weight-normal mb-2">900</span>
                                    <span class="font-weight-light">Downloads</span>
                                </div>

                                <div class="h2 text-muted">
                                    <i class="icon icon-cloud-download"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h4 d-block font-weight-normal mb-2">32s</span>
                                    <span class="font-weight-light">Time</span>
                                </div>

                                <div class="h2 text-muted">
                                    <i class="icon icon-clock"></i>
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

</style>