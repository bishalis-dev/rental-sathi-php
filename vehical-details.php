<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Rental Sathi - Vehicle Rental System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <!-- OWL Carousel slider -->
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <!-- Slick Slider -->
    <link href="assets/css/slick.css" rel="stylesheet">
    <!-- Bootstrap Slider -->
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #f3f3f3;
        }
        .hero-section-slider div {
            border-radius: 8px;
            overflow: hidden;
        }
        .profile_wrap {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #6c5ce7;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #5a51e6;
        }
        .form-control {
            border-radius: 0;
        }
        .listing_detail_wrap .nav-tabs > li > a {
            color: #a041fd;
        }
        .listing_detail_wrap .nav-tabs > li.active > a {
            background-color: #a041fd;
            color: white;
        }
        .listing_detail_wrap .tab-content {
            background-color: white;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .sidebar_widget {
            background-color: #6c5ce7;
            padding: 20px;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (!isset($_SESSION['login'])) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $fromdate = $_POST['fromdate'];
        $todate = $_POST['todate'];
        $message = $_POST['message'];
        $user_email = $_SESSION['login'];
        $status = 0;
        $vhid = $_GET['vhid'];
        $sql = "INSERT INTO bookings (user_email, vehicle_id, start_date, end_date, message, status) VALUES (:user_email, :vhid, :fromdate, :todate, :message, :status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':user_email', $user_email, PDO::PARAM_STR);
        $query->bindParam(':vhid', $vhid, PDO::PARAM_INT);
        $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
        $query->bindParam(':todate', $todate, PDO::PARAM_STR);
        $query->bindParam(':message', $message, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            echo "<script>alert('Booking successful.');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    }
    $vhid = intval($_GET['vhid']);
    $sql = "SELECT vehicles.*, brands.name as brand_name from vehicles join brands on brands.id = vehicles.brand_id where vehicles.id = :vhid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':vhid', $vhid, PDO::PARAM_INT);
    $query->execute();
    // print_r($query);
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    echo $query->rowCount();
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['brndid'] = $result->bid;
            ?>
            <!-- Vehicle Details and Booking Form -->
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h2><?php echo htmlentities($result->brand_name) . ' ' . htmlentities($result->title); ?></h2>
                        <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" alt="Vehicle Image" class="img-responsive">
                        <!-- More vehicle details -->
                    </div>
                    <div class="col-md-4">
                        <div class="booking-form">
                            <h3>Book this vehicle</h3>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="fromdate">From Date:</label>
                                    <input type="date" class="form-control" name="fromdate" required>
                                </div>
                                <div class="form-group">
                                    <label for="todate">To Date:</label>
                                    <input type="date" class="form-control" name="todate" required>
                                </div>
                                <div class="form-group">
                                    <label for="message">Message (Optional):</label>
                                    <textarea class="form-control" name="message"></textarea>
                                </div>
                                <button type="submit" name="submit" class="btn btn-custom">Submit Booking</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
?>
<?php include('includes/footer.php'); ?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
