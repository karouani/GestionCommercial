export default function (Vue){
    Vue.auth = {
       async  getProfile(){
           
           let authen  = await  axios.get('/getProfile')
            .then(response => {let test;
              if(response.data.user[0].role == 'Super Admin')
              test = false;
              else test = true;
              return test;
             // return false;
               
            })
            .catch(function (error) {
               
            });           
         return authen;
                   
            },


    }
    Object.defineProperties(Vue.prototype,{
        $auth:{
            get(){
                return Vue.auth;
            }
        }
    })
}