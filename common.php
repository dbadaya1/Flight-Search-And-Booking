<?php
function is_logged_in()
{
  if (isset($_SESSION['validated']) && $_SESSION['validated'] == true && isset($_SESSION['email'])) {
    return true;
} else {
    return false;
}
}
function getCities()
{
  global $pdo;
  $stmt = $pdo->prepare('SELECT id,name,state FROM city');
  $stmt->execute();
  $cities = $stmt->fetchAll();
    //$cities = array("Delhi","Jaipur","Bangalore","Chennai","Hyderabad","Kanpur","Mumbai");
  return $cities;
}

function getCity($city_id) {
  global $pdo;
  $stmt = $pdo->prepare('SELECT * FROM city WHERE id = :city_id');
    $stmt->execute(['city_id' => $city_id]);
    $city = $stmt->fetch();
    return $city;
}

function getTravelClasses() {
  global $pdo;
  $stmt = $pdo->prepare('SELECT * FROM travel_class ORDER BY id ASC');
  $stmt->execute();
  $travel_classes = $stmt->fetchAll();
  return $travel_classes;
}

function getTravelClassName($class_id) {
  global $pdo;
  $stmt = $pdo->prepare('SELECT name FROM travel_class 
      WHERE id = :travel_class_id
      ');
    $stmt->execute(['travel_class_id' => $class_id]);
    $class = $stmt->fetch()['name'];
    return $class;

}


function getCityName($city_id) {
  global $pdo;
  $stmt = $pdo->prepare('SELECT name FROM city 
      WHERE id = :d_city_id
      ');
    $stmt->execute(['d_city_id' => $city_id]);
    $cityName = $stmt->fetch()['name'];
    return $cityName;


}

function flight_search(){ ?>

  <form action="<?php echo HOMEPAGE_URL; ?>/search" method="POST" class="ui form flight_search">
    <div class="fields">
      <div class="four wide column field originCityDropdown">
        <label>Departure City</label>
        <div class="ui fluid search selection dropdown">
          <input class="city" type="hidden" name="originCity">
          <i class="dropdown icon"></i>
          <div class="default text"> Select Origin </div>
          <div class="menu">
            <?php
            $cities = getCities();
            foreach ($cities as $city) {
              echo "<div class='item' data-value='{$city['id']}'>{$city['name']} - {$city['state']}</div>";
          }
          ?>
      </div>
  </div>
</div>
<div class="four wide column field destinationCityDropdown">
    <label>Destination City</label>
    <div class="ui fluid search selection dropdown">
      <input class="city" type="hidden" name="destinationCity">
      <i class="dropdown icon"></i>
      <div class="default text">Select Destination</div>
      <div class="menu">
        <?php
        $cities = getCities();
        foreach ($cities as $city) {
          echo "<div class='item' data-value='{$city['id']}'>{$city['name']} - {$city['state']}</div>";
      }
      ?>
  </div>
</div>
</div>
<div class="two wide column field travelClass">
    <label>Travel Class</label>
    <select name="class">
   <?php $travel_classes = getTravelClasses();
        foreach ($travel_classes as $travelClass) {
          echo " <option value='{$travelClass['id']}'>{$travelClass['name']}</option>";
      }
    ?>

  </select>
</div>
<div class="two wide column field departureDate">
    <label>Departura Date</label>
    <input name="departureDate" type="text" id="datepicker" placeholder="Depart Date" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Depart Date'" required>
</div>
<div class="field noOfTravellers">
    <label>No. Of Travellers</label>
    <input type="text" name="noOfTravellers" placeholder="No. Of Passengers" onfocus="this.placeholder = ''" onblur="this.placeholder = 'No. Of Passengers'" required>
</div>
<div class="one wide column field">
    <label>Search</label>
    <input type="submit" class="ui submit button" value="Search" >
</div>
</div>
</form>
<?php }


function scriptInclude($name)
{
    echo "<script src='" . JS_URL . "/$name'></script>\n";
}


function stylesheetInclude($name)
{
    echo "<link rel='stylesheet' type='text/css' href='" . CSS_URL . "/$name' />\n";
}





function flight_booking_steps($activeClass) { ?>


<div class="ui ordered four steps flight_booking_steps">
  <div class="step search">
    <div class="content">
      <div class="title">Search</div>
      <div class="description">Search for your desired flight</div>
    </div>
  </div>
  <div class="step review">
    <div class="content">
      <div class="title">Review</div>
      <div class="description">Review your selected flight</div>
    </div>
  </div>
   <div class="step passengers_details">
    <div class="content">
      <div class="title">Passenger Details</div>
      <div class="description">Enter Passenger Details</div>
    </div>
  </div>
  <div class="step confirmed">
    <div class="content">
      <div class="title">Tickets Confirmed</div>
      <div class="description">Get you booking id</div>
    </div>
  </div>
</div>

<script>
$('.flight_booking_steps .<?php echo $activeClass; ?>').addClass('active');
$('.flight_booking_steps').children('.step').each(function () {
    if(!$( this ).hasClass('<?php echo $activeClass; ?>'))
      $( this ).addClass('completed');
    else {
        return false;
    }
});

</script>

<?php }




function signin_signup_form() { ?>
<div class="ui popup container signin-signup-form">
<div class="ui middle aligned center aligned grid">
  <div class="column six wide">
    <h2 class="ui teal header">
      <div class="content">
        Log-in to your account
      </div>
    </h2>
    <form action="<?=HOMEPAGE_URL;?>/login.php" method="post" class="ui large form">
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
      <input type="hidden" name="redirect" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
        <div class="ui fluid large teal submit button">Sign In</div>
      </div>

      <div class="ui error message"></div>

    </form>

    <div class="ui message signup_button">
      New to us? <a target='_blank' href="<?php echo HOMEPAGE_URL.'/login.php'; ?>">Sign Up</a>
    </div>
  </div>
</div>



</div>
<?php }
?>


