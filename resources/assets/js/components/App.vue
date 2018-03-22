<template>
  <div class="page-wrapper">
      <top-menu>
         
      </top-menu>
    <div class="main-container">
       <app-sidebar>

       </app-sidebar>
       <router-view></router-view>
    </div>

  </div>
</template>
<script>

import TopMenu from './TopMenu.vue' 
import Sidebar from './Sidebar.vue' 
import Contents from './Contents.vue' 

export default {
   components:{
     'top-menu':TopMenu,
     'app-sidebar':Sidebar,
     'app-contents':Contents,
    

  },
  data: () => ({
   
  }),
 

}
</script>