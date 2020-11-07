<?php
define('MyConst', TRUE);

include 'includes/header.php';

echo "<div class='container'>";
echo "<div class='row row_pad'>";
echo "<div class='col-md-12'>";
	//include 'includes/books_inc.php';
    include 'includes/ajaxSearchBookName.php';
echo "</div>";
echo "</div>";

include 'includes/footer.php';
?>