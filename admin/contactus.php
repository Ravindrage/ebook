<?php 
define('MyConst', TRUE);

include 'includes/header.php';

	//update table on submit
	if (!empty($_POST)) {
		$contactUpdate = "UPDATE contactus SET heading='".$_POST["contact_heading"]."', introtext='".$_POST["contact_introtext"]."', mapcode='".mysql_real_escape_string($_POST["contact_mapcode"])."', email='".$_POST["contact_email"]."', sendtoemail='".$_POST["contact_sendtoemail"]."', address='".$_POST["contact_address"]."', city='".$_POST["contact_city"]."', state='".$_POST["contact_state"]."', zipcode='".$_POST["contact_zipcode"]."', phone='".$_POST["contact_phone"]."', hours='".$_POST["contact_hours"]."'";
		mysqli_query($con,$contactUpdate);
		$pageMsg="<div class='alert alert-success'>The contact section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='contactus.php'\">×</button></div>";
	}
	
	$sqlContact = mysqli_query($con,"SELECT heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, hours FROM contactus");
	$row  = mysqli_fetch_array($sqlContact);
?>

   <div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				<?php echo $rowContact["heading"]?>
			</h1>
		</div>
	</div>
	 <div class="row">
		<div class="col-lg-8">
		<?php 
		if ($pageMsg !="") {
			echo $pageMsg;
		}
		?>
			<form role="contactForm" method="post" action="">

				<div class="form-group">
					<label>Heading</label>
					<input class="form-control input-sm" name="contact_heading" value="<?php echo $row['heading']; ?>"  placeholder="Contact Me">
				</div>
                <div class="form-group">
					<label>Intro Text</label>
					<textarea class="form-control input-sm" name="contact_introtext" rows="3" maxlength="255"><?php echo $row['introtext']; ?></textarea>
				</div>
				<div class="form-group">
					<label>Map Code</label>
					<textarea class="form-control input-sm" name="contact_mapcode" rows="3" placeholder="Map embed code goes here"><?php echo $row['mapcode']; ?></textarea>
				</div>
				<div class="form-group">
					<label>Street Address</label>
					<input class="form-control input-sm" name="contact_address" value="<?php echo $row['address']; ?>" placeholder="123 Fake Street">
				</div>
				<div class="form-group">
					<label>City</label>
					<input class="form-control input-sm" name="contact_city" value="<?php echo $row['city']; ?>" placeholder="Beverly Hills">
				</div>
				<div class="form-group">
					<label>State</label>
					<input class="form-control input-sm" name="contact_state" value="<?php echo $row['state']; ?>" placeholder="CA">
				</div>
				<div class="form-group">
					<label>Zipcode</label>
					<input class="form-control input-sm" name="contact_zipcode" value="<?php echo $row['zipcode']; ?>" placeholder="90210">
				</div>
				<div class="form-group">
					<label>Phone</label>
					<input class="form-control input-sm" name="contact_phone" value="<?php echo $row['phone']; ?>" placeholder="555-5555">
				</div>
				<div class="form-group">
					<label>Hours</label>
					<textarea class="form-control input-sm" name="contact_hours" rows="3"><?php echo $row['hours']; ?></textarea>
				</div>
				<div class="form-group">
					<label>Email</label>
					<input class="form-control input-sm" name="contact_email" value="<?php echo $row['email']; ?>" placeholder="john.doe@email.com">
				</div>
				<div class="form-group">
					<label>Send To Email</label>
					<input class="form-control input-sm" name="contact_sendtoemail" value="<?php echo $row['sendtoemail']; ?>" placeholder="john.doe@email.com">
				</div>

				<button type="submit" class="btn btn-default"><i class='fa fa-fw fa-save'></i> Submit</button>
				<button type="reset" class="btn btn-default"><i class='fa fa-fw fa-refresh'></i> Reset</button>

			</form>

		</div>
	</div>

<?php 
include 'includes/footer.php';
?>
