<template>
    <div>
             <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
    <!-- button pour afficher tous les users-->
            <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowCharges'"> <i class="fas fa-long-arrow-alt-left fontsize"></i>  </router-link>

        </div>
  
    </div>
    <h2>Ajouter Charge</h2>
    <hr>   
    </div> 
        <form @submit.prevent="addCharge">
         <div class="row" > 
         
            <div class="col-md-6">
                <div class="form-group">
                    <label for="num_facture_ch"> N° Facture</label>
                    <input type="text" class="form-control" id="num_facture_ch"  v-model="charge.num_facture_ch">
                </div>
                <div class="form-group">
                    <label for="date_facture_ch"> Date Facture </label>
                    <input type="date" class="form-control" id="date_facture_ch" v-model="charge.date_facture_ch" >
                </div>
                <div class="form-group">
                    <label for="designation"> Nom Fournisseur </label>
                    <input type="text" class="form-control" id="nom_fournisseur_ch" v-model="charge.nom_fournisseur_ch" >
                </div>
                
                <div class="form-group">
                    <label for="prix_ht_achat"> Designation </label>
                    <input type="text" class="form-control" id="prix_ht_achat" v-model="charge.designation_ch" >
                </div>
                <div class="form-group">
                    <label for="prix_ht_vente">Montant HT</label>
                    <input type="text" class="form-control" id="prix_ht_vente" v-model="charge.montant_ht_ch" >
                    <label for="prix_ht_vente">Montant TTC</label>
                    <input type="text" class="form-control" id="prix_ht_vente" v-model="charge.montant_ttc_ch" disabled>
                
                </div>
                <div class="form-group">
                    <label for="unite"> Taux Tva </label>
                    <select class="form-control custom-select " id="fk_tva_applicable" v-model="charge.taux_tva_ch" required>
                    <option selected>Choisir TVA</option>
                    <option v-for="tva in tvas" :key="tva.id_tva" :value="tva.taux_tva">{{tva.taux_tva}}</option>
                </select>
                    <label for="unite"> Tva </label>
                <input type="text" class="form-control" id="prix_ht_vente" v-model="charge.tva_ch" disabled>

                </div>
              <div class="form-group">
                    <label for="description"> Date Limit </label>
                    <input type="date" class="form-control" id="unite" v-model="charge.date_limit_ch">
                </div>
            </div>
            <div class="col-md-6"> 
               
                <div class="form-group">
                    <label for="quantite"> Mode Paiement </label>
                  <select class="custom-select " id="fk_" v-model="charge.mode_paiement_ch" >
                 <option selected disabled>Choisir type paiement</option>
                <option v-for="typePaiement in typePaiements" :key="typePaiement.id_type_paiement" :value="typePaiement.type_paiement">{{typePaiement.type_paiement}}</option>
                 </select> 
                </div>
           
                <div class="form-group">
                    <label for="quantite_min"> Reference </label>
                    <input type="text" class="form-control" id="quantite_min" v-model="charge.reference_ch">
                </div>
                <div class="form-group">
                    <label for="quantite_min"> Date Paiement </label>
                    <input type="date" class="form-control" id="quantite_min" v-model="charge.date_paiement_ch">
                </div>
                      <div class="form-group">
                    <label for="description"> Objet </label>
                    <input type="text" class="form-control" id="quantite_min" v-model="charge.objet_ch">
                </div>

                <div class="form-group">
                    <label for="fk_tva_applicable"> Support </label>
                    <input type="text" class="form-control" id="unite" v-model="charge.support_ch">

                </div>
                    <div class="form-group">
                    <label for="description"> Type Delai </label>
                <textarea placeholder=""  name="" id="description" class="form-control" rows="5" v-model="charge.type_delai_ch"></textarea>
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
             
              

            error:false,
            loading:false,
              nameFile : "Choose file",
              // objet test sur affichage , ajout , recherche
              Testopen:{
                testAjout : false,
                testAffiche : false,
              },
              testEdit : false,
        
              charge: { 
                    id_charge :0,
                    num_facture_ch:"",
                    date_facture_ch:"",
                    nom_fournisseur_ch:"",
                    designation_ch:"",
                    montant_ht_ch:"",
                    taux_tva_ch:"",
                    tva_ch:"",
                    montant_ttc_ch:"",
                    mode_paiement_ch:"",
                    reference_ch:"",
                    date_paiement_ch:"",
                    support_ch:"",
                    objet_ch:"",
                    type_delai_ch:"",
                    date_limit_ch:"",
              },
              // tableau des charges 
              charges :[],
              tvas:[],
              typePaiements:[],
             
      }),
      

      methods: { 
        addCharge:function(){ 
           
                
              axios.post('/addCharge',this.charge).then(response => {         
                    console.log('charge Bien ajouter !');
                    this.$router.push({name: 'ShowCharges' ,params: { success: "add"  }});
                  });
            
        },
          updateCharge:function(){ 
           
                
              axios.post('/updateCharge',this.charge).then(response => {         
                    console.log('charge Bien ajouter !');
                    this.$router.push({name: 'ShowCharges' ,params: { success: "edit"  }});
                  });
            
        },

             getTypePaiement(){
                            axios.get('/getTypePaiement')
                            .then((response) => {                        
                                this.typePaiements= response.data.listeTypePaiments;
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
 getCharge:function(charge){
              
                  axios.get('/getCharge/'+charge.id_charge).then(
                  response => {
                        this.loading=false;
                    this.charge= response.data.charge;
                   // this.Charge.fk_famille = response.data.libelle_famille[0].libelle_famille;
                    //console.log(response.data.libelle_famille[0]);
                  //  this.charge.fk_tva_applicable = response.data.taux_tva[0].taux_tva;
                  });         
        },
                          precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
},


fetchData(){
    this.loading=true;
    this.charge.id_charge=this.$route.params.charge.id_charge;
     this.getTypePaiement();
          this.getTvas();
          this.getCharge(this.$route.params.charge)
}
      },

          
computed:{
        // calcul
    Calcul(){
                // total de montant tvas 
            this.charge.tva_ch=this.precisionRound(+(this.charge.montant_ht_ch *this.charge.taux_tva_ch)/100 ,2);
                // montant total final
            this.charge.montant_ttc_ch= this.precisionRound(  +this.charge.montant_ht_ch + +this.charge.tva_ch,2);
 


            

          
    },    
},
     created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
watch:{
    'charge.montant_ht_ch':{
            handler: function(){
                console.log('teeeest')
                    this.Calcul;

            },
    },
     'charge.taux_tva_ch':{
            handler: function(){
                    this.Calcul;

            },
    },
  


       // call again the method if the route changes
    '$route': 'fetchData',     
},

      mounted(){

         
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

.fontsize{

    font-size: 1.10rem;
}
</style>



