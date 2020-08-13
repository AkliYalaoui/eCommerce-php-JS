<?php  session_start();
       $pageTitle = "Home";
       include 'init.php';
       $items = getItems(1,"approuve");
       echo "<div class='img-banner'><img src='banner.webp'/></div>";
       echo "<div class='container card-container'>";
       if(!empty($items)){
       foreach($items as $item):?>
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
              redirect("<div class='alert alert-danger'>There Are No Items</div>",5,'back');
              }
       echo "</div>";
       include $template . "footer.php";
