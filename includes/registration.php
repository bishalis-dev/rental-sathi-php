<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (isset($_POST['signup'])) {
  // Validate input fields
  if (empty($_POST['emailid']) || empty($_POST['fullname']) || empty($_POST['mobileno']) || empty($_POST['password']) || empty($_POST['confirmpassword'])) {
    echo "<script>alert('Please fill all the fields');</script>";
  } elseif (strlen($_POST['mobileno']) != 10) {
    echo "<script>alert('Mobile number should be exactly 10 digits');</script>";
  } elseif (strlen($_POST['fullname']) < 3) {
    echo "<script>alert('Name should be at least 3 characters');</script>";
  } else {
    // Assign variables
    $fname = $_POST['fullname'];
    $email = $_POST['emailid'];
    $mobile = $_POST['mobileno'];
    $password = md5($_POST['password']);
    $confirmpassword = md5($_POST['confirmpassword']);
    
    // Check if passwords match
    if ($password !== $confirmpassword) {
      echo "<script>alert('Passwords do not match');</script>";
    } else {
      // Prepare SQL to check if email already exists
      $sql = "SELECT email_id FROM users WHERE email_id = :email";
      $query = $dbh->prepare($sql);
      $query->bindParam(':email', $email, PDO::PARAM_STR);
      $query->execute();

      if ($query->rowCount() > 0) {
        echo "<script>alert('Email already exists. Please try another.');</script>";
      } else {
        // Prepare SQL for inserting new user
        $sql = "INSERT INTO users (full_name, email_id, contact_no, password) VALUES (:fname, :email, :mobile, :password)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
          echo "<script>alert('Registration successful. Now you can login');</script>";
        } else {
          echo "<script>alert('Something went wrong. Please try again');</script>";
        }
      }
    }
  }
}
?>

<script type="text/javascript">
  function valid() {
    if (document.signup.password.value != document.signup.confirmpassword.value) {
      alert("Password and Confirm Password Field do not match  !!");
      document.signup.confirmpassword.focus();
      return false;
    }
    return true;
  }
</script>

<div class="modal fade" id="signupform">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color:#a041fd;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" style="color:#f3f3f3;">MAKE MY ACCOUNT</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="signup_wrap">
            <div class="col-md-12 col-sm-6">
              <form method="post" name="signup" onSubmit="return valid();">
                <div class="form-group">
                  <input type="text" class="form-control" name="fullname" placeholder="Name" required="required">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="mobileno" placeholder="Contact Number" maxlength="10" required="required">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="emailid" id="emailid" onBlur="checkAvailability()" placeholder="Email Address" required="required">
                  <span id="user-availability-status" style="font-size:12px;"></span>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password" required="required">
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="terms_agree" required="required" checked="">
                  <label for="terms_agree" style="color:#fff;">I Agree with <a href="#" style="color:#442;">Terms and Conditions</a></label>
                </div>
                <div class="form-group">
                  <input type="submit" value="Sign Up" name="signup" id="submit" class="btn btn-block" style="background-color:#f3f3f3; color:#442">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p> <a href="#loginform" data-toggle="modal" data-dismiss="modal" style="color:#fff;">Already got an account...?</a></p>
      </div>
    </div>
  </div>
</div>
