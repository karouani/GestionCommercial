<template>
  <div class="page-wrapper">
      <top-menu>

         
      </top-menu>
    <div class="main-container">
       <app-sidebar>

       </app-sidebar>
       <div class="content">
            <div class="container-fluid">
       <router-view></router-view>
            </div>
       </div>
    </div>

  </div>
</template>
<script>

import TopMenu from './TopMenu.vue' 
import Sidebar from './Sidebar.vue' 
import Contents from './Contents.vue' 
import  ShowArticles from './Article/ShowArticles.vue' 
import  Addrticles from './Article/AddArticle.vue'
import  EditArticle from './Article/EditArticle.vue' 
import Pagination from './Pagination.vue' 



export default {
   components:{
     'top-menu':TopMenu,
     'app-sidebar':Sidebar,
     'app-contents':Contents,
     'app-show-article':ShowArticles,
     'app-add-article':Addrticles,
     'app-edit-article':EditArticle ,
     'app_pagination':Pagination
     
     
  },
  data: () => ({
 
  }),


}
</script>