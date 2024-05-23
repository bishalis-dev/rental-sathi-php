<header>
  <nav id="navigation_bar" class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <style>
          div {
            font-family: Play;
            font-size: 20px;
            color: white;
          }
        </style>

        <div class="user_login">
          Rental Sathi
          <?php if (strlen($_SESSION['login']) == 0) {  ?>
            <div class="login_btn"> <a href="#loginform" class="btn btn-xs uppercase bg-main" data-toggle="modal" data-dismiss="modal">Login / Register</a> </div>
          <?php } ?>
        </div>
        <div class="user_login">
          <ul>
            <?php if (strlen($_SESSION['login']) > 0) { ?>
              <li class="dropdown"> 
                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-user-circle" aria-hidden="true"></i>
                  <?php
                  $email = $_SESSION['login'];
                  $sql = "SELECT full_name FROM users WHERE email_id=:email ";
                  $query = $dbh->prepare($sql);
                  $query->bindParam(':email', $email, PDO::PARAM_STR);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                      echo htmlentities($result->full_name);
                    }
                  } ?>
                  <i class="fa fa-angle-down" aria-hidden="true"></i>
                </a>
                <ul class="dropdown-menu">
                  <?php if ($_SESSION['login']) { ?>
                    <li><a href="profile.php">Profile Settings</a></li>
                    <li><a href="update-password.php">Update Password</a></li>
                    <li><a href="my-booking.php">My Booking</a></li>
                    <li><a href="logout.php">Sign Out</a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>
          </ul>
        </div>
        <button id="menu_slide" data-target="#navigation" aria-expanded="false" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> 
          <span class="sr-only">Toggle navigation</span> 
          <span class="icon-bar"></span> 
          <span class="icon-bar"></span> 
          <span class="icon-bar"></span> 
        </button>
      </div>
      <div class="header_wrap">
        <div class="collapse navbar-collapse" id="navigation">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="car-listing.php">Cars</a></li>
            <li><a href="contact-us.php">Contact Us</a></li>
            <li><a href="page.php?type=aboutus">About Us</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</header>
