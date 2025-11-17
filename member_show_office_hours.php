<?php
$page_title = "My Office Hours";
?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "faculty_member") {
    header ( "Location: index.php" );
}

// Define days and time slots
$days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday"];
$time_slots = [];

// Generate time slots from 8:00 AM to 2:00 PM with 15-minute intervals
$time_slots = [];
$start = strtotime('08:00:00');
$end   = strtotime('14:00:00'); // 2:00 PM

for ($time = $start; $time < $end; $time += 900) { // 900 seconds = 15 minutes
    $from_time = date('H:i:s', $time);
    $time_12   = date('g:i A', $time);
    $time_slots[$from_time] = $time_12;
}

// Handle form submission
if (isset($_POST['btn-submit'])) {
    $member_id = $_SESSION['user_id'];
    
    // First, delete all existing office hours for this member
    mysqli_query($con, "DELETE FROM office_hour WHERE member_id = '$member_id'");
    
    // Insert new office hours from checkboxes
    if (isset($_POST['office_hours']) && is_array($_POST['office_hours'])) {
        $success_count = 0;
        foreach ($_POST['office_hours'] as $time_slot) {
            list($day, $from_time) = explode('|', $time_slot);
            $to_time = date('H:i:s', strtotime($from_time . ' +15 minutes'));
            
            if (mysqli_query($con, "INSERT INTO office_hour (member_id, day, from_time, to_time) VALUES ('$member_id', '$day', '$from_time', '$to_time')")) {
                $success_count++;
            }
        }
        echo "<script>alert('Office hours updated successfully! ' + $success_count + ' time slots saved.');</script>";
    } else {
        echo "<script>alert('Office hours cleared successfully!');</script>";
    }
}

// Get existing office hours for this member
$existing_hours = [];
$query = "SELECT * FROM office_hour WHERE member_id = '$_SESSION[user_id]'";
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_array($result)) {
    $existing_hours[] = $row['day'] . '|' . $row['from_time'];
}
?>

<div class="post">
    
    <form method="post" role="form" class="php-email-form">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Time / Day</th>
                        <?php foreach ($days as $day): ?>
                            <th class="text-center"><?php echo $day; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($time_slots as $time_24 => $time_12): ?>
                        <tr>
                            <td class="font-weight-bold"><?php echo $time_12; ?></td>
                            <?php foreach ($days as $day): ?>
                                <td class="text-center align-middle">
                                    <?php
                                    $checkbox_value = $day . '|' . $time_24;
                                    $is_checked = in_array($checkbox_value, $existing_hours) ? 'checked' : '';
                                    ?>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input office-hour-checkbox" 
                                               type="checkbox" 
                                               name="office_hours[]" 
                                               value="<?php echo $checkbox_value; ?>"
                                               <?php echo $is_checked; ?>
                                               style="transform: scale(1.5);">
                                    </div>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <button type="submit" name="btn-submit" class="btn btn-primary">Save Office Hours</button>
            </div>
        </div>
    </form>
</div>

<style>
.table th {
    background-color: #343a40;
    color: white;
}
.form-check-input:checked {
    background-color: #28a745;
    border-color: #28a745;
}
.contact .php-email-form input {
  height: 14px;
}
</style>

<?php include 'footer.php';?>