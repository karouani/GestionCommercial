<template>
  <div class="page-wrapper">
      <top-menu-comptable>

         
      </top-menu-comptable>
    <div class="main-container">
        <app-sidebar-comptable></app-sidebar-comptable>
       <div class="content">
            <div class="container-fluid">
       <router-view></router-view>
            </div>
       </div>
    </div>

  </div>
</template>
<script>

import TopMenuComptable from './TopMenuComptable.vue' 
import Sidebar from './Sidebar.vue' 
import SidebarComptable from './SidebarComptable.vue' 
import Contents from './Contents.vue' 
import  ShowArticles from './Article/ShowArticles.vue' 
import  Addrticles from './Article/AddArticle.vue'
import  EditArticle from './Article/EditArticle.vue' 
import Pagination from './Pagination.vue' 

//compte
import  ShowComptes from './Compte/ShowComptes.vue' 
import  AddCompte from './Compte/AddCompte.vue' 
import  EditCompte from './Compte/EditCompte.vue' 



export default {
   components:{
     'top-menu-comptable':TopMenuComptable,
     'app-sidebar':Sidebar,
     'app-contents':Contents,
     'app-show-article':ShowArticles,
     'app-add-article':Addrticles,
     'app-edit-article':EditArticle ,
     'app_pagination':Pagination,
     'app-sidebar-comptable':SidebarComptable,
     
  },
  data: () => ({
 
  }),


}
</script>
<style scoped>
.content{
  margin-top:47px;
}

</style>
