<?php
require_once "config.php";
require_once TEMPLATES_DIR . "/header.php";
?>
	<?php


if (!empty($_POST['originCity']) && !empty($_POST['destinationCity']) && !empty($_POST['departureDate']) && !empty($_POST['noOfTravellers']) && !empty($_POST['class'])) {
    $originCity      = $_POST['originCity'];
    $destinationCity = $_POST['destinationCity'];
    if($originCity == $destinationCity) {  ?>

   <div class="ui warning message">
  <div class="header">
    Origin and destination city cannot be same  </div>
  </div>
<?php 
    	flight_search();
    	require_once TEMPLATES_DIR . "/footer.php";
    	die();
    }
    $departureDate   = $_POST['departureDate'];
    $departureDate   = date("Y-m-d", strtotime($departureDate));
    $today = date("Y-m-d");
    if((strtotime($departureDate) - strtotime($today)) < 0)
    { ?>

   <div class="ui warning message">
  <div class="header">
   Departure date must not be less than today's date.  </div>
  </div>
<?php 
    	flight_search();
    	require_once TEMPLATES_DIR . "/footer.php";
    	die();
    }
    $noOfTravellers  = $_POST['noOfTravellers'];
    $class           = $_POST['class'];
    $stmt            = $pdo->prepare('SELECT * FROM flight WHERE d_city = :d_city AND a_city = :a_city AND cast(d_date_time as DATE) = :departureDate order by PRICE');
    $stmt->execute(['d_city' => $originCity,
        'a_city'                 => $destinationCity,
        'departureDate'          => $departureDate,
    ]);
    $flights = $stmt->fetchAll();





$originCityName = getCityName($originCity);
$destinationCityName = getCityName($destinationCity);




    ?>
  <script>
  var originCity = '<?php echo $originCity; ?>';
  var originCityName = '<?php echo $originCityName; ?>';
  var destinationCity = '<?php echo $destinationCity; ?>';
var destinationCityName = '<?php echo $destinationCityName; ?>';
var travelClass = '<?php echo $class; ?>';
var departureDate = "<?php echo $_POST['departureDate']; ?>";
var noOfTravellers = '<?php echo $noOfTravellers; ?>';
</script>

<?php flight_booking_steps('search'); ?>

<h3>Modify Your Search</h3>
    <?php flight_search(); ?>

       <div class="ui grid row center aligned">
          
            <div class="three wide column header">
              <h4><?php echo "$originCityName"; ?></h4>
            </div>

            <div class="seven wide column">
             
              <div class="ui horizontal divider">
                <i class="plane icon"></i>
              </div>

          

            </div>

            <div class="three wide column">
              <h4><?php echo "$destinationCityName"; ?></h4>
            </div>

          </div>












		<table class="ui selectable striped table">
			<thead>
				<tr><th>AIRLINE</th>
					<th>DEPART</th>
					<th>ARRIVE</th>
					<th>DURATION</th>
					<th>PRICE</th>
										<th>Seats Available</th>

					<th class="no-sort">Meals</th>
					<th class="no-sort">Refundable</th>
					<th class="no-sort">Book Now</th>

				</tr>
			</thead>
			<tbody>
				<?php
foreach ($flights as $flight) {
        $stmt = $pdo->prepare('SELECT * FROM airplane,airline
						WHERE airplane.id = :airplane_id
						AND airline.id = airplane.airline_id');
        $stmt->execute(['airplane_id' => $flight['airplane_id']]);
        $airplane = $stmt->fetch();




        ?>
					<tr>
						<td>
							<div class="ui image header">
								<img class="ui mini circular image" alt="" src="data:image/png;base64,<?php echo $airplane['logo']; ?>" />
								<div class="content">
									<?php echo "<b>{$airplane['name']}</b> ";
        echo '<div class="sub header">';
        echo "<b>{$airplane['short_name']}{$flight['fnumber']}</b></div>"; ?>
								</div>
							
						</div></td>
						<td data-sort-value="<?php echo strtotime($flight['d_date_time']); ?>">
							<?php echo date("H:i", strtotime($flight['d_date_time'])); ?>
						</td>
						<td data-sort-value="<?php echo strtotime($flight['a_date_time']); ?>">
							<?php echo date("H:i", strtotime($flight['a_date_time'])); ?>
						</td>
						<td>
							<?php
$start_date = new DateTime($flight['d_date_time']);
        $duration   = $start_date->diff(new DateTime($flight['a_date_time']));
        echo "{$duration->h}H {$duration->i}M";
        ?>
						</td>
						<td data-sort-value="<?php echo $flight['price']; ?>">
							<?php echo "&#8377; " . $flight['price']; ?>
						</td>

	<td>

<div class="ui compact menu">

<?php $travel_classes = getTravelClasses();
$i = 0;
foreach($travel_classes as $travel_class) { 

 		$stmt = $pdo->prepare("SELECT capacity from airplane_capacity WHERE airplane_id={$flight['airplane_id']} AND class_id={$travel_class['id']}");
        $stmt->execute();
        $airplane_capacity = $stmt->fetch()['capacity'];

		$stmt = $pdo->prepare("SELECT seats_booked from seats_booked WHERE flight_id={$flight['id']} AND class_id={$travel_class['id']}");
        $stmt->execute();
        if($stmt->rowCount() == 0)
        	$seats_booked = 0;
        else
        	$seats_booked = $stmt->fetch()['seats_booked'];

	?>
  <a class="item">
   <?php echo $travel_class['name']; ?>
    <div class="floating ui red label">
	<?php echo $airplane_capacity - $seats_booked; ?>
    </div>
  </a>
 <?php $i++; } ?>
</div>


						</td>

<td>
										<?php if ($flight['free_meals'] == 1) {?>
										<h4 class="ui header label">
											Free Meals
										</h4>  <?php }?>
										
						</td>
						<td>
						<h4 class="ui header label">
											<?php if ($flight['refundable'] == 1) {
            echo "REFUNDABLE";
        } else {
            echo "NON-REFUNDABLE";
        }

        ?>
										</h4>
						</td>



						<td>
							<a class="ui content blue button" href="<?php echo HOMEPAGE_URL . "/checkout?flight_id={$flight['id']}&noOfTravellers=$noOfTravellers&class=$class"; ?>">BOOK NOW</a>
						</td>
						
					


					</tr>
					<?php }
} else {
	echo "All fields must be filled<br>";
    echo '<h1 class="ui header">Search Your Flights</h1>';
    flight_search();
}
?>
			</tbody>
		</table>
	<?php
require_once TEMPLATES_DIR . "/footer.php";
?>