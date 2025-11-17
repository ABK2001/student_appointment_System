<?php $page_title = "My Appointments"; ?>
<?php include 'header.php'; ?>

<?php
if ($_SESSION['user_type'] != "faculty_member") {
    header("Location: index.php");
    exit;
}

$member_id = $_SESSION['user_id'];

$query = "
    SELECT 
        a.id,
        a.date AS appointment_date,
        a.purpose,
        a.status,
        oh.day,
        oh.from_time,
        oh.to_time,
        s.first_name AS student_first_name,
        s.last_name AS student_last_name,
        s.department AS student_dept
    FROM appointment a
    JOIN office_hour oh ON a.office_hour_id = oh.id
    JOIN student s ON a.student_id = s.id
    WHERE a.member_id = '$member_id'
    ORDER BY a.date DESC, oh.from_time ASC
";

$result = mysqli_query($con, $query) or die('error: ' . mysqli_error($con));
?>

<div class="post">

    <?php if (mysqli_num_rows($result) == 0): ?>
        <p class="text-center">No appointments found.</p>
    <?php else: ?>
        <table class="table table-striped table-bordered" width="100%">
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Student</th>
                <th>Purpose</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_array($result)) { ?>
            <tr>
                <td>
                    <?php echo htmlspecialchars($row['appointment_date']); ?>
                    <br><small class="text-muted">(<?php echo htmlspecialchars($row['day']); ?>)</small>
                </td>
                <td>
                    <?php 
                    $from = date("g:i A", strtotime($row['from_time']));
                    $to = date("g:i A", strtotime($row['to_time']));
                    echo "$from - $to";
                    ?>
                </td>
                <td>
                    <?php 
                    echo htmlspecialchars($row['student_first_name'] . ' ' . $row['student_last_name']);
                    ?><br>
                    <small class="text-muted"><?php echo htmlspecialchars($row['student_dept']); ?></small>
                </td>
                <td><?php echo htmlspecialchars($row['purpose']); ?></td>
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
                <td>
                    <?php if ($status === 'Pending'): ?>
                        <a href="member_approve_appointment.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-sm btn-success">Approve</a>
                        <a href="member_reject_appointment.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-sm btn-danger">Reject</a>
                    <?php else: ?>
                        <em>—</em>
                    <?php endif; ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>