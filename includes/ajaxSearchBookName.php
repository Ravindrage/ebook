<!-- Service Panels -->
<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}

getServices($con);
?>


	<div class="container">
		<br>
		<h2 align="row center">Search Book Name.</h2>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">Search</span>
				<input type="text" name="search_text" id="search_text" placeholder="Search by Book Name" class="form-control" />
			</div>
			<div id="result"></div>
			<?php
			    if ($servicesNumRows > 0) 
			    {
			        echo "<div class='row' id='books'>";
					
					if (!empty($servicesHeading)) {
						echo "<div class='col-lg-12'>";
						echo "<h2 class='page-header services'>".$servicesHeading."</h2>";
						echo "</div>";
					}
			        /**
			        if (!empty($servicesBlurb)) {
			            echo "<div class='col-lg-12'>";
			            echo "<p class='text-center'>".$servicesBlurb."</p>";
			            echo "</div>";
			        }
			        */

			        echo '<div class="col-md-3" ><ul>';
					while ($rowbooks = mysqli_fetch_array($bookcategory)){
						
					echo '<li><a href="select_category.php?cat='.$rowbooks['id'].'">'.$rowbooks['name'].'<a></li>';
					if($rowbooks['id']%50==0) { echo '</ul></div><div class="col-md-3"><ul>' ;  }
					
					}

			        //$connect = mysqli_connect("localhost", "root", "", "bookworm");
			?>
		</div>
		<br>
		
	</div>

	<script type="text/javascript">
		$(document).ready(function(){

			load_data();

			function load_data(query) {
				$.ajax({
					url:"includes/books_inc.php",
					method:"POST",
					data:{query:query},
					success:function(data)
					{
						$('#result').html(data);
					}
				});
			}

			$('#search_text').keyup(function(){
				var search = $(this).val();
				if(search != '')
				{
					load_data(search);
				}
				else
				{
					load_data();
				}
			});
		});

	</script>

<?php
	}
	else 
	{
		echo '<div style="height:300px;"> No Book Found in this Category </div>';
	}
?>