<?php
include('includes/config.php');
if (isset($_POST['signup'])) {

    if ($_POST['cpassword'] != $_POST['password']) {
        echo "<script>alert('Password not match.');</script>";
    } else {
        // $password = "MyP@ssw0rd"; // Replace this with the password you want to validate.
        $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&+=!])(?!.*\s).{8,}$/";

        $cmobileno = $_POST['mobilenumber'];
        $pattern1 = '/^[0-9]{10}$/';

        if (preg_match($pattern, $_POST['password'])) {
            if (preg_match($pattern1, $cmobileno)) {
                $shopownername = $_POST['shopownername'];
                $shopname = $_POST['shopname'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = md5($_POST['password']);
                $mobilenumber = $_POST['mobilenumber'];

                $checkUser = mysqli_query($con, "SELECT Email FROM admin WHERE Email = '$email' ");
                if (mysqli_num_rows($checkUser) > 0) {
                    echo "<script>alert('Email already taken.');</script>";
                } else {
                    $query = mysqli_query($con, "INSERT INTO admin(ShopOwnerName, ShopName, UserName, Email, Password, MobileNumber) values(' $shopownername', '$shopname', '$username', '$email', '$password',  '$mobilenumber') ");
                    if ($query) {
                        echo "<script>alert('Signup successfully.');</script>";
                        echo "<script>window.location.href='login.php'</script>";
                    } else {
                        echo "<script>alert('Something went wrong. Please try again.');</script>";
                        echo "<script>window.location.href='signup.php'</script>";
                    }
                }
            } else {
                echo "<script>alert('Mobile Number is not valid.');</script>";
            }
        } else {
            echo "<script>alert('Password is not valid. It should contain at least one uppercase letter, one lowercase letter, one digit, one special character, and be at least 8 characters long.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>SignUp Page</title>
    <meta name="description" content="A responsive bootstrap 4 admin dashboard template by hencework" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Custom CSS -->
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>


    <!-- HK Wrapper -->
    <div class="hk-wrapper">

        <!-- Main Content -->
        <div class="hk-pg-wrapper hk-auth-wrapper ">
            <header class="d-flex justify-content-between align-items-center">
                <a class="d-flex auth-brand align-items-center" href="#">
                    <span class="text-white font-50">TinyShop</span>
                </a>

            </header>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-5 pa-0">
                        <div id="owl_demo_1" class="owl-carousel dots-on-item owl-theme">
                            <div class="fadeOut item auth-cover-img overlay-wrap" style="background-image:url(dist/img/banner1.jpg);">
                                <div class="auth-cover-info py-xl-0 pt-100 pb-50">
                                    <div class="auth-cover-content text-center w-xxl-75 w-sm-90 w-xs-100">

                                    </div>
                                </div>
                                <div class="bg-overlay bg-trans-dark-50"></div>
                            </div>
                            <div class="fadeOut item auth-cover-img overlay-wrap" style="background-image:url(dist/img/banner2.jpg);">
                                <div class="auth-cover-info py-xl-0 pt-100 pb-50">
                                    <div class="auth-cover-content text-center w-xxl-75 w-sm-90 w-xs-100">

                                    </div>
                                </div>
                                <div class="bg-overlay bg-trans-dark-50"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 pa-0 bg-dark-80">
                        <div class="auth-form-wrap py-xl-0 py-50 ">
                            <div class="auth-form w-xxl-55 w-xl-75 w-sm-90 w-xs-100 ">
                                <form method="post">
                                    <h1 class="text-white display-4 mb-10">SingUp</h1>
                                    <!-- Shop Owner Name -->
                                    <div class="form-group">
                                        <input class="form-control dd-handle" placeholder="Shop Owner Name" type="text" name="shopownername" required="true" \>
                                    </div>

                                    <!-- Shop Name -->
                                    <div class="form-group">
                                        <input class="form-control dd-handle" placeholder="Shop Name" type="text" name="shopname" required="true">
                                    </div>
                                    <!-- Username -->
                                    <div class="form-group">
                                        <input class="form-control dd-handle" placeholder="Username" type="text" name="username" required="true">
                                    </div>

                                    <!-- Email Id -->
                                    <div class="form-group">
                                        <input class="form-control dd-handle" placeholder="Email" type="email" name="email" required="true">
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control dd-handle" placeholder="Password" type="password" name="password" required="true">
                                            <div class="input-group-append">
                                                <span class="input-group-text dd-handle"><span class="feather-icon"><i data-feather="eye-on"></i></span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Conform Password -->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control dd-handle" placeholder="Conform Password" type="password" name="cpassword" required="true">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><span class="feather-icon"><i data-feather="eye-on"></i></span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mobile Number -->
                                    <div class="form-group">
                                        <input class="form-control dd-handle" placeholder="Mobile Number" type="number" name="mobilenumber" required="true">
                                    </div>

                                    <button class="btn  btn-block bg-yellow-light-1 text-black" type="submit" name="signup">SignUp</button>
                                    <p class="font-14 text-center mt-15 text-yellow">
                                        Already have an account ? &nbsp; <a href="login.php">Login</a>
                                    </p>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Slimscroll JavaScript -->
    <script src="dist/js/jquery.slimscroll.js"></script>

    <!-- Fancy Dropdown JS -->
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>

    <!-- Owl JavaScript -->
    <script src="vendors/owl.carousel/dist/owl.carousel.min.js"></script>

    <!-- FeatherIcons JavaScript -->
    <script src="dist/js/feather.min.js"></script>

    <!-- Init JavaScript -->
    <script src="dist/js/init.js"></script>
    <script src="dist/js/login-data.js"></script>
</body>

</html>