<?php $page_title = "Your Notifications";?>

<?php include 'header.php';?>

<?php
// if not logged in as student; redirect to the index page
if ($_SESSION['user_type'] != "student") {
    header("Location: index.php");
    exit;
}
?>

<?php
// get all information for the notifications with appointment details
$notifications_query = "
    SELECT 
        n.content, 
        n.date AS notification_date,
        a.date AS appointment_date,
        a.purpose,
        a.status,
        oh.day,
        oh.from_time,
        oh.to_time,
        fm.first_name,
        fm.last_name,
        fm.department
    FROM 
        notification n
    JOIN appointment a ON n.appointment_id = a.id
    JOIN office_hour oh ON a.office_hour_id = oh.id
    JOIN faculty_member fm ON a.member_id = fm.id
    WHERE n.student_id = '$_SESSION[user_id]'
    ORDER BY n.date DESC
";
$notifications_result = mysqli_query($con, $notifications_query) or die('error: ' . mysqli_error($con));
?>

<div class="post">
    <table class="table table-striped table-bordered" width="100%">
        <tr>
            <th>Notification</th>
            <th>Appointment Date</th>
            <th>Appointment Time</th>
            <th>Received</th>
        </tr>
        <?php while ($notification_row = mysqli_fetch_array($notifications_result)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($notification_row['content']); ?></td>
            <td>
                <?php echo htmlspecialchars($notification_row['appointment_date']); ?>
                <br><small>(<?php echo htmlspecialchars($notification_row['day']); ?>)</small>
            </td>
            <td>
                <?php 
                $from = date("g:i A", strtotime($notification_row['from_time']));
                $to = date("g:i A", strtotime($notification_row['to_time']));
                echo "$from - $to";
                ?>
            </td>
            
            <td><?php echo $notification_row['notification_date']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

<?php include 'footer.php';?>