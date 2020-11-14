<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


define('MyConst', TRUE);

    include 'includes/header.php';

    include 'includes/slider_inc.php';

    //Page Content -->
    echo "<div class='bodyContent'>";
 
	include 'includes/featured_inc.php';
	include 'includes/about_inc.php';
	include 'includes/services_inc.php';
	include 'includes/team_inc.php';
	include 'includes/customers_inc.php';
	include 'includes/generalinfo_inc.php';
	echo "</div>";
	include 'includes/footer.php';
?>