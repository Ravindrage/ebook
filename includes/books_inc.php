<!-- Service Panels -->
<?php
/*
if(!defined('MyConst')) {
   die('Direct access not permitted');
}

getServices($con);
*/
?>

<!--
<div class="container">
	<div class="row center">
        <div class="col-md-8 center">
    		<h2>Custom search Books</h2>
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text" class="form-control input-lg" placeholder="Book Name" />
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
	</div>
</div>
-->

<?php
/**
    if ($servicesNumRows > 0) {
		
		
        echo "<div class='row' id='books' style='height:400px'>";
		
		if (!empty($servicesHeading)) {
			echo "<div class='col-lg-12'>";
			echo "<h2 class='page-header services'>".$servicesHeading."</h2>";
			echo "</div>";
		}
        
        if (!empty($servicesBlurb)) {
            echo "<div class='col-lg-12'>";
            echo "<p class='text-center'>".$servicesBlurb."</p>";
            echo "</div>";
        }
*/
        include "../db/dbsetup.php";
		
        $output = '';

        if(isset($_POST["query"]))
        {
            $search = mysqli_real_escape_string($con, $_POST["query"]);
            $query = "
                        SELECT * FROM books
                        WHERE name LIKE '%".$search."%' 
                    ";
        //}
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0)
        {   echo "Your Search Result:<hr>";
            while ($row = mysqli_fetch_array($result)) 
            {
                //echo "<p>" . $row["name"] . "</p>";
                //echo "<p> Your books: " .'<a href="select_category.php?cat='.$row['id'].'">'.$row['name'].'</a>'."</p>";
                $output .= '
                    <p><a href="select_category.php?cat='.$row['id'].'">'.$row['name'].'</a></p>
                ';
                
            }
            echo $output;
        }
        else
        {
            echo "<p>No matches found</p>";
        }
    }

		 
/**
    }
	else 
	{
		echo '<div style="height:300px;"> No Book Found in this Category </div>';
	}
*/
?>