<?php $page_title = "Logout";?>

<?php include 'header.php';?>

<?php
// destroy the sessions
session_destroy ();

header ( "REFRESH:0; url=index.php" );
?>

<?php include 'footer.php';?>