<template>
    <div >
           
             <notifications group="foo" 
      position="bottom right" 
      classes="vue-notification success"/> 
      <!-- au cas ajout bien passé afficher ce message -->   
            <h5>Avoir facture</h5>
           
    <div class="loading" v-if="loading">
          <div class="lds-hourglass"></div>
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">


        <div class="row">
 <div class="col">
    <!-- button pour afficher formulaire de l'ajout d un compagnie -->  
              <b-btn v-b-modal.modalPrevent class="float-right btn btn-primary"><i class="fas fa-plus-circle"/> Ajouter</b-btn>
        </div>
        </div>
    <hr>
    <!-- formulaire pour Ajouter un avoirFacture -->
   
   
    
    <!-- fin formulaire -->
    <!-- afficher les avoirFactures sous formes des cards  -->
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
            <input type="text" @keyup.enter="searchAvoirFactures"  class="form-control" v-model="search" placeholder="recherche par Compte ou Reference  " aria-label="Username" aria-describedby="basic-addon1" >
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
                                        <th>Date Avoir Facture</th>
                                        <th>Date limit</th>
                                        <th>Status</th>                                        
                                        <th>Montant TTC</th>
                                        <th>Net à payer</th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="avoirFacture of avoirFactures.data" :key="avoirFacture.id_af" >
                                        <td>{{avoirFacture.reference_af}}</td>
                                        <td>{{avoirFacture.nom_compte}} </td>
                                        <td>{{ avoirFacture.date_af}}</td>
                                       <td>{{avoirFacture.date_limit_af}} 
                                            <span v-if="avoirFacture.date_diff > 0" style="color:#83ea0cf7">
                                            (+{{avoirFacture.date_diff}})
                                            </span>
                                            <span v-if="avoirFacture.date_diff <= 0" style="color:red">
                                            ({{avoirFacture.date_diff}})
                                            </span>
                                        </td>
                                        <td v-if="avoirFacture.fk_status_af == 'Brouillon'">
                                            
                                           <span class="badge badge-pill" style="background-color:rgb(170, 170, 170);color:white;font-size:14px"> {{avoirFacture.fk_status_af}}</span> </td>
                                         <td v-else>   
                                             <span class="badge badge-pill" :style="{'background-color': avoirFacture.colorStatu ,'color':fontStatu.white , 'font-size':fontStatu.size}"> {{avoirFacture.type_status}} </span></td>
                                        <td>{{avoirFacture.montant_ttc_af}} </td> 
                                        <td>{{avoirFacture.montant_reste_af}} </td> 
                                       <td  class="optionsWidth"> 
                                            <a href="#"    @click="redirect_To_AvoirFactureDetails(avoirFacture)"  class="btn btn-primary" ><i class="fas fa-eye d-inline-block"></i></a>
                                            <a href="#"    @click="PdfAvoirFactures(avoirFacture.reference_af)"  class="btn btn-secondary" ><i class="far fa-file-pdf"></i></a>
<!--
                                         <router-link class="btn btn-success " :to="'/EditavoirFacture/'+avoirFacture.id_af ">
                                         -->
                               <a href="#"    @click="redirect_To_EditAvoirFacture(avoirFacture)"  class="btn btn-success" >

                                         <i class="fas fa-edit d-inline-block"></i></a>
                                             <a @click="deleteAvoirFacture(avoirFacture)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></td>                                 
                                    </tr>
                                   
                                    </tbody>
                                </table>
                            </div>
                        </div>
 <div>
  
    <!-- Modal Component -->
    <b-modal id="modalPrevent"
             ref="modal"
             title="+ Avoir Facture"
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
                    <label for="reference_af" class="col-sm-3 col-form-label">Référence: </label>
                    <div class="col-sm-9">
                    <b-form-input  type="text" v-model="avoirFacture.reference_af" class="form-control" id="date" placeholder="" disabled/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">compte: </label>
                    <div class="col-sm-9">
            <multiselect v-model="compte" :options="comptes" placeholder="Choisir un client" label="nom_compte"></multiselect>

            </div>
                
        </div>   
 </form>
    </b-modal>
  </div>
                 
                    </div>
                   
    </div>
    
    <vue-pagination  :pagination="avoirFactures"
                     @paginate="getAvoirFactures()"
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
                    adresse_compte:"",
                    fk_compagnie : "",
              },
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
              avoirFactures:{
                        
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
               offset: 4,
                currentDate:"",
              avoirFacture: { 
                    
            id_af:0,
            reference_af:"",
            date_af:"", 
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
            montant_reste_af:"",
           fk_status_af:"",
           fk_compte_af:"",
            fk_user_af:"",

            nom_compte:"",
            date_diff:"",
            startDate:"",
            endDate :"",
            timeDiff:"",
              },
            
             comptes:[],
             
      }),
      mounted(){
               if( this.$route.params.success == "add"){
                                   this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Avoir Facture bien ajouter!',
                                      duration: 1500,
                                    });
        }
        if( this.$route.params.success == "edit"){
        
                                               this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Avoir Facture bien modifier!',
                                      duration: 1500,
                                    });
        }
         
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

        this.getAvoirFactures();
        this.getClients();
          this.countAvoirFactures();
          
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
 
    },

      methods: {
    PdfAvoirFactures(reference_af){
                           
                //   window.location.href='/pdf/'+reference_bc
                  window.open('/pdf_af/'+reference_af,'_blank');
          },
    handleOk(){
        this.$router.push({ name: 'addAvoirFacture', params: { id_compte: this.compte.id_compte ,reference_af: this.avoirFacture.reference_af ,currentDate: this.currentDate }});

            },
             clearName(){

               },
            handleSubmit(){

            },
            redirect_To_EditAvoirFacture(avoirFacture){
                   //  this.$router.push('/ShowBonCommande/'+reference_bc);
                     this.$router.push({ name: 'EditAvoirFacture', params: {id_af: avoirFacture.id_af, reference_af: avoirFacture.reference_af, fk_compte_af: avoirFacture.fk_compte_af}});

            },
               redirect_To_AvoirFactureDetails(avoirFacture){
                    this.$router.push({ name: 'AvoirFactureDetails', params: {id_af: avoirFacture.id_af, reference_af: avoirFacture.reference_af}});

                    // this.$router.push('/AvoirFacturesDetails/'+reference_af);
            },
                   fetchData () {
      //this.error = this.post = null
      this.loading = true
      // replace `getPost` with your data fetching util / API wrapper
   this.getAvoirFactures();

    },
countAvoirFactures(){

                axios.get('/countAvoirFactures',{params: { type_operation_af: 'vente' } })
                .then((response) => {

                   var today = new Date();
                    var yyyy = today.getFullYear();             
                    var year  = yyyy;
                    this.avoirFacture.reference_af='AF-'+year+'-'+response.data.count;
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
          getAvoirFactures(){//type_status
                axios.get('/getAvoirFactures?page='+this.avoirFactures.current_page+'',{params: { type_operation_af: 'vente' } })
                .then((response) => {
                    this.loading = false;
                    this.avoirFactures = response.data.avoirFactures;
                     let that=this
                    this.avoirFactures.data.forEach(function(avoirFacture) {
              
                          // avoirFacture.currentDateFacture = that.currentDate;
                        var startDate = Date.parse(that.currentDate);
                        var endDate = Date.parse(avoirFacture.date_limit_af);
                        var timeDiff = endDate - startDate;
                        var daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                        avoirFacture.date_diff=daysDiff;
                    })
                    //console.log(response.data.avoirFactures);
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
           searchAvoirFactures(event){
             console.log(this.search);
             this.avoirFactures.current_page=1;
             if(this.search === ""){
                //console.log('test2');
                    this.getAvoirFactures();}
                else {
                     // console.log('test1');
                axios.get('/searchAvoirFactures/'+this.search+'?page='+this.avoirFactures.current_page+'',{params: { type_operation_af: 'vente' } })
                .then((response) => {
                  console.log('serchhhh ')
                  console.log(response.data.avoirFactures)
                    this.avoirFactures = response.data.avoirFactures;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
          },
       deleteAvoirFacture(avoirFacture){


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
                            axios.delete('/deleteAvoirFacture/'+avoirFacture.id_af).then(
                                        response => {
                                
                                            this.getAvoirFactures();
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