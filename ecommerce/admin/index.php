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
            $query = "SELECT username,password FROM users WHERE username = ? AND password = ? AND groupeid = ?";
            $statement = $con->prepare($query);
            $statement->execute(array($username,$hashedPass,1));
            $count = $statement -> rowCount();
            //if count > 0 means that db contain record about this user
            if($count > 0){
                 $_SESSION['username'] = $username; // register session username
                 header('Location: dashboard.php'); // redirect to dashboard
                 exit();   // exit the script
            }else{
              $msgErr = 'username/password is not valid';
            }

       }else{

       }
 ?>

    <main>
         
        <section class="login">
          <div id="app-login"> 
              <h4>Admin Login</h4>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input v-on:focus="placeHolderHider('A')"
                           v-on:blur="placeHolderShower('A')"
                           class="form-control"
                           type="text"
                           name="username"
                           v-bind:placeholder="placeholderA"
                           autocomplete="off">

                    <input v-on:focus="placeHolderHider('B')" 
                           v-on:blur="placeHolderShower('B')"
                           class="form-control" 
                           type="password" 
                           name="password" 
                           v-bind:placeholder=" placeholderB" 
                           autocomplete="new-password">
                    <div style="   padding: 5px;
                                   margin: 10px 0;
                                   color: #f00;
                                   font-size: 20px;
                                   text-align: center;">
                                   <?php echo $msgErr;?>
                     </div> 
                    <input class="form-btn" type="submit" value="Log In">
             </form>
           </div>
        </section>
      </main>
      <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
      <script src="<?php echo $js ; ?>login.js"></script>
<?php include $template . "footer.php"; ?>