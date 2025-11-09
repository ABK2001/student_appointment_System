<?php
$page_title = "All students";
?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "admin") {
	header ( "Location: index.php" );
}
?>

<?php
// get all information for the students
$students_query = "SELECT * FROM student";
$students_result = mysqli_query ($con,  $students_query ) or die ( 'error : ' . mysqli_error ($con) );
?>

<div class="post table-responsive">
	<table class="table table-striped table-bordered" width="100%">
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Username</th>
			<th>Email</th>
			<th>Mobile</th>
			<th>Gender</th>
			<th>Department</th>
			<th></th>
		</tr>
		<?php while ($student_row = mysqli_fetch_array($students_result)) { ?>
		<tr>
			<td><?php echo $student_row['first_name']?></td>
			<td><?php echo $student_row['last_name']?></td>
			<td><?php echo $student_row['username']?></td>
			<td><?php echo $student_row['email']?></td>
			<td><?php echo $student_row['mobile']?></td>
			<td><?php echo $student_row['gender']?></td>
			<td><?php echo $student_row['department']?></td>
			<td>
				<a href="admin_edit_student.php?id=<?php echo $student_row['id']?>">Edit</a> | 
				<a href="admin_delete_student.php?id=<?php echo $student_row['id']?>">Delete</a>
			</td>
		</tr>
		<?php } ?>
		
		<tr>
			<td colspan="8"><a href="admin_add_student.php">Add new student</a></td>
		</tr>
	</table>
</div>
<?php include 'footer.php';?>