<?php
session_start();

$total_sub_category = 1;
//error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    $userID = $_SESSION['aid'];
    // Add Category Code
    if (isset($_POST['submit'])) {
        //Getting Post Values
        $catcode = $_POST['category'];
        $subcatname = $_POST['subcategoryname'];
        $subcatcode = $_POST['subcategorycode'];

        // add Category in database
        $query = mysqli_query($con, "insert into subcategory(userID,category_code,sub_category_code,sub_category_name) values('$userID','$catcode','$subcatcode','$subcatname')");

        if ($query) {
            echo "<script>alert('Sub Category added successfully.');</script>";
            echo "<script>window.location.href='add-subcategory-category.php'</script>";
        } else {
            if (!$query) {
                // Handle the error for the first query
                echo "<script>alert('Please provide a valid information.');</script>";
            }
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Add Category</title>
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
                        <li class="breadcrumb-item text-white"><a href="#">Sub Category</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Add Sub Category</li>
                    </ol>
                </nav>
                <!-- /Breadcrumb -->

                <!-- Container -->
                <div class="container">
                    <!-- Title -->
                    <div class="hk-pg-header">
                        <h4 class="hk-pg-title text-white"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Add Sub-Category</h4>
                    </div>
                    <!-- /Title -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col-xl-12">
                            <section class="hk-sec-wrapper">

                                <div class="row">
                                    <div class="col-sm">
                                        <form class="needs-validation" method="post" novalidate>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Category Name</label>
                                                    <select class="form-control custom-select" name="category" required>
                                                        <option value="0">Select category</option>
                                                        <?php
                                                        session_start(); // Ensure session is started
                                                        $userID = isset($_SESSION['aid']) ? $_SESSION['aid'] : 0; // Avoid potential undefined index error
                                                        $query = "SELECT CategoryCode, CategoryName FROM category WHERE userID='$userID'";
                                                        $result = mysqli_query($con, $query);

                                                        if ($result) {
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                $categoryCode = $row['CategoryCode'];
                                                                $categoryName = $row['CategoryName'];
                                                                echo "<option value=\"$categoryCode\">$categoryName</option>";
                                                            }
                                                        } else {
                                                            echo "<option value=''>Error retrieving categories</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">Please select a category.</div>
                                                </div>
                                            </div>


                                            <div class="form-row">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Sub Category Name</label>
                                                    <input type="text" class="form-control" id="validationCustom03" placeholder="Sub Category Code" name="subcategoryname" required>
                                                    <div class="invalid-feedback">Please provide a valid Sub Category Name.</div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Sub Category Code</label>
                                                    <input type="text" class="form-control" id="validationCustom03" placeholder="Sub Category Code" name="subcategorycode" required>
                                                    <div class="invalid-feedback">Please provide a valid Sub Category Code.</div>
                                                </div>
                                            </div>


                                            <button class="btn btn-primary" type="submit" name="submit">Submit</button>
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