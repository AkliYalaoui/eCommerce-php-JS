<?php
    ob_start();
    session_start();
    $pageTitle = 'dashboard';
    if(isset($_SESSION['username'])){
        include 'init.php';?>
        <div class="container">
            <h1 class="dash-title">Dashboard</h1>
        </div>
        <div class="container">
            <div class="stats-container">
                <div class="stat">Total Members <span><a href="members.php"><?php echo items_count("userid","users"); ?></a></span></div>
                <div class="stat">Pending Members <span><a href="members.php?do=Pending"><?php echo items_count("regstatus","users","WHERE regstatus=0"); ?></a></span></div>
                <div class="stat">Total Items <span>1500</span></div>
                <div class="stat">Total Comments <span>3500</span></div>
            </div>
        </div>
        <div class="container">
            <div class="panel-container">
                <div class="panel">
                    <?php $latestUsers = 5 ?>
                    <div class="panel-heading">Latest <?php echo $latestUsers; ?> Registred Users</div>
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
                            $regUsers = latest("*","users",$latestUsers,"userid");
                            foreach($regUsers as $user): ?>
                            <tr class="odd">
                                <td><?php echo $user->username ?></td>
                                <td><?php echo $user->regdate ?></td>
                                <td>   
                                    <a class="dp-inherit" href="members.php?do=Edit&id=<?php echo $user->userid ?>">Edit</a>
                                    <?php if($user->regstatus == 0): ?>
                                        <a class="dp-inherit" href="members.php?do=Activate&id=<?php echo $user->userid ?>">Activate</a>
                                    <?php endif; ?> 
                                    <a class="dp-inherit" onclick="return confirm('Do You Really Want To Delete ?')" href="members.php?do=Delete&id=<?php echo $user->userid ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?> 
                        </tbody>
                </table>   
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-heading">Latest Items</div>
                    <div class="panel-body">Test</div>
                </div>
            </div>
        </div>
        <?php include $template . "footer.php";
    }else{
        header('Location:index.php'); //user can't acces this page , redirect to login
        exit(); // exit script
    }
    ob_end_flush();


