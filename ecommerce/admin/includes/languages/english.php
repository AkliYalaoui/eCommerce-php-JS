<?php
   
    function lang($phrase){
      static $lang = array(
            //dashboard
            'home'         => 'Home',
            'catergories'   => 'Catergories',
            'items'        => 'Items',
            'members'      => 'Members',
            'statistics'   => 'Statistics',
            'logs'         => 'Logs',
            'editprofile'  => 'Edit Profile',
            'setting'      => 'Settings',
            'logout'       => 'Log Out',

      );

      return $lang[$phrase];
    }