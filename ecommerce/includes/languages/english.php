<?php
   
    function lang($phrase){
      static $lang = array(
            //dashboard
            'home'         => 'Home',
            'categories'   => 'Categories',
            'items'        => 'Items',
            'members'      => 'Members',
            'statistics'   => 'Statistics',
            'comments'     => 'Comments',
            'logs'         => 'Logs',
            'editprofile'  => 'Edit Profile',
            'setting'      => 'Settings',
            'logout'       => 'Log Out',

      );

      return $lang[$phrase];
    }