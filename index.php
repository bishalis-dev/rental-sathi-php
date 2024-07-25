<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "carrental");
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Sathi - Vehicle Rental System</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Play&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Play', sans-serif;
        }

        .navbar {
            background-color: #333;
            position: -webkit-sticky; /* For Safari */
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar a {
            color: white !important;
        }

        .banner {
            position: relative;
            width: 100%;
            height: 80vh;
            background: url('https://c4.wallpaperflare.com/wallpaper/66/25/239/machine-grey-background-volvo-wallpaper-preview.jpg') no-repeat center center/cover;
        }

        .banner-content {
            position: absolute;
            bottom: 50px;
            left: 50px;
            color: white;
        }

        .banner-content h4 {
            font-size: 2.5em;
        }

        .banner-content .btn {
            background-color: #a041fd;
            border: none;
            padding: 10px 20px;
            font-size: 1.2em;
        }

        .section {
            padding: 60px 0;
        }

        .section h2, .section h3 {
            color: #333;
        }

        .section p {
            color: #666;
        }

        .fun-facts {
            background-color: #a041fd;
            color: white;
        }

        .fun-facts .fun-fact {
            padding: 20px;
            color: white;
        }

        .footer {
            background-color: #333;
            color: white;
            padding: 20px 0;
        }

        .footer a {
            color: #a041fd;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php include('includes/header.php'); ?>
    <!-- /Header -->

    <!-- Banner Section -->
    <section class="banner">
        <div class="banner-content">
            <h4>DRIVE IN A SANITISED VEHICLES</h4>
            <a href="car-listing.php" class="btn">Search Vehicles</a>
        </div>
    </section>
    <!-- /Banner Section -->

    <!-- Features Section -->
    <section class="section text-center">
        <div class="container">
            <h2>Self Drive Cars on Rent</h2>
            <h3>We simplified car rentals, so you can focus on what's important to you.</h3>
            <h3>Unbeatable Rates. Easy & Quick Online Booking. Clean & Well Maintained Fleet.</h3>
            <div class="row">
                <div class="col-md-4">
                    <h3>Fuel Cost Included</h3>
                    <p>Don't worry about mileage! All fuel costs are included. If you refill fuel, we'll pay you back!</p>
                </div>
                <div class="col-md-4">
                    <h3>No Hidden Charges</h3>
                    <p>Our prices include taxes and insurance. What you see is what you really pay!</p>
                </div>
                <div class="col-md-4">
                    <h3>Flexi Pricing Packages</h3>
                    <p>One size never fits all! Choose a balance of time and kilometers that works best for you.</p>
                </div>
                <div class="col-md-4">
                    <h3>Go Anywhere</h3>
                    <p>Our cars have all-India permits. Just remember to pay state tolls and entry taxes.</p>
                </div>
                <div class="col-md-4">
                    <h3>24x7 Roadside Assistance</h3>
                    <p>We have round-the-clock, pan India partners. Help is never far away from you.</p>
                </div>
                <div class="col-md-4">
                    <h3>Damage Insurance</h3>
                    <p>All your bookings include damage insurance! Drive safe, but don’t worry!</p>
                </div>
            </div>
        </div>
    </section>
    <!-- /Features Section -->

    <!-- Fun Facts Section -->
    <section class="fun-facts section text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-3 fun-fact">
                    <h2><i class="fa fa-calendar" aria-hidden="true"></i>1200+</h2>
                    <p>Rides Daily</p>
                </div>
                <div class="col-md-3 fun-fact">
                    <h2><i class="fa fa-car" aria-hidden="true"></i>36,000+</h2>
                    <p>Km Travelled</p>
                </div>
                <div class="col-md-3 fun-fact">
                    <h2><i class="fa fa-user-circle-o" aria-hidden="true"></i>5,000+</h2>
                    <p>Happy Users</p>
                </div>
                <div class="col-md-3 fun-fact">
                    <h2><i class="fa fa-car" aria-hidden="true"></i>43+</h2>
                    <p>Number of Cars</p>
                </div>
            </div>
        </div>
    </section>
    <!-- /Fun Facts Section -->

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
    <!-- /Footer -->

    <!-- Login-Form -->
    <?php include('includes/login.php'); ?>
    <!-- /Login-Form -->

    <!-- Register-Form -->
    <?php include('includes/registration.php'); ?>
    <!-- /Register-Form -->

    <!-- Forgot-password-Form -->
    <?php include('includes/forgotpassword.php'); ?>
    <!-- /Forgot-password-Form -->

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/interface.js"></script>
</body>

</html>
