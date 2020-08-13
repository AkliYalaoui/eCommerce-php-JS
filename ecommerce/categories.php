<?php
        session_start();
        $pageTitle = "Categories";
        include 'init.php';
        if(isset($_GET['name']) && isset($_GET['id'])){
        ?>

            <h1 class="edit-title"><?php echo str_replace('-'," ",$_GET['name']) ?></h1>
            <div class="container card-container">
            <?php
                $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id']:0;
                $items = getItems($id,"approuve=1 AND categoryid");
                if(!empty($items)){
                    foreach($items as $item):
            ?>
                    <div class="card">
                        <div class="card-header">
                            <img src="<?php echo !is_null($item->img) ? 'data/uploads/'.$item->img : "avatar.png" ;?>" alt="image">
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
                    echo "<div class='alert alert-danger'>There Is No Item In This Category</div>";
            }
        }else{
            echo "<div class='alert alert-danger'>There Is No Such Page</div>";
        }
            ?>
        </div>

<?php include $template . "footer.php"; ?>
