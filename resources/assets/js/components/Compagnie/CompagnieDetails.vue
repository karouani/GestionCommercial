<template>
  <div>


    <div class="loading" v-if="loading">
     <div class="lds-hourglass"></div>
    </div>
    

<div v-if="!loading">
    <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
    <!-- button pour afficher tous les users-->
        <router-link class="btn btn-primary mb-3  float-right " :to="'/getCompagnies'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>

        </div>
  
    </div>
    <h2>Details Compagnie</h2>
    <hr>   
    </div>
  
     <div class=" container colBackround">


<div class="row">
    <div class="col">
        <br>
    <h5><i class="fas fa-address-book"></i> Compagnie {{compagnie.nom_societe_comp}} </h5>
    </div>
</div>
<hr>
    
        <div class="row">
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
                
                <div class="card-text">
       <div class="text-center ">               
     <h4 >Informations Compagnie</h4>
       </div>
     <hr>
                    <span>Raison Sociale : </span>{{compagnie.raison_sociale_comp}}
                     <hr>
                    <span>Nom compagnie : </span>{{compagnie.nom_societe_comp}}
                     <hr>
                    <span>R.C : </span>{{compagnie.RC_comp}} 
                     <hr>
                    <span>I.F : </span>{{compagnie.IF_comp}}
                     <hr>
                    <span>Patente :  </span>{{compagnie.patente_comp}}
                     <hr>
                    <span>C.N.S.S : </span>{{compagnie.cnss_comp}}
                     <hr>
                    <span>I.C.E :  </span>{{compagnie.ICE_comp}}
                     <hr>
                    <span>Capitale : </span>{{compagnie.capitale_comp}}
                   
                              
                
                </div>
                
            </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
             <div class="card-text">
                       <div class="pull-right">
                     
                      <img v-if="compagnie.logo_comp != ''" class="card-img-top" :src="'storage/images/'+compagnie.logo_comp" width="150px" height="185px">
                    <img v-if="compagnie.logo_comp === ''" class="card-img-top" :src="'storage/images/compagnie0.jpg'"  width="150px" height="185px">
                     </div>
                       <hr>
                    <span>Taille : </span>{{compagnie.taille_comp}}
                     <hr>
                    <span>Secteir D'activité : </span>{{compagnie.secteur_activite_comp}}
                    
                   <hr>
                    <div class="text-center ">
                          <h4>Details bancaires </h4>
                    </div>
                      <hr>
                    
                    <span>Nom Banque : </span>{{compagnie.nom_bank_comp}}     
                     <hr>
                    <span>R.I.B : </span>{{compagnie.RIB_comp}}  
             </div>   
            </div>
            </div>
        </div>
        </div>
        
    <div class="col">
       
        <div class="card">
            <div class="card-body">
                <div class="card-text">
                       <div class="text-center ">
                  
                    <h4>Contact </h4>
                    
                </div>
                <hr>
                <div class="row">
                
                 <div class="col-sm-4">
                    <span>GSM: </span>{{compagnie.GSM_comp}}  
                 </div>
                 <div class="col-sm-4">
                    <span>Email: </span>{{compagnie.email_comp}}
</div>
                 <div class="col-sm-4">
                    <span>Fax : </span>{{compagnie.fax_comp}}
                 </div>
                    </div>
           <hr>
                    <div class="row">
                        
                 <div class="col-sm-4">
 <span>Fix: </span>{{compagnie.fix_comp}} 
 </div>
                 <div class="col-sm-4">
                    <span>Site Web: </span>{{compagnie.webSite_comp}}  
                    </div>
                 <div class="col-sm-4">
                    <span>Adresse: </span>{{compagnie.adresse_comp}} 
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    </div>
    <br>
 
  <div class="container colBackround2">
    
                         <h5> <i class="icon-calculator"></i> Contacts</h5>
    <hr>
    
     
            <div class="row colBackround3">
                <div class="col-auto" v-for="(contact,index) in contacts.data" :key="index" >
                <div class="card" style="width: 18rem;">
  <div class="card-header">
   {{contact.prenom}} {{contact.nom}}
  </div>
  
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Civilite : {{contact.civilite}}</li>
    <li class="list-group-item">fonction : {{contact.fonction}}</li>
    <li class="list-group-item">email: {{contact.email}} </li>
    <li class="list-group-item">fixe: {{contact.fixe}} </li>
    <li class="list-group-item">mobile: {{contact.mobile}} </li>
  </ul>
</div>
</div>
        </div>

         <div class="colBackround3">
  <vue-pagination  :pagination="contacts"
                     @paginate="getContactPaginate()"
                     :offset="4">
    </vue-pagination> 
         </div>
  </div>
    </div>
   </div>
</template>

<script>
import  Pagination from '../Pagination.vue';
export default {
    components:{
            'vue-pagination':Pagination,
         },
  data : () => ({
    fileName : "Choose File",
    loading: false,
    error: null,
    compagnie: {
      id_compagnie:0,
      nom_societe_comp:"",
      raison_sociale_comp:"",
      RC_comp:"",
      IF_comp:"",
      patente_comp:"",
      cnss_comp:"",
      ICE_comp:"",
      capitale_comp:"",
      taille_comp:"",
      secteur_activite_comp:"",


      nom_bank_comp:"",
      RIB_comp:"",
      //cp_comp:"",
      //ville_comp:"",
      //pays_comp:"",
      adresse_comp:"",
      email_comp:"",
      GSM_comp:"",
      fix_comp:"",
      fax_comp:"",
      webSite_comp:"",
      logo_comp:"",
      
    },
contact: { 
                    id_contact : 0,
                    prenom : "",
                    nom : "",
                    civilite : "",
                    fonction : "",
                    email : "",
                    fixe : "",
                    mobile : "",
                    type_contact:"",
                    fk_compte_comp : 0,
              },
               contacts :{
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1,
            data: [],
        },
    macompagnies:[],
  }),

  methods:{
     // upload image
    onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                this.fileName=files[0].name;

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
   
        getCompagnie(id_compagnie){
                  axios.get('/getCompagnie/'+id_compagnie).then(
                  response => {
                    this.compagnie= response.data.compagnie;
                    this.nameFile = response.data.compagnie.logo_comp;
                                     


                                  });         
        },
        getContactPaginate:function(){
                  axios.get('/getContactPaginate/'+this.$route.params.id_compagnie+'?page='+this.contacts.current_page+'').then(
                  response => {
                    this.contacts= response.data.contacts;
                    this.loading = false;
                   
                  });     
        },
  fetchData () {
          this.loading = true
          this.getCompagnie(this.$route.params.id_compagnie);
          this.getContactPaginate();
  },
  },
 
  created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
  watch:{
          // call again the method if the route changes
    '$route': 'fetchData', 

  },
  

}
</script>
<style scoped>
.card-header{
    background-color: #cac8c8;
}
span{
    color:#007ee4;
}
.fontsize{

    font-size: 1.30rem;
}
a {
  color: #999;
  color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    
}
.colBackround{
    background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
}


.colBackround2{
    background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
    padding-left: 20px;
    /* margin-left: 0px; */
    padding-right: 20px;
    padding-bottom: 20px;
    padding-top: 10px;
    margin-top: 15px;

}
.colBackround3{
padding-left: 20px;
}
.badgeSize{
    font-size: 14px;
}




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
