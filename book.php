<?php
require_once("config.php");
if(!is_logged_in())
	header('Location: '.HOMEPAGE_URL);
require_once(TEMPLATES_DIR."/header.php");
 ?>
   <?php
   if(!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['age']) && !empty($_POST['flight_id']) && !empty($_POST['noOfTravellers']) && !empty($_POST['class'])) {


$flight_id = $_POST['flight_id'];
$class = $_POST['class'];
$noOfTravellers = $_POST['noOfTravellers'];
$user_email = $_SESSION['email'];

$stmt = $pdo->prepare('SELECT id FROM user WHERE email = :email');
    $stmt->execute(['email' => $user_email]);
    $user_id = $stmt->fetchColumn();


$sql = "INSERT INTO Booking(flight_id,user_id,noOfTravellers,class_id,status)
            VALUES (
            :flight_id, 
            :user_id, 
            :noOfTravellers, 
            :class_id,
            'CNF')";
                                          
$stmt = $pdo->prepare($sql);
$stmt->execute([
	'flight_id' => $flight_id,
	'user_id' => $user_id,
	'noOfTravellers' => $noOfTravellers,
	'class_id' => $class]);

$booking_id = $pdo->lastInsertId('id');


$fnames = $_POST['fname'];
$mnames = $_POST['mname'];
$lnames = $_POST['lname'];
$ages = $_POST['age'];



for($i = 0;$i<count($fnames);$i++) {
if(!is_numeric($ages[$i])) {
    echo "Please enter a valid age";
    echo $ages[$i];
    die();
}
}


$sql = "INSERT INTO Passenger
            VALUES (
            :booking_id, 
            :fname, 
            :mname, 
            :lname, 
            :age)";
                                          
$stmt = $pdo->prepare($sql);


for($i = 0;$i<count($fnames);$i++) {

$stmt->execute([
	'booking_id' => $booking_id,
	'fname' => $fnames[$i],
	'mname' => $mnames[$i],
	'lname' => $lnames[$i],
	'age' => $ages[$i]]);

}

$stmt = $pdo->prepare("SELECT flight_id FROM seats_booked WHERE flight_id = $flight_id AND class_id=$class");
    $stmt->execute();

if($stmt->rowCount() > 0) {

    $sql = "UPDATE seats_booked
SET seats_booked = seats_booked + ".$noOfTravellers." WHERE flight_id = $flight_id AND class_id=$class";

}
else {
    $sql = "INSERT INTO seats_booked VALUES($flight_id,$class,$noOfTravellers)";

}
       
$stmt = $pdo->prepare($sql);
$stmt->execute();



$stmt = $pdo->prepare('SELECT fname FROM user WHERE email = :email');
    $stmt->execute(['email' => $user_email]);
    $user_name = $stmt->fetchColumn();




?>
<?php flight_booking_steps('confirmed'); ?>

<div class="ui segment">
<div class="center aligned header">
<p>Congrulations <?php echo $user_name; ?>,
your booking has been confirmed.</p>
Your Booking Id is <?php echo $booking_id; ?>
<br>You can see all your bookings <a href="<?=HOMEPAGE_URL;?>/mybookings" >here</a>.
</div>
</div>





<?php }

else {
    flight_search();
}
 ?>








<?php
require_once(TEMPLATES_DIR."/footer.php");
?>

