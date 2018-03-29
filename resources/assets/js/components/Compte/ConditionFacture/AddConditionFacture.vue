<template>
    <div>

        <div class="text-center pull-right" >
    <h2>Ajouter Compte</h2>
    <hr>   
    </div>
    <ul id="breadcrumbs-two" class="pull-left">
    <li><a>Compte</a></li>
    <li><a href="#">Contact</a></li>
    <li :id="breadcrumbstree" ><a href="#">Condition facture</a></li>
   
</ul>
<hr>
        <form @submit.prevent="addConditionFacture">
         <div class="row" > 
         
            <div class="col-md-6">
                <div class="form-group">
                    <label for="devise"> devise</label>
                    <input type="text" class="form-control" id="devise"  v-model="condition_facture.devise">
                </div>
                <div class="form-group">
                    <label for="remise"> remise</label>
                    <input type="text" class="form-control" id="remise"  v-model="condition_facture.remise">
                </div>
                 <div class="form-group">
                <label for="delai_paiement">delai_paiement</label>
                
                    <input class="form-control" type="date" value="2011-08-19" id="delai_paiement" v-model="condition_facture.delai_paiement">
                
                </div>
                 <div class="form-group">
                    <label for="remarques"> remarques </label>
                    <input type="text" class="form-control" id="remarques" v-model="condition_facture.remarques" >
                </div>
            </div>
            <div class="col-md-6"> 
  
   
            </div> 
    </div>
     <button  class="btn btn-primary mr-20 btn-success">Enregister</button>
     </form>
    </div>
</template>

<script>

    export default{ 
        
          data: () => ({
             isActive: true,
              breadcrumbstree : "breadcrumbs-tree",

            
            
            
              // objet test sur affichage , ajout , recherche
              Testopen:{
                testAjout : false,
                testAffiche : false,
              },
              testEdit : false,
        
              condition_facture : { 
                    id_condition : 0,
                    devise: "",
                    remise: "",
                    delai_paiement : "",
                    remarques: "",
                    fk_compte : 0,

              },
              // tableau des articles 
              condition_factures :[],

             
      }),
      

      methods: { 
          addConditionFacture:function(){ 
           
               
              axios.post('/addCFacture',this.condition_facture).then(response => {         
                    console.log('condition facture Bien ajouter !');
                     this.$router.push('/ShowComptes/addsuccess');
                     //this.$router.push('/ShowComptes');
                     

                  });
            
        },
                     
      },
      mounted(){
          console.log(this.$route.params.id_compte);
          this.condition_facture.fk_compte = this.$route.params.id_compte;
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
ul{
  margin: 0;
  padding: 0;
  list-style: none;
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
