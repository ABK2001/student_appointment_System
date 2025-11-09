<?php
session_start ();
ob_start ();

// connect to the server
$con = mysqli_connect ( "localhost", "root", "", "student_appointment" );

// show all errors expet the notice and warning
ini_set('display_errors', 1);
error_reporting(E_ALL ^E_NOTICE ^E_WARNING ^E_DEPRECATED);

// for arabic content
mysqli_query ( $con, "SET NAMES utf8" );
?>