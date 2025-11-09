<?php $page_title = "Login";?>

<?php include 'header.php';?>

<?php
if (isset ( $_SESSION ['user_id'] ) != "") {
	header ( "Location: index.php" );
}

if (isset ( $_POST ['btn-submit'] )) {
	$username = ($_POST ['username']);
	$password = ($_POST ['password']);
	
	// if the user is admin (checking username instead of username for admin)
	$res = mysqli_query ($con,  "SELECT * FROM admin WHERE username='$username' AND password = '$password'" );
	$row = mysqli_fetch_array ( $res );
	
	if (mysqli_num_rows ( $res ) != 0) {
		$_SESSION ['user_type'] = "admin";
		$_SESSION ['user_id'] = $row ['id'];
		header ( "Location: index.php" );
	} else {
		// if the user is student
		$res = mysqli_query ($con,  "SELECT * FROM faculty_member WHERE username='$username' AND password = '$password'" );
		$row = mysqli_fetch_array ( $res );
		
		if (mysqli_num_rows ( $res ) != 0) {
			$_SESSION ['user_type'] = "faculty_member";
			$_SESSION ['user_id'] = $row ['id'];
			header ( "Location: index.php" );
		} else {
			// if the user is student
			$res = mysqli_query ($con,  "SELECT * FROM student WHERE username='$username' AND password = '$password'" );
			$row = mysqli_fetch_array ( $res );
			
			if (mysqli_num_rows ( $res ) != 0) {
				$_SESSION ['user_type'] = "student";
				$_SESSION ['user_id'] = $row ['id'];
				header ( "Location: index.php" );
			} else {
				echo "<script>alert('Invalid username or password');</script>";
			}
		}
	}
} 
?>

<form method="post" role="form" class="php-email-form">
	<div class="form-group mt-3">
		<input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
	</div>
	<div class="form-group mt-3">
		<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
	</div>
	<div class="text-center">
		<button type="submit" name="btn-submit">Login</button>
	</div>
</form>

<?php include 'footer.php';?>