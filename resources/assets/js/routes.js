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
import CompagnieDetails from './components/Compagnie/CompagnieDetails.vue'
                /// -----------  Vente --------------------------
  //Devis
import AddDevis from './components/Vente/Devis/AddDevis.vue'
import AffDevis from './components/Vente/Devis/AffDevis.vue'
import DevisDetails from './components/Vente/Devis/DevisDetails.vue'
import EditDevis from './components/Vente/Devis/EditDevis.vue'


// Bon de Commande
import  AddBonCommande from './components/Vente/BonCommande/AddBonCommande.vue' 
import  ShowBonCommandes from './components/Vente/BonCommande/ShowBonCommandes.vue' 
import  ShowBonCommande from './components/Vente/BonCommande/ShowBonCommande.vue' 
import  EditBonCommande from './components/Vente/BonCommande/EditBonCommande.vue' 

// Bon de Livraison
import  AddBonLivraison from './components/Vente/BonLivraison/AddBonLivraison.vue' 
import  ShowBonLivraisons from './components/Vente/BonLivraison/ShowBonLivraisons.vue' 
import  ShowBonLivraison from './components/Vente/BonLivraison/ShowBonLivraison.vue' 
import  EditBonLivraison from './components/Vente/BonLivraison/EditBonLivraison.vue' 
 //Factures
 import AddFacture from './components/Vente/Facture/AddFacture.vue'
 import AffFactures from './components/Vente/Facture/AffFactures.vue'
 import FactureDetails from './components/Vente/Facture/FactureDetails.vue'
 import EditFacture from './components/Vente/Facture/EditFacture.vue'
 //Avoir Factures
 import AddAvoirFacture from './components/Vente/AvoirFacture/AddAvoirFacture.vue'
 import AffAvoirFactures    from './components/Vente/AvoirFacture/AffAvoirFactures.vue'
 import AvoirFactureDetails from './components/Vente/AvoirFacture/AvoirFactureDetails.vue'
 import EditAvoirFacture from './components/Vente/AvoirFacture/EditAvoirFacture.vue'



                    /// -----------  Achat --------------------------
  //Devis
  import AddDevisA from './components/Achat/Devis/AddDevis.vue'
  import AffDevisA from './components/Achat/Devis/AffDevis.vue'
  import DevisDetailsA from './components/Achat/Devis/DevisDetails.vue'
  import EditDevisA from './components/Vente/Devis/EditDevis.vue'

  // Bon de Commande
  import  AddBonCommandeA from './components/Achat/BonCommande/AddBonCommande.vue' 
  import  ShowBonCommandesA from './components/Achat/BonCommande/ShowBonCommandes.vue' 
  import  ShowBonCommandeA from './components/Achat/BonCommande/ShowBonCommande.vue' 
  import  EditBonCommandeA from './components/Achat/BonCommande/EditBonCommande.vue' 
  
  // Bon de reception
  import  AddBonLivraisonA from './components/Achat/BonLivraison/AddBonLivraison.vue' 
  import  ShowBonLivraisonsA from './components/Achat/BonLivraison/ShowBonLivraisons.vue' 
  import  ShowBonLivraisonA from './components/Achat/BonLivraison/ShowBonLivraison.vue' 
  import  EditBonLivraisonA from './components/Achat/BonLivraison/EditBonLivraison.vue' 
   //Factures
   import AddFactureA from './components/Achat/Facture/AddFacture.vue'
   import AffFacturesA from './components/Achat/Facture/AffFactures.vue'
   import FactureDetailsA from './components/Achat/Facture/FactureDetails.vue'
   import EditFactureA from './components/Achat/Facture/EditFacture.vue'
   //Avoir Factures
   import AddAvoirFactureA from './components/Achat/AvoirFacture/AddAvoirFacture.vue'
   import AffAvoirFacturesA    from './components/Achat/AvoirFacture/AffAvoirFactures.vue'
   import AvoirFactureDetailsA from './components/Achat/AvoirFacture/AvoirFactureDetails.vue'
   import EditAvoirFactureA from './components/Achat/AvoirFacture/EditAvoirFacture.vue'
  


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

//Charges
import  ShowCharges from './components/Charge/ShowCharges.vue' 
import  AddCharge from './components/Charge/AddCharge.vue' 
import  EditCharge from './components/Charge/EditCharge.vue' 
//mouvement 
import  ShowMouvements from './components/Mouvement/ShowMouvements.vue' 





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
                TopAdmin:true,
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
            component: AddCompagnie,
            SuperAdmin:true,
            Admin:true
        },
        {    
            path:"/getCompagnies",
            component: AffCompagnie,
            meta:{
            SuperAdmin:true,
            Admin:true
            }
        },
        {    
            path:"/getCompagnies/:success",
            component: AffCompagnie,
            meta:{
                SuperAdmin:true,
                Admin:true
                }
        },
        {    
            path:"/EditCompagnie/:id_compagnie",
            component: EditCompagnie,
            meta:{
                SuperAdmin:true,
                Admin:true
                }
        },
        {    
            path:"/CompagnieDetails",
            component: CompagnieDetails,
            name: "CompagnieDetails",
            meta:{
                SuperAdmin:true,
                Admin:true
                }
        },
                   


        // ----------------------------------------------------------  // Articles 
            // afficher les articles 
         {     path:"/ShowArticles",
             component: ShowArticles,
                meta:{
                SuperAdmin:true,
                Admin:true
                }
         },
         // afficher les articles  avec add ou edit success
         {     path:"/ShowArticles/:success",
         component: ShowArticles,
                meta:{
                SuperAdmin:true,
                Admin:true
                }
          },
        // ajouter les articles 
         {     path:"/AddArticles",
                component: AddArticles
        },
        // modifier un articles 
        {     path:"/EditArticles/:id_article",
                component: EditArticles,
                meta:{
                    SuperAdmin:true,
                    Admin:true
                    }
        },

        // ----------------------------------------------------------  // parametres
        { 
            path:"/Parametres",
                component: Parametres,
                meta:{
                    SuperAdmin:true,
                    Admin:true
                    }
            
        },

        // ----------------------------------------------------------  // Devis 
// ajouter les devis 
        {    
            path:"/addDevis",
            component: AddDevis,
            name: "addDevis",
            meta:{
                SuperAdmin:true,
                Admin:true
                }
        },
        {    
            path:"/getDevis",
            component: AffDevis,
            meta:{
                SuperAdmin:true,
                Admin:true
                }
        },
        {    
            path:"/getDevis/:success",
            component: AffDevis,
            meta:{
                SuperAdmin:true,
                Admin:true
                }
        },
        {    
            path:"/DevisDetails",
            component: DevisDetails,
            name: "DevisDetails",
            meta:{
                SuperAdmin:true,
                Admin:true
                }
        },
        {
            path:"/DevisDetails/:success/:id_devis",
            component: DevisDetails,
            meta:{
                SuperAdmin:true,
                Admin:true
                }

        },
        {    
            path:"/EditDevis",
            component: EditDevis,
            name: "EditDevis",
            meta:{
                SuperAdmin:true,
                Admin:true
                }
        },


         // ----------------------------------------------------------  // Comptes

         {     path:"/ShowComptes",
             component: ShowComptes,
             name:"ShowComptes",
             meta:{
                SuperAdmin:true,
                Admin:true
                }
         },
         {     path:"/ShowCompte/:id_compte",
         component: ShowCompte,
         meta:{
            SuperAdmin:true,
            Admin:true
            }
         
         },
    
         {     path:"/AddCompte",
                component: AddCompte,
                meta:{
                    SuperAdmin:true,
                    Admin:true
                    }
        },
   
        {     path:"/EditCompte/:id_compte",
                component: EditCompte,
                meta:{
                    SuperAdmin:true,
                    Admin:true
                    }
        },
 
        // ----------------------------------------------------------  // condition facture

        // ----------------------------------------------------------  // Bon commande
        {     
        path:"/addBonCommande",
        component: AddBonCommande,
        name: "addBonCommande",
        meta:{
            SuperAdmin:true,
            Admin:true
            }
        },
        {     
            path:"/addBonCommande/:id_devis",
            component: AddBonCommande,
            meta:{
                SuperAdmin:true,
                Admin:true
                }
            },
        {     
         path:"/ShowBonCommandes",
          component: ShowBonCommandes,
          name: "ShowBonCommandes",
          meta:{
            SuperAdmin:true,
            Admin:true
            }
         },
        {     
         path:"/ShowBonCommande/:reference_bc",
         component: ShowBonCommande,
         meta:{
            SuperAdmin:true,
            Admin:true
            }
            },
        {     
         path:"/EditBonCommande",
         component: EditBonCommande,
         name: "EditBonCommande",
         meta:{
            SuperAdmin:true,
            Admin:true
            }
        },  
        
        
               // ----------------------------------------------------------  // Factures 
// ajouter les factures 
{    
    path:"/addFacture",
    component: AddFacture,
    name: "addFacture",
    meta:{
        SuperAdmin:true,
        Admin:true
        }
},
{    
    path:"/getFactures",
    component: AffFactures
},
{    
    path:"/getFactures/:success",
    component: AffFactures
},
{    
    path:"/FactureDetails",
    component: FactureDetails,
    name: "FactureDetails"
},
{
    path:"/FactureDetails/:success/:id_facture",
    component: FactureDetails,

},
{    
    path:"/EditFacture",
    component: EditFacture,
    name: "EditFacture",
    meta:{
        SuperAdmin:true,
        Admin:true
        }
},       
                     // ----------------------------------------------------------  // AvoirFactures 
// ajouter les Avoir Facture 
{    
    path:"/addAvoirFacture",
    component: AddAvoirFacture,
    name: "addAvoirFacture",
    meta:{
        SuperAdmin:true,
        Admin:true
        }
},
{    
    path:"/getAvoirFactures",
    component: AffAvoirFactures
},
{    
    path:"/getAvoirFactures/:success",
    component: AffAvoirFactures
},  
{    
    path:"/AvoirFactureDetails",
    component: AvoirFactureDetails,
    name: "AvoirFactureDetails"
},
{
    path:"/AvoirFactureDetails/:success/:id_af",
    component: AvoirFactureDetails,

},
{    
    path:"/EditAvoirFacture",
    component: EditAvoirFacture,
    name: "EditAvoirFacture",
    meta:{
        SuperAdmin:true,
        Admin:true
        }
},        
        // ----------------------------------------------------------  // Bon Livraison
        {     
            path:"/addBonLivraison",
            component: AddBonLivraison,
            name: "addBonLivraison",
            meta:{
                SuperAdmin:true,
                Admin:true
                }
            },
            {     
                path:"/addBonLivraison/:id_bonCommande",
                component: AddBonLivraison,
                meta:{
                    SuperAdmin:true,
                    Admin:true
                    }
                },
            {     
             path:"/ShowBonLivraisons",
              component: ShowBonLivraisons,
              name: "ShowBonLivraisons",
              meta:{
                SuperAdmin:true,
                Admin:true
                }
             },
            {     
             path:"/ShowBonLivraison/:reference_bl",
             component: ShowBonLivraison,
             meta:{
                SuperAdmin:true,
                Admin:true
                }
                },
            {     
             path:"/EditBonLivraison",
             component: EditBonLivraison,
             name: "EditBonLivraison",
             meta:{
                SuperAdmin:true,
                Admin:true
                }
            }, 
            
            
///----------------------------------  Achat ------------------------------------ ----------------- ----------------- 


                  // ----------------------------------------------------------  // Devis 
// ajouter les devis 
        {    
            path:"/addDevisA",
            component: AddDevisA,
            name: "addDevisA",
            meta:{
                SuperAdmin:true,
                Admin:true
                }
        },
        {    
            path:"/getDevisA",
            component: AffDevisA,
            meta:{
                SuperAdmin:true,
                Admin:true
                }
        },
        {    
            path:"/getDevisA/:success",
            component: AffDevisA,
            meta:{
                SuperAdmin:true,
                Admin:true
                }
        },
        {    
            path:"/DevisDetailsA",
            component: DevisDetailsA,
            name: "DevisDetailsA",
            meta:{
                SuperAdmin:true,
                Admin:true
                }
        },
        {
            path:"/DevisDetailsA/:success/:id_devis",
            component: DevisDetailsA,
            meta:{
                SuperAdmin:true,
                Admin:true
                }

        },
        {    
            path:"/EditDevisA",
            component: EditDevisA,
            name: "EditDevisA",
            meta:{
                SuperAdmin:true,
                Admin:true
                }
        },

        // ----------------------------------------------------------  // Bon commande
        {     
            path:"/addBonCommandeA",
            component: AddBonCommandeA,
            name: "addBonCommandeA",
            meta:{
                SuperAdmin:true,
                Admin:true
                }
            },
            {     
                path:"/addBonCommandeA/:id_devis",
                component: AddBonCommandeA,
                meta:{
                    SuperAdmin:true,
                    Admin:true
                    }
                },
            {     
            path:"/ShowBonCommandesA",
            component: ShowBonCommandesA,
            name: "ShowBonCommandesA",
            meta:{
                SuperAdmin:true,
                Admin:true
                }
            },
            {     
            path:"/ShowBonCommandeA/:reference_bc",
            component: ShowBonCommandeA,
            meta:{
                SuperAdmin:true,
                Admin:true
                }
                },
            {     
            path:"/EditBonCommandeA",
            component: EditBonCommandeA,
            name: "EditBonCommandeA",
            meta:{
                SuperAdmin:true,
                Admin:true
                }
            },                 
                        // ----------------------------------------------------------  // Bon Livraison
        {     
            path:"/addBonLivraisonA",
            component: AddBonLivraisonA,
            name: "addBonLivraisonA",
            meta:{
                SuperAdmin:true,
                Admin:true
                }
            },
            {     
                path:"/addBonLivraisonA/:id_bonCommande",
                component: AddBonLivraisonA,
                meta:{
                    SuperAdmin:true,
                    Admin:true
                    }
                },
            {     
             path:"/ShowBonLivraisonsA",
              component: ShowBonLivraisonsA,
              name: "ShowBonLivraisonsA",
              meta:{
                SuperAdmin:true,
                Admin:true
                }
             },
            {     
             path:"/ShowBonLivraisonA/:reference_bl",
             component: ShowBonLivraisonA ,
             meta:{
                SuperAdmin:true,
                Admin:true
                }
                },
            {     
             path:"/EditBonLivraisonA",
             component: EditBonLivraisonA,
             name: "EditBonLivraisonA",
             meta:{
                SuperAdmin:true,
                Admin:true
                }
            }, 
                           // ----------------------------------------------------------  // Factures 
// ajouter les factures 
{    
    path:"/addFactureA",
    component: AddFactureA,
    name: "addFactureA",
    meta:{
        SuperAdmin:true,
        Admin:true
        }
},
{    
    path:"/getFacturesA",
    component: AffFacturesA
},
{    
    path:"/getFacturesA/:success",
    component: AffFacturesA
},
{    
    path:"/FactureDetailsA",
    component: FactureDetailsA,
    name: "FactureDetailsA"
},
{
    path:"/FactureDetailsA/:success/:id_facture",
    component: FactureDetailsA,

},
{    
    path:"/EditFactureA",
    component: EditFactureA,
    name: "EditFactureA",
    meta:{
        SuperAdmin:true,
        Admin:true
        }
},       

                    // ----------------------------------------------------------  // AvoirFactures 
// ajouter les Avoir Facture 
{    
    path:"/addAvoirFactureA",
    component: AddAvoirFactureA,
    name: "addAvoirFactureA",
    meta:{
        SuperAdmin:true,
        Admin:true
        }
},
{    
    path:"/getAvoirFacturesA",
    component: AffAvoirFacturesA
},
{    
    path:"/getAvoirFacturesA/:success",
    component: AffAvoirFacturesA
},  
{    
    path:"/AvoirFactureDetailsA",
    component: AvoirFactureDetailsA,
    name: "AvoirFactureDetailsA"
},
{
    path:"/AvoirFactureDetailsA/:success/:id_af",
    component: AvoirFactureDetailsA,

},
{    
    path:"/EditAvoirFactureA",
    component: EditAvoirFactureA,
    name: "EditAvoirFactureA",
    meta:{
        SuperAdmin:true,
        Admin:true
},
        
},   
{    
    path:"/ShowMouvements",
    component: ShowMouvements,
    name: "ShowMouvements",
    meta:{
        SuperAdmin:true,
        Admin:true
},
        
},




  // ----------------------------------------------------------  // Charges 
            // afficher les Charges 
            {     path:"/ShowCharges",
            component: ShowCharges,
               meta:{
               SuperAdmin:true,
               Admin:true
               }
        },
        // afficher les Charges  avec add ou edit success
        {     path:"/ShowCharges",
        component: ShowCharges,
        name: "ShowCharges",
               meta:{
               SuperAdmin:true,
               Admin:true
               }
         },
       // ajouter les Charges 
        {     path:"/AddCharge",
               component: AddCharge
       },
       // modifier un Charges 
       {     path:"/EditCharge",
               component: EditCharge,
               name: "EditCharge",
               meta:{
                   SuperAdmin:true,
                   Admin:true
                   }
       },

    ],
   
})

export default router 