<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (isset($_POST['update'])) {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $newpassword = md5($_POST['newpassword']);
    $sql = "SELECT email_id FROM users WHERE email_id=:email AND contact_no=:mobile";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        $con = "UPDATE users SET password=:newpassword WHERE email_id=:email AND contact_no=:mobile";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
        $chngpwd1->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();
        echo "<script>alert('Your Password successfully changed');</script>";
    } else {
        echo "<script>alert('Email id or Mobile no is invalid');</script>";
    }
}
?>

<script type="text/javascript">
function valid() {
    if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
        alert("New Password and Confirm Password Field do not match!!");
        document.chngpwd.confirmpassword.focus();
        return false;
    }
    return true;
}
</script>

<div class="modal fade" id="forgotpassword">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color:#a041fd;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" style="color:#f3f3f3;">Password Recovery</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="forgotpassword_wrap">
                        <div class="col-md-12">
                            <form name="chngpwd" method="post" onSubmit="return valid();">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Your Email Address" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="mobile" class="form-control" placeholder="Your Contact Number" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="newpassword" class="form-control" placeholder="New Password" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm New Password" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Reset My Password" name="update" class="btn btn-block" style="background-color:#f3f3f3; color:#442">
                                </div>
                            </form>
                            <div class="text-center">
                                <p><a href="#loginform" data-toggle="modal" data-dismiss="modal" style="color:#f3f3f3;"><i class="fa fa-angle-double-left" aria-hidden="true"></i> SIGN IN INSTEAD</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
