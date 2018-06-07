<template>
 <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-title">Navigation</li>

                    
               
   
                 

                    <li class="nav-item nav-dropdown">
                        <a href="#" class="nav-link nav-dropdown-toggle active">
                           <i class="fas fa-plus"></i> Vente <i class="fa fa-caret-left"></i>
                        </a>

                        <ul class="nav-dropdown-items">
                     
                             <li class="nav-item">
                                <router-link :to="'/FactureComptableV'" class="nav-link">
                                    <i class="far fa-file"></i> Facture
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="'/AvoirFactureComptableV'" class="nav-link">
                                    <i class="far fa-file"></i>Avoir Facture
                                </router-link>
                            </li>

                           
                            
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a href="#" class="nav-link nav-dropdown-toggle active">
                           <i class="fas fa-minus"></i> Achat <i class="fa fa-caret-left"></i>
                        </a>

                        <ul class="nav-dropdown-items">
                          
                             <li class="nav-item">
                                <router-link :to="'/FactureComptableA'" class="nav-link">
                                    <i class="far fa-file"></i> Facture
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="'/AvoirFactureComptableA'" class="nav-link">
                                    <i class="far fa-file"></i> Avoir Facture
                                </router-link>
                            </li>
                           

                           
                            
                        </ul>
                    </li>                   
              <li class="nav-item nav-dropdown">
                        <a href="#" class="nav-link nav-dropdown-toggle active">
                            <i class="fas fa-clipboard-list"></i> Bilan <i class="fa fa-caret-left"></i>
                        </a>

                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <router-link :to="'/BilanMois'" class="nav-link">
                                    <i class="far fa-file"></i> Bilan Par Mois
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="'/BilanAnnee'" class="nav-link">
                                    <i class="far fa-file"></i> Bilan Par Année
                                </router-link>
                            </li>
 
                        </ul>
                     </li>
                    
                 
                </ul>
            </nav>
        </div> 
</template>
<style scoped>
.sidebar{
    margin-top: 45px;
}


</style>