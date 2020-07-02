// login form
new Vue({
    el :"#app-login",
    data :{
         placeholderA : 'Username',
         placeholderB : 'Password'
    },
    methods: {
        //hide place holder on form focus
        placeHolderHider: function(input){
              if(input === 'A'){
                this.placeholderA = "";
              }else{
                this.placeholderB = "";
              }
            },
       placeHolderShower: function(input){
            if(input === 'A'){
                this.placeholderA = "Username";
            }else{
                this.placeholderB = "Password";
            }
         }   
     } 
});