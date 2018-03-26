<template>
  <div>
   <div>

    <div class="row btnMarge">
       
    <div class="col">
    <!-- button pour rechercher un user par nom -->         
                <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" class="form-control" v-model="search" placeholder="recherche par nom d'utilisateur" aria-label="Username" aria-describedby="basic-addon1">
            </div>
        </div>
         <div class="col">
    <!-- button pour afficher formulaire de l'ajout d un user -->         
    <router-link :to="'/addUsers'"  class="float-right btn btn-primary">
           Ajouter </router-link>
    
        </div>
    </div>
    <!-- afficher les utilisateurs sous formes des cards  -->
    <div class="row">
        <div class="col-auto" v-for="user of filteredUsers" :key="user.id" >
            <div class="card widthCard"  >
            <img v-if="user.photo != ''" class="card-img-top" :src="'images/'+user.photo" alt="Card image cap" width="100px" height="100px">
            <img v-if="user.photo === ''" class="card-img-top" :src="'images/user0.jpg'" alt="Card image cap" width="100px" height="100px">

            <div class="card-body">
                <h5 class="card-title">User Name : {{user.name}}</h5>
                <p class="card-text">
                    <hr>
                    <div class="widthTextCard">E-mail: {{ user.email}}</div>
                    <hr>
                    <div class="widthTextCard">Role: {{user.role}}</div>
                    <hr>
                </p>
                
                <div> 
              
                 <router-link :to="'/editUser/'+user.id">
                    <a href="#" class="btn btn-success "><i class="fas fa-edit d-inline-block"></i></a>
                 </router-link>
                    <a href="#" class="btn btn-danger " @click="deleteUser(user)"><i class="fas fa-trash-alt d-inline-block"></i></a>
                </div>
            </div>
            </div>
        </div>       
    </div>
  
    <!-- fin affiche -->
    </div>
     
    </div>
</template>


<script>

    export default{
        
    data: () => ({
              //search
              search : '',
              //name file 
              nameFile : "Choose file",
              
              

    
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

   // remplire listes des articles aprés la creation complet de ce composant
    mounted(){
          this.getUsers();
    },

    methods: {
          
              // methode pour afficher tous les users                  
            getUsers(){
                        axios.get('getUsers')
                        .then(response => {
                            // recuperé ensemble des articles sous format json
                            this.users = response.data.users;
                         
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
                    vm.user.photo = e.target.result;
                    
                };
                reader.readAsDataURL(file);
            },

      
            deleteUser: function(user) {
                                 
                    axios.delete('deleteUser/'+user.id)
                        .then(response => {
                            this.getUsers();
                        })
                        .catch(error => {
                    
                            console.log(error );
                        })
                       
        },
        
    },



    computed:{
         
        filteredUsers:function(){

            return this.users.filter((user) => {
                  return user.name.match(this.search);
            });

        },   
            
    }

}
    
</script>

<style scoped>
 .btnMarge{
     padding-bottom: 10px;
 }
 .widthCard{
     width: 270px;
     height: 310px;
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
</style>
