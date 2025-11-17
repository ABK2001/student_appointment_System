<?php $page_title = "Reject Appointment"; ?>
<?php include 'header.php'; ?>

<?php
if ($_SESSION['user_type'] != "faculty_member") {
    header("Location: index.php");
    exit;
}

$appointment_id = (int)$_GET['id'];
$member_id = $_SESSION['user_id'];

// Verify appointment belongs to this faculty
$check = mysqli_query($con, "SELECT student_id FROM appointment WHERE id = '$appointment_id' AND member_id = '$member_id' AND status = 'Pending'");
if (mysqli_num_rows($check) == 0) {
    header("Location: member_show_appointments.php");
    exit;
}

$row = mysqli_fetch_array($check);
$student_id = $row['student_id'];

// Update status
mysqli_query($con, "UPDATE appointment SET status = 'Rejected' WHERE id = '$appointment_id'");

// Send notification
$notif_content = "Your appointment has been <strong>rejected</strong> by the faculty member.";
$notif_query = "INSERT INTO notification (student_id, appointment_id, content) 
                VALUES ('$student_id', '$appointment_id', '$notif_content')";
mysqli_query($con, $notif_query);

echo "<script>alert('Appointment rejected and student notified.');</script>";
echo "<meta http-equiv='Refresh' content='0; url=member_show_appointments.php'>";
exit;
?>