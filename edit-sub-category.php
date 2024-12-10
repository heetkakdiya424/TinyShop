<?php
session_start();
//error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    // Add Category Code
    if (isset($_POST['update'])) {

        $scid = substr(base64_decode($_GET['scatid']), 0, -5);
        //Getting Post Values
        $catcode = $_POST['categoryname'];
        $scatname = $_POST['subcategoryname'];
        $scatcode = $_POST['subcategorycode'];

        $query = mysqli_query($con, "UPDATE subcategory
        SET category_code = '$catcode',
            sub_category_code = '$scatcode',
            sub_category_name = '$scatname'
        WHERE id = '$scid'");
        if ($query) {
            echo "<script>alert('Sub Category updated successfully');</script>";
            echo "<script>window.location.href='manage-sub-categories.php'</script>";
        } else {
            echo "<script>alert('" . mysqli_error($con) . "');</script>";
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Edit Sub-Category</title>
        <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
        <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
        <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    </head>

    <body>


        <!-- HK Wrapper -->
        <div class="hk-wrapper hk-vertical-nav">

            <!-- Top Navbar -->
            <?php include_once('includes/navbar.php');
            include_once('includes/sidebar.php');
            ?>
            <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
            <!-- /Vertical Nav -->
            <!-- Main Content -->
            <div class="hk-pg-wrapper" style="background: #000000;">
                <!-- Breadcrumb -->
                <nav class="hk-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light bg-transparent">
                        <li class="breadcrumb-item text-white"><a href="#">Category</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <!-- /Breadcrumb -->

                <!-- Container -->
                <div class="container">
                    <!-- Title -->
                    <div class="hk-pg-header">
                        <h4 class="hk-pg-title text-white"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Edit Sub-Category</h4>
                    </div>
                    <!-- /Title -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col-xl-12">
                            <section class="hk-sec-wrapper">

                                <div class="row">
                                    <div class="col-sm">
                                        <form class="needs-validation" method="post" novalidate>
                                            <?php
                                            $scid = substr(base64_decode($_GET['scatid']), 0, -5);
                                            $ret = mysqli_query($con, "select * from subcategory where ID='$scid'");
                                            $row = mysqli_fetch_array($ret)
                                            ?>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Category Name</label>
                                                    <select class="form-control" name="categoryname">
                                                        <?php
                                                        $uid = $_SESSION['aid'];
                                                        $ctn = mysqli_query($con, "select * from category where userID='$uid'");
                                                        while ($r = mysqli_fetch_assoc($ctn)) {
                                                        ?>
                                                            <option value="<?php echo $r['CategoryCode']; ?>" <?php echo ($row['category_code'] == $r['CategoryCode']) ? 'selected' : ''; ?>>
                                                                <?php echo $r['CategoryName']; ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>

                                                    <div class="invalid-feedback">Please provide a valid category name.</div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Sub-Category Name</label>
                                                    <input type="text" class="form-control" id="validationCustom03" value="<?php echo $row['sub_category_name']; ?>" name="subcategoryname" required>
                                                    <div class="invalid-feedback">Please provide a valid category name.</div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Sub-Category Code</label>
                                                    <input type="text" class="form-control" id="validationCustom03" value="<?php echo $row['sub_category_code']; ?>" name="subcategorycode" required>
                                                    <div class="invalid-feedback">Please provide a valid category code.</div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit" name="update">Update</button>
                                        </form>
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
<?php } ?>