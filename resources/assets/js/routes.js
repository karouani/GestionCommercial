import Vue from 'vue'
import VueRouter from 'vue-router'
import Contents from './components/Contents.vue'
import Login from './components/Login.vue'
  //users
import AddUsers from './components/User/AddUsers.vue'
import AffUsers from './components/User/AffUsers.vue'
import EditUser from './components/User/EditUser.vue'
import UserConnect from './components/User/UserConnect.vue'
   //Compagnies
import AddCompagnie from './components/Compagnie/AddCompagnie.vue'
import AffCompagnie from './components/Compagnie/AffCompagnie.vue'
import EditCompagnie from './components/Compagnie/EditCompagnie.vue'



Vue.use(VueRouter)

//articles
import  ShowArticles from './components/Article/ShowArticles.vue' 
import  AddArticles from './components/Article/AddArticle.vue' 
import  EditArticles from './components/Article/EditArticle.vue' 
//parametres
import  Parametres from './components/Parametres.vue' 

Vue.use(VueRouter) 

const  router = new VueRouter({

    routes: [
        // route gestion de commerce
        {
            path:"/",
            component: Contents
        },
       // route d'authentification
        {   
            path:"/login",
            component: Login
        }, 
        
        


         // ----------------------------------------------------------  // Users 
      // route pour ajouter un utilisateur
        {    
            path:"/addUsers",
            component: AddUsers
        },
      // route pour afficher les utilisateurs
        {   

            path:"/getUsers/:success",
            component: AffUsers
        },
        {   
              
            path:"/getUsers",
            component: AffUsers
        },
     // route pour recuperer les donnees d'un utilisateur
        {     
            path:"/editProfile",
            component: EditUser
        },
        {
            path:"/getProfile",
            component: UserConnect
        },
        {
        path:"/getProfile/:success",
        component: UserConnect
        },

                     //Compagnie

        {    
            path:"/addCompagnie",
            component: AddCompagnie
        },
        {    
            path:"/getCompagnies",
            component: AffCompagnie
        },
        {    
            path:"/EditCompagnie/:id_compagnie",
            component: EditCompagnie
        },

                   


        // ----------------------------------------------------------  // Articles 
            // afficher les articles 
         {     path:"/ShowArticles",
             component: ShowArticles,
             
         },
         // afficher les articles  avec add ou edit success
         {     path:"/ShowArticles/:success",
         component: ShowArticles,
         
          },
        // ajouter les articles 
         {     path:"/AddArticles",
                component: AddArticles
        },
        // modifier un articles 
        {     path:"/EditArticles/:id_article",
                component: EditArticles
        },

        // ----------------------------------------------------------  // parametres
        { 
            path:"/Parametres",
                component: Parametres
            
        }





    ],
   
})

export default router 