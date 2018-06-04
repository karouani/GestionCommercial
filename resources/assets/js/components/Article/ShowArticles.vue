<template>
    <div class="post" >
      <!-- au cas ajout bien passé afficher ce message -->   
                    <notifications group="foo" 
      position="bottom right" 
      classes="vue-notification error"/>
                          <notifications group="foo2" 
      position="bottom right" 
      classes="vue-notification success"/>
           
    <div class="loading" v-if="loading">
           <div class="lds-hourglass"></div>
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
        <div class="row text-center">
                    <div class="col">
    <router-link class="float-left btn btn-secondary" :to="'/ShowMouvements'" ><i class="fas fa-exchange-alt"></i> Mouvements </router-link>
    </div>
     <h3>Liste des Articles</h3>
        <div class="col">
    <!-- button pour afficher tous les users-->
    <router-link class="float-right btn btn-secondary" :to="'/AddArticles'" ><i class="fas fa-plus-circle"/> Ajouter </router-link>

        </div>
  
    
    </div>
     <hr> 
    
    
 
            <div v-if="Testopen.testnotifAdd" class="alert alert-success alert-dismissible fade show notifArticle" role="alert">
        <strong>Article bien ajouter !</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>

        <div v-if="Testopen.testnotifEdit" class="alert alert-success alert-dismissible fade show notifArticle" role="alert">
        <strong>Article bien modifier !</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    
    
  

    <!-- formulaire pour Ajouter un article -->
   
   
    
    <!-- fin formulaire -->
    <!-- afficher les articles sous formes des cards  -->
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
            <input type="text" @keyup.enter="searchArticles"  class="form-control" v-model="search" placeholder="recherche par designation ou reference" aria-label="Username" aria-describedby="basic-addon1" >
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
                                        <th>designation</th>
                                        <th>Prix ht achat:</th>
                                        <th>Prix ht vente:</th>
                                        <th>Quantite:</th>
                                        <th>options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="article of articles.data" :key="article.id_article" >
                                        <td>{{article.reference_art}}</td>
                                        <td>{{ article.designation}}</td>
                                        <td>{{article.prix_ht_achat}}</td>
                                        <td>{{article.prix_ht_vente}}</td>
                                        <td>{{article.quantite}} </td>      
                                        <td  class="optionsWidth"> 
                                            <a href="#"    @click="getArticle(article)"  class="btn btn-primary"  ><i class="fas fa-eye d-inline-block"></i></a>
                                         <router-link class="btn btn-success " :to="'/EditArticles/'+article.id_article "><i class="fas fa-edit d-inline-block"></i></router-link>
                                             <a @click="deleteArticle(article)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a>
                                             <a style="background-color: bisque;color:black;" @click="getArticleMouvement(article)" v-b-modal.modalPreventM class="btn" ><i class="fas fa-exchange-alt"></i></a></td>
                                 
                                    </tr>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    </div>
                                    </tbody>
                                </table>

                            </div>
                               <b-modal id="modalPreventM"
                                            ref="modal"
                                            title="<=> Mouvement"
                                            @ok="addMouvement"
                                            ok-title="Valider" >
                                    <form @submit.stop.prevent="handleSubmit">
                                    <div class="form-group row">
                                                <label for="reference" class="col-sm-3 col-form-label">Quantité: </label>
                                                    <div class="col-sm-9">
                                                 <select class="form-control custom-select " id="fk_compte" v-model="mouvement.type_mouvement">
                                                <option selected disabled>Choisir Operation</option>
                                                 <option  value="entre">Entrée</option>
                                                 <option  value="sortie">Sortie</option>
                                                </select>
                                                </div>
                                    </div> 
                                    <div class="form-group row">
                                                <label for="reference" class="col-sm-3 col-form-label">Date: </label>
                                                    <div class="col-sm-9">
                                                    <input  type="date" v-model="currentDate" class="form-control" id="date" />
                                                    </div>
                                    </div>
                                    <div class="form-group row">
                                                <label for="reference" class="col-sm-3 col-form-label">Quantité: </label>
                                                    <div class="col-sm-9">
                                                    <input  type="number" v-model="mouvement.quantite_mouvement" class="form-control" id="date" />
                                                </div>
                                    </div> 



                  
                                        </form>

                                    </b-modal>
                        </div>
                    </div>
                    <div>
              
                <b-modal ok-only  v-model="modalShow" no-fade
                :title="'Reference : '+article.reference_art"
                :body-bg-variant="+' '+modalShow+''+article.designation+''+article.type_art+''+article.description+''+article.prix_ht_achat+''+article.prix_ht_vente+''+article.unite+''+article.quantite+''+article.quantite_min+''+article.photo_art">
                 <div class="row" v-if="modalShow">
                      
                         <div class="col">
                             <div>
                   <span>Designation : </span>{{article.designation}}
                    <hr>
                   <span>Type : </span>{{article.type_art}} 
                   <hr>
                   <span>Description : </span>{{article.description}}
                   <hr>
                   <span>Prix ht achat :  </span>{{article.prix_ht_achat}}
                   <hr>
                   <span>Prix ht vente : </span>{{article.prix_ht_vente}}
                   </div>
                    </div>
                   <div class="col">
                   <span>Unite :  </span>{{article.unite}}
                   <hr>
                   <span>Quantite : </span>{{article.quantite}}
                   <hr>
                   <span>Quantite minimum : </span>{{article.quantite_min}}
                   <hr>
                   <span>Famille : </span>{{article.fk_famille}}
                   <hr>
                   <span>Taux Tva: </span>{{article.fk_tva_applicable}}  
                   </div>                                   
                   
                   <div class="col">
                       <div class="pull-right">
                     
                      <img v-if="article.photo_art != ''" class="card-img-top" :src="'storage/images/'+article.photo_art" width="150px" height="150px">
                    <img v-if="article.photo_art === ''" class="card-img-top" :src="'storage/images/article0.png'"  width="150px" height="200px">
                     </div>
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
    
    <vue-pagination  :pagination="articles"
                     @paginate="getarticles()"
                     :offset="4">
    </vue-pagination>
    </div>
    </div>
    <!-- fin affiche -->
</template>

<script>
import  Pagination from '../Pagination.vue';

    export default{
         components:{
            'vue-pagination':Pagination,
         },

          data: () => ({
              mouvement:{
                  id_mouvement:0,
                  type_mouvement:"",
                  quantite_mouvement:"",
                  date_mouvement:"",
                  fk_article:0
              },
              currentDate : "",
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
              articles:{
                        
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
               offset: 4,


              article: { 
                    
                    id_article :0,
                    reference_art :"",
                    type_art :"",
                    designation :"",
                    description :"",
                    prix_ht_achat :"",
                    prix_ht_vente :"",
                    unite :"",
                    quantite :"",
                    quantite_min :"",
                    photo_art :'',
                    fk_tva_applicable :"",
                    fk_famille :"",

              },
              
            
             
             
      }),
     /* mounted(){
         
        this.getarticles();
     
          
      },*/
        mounted(){
            this.getDateCourant();
           
          if( this.$route.params.success == "addsuccess"){
             
                        
                            this.$notify({
                                      group: 'foo2',
                                      title: 'Succès',
                                      text: 'Article bien ajouter!',
                                      duration: 1500,
                                    });

          }
                    if( this.$route.params.success == "editsuccess"){
             
                                                   this.$notify({
                                      group: 'foo2',
                                      title: 'Succès',
                                      text: 'Article bien modifier!',
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
    '$route': 'fetchData'
  },


      methods: {
          addMouvement(evt){
            
              let nouveauQuantite= 0;
              if(this.mouvement.type_mouvement == "entre"){
                  nouveauQuantite = +this.article.quantite + +this.mouvement.quantite_mouvement;
                  this.getarticles();
                             
              this.article.quantite = nouveauQuantite;
              this.mouvement.fk_article = this.article.id_article;
             axios.post('/updateArticle',this.article).then( response => {             
                      this.getarticles();
                  });
              this.mouvement.date_mouvement = this.currentDate;
              console.log("dateee : ")
              console.log(this.mouvement.date_mouvement)

             axios.post('/addMouvement',this.mouvement).then(response => {         
                    console.log('mouvement  Bien ajouter !');
             }); 
              }
              else if(this.article.quantite >= this.mouvement.quantite_mouvement){
                  
                   nouveauQuantite = +this.article.quantite - +this.mouvement.quantite_mouvement;

              
           
              this.article.quantite = nouveauQuantite;
              this.mouvement.fk_article = this.article.id_article;
             axios.post('/updateArticle',this.article).then( response => {             
                      this.getarticles();
                  });
              this.mouvement.date_mouvement = this.currentDate;
              console.log("dateee : ")
              console.log(this.mouvement.date_mouvement)

             axios.post('/addMouvement',this.mouvement).then(response => {         
                    console.log('mouvement  Bien ajouter !');
             });     
              console.log('nouveau quantité : '+nouveauQuantite);
                console.log(" mouvement bien modifié !")}
                  else { evt.preventDefault()
                                     this.$notify({
                                      group: 'foo',
                                      title: 'error',
                                      text: 'stock insuffisant!',
                                      duration: 2000,
                                    });
            }
          },
          getArticleMouvement(article){
              this.article  = article;
          },
          notifArticle(){
              let this1 = this
               setTimeout(function () { this1.Testopen.testnotifAdd = false }, 1000);
          },
          searchArticles(event){
             console.log(this.search);
             this.articles.current_page=1;
             if(this.search === ""){
                //console.log('test2');
                    this.getarticles();}
                else {
                     // console.log('test1');
                axios.get('/searchArticles/'+this.search+'?page='+this.articles.current_page+'')
                .then((response) => {
                  
                    this.articles = response.data.articles;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
          },

            fetchData () {
      //this.error = this.post = null
      this.loading = true
      // replace `getPost` with your data fetching util / API wrapper
   
      axios.get('/getArticles?page='+this.articles.current_page+'')
                .then((response) => {
                  
                    this.articles = response.data.articles;
                  this.loading = false;
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
          getarticles(){
                axios.get('/getArticles?page='+this.articles.current_page+'')
                .then((response) => {
                 // console.log('shit');
                    this.articles = response.data.articles;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },




             deleteArticle:function(article){


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
                            axios.delete('/deleteArticle/'+article.id_article).then(
                                        response => {
                                
                                            this.getarticles();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre article a été supprimé',
                        'success'
                        )
  }
})

        },
        getArticle:function(article){
              
                  axios.get('/getArticle/'+article.id_article).then(
                  response => {
                       
                    this.article= response.data.article;
                    this.article.fk_famille = response.data.libelle_famille[0].libelle_famille;
                    //console.log(response.data.libelle_famille[0]);
                    this.article.fk_tva_applicable = response.data.taux_tva[0].taux_tva;
                    this.modalShow = !this.modalShow
                  });         
        },
        getDateCourant(){
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
             console.log('date courant : '+this.currentDate)
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



