<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = md5(trim($_POST['password']));

    // Validate input fields
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please enter both email and password');</script>";
    } else if (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters');</script>";
    } else {
        // Prepare SQL statement to prevent SQL injection
        $sql = "SELECT email_id, password, full_name FROM users WHERE email_id = :email AND password = :password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetch(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            echo $_SESSION['login'] = $email;
            $_SESSION['fname'] = $results->full_name;
            $currentpage = $_SERVER['REQUEST_URI'];
            echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";
        } else {
            echo "<script>alert('Invalid login details');</script>";
        }
    }
}
?>

<div class="modal fade" id="loginform">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color: #a041fd;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" style="color:#f3f3f3;">SIGN IN</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="login_wrap">
            <div class="col-md-12 col-sm-6">
              <form method="post">
                <div class="form-group">
                  <input type="email" class="form-control" name="email" placeholder="Enter Email Address" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="remember">
                  <label for="remember">Remember Me</label>
                </div>
                <div class="form-group">
                  <input type="submit" name="login" value="Sign In" class="btn btn-block" style="background-color:#f3f3f3; color: #442">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div>
        <p class="text-center">
          <a href="#forgotpassword" data-toggle="modal" data-dismiss="modal" style="color:#fff;">Forgot Password...?</a>
          &nbsp; | &nbsp;
          <a href="#signupform" data-toggle="modal" data-dismiss="modal" style="color:#fff;">Make My Account...</a>
        </p>
      </div>
    </div>
  </div>
</div>
