<template>
    <div>
      <!-- au cas ajout bien passé afficher ce message -->   
            
   
    <div class="loading" v-if="loading">
          <div class="lds-hourglass"></div>

    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
       
    <!-- formulaire pour Ajouter un article -->
    
    <!-- fin formulaire -->
    <!-- afficher les articles sous formes des cards  -->

    <div class="row" >
             
                        <div class="card-header">
                           
 
                               
                                <!-- button pour afficher formulaire de l'ajout d un article -->         
                                            <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                        </div>
                                        <input type="text" @keyup.enter="searchBonCommande"  class="form-control widthSeach" v-model="search" placeholder="recherche par nom du Compte ou responsable " aria-label="Username" aria-describedby="basic-addon1" >
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
                                        <th>Statut</th>
                                        <th>options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="bonCommande of bonCommandes.data" :key="bonCommande.id_bc" >
                                        <td>{{bonCommande.reference_bc}}</td>
                                        <td>{{bonCommande.date_bc}}</td>
                                        <td>{{bonCommande.date_limit_bc}}</td>
                                        <td>{{bonCommande.montant_ttc_bc}} </td>  
                                              <td v-if="bonCommande.fk_status_bc == 'Brouillon'">
                                            
                                             <span class="badge badge-pill" style="background-color:rgb(170, 170, 170);color:white;font-size:14px"> <b>{{bonCommande.fk_status_bc}} </b></span> </td>
                                         <td  v-else>   
                                             <span class="badge badge-pill" :style="{'background-color': bonCommande.colorStatu ,'color':fontStatu.white , 'font-size':fontStatu.size}"> <b>{{bonCommande.type_status}} </b></span> </td>
            
                                       
                                        <td  class="optionsWidth"> 
                                            <a href="#"    @click="redirect_To_ShowBonCommande(bonCommande.reference_bc)"  class="btn btn-primary" ><i class="fas fa-eye d-inline-block"></i></a>
                                            <a href="#"    @click="PdfBonCommande(bonCommande.reference_bc)"  class="btn btn-secondary" ><i class="far fa-file-pdf"></i></a>
                                            
                                        </td>                                 
                                    </tr>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    </div>
                                    </tbody>
                                </table>
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
         props: ['idCompte'],

          data: () => ({
              
              fontStatu : {
                    white : "white",
                    size: "14px"
              },
              
              ninjas: "hello ninjas ",
              datahidden: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, eius?",
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

              console.log('----- verifie ---- ');
              console.log(this.idCompte);
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

          PdfBonCommande(reference_bc){
                           
                //   window.location.href='/pdf/'+reference_bc
                  window.open('/pdf/'+reference_bc,'_blank');
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
            
               axios.get('/getBonCommandesCompte/'+this.idCompte+'?page='+this.bonCommandes.current_page+'')
                .then((response) => { 
                 
                  this.loading = false;
                    this.bonCommandes = response.data.bonCommandes;
                    console.log("-------bon COmmandes compte-----------")
                  console.log(this.bonCommandes.data.length);
                 this.$emit('CountBC',this.bonCommandes.data.length)
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },




        

                redirect_To_ShowBonCommande(reference_bc){
                     this.$router.push('/ShowBonCommande/'+reference_bc);
            },
          

            
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

.widthSeach{
    width: 310px
}
</style>



