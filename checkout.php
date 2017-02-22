<?php
require_once("config.php");
require_once(TEMPLATES_DIR."/header.php");

?>

  <?php
  if(!empty($_GET['flight_id']) && !empty($_GET['noOfTravellers']) && !empty($_GET['class'])) {
    $flight_id = $_GET['flight_id'];
    $noOfTravellers = $_GET['noOfTravellers'];
    $class=$_GET['class'];
    $stmt = $pdo->prepare('SELECT * FROM flight WHERE id = :flight_id');
    $stmt->execute(['flight_id' => $flight_id]);
    $flight = $stmt->fetch();

    $stmt = $pdo->prepare('SELECT * FROM airplane,airline 
      WHERE airplane.id = :airplane_id 
      AND airline.id = airplane.airline_id');
    $stmt->execute(['airplane_id' => $flight['airplane_id']]);
    $airplane = $stmt->fetch();

   

    $departureCity = getCity($flight['d_city']);
    $arrivalCity = getCity($flight['a_city']);


    ?>

 

<?php flight_booking_steps('review'); ?>


    <div class="ui grid stacked segment">

      <div class="row">


        <div class="twelve wide column checkout1">
          <div class="ui top attached label">
            <h4>Review Your Booking</h4>
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
              echo getTravelClassName($class);
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
              Passengers x <?php echo $noOfTravellers; ?>            
            </div>
            <div class="right aligned column">
             <?php
             echo "&#8377;". $noOfTravellers*$flight['price']; 
             ?>
           </div>
         </div>

         <div class="two column row">
            <div class="column">
              Tax           
            </div>
            <div class="right aligned column">
             <?php
             echo "&#8377;". $noOfTravellers*$flight['price']*.2; 
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
            You Pay
                                      <div class="header"><h2>
             <?php echo "&#8377;". ($noOfTravellers*$flight['price']*1.2 + 300 );  ?>

                                      </h2>       
</div>
            </div>
            
         </div>




       </div>
     </div>



   </div>


</div>
</div>


<div class="ui one column stackable center aligned page grid">
 <div class="column">
 <?php if(is_logged_in()) 
   echo '<div class="ui button blue large continue" id="checkout_continue">CONTINUE</div>';
  else
    echo '<div class="ui button blue large login-signup-popup">SIGN IN TO CONTINUE</div>';
?>
</div>
</div>


   <div class="ui twelve wide column checkout2 inactive">
   <div class="ui top container message">
            <h4>Traveller Details</h4>
    </div>
<form action="<?php echo HOMEPAGE_URL; ?>/book" method="POST" id="passengerDetails" class="ui form">
<?php for($i = 0;$i<$noOfTravellers;$i++) { ?>
  <div class="inline fields">
     
    <div class="five wide field">
          <label><?php echo $i + 1; ?></label>

      <input type="text" name="fname[]" placeholder="First Name" required>
    </div>
    <div class="four wide field">
      <input type="text" name="mname[]" placeholder="Middle Name">
    </div>
    <div class="four wide field">
      <input type="text" name="lname[]" placeholder="Last Name" required>
    </div>
    <div class="three wide field">
      <input type="text" name="age[]" placeholder="Age" data-validate="age" required>
    </div>

  </div>


<?php } ?>
      <input type="hidden" name="flight_id" value="<?php echo $flight_id; ?>">
      <input type="hidden" name="noOfTravellers" value="<?php echo $noOfTravellers; ?>">
      <input type="hidden" name="class" value="<?php echo $class; ?>">
          <input type="submit" class="ui fluid blue submit button" value="CONFIRM">

          <div class="ui error message"></div>

</form>
<?php } ?>
<?php
require_once(TEMPLATES_DIR."/footer.php");
?>