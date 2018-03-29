<template>
<div>
    <div class="loading" v-if="loading">
      Loading...
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
    <nav class="navbar page-header">
        <a href="#" class="btn btn-link sidebar-mobile-toggle d-md-none mr-auto">
            <i class="fa fa-bars"></i>
        </a>

        <a class="navbar-brand" href="#">
            <img src="storage/images/logo.png" alt="logo">
        </a>

        <a href="#" class="btn btn-link sidebar-toggle d-md-down-none">
            <i class="fa fa-bars"></i>
        </a>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item d-md-down-none">
                <a href="#">
                    <i class="fa fa-bell"></i>
                    <span class="badge badge-pill badge-danger">5</span>
                </a>
            </li>

            <li class="nav-item d-md-down-none">
                <a href="#">
                    <i class="fa fa-envelope-open"></i>
                    <span class="badge badge-pill badge-danger">5</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img v-if="profile.photo != ''" :src="'storage/images/'+profile.photo" class="avatar avatar-sm" alt="logo">
                    <img v-if="profile.photo === ''" :src="'storage/images/user0.jpg'" class="avatar avatar-sm" alt="logo">

                    <span class="small ml-1 d-md-down-none">{{profile.name}}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header">Account</div>

                    <router-link :to="'/getProfile'" class="dropdown-item">
                        <i class="fa fa-user"></i> Profile
                    </router-link>

                    <div class="dropdown-header">Gestion Utilisateur</div>
                        <router-link :to="'/addUsers'" class="dropdown-item" v-if="profile.role =='Super Admin'">
                        <i class="fas fa-plus"></i> 
                        Ajouter Utilisateur
                        </router-link>
                   

                    <router-link :to="'/getUsers'" class="dropdown-item">
                        <i class="far fa-file-alt"></i>
                       Afficher Utilisateurs
                        </router-link>
                  

                    <a href="#" class="dropdown-item" @click="logout">
                        <i class="fa fa-lock"></i> Déconnecter
                    </a>
                   
                </div>
                
            </li>
        </ul>

    </nav>
</div>
</div> 
</template>

<script>

 export default {
        data: () => ({
            loading: false,
            isSuperAd:false,
            profile: {
      id:0,
      name:"",
      email:"",
      password:"",
      role:"",
      photo:"",
      
    },
        }),
        
        methods: {
            logout:function() {

                axios.get('/logout')
                .then((response) => {
                  
                    window.location.href="/login"
                  
                })
                .catch(() => {
                    console.log('error log out ');
                });},
                
                    
        
            
             getProfile(){
this.loading = true
                        axios.get('/getProfile')
                        .then(response => {
                            // recuperé ensemble des articles sous format json
                         //  console.log("11")
                           this.profile = response.data.user[0];
                           this.loading = false;
                        //console.log(response.data.user[0]);
                      //  console.log(this.profile)

                        })
                        .catch(function (error) {
                           
                        });                
                         
                               
            },
            isSuperAdmin(){
                  axios.get('/isSuperAdmin')
                        .then(response => {
                            // recuperé ensemble des articles sous format json
                           console.log("11")
                           this.isSuperAd = test;
                        //console.log(response.data.user[0]);
                        console.log( this.isSuperAd )

                        })
                        .catch(function (error) {
                           
                        });
            }
            

        },

created(){
//this.getProfile();
},
        mounted(){
                    this.getProfile();
            
          
          
         // console.log(this.profile)
          
    },

        
    }
</script>
