<?php
    ob_start();
    session_start();
    $pageTitle = 'dashboard';
    if(isset($_SESSION['username'])){
        include 'init.php';?>
        <div class="container">
            <h1 class="edit-title dash-title">Dashboard</h1>
        </div>
        <div class="container">
            <div class="stats-container">
                <div class="stat">Total Members <span><a href="members.php"><?php echo items_count("userid","users"); ?></a></span></div>
                <div class="stat">Pending Members <span><a href="members.php?do=Pending"><?php echo items_count("regstatus","users","WHERE regstatus=0"); ?></a></span></div>
                <div class="stat">Total Items <span><a href="items.php"><?php echo items_count("itemid","items"); ?></a></span></div>
                <div class="stat">Total Comments <span><a href="comments.php"><?php echo items_count("commentid","comments"); ?></a></span></div>
            </div>
        </div>
        <div class="container">
            <div class="panel-container">
                <div class="panel">
                    <?php define('_LATEST_USERS_',5);?>
                    <div class="panel-heading">
                        <span>Latest <?php echo _LATEST_USERS_; ?> Registred Users</span>
                        <span class="toggle-info">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                    <table class="table mg-auto">
                    <thead>
                        <tr>
                            <td>UserName</td>
                            <td>Registred Date</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $regUsers = latest("*","users",_LATEST_USERS_,"userid");
                            if(!empty($regUsers)){
                            foreach($regUsers as $user): ?>
                            <tr class="odd">
                                <td><?php echo $user->username ?></td>
                                <td><?php echo $user->regdate ?></td>
                                <td>   
                                    <a class="btn btn-success dp-inherit" href="members.php?do=Edit&id=<?php echo $user->userid ?>">Edit</a>
                                    <?php if($user->regstatus == 0): ?>
                                        <a class="btn btn-purple dp-inherit" href="members.php?do=Activate&id=<?php echo $user->userid ?>">Activate</a>
                                    <?php endif; ?> 
                                    <a class="btn btn-danger dp-inherit" onclick="return confirm('Do You Really Want To Delete ?')" href="members.php?do=Delete&id=<?php echo $user->userid ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach;
                                }else{
                                    echo '<div class="alert alert-info">There Is No Users To Show</div>';
                                } ?>
                        </tbody>
                </table>   
                    </div>
                </div>
                <div class="panel">
                    <?php define('_ITEM_',5);?>
                    <div class="panel-heading">
                        <span> Latest <?php echo _ITEM_; ?> Items</span>
                        <span class="toggle-info">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                    <table class="table mg-auto">
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Price</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $latestItems = latest("*","items",_ITEM_,"itemid");
                            if(!empty($latestItems)){
                            foreach($latestItems as $item): ?>
                            <tr class="odd">
                                <td><?php echo $item->name ?></td>
                                <td><?php echo $item->price ?></td>
                                <td>   
                                    <a class="btn btn-success dp-inherit" href="items.php?do=Edit&id=<?php echo $item->itemid ?>">Edit</a>
                                    <a class="btn btn-danger dp-inherit" onclick="return confirm('Do You Really Want To Delete ?')" href="items.php?do=Delete&id=<?php echo $item->itemid?>">Delete</a>
                                    <?php if($item->approuve == 0): ?>
                                        <a class="btn btn-purple dp-inherit" href="items.php?do=Approuve&id=<?php echo $item->itemid ?>">Approuve</a>
                                    <?php endif; ?> 
                                </td>
                            </tr>
                        <?php   
                                endforeach;
                                }else{
                                    echo '<div class="alert alert-info">There Is No Items To Show</div>';
                                } ?>
                        </tbody>
                </table>   
                    </div>
                </div>
                <div class="clear-fix"></div>
                <div class="panel">
                    <?php define('_CMNT_',5);?>
                    <div class="panel-heading">
                        <span> Latest <?php echo _CMNT_; ?> Comments</span>
                        <span class="toggle-info">
                            <i class="fa fa-plus fa-lg"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <?php 
                            $stmt = $con->prepare("SELECT comments.*,users.username FROM comments
                            INNER JOIN users ON users.userid = comments.userid ORDER BY commentid DESC LIMIT "._CMNT_);
                            $stmt->execute();
                            $comments  = $stmt->fetchAll(PDO::FETCH_OBJ); 
                            if($stmt->rowCount() > 0){
                            foreach($comments as $comment):
                        ?>
                        <div class="comment-box">
                            <a href="members.php?do=Edit&id=<?php echo $comment->userid ?>"><?php echo $comment->username ?></></a>
                            <p><?php echo $comment->comment ?></p>
                            <div class="clear-fix"></div>
                            <a class="btn btn-danger"  onclick="return confirm('Do You Really Want To Delete ?')" href="comments.php?do=Delete&id=<?php echo $comment->commentid ?>">Delete</a>
                                    <a  class="btn btn-success" href="comments.php?do=Edit&id=<?php echo $comment->commentid ?>">Edit</a>
                                    <?php if($comment->status == 0): ?>
                                        <a  class="btn btn-purple" href="comments.php?do=Approuve&id=<?php echo $comment->commentid ?>">Approuve</a>
                                    <?php endif; ?>
                        </div>
                        <?php 
                                endforeach;
                                }else{
                                    echo '<div class="alert alert-info">There Is No Comments To Show</div>';
                                } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include $template . "footer.php";
    }else{
        header('Location:index.php'); //user can't acces this page , redirect to login
        exit(); // exit script
    }
    ob_end_flush();
?>
<script src="layout/js/edit.js"></script>
