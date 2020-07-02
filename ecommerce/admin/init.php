<?php

   include 'connect.php';   
   
   // Routes
   $template    =  'includes/templates/' ; // template directory
   $css         =  'layout/css/' ; // css directory
   $js          =  'layout/js/';  // js directory  
   $lang        =  'includes/languages/'; //language directory
   //include  then important files
   include $lang . "english.php"; 
   include $template . "header.php";
   //include navbar on all pages except the one with $noNavbar variable
   if(!isset($noNavbar)){  include $template . "navbar.php"; }
