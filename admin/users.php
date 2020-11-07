<?php 
define('MyConst', TRUE);

include 'includes/header.php';

	//update table on submit
	if (!empty($_POST)) {
		$username=$_POST['user_name'];
		$userpass=$_POST['user_password'];
		$userid=$_POST['user_id'];
		$usersUpdate = "UPDATE users SET username='$username', password=password('$userpass'), level='1' WHERE id='$userid'";
		//echo $usersUpdate;
		mysqli_query($con,$usersUpdate);

		$pageMsg="<div class='alert alert-success'>The user has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">�</button></div>";
	}
	
	$sqlUsers= mysqli_query($con,"SELECT username, password, level, id FROM users");
	$rowUsers  = mysqli_fetch_array($sqlUsers);
?>
   <div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				User Manager
			</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<?php 
			if ($pageMsg !="") {
				echo $pageMsg;
			}
			?>
			<form name="userForm" method="post" action="">

				<div class="form-group">
					<label>User Name</label>
					<input class="form-control" type="text" name="user_name" value="<?php echo $rowUsers['username']; ?>" placeholder="User name">
				</div>
				<div class="form-group">
					<label>User Password</label>
					<input class="form-control" type="password" name="user_password" value="<?php echo $rowUsers['password']; ?>" placeholder="Password">
				</div>
				<input type="hidden" name="user_id" value="<?php echo $rowUsers['id']; ?>" />

				<button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i>Submit</button>
				<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i>Reset</button>

			</form>

		</div>
	</div>

<?php
include 'includes/footer.php';
?>
