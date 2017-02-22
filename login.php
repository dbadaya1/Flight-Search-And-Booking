<?php
require_once "config.php";
if(is_logged_in())
  header('Location: '.HOMEPAGE_URL);

require_once TEMPLATES_DIR . "/header.php";
?>

<?php


if(isset($_GET['wrong']) && $_GET['wrong'] == 1) { ?>
   <div class="ui warning message">
  <div class="header">
    Wrong Email or Password  </div>
  </div>
<?php }

if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['cpassword']) && !empty($_POST['fname']) && isset($_POST['mname']) && !empty($_POST['lname']) && !empty($_POST['sex']) && !empty($_POST['terms'])) {


  $email = $_POST['email'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];

  $fname = $_POST['fname'];
  $mname = $_POST['mname'];
  $lname = $_POST['lname'];
  $address = $_POST['address'];
$sex = $_POST['sex'];
  if($password != $cpassword) {
    echo "Passwords don't match";
    die();
  }
  $password_hash = md5($password);
  $sql = "INSERT INTO user(password_hash,fname,mname,lname,sex,address,email)
  VALUES ('$password_hash','$fname','$mname','$lname','$sex','$address','$email')";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $user_id = $pdo->lastInsertId('id');

  echo "<div class='ui segment'>Congrulations, your account has been created. Please log in to continue.</div>";

}





else if(!empty($_POST['email']) && !empty($_POST['password'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare('SELECT password_hash,id FROM user WHERE email = :email');
  $stmt->execute(['email' => $email]);
  $user_data = $stmt->fetchAll();
  if(count($user_data) == 1 && $user_data[0]['password_hash'] == md5($password)) {
    $_SESSION['validated'] = true;
    $_SESSION['email'] = $email;
    $_SESSION['user_id'] = $user_data[0]['id'];

  }
  else {
    $_SESSION['validated'] = false;

  }


  $redirect_to = $_POST['redirect'];
  header("Location: $redirect_to");

}
else { ?>

<style>
 body {
      background-color: #DADADA;
    }
  </style>

<div class="ui middle aligned center aligned grid signin-form">
  <div class="column six wide">
    <h2 class="ui teal header">
      <div class="content">
        Log-in to your account
      </div>
    </h2>
    <form action="<?=HOMEPAGE_URL;?>/login" method="post" class="ui form large">
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="email" placeholder="E-mail address">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password">
          </div>
        </div>
        <input type="hidden" name="redirect" value="<?php echo HOMEPAGE_URL."/login?wrong=1"; ?>">
        <div class="ui fluid large teal submit button">Sign In</div>
      </div>

      <div class="ui error message"></div>

    </form>

    <div class="ui message signup_button">
      New to us? <a href="#">Sign Up</a>
    </div>
  </div>
</div>











<div class="ui middle aligned center aligned grid signup-form">
  <div class="column ten wide">
    <h2 class="ui teal header">
        Sign Up for your account
    </h2>
      <form action="<?=HOMEPAGE_URL;?>/login" method="POST" class="ui form">
            <div class="ui stacked segment">

        <div class="three fields">
          <div class="field">
            <label> First Name </label>
            <div class="ui left labeled icon input">
              <input id="fname" placeholder="First Name" type="text" name="fname">
              <i class="user icon"></i>

            </div>
          </div>

          <div class="field">
            <label> Middle Name </label>
            <div class="ui left labeled icon input">
              <input id="mname" placeholder="Middle Name" type="text" name="mname">
              <i class="user icon"></i>

            </div>
          </div>

          <div class="field">
            <label> Last Name </label>
            <div class="ui left labeled icon input">
              <input id="lname" placeholder="Last Name" type="text" name="lname">
              <i class="user icon"></i>

            </div>
          </div>

        </div>

        <div class="field">
          <label> Email </label>
          <div class="ui left labeled icon input">
            <input id="email" placeholder="Email" type="text" name="email">
            <i class="mail icon"></i>

          </div>
        </div>

<div class="inline fields">
    <label for="fruit">Sex</label>
    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="sex" value="M">
        <label>Male</label>
      </div>
    </div>
    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="sex" value="F">
        <label>Female</label>
      </div>
    </div>
    
  </div>





        <div class="two fields">
          <div class="field">
            <label> Password </label>
            <div class="ui left labeled icon input">
              <input id="password" placeholder="Password" type="password" name="password">
              <i class="lock icon"></i>

            </div>
          </div>
          <div class="field">
            <label> Confirm Password </label>
            <div class="ui left labeled icon input">
              <input id="confirm-password" placeholder="Confirm Password" type="password" name="cpassword">
              <i class="lock icon"></i>

            </div>
          </div>
        </div>

        <div class="field">
          <label> Address</label>
          <div class="ui left labeled icon input">
            <textarea id="address" placeholder="Address" type="textarea" name="address"></textarea>
            <i class="email icon"></i>

          </div>
        </div>
        <div class="inline field">
          <div class="ui checkbox">
            <input id="terms" type="checkbox" name="terms">
            <label for="terms"> I agree to the <a href="#"> Terms and Conditions </a></label>
          </div>
        </div>
        <div class="ui fluid large teal submit button">Sign Up</div>
</div>
        <div class="ui error message"></div>
      </form>
   <div class="ui message signin_button">
      Already have an account ? <a href="#">Sign In</a>
    </div>
  </div>
</div>
<?php } ?>


<?php

require_once TEMPLATES_DIR . "/footer.php";

?>