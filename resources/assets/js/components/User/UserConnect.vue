<template>
  <div class="contenu">
        <notifications group="foo" 
      position="bottom right" 
      classes="vue-notification success"/> 
          <div class="loading" v-if="loading">
     <div class="lds-hourglass"></div>
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
                 <h5 class="card-title">Nom Utilisateur : {{user.name}}</h5>
                
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
error: "",
         
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
         
              if( this.$route.params.success == "edit"){
        
                                               this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Profile bien modifier!',
                                      duration: 1500,
                                    });
        }
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

.lds-hourglass {
  display: inline-block;
  position: relative;
  width: 0px;
  height: 20px;
}
.lds-hourglass:after {
  content: " ";
  display: block;
  border-radius: 50%;
  width: 0;
  height: 0;
  margin: 6px;
  box-sizing: border-box;
  border: 15px solid #fff;
  border-color: rgb(0, 0, 0) transparent rgb(0, 0, 0) transparent;
  animation: lds-hourglass 1.2s infinite;
}
@keyframes lds-hourglass {
  0% {
    transform: rotate(0);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
  }
  50% {
    transform: rotate(900deg);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
  }
  100% {
    transform: rotate(1800deg);
  }
}
</style>
