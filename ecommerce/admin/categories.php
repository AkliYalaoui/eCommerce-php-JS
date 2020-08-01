<?php
    ob_start();
    session_start();
    if(isset($_SESSION['username'])){
        $pageTitle = "Categories";
        include 'init.php';
            $do = isset($_GET['do']) ? $_GET['do']:"Manage";
            if($do == "Manage"){
                $sort  = "ASC";
                $order = "ordering";
                $sort_options = array("ASC","DESC");
                $order_options = array("id","ordering","name","description");
                if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_options)){
                    $sort = $_GET['sort'];
                }
                if(isset($_GET['order']) && in_array($_GET['order'],$order_options)){
                    $order = $_GET['order'];
                }
                $stmt = $con->prepare("SELECT * FROM categories ORDER BY $order $sort");
                $stmt->execute();
                $categories  = $stmt->fetchAll(PDO::FETCH_OBJ);
            ?>
                <div class="container">
                    <h1 class="edit-title">Manage Categories</h1> 
                    <a class="btn-primary" href="?do=Add"><span>+</span>New Category</a>
                    <div class="panel mg-top-20">
                    <div class="panel-heading ordering">
                        <span>Manage Categories</span>
                        <!-- <div>
                            Order By:
                            <select onchange="location.href=this.value">
                                <option value="?do=Manage&order=ordering">ordering</option>
                                <option value="?do=Manage&order=id">id</option>
                                <option value="?do=Manage&order=name">name</option>
                                <option value="?do=Manage&order=description">description</option>
                            </select>
                        </div> -->
                        <div>
                            Ordering : 
                            <a class="btn btn-night btn-opacity <?php if($sort=="DESC"){echo "active";}?>" href="?do=Manage&sort=DESC">DESC</a>
                            <a class="btn btn-night btn-opacity<?php if($sort=="ASC"){echo "active";}?>" href="?do=Manage&sort=ASC">ASC</a>
                            View :
                            <span id="classic" class="btn btn-success btn-opacity active">Classic</span>
                            <span id="full" class="btn btn-success btn-opacity">Full</span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php foreach($categories as $category): ?>
                            <div class="category">
                                <h2><?php echo $category->name ?></h2>
                                <details class="full-view">
                                    <summary>Full View</summary>
                                    <p><?php echo $category->description ?></p>
                                    <?php if($category->visibility == 1){ echo "<span class='visibility'>Hidden</span>"; }?>
                                    <?php if($category->comment == 1){ echo "<span class='comments'>Comments Disabled</span>"; }?>
                                    <?php if($category->ads == 1){ echo "<span class='ads'>Ads Disabled</span>"; }?>
                                    <div class="action">
                                        <a class="btn btn-danger" onclick="return confirm('Do You Really Want To Delete ?')" href="?do=Delete&id=<?php echo $category->id ?>">Delete</a>
                                        <a class="btn btn-success" href="?do=Edit&id=<?php echo $category->id ?>">Edit</a>
                                    </div>
                                </details>
                            </div>
                        <?php endforeach; ?>    
                    </div>
                </div>
                </div>
            <?php
            }elseif($do=="Add"){?>
                <h1 class="edit-title">Add New Category</h1> 
                <div class="container">
                    <form action="?do=Insert" method="post">
                        <div class="form-groupe">
                            <label>Name:</label>
                            <input type="text" name="name" required autocomplete="off">
                        </div>
                        <div class="form-groupe">
                            <label>Description:</label>
                            <textarea name="description"></textarea>
                        </div>
                        <div class="form-groupe">
                            <label>Ordering:</label>
                            <input type="number" name="order" min="1">
                        </div>
                        <div class="form-groupe-field">
                            <div class="form-groupe-item">
                                <fieldset>
                                    <legend>Visibility</legend>
                                    <div class="form-group-radio">
                                        <label for="vis-yes">Yes</label>
                                        <input id="vis-yes" type="radio" name="visibility" value="0" checked>
                                    </div>
                                    <div class="form-group-radio" >    
                                        <label for="vis-no">No</label>
                                        <input id="vis-no" type="radio" name="visibility" value="1">
                                    </div>
                                </fieldset>
                            </div>
                            <div class="form-groupe-item">
                                <fieldset>
                                    <legend>Allow Comments ?</legend>
                                    <div class="form-group-radio">
                                        <label for="cm-yes">Yes</label>
                                        <input id="cm-yes" type="radio" name="comments" value="0" checked>
                                    </div>
                                    <div class="form-group-radio" >    
                                        <label for="cm-no">No</label>
                                        <input id="cm-no" type="radio" name="comments" value="1">
                                    </div>
                                </fieldset>
                            </div>
                            <div class="form-groupe-item">
                                <fieldset>
                                    <legend>Allow Ads ?</legend>
                                    <div class="form-group-radio">
                                        <label for="ad-yes">Yes</label>
                                        <input id="ad-yes" type="radio" name="ads" value="0" checked>
                                    </div>
                                    <div class="form-group-radio" >    
                                        <label for="ad-no">No</label>
                                        <input id="ad-no" type="radio" name="ads" value="1">
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="form-groupe">
                            <input type="submit" value="Save" class="form-save">
                        </div>
                    </form>
                </div>
            <?php
            }elseif($do=="Insert"){

                if($_SERVER['REQUEST_METHOD'] === "POST"){
                    if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['order']) && isset($_POST['visibility']) && isset($_POST['comments']) && isset($_POST['ads'])){
                        echo "<h1 class='edit-title'>Insert Category</h1>";
                        $name = $_POST['name'];
                        $description = $_POST['description'];
                        $order = $_POST['order'];
                        $visibility = $_POST['visibility'];
                        $comments = $_POST['comments'];
                        $ads = $_POST['ads'];
                        $formErrors = array();

                        if(empty($name)){
                            array_push($formErrors,"Category Name Can Not Be Empty");
                        }
                        if(strlen($name) < 4){
                            array_push($formErrors,"Category Name Must Contain At Least 4 Characters");
                        }
                        if(empty($description)){
                            $description = "No Description is Found";
                        }
                        if(!is_numeric($order) && !empty($order)){
                            array_push($formErrors,"Order Must Be A Number");
                        }
                        if(empty($order)){
                            $order = 1;
                        }

                        if(count($formErrors) == 0){
                            if(!is_exist($con,"name",'categories',$name)){
                                $stmt = $con->prepare('INSERT INTO categories (name,description,ordering,visibility,comment,ads) VALUES(?,?,?,?,?,?)');
                                $stmt->execute(array($name,$description,$order,$visibility,$comments,$ads));
                                redirect("<div class='alert alert-success'>".$stmt->rowCount()." Record Inserted</div>",6,'back');
                            }else{
                                redirect("<div class='alert alert-danger'>Category Already Exists</div>",6,'back');
                            }
                        }else{
                            echo "<div class='container'>";
                                foreach($formErrors as $error){
                                    echo "<div class='alert alert-danger'>".$error."</div>";
                                }
                            echo "</div>";
                        }
                    }
                }else{
                redirect("<div class='alert alert-danger'>You Can\'t Browse This Page Directly</div>",6,'back');
                }

            }elseif($do=="Edit"){
                $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']):0;

                $stmt = $con->prepare('SELECT * FROM categories WHERE id=?');
                $stmt->execute(array($id));
                $caty = $stmt->fetch(PDO::FETCH_OBJ);
                if($stmt->rowCount() > 0){
                ?>
                <h1 class="edit-title">Edit Category</h1> 
                <div class="container">
                    <form action="?do=Update" method="post">
                        <input type="hidden" name="id" value="<?php echo $caty->id; ?>">
                        <div class="form-groupe">
                            <label>Name:</label>
                            <input type="text" name="name" required autocomplete="off" value="<?php echo $caty->name;?>">
                        </div>
                        <div class="form-groupe">
                            <label>Description:</label>
                            <textarea name="description"><?php echo $caty->description;?></textarea>
                        </div>
                        <div class="form-groupe">
                            <label>Ordering:</label>
                            <input type="number" name="order" min="1" value="<?php echo $caty->ordering;?>">
                        </div>
                        <div class="form-groupe-field">
                            <div class="form-groupe-item">
                                <fieldset>
                                    <legend>Visibility</legend>
                                    <div class="form-group-radio">
                                        <label for="vis-yes">Yes</label>
                                        <input id="vis-yes" type="radio" name="visibility" value="0" <?php if($caty->visibility == 0){ echo "checked";}?>>
                                    </div>
                                    <div class="form-group-radio" >    
                                        <label for="vis-no">No</label>
                                        <input id="vis-no" type="radio" name="visibility" value="1" <?php if($caty->visibility == 1){echo "checked";}?>>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="form-groupe-item">
                                <fieldset>
                                    <legend>Allow Comments ?</legend>
                                    <div class="form-group-radio">
                                        <label for="cm-yes">Yes</label>
                                        <input id="cm-yes" type="radio" name="comments" value="0" <?php if($caty->comment == 0){ echo "checked";}?>>
                                    </div>
                                    <div class="form-group-radio" >    
                                        <label for="cm-no">No</label>
                                        <input id="cm-no" type="radio" name="comments" value="1" <?php if($caty->comment == 1){ echo "checked";}?>>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="form-groupe-item">
                                <fieldset>
                                    <legend>Allow Ads ?</legend>
                                    <div class="form-group-radio">
                                        <label for="ad-yes">Yes</label>
                                        <input id="ad-yes" type="radio" name="ads" value="0" <?php if($caty->ads == 0){ echo "checked";}?>>
                                    </div>
                                    <div class="form-group-radio" >    
                                        <label for="ad-no">No</label>
                                        <input id="ad-no" type="radio" name="ads" value="1" <?php if($caty->ads == 1){ echo "checked";}?>>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="form-groupe">
                            <input type="submit" value="Save" class="form-save">
                        </div>
                    </form>
                </div>
                <?php }else{
                    redirect("<div class='alert alert-danger'>There Is No Such ID</div>",5,"back");
                }
            }elseif($do=="Update"){
                if($_SERVER['REQUEST_METHOD'] === "POST"){
                    if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['order']) && isset($_POST['visibility']) && isset($_POST['comments']) && isset($_POST['ads'])){
                        echo "<h1 class='edit-title'>Update Category</h1>";
                        $id = $_POST['id'];
                        $name = $_POST['name'];
                        $description = $_POST['description'];
                        $order = $_POST['order'];
                        $visibility = $_POST['visibility'];
                        $comments = $_POST['comments'];
                        $ads = $_POST['ads'];
                        $formErrors = array();

                        if(empty($name)){
                            array_push($formErrors,"Category Name Can Not Be Empty");
                        }
                        if(strlen($name) < 4){
                            array_push($formErrors,"Category Name Must Contain At Least 4 Characters");
                        }
                        if(empty($description)){
                            $description = "No Description is Found";
                        }
                        if(!is_numeric($order) && !empty($order)){
                            array_push($formErrors,"Order Must Be A Number");
                        }
                        if(empty($order)){
                            $order = 1;
                        }

                        if(count($formErrors) == 0){
                            if(is_exist($con,"name",'categories',$name)){
                                $stmt = $con->prepare('UPDATE categories SET name=?,description=?,ordering=?,visibility=?,comment=?,ads=? WHERE id=?');
                                $stmt->execute(array($name,$description,$order,$visibility,$comments,$ads,$id));
                                redirect("<div class='alert alert-success'>".$stmt->rowCount()." Record Updated</div>",6,'back');
                            }else{
                                redirect("<div class='alert alert-danger'>Category Does Not Exist</div>",6,'back');
                            }
                        }else{
                            echo "<div class='container'>";
                                foreach($formErrors as $error){
                                    echo "<div class='alert alert-danger'>".$error."</div>";
                                }
                            echo "</div>";
                        }
                    }
                }else{
                redirect("<div class='alert alert-danger'>You Can\'t Browse This Page Directly</div>",6,'back');
                }
            }elseif($do=="Delete"){
                $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']):0;
                if(is_exist($con,'id','categories',$id)){
                    $stmt = $con->prepare('DELETE FROM categories WHERE id=?');
                    $stmt->execute(array($id));
                    redirect("<div class='alert alert-success'>".$stmt->rowCount()." Record Deleted</div>",6,'back');
                }else{
                    redirect("<div class='alert alert-danger'>There Is No Such Category With This Name</div>",6,"back");
                }
            }else{
                redirect("<div class='alert alert-danger'>There Is No Such Page With This Name</div>",6,"back");
            }
        include $template."footer.php";
    }else{
        header('Location:index.php');
        exit();
    }
    ob_end_flush();?>
<script src="layout/js/edit.js"></script>