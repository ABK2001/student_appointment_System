<?php $page_title = "Book Appointment"; ?>
<?php include 'header.php'; ?>

<?php
// Must be logged in as student
if ($_SESSION['user_type'] != "student") {
    header("Location: index.php");
    exit;
}

$student_id = $_SESSION['user_id'];
$step = $_GET['step'] ?? 1;
$errors = [];

// Step 1: Select Faculty, Date, Purpose
if ($step == 1 && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = (int)$_POST['member_id'];
    $date      = $_POST['date'];
    $purpose   = trim($_POST['purpose']);

    // Validation
    if ($member_id <= 0) $errors[] = "Please select a faculty member.";
    if (strtotime($date) < strtotime('today')) $errors[] = "Cannot book past dates.";
    if (empty($purpose)) $errors[] = "Purpose is required.";

    if (empty($errors)) {
        // Save to session and go to step 2
        $_SESSION['booking'] = [
            'member_id' => $member_id,
            'date'      => $date,
            'purpose'   => $purpose
        ];
        header("Location: student_book_appointment.php?step=2");
        exit;
    }
}

// Step 2: Show Available Office Hours
if ($step == 2) {
    $booking = $_SESSION['booking'] ?? null;
    if (!$booking) {
        header("Location: student_book_appointment.php?step=1");
        exit;
    }

    $member_id = (int)$booking['member_id'];
    $date      = $booking['date'];

    // Get faculty name
    $faculty_query = "SELECT first_name, last_name FROM faculty_member WHERE id = '$member_id'";
    $faculty_result = mysqli_query($con, $faculty_query);
    $faculty = mysqli_fetch_array($faculty_result);
    if (!$faculty) {
        die("Faculty not found.");
    }
    $faculty_name = htmlspecialchars($faculty['first_name'] . ' ' . $faculty['last_name']);

    // Get office hours for this member on this day
    $day_name = date('l', strtotime($date)); // e.g., Monday

    $office_query = "
        SELECT oh.id, oh.from_time, oh.to_time
        FROM office_hour oh
        WHERE oh.member_id = '$member_id'
          AND oh.day = '$day_name'
          AND oh.id NOT IN (
              SELECT a.office_hour_id 
              FROM appointment a 
              WHERE a.date = '$date' 
                AND a.status IN ('Pending', 'Approved')
          )
        ORDER BY oh.from_time
    ";
    $office_result = mysqli_query($con, $office_query) or die('error: ' . mysqli_error($con));
}

// Step 3: Confirm and Book
if ($step == 3 && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking = $_SESSION['booking'] ?? null;
    $office_hour_id = (int)$_POST['office_hour_id'];

    if (!$booking || $office_hour_id <= 0) {
        header("Location: student_book_appointment.php?step=1");
        exit;
    }

    $member_id = (int)$booking['member_id'];
    $date      = $booking['date'];
    $purpose   = $booking['purpose'];

    // Double-check slot is still available
    $check_query = "
        SELECT 1 FROM appointment 
        WHERE office_hour_id = '$office_hour_id' 
          AND date = '$date' 
          AND status IN ('Pending', 'Approved')
    ";
    $check_result = mysqli_query($con, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $errors[] = "This time slot is no longer available.";
    }

    if (empty($errors)) {
        // Insert appointment
        $insert_query = "
            INSERT INTO appointment 
                (student_id, member_id, office_hour_id, date, purpose, status)
            VALUES 
                ('$student_id', '$member_id', '$office_hour_id', '$date', '$purpose', 'Pending')
        ";
        mysqli_query($con, $insert_query) or die('error: ' . mysqli_error($con));

        $appointment_id = mysqli_insert_id($con);

        // Create notification
        $notif_content = "Your appointment request has been submitted and is pending approval.";
        $notif_query = "
            INSERT INTO notification (student_id, appointment_id, content)
            VALUES ('$student_id', '$appointment_id', '$notif_content')
        ";
        mysqli_query($con, $notif_query);

        // Clear session
        unset($_SESSION['booking']);

        // Redirect to appointments page
        header("Location: student_show_appointments.php");
        exit;
    }
}
?>

<div class="post">
    <h3>Book Appointment - Step <?php echo $step; ?> of 3</h3>

    <!-- Step 1: Select Faculty, Date, Purpose -->
    <?php if ($step == 1): ?>
        <form method="post" action="">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label>Faculty Member</label>
                <select name="member_id" class="form-control" required>
                    <option value="">-- Select Faculty Member --</option>
                    <?php
                    $faculty_query = "SELECT id, first_name, last_name, department FROM faculty_member ORDER BY last_name";
                    $faculty_result = mysqli_query($con, $faculty_query);
                    while ($f = mysqli_fetch_array($faculty_result)) {
                        $name = htmlspecialchars($f['first_name'] . ' ' . $f['last_name']);
                        $dept = htmlspecialchars($f['department']);
                        echo "<option value='{$f['id']}'>$name ($dept)</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Date</label>
                <input type="date" name="date" class="form-control" 
                       min="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="mb-3">
                <label>Purpose</label>
                <input type="text" name="purpose" class="form-control" 
                       placeholder="e.g., Project Discussion" maxlength="50" required>
            </div>

            <button type="submit" class="btn btn-primary">Next</button>
        </form>
    <?php endif; ?>

    <!-- Step 2: Show Available Time Slots -->
    <?php if ($step == 2): ?>
        <p><strong>Faculty Member:</strong> <?php echo $faculty_name; ?></p>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($date); ?> (<?php echo $day_name; ?>)</p>
        <p><strong>Purpose:</strong> <?php echo htmlspecialchars($booking['purpose']); ?></p>

        <hr>

        <?php if (mysqli_num_rows($office_result) == 0): ?>
            <p class="text-danger">No available office hours on this date.</p>
            <a href="student_book_appointment.php?step=1" class="btn btn-secondary">← Back</a>
        <?php else: ?>
            <form method="post" action="student_book_appointment.php?step=3">
                <table class="table table-bordered">
                    <tr>
                        <th>Select</th>
                        <th>Time Slot</th>
                    </tr>
                    <?php while ($oh = mysqli_fetch_array($office_result)): ?>
                        <tr>
                            <td class="text-center">
                                <input type="radio" name="office_hour_id" value="<?php echo $oh['id']; ?>" required>
                            </td>
                            <td>
                                <?php
                                $from = date("g:i A", strtotime($oh['from_time']));
                                $to   = date("g:i A", strtotime($oh['to_time']));
                                echo "$from - $to";
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>

                <button type="submit" class="btn btn-success">Book Appointment</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Step 3: Confirmation (optional flash) -->
    <?php if ($step == 3 && !empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
        </div>
        <a href="student_book_appointment.php?step=2" class="btn btn-secondary">← Try Again</a>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>