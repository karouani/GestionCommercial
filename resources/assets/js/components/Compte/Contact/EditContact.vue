<template>
    <div>

        <div class="text-center pull-right" >
    <h2>Modifer Contact</h2>
    <hr>   
    </div>
    <ul id="breadcrumbs-two" class="pull-left">
    <li><a>Compte</a></li>
    <li :id="breadcrumbstree" ><a href="#">Contact</a></li>
    <li><a href="#">Condition facture</a></li>
   
</ul>
<hr>
        <form @submit.prevent="updateContact">
         <div class="row" > 
         
            <div class="col-md-6">
                 <tr>
                        
                  
                        <th>
                            <!--Remise -->
                    <input class="mr-4"  type="text" v-model="contact.prenom" >
                        </th>
                        <th>
                             <!--majoration -->
                    <input class="mr-4"  type="text" v-model="contact.prenom">
                        </th>
                 </tr>
   
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
        
              contact: { 
                    id_contact : 0,
                    prenom : "",
                    nom : "",
                    civilite : "",
                    fonction : "",
                    email : "",
                    fixe : "",
                    mobile : "",
                    fk_compte : 0,
              },
              // tableau des articles 
              contacts :[],

             
      }),
      

      methods: { 
          updateContact:function(){ 
           
               
              axios.post('/updateContact',this.contact).then(response => {         
                    console.log('contact Bien ajouter !');
                     //this.$router.push('/ShowComptes/addsuccess');
                     //this.$router.push('/ShowComptes');
                     this.$router.push('/EditCompte/'+this.contact.fk_compte);

                  });
            
        },
        getContact:function(){ 
                console.log('fkkkkk : '+this.contact.fk_compte );
            axios.get('/getContact/'+this.contact.fk_compte)
                .then((response) => {
                  console.log('shitttt');
                    this.contact = response.data.contact[0];
                  console.log(response.data.contact);
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
        }
                     
      },
      mounted(){
          this.contact.fk_compte = this.$route.params.id_compte;
          this.getContact();
          console.log(this.$route.params.id_compte);
          
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
