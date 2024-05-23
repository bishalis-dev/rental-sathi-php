<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Rental Sathi - Vehicle Rental System</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="assets/css/style.css" type="text/css">
  <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
  <link rel="stylesheet" href="assets/css/slick.css" type="text/css">
  <link rel="stylesheet" href="assets/css/bootstrap-slider.min.css" type="text/css">
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
  <style>
    body {
      font-family: 'Lato', sans-serif;
      background-color: #f7f7f7;
      padding: 20px;
      color: #555;
    }
    .result-sorting-wrapper {
      background-color: #6c5ce7;
      color: #fff;
      padding: 10px;
      border-radius: 5px;
    }
    .product-listing-m {
      background-color: #fff;
      border: 1px solid #ddd;
      margin-top: 20px;
      padding: 20px;
      border-radius: 5px;
    }
    .product-listing-img img {
      width: 100%;
      height: auto;
      border-radius: 5px;
    }
    .product-listing-content {
      margin-top: 20px;
    }
    .btn {
      background-color: #6c5ce7;
      color: white;
      border: none;
    }
    .btn:hover {
      background-color: #5a51e6;
    }
    .sidebar_widget {
      background-color: #6c5ce7;
      padding: 20px;
      color: #fff;
      border-radius: 5px;
      margin-bottom: 20px;
    }
    .form-control {
      border-radius: 0;
    }
    .uppercase {
      text-transform: uppercase;
    }
  </style>
</head>

<body>
  <?php include('includes/header.php'); ?>

  <section class="listing-page">
    <div class="container">
      <div class="row">
        <div class="col-md-9">
          <div class="result-sorting-wrapper">
            <div class="sorting-count">
              <?php
              // Query for Listing count
              $brand = $_POST['brand'];
              $search_text = '%' . $_POST['carname'] . '%';
              $sql = "SELECT id from tblvehicles where VehiclesBrand=:brand and VehiclesTitle LIKE :searchTxt";
              $query = $dbh->prepare($sql);
              $query->bindParam(':brand', $brand, PDO::PARAM_STR);
              $query->bindParam(':searchTxt', $search_text, PDO::PARAM_STR);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);
              $cnt = $query->rowCount();
              ?>
              <p><center><?php echo htmlentities($cnt); ?> Cars Found</center></p>
            </div>
          </div>

          <?php
          $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid from tblvehicles join tblbrands on tblbrands.id = tblvehicles.VehiclesBrand where VehiclesBrand=:brand and VehiclesTitle LIKE :searchTxt";
          $query = $dbh->prepare($sql);
          $query->bindParam(':brand', $brand, PDO::PARAM_STR);
          $query->bindParam(':searchTxt', $search_text, PDO::PARAM_STR);
          $query->execute();
          $results = $query->fetchAll(PDO::FETCH_OBJ);
          if ($query->rowCount() > 0) {
            foreach ($results as $result) { ?>
              <div class="product-listing-m">
                <div class="product-listing-img">
                  <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" alt="Image" />
                </div>
                <div class="product-listing-content">
                  <h5><a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->BrandName); ?>, <?php echo htmlentities($result->VehiclesTitle); ?></a></h5>
                  <p class="list-price">$<?php echo htmlentities($result->PricePerDay); ?> Per Day</p>
                  <ul>
                    <li><i class="fa fa-user" aria-hidden="true"></i> <?php echo htmlentities($result->SeatingCapacity); ?> seats</li>
                    <li><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo htmlentities($result->ModelYear); ?> model</li>
                    <li><i class="fa fa-car" aria-hidden="true"></i> <?php echo htmlentities($result->FuelType); ?></li>
                  </ul>
                  <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>" class="btn">View Details</a>
                </div>
              </div>
            <?php }
          } else { ?>
            <p>No cars found matching your criteria.</p>
          <?php } ?>
        </div>

        <div class="col-md-3">
          <div class="sidebar_widget">
            <h5>Find Your Car</h5>
            <form action="search-carresult.php" method="post">
              <div class="form-group select">
                <select class="form-control" name="brand">
                  <option value="">Select Brand</option>
                  <?php 
                  $sql = "SELECT * from tblbrands";
                  $query = $dbh->prepare($sql);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  if ($query->rowCount() > 0) {
                    foreach ($results as $result) { ?>
                      <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->BrandName); ?></option>
                    <?php }
                  } ?>
                </select>
              </div>
              <div class="form-group select">
                <select class="form-control" name="fueltype">
                  <option value="">Select Fuel Type</option>
                  <option value="Petrol">Petrol</option>
                  <option value="Diesel">Diesel</option>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-block">Search</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include('includes/footer.php'); ?>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/slick.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>
