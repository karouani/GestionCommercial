<template>
    <div class="post" >
      <!-- au cas ajout bien passé afficher ce message -->   
            
   
    <div class="loading" v-if="loading">
      Loading...
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
   
            <div v-if="Testopen.testnotifAdd" class="alert alert-success alert-dismissible fade show notifArticle" role="alert">
        <strong>Bon Commande bien ajouter !</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>

        <div v-if="Testopen.testnotifEdit" class="alert alert-success alert-dismissible fade show notifArticle" role="alert">
        <strong>Bon Commande bien modifier !</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    
    
  
    <hr>
    <!-- formulaire pour Ajouter un article -->
   
   <div>
    <div class="row">
        <div class="col">
    <b-btn v-b-modal.modalPrevent class="float-right btn btn-primary" ><i class="fas fa-plus-circle"/> Ajouter</b-btn>
    </div>
    </div>
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
                    <b-form-input  type="text" v-model="reference_bc" class="form-control" id="date" placeholder="" disabled/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">compte: </label>
                    <div class="col-sm-10">
                <select class="form-control custom-select " id="fk_compte" v-model="compte.id_compte" >
                    <option selected disabled>Choisir Client</option>
                    <option v-for="compte of comptes" :key="compte.id_compte" :value="compte.id_compte"> {{compte.nom_compte}} </option>
                </select>                    
                </div>
                </div>      
      
      </form>

    </b-modal>
  </div>
    
    <!-- fin formulaire -->
    <!-- afficher les articles sous formes des cards  -->

  


    <div class="row" id="testdiv">
             <div class="card">
                        <div class="card-header bg-light">
                            <div class="row btnMarge">
 
    <div class="col"  >
    <!-- button pour afficher formulaire de l'ajout d un article -->         
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="searchBonCommande"  class="form-control" v-model="search" placeholder="recherche par nom du Compte ou responsable " aria-label="Username" aria-describedby="basic-addon1" >
            </div>
        </div> 
        
    </div>
                       </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>reference</th>
                                        <th>date Bon commande</th>
                                        <th>date limit</th>
                                        <th>Montant TTC</th>
                                        <th>nom societe</th>
                                        <th>options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="bonCommande of bonCommandes.data" :key="bonCommande.id_bc" >
                                        <td>{{bonCommande.reference_bc}}</td>
                                        <td>{{bonCommande.date_bc}}</td>
                                        <td>{{bonCommande.date_limit_bc}}</td>
                                        <td>{{bonCommande.montant_ttc_bc}} </td>    
                                        <td>{{bonCommande.nom_compte}} </td>  
                                        <td  class="optionsWidth"> 
                                            <a href="#"    @click="redirect_To_ShowBonCommande(bonCommande.reference_bc)"  class="btn btn-primary" ><i class="fas fa-eye d-inline-block"></i></a>
                                         <router-link class="btn btn-success " :to="'/EditBonCommande/'+bonCommande.reference_bc"><i class="fas fa-edit d-inline-block"></i></router-link>
                                             <a @click="deleteBonCommande(bonCommande)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></td>                                 
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
    
    <vue-pagination  :pagination="bonCommandes"
                     @paginate="getBonCommandes()"
                     :offset="4">
    </vue-pagination>
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
              reference_bc: "",
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
              bonCommandes:{
                        
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
               bonCommande : { 
            id_bc:0,
            reference_bc:"",
            date_bc:"", 
            type_operation_bc:"",
            objet_bc:"",
            date_emission_bc:"",
            remise_total_bc:"",
            majoration_bc:"",
            date_limit_bc:"",
            introduction_bc:"",  
            conditions_reglements_bc:"",
            notes_bc:"",
            accompte_bc:"",
            adresse_bc:"",
            fk_status_bc:"",
            fk_compte_bc:"",
            fk_user_bc:"",
            total_ht_bc: 0,
            remise_ht_bc: 0,
            montant_net_bc: 0,
            tva_montant_bc: 0,
            montant_ttc_bc: 0,
      
              },
            
             
             
      }),
 
   
        mounted(){
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth(); 
            var yyyy = today.getFullYear();
             if(dd<10) 
                {
                    dd='0'+dd;
                } 

                if(mm<10) 
                {
                    mm='0'+mm;
                } 
            this.currentDate  = yyyy+'-'+mm+'-'+dd;
            this.countBonCommandes()
            console.log(this.currentDate);
            console.log('test date ')
            this.getClients();
          if( this.$route.params.success == "addsuccess"){
             
                        this.Testopen.testnotifAdd = true;
          }
                    if( this.$route.params.success == "editsuccess"){
             
                        this.Testopen.testnotifEdit = true;
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

           countBonCommandes(){

                axios.get('/countBonCommandes')
                .then((response) => {

                    this.reference_bc='BC'+response.data.count;
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
          searchBonCommande(event){
             console.log(this.search);
             this.bonCommandes.current_page=1;
             if(this.search === ""){
                //console.log('test2');
                    this.getBonCommandes();}
                else {
                     // console.log('test1');
                axios.get('/searchBonCommande/'+this.search+'?page='+this.bonCommandes.current_page+'')
                .then((response) => {
                  console.log('serchhhh ')
                  console.log(response.data.boncommandes)
                    this.bonCommandes = response.data.boncommandes;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
          },

            fetchData () {
      //this.error = this.post = null
      this.loading = true
      // replace `getPost` with your data fetching util / API wrapper
  console.log("getBC mazal ")
   this.getBonCommandes();

    },
          getBonCommandes(){
               axios.get('/getBonCommandes?page='+this.bonCommandes.current_page+'')
                .then((response) => {
                  this.loading = false;
                    this.bonCommandes = response.data.bonCommandes;
                  
                  console.log(response.data.bonCommandes)
                  console.log("getBC oook ")
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },




             deleteBonCommande:function(bonCommande){


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
                            axios.delete('/deleteBonCommande/'+bonCommande.id_bc).then(
                                        response => {
                                
                                            this.getBonCommandes();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre compte a été supprimé',
                        'success'
                        )
  }
})

        },

                redirect_To_ShowBonCommande(reference_bc){
                     this.$router.push('/ShowBonCommande/'+reference_bc);
            },

         /*   generatePdfHtml(){
                let doc = new this.$Jspdf();
                
                doc.fromHTML(window.$('#testdiv').get(0));
                //doc.text(20,20,'test pdf ');
                doc.save('test.pdf')
            }*/
            handleOk(){
                    this.$router.push({ name: 'addBonCommande', params: { id_compte: this.compte.id_compte ,reference_bc: this.reference_bc, currentDate: this.currentDate  }});

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
    width: 295px;
    z-index: 100;
    top: 61px;
    right: 0;
    position:  absolute;
    position :fixed;
}

</style>



