<footer class="contact-footer">
  <div class="container">
      <div class="left">
          <h4>Contact Us :</h4>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt , sed do eiusmod tempor incididunt.
          </p>
          <address>
<pre>
  Algeria,Bejaia
  Mars Rue 2292
  Post 66666
</pre>
          </address>
          <div id='map'></div>
      </div>
      <div class="right">
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <div class="form-groupe">
                <label>Email : </label>
                <input type="email" name="email" required placeholder="Please Enter A Valid Email">
            </div>

            <div class="form-groupe">
              <label>Subject : </label>
              <input type="text" name="sunject" required placeholder="Subject Of The Message">
            </div>
            <div class="form-groupe">
              <label>Message : </label>
              <textarea name="message" rows="6" required placeholder="Type Your Message Here ..."></textarea>
            </div>
            <div class="form-groupe">
                <input type="submit" name="contact" value="Send" class="form-save-success">
            </div>
        </form>
      </div>
  </div>
 <script type="text/javascript">
    function initMap() {
        var location = {
          lat:36.75587,
          lng:5.08433
        };
        var map = new google.maps.Map(document.getElementById('map'),{
          zoom:15,
          center : location
        });
        var marker = new google.maps.Marker({
          position : location,
          map : map
        });
    }
 </script>
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_Bk9hZv6bbXXZNzqfs8VANy8sAWFaIh0&callback=initMap"
type="text/javascript"></script>
</footer>
<script src="<?php echo $js ; ?>nav.js"></script>
<script src="<?php echo $js ; ?>login.js"></script>
<script src="<?php echo $js ; ?>edit.js"></script>
</body>
</html>
