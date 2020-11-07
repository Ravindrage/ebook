<?php 
define('MyConst', TRUE);

include 'includes/header.php';

	$getNavSection = $_GET["section"];

	//update table on submit
	if (!empty($_POST)) {
	
		if (!empty($_POST["nav_newname"])) {
			if (!empty($_POST["nav_newcat"]) AND $_POST["exist_cat"]=="") {
				$navNewCat = "INSERT INTO category (name) VALUES ('".$_POST["nav_newcat"]."')";
				//echo $navNewCat;
				mysqli_query($con,$navNewCat);

				$sqlNavCatID = mysqli_query($con,"SELECT id FROM category ORDER BY id DESC LIMIT 1");
				$rowMaxCat = mysqli_fetch_array($sqlNavCatID);
				$navMaxCatId=$rowMaxCat[0];
				//echo $navMaxCatId;
			}

			if ($_POST["exist_cat"]=="" AND $_POST["nav_newcat"]>"") {
				$getTheCat=$navMaxCatId; //create & add new category name & get it's id
			} elseif ($_POST["exist_cat"]>"" AND $_POST["nav_newcat"]>"") {
				$getTheCat=$_POST["exist_cat"]; //use existing category id
			} else {
				$getTheCat=29; //category equal none
			}

			$navNew = "INSERT INTO navigation (name, url, sort, catid, section, win) VALUES ('".$_POST["nav_newname"]."', '".$_POST["nav_newurl"]."', 0, $getTheCat, '".$getNavSection."','off')";
			//echo $navNew;
			mysqli_query($con,$navNew);
		}
		
		for($i=0; $i<$_POST["nav_count"]; $i++) {
			if ($_POST["nav_cat"][$i]=="") {
				$_POST["nav_cat"][$i]=29; //None
			}

			$navUpdate = "UPDATE navigation SET sort=".$_POST["nav_sort"][$i].", name='".$_POST["nav_name"][$i]."', url='".$_POST["nav_url"][$i]."', catid=".$_POST["nav_cat"][$i]." WHERE id=".$_POST["nav_id"][$i]." ";
			//echo $navUpdate;
			mysqli_query($con,$navUpdate);
		}
		
		$pageMsg="<div class='alert alert-success fade in' data-alert='alert'>The navigation has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=".$getNavSection."'\">×</button></div>";
	}
	
?>

	<?php
		//loop through the array of navSections
		$navMenuStr = "";
		$navArrlength = count($navSections);
		for($x = 0; $x < $navArrlength; $x++) {
			if ($navSections[$x]==$_GET["section"]){
				$isSectionSelected="SELECTED";
			} else {
				$isSectionSelected="";
			}
			$navMenuStr = $navMenuStr . "<option value=".$navSections[$x]." ".$isSectionSelected.">".$navSections[$x]."</option>";
		}
	?>
	<div class="row">
		<div class="col-lg-10">
			<h1 class="page-header">
				Navigation (<?php echo $_GET["section"];?>)
			</h1>
		</div>

		<div class="col-lg-2">
			<div class="form-group">
				<label for="nav_menu">Navigation Sections</label>
				<select class="form-control input-sm" name="nav_menu" id="nav_menu" autofocus="autofocus">
					<?php echo $navMenuStr; ?>
				</select>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
		<?php 
		if ($pageMsg !="") {
			echo $pageMsg;
		}
		
		//get and built pages list
		
		$pagesStr="";
		$sqlNavPages= mysqli_query($con,"SELECT id, title, active FROM pages WHERE active=1 ORDER BY title");
		//$pagesStr = "<option value=''>Custom</option>";
		while ($rowNavPages = mysqli_fetch_array($sqlNavPages)) {
			$navPageId=$rowNavPages['id'];
			$navPageTitle=$rowNavPages['title'];
			$pagesStr =  $pagesStr . "<option value=".$navPageId.">".$navPageTitle."</option>";
		}
		$pagesStr = "<optgroup label='Existing Pages'>".$pagesStr."</optgroup>" . $extraPages;
		
		//get and built existing category list
		$sqlNavExistCat= mysqli_query($con,"SELECT id, name FROM category ORDER BY name");
		//$catExistStr = "<option value=''>Custom</option>";
		$catExistStr =  '';
		while ($rowNavExistCat  = mysqli_fetch_array($sqlNavExistCat)) {
			
			$catExistStr = $catExistStr . "<option value=".$rowNavExistCat['id']." >".$rowNavExistCat['name']."</option>";
			
		}

		//delete nav
		$deleteMsg="";
		$deleteConfirm="";
		$pageMsg="";
		if(isset($_GET["deletenav"])and !empty($_GET["deletenav"])) { $delNavId = $_GET["deletenav"];  } 
		if(isset($_GET["deletename"])and !empty($_GET["deletename"])) { $delNavTitle = $_GET["deletename"];  } 
		
		
		//Delete nav link
		if(isset($_GET["deletenav"]) AND isset($_GET["deletename"]) AND !isset($_GET["confirm"])) {
			$deleteMsg="<div class='alert alert-danger fade in' data-alert='alert'>Are you sure you want to delete ".$delNavTitle."? <a href='?section=".$getNavSection."&deletenav=".$delNavId."&deletename=".$delNavTitle."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=$getNavSection'\">×</button></div>";
			echo $deleteMsg;
		} elseif (isset($_GET["deletenav"]) AND isset($_GET["deletename"]) AND ($_GET["confirm"]=="yes")) {
			//delete nav after clicking Yes
			$navDelete = "DELETE FROM navigation WHERE id='$delNavId'";
			mysqli_query($con,$navDelete);
			$deleteMsg="<div class='alert alert-success fade in' data-alert='alert'>".$delNavTitle." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=".$getNavSection."'\">×</button></div>";
			echo $deleteMsg;
		}
		
		//delete category
		
		if(isset($_GET["deletecat"])and !empty($_GET["deletecat"])) { $delCatId = $_GET["deletecat"];  }
		if(isset($_GET["deletecatname"])and !empty($_GET["deletecatname"])) { $delCatTitle = $_GET["deletecatname"];  }
		//$delCatId = $_GET["deletecat"];
		//$delCatTitle = $_GET["deletecatname"];
		
		//Delete category and set nav categories to zero
		if (isset($_GET["deletecat"]) AND isset($_GET["deletecatname"]) AND !isset($_GET["confirm"])) {
			$deleteMsg="<div class='alert alert-danger fade in' data-alert='alert'>Are you sure you want to delete ".$delCatTitle."? <a href='?section=".$getNavSection."&deletecat=".$delCatId."&deletecatname=".$delCatTitle."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=$getNavSection'\">×</button></div>";
			echo $deleteMsg;
		} elseif (isset($_GET["deletecat"]) AND isset($_GET["deletecatname"]) AND ($_GET["confirm"]=="yes")) {
			$navCatUpdate = "UPDATE navigation SET catid='29' WHERE catid='$delCatId'";
			mysqli_query($con,$navCatUpdate);
			//delete category after clicking Yes
			$navCatDelete = "DELETE FROM category WHERE id='$delCatId'";
			mysqli_query($con,$navCatDelete);
			$deleteMsg="<div class='alert alert-success fade in' data-alert='alert'>".$delCatTitle." has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=".$getNavSection."'\">×</button></div>";
			echo $deleteMsg;
		}
		
		//rename category
		$renameMsg="";
		$renameConfirm="";
		
		if(isset($_GET["renamecat"]) and !empty($_GET["renamecat"])){ $renameCatId = $_GET["renamecat"]; }
		if(isset($_GET["newcatname"]) and !empty($_GET["newcatname"])){ $renameCatId = $_GET["newcatname"]; }
		
		//$renameCatId = $_GET["renamecat"];
		//$renameCatTitle = $_GET["newcatname"];
		
		//Rename category and set nav categories to new name
		if (isset($_GET["renamecat"]) AND isset($_GET["newcatname"]) AND !isset($_GET["confirm"])) {
			$renameMsg="<div class='alert alert-danger fade in' data-alert='alert'>Are you sure you want to rename ".$renameCatTitle."? <a href='?section=".$getNavSection."&renamecat=".$renameCatId."&newcatname=".$renameCatTitle."&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=$getNavSection'\">×</button></div>";
			echo $renameMsg;
		} elseif (isset($_GET["renamecat"]) AND isset($_GET["newcatname"]) AND $_GET["confirm"]=="yes") {

			$navRenameCatUpdate = "UPDATE category SET name='".$renameCatTitle."' WHERE id='$renameCatId'";
			mysqli_query($con,$navRenameCatUpdate);

			$renameMsg="<div class='alert alert-success fade in' data-alert='alert'>".$renameCatTitle." has been renamed.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='navigation.php?section=".$getNavSection."&'\">×</button></div>";
			echo $renameMsg;
		}
		
		?>
			<form role="navForm" method="post" action="">
				<fieldset>
					<div class="form-group">
						<label for="nav_newname">Link Name</label>
						<input type="text" class="form-control input-sm" name="nav_newname" id="nav_newname" value="">
					</div>
					<div class="form-group">
						<label for="nav_newurl">Link URL</label>
						<input type="text" class="form-control input-sm" name="nav_newurl" id="nav_newurl">
					</div>
					<div class="form-group">
						<label for="exist_page">Existing Page</label>
						<select class="form-control input-sm" name="exist_page" id="exist_page">
							<?php 
							echo "<option value=''>Custom</option>";
							echo $pagesStr;
							?>
						</select>
					</div>
				</fieldset>
				<hr/>
				<fieldset>
					<div class="form-group">
						<label for="nav_newcat">Category</label>
						<div class="input-group">
							<input type="text" class="form-control input-sm" name="nav_newcat" id="nav_newcat">
							<span class="input-group-addon" id="rename_cat" ><i class='fa fa-fw fa-save' style="visibility:hidden; color:#000; cursor:pointer;" data-toggle="tooltip" title="Rename" onclick="window.location.href='?section=<?php echo $getNavSection; ?>&renamecat='+$('#exist_cat').val()+'&newcatname='+$('#nav_newcat').val();"></i></span>
							<span class="input-group-addon" id="del_cat" ><i class='fa fa-fw fa-trash' style="visibility:hidden; color:#000; cursor:pointer;" data-toggle="tooltip" title="Delete" onclick="window.location.href='?section=<?php echo $getNavSection; ?>&deletecat='+$('#exist_cat').val()+'&deletecatname='+$('#nav_newcat').val();"></i></span>
						</div>
					</div>

					<div class="form-group">
						<label for="exist_cat">Existing Category</label>
						<select class="form-control input-sm" name="exist_cat" id="exist_cat">
							<?php 
							echo "<option value=''>Custom</option>";
							echo $catExistStr; 
							?>
						</select>
					</div>
				</fieldset>
				<hr/>
				<table class="table table-bordered table-hover table-striped" id="nav_Table">
					<thead>
						<tr>
							<th>Sort</th>
							<th>Name</th>
							<th>URL</th>
							<th>Category</th>
							<th><i class="fa fa-fw fa-external-link"></i> External</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$navCount="";

						$sqlNav= mysqli_query($con,"SELECT id, name, url, sort, win, catid FROM navigation WHERE section='$getNavSection' ORDER BY sort");					
						while ($rowNav  = mysqli_fetch_array($sqlNav)) {
							$navId=$rowNav['id'];
							$navName=$rowNav['name'];
							$navURL=$rowNav['url'];
							$navSort=$rowNav['sort'];
							$navWin=$rowNav['win'];
							$navCat=$rowNav['catid'];
							if(isset($rowNav['section'])) { $navSection=$rowNav['section']; };
							$navCount++;

							if ($navWin=='true') {
								$isActive="CHECKED";
							} else {
								$isActive="";
							}

							echo "<tr>
							<td class='col-xs-1'><input type='hidden' name='nav_id[]' value=".$navId." >
							<input class='form-control input-sm' name='nav_sort[]' value=".$navSort." type='text'></td>
							<td><input class='form-control input-sm' name='nav_name[]' value='".$navName."' type='text'></td>
							<td><input class='form-control input-sm' name='nav_url[]' value='".$navURL."' type='text'></td>";
							echo "<td><select class='form-control input-sm' name='nav_cat[]'>'";

							//get and built category list, find selected
							$sqlNavCat= mysqli_query($con,"SELECT id, name FROM category ORDER BY name");
							while ($rowNavCat  = mysqli_fetch_array($sqlNavCat)) {
								$navCatId=$rowNavCat['id'];
								$navCatName=$rowNavCat['name'];
								
								if ($navCatId==$navCat){
									$isSelected="SELECTED";
								} else {
									$isSelected="";
								}
								echo "<option value=".$navCatId." ".$isSelected.">".$navCatName."</option>";
							}

							echo "</select></td>
							<td class='col-xs-1'><input data-toggle='tooltip' title='Open in a new window' class='checkbox nav_win_checkbox' id='$navId' type='checkbox' ".$isActive."></td>
							<td class='col-xs-1'><button type='button' data-toggle='tooltip' title='Delete' class='btn btn-xs btn-default' onclick=\"window.location.href='?section=".$getNavSection."&deletenav=$navId&deletename=".$navName."'\"><i class='fa fa-fw fa-trash'></i></button></td>
							</tr>";
						}
						echo "<input type='hidden' name='nav_count' value=".$navCount." >";
					?>
					</tbody>
				</table>

				<button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i>Submit</button>
				<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i>Reset</button>
			</form>

		</div>
	</div>

<?php
include 'includes/footer.php';
?>
