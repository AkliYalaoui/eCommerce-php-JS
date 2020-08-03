<?php
    session_start();
    $pageTitle="New Ad";
    include 'init.php';

    if(isset($_SESSION['user'])){
        //all countries
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Palestine","Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Zambia", "Zimbabwe");
        //all status
        $status = array(
            "1" => "New",
            "2" => "Like New",
            "3" => "Used",
            "4" => "Very Old",

        );
        //select all categories
        $stmt = $con->prepare("SELECT id,name from categories");
        $stmt->execute();
        $categories  = $stmt->fetchAll(PDO::FETCH_OBJ);
        if($_SERVER['REQUEST_METHOD']== "POST"){
            if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['country']) && isset($_POST['status']) && isset($_POST['categories'])){
                $name        = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
                $description = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
                $price       = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
                $category    = filter_var($_POST['categories'],FILTER_SANITIZE_STRING);
                $countri     = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
                $status      = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
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
                if($category == 0){
                    array_push($formErrors,"You Must Select A Category");
                }
                if($countri == "0"){
                    array_push($formErrors,"$countri You Must Select A Country");
                }
                if($status == 0){
                    array_push($formErrors,"You Must Select The Status Of The Item");
                }
                if(count($formErrors) == 0){
                    //get user id
                    $stmt = $con->prepare('SELECT userid FROM users WHERE username =?');
                    $stmt->execute(array($_SESSION['user']));
                    $user =$stmt->fetch(PDO::FETCH_OBJ)->userid;
                    //insert item
                    $stmt = $con->prepare("INSERT INTO items (name,description,price,country,status,categoryid,userid) VALUES(?,?,?,?,?,?,?)");
                    $stmt->execute(array($name,$description,$price,$countri,$status,$category,$user));
                    echo "<div class='alert alert-success'>Item Added</div>";
                }else{
                    echo "<div class='container'>";
                        foreach($formErrors as $error){
                            echo "<div class='alert alert-danger'>".$error."</div>";
                        }
                    echo "</div>";
                }
            }
        }
?>
    <h1 class="edit-title">Create New Ad</h1>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Add New Ad</div>
            <div class="panel-body panel-float">
            <form class="live-preview" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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
                            <label>Category:</label>
                            <select name="categories">
                                <option value="0">...</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
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
                            <input type="submit" value="Add" class="form-save">
                        </div>
                    </form>
                <div class="card live-preview">
                    <div class="card-header">
                        <img src="avatar.png" alt="image">
                            <div class="card-overlay">$<span>price</span></div>
                    </div>
                    <div class="card-body">
                            <h3>Title</h3>
                            <p>Description</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    }else{
        header('Location:login.php');
        exit();
    }
    include $template."footer.php";