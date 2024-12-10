<?php
session_start();
include('includes/config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$isEmail = true;
$isVerified = false;
$isSended = false; // Initialize the $isSended variable

if (isset($_POST['send'])) {
    $email = $_POST['email'];

    $query = mysqli_query($con, "select * from admin where Email='$email' ");
    $ret = mysqli_fetch_array($query);

    if ($ret > 0) {
        $_SESSION['userID'] = $ret['ID'];
        $randomCode = random_int(100000, 999999);
        $_SESSION['code'] = $randomCode;

        // require './PHPMailer/src/PHPMailer.php';
        require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require './vendor/phpmailer/phpmailer/src/Exception.php';
        require './vendor/phpmailer/phpmailer/src/SMTP.php';
        // require './PHPMailer/src/Exception.php';

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0; // Enable verbose debugging for troubleshooting (set to 2 for maximum debugging)
            $mail->isSMTP();
            $mail->Host = 'smtp.mailgun.org'; // SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'postmaster@sandbox51eae4e5122941c9bfb574ac1032dece.mailgun.org';
            $mail->Password = '622ae31a1287aa8df3542be4bfa7db0f-79295dd0-b7eda099';
            $mail->SMTPSecure = 'STARTTLS'; // Enable TLS encryption, 'ssl' also accepted
            $mail->Port = 587; // TCP port to connect to

            // Recipients
            $mail->setFrom('postmaster@sandbox51eae4e5122941c9bfb574ac1032dece.mailgun.org', 'TinyShop Mail Services');
            $mail->addAddress($email, 'Recipient Name');

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Forget Password Code';
            $mail->Body = 'Security code is ' . $_SESSION['code'];
           
            $mail->send();
            $isEmail = false; // Email sent successfully
            $isSended = true;
        } catch (Exception $e) {
            echo 'Email could not be sent. Error: ' . $mail->ErrorInfo;
        }
    } else {
        echo "<script>alert('Please enter a registered email. Please try again.');</script>";
        echo "<script>window.location.href = 'signup.php';</script>";
    }
}

if (isset($_POST['verify'])) {
    if ($_POST['securitycode'] == $_SESSION['code']) {
        $isSended = false;
        $isEmail  = false;
        $isVerified = true;
    }
}

if (isset($_POST['submit'])) {
    if ($_POST['cpassword'] != $_POST['password']) {
        echo "<script>alert('Password not match.');</script>";
    } else {
        $uid = $_SESSION['userID'];
        $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&+=!])(?!.*\s).{8,}$/";
        if (preg_match($pattern, $_POST['password'])) {
            $newpassword = md5($_POST['password']);
            $query = mysqli_query($con, "update admin set Password='$newpassword' where id='$uid' ");
            echo "<script>alert('Password Updated.');</script>";
            session_destroy();
            echo "<script>window.location.href='login.php'</script>";
        } else {
            echo "<script>alert('Password is not valid. It should contain at least one uppercase letter, one lowercase letter, one digit, one special character, and be at least 8 characters long.');</script>";
        }
    }
}0

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Forget Password</title>
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>

    <!-- HK Wrapper -->
    <div class="hk-wrapper hk-vertical-nav">

        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->

        <!-- Main Content -->
        <div class="hk-pg-wrapper">

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Forgot Password</h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-10">
                        <section class="hk-sec-wrapper">

                            <div class="row">
                                <div class="col-sm">

                                    <?php

                                    if ($isEmail) {

                                        echo '<form class="needs-validation" method="post" novalidate>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Enter Registered Email</label>
                                                <input type="text" class="form-control" id="validationCustom03" placeholder="email" name="email" required>
                                                <div class="invalid-feedback">Please provide a valid email.</div>
                                            </div>
                                            <div>
                                                <button class="btn btn-primary" style="margin-top: 34px;" type="submit" name="send">Send</button>
                                            </div>
                                        </div>
                                    </form>';
                                    }

                                    if ($isSended) {

                                        echo '<form class="needs-validation" method="post" novalidate>
                                            <div class="form-row">
                                             <div class="col-md-6 mb-10">
                                                 <label for="validationCustom03">Enter Security Code</label>
                                                 <input type="text" class="form-control" id="validationCustom03" placeholder="Security Code" name="securitycode" required>
                                                    <div class="invalid-feedback">Please provide a valid Security Code.</div>
                                                </div>
                                                <div>
                                                    <button class="btn btn-primary" style="margin-top: 33px;" type="submit" name="verify">Verify</button>
                                                 </div>
                                                </div>
                                            </form>';
                                    }

                                    if ($isVerified) {

                                        echo '<form class="needs-validation" method="post" novalidate>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">New Password</label>
                                                <input type="password" class="form-control" id="validationCustom03" placeholder="New Password" name="password" required>
                                                <div class="invalid-feedback">Password is not valid. It should contain at least one uppercase letter, one lowercase letter, one digit, one special character, and be at least 8 characters long.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Conform Password</label>
                                                <input type="password" class="form-control" id="validationCustom03" placeholder="Conform Password" name="cpassword" required>
                                                <div class="invalid-feedback">password not match</div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                    </form>';
                                    }
                                    ?>

                                </div>
                            </div>
                        </section>

                    </div>
                </div>
            </div>

            <!-- Footer -->
            <?php include_once('includes/footer.php'); ?>
            <!-- /Footer -->

        </div>
        <!-- /Main Content -->

    </div>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="vendors/jquery-toggles/toggles.min.js"></script>
    <script src="dist/js/toggle-data.js"></script>
    <script src="dist/js/init.js"></script>
    <script src="dist/js/validation-data.js"></script>

</body>

</html>