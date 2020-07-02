<?php
   
    function lang($phrase){
      static $lang = array(
            //home Page
            'MESSAGE' => 'Welcome',
            'ADMIN'   => 'Administrator'
                  
      );

      return $lang[$phrase];
    }