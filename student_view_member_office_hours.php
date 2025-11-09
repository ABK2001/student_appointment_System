<?php
$page_title = "Faculty Member Office Hours";
?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student") {
    header ( "Location: index.php" );
}
?>

<?php
// Get member details
$member_id = mysqli_real_escape_string($con, $_GET['member_id']);
?>

<?php
// Get office hours for this member
$office_hours_query = "SELECT * FROM office_hour WHERE member_id = '$member_id' ORDER BY 
    FIELD(day, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'), from_time";
$office_hours_result = mysqli_query($con, $office_hours_query);

// Group office hours by day
$office_hours_by_day = [
    'Sunday' => [],
    'Monday' => [],
    'Tuesday' => [],
    'Wednesday' => [],
    'Thursday' => []
];

while ($hour_row = mysqli_fetch_array($office_hours_result)) {
    $office_hours_by_day[$hour_row['day']][] = [
        'from_time' => $hour_row['from_time'],
        'to_time' => $hour_row['to_time'],
        'time_display' => date('g:i A', strtotime($hour_row['from_time'])) . ' - ' . date('g:i A', strtotime($hour_row['to_time']))
    ];
}
?>

<div class="container-fluid">

    <!-- Office Hours Calendar -->
    <div class="row">
        <?php 
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];
        $time_slots = [
            '08:00:00' => '8:00 AM', '09:00:00' => '9:00 AM', '10:00:00' => '10:00 AM',
            '11:00:00' => '11:00 AM', '12:00:00' => '12:00 PM', '13:00:00' => '1:00 PM',
            '14:00:00' => '2:00 PM', '15:00:00' => '3:00 PM', '16:00:00' => '4:00 PM'
        ];
        
        foreach ($days as $day): 
            $day_hours = $office_hours_by_day[$day];
        ?>
        <div class="col-xl-2 col-lg-4 col-md-6 col-12 mb-4">
            <div class="card day-card h-100 shadow-sm border-0" data-aos="fade-up">
                <div class="card-header bg-light py-3 border-0">
                    <h5 class="card-title mb-0 text-center text-dark">
                        <i class="fas fa-calendar-day me-2 text-primary"></i><?php echo $day; ?>
                    </h5>
                </div>
                
                <div class="card-body p-0">
                    <?php if (!empty($day_hours)): ?>
                        <div class="time-slots-container">
                            <?php foreach ($day_hours as $slot): ?>
                                <div class="time-slot-item bg-success text-white p-3 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-clock me-2"></i>
                                            <strong><?php echo $slot['time_display']; ?></strong>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-times-circle fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No office hours</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="card-footer bg-transparent border-0 text-center">
                    <small class="text-muted">
                        <?php echo count($day_hours); ?> slot<?php echo count($day_hours) != 1 ? 's' : ''; ?> available
                    </small>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.day-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.day-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1) !important;
}

.time-slot-item {
    transition: all 0.3s ease;
    border-left: 4px solid #28a745 !important;
}

.time-slot-item:hover {
    background-color: #218838 !important;
    transform: scale(1.02);
}

.avatar-circle-sm {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1rem;
}

.icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 1.2rem;
}

.time-slots-container {
    max-height: 300px;
    overflow-y: auto;
}

/* Custom scrollbar for time slots */
.time-slots-container::-webkit-scrollbar {
    width: 6px;
}

.time-slots-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.time-slots-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.time-slots-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.badge.fs-6 {
    font-size: 1rem !important;
}

.card-header.bg-light {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
}
</style>

<?php include 'footer.php';?>