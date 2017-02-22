<?php
require_once("config.php");
if(!is_logged_in())
	header('Location: '.HOMEPAGE_URL);
require_once(TEMPLATES_DIR."/header.php");
?>







<?php if(!empty($_GET['booking_id'])) {
  $booking_id = $_GET['booking_id'];


  if(!empty($_GET['cancel'])  && $_GET['cancel'] == 1) {
   $stmt = $pdo->prepare("update booking set status='CAN' WHERE id = :booking_id");
   $stmt->execute(['booking_id' => $booking_id]);
   header('Location: '.HOMEPAGE_URL."/mybookings.php");

 }

 $stmt = $pdo->prepare('SELECT * FROM booking WHERE id = :booking_id');
 $stmt->execute(['booking_id' => $booking_id]);
 $booking = $stmt->fetch();


 $stmt = $pdo->prepare('SELECT * FROM flight WHERE id = :flight_id');
 $stmt->execute(['flight_id' => $booking['flight_id']]);
 $flight = $stmt->fetch();


 $stmt = $pdo->prepare('SELECT * FROM passenger WHERE booking_id = :booking_id');
 $stmt->execute(['booking_id' => $booking['id']]);
 $passengers = $stmt->fetchAll();

 $stmt = $pdo->prepare('SELECT * FROM airplane,airline 
  WHERE airplane.id = :airplane_id 
  AND airline.id = airplane.airline_id');
 $stmt->execute(['airplane_id' => $flight['airplane_id']]);
 $airplane = $stmt->fetch();

 $departureCity = getCity($flight['d_city']);
 $arrivalCity = getCity($flight['a_city']);

 ?>



 <?php if($booking['status'] == "CAN") { ?>


 <div class="ui warning message">
  <div class="header">
    This booking has been cancelled  </div>
  </div>

  <?php } ?>
  <div class="ui grid stacked segment">

    <div class="row">

      <div class="twelve wide column checkout1">
        <div class="ui top attached label">
          <h4>Booking Details</h4>
        </div>
        <div class="ui grid">
          <div class="four column row">

            <div class="ui left floated column label">
              <i class="plane icon"></i> Departure
            </div>
            <div class="ui right floated column label">
             Total Time:
             <?php 
             $start_date = new DateTime($flight['d_date_time']);
             $duration = $start_date->diff(new DateTime($flight['a_date_time']));
             echo "{$duration->h}H {$duration->i}M";

             ?>
           </div>
         </div>
       </div>
       <div class="ui grid">

        <div class="row">
          <div class="three wide column">

            <div class="ui image header">
              <img class="ui mini circular image" alt="" src="data:image/png;base64,<?php echo $airplane['logo']; ?>" />
              <div class="content">
                <?php echo "<b>{$airplane['name']}</b> ";
                echo '<div class="sub header">';
                echo "<b>{$airplane['short_name']}{$flight['fnumber']}</b></div>"; ?>
              </div>
            </div>


            
          </div>

          <div class="three wide column">
            <?php echo "{$departureCity['name']}<br>{$departureCity['state']}<br>"; 
            $date_time = strtotime($flight['d_date_time']);
            echo date('jS F Y H:i', $date_time);
            ?>
          </div>

          <div class="seven wide column">
            <i class="clock icon"></i> 
            <?php
            echo "{$duration->h}H {$duration->i}M";
            echo " | Non Stop";
            if($flight['free_meals'] == 1)
              echo " | Free Meal";
            ?>
            <div class="ui horizontal divider">
              <i class="plane icon"></i>
            </div>

            <?php
            echo getTravelClassName($booking['class_id']);
            if($flight['refundable'] == 1)
              echo " | Refundable";

            ?>

          </div>

          <div class="three wide column">
            <?php echo "{$arrivalCity['name']}<br>{$arrivalCity['state']}<br>"; 
            $date_time = strtotime($flight['a_date_time']);
            echo date('jS F Y H:i', $date_time);
            ?>
          </div>

        </div>
      </div>
    </div>


    <div class="four wide column">
      <div class="ui top attached label">
        <h4>Fare Details</h4>
      </div>


      <div class="ui grid">
        <div class="two column row">
          <div class="column">
            Passengers x <?php echo $booking['noOfTravellers']; ?>            
          </div>
          <div class="right aligned column">
           <?php
           echo "&#8377;". $booking['noOfTravellers']*$flight['price']; 
           ?>
         </div>
       </div>

       <div class="two column row">
        <div class="column">
          Tax           
        </div>
        <div class="right aligned column">
         <?php
         echo "&#8377;". $booking['noOfTravellers']*$flight['price']*.2; 
         ?>
       </div>
     </div>

     <div class="two column row">
      <div class="column">
        Service Charge            
      </div>
      <div class="right aligned column">
       <?php
       echo "&#8377;300"; 
       ?>
     </div>
   </div>



   <div class="row">
    <div class="right aligned column">
      You Paid
      <div class="header"><h2>
       <?php echo "&#8377;". ($booking['noOfTravellers']*$flight['price']*1.2 + 300 );  ?>

     </h2>       
   </div>
 </div>
 
</div>




</div>
</div>



</div>



<h4 class="ui header">Passengers List</h4>
<div class="ui ordered middle aligned animated list">

  <?php foreach($passengers as $passenger) { ?>
  <div class="item">
    <i class="user icon"></i>
    <div class="content">
      <div class="header"><?php echo "{$passenger['fname']} {$passenger['mname']} {$passenger['lname']}" ?></div>
      <div class="description"><?php echo "Age: {$passenger['age']}"; ?></div>
    </div>
  </div>
  <?php } ?>
</div>

</div>


<?php if($booking['status'] == "CNF") { ?>

<a href="<?php echo "?booking_id={$booking['id']}&cancel=1";  ?>" class="ui fluid blue submit button">Cancel Flight</a>
<?php } ?>


<?php  } ?>



<?php
require_once(TEMPLATES_DIR."/footer.php");
?>

