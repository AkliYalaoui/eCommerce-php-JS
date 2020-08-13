<?php
    session_start();
    $pageTitle="Profile";
    include 'init.php';
    if(isset($_SESSION['user'])){

        if(!isset($_GET['do'])){
        $stmt = $con->prepare("SELECT * FROM users WHERE username=?");
        $stmt->execute(array($_SESSION['user']));
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $items = getItems($user->userid,"userid");
        $comments = getComments(null,$user->userid,"userid",null);
        ?>
    <h1 class="edit-title">My Profile</h1>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Information</div>
            <div class="panel-body">
                <ul class="user-info">
                    <li>
                        <span><i class="fa fa-unlock-alt fa-fw"></i> Name</span><?php echo ": ".$user->username; ?>
                    </li>
                    <li>
                        <span><i class="fa fa-envelope fa-fw"></i> Email</span><?php echo ": ".$user->email; ?>
                    </li>
                    <li>
                        <span><i class="fa fa-user-alt fa-fw"></i> Full Name</span><?php echo ": ".$user->fullname; ?>
                    </li>
                    <li>
                        <span><i class="fa fa-calendar fa-fw"></i> Registred Date</span>
                        <time datetime="<?php echo $user->regdate;?>"><?php echo ": ".$user->regdate;?></time>
                    </li>
                    <li>
                        <span><i class="fa fa-tags fa-fw"></i> Favourite Category :</span>
                    </li>
                </ul>
                <a class="btn btn-success" href="?do=Edit">Edit Profile</a>
            </div>
        </div>
        <div id="my-items" class="panel panel-primary">
            <div class="panel-heading">Latest Items</div>
            <div class="panel-body">
                <?php if(!empty($items)){ ?>
                <div class="card-container">
                <?php foreach($items as $item): ?>
                    <div class="card">
                        <div class="card-header">
                            <img src="<?php echo !is_null($item->img) ? 'data/uploads/'.$item->img : "avatar.png" ;?>" alt="image">
                            <div class="card-overlay">
                                <span>$<?php echo $item->price ?></span>
                                <?php
                                    if($item->approuve == 0){
                                        echo "<span>Waiting For Approval</span>";
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <h3><a href="items.php?id=<?php echo $item->itemid; ?>"><?php echo $item->name ?></a></h3>
                            <p><?php echo $item->description ?></p>
                            <div class="date"> <time datetime="<?php echo $item->date ?>"><?php echo $item->date ?></time></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
                <?php
                }else{
                    echo 'There Is No Items To Show , <a href="ads.php">New Add</a>';
                } ?>
            </div>
        </div>
        <div id="my-comments" class="panel panel-primary">
            <div class="panel-heading">Latest Comments</div>
            <div class="panel-body">
                <?php
                    if(!empty($comments)){
                        foreach($comments as $comment): ?>
                            <div class="user-cm-profile">
                                <p><?php echo $comment->comment; ?></p>
                                <div class="date"><time datetime="<?php echo $comment->date;?>"><?php echo $comment->date;?></time></div>
                            </div>
                        <?php endforeach;
                    }else{
                        echo 'There Is No Comments To Show';
                    }
                ?>
            </div>
        </div>
    </div>
<?php
        }else{
            $do = $_GET['do'];
            if($do=="Edit"){
                $stmt = $con->prepare("SELECT * FROM users WHERE username=?");
                $stmt->execute(array($_SESSION['user']));
                if($stmt->rowCount() > 0){
                    $user = $stmt->fetch(PDO::FETCH_OBJ);
                ?>
                <h1 class="edit-title">Edit Profile</h1>
                <div class="container">
                    <form action="?do=Update" method="POST" enctype="multipart/form-data">
                        <div class="form-groupe">
                            <label>Username : </label>
                            <input type="text" value="<?php echo $user->username;?>" name="username" autofocus autocomplete="off">
                        </div>
                        <div class="form-groupe">
                            <label>Password : </label>
                            <input type="password" placeholder="Leave It Blank If You Do Not Want To Update It" name="password" autocomplete="new-password">
                            <input type="hidden" name="oldPassword" value="<?php echo $user->password;?>">
                        </div>
                        <div class="form-groupe">
                            <label>Email : </label>
                            <input type="email" value="<?php echo $user->email;?>" name="email">
                        </div>
                        <div class="form-groupe">
                            <label>Fullname : </label>
                            <input type="text" value="<?php echo $user->fullname;?>" name="fullname">
                        </div>
                        <!-- start Profile Image field -->
                        <div class="form-groupe">
                            <label>Avatar : </label>
                            <input type="file" name="avatar">
                        </div>
                        <div class="form-groupe">
                            <input type="submit" class="form-save" name="submit" value="Save">
                        </div>
                    </form>
                </div>
            <?php
                }else{

                }
            }elseif($do=="Update"){
                if($_SERVER['REQUEST_METHOD'] == "POST"){
                    if(isset($_FILES['avatar']) && isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['oldPassword']) && isset($_POST['username'])){
                        $avatar =$_FILES['avatar'];
                        $username = trim(filter_var($_POST['username'],FILTER_SANITIZE_STRING));
                        $fullname = trim(filter_var($_POST['fullname'],FILTER_SANITIZE_STRING));
                        $password = trim(filter_var($_POST['password'],FILTER_SANITIZE_STRING));
                        $email = trim(filter_var($_POST['email'],FILTER_SANITIZE_EMAIL));
                        
                        $formErrors = array();
                        if(empty($username)){
                            array_push($formErrors,"Username Can Not BE Empty");
                        }
                        if(strlen($username) < 4){
                            array_push($formErrors,"Username Can Not BE Less Than 4 Characters");
                        }
                        if(empty($password)){
                            $password = $_POST['oldPassword'];
                        }else{
                            $password = sha1($password);
                        }
                        if(empty($email)){
                            array_push($formErrors,"Email Can Not BE Empty");
                        }
                        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                            array_push($formErrors,"Email Is Not Valid");
                        }
                        $profilePic = "";
                        if(count($formErrors) == 0 && !empty($avatar['name'])){
                         //deal with the avatar
                            $img_extension =  array('png','jpeg','jpg',"gif");
                            $avatarExploded = explode('.',$avatar['name']);
                            $avatarExtension = strtolower(array_pop($avatarExploded));
        
                            if(in_array($avatarExtension,$img_extension)){
                                if($avatar['size'] <= pow(2,22)){
                                    if($avatar['error'] == 0){
                                        $profilePic = uniqid($name ,true).".".$avatarExtension;
                                        move_uploaded_file($avatar['tmp_name'],'data/uploads/'.$profilePic);
                                    }else{
                                        array_push($formErrors,'<div class="alert alert-danger">Sorry...Something Went Wrong!</div>');
                                    }
                                }else{
                                    array_push($formErrors,'<div class="alert alert-danger">Avatar Size Can Not Be Less Than 4MB</div>');
                                }
                            }else{
                                array_push($formErrors,'<div class="alert alert-danger">Please,Upload The Right Image</div>');
                            }
                        }
                        if(count($formErrors) == 0){
                            $stmt = $con->prepare('SELECT * FROM users WHERE username=? AND userid != ?');
                            $stmt->execute(array($username,$_SESSION['user_member']));
                            if($stmt->rowCount() == 0){
                            $stmt = $con->prepare("UPDATE users SET username=?,password=?,email=?,fullname=?,avatar=? WHERE userid=?");
                            $stmt->execute(array($username,$password,$email,$fullname,$profilePic,$_SESSION['user_member']));
                            echo "<div class='alert alert-success'>Profile Updated</div>";
                            }else{
                                echo "<div class='alert alert-danger'>Username Already Exists</div>";
                            }
                        }else{
                            echo "<div class='container'>";
                                foreach($formErrors as $error){
                                    echo "<div class='alert alert-danger'>".$error."</div>";
                                }
                            echo "</div>";
                        }
                    }
                }
            }else{
                redirect('<div class="alert alert-danger">There Is No Such Page</div>',5,'back');
            }
        }
    }else{
        header("Location:login.php");
        exit();
    }
    include $template."footer.php";