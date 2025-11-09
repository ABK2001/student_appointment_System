<?php $page_title = "Update profile";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student") {
	header ( "Location: index.php" );
}

// Define departments
$departments = [
    "Computer and Network Engineering",
    "Computer Science", 
    "Software Engineering",
    "Information Systems"
];

if (isset ( $_POST ['btn-submit'] )) {
	$first_name = mysqli_real_escape_string($con, $_POST ['first_name']);
	$last_name = mysqli_real_escape_string($con, $_POST ['last_name']);
	$username = mysqli_real_escape_string($con, $_POST ['username']);
	$email = mysqli_real_escape_string($con, $_POST ['email']);
	$password = mysqli_real_escape_string($con, $_POST ['password']);
	$mobile = mysqli_real_escape_string($con, $_POST ['mobile']);
	$gender = mysqli_real_escape_string($con, $_POST ['gender']);
	$department = mysqli_real_escape_string($con, $_POST ['department']);
	
	if (mysqli_query ($con,  "UPDATE student SET first_name = '$first_name', last_name = '$last_name', username = '$username', password = '$password', email = '$email', mobile = '$mobile', gender = '$gender', department = '$department' WHERE id = $_SESSION[user_id]" )) {
		echo "<script>alert('Updating successfully');</script>";
	} else {
		echo "<script>alert('Error in updating');</script>";
	}
}
?>

<?php
// if the student is loggedin
$query = "SELECT * FROM student WHERE id = '$_SESSION[user_id]'";
$student_result = mysqli_query ($con,  $query ) or die ( "can't run query because " . mysqli_error ($con) );

$student_row = mysqli_fetch_array ( $student_result );

if (mysqli_num_rows ( $student_result ) == 1) { ?>
<div class="contact" data-aos="fade-up">
	<form method="post" role="form" class="php-email-form">
		<div class="form-group mt-3">
			First Name
			<input type="text" class="form-control" name="first_name" required value="<?php echo $student_row['first_name'];?>" pattern="[A-Za-z]+" title="Only letters are allowed" />
		</div>
		<div class="form-group mt-3">
			Last Name
			<input type="text" class="form-control" name="last_name" required value="<?php echo $student_row['last_name'];?>" pattern="[A-Za-z]+" title="Only letters are allowed" />
		</div>
		<div class="form-group mt-3">
			Username
			<input type="text" class="form-control" name="username" required value="<?php echo $student_row['username'];?>" />
		</div>
		<div class="form-group mt-3">
			Email <input type="email" class="form-control" name="email" required value="<?php echo $student_row['email'];?>"  />
		</div>
		<div class="form-group mt-3">
			Password <input type="password" class="form-control" name="password" required value="<?php echo $student_row['password'];?>"  />
		</div>
		<div class="form-group mt-3">
			Mobile
			<input type="text" name="mobile" class="form-control" required title="0551234567" value="<?php echo $student_row['mobile'];?>" pattern="05[0-9]{8}" maxlength="10"/>
		</div>
		<div class="form-group mt-3">
			Gender
			<select class="form-control" name="gender" required>
				<option value="Male" <?php if($student_row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
				<option value="Female" <?php if($student_row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
			</select>
		</div>
		<div class="form-group mt-3">
			Department
			<select class="form-control" name="department" required>
				<option value="">Select Department</option>
				<?php foreach ($departments as $dept): ?>
					<option value="<?php echo $dept; ?>" <?php if($student_row['department'] == $dept) echo 'selected'; ?>><?php echo $dept; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<br/>
		<div class="text-center">
			<button type="submit" name="btn-submit">Update</button>
		</div>
	</form>
</div>
<?php
} // end of else; the student didn't loggedin
?>

<?php include 'footer.php'; ?>