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
                $items = getItems($id);
                if(!empty($items)){
                    foreach($items as $item):
            ?>
                    <div class="card">
                        <div class="card-header">
                            <img src="avatar.png" alt="image">
                            <div class="card-overlay">
                                <?php echo $item->price ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <h3><?php echo $item->name ?></h3>
                            <p><?php echo $item->description ?></p>
                        </div>
                    </div>
            <?php 
                endforeach;
                }else{
                    redirect("<div class='alert alert-danger'>There Is No Item In This Category</div>",5,'back');
            }
        }else{
            redirect("<div class='alert alert-danger'>There Is No Such Page</div>",5,'back');
        }
            ?>
        </div>

<?php include $template . "footer.php"; ?>