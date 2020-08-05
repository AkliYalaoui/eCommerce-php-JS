<?php

/*
** Title function that echo the page title in case the page
** has the variable $pageTitle and echo default title for other pages
*/

function getTitle(){
        global $pageTitle;
        
        if(isset($pageTitle)){
            echo $pageTitle;
        }else{
            echo 'Default';
        }
}

/* 
    Redirect Function
*/
function redirect($msg,$second = 3,$url=null){
    if($url !== null && isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])){
        $url = $_SERVER['HTTP_REFERER'];
        $go ="Previous";
    }else{
        $url = "index.php";
        $go = "Home";
    }
    echo "<div class='container'>";
        echo $msg;
        echo "<div class='alert alert-info'>You Will Be Redirected To $go Page After " . $second." Seconds</div>";
    echo "</div>";
    header("refresh:$second;url=$url");
    exit();
}

/*
    Check existence function
*/
function is_exist($connection,$select,$from,$values){
    $query = "SELECT $select FROM $from WHERE $select = ?";
    $stmt = $connection->prepare($query);
    $stmt->execute(array($values));
    $stmt->fetch();
    return $stmt->rowCount()> 0 ? true : false; 
}

/*
    calculate number of items
*/

function items_count($column,$from,$condition=""){
    global $con;
    $stmt = $con->prepare("SELECT COUNT($column) FROM $from $condition");
    $stmt->execute();
    return $stmt->fetchColumn();
}
/*
    latest items
*/
function latest($select,$from,$cpt,$order){
    global $con;
    $sql = "SELECT $select FROM $from ORDER BY $order DESC LIMIT $cpt";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $items;
}
/*
    Get All Record From A specific Table
 */
function getAll($table,$order,$where=null,$ordering="DESC"){
    global $con;
    $stmt = $con->prepare("SELECT * FROM $table $where ORDER BY $order $ordering");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}