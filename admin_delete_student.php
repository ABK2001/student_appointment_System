<?php
$page_title = "Delete student";
?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "admin") {
	header ( "Location: index.php" );
}
?>

<?php
// delete the student
mysqli_query ($con,  "DELETE FROM student WHERE id = '$_GET[id]'" ) or die ( 'error ' . mysqli_error ($con) );

// if there is affected rows in the database;
if (mysqli_affected_rows ( $con ) == 1) {
	echo "<script>alert('Deleted successfully');</script>";
	
	echo "<meta http-equiv='Refresh' content='0; url=admin_show_students.php'>";
} else {
	echo "<script>alert('Error in delete');</script>";
	echo "<meta http-equiv='Refresh' content='0; url=admin_show_students.php'>";
}
?>

<?php include 'footer.php';?>