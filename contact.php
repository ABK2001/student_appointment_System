<?php $page_title = "Contact Us";?>

<?php include 'header.php';?>

<div class="map-section">
  <div class="map-section">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13825.123456789012!2d40.12345678901234!3d29.98765432109876!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjnCsDU5JzE1LjYiTiA0MMKwMDcnMzQuMyJF!5e0!3m2!1sen!2ssa!4v1234567890123!5m2!1sen!2ssa" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
</div>

<section id="contact" class="contact">
  <div class="container">

    <div class="row justify-content-center" data-aos="fade-up">

      <div class="col-lg-10">

        <div class="info-wrap">
          <div class="row">
            <div class="col-lg-4 info">
              <i class="bi bi-geo-alt"></i>
              <h4>Location:</h4>
              <p>Al-Jouf University<br>Sakaka, Al Jouf, Saudi Arabia</p>
            </div>

            <div class="col-lg-4 info mt-4 mt-lg-0">
              <i class="bi bi-envelope"></i>
              <h4>Email:</h4>
              <p>student_appointment@ju.edu.sa<br>support@student_appointment.edu.sa</p>
            </div>

            <div class="col-lg-4 info mt-4 mt-lg-0">
              <i class="bi bi-phone"></i>
              <h4>Call:</h4>
              <p>+966 14 624 0000<br>+966 14 624 1111</p>
            </div>
          </div>
        </div>

      </div>

    </div>

    <div class="row mt-5 justify-content-center" data-aos="fade-up">
      <div class="col-lg-10">
        <form action="#" method="post" role="form" class="php-email-form">
          <div class="row">
            <div class="col-md-6 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
            </div>
            <div class="col-md-6 form-group mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
            </div>
          </div>
          <div class="form-group mt-3">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
          </div>
          <div class="form-group mt-3">
            <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
          </div>
          <div class="text-center"><button type="submit">Send Message</button></div>
        </form>
      </div>

    </div>

  </div>
</section><!-- End Contact Section -->

<?php include 'footer.php'; ?>