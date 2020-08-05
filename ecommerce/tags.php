<?php 
        session_start();
        $pageTitle = "Tags";
        include 'init.php';
        if(isset($_GET['tag'])){
        ?>
            <div class="container card-container">
            <h1 class="edit-title"><?php echo $_GET['tag'] ?></h1>
            <?php  
                $tag =  $_GET['tag'];
                $items = getItems(1,"tags LIKE '%$tag%'  AND approuve");
                if(!empty($items)){
                    foreach($items as $item):
            ?>
                    <div class="card">
                        <div class="card-header">
                            <img src="avatar.png" alt="image">
                            <div class="card-overlay">
                                <span>$<?php echo $item->price ?></span>
                            </div>
                        </div>
                        <div class="card-body">
                        <h3><a href="items.php?id=<?php echo $item->itemid; ?>"><?php echo $item->name ?></a></h3>
                            <p><?php echo $item->description ?></p>
                            <div class="date"> <time datetime="<?php echo $item->date ?>"><?php echo $item->date ?></time></div>
                        </div>
                    </div>
            <?php 
                endforeach;
                }else{
                    echo "<div class='alert alert-danger'>There Is No Item In This Tag</div>";
            }
        }else{
            echo "<div class='alert alert-danger'>There Is No Such Page</div>";
        }
            ?>
        </div>

<?php include $template . "footer.php"; ?>