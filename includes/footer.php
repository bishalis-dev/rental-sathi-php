<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (isset($_POST['emailsubscribe'])) {
    $subscriberemail = $_POST['subscriberemail'];
    $sql = "SELECT subscriber_email FROM subscribers WHERE subscriber_email=:subscriberemail";
    $query = $dbh->prepare($sql);
    $query->bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        echo "<script>alert('Already Subscribed.');</script>";
    } else {
        $sql = "INSERT INTO subscribers (subscriber_email) VALUES (:subscriberemail)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            echo "<script>alert('Subscribed successfully.');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    }
}
?>

<footer>
  <div class="footer-top">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h6>About Us</h6>
          <ul>
            <li><a href="index.php">HOME</a></li>
            <li><a href="car-listing.php">CARS</a></li>
            <li><a href="contact-us.php">CONTACT US</a></li>
            <li><a href="page.php?type=aboutus">ABOUT US</a></li>
          </ul>
        </div>
        <div class="col-md-3 col-sm-6">
          <h6>Let's Keep in Touch</h6>
          <div class="newsletter-form">
            <form method="post">
              <div class="form-group">
                <input type="email" name="subscriberemail" class="form-control newsletter-input" required placeholder="Enter Your Email" />
              </div>
              <button type="submit" name="emailsubscribe" class="btn btn-block" style="background-color:#a041fd;">Subscribe</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom" style="background-color:#a041fd;">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-push-6 text-right">
        </div>
        <div class="col-md-6 col-md-pull-6">
          <center><p class="copy-right">Copyright &copy; 2020 AHNA car India Private Ltd. All rights reserved.</p></center>
        </div>
      </div>
    </div>
  </div>
</footer>
