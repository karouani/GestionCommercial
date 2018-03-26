<template>
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
                    <img src="storage/images/avatar-1.png" class="avatar avatar-sm" alt="logo">
                    <span class="small ml-1 d-md-down-none">John Smith</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header">Account</div>

                    <a href="#" class="dropdown-item">
                        <i class="fa fa-user"></i> Profile
                    </a>

                    <div class="dropdown-header">Gestion Utilisateur</div>
                   

                    <router-link :to="'/addUsers'" class="dropdown-item">
                      <i class="fa fa-wrench"></i> 
                        Ajouter Utilisateur</router-link>
                        
                    <router-link :to="'/getUsers'" class="dropdown-item">
                      <i class="fa fa-wrench"></i> 
                        Afficher Utilisateurs</router-link>
                        
                    

                    <a href="#" class="dropdown-item" @click="logout">
                        <i class="fa fa-lock"></i> Déconnecter
                    </a>
                   
                </div>
                
            </li>
        </ul>
    </nav>
    
</template>

<script>

 export default {
        data: () => ({
        }),
        
        methods: {
            logout:function() {

                axios.get('/logout')
                .then((response) => {
                  
                    window.location.href="/login"
                  
                })
                .catch(() => {
                    console.log('error log out ');
                });}
                
                    
                }


            
        
    }
</script>
