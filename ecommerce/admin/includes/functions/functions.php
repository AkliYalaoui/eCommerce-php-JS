<?php

/*

** Title function that echo the page title in case the page
** has the variable $pageTitle and echo defailt title for other pages
*/

function getTitle(){
       global $pageTitle;
       
       if(isset($pageTitle)){
           echo $pageTitle;
       }else{
           echo 'Default';
       }
}