<?php
    ob_start();
    session_start();
    if(isset($_SESSION['username'])){
        $pageTitle = "Items";
        include "init.php";
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Zambia", "Zimbabwe");
        $do = isset($_GET['do']) ? $_GET['do']:"Manage";

        if($do=="Manage"){?>
            <h1 class="edit-title">Manage Items</h1>
            <div class="container">
                <a href="?do=Add">New Items</a>
            </div>
        <?php    
        }elseif($do == "Add"){?>
        <h1 class="edit-title">Add New Item</h1> 
                <div class="container">
                    <form action="?do=Insert" method="post">
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
                            <input type="number" name="price" min="1" required>
                        </div>
                        <div class="form-groupe">
                            <label>Country:</label>
                            <select name="country">
                                <?php foreach($countries as $country): ?>
                                    <option value="<?php echo $country ?>"><?php echo $country ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-groupe">
                            <label>Status:</label>
                            <select name="status">
                                <option value="0">...</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Very Old</option>
                            </select>
                        </div>
                        <div class="form-groupe">
                            <input type="submit" value="Save" class="form-save">
                        </div>
                    </form>
                </div>
        <?php
        }elseif($do == "Insert"){

        }elseif($do == "Edit"){

        }elseif($do == "Update"){

        }elseif($do == "Delete"){

        }elseif($do == "Approuve"){

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