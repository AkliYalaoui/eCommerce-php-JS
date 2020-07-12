<?php 
       session_start();
       $noNavbar = 'yes';
       $pageTitle = 'login';
       if(isset($_SESSION['username'])){
              header('Location: dashboard.php'); // redirect to dashboard
       }
       include 'init.php';
        //display a message error if user does not exist
        $msgErr = "";
       // check if user coming from HTTP POST REQUEST 
       if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $username = $_POST['username'];
            $password = $_POST['password'];
            //secure the password
            $hashedPass = sha1($password);  // echo $password.' | '. $hashedPass ;

            //check if the user exists in the database
            $query = " SELECT
                             userid,username,password 
                       FROM
                              users
                       WHERE 
                              username = ? 
                       AND 
                              password = ? 
                       AND
                              groupeid = ?
                       LIMIT   1";
            $statement = $con->prepare($query);
            $statement->execute(array($username,$hashedPass,1));
            $row   = $statement->fetch();
            $count = $statement -> rowCount();
            //if count > 0 means that db contain record about this user
            if($count > 0){
                 $_SESSION['username'] = $username; // register session username
                 $_SESSION['id']       = $row['userid'];  // register session id        
                 header('Location: dashboard.php'); // redirect to dashboard
                 exit();   // exit the script
            }else{
              $msgErr = 'username/password is not valid';
            }

       }
 ?>

    <main>
        <section> <p></p> </section>
        <section> <img src="./layout/images/login.svg" alt="login"> </section>
        <section class="login">
              <h4>Admin Login</h4>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                   <div class="form-group">
                    <input 
                          class="form-control"
                           type="text"
                           name="username"
                           placeholder="Username"
                           autocomplete="off">
                      <i class="fa fa-user fa-fw"></i>     
                  </div> 
                  <div class="form-group">
                    <input
                           class="form-control" 
                           type="password" 
                           name="password" 
                           placeholder="Password" 
                           autocomplete="new-password">
                       <i class="fa fa-key fa-fw"></i>    
                  </div>

                    <div style="   padding: 5px;
                                   margin: 10px 0;
                                   color: #f00;
                                   font-size: 20px;
                                   text-align: center;">
                                   <?php echo $msgErr;?>
                     </div> 
                     <div class="form-group">
                       <input class="form-btn" type="submit" value="Log In">
                       <i class="fa fa-door-open fa-fw"></i>
                     </div>
             </form>
        </section>
      </main>
      <script src="<?php echo $js ; ?>login.js"></script>
<?php include $template . "footer.php"; ?>