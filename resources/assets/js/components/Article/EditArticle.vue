 <template>
    <div>
        <div class="text-center">
    <h2>Modifier Article</h2>
    </div>
         <div class="row" > 
         
            <div class="col-md-6">
                <div class="form-group">
                    <label for="reference_art"> reference</label>
                    <input type="text" class="form-control" id="reference_art"  v-model="article.reference_art">
                </div>
                <div class="form-group">
                    <label for="type_art"> Type </label>
                    <input type="text" class="form-control" id="type_art" v-model="article.type_art" >
                </div>
                <div class="form-group">
                    <label for="designation"> designation </label>
                    <input type="text" class="form-control" id="designation" v-model="article.designation" >
                </div>
                <div class="form-group">
                    <label for="description"> description </label>
                    <input type="text" class="form-control" id="description" v-model="article.description" >
                </div>
                <div class="form-group">
                    <label for="prix_ht_achat"> prix ht achat </label>
                    <input type="text" class="form-control" id="prix_ht_achat" v-model="article.prix_ht_achat" >
                </div>
                <div class="form-group">
                    <label for="prix_ht_vente"> prix ht vente</label>
                    <input type="text" class="form-control" id="prix_ht_vente" v-model="article.prix_ht_vente" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="unite"> unite </label>
                    <input type="text" class="form-control" id="unite" v-model="article.unite">
                </div>
                <div class="form-group">
                    <label for="quantite"> quantite </label>
                    <input type="text" class="form-control" id="quantite" v-model="article.quantite">
                </div>
                <div class="form-group">
                    <label for="quantite_min"> quantite minimun </label>
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
                    <label for="fk_tva_applicable"> Tva applicable </label>
                <select class="form-control custom-select " id="fk_tva_applicable" v-model="article.fk_tva_applicable">
                    <option selected>Choisir Tva</option>
                    <option v-for="tva in tvas" :key="tva.id_tva" :value="tva.id_tva">{{tva.taux_tva}}</option>
                </select>
                </div>
                <div class="form-group">

                <label for="exampleFormControlSelect1">famille</label>
                <select class="form-control custom-select " id="exampleFormControlSelect1" v-model="article.fk_famille">
                    <option selected>Choisir une categorie</option>
                    <option v-for="famille in famille_articles" :key="famille.id_famille" :value="famille.id_famille">{{famille.libelle_famille}}</option>
                </select>
                </div>
            </div> 
    </div>
     <button  @click="updateArticle()" class="btn btn-primary mr-20 btn-success">Modifier</button>
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
              famille_articles:[],
              tvas:[],
              //etat 
             
             
      }),
    
      

      methods: { 

     getArticle(id_article){
                        console.log('id : '+id_article);
                        axios.get('/getArticle/'+id_article)
                        
                        .then(response => {
                            // recuperé ensemble des articles sous format json
                           
                            this.article = response.data.article;
                           this.nameFile = response.data.article.photo_art;
                          
                        })
                        .catch(function (error) {
                           
                        });                                     
     },
         updateArticle: function(){
           
  
                  axios.post('/updateArticle',this.article).then( response => {             
                    this.$router.push('/ShowArticles/editsuccess');  
                    
                  
                  });
                  
           
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
                    vm.article.photo_art = e.target.result;
                
                    
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
          this.getArticle(this.$route.params.id_article);
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
</style>



