<?php
$page_title = "Delete faculty member";
?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "admin") {
	header ( "Location: index.php" );
}
?>

<?php
// delete the faculty member
mysqli_query ($con,  "DELETE FROM faculty_member WHERE id = '$_GET[id]'" ) or die ( 'error ' . mysqli_error ($con) );

// if there is affected rows in the database;
if (mysqli_affected_rows ( $con ) == 1) {
	echo "<script>alert('Deleted successfully');</script>";
	
	echo "<meta http-equiv='Refresh' content='0; url=admin_show_members.php'>";
} else {
	echo "<script>alert('Error in delete');</script>";
	echo "<meta http-equiv='Refresh' content='0; url=admin_show_members.php'>";
}
?>

<?php include 'footer.php';?>