<?php $page_title = "System Reports"; ?>
<?php include 'header.php'; ?>

<?php
if ($_SESSION['user_type'] != "admin") {
    header("Location: index.php");
    exit;
}

// Count students
$students = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) AS total FROM student"))['total'];

// Count faculty
$faculty = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) AS total FROM faculty_member"))['total'];

// Count appointments
$appointments = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) AS total FROM appointment"))['total'];

// Count by status
$pending = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) AS total FROM appointment WHERE status = 'Pending'"))['total'];
$approved = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) AS total FROM appointment WHERE status = 'Approved'"))['total'];
$rejected = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) AS total FROM appointment WHERE status = 'Rejected'"))['total'];
?>

<div class="post">
    <h3>System Statistics</h3>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Students</h5>
                    <h2><?php echo $students; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Faculty Members</h5>
                    <h2><?php echo $faculty; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Appointments</h5>
                    <h2><?php echo $appointments; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <h4>Appointments by Status</h4>
    <table class="table table-bordered">
        <tr>
            <th>Status</th>
            <th>Count</th>
            <th>Progress</th>
        </tr>
        <tr>
            <td>Pending</td>
            <td><?php echo $pending; ?></td>
            <td>
                <div class="progress">
                    <div class="progress-bar bg-warning" style="width: <?php echo $appointments ? ($pending/$appointments*100) : 0; ?>%"></div>
                </div>
            </td>
        </tr>
        <tr>
            <td>Approved</td>
            <td><?php echo $approved; ?></td>
            <td>
                <div class="progress">
                    <div class="progress-bar bg-success" style="width: <?php echo $appointments ? ($approved/$appointments*100) : 0; ?>%"></div>
                </div>
            </td>
        </tr>
        <tr>
            <td>Rejected</td>
            <td><?php echo $rejected; ?></td>
            <td>
                <div class="progress">
                    <div class="progress-bar bg-danger" style="width: <?php echo $appointments ? ($rejected/$appointments*100) : 0; ?>%"></div>
                </div>
            </td>
        </tr>
    </table>
</div>

<?php include 'footer.php'; ?>