<?php

require_once("config.php");

if( isset($_SESSION['validated']) && $_SESSION['validated'] == true && isset($_SESSION['email'])) {
	unset($_SESSION['validated']);
	unset($_SESSION['email']);
	unset($_SESSION);

	header("Location: ".HOMEPAGE_URL);

}

?>