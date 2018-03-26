
<template>
 <div>
  <div>
 
    <div class="row btnMarge">
        <div class="col">
    <!-- button pour afficher tous les users-->
       <router-link :to="'/getProfile'"  class="float-left btn btn-primary"> Afficher</router-link>
        </div>
  
    </div>

    <div class="text-center">
    <h2>Modifier Profile</h2>
    </div>
    <hr>
  <!-- formulaire pour modifier un user -->

  <div class="row" >
        
    <div class="form-group col-md-6">
      <label for="inputEmail4">Email</label>
      <input type="email" class="form-control" id="inputEmail4" v-model="user.email" placeholder="Email">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" id="inputPassword4" v-model="user.password" placeholder="Password">
    </div>

  </div>
  <div class="row">
    <div class="form-group col-md-6">
      <label for="inputName4">Name</label>
      <input type="text" class="form-control" id="inputname4" v-model="user.name" placeholder="User Name">
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

  <!-- fin formulaire -->

</template>

<script>
export default {
  
  data : () => ({
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
                axios.get('/getProfile')
                .then(response => {
                    this.user = response.data.user[0];
                    this.fileName = response.data.user[0].photo;
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
