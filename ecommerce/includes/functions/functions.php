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
    Get Categories From Db
*/
function getCategories(){
    global $con;
    $sql = "SELECT * FROM categories ORDER BY id ASC";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
/* 
    Get Items
*/
function getItems($id,$condition=null){
    global $con;
    if($condition == null){
        $condition ="categoryid";
    }
    $sql = "SELECT * FROM items WHERE $condition=? ORDER BY itemid DESC";
    $stmt = $con->prepare($sql);
    $stmt->execute(array($id));
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
/* 
    Get Comments
*/
function getComments($id,$condition=null){
    global $con;
    if($condition == null){
        $condition ="itemid";
    }
    $sql = "SELECT * FROM comments WHERE $condition=? ORDER BY commentid DESC";
    $stmt = $con->prepare($sql);
    $stmt->execute(array($id));
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
/*
    Check USER status
*/
function is_activate($user){
    global $con;
    $stmt = $con->prepare("SELECT regstatus FROM users WHERE username=?");
    $stmt->execute(array($user));
    $status = $stmt->fetch(PDO::FETCH_OBJ);
    if($status->regstatus == 1){
        return true;
    }else{
        return false;
    }
}