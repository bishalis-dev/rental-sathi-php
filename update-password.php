<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['update'])) {
        $password = md5($_POST['password']);
        $newpassword = md5($_POST['newpassword']);
        $email = $_SESSION['login'];
        $sql = "SELECT Password FROM users WHERE email_id=:email AND Password=:password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $con = "UPDATE users SET password=:newpassword WHERE email_id=:email";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();
            $msg = "Your Password succesfully changed";
        } else {
            $error = "Your current password is wrong";
        }
    }
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rental Sathi - Vehicle Rental System</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #f3f3f3;
            padding: 20px;
            color: #555;
        }
        .profile_wrap {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
        }
        .errorWrap, .succWrap {
            padding: 10px;
            margin-bottom: 20px;
            background: #fff;
            border-left: 4px solid;
        }
        .errorWrap {
            border-color: #dd3d36;
        }
        .succWrap {
            border-color: #5cb85c;
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="container" style="margin-top: 25px;">
        <div class="col-md-6 col-md-offset-3">
            <div class="profile_wrap">
                <h4 class="uppercase underline">Change Password</h4>
                <?php if ($error) { ?>
                    <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                <?php } else if ($msg) { ?>
                    <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                <?php } ?>
                <form name="chngpwd" method="post" onSubmit="return valid();">
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-control" name="newpassword" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" class="form-control" name="confirmpassword" required>
                    </div>
                    <button type="submit" name="update" class="btn btn-block">Update Password</button>
                </form>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>
