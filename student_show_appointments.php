<?php $page_title = "My Appointments"; ?>

<?php include 'header.php'; ?>

<?php
// if not logged in as student; redirect to the index page
if ($_SESSION['user_type'] != "student") {
    header("Location: index.php");
    exit;
}
?>

<?php
// Fetch all appointments for the current student with full details
$appointments_query = "
    SELECT 
        a.id,
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
        appointment a
    JOIN office_hour oh ON a.office_hour_id = oh.id
    JOIN faculty_member fm ON a.member_id = fm.id
    WHERE 
        a.student_id = '$_SESSION[user_id]'
    ORDER BY 
        a.date DESC, oh.from_time ASC
";

$appointments_result = mysqli_query($con, $appointments_query) 
    or die('error: ' . mysqli_error($con));
?>

<div class="post">
    <?php if (mysqli_num_rows($appointments_result) == 0): ?>
        <p class="text-center">You have no appointments yet.</p>
    <?php else: ?>
        <table class="table table-striped table-bordered" width="100%">
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Faculty Member</th>
                <th>Purpose</th>
                <th>Status</th>
            </tr>
            <?php while ($row = mysqli_fetch_array($appointments_result)) { ?>
            <tr>
                <!-- Appointment Date + Day -->
                <td>
                    <?php echo htmlspecialchars($row['appointment_date']); ?>
                    <br>(<small class="text-muted"><?php echo htmlspecialchars($row['day']); ?></small>)
                </td>

                <!-- Time Slot -->
                <td>
                    <?php 
                    $from = date("g:i A", strtotime($row['from_time']));
                    $to = date("g:i A", strtotime($row['to_time']));
                    echo "$from - $to";
                    ?>
                </td>

                <!-- Faculty Member -->
                <td>
                    <?php 
                    echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                    ?><br>
                    ( <small class="text-muted"><?php echo htmlspecialchars($row['department']); ?></small> )
                </td>

                <!-- Purpose -->
                <td><?php echo htmlspecialchars($row['purpose']); ?></td>

                <!-- Status with Badge -->
                <td>
                    <?php
                    $status = $row['status'];
                    $badge = $status === 'Approved' ? 'success' :
                            ($status === 'Rejected' ? 'danger' : 'warning');
                    ?>
                    <span class="badge bg-<?php echo $badge; ?>">
                        <?php echo htmlspecialchars($status); ?>
                    </span>
                </td>
            </tr>
            <?php } ?>
        </table>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>