<template>
  <div>
        <div class="loading" v-if="loading">
      Loading...
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
   <div>

    <div class="row btnMarge">
       
   
         <div class="col">
    <!-- button pour afficher formulaire de l'ajout d un compagnie -->         
           <router-link :to="'/addCompagnie'" class="float-right btn btn-primary">Ajouter</router-link>
        </div>
    </div>
    <!-- afficher les utilisateurs sous formes des cards  -->
    <div class="row">
        <div class="col-auto" v-for="compagnie of compagnies.data" :key="compagnie.id_compagnie" >
            <div class="card widthCard"  >
            <img v-if="compagnie.logo_comp != ''" class="card-img-top" :src="'images/'+compagnie.logo_comp" alt="Card image cap" width="100px" height="100px">
            <img v-if="compagnie.logo_comp === ''" class="card-img-top" :src="'images/compagnie0.jpg'" alt="Card image cap" width="100px" height="100px">

            <div class="card-body">
                <h5 class="card-title">Raison Sociale : {{compagnie.raison_sociale}}</h5>
                <p class="card-text">
                    <hr>
                    <div class="widthTextCard">Secteur d'Activité : {{ compagnie.secteur_activite}}</div>
                    <hr>
                    <div class="widthTextCard">Adresse : {{compagnie.adresse_comp}}</div>
                    <hr>
                    <div class="widthTextCard">Taille de Compagnie : {{ compagnie.taille_comp}}</div>
                    <hr>
                </p>
                
                <div> 
                <a href="#"  class="btn btn-primary" @click="getCompagnie(compagnie)"  ><i class="fas fa-eye d-inline-block"></i></a>

                 <router-link :to="'/EditCompagnie/'+compagnie.id_compagnie">
                    <a href="#" class="btn btn-success "><i class="fas fa-edit d-inline-block"></i></a>
                 </router-link>
                    <a href="#" class="btn btn-danger " @click="deleteCompagnie(compagnie)"><i class="fas fa-trash-alt d-inline-block"></i></a>
                </div>
            </div>
            </div>
        </div>
         <div>
              
                <b-modal ok-only  v-model="modalShow" no-fade
                :title="'Raison Sociale : '+compagnie.raison_sociale"
                :body-bg-variant="+' '+modalShow+''+compagnie.secteur_activite+''+compagnie.taille_comp+''+compagnie.adresse_comp+''+compagnie.cp_comp+''+compagnie.ville_comp+''+compagnie.pays_comp+''+compagnie.tel_comp+''+compagnie.fix_comp+''+compagnie.webSite_comp+''+compagnie.logo_comp">
                 <div class="row" v-if="modalShow">
                     <div class="col">                     
                   <span>Adresse : </span>{{compagnie.adresse_comp}}
                        <hr>
                   <span>Code Postale : </span>{{compagnie.cp_comp}} 
                   <hr>
                   <span>Ville : </span>{{compagnie.ville_comp}}
                   <hr>
                   <span>Pays :  </span>{{compagnie.pays_comp}}
                   <hr>
                   <span>Téléphone : </span>{{compagnie.tel_comp}}
                   <hr>
                   <span>Fix :  </span>{{compagnie.fix_comp}}
                   <hr>
                   <span>Site Web : </span>{{compagnie.webSite_comp}}
                   </div>
                   <div class="col">
                       <div class="pull-right">
                     
                      <img v-if="compagnie.logo_comp != ''" class="card-img-top" :src="'images/'+compagnie.logo_comp" width="150px" height="150px">
                    <img v-if="compagnie.logo_comp === ''" class="card-img-top" :src="'images/compagnie0.jpg'"  width="150px" height="200px">
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
         
    compagnie: {
      id_compagnie:0,
      raison_sociale:"",
      taille_comp:"",
      secteur_activite:"",
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
          this.getCompagnies();
    },

    methods: {
          
              // methode pour afficher tous les compagnies                  
            getCompagnies(){
console.log("testttt");
                        axios.get('/getCompagnies?page='+this.compagnies.current_page+'')
                        .then(response => {
                            // recuperé ensemble des compagnies sous format json
                            this.compagnies = response.data.compagnies;
                         
                        })
                        .catch(function (error) {
                           
                        });                
                         
                               
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

        getCompagnie:function(compagnie){
              
                  axios.get('/getCompagnie/'+compagnie.id_compagnie).then(
                  response => {
                       
                    this.compagnie= response.data.compagnie;
                  
                    
                    this.modalShow = !this.modalShow
                  });         
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
        
    },



    computed:{
        
            
    }

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
 a {
  color: #999;
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
</style>
