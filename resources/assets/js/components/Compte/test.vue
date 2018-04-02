<template>
    <div>
        <div class="text-center">
    <h2>Modifier Compte</h2>
    <hr>
    </div>
        <ul id="breadcrumbs-two" class="pull-left">
    <li :id="breadcrumbstree"><a>Compte</a></li>
    <li><a @click="redirect_To_EditContact">Contact</a></li>
    <li><a href="#">Condition facture</a></li>
   
</ul>
        <form @submit.prevent="updateCompte">
         <div class="row" > 
         
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nom_compte"> nom_compte</label>
                    <input type="text" class="form-control" id="nom_compte"  v-model="compte.nom_compte">
                </div>
                <div class="form-group">
                    <label for="responsable"> responsable</label>
                    <input type="text" class="form-control" id="responsable"  v-model="compte.responsable">
                </div>
                <div class="form-group">
                    <label for="type_compte"> type_compte </label>
                    <input type="text" class="form-control" id="type_compte" v-model="compte.type_compte" >
                </div>
                <div class="form-group">
                    <label for="categorie"> categorie </label>
                    <input type="text" class="form-control" id="categorie" v-model="compte.categorie" >
                </div>
                <div class="form-group">
                    <label for="raison_social"> raison_social </label>
                    <input type="text" class="form-control" id="raison_social" v-model="compte.raison_social" >
                </div>
                <div class="form-group">
                    <label for="reference"> reference </label>
                    <input type="text" class="form-control" id="reference" v-model="compte.reference" >
                </div>
                <div class="form-group">
                    <label for="fixe"> fixe</label>
                    <input type="text" class="form-control" id="fixe" v-model="compte.fixe" >
                </div>
            
            </div>
            <div class="col-md-6"> 
                <div class="form-group">
                    <label for="portable"> portable </label>
                    <input type="text" class="form-control" id="portable" v-model="compte.portable">
                </div>    
                <div class="form-group">
                    <label for="fax"> fax </label>
                    <input type="text" class="form-control" id="fax" v-model="compte.fax">
                </div>
                <div class="form-group">
                    <label for="email"> email </label>
                    <input type="text" class="form-control" id="email" v-model="compte.email">
                </div>
                <div class="form-group">
                    <label for="site_web"> site_web </label>
                    <input type="text" class="form-control" id="site_web" v-model="compte.site_web">
                </div>
                <div class="form-group">
                    <label for="secteur_activite"> secteur_activite </label>
                    <input type="text" class="form-control" id="secteur_activite" v-model="compte.secteur_activite">
                </div>
                <div class="form-group">
                    <label for="taille"> taille </label>
                    <input type="text" class="form-control" id="taille" v-model="compte.taille">
                </div>                                                
                <div class="form-group">
                    <label for="RC">RC </label>
                    <input type="text" class="form-control" id="RC" v-model="compte.RC">
                </div>   

            </div> 
    </div>
     <button  class="btn btn-primary mr-20 btn-success">Enregister</button>
     </form>
    </div>
</template>

<script>

    export default{ 
        
          data: () => ({
             
              
breadcrumbstree : "breadcrumbs-tree",
            
            
            
              // objet test sur affichage , ajout , recherche
              Testopen:{
                testAjout : false,
                testAffiche : false,
              },
              testEdit : false,
        
              compte: { 
                    id_compte : 0,
                    nom_compte : "",
                    responsable : "",
                    type_compte : "",
                    categorie : "",
                    raison_social : "",
                    reference : "",
                    fixe : "",
                    portable : "",
                    fax : "",
                    email : "",
                    site_web  : "",
                    secteur_activite : "",
                    taille : "",
                    RC : "",
                    fk_compagnie : "",
              },
              // tableau des articles 
              comptes :[],

             
      }),
      

      methods: { 
         updateCompte: function(){
           
  
                  axios.post('/updateCompte',this.compte).then( response => {             
                    this.$router.push('/ShowComptes/editsuccess');  
                    
                  
                  });
                  
           
        },
             getCompte(id_compte){
                        
                        axios.get('/getCompte/'+id_compte)
                        
                        .then(response => {
                            // recuperé ensemble des articles sous format json
                           
                            this.compte = response.data.compte;                                
                        })
                        .catch(function (error) {
                           
                        });                                     
     },
            redirect_To_EditContact(){
                        this.$router.push('/EditContact/'+this.compte.id_compte);
            },
                     
      },
            mounted(){
                console.log(this.$route.params.id_compte);
          this.getCompte(this.$route.params.id_compte);
      }

     
       
        
      

    }
    
</script>

<style scoped>
 .btnMarge{
     padding-bottom: 10px;
 }
 .widthCard{
     width: 270px;
     height: 350px;
     
 }
 .widthTextCard{
     width  : 236px;
     height: 13px;
 }
 a {
  color: #999;
  color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    
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
.cardbox:hover{
 box-shadow: 1px 2px 2px 2px #c9ced2;
}
#breadcrumbs-two{
  overflow: hidden;
  width: 100%;
}

#breadcrumbs-two li{
  float: left;
  margin: 0 .5em 0 1em;
}

#breadcrumbs-two a{
  background: #ddd;
  padding: -0.3em 1em;
  float: left;
  text-decoration: none;
  color: #444;
  text-shadow: 0 1px 0 rgba(255,255,255,.5); 
  position: relative;
}

#breadcrumbs-two a:hover{
  background: #99db76;
}


#breadcrumbs-two a::before{
  content: "";
  position: absolute;
  top: 50%; 
  margin-top: -1.5em;   
  border-width: 1.5em 0 1.5em 1em;
  border-style: solid;
  border-color: #ddd #ddd #ddd transparent;
  left: -1em;
}

#breadcrumbs-two a:hover::before{
  border-color: #99db76 #99db76 #99db76 transparent;
}

#breadcrumbs-two a::after{
  content: "";
  position: absolute;
  top: 50%; 
  margin-top: -1.5em;   
  border-top: 1.5em solid transparent;
  border-bottom: 1.5em solid transparent;
  border-left: 1em solid #ddd;
  right: -1em;
}

#breadcrumbs-two a:hover::after{
  border-left-color: #99db76;
}

#breadcrumbs-two .current,
#breadcrumbs-two .current:hover{
  font-weight: bold;
  background: none;
}

#breadcrumbs-two .current::after,
#breadcrumbs-two .current::before{
  content: normal;
}

.activeBreadcrumbs a{
    background: #99db76;
}
.activeBreadcrumbs2 a{
    background: #99db76;
}


#breadcrumbs-tree a{
  background: #99db76;
}
#breadcrumbs-tree a::before{
  border-color: #99db76 #99db76 #99db76 transparent;
}
#breadcrumbs-tree a::after{
  border-left-color: #99db76;
}
</style>
