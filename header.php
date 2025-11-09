<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Student Appointment System - Al-Jouf University</title>
  <meta content="Contact the Office Hours Platform support team at Al-Jouf University" name="description">
  <meta content="contact, support, office hours, faculty appointments" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/logo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <style>
    td, th {
      text-align: center;
    }
  </style>

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="index.php"><span>Student Appointment</span> System</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.php" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="index.php#services">Services & Features</a></li>
          <?php 
            if (isset($_SESSION ['user_id']) == "") { ?>
              <li><a href="login.php">Login</a></li>
            <?php
            } else { ?>
              <li class="dropdown"><a href="#"><span>Menu</span> <i class="bi bi-chevron-down"></i></a>
                <ul>
                  <?php if ($_SESSION ['user_type'] == "admin") { ?>
                    <li><a href="admin_show_students.php">Students</a></li>
                    <li><a href="admin_show_members.php">Faculty Members</a></li>
                    <li><a href="admin_show_reports.php">Reports</a></li>
                    <li><a href="admin_profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <?php } ?>
                    
                    <?php if ($_SESSION ['user_type'] == "student") { ?>
                      <li><a href="student_show_members.php">Faculty Members</a></li>
                      <li><a href="student_show_appointments.php">Appointments</a></li>
                      <li><a href="student_book_appointment.php">Book Appointment</a></li>
                      <li><a href="student_show_notifications.php">Notifications</a></li>
                      <li><a href="student_profile.php">Profile</a></li>
                      <li><a href="logout.php">Logout</a></li>
                    <?php } ?>
                    
                    <?php if ($_SESSION ['user_type'] == "faculty_member") { ?>
                      <li><a href="member_show_office_hours.php">Office Hours</a></li>
                      <li><a href="member_show_appointments.php">Appointments</a></li>
                      <li><a href="member_profile.php">Profile</a></li>
                      <li><a href="logout.php">Logout</a></li>
                    <?php } ?>

                  </ul>
                </li>
            <?php } ?>
          <li><a href="index.php#features">Features</a></li>
          <li><a href="contact.php" class="active">Contact</a></li>

        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?php echo $page_title;?></h2>
        </div>

      </div>
    </section><!-- End Breadcrumbs Section -->

    <section id="contact" class="contact">
      <div class="container">