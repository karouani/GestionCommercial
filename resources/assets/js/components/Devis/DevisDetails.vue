<template>
<div>
     <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/getDevis'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
         <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/addBonCommande/'+devi.id_devis "> Convertir</router-link>
        </div>
    </div>
<div class=" container colBackround">
          
<div class="row">
    <div class="col">
        <br>
    <h5><i class="far fa-file"></i> Informations du Devis : <strong>{{devi.reference_d}}</strong></h5>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label"><strong>Devis {{devi.reference_d}} [{{devi.montant_ttc_d}} DH]</strong> </label>

            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Date : {{devi.date_d}}</label>
            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Validité : {{devi.date_limit_d}}  </label>
            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Vendeur : {{devi.nom_societe}}  </label>
            </div>
          
    </div>
    <div class="col-md-6 col-sm-12">
        
        <div class="container  infoClient">
            <label class="compte" for="">{{devi.nom_compte}} </label>
            <div class="form-group row">
            <div class="col-sm-10">
            {{devi.adresse_d}}
            </div>
         </div>
        </div>
        <br>
        <div class="form-group">
                
                <select class="form-control custom-select " id="fk_status_d" v-model="devi.fk_status_d" >
                    <option selected disabled>Choisir Status</option>
                    <option v-for="statu in status" :key="statu.id_status" :value="statu.id_status">{{statu.type_status}}</option>
                </select>
        </div>
    </div>
</div>
<hr>

  <div>     
        
                     <table class="table table-bordered tableau">
                            <thead>
                          <tr class="heade">
                            <th>Article</th>
                            <th>Quantite</th>
                            <th>Remise</th>
                            <th>majoration</th>
                            <th>Prix HT</th>
                            <th>TVA</th>
                            <th>Total HT</th>
                          </tr>                           
                        </thead>
                         <tbody class="boby-table">
                          <tr v-for="(commande,index) in commandes" :key="index" >
                            <th> {{commande.designation}}</th>
                            <th>{{commande.quantite_cmd}}</th>
                            <th>{{commande.remise_cmd}}</th>
                            <th> {{commande.majoration_cmd}}</th>
                            <th>{{commande.prix_ht}}</th>
                            <th>{{commande.taux_tva}} </th> 
                            <th>{{commande.total_ht_cmd}} </th> 

                         </tr>              
                        </tbody>


                         </table>
  </div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-4 col-form-label">Date Limit</label>
                <div class="col-sm-8 cam">
                {{devi.date_limit_d}}
                </div>
            </div>
            <div class="form-group row">
                    <label for="type_paiement" class="col-sm-4 col-form-label" > Type Paiement </label>
                <div class="col-sm-8">
                {{devi.type_paiement}}
                   
                </div>
            </div>
                <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Reference Paiement </label>
                    <div class="col-sm-8">
                    {{devi.reference_paiement}}
                    </div>
                </div> 
                 <div class="form-group row">
                    <label for="date_paiement"  class="col-sm-4 col-form-label" >Date Paiement </label>
                    <div class="col-sm-8">
                    
                    {{devi.date_paiement}} 
                    </div>
                </div>  
                <div class="form-group row">
                    <label for="remise_total_d"  class="col-sm-4 col-form-label" >Remise Total </label>
                    <div class="col-sm-8">
                    {{devi.remise_total_d}}
                    </div>
                </div>                  
                      

                                 
    </div>
    <div class="col-md-6 col-sm-12">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Total HT </label>
            <div class="col-sm-8 cal">
            {{devi.total_ht_d}}
            </div>
         </div>
   
       
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Remise Total (montant) </label>
            <div class="col-sm-8 cal">
            {{devi.remise_ht_d}}
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label"> Montant Net HT  </label>
            <div class="col-sm-8 cal">
            {{devi.montant_net_d}}
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">TVA (Montant) </label>
            <div class="col-sm-8 cal">
            {{devi.tva_montant_d}}
            </div>
         </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Montant TTC (Montant) </label>
            <div class="col-sm-8 cal">
            {{devi.montant_ttc_d}}
            </div>
         </div>
   
 </div>

        
</div>
</div>
</div>
</template>
<script>
    


      export default{ 
        
          data: () => ({
   // devi
              devi: { 
            id_devis:0,
            reference_d:"",
            date_d:"", 
            adresse_d:"",
            type_operation:"",
            objet_d:"",
            date_emission_d:"",
            remise_total_d:"",
            majoration_d:"",
            date_limit_d:"",
            introduction_d:"",  
            conditions_reglements_d:"",
            notes_d:"",
            accompte_d:"",
           fk_status_d:"",
           fk_compte_d:"",
            fk_user_d:"",

            designation:"",
            nom_compte:"",
            taux_tva:"",

            total_ht_d:0,
            remise_ht_d:0,
            montant_net_d:0,
            tva_montant_d:0,
            montant_ttc_d:0,
      
            nom_societe:"",
              },
              // tableau des devis 
              devis :[],
              //tables foreign key 
              status:[],
              tvas:[],
              articles:[],
              comptes:[],
            index:0,
            total_prix:0,
            remise_T:0,
              //commandes
      
              commande:{
                  id_cmd:0,
                quantite_cmd:1,
                remise_cmd:0,
                majoration_cmd:0,
                prix_ht:0,
                fk_article:"",
                fk_document:"",
                fk_tva_cmd:"",
               
               //affichage
               
               desig:"",
                total_ht_cmd:0,
                taux_tva:0,

                
              },
              commandes:[],
            

          }),
          methods:{

       getDevisD:function(id_devis){
                  axios.get('/getDevisD/'+id_devis).then(
                  response => {
                         //console.log(response.data.devi.fk_compte_d);

                    this.devi= response.data.devi[0];

                  });     
        },
        getCommandes:function(id_devis){
                  axios.get('/getCommandes/'+'D'+id_devis).then(
                  response => {
                      console.log("commandes:  ");
                         console.log(response.data.commandes);

                    this.commandes= response.data.commandes;
                    // this.commande.fk_article= response.data.articles;

                  });     
        },

       /* tauxTva(){
            axios.get('/tauxTva/'+commandes.fk_tva_cmd).then(
                  response => {
                      console.log(response.data.taux_tva.taux_tva)
                    this.commande.taux_tva= response.data.taux_tva.taux_tva;
                   //console.log(response.data.modePaiement[0])
                  });

        }*/
        
    },
           
          mounted(){
              this.devi.id_devis = this.$route.params.id_devis;
              this.getDevisD(this.devi.id_devis);
              this.getCommandes(this.devi.id_devis);

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
.mr-4{
    margin-right: 0rem!important;
    width:100px;
}
.colBackround{
     background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
}
.infoClient{

    background-color:  #42a5f529;

}
.AdressClient{
    width: 121%;
}

.noteCondition{
    width: 77%;
}
.calculePadding{
    padding-left: 50%;
}
.top{
        margin-left: 100px;
    margin-bottom: 0rem;
}
.compte{
        color: blue;
    font-size: large;
}


.table {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

.table td, .table th {
    border: 0px solid #ddd;
    padding: 8px;
}

.table tr:nth-child(even){background-color: rgb(236, 236, 236);}


.heade {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    color: #898585;
    background-color: #d8e9f6;
}

.form-group{
    margin-bottom: 0rem;
}
.cal{
padding-right: 0px;
}
</style>
