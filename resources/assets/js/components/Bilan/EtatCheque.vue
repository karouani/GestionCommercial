<template>
    <div class="post" >
      <!-- au cas ajout bien passé afficher ce message -->   
                            <notifications group="foo" 
      position="bottom right" 
      classes="vue-notification success"/> 
           
    <div class="loading" v-if="loading">
     <div class="lds-hourglass"></div>
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
       <div class="row" >
                 
        <div class="col-4">
            <div class="row">
            <h3>Etat de chèque</h3>
            </div>
            <div class="row">
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="number" @keyup.enter="getEtatCheque"  class="form-control" v-model="anneeCheque" placeholder="recherche par année " aria-label="Username" aria-describedby="basic-addon1" >
            </div>            </div>
            </div>
    <!-- button pour afficher tous les users-->
       <div class="col-8">
<div class="card text-white bg-primary mb-3 float-right" style="max-width: 18rem;">
  <div class="card-header" style="background-color: rgb(53, 169, 230);">Somme payée par chèque</div>
  <div class="card-body">
   <h3> <p class="card-text text-danger">{{totalCheque}} DH</p></h3>
  </div>
</div>
       </div>
       
  
    
    
    <hr>   
    </div>
   
            <div v-if="Testopen.testnotifAdd" class="alert alert-success alert-dismissible fade show notifArticle" role="alert">
        <strong>Compte bien ajouter !</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>

        <div v-if="Testopen.testnotifEdit" class="alert alert-success alert-dismissible fade show notifArticle" role="alert">
        <strong>Compte bien modifier !</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
   
    <!-- formulaire pour Ajouter un article -->
   
   
    
    <!-- fin formulaire -->
    <!-- afficher les articles sous formes des cards  -->
    
  


    <div class="row" id="testdiv">
        <div class="col-12">
             <div class="card">
                        <div class="card-header bg-light">
                            
                            <div class="row btnMarge">
 <div class="col-2">Achats</div>
    <div class="col"  >
    <!-- button pour afficher formulaire de l'ajout d un article -->         
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="getEtatChequeAchat"  class="form-control" v-model="searchAchat" placeholder="recherche par N°cheque" aria-label="Username" aria-describedby="basic-addon1" >
            </div>
        </div> 
        
    </div>
                       </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>N ° Chèque</th>
                                        <th>Montant</th>
                                        <th>Date</th>
                                        <th>Ordre</th>
                                        <th>Date débit </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="(etatChequeItem,index) of etatCheque.data" :key="index" >
                                           <td>{{etatChequeItem.reference_paiement}}</td>
                                        <td>{{etatChequeItem.montant_reste_f}}</td>
                                        <td>{{etatChequeItem.date_paiement}}</td>  
                                        <td>{{etatChequeItem.fk_document}}</td> 
                                         <td>{{etatChequeItem.date_paiement}}</td> 
                                     
                                 
                                    </tr>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    </div>
                                    </tbody>
                                </table>
                            </div>
                                <vue-pagination  :pagination="etatCheque"
                     @paginate="getEtatChequeAchat()"
                     :offset="4">
    </vue-pagination>
                        </div>
                    </div>
       </div>

    </div>
    


     <div class="row" id="testdiv">
          <div class="col-12">
             <div class="card">
   
                        <div class="card-header bg-light">
                            <div class="row btnMarge">
                                <div class="col-2">Charges</div>
    <div class="col">
    <!-- button pour afficher formulaire de l'ajout d un article -->         
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="getEtatChequeCharge"  class="form-control" v-model="searchCharge" placeholder="recherche par N°cheque " aria-label="Username" aria-describedby="basic-addon1" >
            </div>
        </div> 
        
    </div>
                       </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>N ° Chèque</th>
                                        <th>Montant</th>
                                        <th>Date</th>
                                        <th>Ordre</th>
                                        <th>Date débit </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="(charge,index) of charges.data" :key="index" >
                                           <td>{{charge.reference_ch}}</td>
                                        <td>{{charge.montant_ttc_ch}}</td>
                                        <td>{{charge.date_paiement_ch}}</td>  
                                        <td>{{charge.designation_ch}}</td> 
                                         <td>{{charge.date_paiement}}</td> 
                                     
                                 
                                    </tr>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    </div>
                                    </tbody>
                                </table>
                            </div>
                                <vue-pagination  :pagination="charges"
                     @paginate="getEtatChequeCharge()"
                     :offset="4">
    </vue-pagination>
                        </div>
                    </div>
     </div>
    </div>
    

    
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
              searchAchat:"",
              searchCharge:"",
              anneeCheque:"",
              totalAchats:0,
              totalCharge:0,
              totalCheque: 0,
        charges:{
                    total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],
              },
           etatCheque:{
                        
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },

              test1 : {
                  searchQuery: 0,
                   calculee: 0,
                  },
                 
                     loading: false,
      post: null,
      error: null,
             modalShow: false,
              //search
              search : '',
              //name file 
              nameFile : "Choose file",
              // objet test sur affichage , ajout , recherche
              Testopen:{
                testnotifEdit : false,
                testnotifAdd : false,
                testAjout : false,
                testAffiche : false,
                testmodelArticle : false,
              },
              testEdit : false,
              // tester l ajout si bien fais 
              
              // tester  si affiche articles  ou afficher ajouter article 
              
              // initialisation d un article 
              comptes:{
                        
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
               offset: 4,


              compte: { 
                    id_compte : 0,
                    nom_compte : "",
                    responsable : "",
                    type_compte : "",
                    categorie : "",
                    raison_social : "",
                    reference : "",
                    fixe : "",
                    portable : "",
                    fax : "",
                    email : "",
                    site_web  : "",
                    secteur_activite : "",
                    taille : "",
                    RC : "",
                    fk_compagnie : "",
              },
            
             
             
      }),
 
   
        mounted(){
                       
            this.anneeCheque = new Date().getFullYear();
            
          if( this.$route.params.success == "addsuccess"){
             
                           this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'compte bien ajouter!',
                                      duration: 1500,
                                    });
          }
                    if( this.$route.params.success == "editsuccess"){
             
                                  this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'compte bien modifier!',
                                      duration: 1500,
                                    });
          }
        },
      updated(){
          if( this.$route.params.success == "addsuccess"){
          let this1 = this
               setTimeout(function () { this1.Testopen.testnotifAdd = false }, 1500);
               }
          if( this.$route.params.success == "editsuccess"){
          let this1 = this
               setTimeout(function () { this1.Testopen.testnotifEdit = false }, 1500);}               
            
      },
        created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
  watch: {
    // call again the method if the route changes
    '$route': 'fetchData',
  
   'test1.searchQuery':
     function(val){
      //console.log(val)
      this.test1.calculee = +val + 1
      console.log(this.test1.calculee)  
     }
 
  },

      methods: {
              precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
},
          notifArticle(){
              let this1 = this
               setTimeout(function () { this1.Testopen.testnotifAdd = false }, 1000);
          },
          searchComptes(event){
             console.log(this.search);
             this.comptes.current_page=1;
             if(this.search === ""){
                //console.log('test2');
                    this.getcomptes();}
                else {
                     // console.log('test1');
                axios.get('/searchComptes/'+this.search+'?page='+this.comptes.current_page+'')
                .then((response) => {
                  
                    this.comptes = response.data.comptes;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
          },

            fetchData () {
      //this.error = this.post = null
      this.loading = true
      // replace `getPost` with your data fetching util / API wrapper
     this.anneeCheque = new Date().getFullYear();
     console.log('annéeeeee '+this.anneeCheque)
        this.getEtatCheque();
    },
      
           getEtatCheque(){
                axios.get('/getEtatCheque?page='+this.etatCheque.current_page+'',{params:{anneeCheque:this.anneeCheque}})
                .then((response) => {
                 // console.log('shit');
                    this.etatCheque = response.data.etatCheque;
                    this.charges= response.data.charges;
                    console.log('testttt ')
                   
                    if(response.data.totalAchats.length !=0){
                        console.log('dkhelll')
                    this.totalAchats = response.data.totalAchats[0].total;
                    }else this.totalAchats=0;
                    console.log('total == ')
                    console.log(this.totalAchats)
                    this.totalCharge = response.data.totalCharge[0].total;
                    var total = +this.totalAchats + +this.totalCharge;
                    this.totalCheque =  this.precisionRound(total,2)
                    console.log("etata cheque=============================")
                    console.log(this.etatCheque)
                  this.loading = false;
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
          getEtatChequeAchat(){
                   axios.get('/getEtatChequeAchat?page='+this.etatCheque.current_page+'',{params:{anneeCheque:this.anneeCheque,searchAchat:this.searchAchat}})
                .then((response) => {
                 // console.log('shit');
                    this.etatCheque = response.data.etatCheque;
                    console.log('ooooooook ')
                    console.log(response)
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
          
getEtatChequeCharge(){
           axios.get('/getEtatChequeCharge?page='+this.etatCheque.current_page+'',{params:{anneeCheque:this.anneeCheque,searchCharge:this.searchCharge}})
                .then((response) => {
                 // console.log('shit');
                    this.charges= response.data.charges;
                    console.log('ooooooook ')
                    console.log(response)
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
}



   

               
      },


      computed:{
       
       
     
     
            
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
    width: 241px;
    z-index: 100;
    top: 61px;
    right: 0;
    position:  absolute;
    position :fixed;
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



