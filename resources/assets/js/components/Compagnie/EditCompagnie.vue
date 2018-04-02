 <template>
    <div>
        <div class="text-center">
    <h2>Modifier Compagnie</h2>
    </div>
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
  <div class="form-group">
      <label for="inputPassword4">Logo</label>
 <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text">Upload</span>
  </div>
  <div class="custom-file">
    <input type="file" class="custom-file-input"  v-on:change="onImageChange"  id="inputGroupFile01">
    <label class="custom-file-label"  for="inputGroupFile01">{{nameFile}}</label>
  </div>
</div>
 </div>
  </div>
    </div>

     <button  @click="updateCompagnie()" class="btn btn-primary mr-20 btn-success">Modifier</button>
    </div>
</template>

<script>

    export default{ 
        
          data: () => ({
              nameFile : "Choose file",
              // objet test sur affichage , ajout , recherche
              Testopen:{
                testAjout : false,
                testAffiche : false,
                testEdit : false,
              },
        
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
              //etat 
             
             
      }),
    
      

      methods: { 


        getCompagnie(id_compagnie){

                  axios.get('/getCompagnie/'+id_compagnie).then(
                  response => {
                    this.compagnie= response.data.compagnie;

                    this.nameFile = response.data.compagnie.logo_comp;

                                  });         
        },
        
        
        updateCompagnie: function(){
           
  
                  axios.post('/updateCompagnie',this.compagnie).then( response => {             
                    this.$router.push('/getCompagnies/edit');  
                    
                  
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
    

      },
      mounted(){
          this.getCompagnie(this.$route.params.id_compagnie);
      }
      

      
       
        
      

    }
    
</script>

<style scoped>
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
</style>



