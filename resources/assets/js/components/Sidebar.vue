<template>
 <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-title">Navigation</li>

                    <li class="nav-item">
                      <router-link :to="'/'" class="nav-link active">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </router-link>
                    </li>            
                 <li class="nav-item">
                      <router-link :to="'/getCompagnies'" class="nav-link active">
                            <i class="far fa-building"></i> Ma Compagnie
                        </router-link>
                    </li>
                     
                   <li class="nav-item">
                      <router-link :to="'/ShowComptes'" class="nav-link active">
                            <i class="fas fa-address-book"></i>Compte
                        </router-link>
                    </li>
                    <li class="nav-item">
                      <router-link :to="'/Parametres'" class="nav-link active">
                            <i class="fas fa-cogs"></i>Paramètres
                        </router-link>
                    </li>    
               
   
                   <li class="nav-item">
                      <router-link :to="'/ShowArticles'" class="nav-link active">
                            <i class="fab fa-product-hunt"></i> Article
                        </router-link>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a href="#" class="nav-link nav-dropdown-toggle active">
                           <i class="fas fa-plus"></i> Vente <i class="fa fa-caret-left"></i>
                        </a>

                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <router-link :to="'/getDevis'" class="nav-link">
                                    <i class="far fa-file"></i> Devis
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link :to="'/ShowBonCommandes'" class="nav-link">
                                    <i class="far fa-file"></i> Bon  Commande
                                </router-link>
                            </li>

                            
                        </ul>
                    </li>
              
                    
                 
                </ul>
            </nav>
        </div> 
</template>
<style scoped>



</style>