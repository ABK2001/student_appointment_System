<?php
$page_title = "Faculty Members";
?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student") {
    header ( "Location: index.php" );
}
?>

<?php
// get all faculty members
$members_query = "SELECT * FROM faculty_member ORDER BY first_name, last_name";
$members_result = mysqli_query ($con,  $members_query ) or die ( 'error : ' . mysqli_error ($con) );
?>

<div class="container-fluid">

    <?php if (mysqli_num_rows($members_result) > 0): ?>
    <div class="row">
        <?php while ($member_row = mysqli_fetch_array($members_result)): 
            // Get office hours count for this member
            $hours_query = "SELECT COUNT(*) as hours_count FROM office_hour WHERE member_id = '{$member_row['id']}'";
            $hours_result = mysqli_query($con, $hours_query);
            $hours_data = mysqli_fetch_array($hours_result);
            $office_hours_count = $hours_data['hours_count'];
        ?>
        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
            <div class="card faculty-card h-100 shadow-sm border-0" data-aos="fade-up">
                <div class="card-header bg-gradient-primary text-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title mb-1"><?php echo $member_row['first_name'] . ' ' . $member_row['last_name']; ?></h4>
                            <p class="card-subtitle mb-0 opacity-75"><?php echo $member_row['speciality']; ?></p>
                        </div>
                        <div class="faculty-avatar">
                            <div class="avatar-circle bg-white text-primary">
                                <?php echo substr($member_row['first_name'], 0, 1) . substr($member_row['last_name'], 0, 1); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="faculty-info mb-3">
                        <div class="info-item d-flex align-items-center mb-2">
                            <i class="fas fa-graduation-cap text-primary me-3"></i>
                            <div>
                                <small class="text-muted">Department</small>
                                <div class="fw-bold"><?php echo $member_row['department']; ?></div>
                            </div>
                        </div>
                        
                        <div class="info-item d-flex align-items-center mb-2">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <div>
                                <small class="text-muted">Email</small>
                                <div class="fw-bold"><?php echo $member_row['email']; ?></div>
                            </div>
                        </div>
                        
                        <div class="info-item d-flex align-items-center mb-2">
                            <i class="fas fa-phone text-primary me-3"></i>
                            <div>
                                <small class="text-muted">Mobile</small>
                                <div class="fw-bold"><?php echo $member_row['mobile']; ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="office-hours-indicator">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-<?php echo $office_hours_count > 0 ? 'success' : 'secondary'; ?>">
                                <i class="fas fa-clock me-1"></i>
                                <?php echo $office_hours_count; ?> Office Hour<?php echo $office_hours_count != 1 ? 's' : ''; ?> Available
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-transparent border-0 pt-0">
                    <div class="d-grid gap-2">
                        <a href="student_view_member_office_hours.php?member_id=<?php echo $member_row['id']; ?>" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-calendar-alt me-2"></i>View Office Hours
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">No Faculty Members Found</h3>
                <p class="text-muted">There are currently no faculty members in the system.</p>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.faculty-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.faculty-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.faculty-avatar .avatar-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
}

.info-item i {
    width: 20px;
    text-align: center;
}

.faculty-info {
    border-left: 3px solid #007bff;
    padding-left: 15px;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5em 0.75em;
}

.btn-outline-primary {
    border-radius: 25px;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    transform: scale(1.05);
}

.page-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem !important;
}
</style>

<?php include 'footer.php';?>