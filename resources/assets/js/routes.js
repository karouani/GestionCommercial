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
  //Devis
import AddDevis from './components/Devis/AddDevis.vue'
import AffDevis from './components/Devis/AffDevis.vue'
import DevisDetails from './components/Devis/DevisDetails.vue'
import EditDevis from './components/Devis/EditDevis.vue'




//Vue.use(VueRouter)

//articles
import  ShowArticles from './components/Article/ShowArticles.vue' 
import  AddArticles from './components/Article/AddArticle.vue' 
import  EditArticles from './components/Article/EditArticle.vue' 
//parametres
import  Parametres from './components/Parametres.vue' 


//comptes
import  ShowCompte from './components/Compte/ShowCompte.vue' 
import  ShowComptes from './components/Compte/ShowComptes.vue' 
import  AddCompte from './components/Compte/AddCompte.vue' 
import  EditCompte from './components/Compte/EditCompte.vue' 



// Bon de Commande
import  AddBonCommande from './components/BonCommande/AddBonCommande.vue' 
import  ShowBonCommandes from './components/BonCommande/ShowBonCommandes.vue' 
import  ShowBonCommande from './components/BonCommande/ShowBonCommande.vue' 
import  EditBonCommande from './components/BonCommande/EditBonCommande.vue' 



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
            component: AddUsers,
            meta:{
                SuperAdmin:true
            }
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
            path:"/getCompagnies/:success",
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
            
        },

        // ----------------------------------------------------------  // Devis 
// ajouter les devis 
        {    
            path:"/addDevis",
            component: AddDevis,
            name: "addDevis",
        },
        {    
            path:"/getDevis",
            component: AffDevis
        },
        {    
            path:"/getDevis/:success",
            component: AffDevis
        },
        {    
            path:"/DevisDetails/:id_devis",
            component: DevisDetails
        },
        {
        path:"/DevisDetails/:success/:id_devis",
        component: DevisDetails
        },
        {    
            path:"/EditDevis",
            component: EditDevis,
            name: "EditDevis",
        },


         // ----------------------------------------------------------  // Comptes

         {     path:"/ShowComptes",
             component: ShowComptes,
             name:"ShowComptes"
         },
         {     path:"/ShowCompte/:id_compte",
         component: ShowCompte,
         
         },
    
         {     path:"/AddCompte",
                component: AddCompte
        },
   
        {     path:"/EditCompte/:id_compte",
                component: EditCompte
        },
 
        // ----------------------------------------------------------  // condition facture

        // ----------------------------------------------------------  // Bon commande
        {     
        path:"/addBonCommande",
        component: AddBonCommande,
        name: "addBonCommande",
        },
        {     
            path:"/addBonCommande/:id_devis",
            component: AddBonCommande,
            },
        {     
         path:"/ShowBonCommandes",
          component: ShowBonCommandes,
          name: "ShowBonCommandes",
         },
        {     
         path:"/ShowBonCommande/:reference_bc",
         component: ShowBonCommande
            },
        {     
         path:"/EditBonCommande",
         component: EditBonCommande,
         name: "EditBonCommande",
        },           
        
    ],
   
})

export default router 