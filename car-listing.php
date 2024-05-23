<?php 
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Rental Sathi - Vehicle Rental System</title>
  <!--Bootstrap -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
  <!--Custom Style -->
  <link rel="stylesheet" href="assets/css/style.css" type="text/css">
  <!--OWL Carousel slider-->
  <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
  <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
  <!--slick-slider -->
  <link href="assets/css/slick.css" rel="stylesheet">
  <!--bootstrap-slider -->
  <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
  <!--FontAwesome Font Style -->
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
  <link href="https://fonts.googleapis.com/css2?family=Play&display=swap" rel="stylesheet">
  <style>
    div {
      font-family: 'Play', sans-serif;
      font-size: 20px;
      color: BLUE;
    }
  </style>
</head>

<body>
  <!--Header-->
  <?php include('includes/header.php'); ?>
  <!-- /Header -->
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-md-push-3">
        <div class="result-sorting-wrapper bg-main">
          <center><span>Choose Vehicle</span></center>
        </div>

        <?php $sql = "SELECT vehicles.*, brands.name as brand_name, brands.id as brand_id from vehicles join brands on brands.id = vehicles.vehicles_brand";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
          foreach ($results as $result) { ?>
            <div class="product-listing-m bg-main">
              <div class="product-listing-img"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->image1); ?>" class="img-responsive" alt="Image" /></div>
              <div class="product-listing-content">
                <h5><a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->brand_name); ?>, <?php echo htmlentities($result->vehicles_title); ?></a></h5>
                <p class="list-price">₹<?php echo htmlentities($result->price_per_day); ?> Per Day Rental</p>
                <ul>
                  <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->seating_capacity); ?> seats</li>
                  <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->model_year); ?> model</li>
                  <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->fuel_type); ?></li>
                </ul>
                <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>" class="btn" style="background-color:#fff; color: #442">View Details</a>
              </div>
            </div>
          <?php }
        } ?>
      </div>

      <aside class="col-md-3 col-md-pull-9">
        <div class="sidebar_widget bg-main">
          <div class="widget_heading">
            <h5 class="text-main"> Find Your Car </h5>
          </div>
          <div class="sidebar_filter">
            <form action="search-carresult.php" method="post">
              <div class="form-group">
                <input type="text" class="form-control" name="carname" placeholder="Search...">
              </div>
              <div class="form-group select">
                <select class="form-control" name="brand">
                  <option>Select Brand</option>
                  <?php $sql = "SELECT * from brands";
                  $query = $dbh->prepare($sql);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  if ($query->rowCount() > 0) {
                    foreach ($results as $result) { ?>
                      <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->name); ?></option>
                  <?php }
                  } ?>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-block" style="background-color:#fff; color:#442">SEARCH</button>
              </div>
            </form>
          </div>
        </div>
      </aside>
    </div>
  </div>
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
