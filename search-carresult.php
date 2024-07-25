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
        <div class="col-md-9 m-auto">
          <div class="result-sorting-wrapper">
            <div class="sorting-count m-auto">
              <?php
              // Query for Listing count
              $brand = $_POST['brand'];
              $search_text = '%' . $_POST['carname'] . '%';
              $sql = "SELECT id from vehicles where vehicles_brand=:brand and vehicles_title LIKE :searchTxt";
              $query = $dbh->prepare($sql);
              $query->bindParam(':brand', $brand, PDO::PARAM_STR);
              $query->bindParam(':searchTxt', $search_text, PDO::PARAM_STR);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);
              $cnt = $query->rowCount();
              ?>
              <p>
                <center><?php echo htmlentities($cnt); ?> Cars Found</center>
              </p>
            </div>
          </div>

          <?php
          $sql = "SELECT vehicles.*, brands.name, brands.id as bid from vehicles join brands on brands.id = vehicles.vehicles_brand where vehicles_brand=:brand and vehicles_title LIKE :searchTxt and vehicles.isBooked=0";
          $query = $dbh->prepare($sql);
          $query->bindParam(':brand', $brand, PDO::PARAM_STR);
          $query->bindParam(':searchTxt', $search_text, PDO::PARAM_STR);
          $query->execute();
          $results = $query->fetchAll(PDO::FETCH_OBJ);
          // print_r($results);
          if ($query->rowCount() > 0) {
            foreach ($results as $result) { ?>
              <div class="product-listing-m">
                <div class="product-listing-img">
                  <img src="admin/img/vehicleimages/<?php echo htmlentities($result->image1); ?>" alt="Image" />
                </div>
                <div class="product-listing-content" style="color:black;">
                  <h5><a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>" style="color: #5a51e6!important;"><?php echo htmlentities($result->name); ?>, <?php echo htmlentities($result->vehicles_title); ?></a></h5>
                  <p class="list-price">$<?php echo htmlentities($result->price_per_day); ?> Per Day</p>
                  <ul>
                    <li><i class="fa fa-user" aria-hidden="true"></i> <?php echo htmlentities($result->seating_capacity); ?> seats</li>
                    <li><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo htmlentities($result->model_year); ?> model</li>
                    <li><i class="fa fa-car" aria-hidden="true"></i> <?php echo htmlentities($result->fuel_type); ?></li>
                  </ul>
                  <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>" class="btn">View Details</a>
                </div>
              </div>
            <?php }
          } else { ?>
            <p>No cars found matching your criteria.</p>
          <?php } ?>
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