<?php
    session_start();
    $pageTitle = "Items";
    include 'init.php';

    $id = isset($_GET['id']) && is_numeric($_GET['id'])? $_GET['id']:0;
    $stmt = $con->prepare('SELECT items.*,users.username,categories.name AS cats,categories.id AS catid FROM items
                            INNER JOIN users ON users.userid = items.userid
                            INNER JOIN categories ON categories.id = items.categoryid
                            WHERE approuve=1 AND itemid=?');
    $stmt->execute(array($id));
    if($stmt->rowCount() > 0){
        $item=$stmt->fetch(PDO::FETCH_OBJ);
         //all status
        $status = array(
            "1" => "New",
            "2" => "Like New",
            "3" => "Used",
            "4" => "Very Old",

        );
?>
    <h1 class="edit-title"><?php echo $item->name?></h1>
    <div class="container item-container-f">
        <div class="image-info-item">
            <img src="<?php echo !is_null($item->img) ? 'data/uploads/'.$item->img : "avatar.png" ;?>" alt="image">
        </div>
        <div class="item-info-f">
            <h2><?php echo $item->name ?></h2>
            <p><?php echo $item->description ?></p>
            <ul>
                <li>
                    <i class="fa fa-calendar-alt fa-fw"></i>
                    <span>Added :</span> <time><?php echo $item->date ?></time>
                </li>
                <li>
                    <i class="fa fa-money-bill fa-fw"></i>
                    <span>Price : $</span><?php echo $item->price ?>
                </li>
                <li>
                    <i class="fa fa-building fa-fw"></i>
                    <span>Made In :</span><?php echo $item->country ?>
                </li>
                <li>
                    <i class="fa fa-star fa-fw"></i>
                    <span>Status :</span><?php echo $status[$item->status] ?>
                </li>
                <li>
                    <i class="fa fa-tag fa-fw"></i>
                    <span>Category : </span><a href="categories.php?id=<?php echo $item->catid ?>&name=<?php echo $item->cats ?>"><?php echo $item->cats ?></a>
                </li>
                <li>
                    <i class="fa fa-user fa-fw"></i>
                    <span>User : </span><a href="#"><?php echo $item->username; ?></a>
                </li>
                <li>
                    <i class="fa fa-tags"></i>
                    <span>Tags : </span>
                    <?php
                        $Tags  = explode(",",$item->tags);
                        foreach($Tags as $tg){
                            $tg = str_replace(" ","",$tg);
                            $tg = strtolower($tg);
                            if(!empty($tg)){
                                echo "<a href='tags.php?tag={$tg}'>$tg</a> | ";
                            }
                        }
                    ?>

                </li>
            </ul>
        </div>
    </div>
    <!-- add comment -->
    <div class="container comment-container">
        <?php if(isset($_SESSION['user'])):
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                if(isset($_POST['comment'])){
                    $cmnt = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                    $formError = array();
                    if(empty($cmnt)){
                        array_push($formError,"Can Not Send An Empty Comment");
                    }
                    if(count($formError) == 0){
                        $stmt = $con->prepare("INSERT INTO comments (comment,itemid,userid) VALUES (?,?,?)");
                        $stmt->execute(array($cmnt,$item->itemid,$_SESSION['user_member']));
                    }else{
                        foreach($formError as $error){
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    }
                }
            }
        ?>
        <h3 class="comment-title">Add Your Comment</h3>
        <form action="<?php echo $_SERVER['PHP_SELF']."?id=".$id; ?>" method="post">
            <div class="form-groupe">
                <label>Comment :</label>
                <textarea name="comment" autofocus required rows="10"></textarea>
            </div>
            <div class="form-groupe">
                <input type="submit" class="form-save-success" value="Post Comment">
            </div>
        </form>
        <?php else:
        echo "<div class='alert alert-danger'><a style='color:#fff;' href='login.php'>Log In</a> Or <a style='color:#fff;' href='login.php'>Sign Up</a> , To Add A Comment</div>";
        endif; ?>
    </div>
    <!-- display all comment -->
    <div class="container">
        <?php
            $allComments = getComments("comments.*,users.username",$item->itemid,"status=1 AND itemid","INNER JOIN users ON users.userid = comments.userid");
            if(!empty($allComments)):
            foreach($allComments as $comment):
        ?>
            <div class="show-cmnt-container">
                <div class="user-img-c">
                    <img src="avatar.png" alt="avatar">
                    <a><?php echo $comment->username;?></a>
                </div>
                <div class="user-comment-all">
                    <p><?php echo $comment->comment; ?></p>
                    <div class="date"><time datetime="<?php echo $comment->date; ?>"><?php echo $comment->date; ?></time></div>
                </div>
            </div>
        <?php
                endforeach;
            else:
                echo "<div class='alert alert-danger'>There Are No Comments To Show</div>";
        endif;
        ?>
    </div>
<?php
    }else{
        redirect("<div class='alert alert-danger'>There Is No Such Item <br> Or This Item Is Not Approved Yet From The Administration</div>",5,"back");
    }
    include $template."footer.php";
