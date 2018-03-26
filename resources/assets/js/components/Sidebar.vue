<template>
 <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-title">Navigation</li>

                    <li class="nav-item">
                      <router-link :to="'/'" class="nav-link active">
                            <i class="icon icon-speedometer"></i> Dashboard
                        </router-link>
                    </li>
                    <li class="nav-item">
                      <router-link :to="'/Parametres'" class="nav-link active">
                            <i class="icon icon-speedometer"></i> Paramètres
                        </router-link>
                    </li>                    
                     <li class="nav-item nav-dropdown">
                        <a href="#" class="nav-link nav-dropdown-toggle active">
                            <i class="icon icon-speedometer"></i> Article <i class="fa fa-caret-left"></i>
                        </a>

                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <router-link :to="'/ShowArticles'" class="nav-link">
                                    <i class="icon icon-target"></i> Afficher Article
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link :to="'/AddArticles'" class="nav-link">
                                    <i class="icon icon-target"></i> Ajouter Article
                                </router-link>
                            </li>

                            
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a href="#" class="nav-link nav-dropdown-toggle">
                            <i class="icon icon-target"></i> Ma Compagnie <i class="fa fa-caret-left"></i>
                        </a>

                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <router-link :to="'/getCompagnies'" class="nav-link">
                                    <i class="icon icon-target"></i> Afficher Compagnie
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link :to="'/addCompagnie'" class="nav-link">
                                    <i class="icon icon-target"></i> Ajouter Compagnie
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