<template>
<div>

    <div v-if="error" class="error">
      {{ error }}
    </div>

<div>
    <nav class="navbar page-header">
        <a href="#" class="btn btn-link sidebar-mobile-toggle d-md-none mr-auto">
            <i class="fa fa-bars"></i>
        </a>

        <a class="navbar-brand" href="#">
            <img src="storage/images/logo.png" alt="logo">
        </a>

        <a href="#" class="btn btn-link sidebar-toggle d-md-down-none">
            <i class="fa fa-bars"></i>
        </a>

        <ul class="navbar-nav ml-auto">

           

            <li class="nav-item dropdown">

                   <a  href="#" role="button" @click="MarkNotifRead" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="fa fa-bell"></i>
                    <span class="badge badge-pill badge-danger">{{nbNotif}}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                <ul class="list-group scroll">
                    <li   class="list-group-item"  v-for="(notification,index) of notifications" :key="index" ><i class="far fa-file" :style="[notification.read_at == null ? redColor : blueColor]" ></i> {{notification.data.data}}</li>
                </ul>
                </div>
                
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img v-if="profile.photo != ''" :src="'storage/images/'+profile.photo" class="avatar avatar-sm" alt="logo">
                    <img v-if="profile.photo === ''" :src="'storage/images/user0.jpg'" class="avatar avatar-sm" alt="logo">

                    <span class="small ml-1 d-md-down-none">{{profile.name}}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header">Account</div>

                    <router-link :to="'/getProfile'" class="dropdown-item">
                        <i class="fa fa-user"></i> Profile
                    </router-link>

                    <div class="dropdown-header">Gestion Utilisateur</div>
                        <router-link :to="'/addUsers'" class="dropdown-item" v-if="profile.role =='Super Admin'">
                        <i class="fas fa-plus"></i> 
                        Ajouter Utilisateur
                        </router-link>
                   

                    <router-link :to="'/getUsers'" class="dropdown-item">
                        <i class="far fa-file-alt"></i>
                       Afficher Utilisateurs
                        </router-link>
                  

                    <a href="#" class="dropdown-item" @click="logout">
                        <i class="fa fa-lock"></i> Déconnecter
                    </a>
                   
                </div>
                
            </li>
        
        </ul>

    </nav>
</div>
</div> 
</template>

<script>

 export default {
        data: () => ({
             redColor: {
               color: 'red',
                },
            blueColor:{
                color: 'blue',
            },
           
            loading: false,
            error:false,
            isSuperAd:false,
            profile: {
      id:0,
      name:"",
      email:"",
      password:"",
      role:"",
      photo:"",
      
    },
    notifications : [],
    nbNotif :0,
    devis:[],
    factures:[],
    boncommandes:[],
    avoirFactures:[],
    bonLivraisons:[],
    currentDate:"",
        }),
        
        methods: {

            MarkNotifRead(){
                axios.get('/MarkNotifRead').then((response) => {
                                                console.log('all notif read')
                                               let  this1 = this;
                                                this.nbNotif =0;
                                                setTimeout(function(){ this1.getNotifications(); }, 100000);
                                               console.log('douzzzz')
                                                })
                                                .catch(() => {
                                                    console.log('handle server error from here');
                                                });
            },

            getDifferenceDate(date_limit){
                         
                                    var startDate = Date.parse(this.currentDate);
                                    var endDate = Date.parse(date_limit);
                                    var timeDiff = endDate - startDate;
                                    var daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                                    return daysDiff;
            },
            
            

            setCurrentDate(){
             var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; 
            var yyyy = today.getFullYear();
            console.log("month"+today)
             if(dd<10) 
                {
                    dd='0'+dd;
                } 

                if(mm<10) 
                {
                    mm='0'+mm;
                } 
            this.currentDate  = yyyy+'-'+mm+'-'+dd;
            },

     async getDocuments(){

                
                 const response0 = await this.getNotifications()
                 const response2 = await this.getAllDevis()
                 const response3 = await  this.getAllBoncommandes()
                
                 const response5 = await  this.getAllBonLivraisons()
                 const response6 = await  this.getAllFactures() 
                 const response7 = await  this.getAllAvoirFactures() 

                 

                  
          },



           async  getNotifications(){
               const response11 = await  axios.get('/getNotifications')
                .then((response) => {
                
                    
                  this.notifications = response.data.notifications;
                  this.nbNotif = response.data.CountnotifNotRead

                })
                .catch(() => {
                    console.log('handle server error from here');
                });
                return response11;
          },
        async getAllDevis(){
             const response22 = await axios.get('/getAllDevis')
                    .then((response) => {            
                        this.devis = response.data.AllDevis;
                        let that=this
                        let test = 0;
                        console.log("tous les devis ")
                        console.log(this.devis)
                        this.devis.forEach(function(devi) {

                            test = 0;
                            that.notifications.forEach(function(notif) { 
        
                                if(notif.data.data.indexOf(devi.reference_d+" va") > -1){
                                test =1;
                                }
                            })
                            if(test == 0){
                                        if(that.getDifferenceDate(devi.date_limit_d)<2){
                                            
                                                    axios.get('/addNotification',{params: {reference_d: devi.reference_d} })
                                                    .then((response) => {
                                                    console.log('notif bien ajouter ')
                                                    that.getNotifications()
                                                    })
                                                    .catch(() => {
                                                        console.log('handle server error from here');
                                                    });
                                        }
                                }
                        })
                        
                })
                    .catch(() => {
                        console.log('handle server error from here');
                    });
                    return response22;
        },

        async getAllBoncommandes(){
           
             const response33 = await axios.get('/getAllBoncommandes')
                    .then((response) => {      
                              
                        this.boncommandes = response.data.AllBoncommandes;
                        let that=this
                        let test = 0;
                        this.boncommandes.forEach(function(boncommande) {

                            test = 0;
                            that.notifications.forEach(function(notif) { 
        
                                if(notif.data.data.indexOf(boncommande.reference_bc+" va") > -1){
                                
                                test =1;
                                }
                            })
                            if(test == 0){
                                        if(that.getDifferenceDate(boncommande.date_limit_bc)<2){
                                            
                                                    axios.get('/addNotification',{params: {reference_d: boncommande.reference_bc} })
                                                    .then((response) => {
                                                    console.log('notif bien ajouter ')
                                                    that.getNotifications()
                                                    })
                                                    .catch(() => {
                                                        console.log('handle server error from here');
                                                    });
                                        }
                                }
                        })
                        
                })
                    .catch(() => {
                        console.log('handle server error from here');
                    });
                    return response33;
        },
         async getAllBonLivraisons(){
           
             const response44 = await axios.get('/getAllBonLivraisons')
                    .then((response) => {      
                              
                        this.bonLivraisons = response.data.AllBonLivraisons;
                        console.log('bon livraisons : ===== ')
                        console.log(this.bonLivraisons)
                        let that=this
                        let test = 0;
                        this.bonLivraisons.forEach(function(bonLivraison) {
                                
                                
                            test = 0;
                            that.notifications.forEach(function(notif) { 
        
                                if(notif.data.data.indexOf(bonLivraison.reference_bl+" va") > -1){
                                
                                test =1;
                                }
                            })
                            if(test == 0){
                               
                               
                                        if(that.getDifferenceDate(bonLivraison.date_limit_bl)<2){
                                            
                                                    axios.get('/addNotification',{params: {reference_d: bonLivraison.reference_bl} })
                                                    .then((response) => {
                                                    console.log('notif bien ajouter ')
                                                    that.getNotifications()
                                                    })
                                                    .catch(() => {
                                                        console.log('handle server error from here');
                                                    });
                                        }
                                }
                        })
                        
                })
                    .catch(() => {
                        console.log('handle server error from here');
                    });
                    return response44;
        },
         async getAllFactures(){
           
             const response55 = await axios.get('/getAllFactures')
                    .then((response) => {      
                              
                        this.factures = response.data.AllFactures;
                        let that=this
                        let test = 0;
                        this.factures.forEach(function(facture) {

                            test = 0;
                            that.notifications.forEach(function(notif) { 
        
                                if(notif.data.data.indexOf(facture.reference_f+" va") > -1){
                                
                                test =1;
                                }
                            })
                            if(test == 0){
                                        if(that.getDifferenceDate(facture.date_limit_f)<2){
                                            
                                                    axios.get('/addNotification',{params: {reference_d: facture.reference_f} })
                                                    .then((response) => {
                                                    console.log('notif bien ajouter ')
                                                    that.getNotifications()
                                                    })
                                                    .catch(() => {
                                                        console.log('handle server error from here');
                                                    });
                                        }
                                }
                        })
                        
                })
                    .catch(() => {
                        console.log('handle server error from here');
                    });
                    return response55;
        },
         async getAllAvoirFactures(){
           
             const response66 = await axios.get('/getAllAvoirFactures')
                    .then((response) => {      
                              
                        this.avoirFactures = response.data.AllAvoirFactures;
                        let that=this
                        let test = 0;
                        this.avoirFactures.forEach(function(avoirFacture) {

                            test = 0;
                            that.notifications.forEach(function(notif) { 
        
                                if(notif.data.data.indexOf(avoirFacture.reference_af+" va") > -1){
                                
                                test =1;
                                }
                            })
                            if(test == 0){
                                        if(that.getDifferenceDate(avoirFacture.date_limit_af)<2){
                                            
                                                    axios.get('/addNotification',{params: {reference_d: avoirFacture.reference_af} })
                                                    .then((response) => {
                                                    console.log('notif bien ajouter ')
                                                    that.getNotifications()
                                                    })
                                                    .catch(() => {
                                                        console.log('handle server error from here');
                                                    });
                                        }
                                }
                        })
                        
                })
                    .catch(() => {
                        console.log('handle server error from here');
                    });
                    return response66;
        },




            logout:function() {

                axios.get('/logout')
                .then((response) => {
                  
                    window.location.href="/login"
                  
                })
                .catch(() => {
                    console.log('error log out ');
                });},
                
                    
        
            
             getProfile(){
this.loading = true
                        axios.get('/getProfile')
                        .then(response => {
                                             console.log('errrrrrrrror')
                        console.log(response)
                        if(response.data.error == "Unauthenticated"){
                     window.location.href="/login"}
                            // recuperé ensemble des articles sous format json
                         //  console.log("11")
                           this.profile = response.data.user[0];
                           this.loading = false;
                        //console.log(response.data.user[0]);
                      //  console.log(this.profile)

                        })
                        .catch(function (error) {
                           
                        });                
                         
                               
            },
            isSuperAdmin(){
                  axios.get('/isSuperAdmin')
                        .then(response => {
                            // recuperé ensemble des articles sous format json
                           console.log("11")
                           this.isSuperAd = test;
                        //console.log(response.data.user[0]);
                        console.log( this.isSuperAd )

                        })
                        .catch(function (error) {
                           
                        });
            }
            

        },

created(){
//this.getProfile();
},


        mounted(){
            // this.getNotifications(); 
             this.getDocuments();
            this.setCurrentDate();

            
            let this1=this;
           
         // setInterval(function(){ this1.getNotifications(); }, 10000);  
        //setInterval(function(){ this1.getDocuments();}, 10000);  
                    this.getProfile();
            
          
          
         // console.log(this.profile)
          
    },

        
    }
</script>
<style scoped>
.scroll {
  height:150px;
  overflow-y: scroll;
}



</style>
