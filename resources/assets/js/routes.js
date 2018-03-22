import Vue from 'vue'
import VueRouter from 'vue-router'
import Contents from './components/Contents.vue'
import  ShowArticles from './components/Article/ShowArticles.vue' 
import  AddArticles from './components/Article/AddArticle.vue' 
import  EditArticles from './components/Article/EditArticle.vue' 

Vue.use(VueRouter) 

const  router = new VueRouter({

    routes: [
        {
            path:"/",
            component: Contents
        },
         {     path:"/ShowArticles",
             component: ShowArticles,
             
         },

         {     path:"/AddArticles",
                component: AddArticles
        },
        {     path:"/EditArticles/:id_article",
                component: EditArticles
        },

    ],
   
})

export default router 