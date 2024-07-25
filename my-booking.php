<?php
session_start();
error_reporting(1);
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
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <title>Rental Sathi - Vehicle Rental System</title>
        <!--Bootstrap -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
        <!--Custome Style -->
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
        <!-- Google-Font-->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #9370DB;
                color: white;
                margin: 0;
                padding: 0;
                height: 100vh;
            }

            /* .container {
                width: 90%;
                margin: 20px auto;
                display: flex;
                flex-direction: column;
            } */

            .approved {
                background-color: green;
                color: #fff !important;
                display: inline-block;
            }

            .pending {
                color: #fff !important;
                background-color: orange;
                display: inline-block;
            }

            .booking-card {
                display: flex;
                align-items: center;
                background-color: #fff;
                margin-bottom: 20px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                overflow: hidden;
            }

            .vehicle-image {
                width: 35%;
                object-fit: cover;
                border-right: 1px solid #eee;
            }

            .booking-info {
                padding: 20px;
                flex-grow: 1;
            }

            .booking-info h5 {
                color: #333;
                margin-bottom: 10px;
            }

            .booking-info p {
                margin: 5px 0;
                color: #666;
            }

            .status {
                font-weight: bold;
                padding: 5px 10px;
                border-radius: 5px;
                color: #fff;
            }

            .status.confirmed {
                background-color: green;
            }

            .status.cancelled {
                background-color: red;
            }

            .status.pending {
                background-color: orange;
            }
        </style>
    </head>

    <body style="background-color:#fff;">
        <!--Header-->
        <?php include('includes/header.php'); ?>
        <!-- /Header -->

        <div class="row" style="margin-top: 25px;;">
            <div class="col-md-3 col-sm-3">
                <?php include('includes/sidebar.php'); ?>
                <div class="col-md-6 col-sm-8" style="background-color: #a041fd;">
                    <div class="profile_wrap">
                        <center>
                            <h5 class="uppercase underline" style="background-color:#f3f3f3;">MY BOOKING</h5>
                        </center>
                        <?php
                        $useremail = $_SESSION['login'];
                        $sql = "SELECT vehicles.image1 as Vimage1, vehicles.price_per_day, vehicles.vehicles_title, vehicles.id as vid, brands.name as BrandName, bookings.start_date, bookings.end_date, bookings.message, bookings.status FROM bookings JOIN vehicles ON bookings.vehicle_id = vehicles.id JOIN brands ON brands.id = vehicles.vehicles_brand WHERE bookings.user_email = :useremail ORDER BY bookings.id DESC";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) {
                                $startDate = new DateTime($result->start_date);
                                $endDate = new DateTime($result->end_date);
                                $interval = $startDate->diff($endDate);
                                $totalDays = $interval->days + ($interval->h / 24) + ($interval->i / 1440) + ($interval->s / 86400);
                                $totalDays = number_format($totalDays, 2);
                                // print_r($result);
                                // $totalDays = $result->
                        ?>
                                <div class="booking-card">
                                    <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" alt="Vehicle Image" class="vehicle-image">
                                    <div class="booking-info">
                                        <h5 style="display:flex; justify-content: space-between;"><?php echo htmlentities($result->vehicles_title) . '<span>' . ' Rs. ' . $result->price_per_day * $totalDays . '</span>';  ?></h5>
                                        <p><strong>From:</strong> <?php echo date('d M Y', strtotime(htmlentities($result->start_date))); ?></p>
                                        <p><strong>To:</strong> <?php echo date('d M Y', strtotime(htmlentities($result->end_date))); ?></p>
                                        <p class="status <?php echo $result->status ? "approved" : "pending"; ?>">
                                            <?php echo htmlentities($result->status ? "Approved! Please carry your id card during pickup." : "Pending"); ?>
                                        </p>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <br /><br />
        <?php include('includes/footer.php'); ?>
        <!-- Scripts -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/interface.js"></script>
        <!--bootstrap-slider-JS-->
        <script src="assets/js/bootstrap-slider.min.js"></script>
        <!--Slider-JS-->
        <script src="assets/js/slick.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
    </body>

    </html>
<?php } ?>