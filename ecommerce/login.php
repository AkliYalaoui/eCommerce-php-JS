<?php
    session_start();
    if(isset($_SESSION['user'])){
        header('Location:index.php');
        exit();
    }else{
    $pageTitle = "Login/Signup";
    include "init.php";

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])){
            $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
            $formErrors = array();
            if(empty(trim($username))){
                array_push($formErrors,"Username Can Not BE Empty");
            }
            if(empty(trim($password))){
                array_push($formErrors,"Password Can Not BE Empty");
            }
            if(count($formErrors) == 0){
                $stmt = $con->prepare('SELECT * FROM users WHERE username=? AND password=?');
                $stmt->execute(array($username,sha1($password)));
                if($stmt->rowCount() > 0){
                    $_SESSION['user'] = $username;
                    header('Location:index.php');
                    exit();
                }else{
                    echo "<div class='container'><div class='alert alert-danger'>User Does Not Exist</div></div>";
                }
            }else{
                echo "<div class='container'>";
                foreach($formErrors as $error){
                    echo "<div class='alert alert-danger'>$error</div>";
                }
                echo "</div>";
            }
        }
        if(isset($_POST['signup']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])){
            $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

            $formErrors = array();
            if(empty(trim($username))){
                array_push($formErrors,"Username Can Not BE Empty");
            }
            if(strlen($username) < 4){
                array_push($formErrors,"Username Can Not BE Less Than 4 Characters");
            }
            if(empty(trim($password))){
                array_push($formErrors,"Password Can Not BE Empty");
            }
            if(empty(trim($email))){
                array_push($formErrors,"Email Can Not BE Empty");
            }
            if(count($formErrors) == 0){
                if(!is_exist($con,"username","users",$username)){
                    $stmt = $con->prepare('INSERT INTO users (username,password,email) VALUES(?,?,?)');
                    $stmt->execute(array($username,sha1($password),$email));
                    $_SESSION['user'] = $username;
                    header('Location:index.php');
                    exit();
                }else{
                    echo "<div class='container'>";
                        echo "<div class='alert alert-danger'>User Already Exists</div>";
                    echo "</div>";
                }
            }else{
                echo "<div class='container'>";
                foreach($formErrors as $error){
                    echo "<div class='alert alert-danger'>$error</div>";
                }
                echo "</div>";
            }
        }
    }
?>
    <div class="container">
        <h1 class="edit-title lg-sg">
            <span class="lg-span show" data-show="login" data-hide="signup">Login</span> |
            <span class="lg-span" data-show="signup" data-hide="login">Signup</span>
        </h1>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="login" class="show">
            <div class="form-groupe">
                <label>Username :</label>
                <input type="text" name="username" required autocomplete="off" autofocus>
            </div>
            <div class="form-groupe">
                <label>Password :</label>
                <input type="password" name="password" required autocomplete="new-password">
            </div>
            <div class="form-groupe">
                <input type="submit" class="form-save" name="login" value="Login">
            </div>
        </form>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="signup">
            <div class="form-groupe">
                <label>Username :</label>
                <input type="text" placeholder="Username can not be less than 4 characters" name="username" required autocomplete="off">
            </div>
            <div class="form-groupe">
                <label>Password :</label>
                <input type="password" placeholder="Type A Strong Password" name="password" required autocomplete="new-password">
            </div>
            <div class="form-groupe">
                <label>Email :</label>
                <input type="email" placeholder="Type A Valid Email" name="email" required>
            </div>
            <div class="form-groupe">
                <input type="submit" class="form-save-success" name="signup" value="Signup">
            </div>
        </form>
    </div>
<?php
    }
    include $template."footer.php";
?>