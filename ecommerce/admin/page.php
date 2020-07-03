<?php

    
   $do = '';

   if(isset($_GET['do'])){
        $do = $_GET['do'];
   }else{
        $do = 'Manage';
   }

   //if the page is main page

   if($do == 'Manage'){

   }elseif($do == 'Add'){

   }elseif($do == 'Edit'){

   }elseif($do == 'Update'){

   }elseif($do == 'Delete'){

    }elseif($do == 'Insert'){

    }else{
        echo '<h1>There is no such page with this name</h1>' ;
    }