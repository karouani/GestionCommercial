<template>
  <div>
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
   <div>
            <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
    <!-- button pour afficher tous les users-->
    <router-link class="float-right btn btn-secondary" :to="'/addCompagnie'" ><i class="fas fa-plus-circle"/> Ajouter </router-link>

        </div>
  
    </div>
    <h2>List des Compagnies</h2>
    <hr>   
    </div>   
       
 <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testAjout">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Compagnie Bien Ajouter !</strong>
</div>
 <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testEdit">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Compagnie Bien Modifier !</strong>
</div>


    <!-- afficher les utilisateurs sous formes des cards  -->
    <div class="row">
        <div class="col-auto" v-for="compagnie of compagnies.data" :key="compagnie.id_compagnie" >
            <div class="card widthCard"  >
            <img v-if="compagnie.logo_comp != ''" class="card-img-top" :src="'storage/images/'+compagnie.logo_comp" alt="Card image cap" width="100px" height="100px">
            <img v-if="compagnie.logo_comp === ''" class="card-img-top" :src="'storage/images/compagnie0.jpg'" alt="Card image cap" width="100px" height="100px">

            <div class="card-body">
                <h5 class="card-title">Raison Sociale : {{compagnie.raison_sociale_comp}}</h5>
                <div class="card-text">
                    <hr>
                    <div class="widthTextCard">Secteur d'Activité : {{ compagnie.secteur_activite_comp}}</div>
                    <hr>
                    <div class="widthTextCard">Nom Societe : {{compagnie.nom_societe_comp}}</div>
                    <hr>
                    <div class="widthTextCard">Taille de Compagnie : {{ compagnie.taille_comp}}</div>
                    <hr>
                </div>
                
                <div> 
                    
                <a href="#"  class="btn btn-primary" @click="redirect_to_CompagnieDetails(compagnie)"  ><i class="fas fa-eye d-inline-block"></i></a>

                 <router-link :to="'/EditCompagnie/'+compagnie.id_compagnie">
                    <a href="#" class="btn btn-success "><i class="fas fa-edit d-inline-block"></i></a>
                 </router-link>
                    <a href="#" class="btn btn-danger " @click="deleteCompagnie(compagnie)"><i class="fas fa-trash-alt d-inline-block"></i></a>
                </div>
            </div>
            </div>
        </div>
         <div>
              
            </div>
    </div> 
         <vue-pagination  :pagination="compagnies"
                     @paginate="getCompagnies()"
                     :offset="4">
    </vue-pagination>      
    </div>
  
    <!-- fin affiche -->
    </div>
     
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
               error: null,
             modalShow: false,

              //search
              search : '',
              //name file 
              nameFile : "Choose file",
           // objet test sur affichage , ajout , recherche
              Testopen:{
                testAjout : false,
                testEdit : false,
                testAffiche : false,
                testmodelArticle : false,
              },
    compagnie: {
      id_compagnie:0,
      raison_sociale_comp:"",
      taille_comp:"",
      secteur_activite_comp:"",
      adresse_comp:"",
      cp_comp:"",
      ville_comp:"",
      pays_comp:"",
      tel_comp:"",
      fix_comp:"",
      webSite_comp:"",
      logo_comp:"",
      
        },
        compagnies:{
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1,
            data: [],
        },
    }),

   // remplire listes des compagnies aprés la creation complet de ce composant
    mounted(){
        if(this.$route.params.success == "add")
                            this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Compagnie bien ajouter!',
                                      duration: 1500,
                                    });
   if(this.$route.params.success == "edit")
                                this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Bon de livraison bien modifier!',
                                      duration: 1500,
                                    });

          
    },
updated(){
    if( this.$route.params.success == "add"){
          let that = this
              setTimeout(function(){that.Testopen.testAjout = false;}, 2000);
               }
          if( this.$route.params.success == "edit"){
         let that=this;
              setTimeout(function(){that.Testopen.testEdit = false;}, 2000);}
},
watch:{
    // call again the method if the route changes
    '$route': 'fetchData', 
},
    methods: {
          
              // methode pour afficher tous les compagnies                  
        getCompagnies(){
            console.log("testttt");
                axios.get('/getCompagnies?page='+this.compagnies.current_page+'')
                    .then(response => {
        console.log("test======="); console.log("testttt========");
                            // recuperé ensemble des compagnies sous format json
                            this.compagnies = response.data.compagnies;
                            this.loading = false
                         
                    })
                    .catch(function (error) {
                           
                    });                
                         
                               
        },

        redirect_to_CompagnieDetails(compagnie){
                     this.$router.push({ name: 'CompagnieDetails', params: {id_compagnie: compagnie.id_compagnie}});

        },
      
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                this.nameFile = files[0].name;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },


            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.compagnie.logo_comp = e.target.result;
                    
                };
                reader.readAsDataURL(file);
            },
            deleteCompagnie(compagnie) {
                                     this.$swal({
                        title: 'Êtes-vous sûr?',
                        text: "Vous ne serez pas capable de revenir à cela!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, supprimez-le!'
                        }).then((result) => {
                        if (result.value) {
                    axios.delete('deleteCompagnie/'+compagnie.id_compagnie)
                        .then(response => {
                            this.getCompagnies();
                        })
                        .catch(error => {
                    
                            console.log(error );
                        })
                         this.$swal(
                            'Supprimé',
                            'Votre fichier a été supprimé.',
                            'success'
                            )
                        }

                        })
                       
        },
          fetchData () {
      this.loading = true
      this.getCompagnies();
          }
        
    },
   created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },


}
    
</script>

<style scoped>
 .btnMarge{
     padding-bottom: 10px;
 }
 .widthCard{
     width: 270px;
     height: 360px;
 }
 .widthTextCard{
     width  : 236px;
     height: 13px;
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
.show{
     opacity:0.9;
    width: 265px;
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
