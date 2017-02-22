<?php
require_once("config.php");
if(!is_logged_in())
	header('Location: '.HOMEPAGE_URL);
require_once(TEMPLATES_DIR."/header.php");
 ?>

<h1> Your Bookings </h1>


<?php 

$stmt = $pdo->prepare('SELECT * FROM booking WHERE user_id = :user_id ORDER BY booking_time DESC');
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $bookings = $stmt->fetchAll();
if(count($bookings) == 0) {
	echo "You haven't booked any ticket yet.";

}
else {
?>
<table class="ui selectable striped table">
			<thead>
				<tr>
				<th>AIRLINE</th>
				<th>DEPART CITY</th>
								<th>DEST CITY</th>

					<th>DEPART TIME</th>

					<th>ARRIVAL TIME</th>
					<th>Booking Date</th>
										<th>STATUS</th>

					<th class="no-sort">Flight Details</th>
				</tr>
			</thead>
			<tbody>
				<?php 

foreach($bookings as $booking) {

  $stmt            = $pdo->prepare('SELECT * FROM flight WHERE id=:flight_id');
    $stmt->execute(['flight_id' => $booking['flight_id']]);
    $flight = $stmt->fetch();

        $stmt = $pdo->prepare('SELECT * FROM airplane,airline
						WHERE airplane.id = :airplane_id
						AND airline.id = airplane.airline_id');
        $stmt->execute(['airplane_id' => $flight['airplane_id']]);
        $airplane = $stmt->fetch();


$originCityName = getCityName($flight['d_city']);
$destinationCityName = getCityName($flight['a_city']);

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
						<td>
						<?php echo $originCityName; ?>
						</td>
						<td>
						<?php echo $destinationCityName; ?>
						</td>

						<td data-sort-value="<?php echo strtotime($flight['d_date_time']); ?>">
							<?php echo date("H:i", strtotime($flight['d_date_time'])); ?>
						</td>
						<td data-sort-value="<?php echo strtotime($flight['a_date_time']); ?>">
							<?php echo date("H:i", strtotime($flight['a_date_time'])); ?>
						</td>

						<td>
						<?php echo date('jS F Y',strtotime($booking['booking_time'])); ?>
						</td> 
						<td>
						<?php if($booking['status'] == "CNF")
								echo "CONFIRMED";
							else if($booking['status'] == "CAN") 
								echo "<span class='ui red label'>CANCELLED</span>";
							?>
						<td>
							<a class="ui button blue flight_details" href="<?=HOMEPAGE_URL;?>/booked-flight-details?booking_id=<?php echo $booking['id']; ?>">Flight Details</a>
						
						</td>
					</tr>
					<?php }

?>
			</tbody>
		</table>




<?php } ?>

















<?php
require_once(TEMPLATES_DIR."/footer.php");
?>
