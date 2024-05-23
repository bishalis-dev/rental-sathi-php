<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_POST['send'])) {
  $name = $_POST['fullname'];
  $email = $_POST['email'];
  $contactno = $_POST['contactno'];
  $message = $_POST['message'];
  // Updated table and column names to snake case
  $sql = "INSERT INTO contact_queries (name, email_id, contact_number, message) VALUES (:name, :email, :contactno, :message)";
  $query = $dbh->prepare($sql);
  $query->bindParam(':name', $name, PDO::PARAM_STR);
  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->bindParam(':contactno', $contactno, PDO::PARAM_STR);
  $query->bindParam(':message', $message, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbh->lastInsertId();
  if ($lastInsertId) {
    $msg = "Query Sent. We will contact you shortly";
  } else {
    $error = "Something went wrong. Please try again";
  }
}
?>

<html>
<head>
  <title>Rental Sathi - Vehicle Rental System</title>
  <!-- Styles and Scripts include -->
</head>

<body style="background-color:#fff;">
  <!--Header-->
  <?php include('includes/header.php'); ?>
  <!-- /Header -->

  <section class="contact_us section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h3 style="color: #a041fd;">REACH US</h3>
          <div class="contact_detail">
            <?php
            $sql = "SELECT address, email_id, contact_no FROM contact_us_info";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
              foreach ($results as $result) { ?>
                <ul>
                  <li>
                    <div class="icon_wrap"><i class="fa fa-map-marker" aria-hidden="true" style="color:blue;"></i></div>
                    <div class="contact_info_m" style="color:blue;"><?php echo htmlentities($result->address); ?></div>
                  </li>
                  <li>
                    <div class="icon_wrap"><i class="fa fa-envelope-o" aria-hidden="true" style="color:blue;"></i></div>
                    <div class="contact_info_m" style="color:blue;"><a href="mailto:<?php echo htmlentities($result->email_id); ?>" style="color:blue;"><?php echo htmlentities($result->email_id); ?></a></div>
                  </li>
                  <li>
                    <div class="icon_wrap"><i class="fa fa-phone" aria-hidden="true" style="color:blue;"></i></div>
                    <div class="contact_info_m"><a href="tel:<?php echo htmlentities($result->contact_no); ?>" style="color:blue;"><?php echo htmlentities($result->contact_no); ?></a></div>
                  </li>
                </ul>
            <?php }
            } ?>
          </div>
        </div>

        <div class="col-md-6">
          <h3 style="color:blue;">LET'S KEEP IN TOUCH</h3>
          <?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } elseif ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
          <div class="contact_form gray-bg" style="background-color:black;">
            <form method="post">
              <!-- Input fields -->
              <div class="form-group">
                <button class="btn" type="submit" name="send" style="background-color:blue;">ASK US</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /Contact-us-->

  <!--Footer -->
  <?php include('includes/footer.php'); ?>
  <!-- /Footer-->

  <!--Login-Form -->
  <?php include('includes/login.php'); ?>
  <!--/Login-Form -->
  <!--Register-Form -->
  <?php include('includes/registration.php'); ?>
  <!--Forgot-password-Form -->
  <?php include('includes/forgotpassword.php'); ?>

  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/interface.js"></script>
  <!--Switcher-->
  <script src="assets/switcher/js/switcher.js"></script>
  <!--bootstrap-slider-JS-->
  <script src="assets/js/bootstrap-slider.min.js"></script>
  <!--Slider-JS-->
  <script src="assets/js/slick.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
</body>
</html>
