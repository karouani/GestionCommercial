<template>
    <div>
 <div class="text-center pull-right" >

                  <div class=" btnMarge">
        <div class="col">
        <router-link class="btn btn-primary mb-3 retour  float-right " :to="'/ShowArticles'"> <i class="fas fa-long-arrow-alt-left fontsize"></i>  </router-link>
        </div>
    </div>   
    <h2>Ajouter Article</h2>
    <hr>
    </div>
        <form @submit.prevent="addArticle">
         <div class="row" > 
         
            <div class="col-md-6">
                <div class="form-group">
                    <label for="reference_art"> Code Article</label>
                    <input type="text" class="form-control" id="reference_art"  v-model="article.reference_art">
                </div>
                <div class="form-group">
                    <label for="type_art"> Type </label>
                    <input type="text" class="form-control" id="type_art" v-model="article.type_art" >
                </div>
                <div class="form-group">
                    <label for="designation"> Désignation </label>
                    <input type="text" class="form-control" id="designation" v-model="article.designation" >
                </div>
                <div class="form-group">
                    <label for="description"> Déscription </label>
                <textarea placeholder="Description article"  name="" id="description" class="form-control" rows="4" v-model="article.description"></textarea>
                </div>
                <div class="form-group">
                    <label for="prix_ht_achat"> Prix HT Achat </label>
                    <input type="text" class="form-control" id="prix_ht_achat" v-model="article.prix_ht_achat" >
                </div>
                <div class="form-group">
                    <label for="prix_ht_vente"> Prix HT Vente</label>
                    <input type="text" class="form-control" id="prix_ht_vente" v-model="article.prix_ht_vente" >
                </div>
            </div>
            <div class="col-md-6"> 
                <div class="form-group">
                    <label for="unite"> Unité </label>
                    <input type="text" class="form-control" id="unite" v-model="article.unite">
                </div>
                <div class="form-group">
                    <label for="quantite"> Quantité </label>
                    <input type="text" class="form-control" id="quantite" v-model="article.quantite">
                </div>
                <div class="form-group">
                    <label for="quantite_min"> Quantité minimum </label>
                    <input type="text" class="form-control" id="quantite_min" v-model="article.quantite_min">
                </div>
                    <div class="form-group">
                    <label for=""> Image </label>
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Photo</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" v-on:change="onImageChange">
                        <label class="custom-file-label" for="inputGroupFile01">{{nameFile}}</label>
                    </div>
                    </div>     
                    </div>

                <div class="form-group">
                    <label for="fk_tva_applicable"> Tva Applicable </label>
                <select class="form-control custom-select " id="fk_tva_applicable" v-model="article.fk_tva_applicable" required>
                    <option selected>Choisir TVA</option>
                    <option v-for="tva in tvas" :key="tva.id_tva" :value="tva.id_tva">{{tva.taux_tva}}</option>
                </select>
                </div>
                <div class="form-group">

                <label for="exampleFormControlSelect1">Famille</label>
                <select class="form-control custom-select " id="exampleFormControlSelect1" v-model="article.fk_famille" required>
                    <option selected>Choisir une Famille</option>
                    <option v-for="famille in famille_articles" :key="famille.id_famille" :value="famille.id_famille">{{famille.libelle_famille}}</option>
                </select>
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
             
              

            
            
              nameFile : "Choose file",
              // objet test sur affichage , ajout , recherche
              Testopen:{
                testAjout : false,
                testAffiche : false,
              },
              testEdit : false,
        
              article: { 
                    id_article :0,
                    reference_art :"",
                    type_art :"",
                    designation :"",
                    description :"",
                    prix_ht_achat :"",
                    prix_ht_vente :"",
                    unite :"",
                    quantite :"",
                    quantite_min :"",
                    photo_art :'',
                    fk_tva_applicable :"",
                    fk_famille :"",
              },
              // tableau des articles 
              articles :[],
              //familles 
              famille_articles:[],
              tvas:[],
             
      }),
      

      methods: { 
          addArticle:function(){ 
           
                
              axios.post('/addArticle',this.article).then(response => {         
                    console.log('Article Bien ajouter !');
                    this.$router.push('/ShowArticles/addsuccess');
                  });
            
        },
       
       /* onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
    },

    createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.article.photo_art = e.target.result;
    };
                reader.readAsDataURL(file);
    },*/

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
                        var image = new Image();
                       image.src=e.target.result;
                         //console.log("okkkkk111 : "+image.src.length)
                        image.onload=function(){
                        //console.log("test222222");
                        //document.getElementById("original-Img").src=image.src;
                       // console.log("taille width : "+image.width)
                         console.log("taille size : "+image.src.length)
                         //console.log("taille width : "+image.height)

                        var canvas=document.createElement("canvas");
                        var context=canvas.getContext("2d");
                        if(image.src.length > 1000000){
                            
                        canvas.width=image.width/8; 
                        canvas.height=image.height/8;
                        }
                        else {
                         canvas.width=image.width; 
                        canvas.height=image.height;}
                        //console.log("canvas.width : "+canvas.width)
                        context.drawImage(image,
                            0,
                            0,
                            image.width,
                            image.height,
                            0,
                            0,
                            canvas.width,
                            canvas.height
                        );
                        console.log("size 2 : "+canvas.toDataURL().length)
                        vm.article.photo_art = canvas.toDataURL();
                    }
                        

                   // vm.article.photo_art = e.target.result;
                
                    
                };
                reader.readAsDataURL(file);
            },
                    getfamilles(){
                axios.get('/getfamilles')
                .then((response) => {
                 // console.log('shit');
                    this.famille_articles = response.data.famille_articles;
                    
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
             getTvas(){
                axios.get('/getTvas')
                .then((response) => {
                  //console.log(response.data);
                    this.tvas= response.data.tvas;
                  //  console.log(this.tvas);
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },

      },

      mounted(){

          this.getfamilles();
          this.getTvas();
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

/*.fontsize{

    font-size: 1.10rem;
}*/
.retour {
    border-left-color:#0000009e;
    border-left-width: 3px;
}
</style>



