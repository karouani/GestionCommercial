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
              
                    
                 
                </ul>
            </nav>
        </div> 
</template>
<style scoped>



</style>