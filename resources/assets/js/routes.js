import Vue from 'vue'
import VueRouter from 'vue-router'
import Contents from './components/Contents.vue'
import Login from './components/Login.vue'

Vue.use(VueRouter)

const  router = new VueRouter({

    routes: [
        {
            path:"/",
            component: Contents
        },
        {     path:"/login",
             component: Login
         }
    ],
   
})

export default router 