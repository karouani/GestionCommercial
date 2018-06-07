<template>
 <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-title">Navigation</li>

                    <li class="nav-item">
                      <router-link :to="'/'" v-on:click.native="setActive('Dashboard')" :class="{ active: isActive2('Dashboard'), 'nav-link': navTest }">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </router-link>
                    </li>            
                    <li class="nav-item">
                      <router-link :to="'/getCompagnies'"  v-on:click.native="setActive('Compagnie')" :class="{ active: isActive2('Compagnie'), 'nav-link': navTest }">
                            <i class="fas fa-address-book"></i>Compagnie
                        </router-link>
                    </li>
                     
                   <li class="nav-item">
                      <router-link :to="'/ShowComptes'" v-on:click.native="setActive('Compte')" :class="{ active: isActive2('Compte'), 'nav-link': navTest }">
                            <i class="fas fa-address-book"></i>Compte
                        </router-link>
                    </li>
                    <li class="nav-item">
                      <router-link :to="'/Parametres'" v-on:click.native="setActive('Parametres')" :class="{ active: isActive2('Parametres'), 'nav-link': navTest }">
                            <i class="fas fa-cogs"></i>Paramètres
                        </router-link>
                    </li>    
               
   
                   <li class="nav-item">
                      <router-link :to="'/ShowArticles'" v-on:click.native="setActive('Article')" :class="{ active: isActive2('Article'), 'nav-link': navTest }">
                            <i class="fab fa-product-hunt"></i> Article
                        </router-link>
                    </li>
 
                    <li class="nav-item">
                      <router-link :to="'/ShowCharges'" v-on:click.native="setActive('Charge')" :class="{ active: isActive2('Charge'), 'nav-link': navTest }">
                            <i class="fas fa-copyright"></i> Charge
                        </router-link>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a href="#"  v-on:click="setActive('Vente')" :class="{ active: isActive2('Vente'), 'nav-link': navTest ,'nav-dropdown-toggle': navDown}">
                           <i class="fas fa-plus"></i> Vente <i class="fa fa-caret-left"></i>
                        </a>

                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <router-link :to="'/getDevis'" v-on:click.native="setVente('DevisV')" class="nav-link">
                                    <i :style="[isVente2('DevisV') == true ? {color: greenColor} : {}]" class="far fa-file"></i> Devis
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link :to="'/ShowBonCommandes'" v-on:click.native="setVente('CommandeV')"  class="nav-link">
                                    <i :style="[isVente2('CommandeV') == true ? {color: greenColor} : {}]" class="far fa-file"></i> Commande
                                </router-link>
                            </li>
                             <li class="nav-item">
                                <router-link :to="'/ShowBonLivraisons'" v-on:click.native="setVente('BlV')"  class="nav-link">
                                    <i :style="[isVente2('BlV') == true ? {color: greenColor} : {}]" class="far fa-file"></i> Bon  Livraison
                                </router-link>
                            </li>
                             <li class="nav-item">
                                <router-link :to="'/getFactures'"  v-on:click.native="setVente('FactureV')"  class="nav-link">
                                    <i :style="[isVente2('FactureV') == true ? {color: greenColor} : {}]" class="far fa-file"></i> Facture
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="'/getAvoirFactures'"  v-on:click.native="setVente('AvoirFactureV')"  class="nav-link">
                                    <i :style="[isVente2('AvoirFactureV') == true ? {color: greenColor} : {}]"  class="far fa-file"></i>Avoir Facture
                                </router-link>
                            </li>

                           
                            
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a href="#"  v-on:click="setActive('Achat')" :class="{ active: isActive2('Achat'), 'nav-link': navTest ,'nav-dropdown-toggle': navDown}">
                           <i class="fas fa-minus"></i> Achat <i class="fa fa-caret-left"></i>
                        </a>

                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <router-link :to="'/getDevisA'"  v-on:click.native="setVente('DevisA')"  class="nav-link">
                                    <i :style="[isVente2('DevisA') == true ? {color: greenColor} : {}]" class="far fa-file"></i> Devis
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link :to="'/ShowBonCommandesA'" v-on:click.native="setVente('BcA')"   class="nav-link">
                                    <i :style="[isVente2('BcA') == true ? {color: greenColor} : {}]" class="far fa-file"></i> Bon  Commande
                                </router-link>
                            </li>
                             <li class="nav-item">
                                <router-link :to="'/ShowBonLivraisonsA'" v-on:click.native="setVente('BrA')"  class="nav-link">
                                    <i :style="[isVente2('BrA') == true ? {color: greenColor} : {}]" class="far fa-file"></i> Bon Réception
                                </router-link>
                            </li>
                             <li class="nav-item">
                                <router-link :to="'/getFacturesA'" v-on:click.native="setVente('FactureA')"  class="nav-link">
                                    <i :style="[isVente2('FactureA') == true ? {color: greenColor} : {}]" class="far fa-file"></i> Facture
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="'/getAvoirFacturesA'" v-on:click.native="setVente('AvoirFactureA')"  class="nav-link">
                                    <i :style="[isVente2('AvoirFactureA') == true ? {color: greenColor} : {}]" class="far fa-file"></i>Avoir Facture
                                </router-link>
                            </li>

                           
                            
                        </ul>
                    </li> 
                     <li class="nav-item nav-dropdown">
                        <a href="#" v-on:click="setActive('Bilan')" :class="{ active: isActive2('Bilan'), 'nav-link': navTest ,'nav-dropdown-toggle': navDown}">
                            <i class="fas fa-clipboard-list"></i> Bilan <i class="fa fa-caret-left"></i>
                        </a>

                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <router-link :to="'/BilanMois'"  v-on:click.native="setVente('BilanParMois')"  class="nav-link">
                                    <i :style="[isVente2('BilanParMois') == true ? {color: greenColor} : {}]" class="far fa-file"></i> Bilan Par Mois
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="'/BilanAnnee'"  v-on:click.native="setVente('BilanParAnnee')"  class="nav-link">
                                    <i :style="[isVente2('BilanParAnnee') == true ? {color: greenColor} : {}]" class="far fa-file"></i> Bilan Par Année
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="'/EtatCheque'"  v-on:click.native="setVente('EtatCheque')"  class="nav-link">
                                    <i :style="[isVente2('EtatCheque') == true ? {color: greenColor} : {}]" class="far fa-file"></i> Etat de chèque
                                </router-link>
                            </li>
 
                        </ul>
                     </li>
                    <li class="nav-item">
                      <router-link :to="'/ShowHistoriques'" v-on:click.native="setActive('Historiques')" :class="{ active: isActive2('Historiques'), 'nav-link': navTest }">
                            <i class="fas fa-history"></i> Historiques
                        </router-link>
                    </li>
                 
                </ul>
            </nav>
        </div> 
</template>
<script>
export default {
        data: () => ({
            greenColor:"rgb(33, 201, 96)",
            navDown:true,
                isActive : true,
                navTest : true,
                activeItem: 'Dashboard',
                activeItem2: '',
        }),
        methods:{
            isActive2: function (menuItem) {
                
                console.log(this.activeItem === menuItem)
                return this.activeItem === menuItem
                },
                setActive: function (menuItem) {
                    console.log("test : ")
                this.activeItem = menuItem // no need for Vue.set()
                },
        
        isVente2: function (menuItem2) {
                
                console.log(this.activeItem2 === menuItem2)
                return this.activeItem2 === menuItem2
                },
        setVente: function (menuItem2) {
                    console.log("test : ")
                this.activeItem2 = menuItem2 // no need for Vue.set()
                }
        
        
        
        }}
</script>
<style scoped>

.sidebar{
    margin-top:45px;
}

</style>
