<template>
	<div>
        <h3>Mouvements</h3>
        <hr>
                <notifications group="foo" 
      position="bottom right" 
      classes="vue-notification succes"/>

        <div class="table-responsive">
        <table class="table">
  
    <tr>
      <th scope="col">Article</th>
      <th scope="col">Mouvement</th>
      <th scope="col">Quantité</th>
      <th scope="col">Date</th>
      <th scope="col">Option</th>
    </tr>
 
  
    <tr v-for="(mouvement,index) in mouvements" :key="index">
      <td >{{mouvement.designation}}</td>
      <td v-if="mouvement.type_mouvement == 'entre'"><i style="color:green" class="fas fa-sign-in-alt"></i> Entrée</td>
      <td v-else><i style="color:red" class="fas fa-sign-out-alt"></i> Sortie</td>  
      <td>{{mouvement.quantite_mouvement}}</td>
      <td>{{mouvement.date_mouvement }}</td>
     <td><a @click="deleteMouvement(mouvement)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></td>

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
			//this.getMouvements();
		},
		data() {
            
			return {
                spinnerName: "bubbles",
				mouvements: [],
			}
		},
		methods: {
            reset(){
        this.mouvements = [];
                
                    this.$nextTick(() => {
                    this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset');
                });
            },
            deleteMouvement(mouvement){
                    axios.delete('/deleteMouvement/'+mouvement.id_mouvement).then(
                        response => {
              this.mouvements = [];
                
                    this.$nextTick(() => {
                    this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset');
                });


                             this.$notify({
                                      group: 'foo',
                                      title: 'succée',
                                      text: 'mouvement a été supprimer!',
                                      duration: 2000,
                                    }); 

                        });
                    },


		
			infiniteHandler: function ($state) {
                console.log('testttt : ')
                //this.mouvements = [];
                console.log(this.mouvements.length)
				let limit = this.mouvements.length / 10 + 1;
				axios.get('/getMouvements', { params: { page: limit } }).then(response => {
					this.loadMore($state, response);
				});
			},
			loadMore: function ($state, response) {


				if ( response.data.listeMouvements.data.length ) {
                    
           
                    console.log("total ")
                    console.log(response.data.listeMouvements.total)
                    console.log("length")
                    console.log(this.mouvements.length)
                    
					this.mouvements = this.mouvements.concat(response.data.listeMouvements.data);
					setTimeout(() => {
                        $state.loaded();
                        console.log("load")
					}, 1000);
                      if ( response.data.listeMouvements.total <= this.mouvements.length ) {
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