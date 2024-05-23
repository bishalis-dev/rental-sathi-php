<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
} else {
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rental Sathi - Vehicle Rental System</title>
    <!-- Bootstrap and Custom Styles -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/slick.css" type="text/css">
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #9370DB;
            color: white;
            margin: 0;
            padding: 0;
            height: 100vh;
        }
        .booking-list > li {
            list-style-type: none;
            padding: 20px;
            background: #6A5ACD;
            border-radius: 8px;
            width: 80%;
            height: 130px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .vehicle_img img {
            width: 150px;
            height: auto;
        }
        .confirmed, .cancelled, .not-confirmed {
            font-size: 12px;
            color: #32CD32;
            padding: 7px;
            border-radius: 5px;
            text-decoration: none;
        }
        .cancelled {
            color: #ff4500;
            background-color: #fff;
        }
        .not-confirmed {
            color: #1e90ff;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php include('includes/header.php'); ?>

    <div class="container" style="margin-top: 25px;">
        <div class="row">
            <div class="col-md-3">
                <?php include('includes/sidebar.php'); ?>
            </div>
            <div class="col-md-9" style="background-color: #a041fd;">
                <div class="profile_wrap">
                    <h5 class="uppercase underline" style="background-color:#f3f3f3; text-align: center;">My Bookings</h5>
                    <ul class="booking-list">
                    <?php
                    $useremail = $_SESSION['login'];
                    $sql = "SELECT vehicles.image1 as Vimage1, vehicles.title, vehicles.id as vid, brands.name as BrandName, bookings.start_date, bookings.end_date, bookings.message, bookings.status FROM bookings JOIN vehicles ON bookings.vehicle_id = vehicles.id JOIN brands ON brands.id = vehicles.vehicles_brand WHERE bookings.user_email = :useremail";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) { ?>
                            <li>
                                <div class="vehicle_img">
                                    <a href="vehical-details.php?vhid=<?php echo htmlentities($result->vid); ?>">
                                        <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" alt="image">
                                    </a>
                                </div>
                                <div class="vehicle_title">
                                    <h6>
                                        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->vid); ?>" style="color:white;">
                                            <?php echo htmlentities($result->BrandName); ?>, <?php echo htmlentities($result->title); ?>
                                        </a>
                                    </h6>
                                    <p><b>From Date:</b> <?php echo htmlentities($result->start_date); ?><br />
                                    <b>To Date:</b> <?php echo htmlentities($result->end_date); ?></p>
                                </div>
                                <div class="vehicle_status">
                                    <?php if ($result->status == 1) { ?>
                                        <a href="#" class="confirmed" style="background-color:#32CD32;">CONFIRMED</a>
                                    <?php } elseif ($result->status == 2) { ?>
                                        <a href="#" class="cancelled">CANCELLED</a>
                                    <?php } else { ?>
                                        <a href="#" class="not-confirmed">Not Confirmed</a>
                                    <?php } ?>
                                </div>
                                <div style="float: left; color:white;margin-top: 10px;">
                                    <p><b>Message:</b> <?php echo htmlentities($result->message); ?></p>
                                </div>
                            </li>
                        <?php }
                    } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>
<?php } ?>
