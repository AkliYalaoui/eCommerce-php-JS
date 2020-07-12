<?php

      /*
      ==================================================
      == Manage members page
      == you can add | edit  | delete members   
      ==================================================
      */

      session_start();
      $pageTitle = 'Members';
    if(isset($_SESSION['username'])){
        include 'init.php';

        $do = '';

        if(isset($_GET['do'])){
             $do = $_GET['do'];
        }else{
             $do = 'Manage';
        }   
        // start manage page 
        if($do == 'Manage'){

        }elseif($do == 'Add'){
     
        }elseif($do == 'Edit'){ // edit page 
        
         $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): 0;
         
         $query = 'SELECT * FROM users WHERE userid = ? LIMIT 1';
         $stmt =  $con->prepare($query);
         $stmt->execute(array($id));
         $row = $stmt->fetch();
         $count = $stmt->rowCount();
         if($count > 0){
        ?>    
            <div class="container">
                <h1 class="edit-title">Edit Member</h1> 
                <form action="?do=Update" method="POST">
                    <input type="hidden" name="userid" value="<?php echo $id; ?>">
                <!-- start username field -->
                    <div class="form-groupe">
                        <label>Username</label>
                        <input type="text" name="username" value="<?php echo $row['username']; ?>" autocomplete="off">
                    </div>
                    <!-- start password field -->
                    <div class="form-groupe">
                        <label>Password</label>
                        <input type="password" name="newpassword" autocomplete="new-password">
                        <input type="hidden" name="oldpassword" value="<?php echo $row['password']; ?>" autocomplete="new-password">
                    </div>
                    <!-- start email field -->
                    <div class="form-groupe">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo $row['email']; ?>" autocomplete="off">
                    </div>
                     <!-- start Full name field -->
                     <div class="form-groupe">
                        <label>Full name</label>
                        <input type="text" name="full" value="<?php echo $row['fullname']; ?>">
                    </div>
                    <!-- start save field -->
                    <div class="form-groupe">
                        <input type="submit" value="save" class="form-save">
                    </div>
                </form>
            </div>    

        <?php
           }else{
               echo '<h1 style="text-align:center;color:#f00;">there is no such id</h1><br/>';
           }
        }elseif($do == 'Update'){
            //update page
          echo   '<h1 class="edit-title">Update Member</h1>';
            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                    //get variables from the post
                    $id =$_POST['userid'];
                    $username =$_POST['username'];
                    $email =$_POST['email'];
                    $full =$_POST['full'];
                    $Newpassword =  empty($_POST['newpassword']) ? $_POST['oldpassword']: sha1($_POST['newpassword']);
                    //validate the form
                    
             // update the database
             $query = 'UPDATE users SET username=?,password=?,email=?,fullname=? WHERE userid=?';
             $stmt = $con->prepare($query);
             $stmt->execute(array($username,$Newpassword,$email,$full,$id));
                //echo succes message
                echo '<h2 style="text-align:center;color:#0F0;">'.$stmt->rowCount().' record updated</h2><br/>';
            }else{
                echo '<h2 style="text-align:center;color:#f00;">You can\' browse this page directly</h2><br/>';
            }

        }elseif($do == 'Delete'){
     
         }elseif($do == 'Insert'){
     
         }else{
             echo '<h1>There is no such page with this name</h1>' ;
         }

        include $template . "footer.php";
    }else{
        header('Location:index.php'); //user can't acces this page , redirect to login
        exit(); // exit script
    }
