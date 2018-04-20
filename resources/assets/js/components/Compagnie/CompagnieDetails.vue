<template>
  <div>


    <div class="loading" v-if="loading">
     <div class="lds-hourglass"></div>
    </div>
    

<div v-if="!loading">
    <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/getCompagnies'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
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
      <!--          <p class="card-text">
                   
      <div class="text-center ">
                  
                    <h4>Contact </h4>
                    
                </div>
                <hr>
                    <span>Fax : </span>{{compagnie.fax_comp}}
                     <hr>
                    <span>Fix: </span>{{compagnie.fix_comp}} 
                     <hr>
                    <span>GSM: </span>{{compagnie.GSM_comp}}  
                     <hr>
                    <span>Email: </span>{{compagnie.email_comp}}
                     <hr>
                    <span>Site Web: </span>{{compagnie.webSite_comp}}  
                     <hr>
                    <span>Adresse: </span>{{compagnie.adresse_comp}}  
                </p>
               -->
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
    </div>
  </div>
     <hr>
    <h3>Contacts</h3>
    <hr>
    
     
            <div class="row">
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
  <vue-pagination  :pagination="contacts"
                     @paginate="getContactPaginate(id_compagnie)"
                     :offset="4">
    </vue-pagination> 
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
console.log("getttt")
                  axios.get('/getCompagnie/'+id_compagnie).then(
                  response => {
                    this.compagnie= response.data.compagnie;
                    console.log(this.compagnie)
                    this.nameFile = response.data.compagnie.logo_comp;
                    this.getContactPaginate(this.compagnie.id_compagnie);
                                     


                                  });         
        },
        getContactPaginate:function(id_compagnie){
                  axios.get('/getContactPaginate/'+id_compagnie+'?page='+this.contacts.current_page+'').then(
                  response => {
                       console.log('-------------------111');
                    console.log(response.data.contacts);
                    this.contacts= response.data.contacts;
                    this.loading = false;
                   
                    console.log('-------------------2222');
                    console.log(this.contacts);
                  });     
        },
  fetchData () {
      //this.error = this.post = null
      this.loading = true
      console.log("fetchDat...")
       this.compagnie.id_compagnie=this.$route.params.id_compagnie;
                console.log(this.$route.params.id_compagnie)
          this.getCompagnie(this.$route.params.id_compagnie);
         // this.getContactPaginate(this.compagnie.id_compagnie);
  },
  },
  computed:{
     contactsPaginate(){
         this.getContactPaginate(id_compagnie);
     }
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
    padding-left:  0px;
    margin-left:  0px;
    padding-right: 0px;
}
.colBackround3{
    background-color: #d8edff;
    padding-left:  0px;
    margin-left:  0px;
    padding-right: 0px;
}
.badgeSize{
    font-size: 14px;
}
</style>
