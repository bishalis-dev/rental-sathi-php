<?php
session_start();
include('includes/config.php');
error_reporting(1);
// get isBooked status and if 0 then show not available message
$vhid = intval($_GET['vhid']);
$sql = "SELECT isBooked FROM vehicles WHERE id = :vhid";
$query = $dbh->prepare($sql);
$query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
foreach ($results as $result) {
    $isBooked = $result->isBooked;
}
if ($isBooked == 1) {
    echo "<script>alert('This vehicle is already booked.');</script>";
    echo "<script>window.location.href='index.php'</script>";
}
if (isset($_POST['submit'])) {
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $message = $_POST['message'];
    $useremail = $_SESSION['login'];
    $status = 0;
    $vhid = $_GET['vhid'];
    $sql = "INSERT INTO bookings (user_email, vehicle_id, start_date, end_date, message, status) VALUES (:useremail, :vhid, :fromdate, :todate, :message, :status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
    $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        // update vehicles isBooked = 1
        $sql = "UPDATE vehicles SET isBooked = 1 WHERE id = :vhid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
        $query->execute();

        echo "<script>alert('Booking successful.');</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again');</script>";
    }
}

?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta charset="UTF-8">

    <title>Rental Sathi | Vehicle Rental System</title>
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

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .price {
            font-family: 'Roboto', sans-serif;
            ;
        }
    </style>

</head>

<body>

    <!--Header-->
    <?php include('includes/header.php'); ?>
    <!-- /Header -->

    <!--Listing-Image-Slider-->

    <?php
    $vhid = intval($_GET['vhid']);
    $sql = "SELECT vehicles.*, brands.name as brand_name from vehicles join brands on brands.id = vehicles.vehicles_brand where vehicles.id = :vhid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    $query->rowCount();
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['brndid'] = $result->vehicles_brand;
    ?>

            <section id="listing_img_slider">
                <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->image1); ?>" class="img-responsive" alt="image" width="900" height="400"></div>
                <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->image2); ?>" class="img-responsive" alt="image" width="900" height="560"></div>
                <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->image3); ?>" class="img-responsive" alt="image" width="900" height="560"></div>
                <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->image4); ?>" class="img-responsive" alt="image" width="900" height="560"></div>
                <?php if ($result->Vimage5 == "") {
                } else {
                ?>
                    <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage5); ?>" class="img-responsive" alt="image" width="900" height="560"></div>
                <?php } ?>
            </section>
            <!--/Listing-Image-Slider-->


            <!--Listing-detail-->
            <section class="listing-detail">
                <div class="container">
                    <div class="listing_detail_head row">
                        <div class="col-md-9">
                            <h2 style=" color:aqua;"><?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?></h2>
                        </div>
                        <div class="col-md-3">
                            <div class="price_info price" style=" color:#442;">
                                <p style="color:#442;">Rs. <?php echo htmlentities($result->price_per_day); ?> </p>Per Day Rental

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="main_features">
                                <ul>

                                    <li style="background-color:#a041fd;"> <i class="fa fa-calendar" aria-hidden="true" style="color:#fff;"></i>
                                        <h5><?php echo htmlentities($result->model_year); ?></h5>
                                        <p style="color:#fff;">Reg.Year</p>
                                    </li>
                                    <li style="background-color:#a041fd;"> <i class="fa fa-cogs" aria-hidden="true" style="color:#fff;"></i>
                                        <h5><?php echo htmlentities($result->fuel_type); ?></h5>
                                        <p style="color:#fff;">Fuel Type</p>
                                    </li>

                                    <li style="background-color:#a041fd;"> <i class="fa fa-user-plus" aria-hidden="true" style="color:#fff;"></i>
                                        <h5><?php echo htmlentities($result->seating_capacity); ?></h5>
                                        <p style="color:#fff;">Seats</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="listing_more_info" style="color:#fff;">
                                <div class="listing_detail_wrap" style="background-color:aqua;">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs gray-bg" role="tablist">
                                        <li role="presentation" class="active"><a href="#vehicle-overview " aria-controls="vehicle-overview" role="tab" data-toggle="tab" style="color:#fff;">Vehicle Overview </a></li>

                                        <li role="presentation"><a href="#accessories" aria-controls="accessories" role="tab" data-toggle="tab" style="color:#fff;">Accessories</a></li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content" style="background-color:#a041fd;">
                                        <!-- vehicle-overview -->
                                        <div role="tabpanel" class="tab-pane active" id="vehicle-overview">

                                            <p><?php echo htmlentities($result->vehicles_overview); ?></p>
                                        </div>


                                        <!-- Accessories -->
                                        <div role="tabpanel" class="tab-pane" id="accessories">
                                            <!--Accessories-->
                                            <table style="background-color:#fff;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2" style="color:#442;">Accessories</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Air Conditioner</td>
                                                        <?php if ($result->air_conditioner >= 1) {
                                                        ?>
                                                            <td><i class="fa fa-check" aria-hidden="true" style="color:#442;"></i></td>
                                                        <?php } else { ?>
                                                            <td><i class="fa fa-close" aria-hidden="true" style="color:#442;"></i></td>
                                                        <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <td>AntiLock Braking System</td>
                                                        <?php if ($result->anti_lock_braking_system >= 1) {
                                                        ?>
                                                            <td><i class="fa fa-check" aria-hidden="true" style="color:#442;"></i></td>
                                                        <?php } else { ?>
                                                            <td><i class="fa fa-close" aria-hidden="true" style="color:#442;"></i></td>
                                                        <?php } ?>
                                                    </tr>


                                                    <tr>
                                                        <td>Power Door Locks</td>
                                                        <?php if ($result->power_door_locks >= 1) {
                                                        ?>
                                                            <td><i class="fa fa-check" aria-hidden="true" style="color:#442;"></i></td>
                                                        <?php } else { ?>
                                                            <td><i class="fa fa-close" aria-hidden="true" style="color:#442;"></i></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Brake Assist</td>
                                                        <?php if ($result->brake_assist >= 1) {
                                                        ?>
                                                            <td><i class="fa fa-check" aria-hidden="true" style="color:#442;"></i></td>
                                                        <?php  } else { ?>
                                                            <td><i class="fa fa-close" aria-hidden="true" style="color:#442;"></i></td>
                                                        <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <td>Driver Airbag</td>
                                                        <?php if ($result->driver_airbag == 1) {
                                                        ?>
                                                            <td><i class="fa fa-check" aria-hidden="true" style="color:#442;"></i></td>
                                                        <?php } else { ?>
                                                            <td><i class="fa fa-close" aria-hidden="true" style="color:#442;"></i></td>
                                                        <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <td>Passenger Airbag</td>
                                                        <?php if ($result->passenger_airbag >= 1) {
                                                        ?>
                                                            <td><i class="fa fa-check" aria-hidden="true" style="color:#442;"></i></td>
                                                        <?php } else { ?>
                                                            <td><i class="fa fa-close" aria-hidden="true" style="color:#442;"></i></td>
                                                        <?php } ?>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                    <?php
                }
            } ?>

                        </div>

                        <aside class="col-md-3">
                            <div class="sidebar_widget" style="background-color:#a041fd;">
                                <div class="widget_heading">
                                    <h5 style="color:#fff;">Book Now</h5>
                                </div>
                                <form method="post">
                                    <div class="form-group">
                                        <label for="fromdate">From Date and Time:</label>
                                        <input type="datetime-local" class="form-control" id="fromdate" name="fromdate" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="todate">To Date and Time:</label>
                                        <input type="datetime-local" class="form-control" id="todate" name="todate" required>
                                    </div>
                                    <div class="form-group">
                                        <textarea rows="3" class="form-control" name="message" placeholder="Extra Requirements..." required></textarea>
                                    </div>
                                    <?php if ($_SESSION['login']) { ?>
                                        <div class="form-group">
                                            <input type="submit" class="btn" name="submit" value="Book Now" style="background-color:#442;">
                                        </div>
                                    <?php } else { ?>
                                        <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal" style="background-color:#442;">SIGN IN FOR BOOKING</a>
                                    <?php } ?>
                                </form>
                            </div>
                        </aside>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                function setMinDateTime() {
                                    const now = new Date();
                                    const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
                                    document.getElementById('fromdate').min = localDateTime;
                                    document.getElementById('todate').min = localDateTime;
                                }

                                setMinDateTime();

                                const fromDateInput = document.getElementById('fromdate');
                                const toDateInput = document.getElementById('todate');

                                fromDateInput.addEventListener('change', function() {
                                    const selectedFromDate = new Date(fromDateInput.value);
                                    toDateInput.min = fromDateInput.value;
                                    if (new Date(toDateInput.value) < selectedFromDate) {
                                        toDateInput.value = fromDateInput.value;
                                    }
                                });
                            });
                        </script>

                    </div>

                    <div class="space-20"></div>
                    <div class="divider"></div>

                    <!--Similar-Cars-->
                    <div class="similar_cars" style="color:#442;">
                        <h3 style="color:#442;">SIMILAR CARS</h3>
                        <div class="row">
                            <?php
                            $bid = $_SESSION['brndid'];
                            $sql = "SELECT vehicles.vehicles_title, brands.name AS brand_name, vehicles.price_per_day, vehicles.fuel_type, vehicles.model_year, vehicles.id, vehicles.seating_capacity, vehicles.vehicles_overview, vehicles.image1 FROM vehicles JOIN brands ON brands.id = vehicles.vehicles_brand WHERE vehicles.vehicles_brand = :bid";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':bid', $bid, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $result) { ?>

                                    <div class="col-md-3 grid_listing">
                                        <div class="product-listing-m gray-bg" style="background-color:black;">
                                            <div class="product-listing-img"> <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->image1); ?>" class="img-responsive" alt="image" /> </a>
                                            </div>
                                            <div class="product-listing-content" style="background-color: #a041fd;">
                                                <h5><a href="vehicle-details.php?vid=<?php echo htmlentities($result->id); ?>" style="color:#fff;">
                                                        <?php echo htmlentities($result->brand_name); ?>, <?php echo htmlentities($result->vehicles_title); ?>
                                                    </a></h5>
                                                <p class="list-price price" style="color:#fff;">₹<?php echo htmlentities($result->price_per_day); ?></p>

                                                <ul class="features_list" style="background-color:#a041fd;">
                                                    <li style="color:#fff;"><i class="fa fa-user" aria-hidden="true" style="color:#fff;"></i>
                                                        <?php echo htmlentities($result->seating_capacity); ?> seats
                                                    </li>
                                                    <li style="color:#fff;"><i class="fa fa-calendar" aria-hidden="true" style="color:#fff;"></i>
                                                        <?php echo htmlentities($result->model_year); ?> model
                                                    </li>
                                                    <li style="color:#fff;"><i class="fa fa-car" aria-hidden="true" style="color:#fff;"></i>
                                                        <?php echo htmlentities($result->fuel_type); ?>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                            <?php }
                            } ?>

                        </div>
                    </div>
                    <!--/Similar-Cars-->

                </div>
            </section>
            <!--/Listing-detail-->

            <!--Footer -->
            <?php include('includes/footer.php'); ?>
            <!-- /Footer-->


            <!--Login-Form -->
            <?php include('includes/login.php'); ?>
            <!--/Login-Form -->

            <!--Register-Form -->
            <?php include('includes/registration.php'); ?>

            <!--/Register-Form -->

            <!--Forgot-password-Form -->
            <?php include('includes/forgotpassword.php'); ?>

            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/bootstrap.min.js"></script>
            <script src="assets/js/interface.js"></script>
            <script src="assets/switcher/js/switcher.js"></script>
            <script src="assets/js/bootstrap-slider.min.js"></script>
            <script src="assets/js/slick.min.js"></script>
            <script src="assets/js/owl.carousel.min.js"></script>

</body>

</html>