<?php
if (!defined('included')) {
  die('Direct access not permitted');
}
?>
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <title>Ghoomo.com</title>

  <?php
  scriptInclude("jquery.min.js");
  scriptInclude("jquery-ui.min.js");
  scriptInclude("semantic.min.js");
  scriptInclude("tablesort.min.js");

  stylesheetInclude("jquery-ui.min.css");
  stylesheetInclude("semantic.min.css");

stylesheetInclude("style.css");

  ?>

}

</head>
<body>

  <header>





    <div class="ui inverted fixed menu clear">
      <div class="ui container">
        <a href="<?php echo HOMEPAGE_URL; ?>" class="header item">
          <img class="logo" alt="logo" src="<?php echo LAYOUT_IMAGES_URL; ?>/yatra.png" />
          Ghoomo.com
        </a>


        <div class="item right aligned">
          <?php

          $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

          if (is_logged_in()) {
            $user_email = $_SESSION['email'];

            $stmt = $pdo->prepare('SELECT fname FROM user WHERE email = :email');
            $stmt->execute(['email' => $user_email]);
            $user_name = $stmt->fetchColumn();

            ?>

            <div class="ui simple dropdown item">
              Hi <?php echo $user_name; ?> <i class="dropdown icon"></i>
              <div class="menu">
                <a class="item" href="/mybookings.php">My Bookings</a>
                <a class="item" href="/profile.php">My Profile</a>

                <a class="item" href="/logout.php">LogOut</a>

              </div>
            </div>
            <?php } else {
              if (isset($_SESSION['validated']) && $_SESSION['validated'] == false) {
                echo "Wrong email/password";
                unset($_SESSION['validated']);
              }
              ?>

              <form action="/login.php" method="post" class="ui form">
                <div class="fields">

                  <div class="field">
                    <input type="text" name="email" placeholder="Email" required>
                  </div>
                  <div class="field">
                    <input type="password" name="password" placeholder="Password" required>
                  </div>
                  <input type="hidden" name="redirect" value="<?php echo $actual_link; ?>">
        <div class="ui submit button">Sign In</div>



                </div>

      <div class="ui error message"></div>

              </form>
              <div class="ui button"><a href="/login.php">Sign Up</a></div>












              <?php }?>


            </div>



          </div>
        </div>





      </header>

      <div id="main-content" class="ui main container">




