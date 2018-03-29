<template>
  <div class="contenu">
          <div class="loading" v-if="loading">
      Loading...
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
   <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testEdit">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Profile Bien Modifier !</strong>
   </div>

   <div>

      
 
    <!-- afficher les utilisateurs sous formes des cards  -->
    <div class="row">
        <div class="card "  >
            <div class="card-body ">
                
        <div class="col img">
            <img v-if="user.photo != ''" class="img-right" :src="'storage/images/'+user.photo" alt="Card image cap" width="100px" height="100px">
            <img v-if="user.photo === ''" class="img-right" :src="'storage/images/user0.jpg'" alt="Card image cap" width="100px" height="100px">
               
            </div>
            </div>
        </div>
                    <div class="card widthCard"  >
                         <div class="card-body">
            <div class="col text"> 
                 <h5 class="card-title">User Name : {{user.name}}</h5>
                
                    <hr>
                    <div class="widthTextCard">E-mail  :  {{ user.email}}</div>
                    <hr>
                    <div class="widthTextCard">Role  :  {{user.role}}</div>
                    <hr>
                
                
                <router-link :to="'/editProfile'">
                    <a href="#" class="btn btn-success float-right "><i class="fas fa-edit d-inline-block"></i></a>
                 </router-link>        
                  
            </div>
            </div>
        </div>
 
           
    </div>
  
    <!-- fin affiche -->
    </div>
</div>
    </div>
</template>


<script>

    export default{
        
    data: () => ({
           loading: false,

         
        user: {
           id:0,
           names:"",
           email:"",
           password:"",
           role:"",
           photo:"",
      
        },
        // objet test sur affichage , ajout , recherche
              Testopen:{
                testAjout : false,
                testEdit : false,
                testmodelArticle : false,
              },
        users:[]
    }),

   // remplire listes des articles aprés la creation complet de ce composant
   created(){
  this.getProfile();
   },
    mounted(){
         
             if(this.$route.params.success == "edit")
            this.Testopen.testEdit =true;   

           
    },

    updated:function(){
     let that=this;
     setTimeout(function(){that.Testopen.testEdit = false;}, 2000);
    },

    methods: {
          
              // methode pour afficher tous les users                  
              getProfile(){
                   this.loading = true
                axios.get('/getProfile')
                .then(response => {
                    this.user = response.data.user[0];
                     this.loading = false;
                    console.log(response.data.user[0])
                })
                .catch(error => {
                })
    },
        
      
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                this.nameFile = files[0].name;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },


            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.user.photo = e.target.result;
                    
                };
                reader.readAsDataURL(file);
            },
        
    },

}
    
</script>

<style scoped>
 .btnMarge{
     padding-bottom: 10px;
 }
 .text{
     padding-top: 25px;
 }
 .img{
     padding: 0px 5px;

 }
 .img-right{
    width: 300px;
     height: 300px;
     float: left;
 }
 .widthCard{
     width: 50%;
    /*height: 330px;*/
 }
 .widthTextCrd{
     width  : 236px;
     height: 13px;
 }
 a {
  color: #999;
}
.current {
  color: red;
}
ul {
  padding: 0;
  list-style-type: none;
}
li {
  display: inline;
  margin: 5px 5px;
}

a.first::after {
  content:'...'
}

a.last::before {
  content:'...'
}
.contenu {
  
    padding-left: 150px;
    padding-top: 100px;
}
.show{
     opacity:0.9;
    width: 233px;
    z-index: 100;
    top: 61px;
    right: 0;
    position:  absolute;
    position :fixed;}
</style>
