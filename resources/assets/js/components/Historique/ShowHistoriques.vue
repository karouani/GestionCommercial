<template>
	<div><div class="row">
        <div class="col">
        <h3>Historiques des operations</h3>
        </div>
        <div class="col">
                     <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="reset"  class="form-control" v-model="email_user" placeholder="recherche par email" aria-label="Username" aria-describedby="basic-addon1" >
            </div>
        </div>
         <div class="col">
                     <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="number" @keyup.enter="reset"  class="form-control" v-model="anneeHistorique" placeholder="recherche par année " aria-label="Username" aria-describedby="basic-addon1" >
            </div>
        </div>
    </div>
       
        <hr>
                <notifications group="foo" 
      position="bottom right" 
      classes="vue-notification succes"/>

        <div class="table-responsive">
        <table class="table">
  
    <tr>
      <th scope="col">user</th>
      <th scope="col">operation</th>
      <th scope="col">Date</th>
      <th scope="col">Option</th>
    </tr>
 
  
    <tr v-for="(historique,index) in historiques" :key="index">
      <td >{{historique.email_user}}</td>

      <td v-if="historique.nom_document == 'vente'" ><i style="color:blue" class="far fa-file"></i> {{historique.operation_user}}</td>
      <td v-else-if="historique.nom_document == 'achat'" ><i style="color:green" class="far fa-file"></i> {{historique.operation_user}}</td>
      <td>{{historique.created_at}}</td>
     <td><a @click="deleteHistorique(historique)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></td>

    </tr>
  
  
</table>

        </div>
        
        <infinite-loading :spinner="spinnerName"  @infinite="infiniteHandler" ref="infiniteLoading">
        	<span slot="no-more">
        		Fin !
        	</span>
        </infinite-loading>
	</div>
</template>

<script>
	import InfiniteLoading from 'vue-infinite-loading';

	export default {
         components:{
            'infinite-loading':InfiniteLoading,
         },
		created() {
			
		},
		data() {
            
			return {

                email_user:"",//email_user
                anneeHistorique:"",//anneeHistorique
                spinnerName: "bubbles",
				historiques: [], 
			}
		},
		methods: {

            reset(){
        this.historiques = [];

                
                    this.$nextTick(() => {
                    this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset');
                });
            },
            deleteHistorique(historique){
                    axios.delete('/deleteHistorique/'+historique.id_historique_operation).then(
                        response => {
              this.historiques = [];
                
                    this.$nextTick(() => {
                    this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset');
                });


                             this.$notify({
                                      group: 'foo',
                                      title: 'succée',
                                      text: 'historique a été supprimer!',
                                      duration: 2000,
                                    }); 

                        });
                    },


		
			infiniteHandler: function ($state) {
                console.log('testttt : ')
                //this.historiques = [];
                console.log(this.historiques.length)
				let limit = this.historiques.length / 10 + 1;
				axios.get('/getHistoriques', { params: { page: limit ,email_user: this.email_user ,anneeHistorique: this.anneeHistorique } }).then(response => {
					this.loadMore($state, response);
				});
			},
			loadMore: function ($state, response) {


				if ( response.data.listeHistoriques.data.length ) {
                    
           
                    console.log("total ")
                    console.log(response.data.listeHistoriques.total)
                    console.log("length")
                    console.log(this.historiques.length)
                    
					this.historiques = this.historiques.concat(response.data.listeHistoriques.data);
					setTimeout(() => {
                        $state.loaded();
                        console.log("load")
					}, 1000);
                      if ( response.data.listeHistoriques.total <= this.historiques.length ) {
						$state.complete();
					}
				} else {
					$state.complete();
				}
			}

		}

	}

</script>

<style lang="scss" scoped>
	.post {
		margin-bottom: 20px;
		padding-bottom: 20px;
		border-bottom: solid 1px #CCC;

		.post-title {
			font-size: 2em;
		}

		.post-body {
			font-size: 1.4em;
		}

	}
</style>