import Vue from 'vue'
import VueRouter from 'vue-router'
import Contents from './components/Contents.vue'
import Login from './components/Login.vue'
import AddUsers from './components/AddUsers.vue'
import AffUsers from './components/AffUsers.vue'
import EditUser from './components/EditUser.vue'

//import Guser from './components/Guser.vue'
Vue.use(VueRouter)
import  ShowArticles from './components/Article/ShowArticles.vue' 
import  AddArticles from './components/Article/AddArticle.vue' 
import  EditArticles from './components/Article/EditArticle.vue' 

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
      // route pour ajouter un utilisateur
        {    
            path:"/addUsers",
            component: AddUsers
        },
      // route pour afficher les utilisateurs
        {     
            path:"/getUsers",
            component: AffUsers
        },
     // route pour recuperer les donnees d'un utilisateur
        {     
            path:"/editUser/:id",
            component: EditUser
        },
         {     path:"/ShowArticles",
             component: ShowArticles,
             
         },

         {     path:"/AddArticles",
                component: AddArticles
        },
        {     path:"/EditArticles/:id_article",
                component: EditArticles
        },

    ],
   
})

export default router 