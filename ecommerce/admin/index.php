<?php 
       include 'init.php';
       include $template . "header.php";
       include 'includes/languages/english.php';

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
                       echo 'Welcome ' . $username;
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

                    <input class="form-btn" type="submit" value="Log In">
             </form>
           </div>
        </section>
      </main>
<?php include $template . "footer.php"; ?>