
<template>
 <div>
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
    <!-- button pour afficher tous les utilisateurs-->
          <router-link class="btn btn-primary mb-3 retour  float-right " :to="'/getProfile'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>

  </div>
 
    <h2>Modifier Profile</h2>
</div>
</div>
  
    <hr>
  <!-- formulaire pour modifier un user -->

  <div class="row" >
        
    <div class="form-group col-md-6">
      <label for="inputEmail4">Email</label>
      <input type="email" class="form-control" id="inputEmail4" v-model="user.email" placeholder="">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Mot de Passe</label>
      <input type="password" class="form-control" id="inputPassword4" v-model="user.password" placeholder="">
    </div>

  </div>
  <div class="row">
    <div class="form-group col-md-6">
      <label for="inputName4">Nom Utilisateur</label>
      <input type="text" class="form-control" id="inputname4" v-model="user.name" placeholder="">
    </div>
    <div class="form-group col-md-6">
       <label for="inputPhoto4">Photo</label>
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">Upload</span>
    </div>
    <div class="custom-file">
     <input type="file"  class="custom-file-input"  v-on:change="onImageChange"  id="inputGroupFile01">
     <label class="custom-file-label"  for="inputGroupFile01">{{fileName}}</label>
    </div>
 </div>
    </div> 

  </div>
 


    <button @click="updateUser()" class="btn btn-success btn-lg btn-block" >Modifier</button>

</div>
    </div>
</div>

  <!-- fin formulaire -->

</template>

<script>
export default {
  
  data : () => ({
     loading: false,
               error: null,
    fileName :"Choose File",
    
    user: {
      id:0,
      names:"",
      email:"",
      password:"",
      role:"",
      photo:"",
      
    },

    users:[],
  }),

  methods:{
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
                    vm.user.photo = e.target.result;
    };
                reader.readAsDataURL(file);
    },
    

       // recupere les donnees d'un user dans le formulaire
    getProfile(){
                         this.loading = true

                axios.get('/getProfile')
                .then(response => {
                    this.user = response.data.user[0];
                    this.fileName = response.data.user[0].photo;
                              this.loading = false;

                })
                .catch(error => {
                })
    },
    updateUser(){
                axios.put('/updateUser',this.user)
                .then(response => {
                    if(response.data.etat){
                        this.$router.push('/getProfile/edit');
                    }
                })
                .catch(error => {
                })
    },

  },

  mounted(){
      this.getProfile(this.$route.params.id);         
  },

}
</script>
<style scoped>
.retour {
    border-left-color:#0000009e;
    border-left-width: 3px;
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

