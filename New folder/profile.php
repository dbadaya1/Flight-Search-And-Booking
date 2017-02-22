<?php
require_once("config.php");
if(!is_logged_in())
	header('Location: '.HOMEPAGE_URL);
require_once(TEMPLATES_DIR."/header.php");
 ?>

<?php 

$stmt = $pdo->prepare('SELECT * FROM user WHERE id = :user_id');
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $user = $stmt->fetch();


if(!empty($_POST['update']) &&!empty($_POST['email']) && !empty($_POST['fname']) && !empty($_POST['lname'])  ) {


  $email = $_POST['email'];
  
  $fname = $_POST['fname'];
  $mname = $_POST['mname'];
  $lname = $_POST['lname'];
  $address = $_POST['address'];
$password_hash = "";
if(!empty($_POST['password']) && !empty($_POST['cpassword']) && !empty($_POST['oldpassword'])) {
	$password = $_POST['password'];
  	$cpassword = $_POST['cpassword'];
	$oldpassword = $_POST['oldpassword'];
  if(md5($oldpassword) == $user['password_hash'] || $password == $cpassword) {
  	  $password_hash = md5($password);
  }	
  else {
  	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	header('Location: '.$actual_link.'?error=1');
    die();
  }
}

else {
	  $password_hash = $user['password_hash'];
}
  $sql = "UPDATE user SET password_hash='$password_hash',fname='$fname',mname='$mname',lname='$lname',address='$address',email='$email' WHERE id={$user['id']}";
  echo $sql;
    $stmt = $pdo->prepare($sql);
  $stmt->execute();

	header('Location: '.$actual_link);


}

else if(!empty($_GET['error']) && $_GET['error'] == 1) { ?>

<div class="ui negative message">
  <div class="header">
Passwords don't match up.  </div>
  <p>Please try again.
</p></div>

<?php } ?>









<div class="ui container grid">
  <div class="column ten wide">
    <h2 class="ui teal header">
        Edit Your Account Details
    </h2>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="ui form">
            <div class="ui stacked segment">

        <div class="three fields">
          <div class="field">
            <label> First Name </label>
            <div class="ui left labeled icon input">
              <input id="fname" placeholder="First Name" type="text" name="fname" value="<?php echo $user['fname']; ?>">
              <i class="user icon"></i>

            </div>
          </div>

          <div class="field">
            <label> Middle Name </label>
            <div class="ui left labeled icon input">
              <input id="mname" placeholder="Middle Name" type="text" name="mname" value="<?php echo $user['mname']; ?>">
              <i class="user icon"></i>

            </div>
          </div>

          <div class="field">
            <label> Last Name </label>
            <div class="ui left labeled icon input">
              <input id="lname" placeholder="Last Name" type="text" name="lname" value="<?php echo $user['lname']; ?>">
              <i class="user icon"></i>

            </div>
          </div>

        </div>

        <div class="field">
          <label> Email </label>
          <div class="ui left labeled icon input">
            <input id="email" placeholder="Email" type="text" name="email" value="<?php echo $user['email']; ?>">
            <i class="mail icon"></i>

          </div>
        </div>







      

        <div class="field">
          <label> Address</label>
          <div class="ui left labeled icon input">
            <textarea id="address" placeholder="Address" type="textarea" name="address" ><?php echo $user['address']; ?></textarea>
            <i class="email icon"></i>

          </div>
        </div>
      
        <div class="ui fluid large teal submit button">UPDATE</div>
</div>
        <div class="ui error message"></div>
        <input type="hidden" name="update" value="1">
      </form>

  </div>
</div>




 <?php
require_once(TEMPLATES_DIR."/footer.php");
?>
