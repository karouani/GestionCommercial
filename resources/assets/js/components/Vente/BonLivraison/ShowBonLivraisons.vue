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
   <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
    <!-- button pour afficher tous les users-->
    <b-btn v-b-modal.modalPrevent class="float-right btn btn-primary" ><i class="fas fa-plus-circle"/> Ajouter</b-btn>

        </div>
  
    </div>
    <h3>Liste des Bons de Livraisons</h3>
    <hr>   
    </div>
    
  
  
   <div>
   
    <!-- Main UI -->
    <div class="mt-3 mb-3">
     
   
    </div>
    <!-- Modal Component -->
    <b-modal id="modalPrevent"
             ref="modal"
             title="+ Bon de Commande"
             @ok="handleOk"
             @shown="clearName"
             ok-title="Enregister" >
      <form @submit.stop.prevent="handleSubmit">


                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">date: </label>
                    <div class="col-sm-10">
                    <input  type="date" v-model="currentDate" class="form-control" id="date" placeholder="Password"/>
                    </div>
                </div>                 
                <div class="form-group row">
                    <label for="reference" class="col-sm-2 col-form-label">Référence: </label>
                    <div class="col-sm-10">
                    <b-form-input  type="text" v-model="bonLivraison.reference_bl" class="form-control" id="date" placeholder="" disabled/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">compte: </label>
                    <div class="col-sm-10">
            <multiselect v-model="compte" :options="comptes" placeholder="Choisir un client" label="nom_compte"></multiselect>
                   
                </div>
                </div>      
      
      </form>

    </b-modal>
  </div>
    
    <!-- fin formulaire -->
    <!-- afficher les articles sous formes des cards  -->

  


    <div class="row" >
             <div class="card">
                        <div class="card-header bg-light">
                            <div class="row btnMarge">
 <div class="col">
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="number" @keyup.enter="getBonLivraisons"  class="form-control" v-model="anneeBL" placeholder="recherche par année " aria-label="Username" aria-describedby="basic-addon1" >
            </div>  
                                </div> 
    <div class="col"  >
    <!-- button pour afficher formulaire de l'ajout d un article -->         
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="searchBonLivraison"  class="form-control" v-model="search" placeholder="recherche par nom du Compte ou responsable " aria-label="Username" aria-describedby="basic-addon1" >
            </div>
        </div> 
        
    </div>
                       </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Référence</th>
                                        <th>Nom Société</th>                                      
                                        <th>Date Bon livraison</th>
                                        <th>Date limit</th>
                                        <th>Statut</th> 
                                        <th>Montant TTC</th>
                                        <th>Net à payer</th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="bonLivraison of bonLivraisons.data" :key="bonLivraison.id_bl" >
    
                                        <td>{{bonLivraison.reference_bl}}</td>
                                        <td>{{bonLivraison.nom_compte}} </td>  
                                        <td>{{bonLivraison.date_bl}}</td>
                                        <td>{{bonLivraison.date_limit_bl}}
                                                 <div v-if="bonLivraison.type_status !='validé' && bonLivraison.type_status !='annulée'"> 
                                          
                                             <span v-if="bonLivraison.date_diff > 0" style="color:#83ea0cf7">
                                            (+{{bonLivraison.date_diff}})
                                            </span>
                                            <span v-if="bonLivraison.date_diff <= 0" style="color:red">
                                            ({{bonLivraison.date_diff}})
                                            </span>
                                                 </div>
                                        </td>
                                              <td v-if="bonLivraison.fk_status_bl == 'Brouillon'">
                                            
                                             <span class="badge badge-pill" style="background-color:rgb(170, 170, 170);color:white;font-size:14px"> <b>{{bonLivraison.fk_status_bl}} </b></span> </td>
                                         <td  v-else>   
                                             <span class="badge badge-pill" :style="{'background-color': bonLivraison.colorStatu ,'color':fontStatu.white , 'font-size':fontStatu.size}"> <b>{{bonLivraison.type_status}} </b></span> </td>
                                        <td>{{bonLivraison.montant_ttc_bl}} </td>  
                                        <td>{{bonLivraison.montant_reste_bl}} </td>  
                                       
                                        <td  class="optionsWidth"> 
                                            <a href="#"    @click="redirect_To_ShowBonLivraison(bonLivraison.reference_bl)"  class="btn btn-primary" ><i class="fas fa-eye d-inline-block"></i></a>
                                            <a href="#"    @click="PdfBonLivraison(bonLivraison.reference_bl)"  class="btn btn-secondary" ><i class="far fa-file-pdf"></i></a>
                                            

                                     <a href="#"  @click="redirect_To_EditBonLivraison(bonLivraison)" class="btn btn-success"><i class="fas fa-edit d-inline-block"></i></a>                                

                                             <a href="#"  @click="deleteBonLivraison(bonLivraison)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></td>                                 
                                    </tr>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div>
              
            </div>
    </div>
    
    <vue-pagination  :pagination="bonLivraisons"
                     @paginate="getBonLivraisons()"
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
               nbrBLs:0,
               year:"",
              fontStatu : {
                    white : "white",
                    size: "14px"
              },
              
              ninjas: "hello ninjas ",
              datahidden: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, eius?",
              reference_bl: "",
              currentDate : "",
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
              bonLivraisons:{
                        
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
              comptes: [],
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
                    adresse_compte:""
              },
               bonLivraison : { 
            id_bl:0,
            reference_bl:"",
            date_bl:"", 
            type_operation_bl:"",
            objet_bl:"",
            date_emission_bl:"",
            remise_total_bl:"",
            majoration_bl:"",
            date_limit_bl:"",
            introduction_bl:"",  
            conditions_reglements_bl:"",
            notes_bl:"",
            accompte_bl:"",
            adresse_bl:"",
            fk_status_bl:"",
            fk_compte_bl:"",
            fk_user_bl:"",
            total_ht_bl: 0,
            remise_ht_bl: 0,
            montant_net_bl: 0,
            tva_montant_bl: 0,
            montant_ttc_bl: 0,
            date_diff: "",
      
              },
            
             anneeBL:"",
             
      }),
 
   
        mounted(){
                                                this.anneeBL = new Date().getFullYear();

            this.currentDate  = this.DataCourant();
            this.countBonLivraisons()
            console.log(this.currentDate);
            console.log('test date ')
            this.getClients();
          if( this.$route.params.success == "addsuccess"){
             
                                       this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Bon de livraison bien ajouter!',
                                      duration: 1500,
                                    });
          }
                    if( this.$route.params.success == "editsuccess"){
             
                                    this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Bon de livraison bien modifier!',
                                      duration: 1500,
                                    });
          }
          if( this.$route.params.success == "editStatusuccess"){
        
                                               this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Statut bien modifier!',
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
                 'currentDate': function(){
      console.log("current date")
  var today = new Date(this.currentDate);
                    var yyyy = today.getFullYear();             
                    this.year  = yyyy;
                     this.bonLivraison.reference_bl='BL-'+this.year+'-'+this.nbrBLs;

     },
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
          DataCourant(){
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() +1; 
            var yyyy = today.getFullYear();
             if(dd<10) 
                {
                    dd='0'+dd;
                } 

                if(mm<10) 
                {
                    mm='0'+mm;
                } 
           return  yyyy+'-'+mm+'-'+dd;
          },

          PdfBonLivraison(reference_bl){
                           
                //   window.location.href='/pdf/'+reference_bl
                  window.open('/pdfBL/'+reference_bl,'_blank');
          },

         getClients(){
                axios.get('/getClients')
                .then((response) => {
                    this.comptes = response.data.comptes;
                    console.log(response.data.comptes);
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },

           countBonLivraisons(){

                axios.get('/countBonLivraisons',{params: { type_operation_bl: 'vente' } })
                .then((response) => {
                     var today = new Date();
                    var yyyy = today.getFullYear();             
                    var year  = yyyy;
                     this.nbrBLs = response.data.count;
                    this.bonLivraison.reference_bl='BL-'+year+'-'+this.nbrBLs;

                    
                    /*this.commande.fk_document='D'+response.data.count;
                    this.modePaiement.fk_document='D'+response.data.count;*/

                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
          notifArticle(){
              let this1 = this
               setTimeout(function () { this1.Testopen.testnotifAdd = false }, 1000);
          },
          searchBonLivraison(event){
             console.log(this.search);
             this.bonLivraisons.current_page=1;
             if(this.search === ""){
                //console.log('test2');
                    this.getBonLivraisons();}
                else {
                     // console.log('test1');
                axios.get('/searchBonLivraison/'+this.search+'?page='+this.bonLivraisons.current_page+'',{params: { type_operation_bl: 'vente',anneeBL:this.anneeBL } })
                .then((response) => {
                 // console.log('serchhhh ')
                 // console.log(response.data.boncommandes)
                    this.bonLivraisons = response.data.bonlivraisons;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
          },

            fetchData () {
      //this.error = this.post = null
      this.loading = true
                                       this.anneeBL = new Date().getFullYear();

      // replace `getPost` with your data fetching util / API wrapper
  console.log("getBL mazal ")
   this.getBonLivraisons();

    },
          getBonLivraisons(){
               axios.get('/getBonLivraisons?page='+this.bonLivraisons.current_page+'',{params: { type_operation_bl: 'vente',anneeBL:this.anneeBL } })
                .then((response) => {
                  this.loading = false;
                    this.bonLivraisons = response.data.bonLivraisons;
                    let that=this
                    this.bonLivraisons.data.forEach(function(bonLivraison) {
              
                          // bonLivraison.currentDateDevi = that.currentDate;
                        var startDate = Date.parse(that.currentDate);
                        var endDate = Date.parse(bonLivraison.date_limit_bl);
                        var timeDiff = endDate - startDate;
                        var daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                        bonLivraison.date_diff=daysDiff;
                    })
                  console.log(response.data.bonLivraisons)
                  console.log("getBL oook ")
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },




             deleteBonLivraison:function(bonLivraison){


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
                            axios.delete('/deleteBonLivraison/'+bonLivraison.id_bl).then(
                                        response => {
                                
                                            this.getBonLivraisons();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre compte a été supprimé',
                        'success'
                        )
  }
})

        },

                redirect_To_ShowBonLivraison(reference_bl){
                     this.$router.push('/ShowBonLivraison/'+reference_bl);
            },
            redirect_To_EditBonLivraison(boncommande){
                   //  this.$router.push('/ShowBonLivraison/'+reference_bl);
                     this.$router.push({ name: 'EditBonLivraison', params: { reference_bl: boncommande.reference_bl, fk_compte_bl: boncommande.fk_compte_bl}});

            },

            
            handleOk(){
                console.log('id compte : '+this.compte.id_compte);
                    this.$router.push({ name: 'addBonLivraison', params: { id_compte: this.compte.id_compte ,reference_bl: this.bonLivraison.reference_bl, currentDate: this.currentDate  }});

            },
            
               clearName(){

               },
            handleSubmit(){

            }
      },


      computed:{
       
       
     
     
            
      }, 

      
       
        
      

    }
    
</script>

<style scoped>
 .btnMarge{
     padding-bottom: 10px;
 }
.shadawTr:hover {
  box-shadow: 1px 1px 1px 1px #888888;
    }
thead{
    background-color: #efefef;
}
.optionsWidth{
width : 230px;
min-width: 230px;

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
    width: 295px;
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



