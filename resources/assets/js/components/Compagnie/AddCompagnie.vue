
<template>
 <div>
 <div>
    
<div class="row btnMarge">
  <div class="col">
    <!-- button pour afficher tous les utilisateurs-->
       <router-link :to="'/'" class="float-left btn btn-primary">Afficher</router-link>
  </div>
  
</div>

<div class="text-center">
    <h2>Ajouter Compagnie</h2>
</div>
<hr>
  <!-- formulaire pour Ajouter un user -->
  <div class="row" >
        
            <div class="form-group col-md-6">
      <label for="inputEmail4">Raison Sociale</label>
      <input type="text" class="form-control" id="inputEmail4" v-model="compagnie.raison_sociale" placeholder="Raison Social">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Taille Compagnie</label>
      <input type="text" class="form-control" id="inputPassword4" v-model="compagnie.taille_comp" placeholder="Taille de Compagnie">
    </div>

  </div>


  <div class="row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Nom Societe</label>
      <input type="text" class="form-control" id="inputname4" v-model="compagnie.nom_societe" placeholder="Secteur d'Activité">
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Secteur d'Activité</label>
      <input type="text" class="form-control" id="inputname4" v-model="compagnie.secteur_activite" placeholder="Secteur d'Activité">
    </div>
   

  </div>
   
<div class="row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Code Postale</label>
      <input type="text" class="form-control" id="inputname4" v-model="compagnie.cp_comp" placeholder="Code Postale">
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Ville</label>
      <input type="text" class="form-control" id="inputname4" v-model="compagnie.ville_comp" placeholder="Ville de Compagnie">
    </div>

  </div>
  
<div class="row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Pays</label>
      <input type="text" class="form-control" id="inputname4" v-model="compagnie.pays_comp" placeholder="Pays">
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Téléphone</label>
      <input type="text" class="form-control" id="inputname4" v-model="compagnie.tel_comp" placeholder="télephone">
    </div>

  </div>

<div class="row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Fix</label>
      <input type="text" class="form-control" id="inputname4" v-model="compagnie.fix_comp" placeholder="fix">
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Site Web</label>
      <input type="text" class="form-control" id="inputname4" v-model="compagnie.webSite_comp" placeholder="Site web">
    </div>

  </div>
  <div class="row">
     <div class="form-group col-md-6">
      <label for="inputEmail4">Adresse</label>
      <input type="text" class="form-control" id="inputname4" v-model="compagnie.adresse_comp" placeholder="Adresse de Compagnie">
    </div>
  <div class="form-group col-md-6">
      <label for="inputPassword4">Logo</label>
 <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text">Upload</span>
  </div>
  <div class="custom-file">
    <input type="file" class="custom-file-input"  v-on:change="onImageChange"  id="inputGroupFile01">
    <label class="custom-file-label"  for="inputGroupFile01">{{fileName}}</label>
  </div>
</div>
 </div>
  </div>


    <button @click="store()" class="btn btn-success btn-lg btn-block" >Enregister</button>
  
  </div>
 </div>

  <!-- fin formulaire -->

</template>

<script>
export default {
  
  data : () => ({
    fileName : "Choose File",
    loading: false,

    compagnie: {
      id_compagnie:0,
      nom_societe:"",
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
     // ajouter un user
    store() {
               console.log("test");
                 
                axios.post('/addCompagnie',this.compagnie)
                
                    .then(response => {
                        this.$router.push('/getCompagnies/add');
                    })
                    .catch(function (resp) {
                       
                    });
            
    },
       


  },


}
</script>
