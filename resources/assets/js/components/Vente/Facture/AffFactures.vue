<template>
    <div >
      <!-- au cas ajout bien passé afficher ce message -->   
        <h5>Factures</h5>    
           
    <div class="loading" v-if="loading">
          <div class="lds-hourglass"></div>
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
    
    <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testAjout">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Facture Bien Ajouter !</strong>
</div>
  <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testEdit">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Facture Bien Modifier !</strong>
</div>

        <div class="row">
 <div class="col">
    <!-- button pour afficher formulaire de l'ajout d un compagnie -->  
              <b-btn v-b-modal.modalPrevent class="float-right btn btn-primary"><i class="fas fa-plus-circle"/> Ajouter</b-btn>
        </div>
        </div>
    <hr>
    <!-- formulaire pour Ajouter un facture -->
   
   
    
    <!-- fin formulaire -->
    <!-- afficher les factures sous formes des cards  -->
    <div class="row" >
             <div class="card">
                        <div class="card-header bg-light">
                            <div class="row btnMarge">
  <div class="col"  >
    <!-- button pour afficher formulaire de l'ajout d un article -->         
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="searchFacture"  class="form-control" v-model="search" placeholder="recherche par Compte ou Reference  " aria-label="Username" aria-describedby="basic-addon1" >
            </div>
        </div> 
         <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         </div>
    </div>
                       </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Reference</th>
                                        <th>Nom Societe </th>
                                        <th>Date facture</th>
                                        <th>Date limit</th>
                                        <th>Status</th>                                        
                                        <th>Montant TTC</th>
                                        <th>Net à payer</th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="facture of factures.data" :key="facture.id_facture" >
                                        <td>{{facture.reference_f}}</td>
                                        <td>{{facture.nom_compte}} </td>
                                        <td>{{ facture.date_f}}</td>
                                       <td>{{facture.date_limit_f}} 
                                            <span v-if="facture.date_diff > 0" style="color:#83ea0cf7">
                                            (+{{facture.date_diff}})
                                            </span>
                                            <span v-if="facture.date_diff <= 0" style="color:red">
                                            ({{facture.date_diff}})
                                            </span>
                                        </td>
                                        <td v-if="facture.fk_status_f == 'Brouillon'">
                                            
                                           <span class="badge badge-pill" style="background-color:rgb(170, 170, 170);color:white;font-size:14px"> {{facture.fk_status_f}}</span> </td>
                                         <td v-else>   
                                             <span class="badge badge-pill" :style="{'background-color': facture.colorStatu ,'color':fontStatu.white , 'font-size':fontStatu.size}"> {{facture.type_status}} </span></td>
                                        <td>{{facture.montant_ttc_f}} </td> 
                                        <td>{{facture.montant_reste_f}} </td> 
                                       <td  class="optionsWidth"> 
                                            <a href="#"    @click="redirect_To_FactureDetails(facture)"  class="btn btn-primary" ><i class="fas fa-eye d-inline-block"></i></a>
                                            <a href="#"    @click="PdfFactures(facture.reference_f)"  class="btn btn-secondary" ><i class="far fa-file-pdf"></i></a>
<!--
                                         <router-link class="btn btn-success " :to="'/EditFacture/'+facture.id_facture ">
                                         -->
                               <a href="#"    @click="redirect_To_EditFacture(facture)"  class="btn btn-success" >

                                         <i class="fas fa-edit d-inline-block"></i></a>
                                             <a @click="deleteFacture(facture)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></td>                                 
                                    </tr>
                                   
                                    </tbody>
                                </table>
                            </div>
                        </div>
 <div>
  
    <!-- Modal Component -->
    <b-modal id="modalPrevent"
             ref="modal"
             title="+ Facture"
             @ok="handleOk"
             ok-title="Enregistrer"
             @shown="clearName">
             
      <form @submit.stop.prevent="handleSubmit">

<div class="form-group row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">date: </label>
                    <div class="col-sm-9">
                    <input  type="date" v-model="currentDate" class="form-control" id="date" placeholder="Password"/>
                    </div>
                </div>                 
                <div class="form-group row">
                    <label for="reference_f" class="col-sm-3 col-form-label">Référence: </label>
                    <div class="col-sm-9">
                    <b-form-input  type="text" v-model="facture.reference_f" class="form-control" id="date" placeholder="" disabled/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">compte: </label>
                    <div class="col-sm-9">
                <select class="form-control custom-select " id="fk_compte" v-model="facture.fk_compte_f" v-on:change="getClients" >
                    <option selected disabled>Choisir Client</option>
<option v-for="compte in comptes" :key="compte.id_compte" :value="compte.id_compte">
          {{compte.nom_compte}}
        </option>       
                 </select>   
            </div>
                
        </div>   
 </form>
    </b-modal>
  </div>
                 
                    </div>
                   
    </div>
    
    <vue-pagination  :pagination="factures"
                     @paginate="getFactures()"
                     :offset="4">
    </vue-pagination>
    </div>
    <!-- fin affiche -->
    </div>
</template>



<script>
import  Pagination from '../../Pagination.vue';

    export default{
         components:{
            'vue-pagination':Pagination,
         },

          data: () => ({
                        fontStatu : {
                    white : "white",
                    size: "14px"
              },
                     loading: false,
                     error: null,
                     test1 : {
                  searchQuery: 0,
                   calculee: 0,
                  },
      post: null,
      
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
                testEdit : false,

              },
              // tester l ajout si bien fais 
              
              // tester  si affiche articles  ou afficher ajouter article 
              
              // initialisation d un article 
              factures:{
                        
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
               offset: 4,
                currentDate:"",
              facture: { 
                    
            id_facture:0,
            reference_f:"",
            date_f:"", 
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
            montant_reste_f:"",
           fk_status_f:"",
           fk_compte_f:"",
            fk_user_f:"",

            nom_compte:"",
            date_diff:"",
            startDate:"",
            endDate :"",
            timeDiff:"",
              },
            
             comptes:[],
             
      }),
      mounted(){
         
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
                        console.log(this.currentDate); 

        this.getFactures();
        this.getClients();
          this.countFactures();
          
           if(this.$route.params.success == "add"){
            this.Testopen.testAjout =true;}
   if(this.$route.params.success == "edit"){
            this.Testopen.testEdit =true; }
    
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
    updated(){
        if( this.$route.params.success == "add"){
          let that = this
              setTimeout(function(){that.Testopen.testAjout = false;}, 2000);
        }
        if( this.$route.params.success == "edit"){
         let that=this;
              setTimeout(function(){that.Testopen.testEdit = false;}, 2000);
        }
    },

      methods: {
    PdfFactures(reference_f){
                           
                //   window.location.href='/pdf/'+reference_bc
                  window.open('/pdf_f/'+reference_f,'_blank');
          },
    handleOk(){
        this.$router.push({ name: 'addFacture', params: { id_compte: this.facture.fk_compte_f ,reference_f: this.facture.reference_f ,currentDate: this.currentDate }});

            },
             clearName(){

               },
            handleSubmit(){

            },
            redirect_To_EditFacture(facture){
                   //  this.$router.push('/ShowBonCommande/'+reference_bc);
                     this.$router.push({ name: 'EditFacture', params: {id_facture: facture.id_facture, reference_f: facture.reference_f, fk_compte_f: facture.fk_compte_f}});

            },
               redirect_To_FactureDetails(facture){
                    this.$router.push({ name: 'FactureDetails', params: {id_facture: facture.id_facture, reference_f: facture.reference_f}});

                    // this.$router.push('/FacturesDetails/'+reference_f);
            },
                   fetchData () {
      //this.error = this.post = null
      this.loading = true
      // replace `getPost` with your data fetching util / API wrapper
   this.getFactures();

    },
countFactures(){

                axios.get('/countFactures',{params: { type_operation_f: 'vente' } })
                .then((response) => {

                   var today = new Date();
                    var yyyy = today.getFullYear();             
                    var year  = yyyy;
                    this.facture.reference_f='F-'+year+'-'+response.data.count;
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
          getFactures(){//type_status
                axios.get('/getFactures?page='+this.factures.current_page+'',{params: { type_operation_f: 'vente' } })
                .then((response) => {
                    this.loading = false;
                    this.factures = response.data.factures;
                     let that=this
                    this.factures.data.forEach(function(facture) {
              
                           facture.currentDateFacture = that.currentDate;
                        var startDate = Date.parse(facture.currentDateFacture);
                        var endDate = Date.parse(facture.date_limit_f);
                        var timeDiff = endDate - startDate;
                        var daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                        facture.date_diff=daysDiff;
                    })
                    //console.log(response.data.factures);
               })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
          getClients(){
                axios.get('/getClients')
                .then((response) => {
                    this.comptes = response.data.comptes;
                    //console.log(response.data.comptes);
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
           searchFacture(event){
             console.log(this.search);
             this.factures.current_page=1;
             if(this.search === ""){
                //console.log('test2');
                    this.getFactures();}
                else {
                     // console.log('test1');
                axios.get('/searchFactures/'+this.search+'?page='+this.factures.current_page+'',{params: { type_operation_f: 'vente' } })
                .then((response) => {
                  console.log('serchhhh ')
                  console.log(response.data.factures)
                    this.factures = response.data.factures;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
          },
       deleteFacture(facture){


                        this.$swal({
                        title: 'Etes-vous sur?',
                        text: "Vous ne serez pas capable de revenir a cela!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, supprimez-le!'
                                                }).then((result) => {
                        if (result.value) {
                            axios.delete('/deleteFacture/'+facture.id_facture).then(
                                        response => {
                                
                                            this.getFactures();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre compte a été supprimé',
                        'success'
                        )
  }
})

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
width : 230px;

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