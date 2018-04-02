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
    
    
  
    <hr>
    <!-- formulaire pour Ajouter un article -->
   
   
    
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
            <input type="text" @keyup.enter="searchComptes"  class="form-control" v-model="search" placeholder="recherche par nom du Compte" aria-label="Username" aria-describedby="basic-addon1" >
            </div>
        </div> 
        
    </div>
                       </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>nom_compte</th>
                                        <th>responsable</th>
                                        <th>type_compte</th>
                                        <th>fixe</th>
                                        <th>portable</th>
                                        <th>email</th>
                                        <th>options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="compte of comptes.data" :key="compte.id_compte" >
                                        <td>{{compte.nom_compte}}</td>
                                        <td>{{compte.responsable}}</td>
                                        <td>{{compte.type_compte}}</td>
                                        <td>{{compte.fixe}} </td>    
                                        <td>{{compte.portable}} </td>  
                                        <td>{{compte.email}} </td>    
                                        <td  class="optionsWidth"> 
                                            <a href="#"    @click="redirect_To_ShowCompte(compte.id_compte)"  class="btn btn-primary"  ><i class="fas fa-eye d-inline-block"></i></a>
                                         <router-link class="btn btn-success " :to="'/EditCompte/'+compte.id_compte"><i class="fas fa-edit d-inline-block"></i></router-link>
                                             <a @click="deleteCompte(compte)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></td>                                 
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
    
    <vue-pagination  :pagination="comptes"
                     @paginate="getcomptes()"
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
   
      axios.get('/getComptes?page='+this.comptes.current_page+'')
                .then((response) => {
                  
                    this.comptes = response.data.comptes;
                  this.loading = false;
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
          getcomptes(){
                axios.get('/getComptes?page='+this.comptes.current_page+'')
                .then((response) => {
                 // console.log('shit');
                    this.comptes = response.data.comptes;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },




             deleteCompte:function(compte){


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
                            axios.delete('/deleteCompte/'+compte.id_compte).then(
                                        response => {
                                
                                            this.getcomptes();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre compte a été supprimé',
                        'success'
                        )
  }
})

        },
        getCompte:function(compte){
              
                  axios.get('/getCompte/'+compte.id_compte).then(
                  response => {
                       
                    this.compte= response.data.compte;
                    this.modalShow = !this.modalShow
                  });         
        },
                redirect_To_ShowCompte(id_compte){
                     this.$router.push('/ShowCompte/'+id_compte);
            },

         /*   generatePdfHtml(){
                let doc = new this.$Jspdf();
                
                doc.fromHTML(window.$('#testdiv').get(0));
                //doc.text(20,20,'test pdf ');
                doc.save('test.pdf')
            }*/
               
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

</style>



