<?php
    ob_start();
    session_start();

    if(isset($_SESSION['username'])){
        $pageTitle = "Comments";
        include 'init.php';
        $do = isset($_GET['do']) ? $_GET['do']: "Manage";
        if($do == "Manage"){
            $stmt = $con->prepare("SELECT comments.*,users.username,items.name FROM comments
            INNER JOIN items ON items.itemid = comments.itemid
            INNER JOIN users ON users.userid = comments.userid");
            $stmt->execute();
            $comments  = $stmt->fetchAll(PDO::FETCH_OBJ); 
            ?>

            <h1 class="edit-title">Manage Comments</h1>
            <div class="container table-container">
            <table class="table mg-auto">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Comment</td>
                            <td>Item Name</td>
                            <td>User Name</td>
                            <td>Added Date</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($comments as $comment): ?>
                            <tr>
                                <td><?php echo $comment->commentid ?></td>
                                <td><?php echo $comment->comment ?></td>
                                <td><?php echo $comment->name ?></td>
                                <td><?php echo $comment->username ?></td>
                                <td><?php echo $comment->date ?></td>
                                <td>
                                    <a class="btn btn-danger dp-inherit"  onclick="return confirm('Do You Really Want To Delete ?')" href="?do=Delete&id=<?php echo $comment->commentid ?>">Delete</a>
                                    <a  class="btn btn-success dp-inherit" href="?do=Edit&id=<?php echo $comment->commentid ?>">Edit</a>
                                    <?php if($comment->status == 0): ?>
                                        <a  class="btn btn-purple dp-inherit" href="?do=Approuve&id=<?php echo $comment->commentid ?>">Approuve</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>    
                    </tbody>
                </table>
            </div>

        <?php
        }elseif($do == "Edit"){
            $id = isset($_GET["id"]) && is_numeric($_GET['id']) ? $_GET['id']:0;

            $stmt = $con->prepare('SELECT * FROM comments WHERE commentid = ? ');
            $stmt->execute(array($id));
            $comment = $stmt->fetch(PDO::FETCH_OBJ);
            if($stmt->rowCount() > 0){?>
                <div class="container">
                    <h1 class="edit-title">Edit A Comment</h1>
                    <form action="?do=Update" method="post">
                        <input type="hidden" name="commentid" value="<?php echo $comment->commentid; ?>">
                        <div class="form-groupe">
                            <label>Comment:</label>
                            <textarea type="text" name="comment" required autofocus><?php echo $comment->comment?></textarea>
                        </div>
                        <div class="form-groupe">
                            <input type="submit" value="Save" class="form-save">
                        </div>
                    </form>
                </div>
            <?php }else{
                redirect("<div class='alert alert-danger'>There Is No Such Comment</div>",5,'back');
            }
        }elseif($do == "Update"){
            if($_SERVER['REQUEST_METHOD'] === "POST"){
                echo "<h1 class='edit-title'>Update Comment</h1>";
                if(isset($_POST['commentid']) && isset($_POST['comment'])){

                    $id = $_POST['commentid'];
                    $comment = $_POST['comment'];
                    if(!empty(trim($comment))){
                        if(is_exist($con,"commentid","comments",$id)){
                            $stmt = $con->prepare("UPDATE comments SET comment=? WHERE commentid=?");
                            $stmt->execute(array($comment,$id));
                            redirect("<div class='alert alert-success'>".$stmt->rowCount()." Record Updated</div>",4,'back');
                        }else{
                            redirect("<div class='alert alert-danger'>There Is No Such Comment</div>",5,'back');
                        }
                    }else{
                        echo "<div class='container'>
                                    <div class='alert alert-danger'>Comment Can Not Be Emtpy</div>
                                </div>";
                    }
                }

            }else{
                redirect("<div class='alert alert-danger'>You Can't Access This Page Directly</div>");
            }

        }elseif($do == "Delete"){
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id']:0;
            echo "<h1 class='edit-title'>Delete Comment</h1>";
            if(is_exist($con,'commentid','comments',$id)){
                $stmt = $con->prepare("DELETE FROM comments WHERE commentid=?");
                $stmt->execute(array($id));
                redirect("<div class='alert alert-success'>Comment Deleted Successfully</div>",5,'back');
            }else{
                redirect("<div class='alert alert-danger'>There Is No Such Comment</div>",5,'back');
            }
        }elseif($do == "Approuve"){
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id']:0;
            echo "<h1 class='edit-title'>Approuve Comment</h1>";
            if(is_exist($con,'commentid','comments',$id)){
                $stmt = $con->prepare("UPDATE comments SET status=1 WHERE commentid=?");
                $stmt->execute(array($id));
                redirect("<div class='alert alert-success'>Comment Approuved Successfully</div>",5,'back');
            }else{
                redirect("<div class='alert alert-danger'>There Is No Such Comment</div>",5,'back');
            }
        }elseif($do == "ItemsComment"){
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id']:0;
            $stmt = $con->prepare("SELECT comments.*,users.username FROM comments
            INNER JOIN users ON users.userid = comments.userid WHERE itemid = ?");
            $stmt->execute(array($id));
            $comments  = $stmt->fetchAll(PDO::FETCH_OBJ); 
            if($stmt->rowCount() > 0){
            ?>
            <h1 class="edit-title">Manage 
                [<?php
                        $stmt = $con->prepare("SELECT name FROM items WHERE itemid=?");
                        $stmt->execute(array($id));
                        $item = $stmt->fetch(PDO::FETCH_OBJ); 
                    echo $item->name ?>] Comments</h1>
            <div class="container table-container">
            <table class="table mg-auto">
                    <thead>
                        <tr>
                            <td>Comment</td>
                            <td>User Name</td>
                            <td>Added Date</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($comments as $comment): ?>
                            <tr>
                                <td><?php echo $comment->comment ?></td>
                                <td><?php echo $comment->username ?></td>
                                <td><?php echo $comment->date ?></td>
                                <td>
                                    <a class="btn btn-danger dp-inherit"  onclick="return confirm('Do You Really Want To Delete ?')" href="?do=Delete&id=<?php echo $comment->commentid ?>">Delete</a>
                                    <a  class="btn btn-success dp-inherit" href="?do=Edit&id=<?php echo $comment->commentid ?>">Edit</a>
                                    <?php if($comment->status == 0): ?>
                                        <a  class="btn btn-purple dp-inherit" href="?do=Approuve&id=<?php echo $comment->commentid ?>">Approuve</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>    
                    </tbody>
                </table>
            </div>
        <?php }else{
            redirect("<div class='alert alert-info'>There Is No Comments For This Item</div>",4,'back');
        }
        }else{
            redirect("<div class='alert alert-danger'>There Is No Such Page</div>",5,'back');
        }
        include $template."footer.php";
    }else{
        header('Location:index.php');
        exit();
    }
?>
<script src="layout/js/edit.js"></script>