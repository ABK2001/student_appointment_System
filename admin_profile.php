<?php $page_title = "Update profile";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "admin") {
	header ( "Location: index.php" );
}

if (isset ( $_POST ['btn-submit'] )) {
	$username = ($_POST ['username']);
	$password = ($_POST ['password']);
	
	if (mysqli_query ($con,  "UPDATE admin SET username = '$username', password = '$password' WHERE id = $_SESSION[user_id]" )) {
		echo "<script>alert('Updating successfully');</script>";
	} else {
		echo "<script>alert('Error in updating');</script>";
	}
}
?>

<?php
// if the admin is loggedin
$query = "SELECT * FROM admin WHERE id = '$_SESSION[user_id]'";
$admin_result = mysqli_query ($con,  $query ) or die ( "can't run query because " . mysqli_error ($con) );

$admin_row = mysqli_fetch_array ( $admin_result );

if (mysqli_num_rows ( $admin_result ) == 1) { ?>
<div class="contact" data-aos="fade-up">
	<form method="post" role="form" class="php-email-form">
		<div class="form-group mt-3">
			Username
			<input type="text" class="form-control" name="username" required value="<?php echo $admin_row['username'];?>" />
		</div>
		<div class="form-group mt-3">
			Password <input type="password" class="form-control" name="password" required value="<?php echo $admin_row['password'];?>"  />
		</div>
		<br/>
		<div class="text-center">
			<button type="submit" name="btn-submit">Update</button>
		</div>
	</form>
</div>
<?php
} // end of else; the admin didn't loggedin
?>

<?php include 'footer.php'; ?>