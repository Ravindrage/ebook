<?php 
define('MyConst', TRUE);
//print_r($_POST);  exit;
include 'includes/header.php';

	if ( isset($_FILES["fileToUpload"]["tmp_name"]) and !empty($_FILES["fileToUpload"]["tmp_name"])) {
	    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
		
		$uploadMsg = "<div class='alert alert-success'>The file ". basename( $_FILES["fileToUpload"]["name"]) ." has been uploaded.<button type='button' class='close' data-dismiss='alert'>×</button></div>";
	} else {
		$uploadMsg = "";
	}

	//Page preview
	if (isset($_GET["preview"]) and ($_GET["preview"]>"")){
		$pagePreviewId=$_GET["preview"];
		$sqlteamPreview = mysqli_query($con,"SELECT id, title, image, content, name FROM books WHERE id='$pagePreviewId'");
		$row  = mysqli_fetch_array($sqlteamPreview);
			
			echo "<style type='text/css'>html, body {margin-top:0px !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;}</style>";			
			echo "<div class='col-lg-12'>";
			if ($row["image"]>""){
				echo "<p><img src=../uploads/".$row['image']." style='max-width:350px; max-height:150px;' /></p>";
			}
			if ($row["name"]>""){
				echo "<h4>".$row['name']."</h4>";
			}
			if ($row["title"]>""){
				echo "<p>".$row['title']."</p>";
			}
			echo "<p>".$row['content']."</p>";
			echo "</div>";
	}
?>
   <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?php echo $rowSetup["teamheading"]?>
            </h1>
        </div>
    </div>
	<div class="row">
		<div class="col-lg-12">
<?php

	if (isset($_GET["newteam"]) OR isset($_GET["editteam"])) {
		$teamMsg="";
		
		//Update existing team
		if (isset($_GET["editteam"])) {
			$theteamId = $_GET["editteam"];
			$teamLabel = "Edit Team Title";
			
			//update data on submit
			if (!empty($_POST["team_title"])) {
				$teamUpdate = "UPDATE books SET title='".$_POST["team_title"]."', content='".$_POST["team_content"]."', name='".$_POST["team_name"]."', image='".$_POST["team_image"]."', active=".$_POST["team_status"].", datetime='".date("Y-m-d H:i:s")."' WHERE id='$theteamId'";
				mysqli_query($con,$teamUpdate);
				$teamMsg="<div class='alert alert-success'>The Book ".$_POST["team_name"]." has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php'\">×</button></div>";
			}
			
			$sqlteam = mysqli_query($con,"SELECT id, title,category, image, content, name, active, datetime FROM books WHERE id='$theteamId'");
			$row  = mysqli_fetch_array($sqlteam);
			
			
			
		//Create new team
		} else if ($_GET["newteam"]) {
			$teamLabel = "New Team Title";
			//insert data on submit
			//print_r($_POST);
			//exit;
			
			if (!empty($_POST["team_title"])) {
				
				$filename = basename($_FILES["fileToUpload"]["name"]);
				
				$teamInsert = "INSERT INTO books (title, content, image, name, active,category,file_name) VALUES ('".$_POST["team_name"]."', '".$_POST["team_content"]."', '".$_POST["team_image"]."', '".$_POST["team_name"]."', ".$_POST["team_status"].",".$_POST["category"].",".$target_file.")";
				mysqli_query($con,$teamInsert);
				$teamMsg="<div class='alert alert-success'>The Book ".$_POST["team_name"]." has been added.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php'\">×</button></div>";
			}
		} 
        
		//alert messages
		if ($uploadMsg !="") {
			echo $uploadMsg;
		}
		
		if ($teamMsg !="") {
			echo $teamMsg;
		}
		
		if (isset($_GET["editteam"])){ 
			//active status		
			if ($row['active']==1) {
				$selActive1="SELECTED";
				$selActive0="";
			} else {
				$selActive0="SELECTED";
				$selActive1="";
			}
		}

		if(isset($row["image"]) and !empty($row["image"])) {
			$thumbNail = "../uploads/".$row["image"];
		} else {
			$thumbNail = "http://placehold.it/140x100&text=No Image";
		}
?>

	<form role="teamForm" method="post" action="" enctype="multipart/form-data">
        
		<div class="form-group">
			<label>Name</label>
			<input class="form-control input-sm" name="team_name" value="<?php if(isset($_GET["editteam"])){echo $row['name'];} ?>" placeholder="Name">
		</div>
		<div class="form-group">
			<label>Title</label>
			<input class="form-control input-sm" name="team_title" value="<?php if(isset($_GET["editteam"])){echo $row['title'];} ?>" placeholder="Title">
		</div>
		<div class="form-group">
			<label>Description</label>
			<textarea class="form-control input-sm" rows="3" name="team_content" placeholder="Text" maxlength="255"><?php if(isset($_GET["editteam"])){echo $row['content'];} ?></textarea>
		</div>		
		<div class="form-group">
            <label>Status</label>
            <select class="form-control input-sm" name="team_status">
                <option value="1" <?php if(isset($_GET["editteam"])){echo $selActive1;} ?>>Active</option>
                <option value="0" <?php if(isset($_GET["editteam"])){echo $selActive0;} ?>>Draft</option>
            </select>
        </div>
		<div class="form-group">
            <label>Category</label>
            <select class="form-control input-sm"  name="category">
                <option>Select</option>
				<?php $query = "select * from category where main_cat=0 ORDER BY id  ASC";
				$sqlCategory = mysqli_query($con,$query);
		      	while($row  = mysqli_fetch_array($sqlCategory) ) 	{ 
				  echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';				
				  echo $query2 = "select * from category where main_cat=".$row['id']." ";
				  $sqlCategory2 = mysqli_query($con,$query2);
					  while($row2 = mysqli_fetch_array($sqlCategory2))
					  {
					   echo '<option value="'.$row2['id'].'">&nbsp;&nbsp &nbsp'.$row2['name'].'</option>';					  
					  }
							?>
				<?php } ?>
			      
            </select>
			            			
        </div>
		
		
        <hr/>
        <div class="form-group">
            <label>Upload Image</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
        </div>
        <div class="form-group">
        	<img src="<?php echo $thumbNail;?>" id="team_image_preview" style="max-width:140px; height:auto;"/>
        </div>
		<div class="form-group">
			<label>Use an Existing Image</label>
			<select class="form-control input-sm" name="team_image" id="team_image">
				<option value="">None</option>
				<?php
					if ($handle = opendir($target_dir)) {
						while (false !== ($file = readdir($handle))) {
							if ('.' === $file) continue;
							if ('..' === $file) continue;
							if ($file==="Thumbs.db") continue;
							if ($file===".DS_Store") continue;
							if ($file==="index.html") continue;
							if ($file===$row['image']){
								$imageCheck="SELECTED";
							} else {
								$imageCheck="";
							}
							echo "<option value=".$file." $imageCheck>".$file."</option>";
						}
						closedir($handle);
					}
				?>
			</select>
		</div>
		<hr/>
		
        <div class="form-group">
			<span><?php if(isset($_GET["editteam"])){echo "Updated: ".date('m-d-Y, H:i:s',strtotime($row['datetime']));} ?></span>
		</div>
		<button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
		<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

	</form>

<?php
	} else {
		$deleteMsg="";
		$deleteConfirm="";
		$teamMsg="";
		
		if(isset($_GET["deleteteam"])and !empty($_GET["deleteteam"])) { $delteamId = $_GET["deleteteam"];   } 
		if(isset($_GET["deletetitle"])and !empty($_GET["deletetitle"])) { $delteamTitle = $_GET["deletetitle"];  }
		if(isset($_GET["moveteam"])and !empty($_GET["moveteam"])) { $moveteamId = $_GET["moveteam"];  }
		if(isset($_GET["movetitle"])and !empty($_GET["movetitle"])) { $moveteamTitle = $_GET["movetitle"];  }
				
		//delete team
		if (isset($_GET["deleteteam"]) AND isset($_GET["deletetitle"]) AND !isset($_GET["confirm"])) {
			$deleteMsg="<div class='alert alert-danger'>Are you sure you want to delete ".$delteamTitle."? <a href='?deleteteam=".$delteamId."&deletetitle=".$delteamTitle."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php'\">×</button></div>";
			echo $deleteMsg;
		} elseif (isset($_GET["deleteteam"]) AND isset($_GET["deletetitle"]) AND ($_GET["confirm"]=="yes")) {
			//delete team after clicking Yes
			$teamDelete = "DELETE FROM books WHERE id='$delteamId'";
			mysqli_query($con,$teamDelete);
			$deleteMsg="<div class='alert alert-success'>".$delteamTitle." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php'\">×</button></div>";
			echo $deleteMsg;
		}
		
	//move team to top of list
    if (isset($_GET["moveteam"]) AND isset($_GET["movetitle"])) {
        $teamDateUpdate = "UPDATE books SET datetime='".date("Y-m-d H:i:s")."' WHERE id='$moveteamId'";
        mysqli_query($con,$teamDateUpdate);
        $teamMsg="<div class='alert alert-success'>".$moveteamTitle." has been moved to the top.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php'\">×</button></div>";
    }
		
    //update heading on submit
    if (isset($_POST["save_main"])) {
        $setupUpdate = "UPDATE setup SET teamheading='".$_POST["team_heading"]."', teamcontent='".$_POST["main_content"]."'";
        mysqli_query($con,$setupUpdate);
        $teamMsg="<div class='alert alert-success'>The heading has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php'\">×</button></div>";
    }
		
    $sqlSetup = mysqli_query($con,"SELECT teamheading, teamcontent FROM setup");
	$rowSetup  = mysqli_fetch_array($sqlSetup);
?>
<!--modal preview window-->

<style>
#webpageDialog iframe {
	width: 100%;
	height: 600px;
	frameborder: 0;
	border: none;
}
.modal-dialog {
	width:95%;
}
</style>

 <div class="modal fade" id="webpageDialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalTitle"></h4>
      </div>
      <div class="modal-body">
			<iframe id="myModalFile" src="" frameborder="0"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	<button type="button" class="btn btn-default" onclick="window.location='?newteam=true';"><i class='fa fa-fw fa-paper-plane'></i> Add a New Ebook</button>
		<h2></h2>
		<div class="table-responsive">
    <?php 
		if ($teamMsg !="") {
			echo $teamMsg;
		}
		?>
			<form role="teamForm" method="post" action="">
            <div class="form-group">
                <label>Heading</label>
                <input class="form-control input-sm" name="team_heading" value="<?php echo $rowSetup['teamheading']; ?>" placeholder="My team">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea rows="3" class="form-control input-sm" name="main_content" placeholder="About our team" maxlength="255"><?php echo $rowSetup['teamcontent']; ?></textarea>
            </div>
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Name</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
        		<?php 
					$sqlteam = mysqli_query($con,"SELECT id, title, image, content, name, active FROM books ORDER BY datetime DESC");
					while ($row  = mysqli_fetch_array($sqlteam)) {
						$teamId=$row['id'];
						$teamTitle=$row['title'];
						$teamName=$row['name'];
						$teamTumbnail=$row['image'];
						$teamContent=$row['content'];
						$teamActive=$row['active'];
						if ($row['active']==0){
							$isActive="<i style='color:red;'>(Draft)</i>";
						} else {
							$isActive="";
						}
						echo "<tr>
						<td>".$teamName."</td>
						<td class='col-xs-1'>
						<span>".$isActive."</span>
						</td>
						<td class='col-xs-2'>
						<button type='button' data-toggle='tooltip' title='Preview' class='btn btn-xs btn-default' onclick=\"showMyModal('$teamName', '?preview=$teamId')\"><i class='fa fa-fw fa-image'></i></button>
						<button type='button' data-toggle='tooltip' title='Edit' class='btn btn-xs btn-default' onclick=\"window.location.href='?editteam=$teamId'\"><i class='fa fa-fw fa-edit'></i></button>
						<button type='button' data-toggle='tooltip' title='Move' class='btn btn-xs btn-default' onclick=\"window.location.href='?moveteam=$teamId&movetitle=$teamName'\"><i class='fa fa-fw fa-arrow-up'></i></button>
						<button type='button' data-toggle='tooltip' title='Delete' class='btn btn-xs btn-default' onclick=\"window.location.href='?deleteteam=$teamId&deletetitle=$teamName'\"><i class='fa fa-fw fa-trash'></i></button>
						</td>
						</tr>";
					}
				?>
				</tbody>
			</table>
			<input type="hidden" name="save_main" value="true" />
            <button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
			<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>
			</form>
		</div>
<?php
	}
?>
		</div>
	</div>
	<p></p>

<?php
include 'includes/footer.php';
?>
