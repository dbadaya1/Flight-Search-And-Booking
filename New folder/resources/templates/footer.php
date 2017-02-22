<?php
if (!defined('included')) {
    die('Direct access not permitted');
}
?>
</div> 
<footer>
 <div class="ui inverted vertical footer segment">
    <div class="ui center aligned container">
  
      <img src="<?php echo LAYOUT_IMAGES_URL; ?>/yatra.png" class="ui centered mini image" alt="">
      <div class="ui horizontal inverted small divided link list">
        <a class="item" href="#">Site Map</a>
        <a class="item" href="#">Contact Us</a>
        <a class="item" href="#">Terms and Conditions</a>
        <a class="item" href="#">Privacy Policy</a>
      </div>
    </div>
  </div>

</footer>











<?php
signin_signup_form();
scriptInclude("js.js");
?>
</body>
</html>