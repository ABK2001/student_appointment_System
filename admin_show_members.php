<?php
$page_title = "All Faculty Members";
?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "admin") {
	header ( "Location: index.php" );
}
?>

<?php
// get all information for the faculty members
$members_query = "SELECT * FROM faculty_member";
$members_result = mysqli_query ($con,  $members_query ) or die ( 'error : ' . mysqli_error ($con) );
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
			<th>Age</th>
			<th>Speciality</th>
			<th>Department</th>
			<th></th>
		</tr>
		<?php while ($member_row = mysqli_fetch_array($members_result)) { ?>
		<tr>
			<td><?php echo $member_row['first_name']?></td>
			<td><?php echo $member_row['last_name']?></td>
			<td><?php echo $member_row['username']?></td>
			<td><?php echo $member_row['email']?></td>
			<td><?php echo $member_row['mobile']?></td>
			<td><?php echo $member_row['gender']?></td>
			<td><?php echo $member_row['age']?></td>
			<td><?php echo $member_row['speciality']?></td>
			<td><?php echo $member_row['department']?></td>
			<td>
				<a href="admin_edit_member.php?id=<?php echo $member_row['id']?>">Edit</a> | 
				<a href="admin_delete_member.php?id=<?php echo $member_row['id']?>">Delete</a>
			</td>
		</tr>
		<?php } ?>
		
		<tr>
			<td colspan="10"><a href="admin_add_member.php">Add new faculty member</a></td>
		</tr>
	</table>
</div>
<?php include 'footer.php';?>