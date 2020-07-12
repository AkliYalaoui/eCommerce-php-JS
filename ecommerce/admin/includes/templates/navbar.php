<header>
     <nav class="nav-bar">
        <div class="nav-brand">
            <a href="#"><?php echo lang('home'); ?></a>
            <span id="menu"
                 class="fa fa-bars active">
            </span>
        </div>
            <ul class="nav-list" id="menuBarOne">
                <li><a href="#"><?php echo lang('catergorie'); ?></a></li>
                <li><a href="#"><?php echo lang('items'); ?></a></li>
                <li><a href="#"><?php echo lang('members'); ?></a></li>
                <li><a href="#"><?php echo lang('statistics'); ?></a></li>
                <li><a href="#"><?php echo lang('logs'); ?></a></li>
            </ul>
            <div class="sub-nav"  id="menuBarTwo">
                <h4 id="subNav" class="nav-title">
                    <?php echo $_SESSION['username'];?><span></span>
                </h4>
                <ul id="ulSlide">
                    <li><a href="members.php?do=Edit&id=<?php echo  $_SESSION['id'];?>"><?php echo lang('editprofile'); ?></a></li>
                    <li><a href="#"><?php echo lang('setting'); ?></a></li>
                    <li><a href="logout.php"><?php echo lang('logout'); ?></a></li>
                </ul> 
            </div>
    </nav> 
    <script src="<?php echo $js ; ?>nav.js"></script>  
</header>