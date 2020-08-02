<?php

   include 'admin/connect.php';   
   
   // Routes
   $template    =  'includes/templates/' ; // template directory
   $css         =  'layout/css/' ; // css directory
   $js          =  'layout/js/';  // js directory  
   $lang        =  'includes/languages/'; //language directory
   $func        =  'includes/functions/';  
   //include  then important files
   include $func . 'functions.php';
   include $lang . "english.php"; 
   include $template . "header.php";
