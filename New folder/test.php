<?php
require_once "config.php";
require_once TEMPLATES_DIR . "/header.php";
?>





<div class="ui ordered steps">
  <div class="completed step">
    <div class="content">
      <div class="title">Shipping</div>
      <div class="description">Choose your shipping options</div>
    </div>
  </div>
  <div class="completed step">
    <div class="content">
      <div class="title">Billing</div>
      <div class="description">Enter billing information</div>
    </div>
  </div>
  <div class="active step">
    <div class="content">
      <div class="title">Confirm Order</div>
      <div class="description">Verify order details</div>
    </div>
  </div>
</div>



<?php

require_once TEMPLATES_DIR . "/footer.php";

?>