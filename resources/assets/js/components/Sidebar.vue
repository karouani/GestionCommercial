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
                            <i class="fas fa-address-book"></i>Compagnie
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
 
                    <li class="nav-item">
                      <router-link :to="'/ShowCharges'" class="nav-link active">
                            <i class="fas fa-copyright"></i> Charge
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
                                    <i class="far fa-file"></i> Commande
                                </router-link>
                            </li>
                             <li class="nav-item">
                                <router-link :to="'/ShowBonLivraisons'" class="nav-link">
                                    <i class="far fa-file"></i> Bon  Livraison
                                </router-link>
                            </li>
                             <li class="nav-item">
                                <router-link :to="'/getFactures'" class="nav-link">
                                    <i class="far fa-file"></i> Facture
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="'/getAvoirFactures'" class="nav-link">
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
                                <router-link :to="'/getDevisA'" class="nav-link">
                                    <i class="far fa-file"></i> Devis
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link :to="'/ShowBonCommandesA'" class="nav-link">
                                    <i class="far fa-file"></i> Bon  Commande
                                </router-link>
                            </li>
                             <li class="nav-item">
                                <router-link :to="'/ShowBonLivraisonsA'" class="nav-link">
                                    <i class="far fa-file"></i> Bon Réception
                                </router-link>
                            </li>
                             <li class="nav-item">
                                <router-link :to="'/getFacturesA'" class="nav-link">
                                    <i class="far fa-file"></i> Facture
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="'/getAvoirFacturesA'" class="nav-link">
                                    <i class="far fa-file"></i>Avoir Facture
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
                            <li class="nav-item">
                                <router-link :to="'/EtatCheque'" class="nav-link">
                                    <i class="far fa-file"></i> Etat de chèque
                                </router-link>
                            </li>
 
                        </ul>
                     </li>
                    <li class="nav-item">
                      <router-link :to="'/ShowHistoriques'" class="nav-link active">
                            <i class="fas fa-history"></i> Historiques
                        </router-link>
                    </li>
                 
                </ul>
            </nav>
        </div> 
</template>
<style scoped>

.sidebar{
    margin-top:45px;
}

</style>