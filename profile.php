<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['updateprofile'])) {
        $name = $_POST['fullname'];
        $mobileno = $_POST['mobilenumber'];
        $dob = $_POST['dob'];
        $adress = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $email = $_SESSION['login'];
        $sql = "UPDATE users SET full_name=:name, contact_no=:mobileno, dob=:dob, address=:adress, city=:city, country=:country WHERE email_id=:email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':adress', $adress, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $msg = "Profile Updated Successfully";
    }

    $useremail = $_SESSION['login'];
    $sql = "SELECT * FROM users WHERE email_id=:useremail";
    $query = $dbh->prepare($sql);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
?>

    <!DOCTYPE HTML>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Rental Sathi - Vehicle Rental System</title>
        <!-- Styles -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="assets/css/style.css" type="text/css">
        <link href="assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
        <style>
            body {
                font-family: 'Lato', sans-serif;
                background-color: #f3f3f3;
                padding: 20px;
            }

            .profile_wrap {
                background-color: white;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .form-group label {
                color: #666;
            }

            .btn {
                background-color: #6c5ce7;
                color: white;
                border: none;
            }

            .btn:hover {
                background-color: #5a51e6;
                color: white;
            }
        </style>
    </head>

    <body>
        <!-- Header -->
        <?php include('includes/header.php'); ?>

        <div class="container">
            <div class="profile_wrap">
                <h4 class="uppercase underline">My Profile</h4>
                <?php if ($msg) { ?>
                    <div class="alert alert-success" role="alert"><?php echo htmlentities($msg); ?></div>
                <?php } ?>
                <?php if ($query->rowCount() > 0) {
                    foreach ($results as $result) { ?>
                        <form method="post">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" class="form-control" name="fullname" value="<?php echo htmlentities($result->full_name); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address (Cannot be changed)</label>
                                <input type="email" class="form-control" value="<?php echo htmlentities($result->email_id); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="text" class="form-control" name="mobilenumber" value="<?php echo htmlentities($result->contact_no); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <?php
                                $date = new DateTime();
                                $date->sub(new DateInterval('P18Y')); // Subtract 18 years from today
                                $maxDate = $date->format('Y-m-d'); // Format to YYYY-MM-DD
                                ?>
                                <input type="date" class="form-control" name="dob" value="<?php echo htmlentities($result->dob); ?>" max="<?php echo $maxDate; ?>">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" name="address"><?php echo htmlentities($result->address); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" name="city" value="<?php echo htmlentities($result->city); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <input type="text" class="form-control" name="country" value="<?php echo htmlentities($result->country); ?>" required>
                            </div>
                            <button type="submit" name="updateprofile" class="btn btn-primary">Update Profile</button>
                        </form>
                <?php }
                } ?>
            </div>
        </div>

        <!-- Footer -->
        <?php include('includes/footer.php'); ?>

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
    </body>

    </html>
<?php } ?>