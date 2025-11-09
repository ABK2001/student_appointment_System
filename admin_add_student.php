<?php
$page_title = "Add new student";
?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "admin") {
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
	
	// Check if email, username or mobile already exists
	$check_query = "SELECT * FROM student WHERE email = '$email' OR username = '$username' OR mobile = '$mobile'";
	$check_result = mysqli_query($con, $check_query);
	
	if (mysqli_num_rows($check_result) > 0) {
		echo "<script>alert('Error: Email, username or mobile already exists');</script>";
	} else {
		if (mysqli_query ($con,  "INSERT INTO student (first_name, last_name, username, email, password, mobile, gender, department) VALUES ('$first_name', '$last_name', '$username', '$email', '$password', '$mobile', '$gender', '$department')" )) {
			echo "<script>alert('Adding Successfully');</script>";
		} else {
			echo "<script>alert('Error in adding');</script>";
		}
	}
}
?>

<div class="contact" data-aos="fade-up">
	<form method="post" role="form" class="php-email-form" enctype="multipart/form-data">
		<div class="form-group mt-3">
			First Name
			<input type="text" class="form-control" name="first_name" placeholder="First Name" pattern="[A-Za-z]+" title="Only letters are allowed" required />
		</div>
		<div class="form-group mt-3">
			Last Name
			<input type="text" class="form-control" name="last_name" placeholder="Last Name" pattern="[A-Za-z]+" title="Only letters are allowed" required />
		</div>
		<div class="form-group mt-3">
			Username
			<input type="text" class="form-control" name="username" placeholder="Username" required />
		</div>
		<div class="form-group mt-3">
			Email
			<input type="email" class="form-control" name="email" placeholder="Email" required />
		</div>
		<div class="form-group mt-3">
			Password
			<input type="password" class="form-control" name="password" placeholder="Password" required />
		</div>
		<div class="form-group mt-3">
			Mobile
			<input type="text" class="form-control" name="mobile" placeholder="Mobile" maxlength="10" required pattern="05[0-9]{8}" />
		</div>
		<div class="form-group mt-3">
			Gender
			<select class="form-control" name="gender" required>
				<option value="Male">Male</option>
				<option value="Female">Female</option>
			</select>
		</div>
		<div class="form-group mt-3">
			Department
			<select class="form-control" name="department" required>
				<option value="">Select Department</option>
				<?php foreach ($departments as $dept): ?>
					<option value="<?php echo $dept; ?>"><?php echo $dept; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<br/>
		<div class="text-center">
			<button type="submit" name="btn-submit">Add</button>
		</div>
	</form>
</div>

<?php include 'footer.php';?>