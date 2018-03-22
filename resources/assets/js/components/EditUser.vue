
<template>
 <div>
  <div>
 
    <div class="row btnMarge">
        <div class="col">
    <!-- button pour afficher tous les users-->
    <button type="submit" class="float-left btn btn-primary" >
       <router-link :to="'/getUsers'"> Afficher</router-link>
    </button>
        </div>
  
    </div>

    <div class="text-center">
    <h2>Modifier Utilisateur</h2>
    </div>
    <hr>
  <!-- formulaire pour modifier un user -->
  <form  @submit.prevent="updateUser()">
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
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Name</label>
      <input type="text" class="form-control" id="inputname4" v-model="user.name" placeholder="User Name">
    </div>
    <div class="form-group col-md-6">
      <label for="inputState">Role</label>
      <select id="inputState" v-model="user.role" class="form-control">
        <option selected>Choose...</option>
        <option>Admin</option>
        <option>Expert Comptable</option>
      </select>
    </div> 

  </div>
   

 <div class="form-group">
    <label for="inputPassword4">Photo</label>
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


    <button type="submit" class="btn btn-success btn-lg btn-block" >Modifier</button>
</form>
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
    editUser(id){
                axios.get('editUser/'+id)
                .then(response => {
                    this.user = response.data.user;
                    this.fileName = response.data.user.photo;
                })
                .catch(error => {
                })
    },


    updateUser(){
                axios.put('/updateUser',this.user)
                .then(response => {
                    if(response.data.etat){
                        this.$router.push('/getUsers');
                    }
                })
                .catch(error => {
                })
    },

  },

  mounted(){
      this.editUser(this.$route.params.id);         
  },

}
</script>
