<?php
    session_start();
    $pageTitle = 'dashboard';
    if(isset($_SESSION['username'])){
        include 'init.php';
        include $template . "footer.php";
    }else{
        header('Location:index.php'); //user can't acces this page , redirect to login
        exit(); // exit script
    }


