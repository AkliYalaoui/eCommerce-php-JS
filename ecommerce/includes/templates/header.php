<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title><?php getTitle(); ?></title>
    <link rel="stylesheet" href="<?php echo $css ; ?>style.css" />
    <link rel="stylesheet" href="<?php echo $css ; ?>all.css" />
<body>
<div class="upper-bar">
    <div class="container">
        <?php if(!isset($_SESSION['user'])){ ?>
                <a class="btn-primary" href="login.php">Login/signup</a>
        <?php }else{?>
                <div class="dropdown">
                    <a href="profile.php">
                      <img src="<?php echo !empty($_SESSION['avatar-user']) ? 'data/uploads/'.$_SESSION['avatar-user'] : "avatar.png" ;?>" alt="image">
                    </a>
                    <button id="dropdown"><?php echo $_SESSION['user']; ?></button>
                    <ul>
                        <li><a href='profile.php'>My Profile</a></li>
                        <li><a href="ads.php">New Item</a></li>
                        <li><a href="profile.php#my-items">My Items</a></li>
                        <li><a href="profile.php#my-comments">My Comments</a></li>
                        <li><a href='logout.php'>Logout</a></li>
                    </ul>
                </div>
                <?php } ?>
</div>
    </div>
<header>
    <nav class="nav-bar nav-right">
        <div class="nav-brand nav-right">
            <a href="index.php"><?php echo lang('home'); ?></a>
            <span id="menu"
                class="fa fa-bars active">
            </span>
        </div>
            <ul class="nav-list nav-right" id="menuBarOne">
                <?php $categories = getAll('categories','id','WHERE parent=0',"ASC");
                    foreach($categories as $category): ?>
                    <li><a href="categories.php?id=<?php echo $category->id; ?>&name=<?php echo str_replace(" ","-",$category->name); ?>"><?php echo $category->name; ?></a></li>
                <?php endforeach; ?>
            </ul>
    </nav>
</header>
