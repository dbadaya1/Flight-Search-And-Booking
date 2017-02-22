<?php
require_once("config.php");
require_once(TEMPLATES_DIR."/header.php");
 ?>
 <div class="ui main container">
    <h1 class="ui header">Search Your Flights</h1>
     <?php flight_search(); ?>

  </div>





<?php

require_once(TEMPLATES_DIR."/footer.php");
?>

