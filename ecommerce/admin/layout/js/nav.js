// navigation menu

new Vue({
    el:'#app-nav',
    data :{
       isHidden : true,
       menu : true
    },
    methods:{
       showHide : function(){
          this.$refs.ulSlide.style.display = this.isHidden ? 'flex':'none';
          this.isHidden = !this.isHidden;
       },
       showmenu :function(){
        this.$refs.menu_barA.style.display = this.menu ? 'flex':'none';
        this.$refs.menu_barB.style.display = this.menu ? 'flex':'none';
        this.menu = !this.menu;
       }
    }
  });