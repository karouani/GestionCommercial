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
    <router-link class="float-right btn btn-secondary" :to="'/AddCharge'" ><i class="fas fa-plus-circle"/> Ajouter </router-link>

        </div>
  
    </div>
    <h3>Liste des Charges</h3>
    <hr>   
    </div> 

   

    <div class="row" >
             <div class="card">
                        <div class="card-header bg-light">
                            <div class="row btnMarge">
 
    <div class="col"  >
    <!-- button pour afficher formulaire de l'ajout d un Charge -->         
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="searchCharges"  class="form-control" v-model="search" placeholder="recherche par designation" aria-label="Username" aria-describedby="basic-addon1" >
            </div>
        </div> 
        
    </div>
                       </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>N° Facture</th>
                                        <th>Nom Fournisseur</th>
                                        <th>Désignation</th>
                                        <th>Date Limit Paiement</th>
                                        <th>Date Paiement</th>
                                        <th>Taux Tva</th>
                                        <th>Montant TTC</th>
                                        <th>Mode Paiement</th>

                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="charge of charges.data" :key="charge.id_charge" >
                                      
                                         <td>{{charge.num_facture_ch}} </td>
                                         <td>{{charge.nom_fournisseur_ch}} </td>
                                         <td>{{charge.designation_ch}} </td>
                                          <td>{{charge.date_limit_ch }} 
                                              <div v-if="charge.date_paiement_ch === null">
                                              <span v-if="charge.date_diff > 0" style="color:#83ea0cf7">
                                            (+{{charge.date_diff}})
                                            </span>
                                            <span v-if="charge.date_diff <= 0" style="color:red">
                                            ({{charge.date_diff}})
                                            </span>
                                              </div>
                                              </td>   
                                         <td>{{charge.date_paiement_ch}} </td>
                                         <td>{{charge.taux_tva_ch}} </td>
                                         <td>{{charge.montant_ttc_ch}} </td>
                                         <td>{{charge.mode_paiement_ch}} </td>
                                        
                                        <td  class="optionsWidth"> 
                                            <a href="#"    @click="getCharge(charge)"  class="btn btn-primary"  ><i class="fas fa-eye d-inline-block"></i></a>
                                         <a @click="EditCharge(charge)" class="btn btn-success"><i class="fas fa-edit d-inline-block"></i></a>
                                             <a @click="deleteCharge(charge)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a>                                
                                              <a @click="CopieCharge(charge)" class="btn btn-info"><i class="far fa-copy"></i></a></td>                                 

                                    </tr>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div>
              
                <b-modal ok-only  v-model="modalShow" no-fade
                :title="'N° Facture : '+charge.num_facture_ch"
                :body-bg-variant="+' '+modalShow+''+charge.num_facture_ch+''+charge.date_facture_ch+''+charge.nom_fournisseur_ch+''+charge.designation_ch+''+charge.montant_ht_ch+''+charge.taux_tva_ch+''+charge.tva_ch+''+charge.montant_ttc_ch+''+charge.mode_paiement_ch">
                 <div class="row" v-if="modalShow">
                      
                         <div class="col">
                   <span>Date Facture : </span>{{charge.date_facture_ch}}
                        <hr>
                   <span>Nom Fournisseur : </span>{{charge.nom_fournisseur_ch}} 
                   <hr>
                   <span>Designation : </span>{{charge.designation_ch}}
                   <hr>
                   <span>Support :  </span>{{charge.support_ch}}
                   <hr>
                   <span>Objet : </span>{{charge.objet_ch}}
                    <hr>
                     <span>Tva :  </span>{{charge.tva_ch}}
                   <hr>
                   <span>Taux Tva : </span>{{charge.montant_ttc_ch}}
              
                   </div>
                    
                   <div class="col">
                   <span>Mode Paiement : </span>{{charge.mode_paiement_ch}}
                   <hr>
                   <span>Type Delai : </span>{{charge.type_delai_ch}}
                   <hr>
                   <span>Date Limit : </span>{{charge.date_limit_ch}} 
                   <hr>
                   <span>Reference : </span>{{charge.reference_ch}}
                   <hr>
                   <span>Date Paiement : </span>{{charge.date_paiement_ch}} 
                   <hr>  
                     <span>Montant HT :  </span>{{charge.montant_ht_ch}}
                   <hr>
                   <span>Montant TTC : </span>{{charge.taux_tva_ch}}
                   
                   </div>                                   
                   
                     </div>
                    <div slot="modal-footer" class="w-100">
                    <p class="float-left"> </p>
                    <b-btn size="sm" class="float-right" variant="primary" @click="modalShow=false">
                    Fermer
                    </b-btn>
                </div>
                </b-modal>
            </div>
    </div>
    
    <vue-pagination  :pagination="charges"
                     @paginate="getCharges()"
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
                testnotifAdd : false,
             
              },
                charges:{
                      
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
                offset: 4,
                currentDate:"",

              charge: { 
                    
                    id_charge :0,
                    num_facture_ch:"",
                    date_facture_ch:"",
                    nom_fournisseur_ch:"",
                    designation_ch:"",
                    montant_ht_ch:"",
                    taux_tva_ch:"",
                    tva_ch:"",
                    montant_ttc_ch:"",
                    mode_paiement_ch:"",
                    reference_ch:"",
                    date_paiement_ch:"",
                    support_ch:"",
                    objet_ch:"",
                    type_delai_ch:"",
                    date_limit_ch:"",


                    date_diff:"",

              },
            
             
             
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
                       console.log("current date ******************")
                       console.log(this.currentDate); 

              if( this.$route.params.success == "add"){
             
                       // this.Testopen.testnotifAdd = true;                  
                                   this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Charge bien ajouter!',
                                      duration: 1500,
                                    });
          }
                    if( this.$route.params.success == "edit"){
             
                             this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Charge bien modifier!',
                                      duration: 1500,
                                    });
          }
        
        },
      updated(){
         
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
          notifCharge(){
              let this1 = this
               setTimeout(function () { this1.Testopen.testnotifAdd = false }, 1000);
          },
          searchCharges(event){
             console.log(this.search);
             this.charges.current_page=1;
             if(this.search === ""){
                //console.log('test2');
                    this.getCharges();}
                else {
                     // console.log('test1');
                axios.get('/searchCharges/'+this.search+'?page='+this.charges.current_page+'')
                .then((response) => {
                  
                    this.charges = response.data.charges;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
          },

            fetchData () {
      //this.error = this.post = null
      this.loading = true
      this.getCharges();
   
    },
          getCharges(){
                axios.get('/getCharges?page='+this.charges.current_page+'')
                .then((response) => {
                  console.log('shiiiiiiiiiiit');
                  console.log(response.data.charges)
                    this.charges = response.data.charges;
                     let that=this
                    this.charges.data.forEach(function(charge) {
              
                           charge.currentDateCharge = that.currentDate;
                        var startDate = Date.parse(charge.currentDateCharge);
                        var endDate = Date.parse(charge.date_limit_ch);
                        var timeDiff = endDate - startDate;
                        var daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                        charge.date_diff=daysDiff;
                    })
this.loading = false
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },

EditCharge(charge){
                     this.$router.push({ name: 'EditCharge', params: { charge:charge}});

},
CopieCharge(charge){
                     this.$router.push({ name: 'CopieCharge', params: { charge:charge}});

},


             deleteCharge:function(charge){


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
                            axios.delete('/deleteCharge/'+charge.id_charge).then(
                                        response => {
                                
                                            this.getCharges();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre Charge a été supprimé',
                        'success'
                        )
  }
})

        },
        getCharge:function(charge){
              
                  axios.get('/getCharge/'+charge.id_charge).then(
                  response => {
                       
                    this.charge= response.data.charge;
                   this.modalShow = !this.modalShow
                  });         
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
width : 171px;
min-width: 216px;

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



