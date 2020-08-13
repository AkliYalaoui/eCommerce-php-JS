<?php
    ob_start();
    session_start();
    if(isset($_SESSION['username'])){
        $pageTitle = "Items";
        include "init.php";
        //all countries
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Palestine","Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Zambia", "Zimbabwe");
        //all status
        $status = array(
            "1" => "New",
            "2" => "Like New",
            "3" => "Used",
            "4" => "Very Old",

        );
        //select all users
        $stmt = $con->prepare("SELECT userid,username from users");
        $stmt->execute();
        $users  = $stmt->fetchAll(PDO::FETCH_OBJ);
        //select all categories
        $stmt = $con->prepare("SELECT id,name from categories WHERE parent=0");
        $stmt->execute();
        $categories  = $stmt->fetchAll(PDO::FETCH_OBJ);
        //select All Items
        $stmt = $con->prepare("SELECT items.*,users.username,categories.name AS cat_name FROM items
                                INNER JOIN categories ON categories.id = items.categoryid
                                INNER JOIN users ON users.userid = items.userid");
        $stmt->execute();
        $items  = $stmt->fetchAll(PDO::FETCH_OBJ);
        $do = isset($_GET['do']) ? $_GET['do']:"Manage";

        if($do=="Manage"){?>
            <h1 class="edit-title">Manage Items</h1>
            <div class="container table-container">
                <a class="btn-primary" href="?do=Add"><span><i class="fa fa-plus"></i></span> New Items</a>
                <table class="table">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>name</td>
                            <td>description</td>
                            <td>price</td>
                            <td>Added Date</td>
                            <td>Country Made</td>
                            <td>status</td>
                            <td>Category</td>
                            <td>user</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($items as $item): ?>
                            <tr>
                                <td><?php echo $item->itemid ?></td>
                                <td><?php echo $item->name ?></td>
                                <td><?php echo $item->description ?></td>
                                <td><?php echo $item->price ?></td>
                                <td><?php echo $item->date ?></td>
                                <td><?php echo $item->country ?></td>
                                <td><?php echo $status[$item->status]; ?></td>
                                <td><?php echo $item->cat_name ?></td>
                                <td><?php echo $item->username ?></td>
                                <td>
                                    <a class="dp-inherit btn-night" href="comments.php?do=ItemsComment&id=<?php echo $item->itemid ?>">All Comments</a>
                                    <a class="btn btn-danger dp-inherit"  onclick="return confirm('Do You Really Want To Delete ?')" href="?do=Delete&id=<?php echo $item->itemid ?>">Delete</a>
                                    <a  class="btn btn-success dp-inherit" href="?do=Edit&id=<?php echo $item->itemid ?>">Edit</a>
                                    <?php if($item->approuve == 0): ?>
                                        <a  class="btn btn-purple dp-inherit" href="?do=Approuve&id=<?php echo $item->itemid ?>">Approuve</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php
        }elseif($do == "Add"){?>
        <h1 class="edit-title">Add New Item</h1>
                <div class="container">
                    <form action="?do=Insert" method="post" enctype="multipart/form-data">
                        <div class="form-groupe">
                            <label>Name:</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-groupe">
                            <label>Description:</label>
                            <input type="text" name="description" required></input>
                        </div>
                        <div class="form-groupe">
                            <label>Price:</label>
                            <input type="text" name="price" required>
                        </div>
                        <div class="form-groupe">
                            <label>Tags:</label>
                            <input type="text" name="tags" placeholder="Separate Tags With Comas">
                        </div>
                        <div class="form-groupe">
                            <label>User:</label>
                            <select name="user">
                                <option value="0">...</option>
                                <?php foreach($users as $user): ?>
                                    <option value="<?php echo $user->userid; ?>"><?php echo $user->username; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- start Profile Image field -->
                        <div class="form-groupe">
                            <label>Item Image : </label>
                            <input type="file" name="avatar" required>
                        </div>
                        <div class="form-groupe">
                            <label>Category:</label>
                            <select name="categories">
                                <option value="0">...</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                    <?php
                                        $stmt = $con->prepare("SELECT id,name from categories WHERE parent=$category->id");
                                        $stmt->execute();
                                        $subcategories  = $stmt->fetchAll(PDO::FETCH_OBJ);
                                        if($stmt->rowCount()>0):
                                            echo "<optgroup label='{$category->name} Children'>";
                                        foreach($subcategories as $sub):
                                    ?>
                                    <option value="<?php echo $sub->id; ?>"><?php echo $sub->name; ?></option>
                                    <?php endforeach;
                                            echo "</optgroup>";
                                            endif;?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-groupe">
                            <label>Country:</label>
                            <select name="country">
                                <option value="0">...</option>
                                <?php foreach($countries as $country): ?>
                                    <option value="<?php echo $country ?>"><?php echo $country ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-groupe">
                            <label>Status:</label>
                            <select name="status">
                                <option value="0">...</option>
                                <?php foreach($status as $st => $value): ?>
                                    <option value="<?php echo $st ?>"><?php echo $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-groupe">
                            <input type="submit" value="Save" class="form-save">
                        </div>
                    </form>
                </div>
        <?php
        }elseif($do == "Insert"){
            if($_SERVER['REQUEST_METHOD'] === "POST"){
                echo "<h1 class='edit-title'>Insert Item</h1>";
                if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['country']) && isset($_POST['status']) && isset($_POST['user']) && isset($_POST['categories']) && isset($_POST['tags'])){
                    $name = $_POST['name'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $user = $_POST['user'];
                    $category = $_POST['categories'];
                    $countri= $_POST['country'];
                    $status = $_POST['status'];
                    $tags = $_POST['tags'];
                    $avatar =$_FILES['avatar'];
                    //validate The Form
                    $formErrors = array();
                    if(empty($name)){
                        array_push($formErrors,"Item Name Can Not Be Emtpy");
                    }
                    if(empty($description)){
                        array_push($formErrors,"Item Description Can Not Be Emtpy");
                    }
                    if(empty($price)){
                        array_push($formErrors,"Item Price Can Not Be Emtpy");
                    }
                    if($user == 0){
                        array_push($formErrors,"You Must Select A User");
                    }
                    if($categories == 0){
                        array_push($formErrors,"You Must Select A Category");
                    }
                    if($countri === "0"){
                        array_push($formErrors,"You Must Select A Country");
                    }
                    if($status == 0){
                        array_push($formErrors,"You Must Select The Status Of The Item");
                    }
                    if(empty($avatar['name'])){
                        array_push($formErrors,'<div class="alert alert-danger">Avatar Is Required</div>');
                    }

                if(count($formErrors) == 0){
                     //deal with the avatar
                        $img_extension =  array('png','jpeg','jpg',"gif");
                        $avatarExploded = explode('.',$avatar['name']);
                        $avatarExtension = strtolower(array_pop($avatarExploded));

                        if(in_array($avatarExtension,$img_extension)){
                            if($avatar['size'] <= pow(2,22)){
                                if($avatar['error'] == 0){
                                    $profilePic = uniqid($name ,true).".".$avatarExtension;
                                    move_uploaded_file($avatar['tmp_name'],'data/uploads/'.$profilePic);
                                }else{
                                    array_push($formErrors,'<div class="alert alert-danger">Sorry...Something Went Wrong!</div>');
                                }
                            }else{
                                array_push($formErrors,'<div class="alert alert-danger">Avatar Size Can Not Be Less Than 4MB</div>');
                            }
                        }else{
                            array_push($formErrors,'<div class="alert alert-danger">Please,Upload The Right Image</div>');
                        }
                }
                    if(count($formErrors) == 0){
                        $user = intval($user);
                        $category = intval($category);
                        $stmt = $con->prepare("INSERT INTO items (name,description,price,country,status,categoryid,userid,tags,img) VALUES(?,?,?,?,?,?,?,?,?)");
                        $stmt->execute(array($name,$description,$price,$countri,$status,$category,$user,$tags,$profilePic));
                        redirect("<div class='alert alert-success'>".$stmt->rowCount()." Record Inserted</div>",4,'back');
                    }else{
                        echo "<div class='container'>";
                            foreach($formErrors as $error){
                                echo "<div class='alert alert-danger'>".$error."</div>";
                            }
                        echo "</div>";
                    }
                }

            }else{
                redirect("<div class='alert alert-danger'>You Can't Access This Page Directly</div>");
            }

        }elseif($do == "Edit"){
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id']:0;
            $stmt = $con->prepare("SELECT * FROM items WHERE itemid = ?");
            $stmt->execute(array($id));
            $item = $stmt->fetch(PDO::FETCH_OBJ);
            if($stmt->rowCount() > 0){
            ?>
                <h1 class="edit-title">Edit Item</h1>
                <div class="container">
                    <form action="?do=Update" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="itemid" value="<?php echo $item->itemid ?>">
                        <div class="form-groupe">
                            <label>Name:</label>
                            <input type="text" name="name" required value="<?php echo $item->name ?>">
                        </div>
                        <div class="form-groupe">
                            <label>Description:</label>
                            <input type="text" name="description" required value="<?php echo $item->description ?>"></input>
                        </div>
                        <div class="form-groupe">
                            <label>Price:</label>
                            <input type="text" name="price" required value="<?php echo $item->price?>">
                        </div>
                        <div class="form-groupe">
                            <label>Tags:</label>
                            <input type="text" name="tags" value="<?php echo $item->tags?>">
                        </div>
                        <div class="form-groupe">
                            <label>User:</label>
                            <select name="user">
                                <?php foreach($users as $user): ?>
                                    <option value="<?php echo $user->userid; ?>" <?php if($user->userid == $item->userid){ echo "selected";} ?>><?php echo $user->username; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- start Profile Image field -->
                        <div class="form-groupe">
                            <label>Item Image : </label>
                            <input type="file" name="avatar">
                            <input type="hidden" name="oldAvatar" value="<?php echo $item->img ?>">
                        </div>
                        <div class="form-groupe">
                            <label>Category:</label>
                            <select name="categories">
                                <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category->id; ?>" <?php if($category->id == $item->categoryid){ echo "selected";} ?>><?php echo $category->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-groupe">
                            <label>Country:</label>
                            <select name="country">
                                <?php foreach($countries as $country): ?>
                                    <option value="<?php echo $country ?>" <?php if($country == $item->country){ echo "selected";} ?> ><?php echo $country ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-groupe">
                            <label>Status:</label>
                            <select name="status">
                                <?php foreach($status as $st => $value): ?>
                                    <option value="<?php echo $st ?>" <?php if($st == $item->status){ echo "selected";} ?>><?php echo $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-groupe">
                            <input type="submit" value="Save" class="form-save">
                        </div>
                    </form>
                </div>
        <?php }else{
            redirect("<div class='alert alert-danger'>There Is No Such Item</div>");
        }
        }elseif($do == "Update"){
            if($_SERVER['REQUEST_METHOD'] === "POST"){
                echo "<h1 class='edit-title'>Update Item</h1>";
                if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['country']) && isset($_POST['status']) && isset($_POST['user']) && isset($_POST['categories']) && isset($_POST['tags'])){
                    $name = $_POST['name'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $user = $_POST['user'];
                    $category = $_POST['categories'];
                    $countri= $_POST['country'];
                    $status = $_POST['status'];
                    $id=$_POST['itemid'];
                    $tags=$_POST['tags'];
                    $avatar = isset($_FILES['avatar']) ? $_FILES['avatar']: null;
                    $oldAvatar = $_POST['oldAvatar'];
                    //validate The Form
                    $formErrors = array();
                    if(empty($name)){
                        array_push($formErrors,"Item Name Can Not Be Emtpy");
                    }
                    if(empty($description)){
                        array_push($formErrors,"Item Description Can Not Be Emtpy");
                    }
                    if(empty($price)){
                        array_push($formErrors,"Item Price Can Not Be Emtpy");
                    }
                  $profilePic  = $oldAvatar;

                if(count($formErrors) == 0  && $avatar !== null && !empty($avatar['name'])){
                     //deal with the avatar
                        $img_extension =  array('png','jpeg','jpg',"gif");
                        $avatarExploded = explode('.',$avatar['name']);
                        $avatarExtension = strtolower(array_pop($avatarExploded));

                        if(in_array($avatarExtension,$img_extension)){
                            if($avatar['size'] <= pow(2,22)){
                                if($avatar['error'] == 0){
                                    $profilePic = uniqid($name ,true).".".$avatarExtension;
                                    move_uploaded_file($avatar['tmp_name'],'../data/uploads/'.$profilePic);
                                }else{
                                    array_push($formErrors,'<div class="alert alert-danger">Sorry...Something Went Wrong!</div>');
                                }
                            }else{
                                array_push($formErrors,'<div class="alert alert-danger">Avatar Size Can Not Be Less Than 4MB</div>');
                            }
                        }else{
                            array_push($formErrors,'<div class="alert alert-danger">Please,Upload The Right Image</div>');
                        }
                }
                    if(count($formErrors) == 0){
                        if(is_exist($con,"itemid","items",$id)){
                            $user = intval($user);
                            $category = intval($category);
                            $stmt = $con->prepare("UPDATE items SET name=?,description=?,price=?,country=?,status=?,categoryid=?,userid=?,tags=?,img=? WHERE itemid=?");
                            $stmt->execute(array($name,$description,$price,$countri,$status,$category,$user,$tags,$profilePic,$id));
                            redirect("<div class='alert alert-success'>".$stmt->rowCount()." Record Updated</div>",4,'back');
                        }else{
                            redirect("<div class='alert alert-danger'>There Is No Such Item</div>",5,'back');
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
                redirect("<div class='alert alert-danger'>You Can't Access This Page Directly</div>");
            }

        }elseif($do == "Delete"){
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id']:0;
            echo "<h1 class='edit-title'>Delete Item</h1>";
            if(is_exist($con,'itemid','items',$id)){
                $stmt = $con->prepare("DELETE FROM items WHERE itemid=?");
                $stmt->execute(array($id));
                redirect("<div class='alert alert-success'>Item Deleted Successfully</div>",5,'back');
            }else{
                redirect("<div class='alert alert-danger'>There Is No Such Item</div>",5,'back');
            }

        }elseif($do == "Approuve"){
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id']:0;
            echo "<h1 class='edit-title'>Approuve Item</h1>";
            if(is_exist($con,'itemid','items',$id)){
                $stmt = $con->prepare("UPDATE items SET approuve=1 WHERE itemid=?");
                $stmt->execute(array($id));
                redirect("<div class='alert alert-success'>Item Approuved Successfully</div>",5,'back');
            }else{
                redirect("<div class='alert alert-danger'>There Is No Such Item</div>",5,'back');
            }
        }else{
            redirect("<div class='alert alert-danger'>There Is No Such Page With This Name</div>");
        }
        include $template."footer.php";
    }else{
        header('Location: index.php');
        exit();
    }
    ob_end_flush();
?>
<script src="layout/js/edit.js"></script>
