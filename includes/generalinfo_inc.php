<!-- General Info Section -->
<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}

	getGeneralInfo($con);

	if (!empty($generalInfoContent)) {
		echo "<div class='row' id='generalinfo'>";
		
		if (!empty($generalInfoHeading)) {
			echo "<div class='col-lg-12'>";
			echo "<h2 class='page-header generalinfo'>".$generalInfoHeading."</h2>";
			echo "</div>";
		}
		
		echo "<div class='col-md-12'>";
		echo $generalInfoContent;
		echo "</div>";

		echo "</div>";
	}
?>