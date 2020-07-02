<header>
  <div id="app-nav">
     <nav class="nav-bar">
        <div class="nav-brand">
            <a href="#"><?php echo lang('home'); ?></a>
            <span v-on:click="showmenu" 
                 class="fa fa-bars active">
            </span>
        </div>
            <ul class="nav-list" ref="menu_barA">
                <li><a href="#"><?php echo lang('catergorie'); ?></a></li>
                <li><a href="#"><?php echo lang('items'); ?></a></li>
                <li><a href="#"><?php echo lang('members'); ?></a></li>
                <li><a href="#"><?php echo lang('statistics'); ?></a></li>
                <li><a href="#"><?php echo lang('logs'); ?></a></li>
            </ul>
            <div class="sub-nav"  ref="menu_barB">
                <h4 v-on:click="showHide" class="nav-title">
                    <?php echo $_SESSION['username'];?><span></span>
                </h4>
                <ul ref="ulSlide">
                    <li><a href="#"><?php echo lang('editprofile'); ?></a></li>
                    <li><a href="#"><?php echo lang('setting'); ?></a></li>
                    <li><a href="#"><?php echo lang('logout'); ?></a></li>
                </ul> 
            </div>
    </nav>  
  </div>    
</header>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="<?php echo $js ; ?>nav.js"></script>