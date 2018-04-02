<template>
    <div >
      <!-- au cas ajout bien passé afficher ce message -->   
            
           
    <div class="loading" v-if="loading">
      Loading...
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
   
    <hr>
    <!-- formulaire pour Ajouter un devi -->
   
   
    
    <!-- fin formulaire -->
    <!-- afficher les devis sous formes des cards  -->
    <div class="row" >
             <div class="card">
                        <div class="card-header bg-light">
                            <div class="row btnMarge">
 
        
    </div>
                       </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>reference</th>
                                        <th>date devis</th>
                                        <th>date limit</th>
                                        <th>Quantite:</th>
                                        <th>Nom Societe </th>
                                        <th>options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="devi of devis.data" :key="devi.id_devis" >
                                        <td>{{devi.reference_d}}</td>
                                        <td>{{ devi.date_d}}</td>
                                        <td>{{devi.date_limit_d}}</td>
                                        <td>{{devi.type_operation}} </td> 
                                        <td>{{devi.fk_compte_d}} </td>
                                        
                                       <td  class="optionsWidth"> 
                                            <router-link class="btn btn-primary " :to="'/DetailsDevis/'+devi.id_devis "><i class="fas fa-eye d-inline-block"></i></router-link>
                                         <router-link class="btn btn-success " :to="'/EditDevis/'+devi.id_devis "><i class="fas fa-edit d-inline-block"></i></router-link>
                                             <a class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></td>                                 
                                    </tr>
                                   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div>
              
            </div>
    </div>
    
    <vue-pagination  :pagination="devis"
                     @paginate="getDevis()"
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
              devis:{
                        
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
               offset: 4,


              devi: { 
                    
                       id_devis:0,
            reference_d:"",
            date_d:"", 
            type_operation:"",
            objet_d:"",
            date_emission_d:"",
            remise_total_d:"",
            majoration_d:"",
            date_limit_d:"",
            introduction_d:"",  
            conditions_reglements_d:"",
            notes_d:"",
            accompte_d:"",
           fk_status_d:"",
           fk_compte_d:"",
            fk_user_d:"",

              },
            
             comptes:[],
             
      }),
      mounted(){
         
        this.getDevis();
     
          
      },

      methods: {
         

          getDevis(){
                axios.get('/getDevis?page='+this.devis.current_page+'')
                .then((response) => {
                 // console.log('shit');
                    this.devis = response.data.devis;
                    this.devis.fk_compte_d = response.data.comptes[0].nom_compte;

                })
                .catch(() => {
                    console.log('handle server error from here');
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

</style>