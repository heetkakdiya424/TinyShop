<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    // Add product Code
    if (isset($_POST['submit'])) {

        //Getting Post Values
        $userID = $_SESSION['aid'];
        $catname = $_POST['category'];
        $catname = explode(",", $catname)[1];
        $subcatname = $_POST['subcategory'];
        $company = $_POST['company'];
        $pname = $_POST['productname'];
        $pprice = $_POST['productprice'];
        $expirydate = $_POST['expirydate'];
        $stock = $_POST['stock'];
        $ex_check = $_POST['edrequired'];

        if (isset($_POST['edrequired'])) {
            $currentDate = date("d-m-Y");
            $futureDate = strtotime($currentDate . " +7 days");
            if (strtotime($expirydate) > $futureDate) {
                $query = mysqli_query($con, "insert into products(userID,CategoryName,SubCategoryName,CompanyName,ProductName,ProductPrice,ExpiryDate,Stock) values('$userID','$catname','$subcatname','$company','$pname','$pprice','$expirydate','$stock')");
                if ($query) {
                    echo "<script>alert('Product added successfully.');</script>";
                    echo "<script>window.location.href='add-product.php'</script>";
                } else {
                    echo "<script>alert('" . mysqli_error($con) . "');</script>";

                    echo "<script>alert('Something went wrong. Please try again.');</script>";
                    echo "<script>window.location.href='add-product.php'</script>";
                }
            } else {
?>
                <div class="error-alert">
                    <script>
                        alert('product is already expired.');
                    </script>
                </div>
    <?php
            }
        } else {
            $query = mysqli_query($con, "insert into products(userID,CategoryName,SubCategoryName,CompanyName,ProductName,ProductPrice,Stock) values('$userID','$catname','$subcatname','$company','$pname','$pprice','$stock')");
            if ($query) {
                echo "<script>alert('Product added successfully.');</script>";
                echo "<script>window.location.href='add-product.php'</script>";
            } else {
                echo "<script>alert('" . mysqli_error($con) . "');</script>";
                echo "<script>alert('Something went wrong. Please try again.');</script>";
                echo "<script>window.location.href='add-product.php'</script>";
            }
        }
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Add Product</title>
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
                        <li class="breadcrumb-item text-white"><a href="#">Product</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Add Product</li>
                    </ol>
                </nav>
                <!-- /Breadcrumb -->

                <!-- Container -->
                <div class="container">
                    <!-- Title -->
                    <div class="hk-pg-header">
                        <h4 class="hk-pg-title text-white"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Add Product</h4>
                    </div>
                    <!-- /Title -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col-xl-12">
                            <section class="hk-sec-wrapper">

                                <div class="row">
                                    <div class="col-sm">

                                        <form class="needs-validation" method="post" enctype="multipart/form-data" novalidate>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Category</label>
                                                    <select class="form-control custom-select" name="category" onChange="subcategory(this.value)" required>
                                                        <option value="0">Select category</option>
                                                        <?php
                                                        $userID = $_SESSION['aid'];
                                                        $ret = mysqli_query($con, "select CategoryName from category where userID='$userID'");
                                                        while ($row = mysqli_fetch_array($ret)) { ?>
                                                            <option value="<?php echo $row['CategoryCode'] . "," . $row['CategoryName']; ?>"><?php echo $row['CategoryName']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">Please select a category.</div>
                                                </div>
                                            </div>

                                            <div class="form-row" id="subcategory1">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Sub Category</label>
                                                    <select class="form-control custom-select" name="subcategory" required>
                                                        <option value="0">Select Sub category</option>
                                                        <?php
                                                        $ret = mysqli_query($con, "select * from subcategory where userID='$userID'");
                                                        while ($row = mysqli_fetch_array($ret)) { ?>
                                                            <option value="<?php echo $row['sub_category_name']; ?>"><?php echo $row['sub_category_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">Please select a category.</div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Company</label>
                                                    <select class="form-control custom-select" name="company" required>
                                                        <option value="">Select Company</option>
                                                        <?php
                                                        $ret = mysqli_query($con, "select CompanyName from company  where userID='$userID'");
                                                        while ($row = mysqli_fetch_array($ret)) { ?>
                                                            <option value="<?php echo $row['CompanyName']; ?>"><?php echo $row['CompanyName']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">Please select a company.</div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Product Name</label>
                                                    <input type="text" class="form-control" id="validationCustom03" placeholder="Product Name" name="productname" required>
                                                    <div class="invalid-feedback">Please provide a valid product name.</div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Product Price</label>
                                                    <input type="number" class="form-control" id="validationCustom03" placeholder="Product Price" name="productprice" required>
                                                    <div class="invalid-feedback">Please provide a valid product price.</div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">
                                                        Expiry date required ?
                                                    </label>
                                                    <input type="checkbox" style="width: 20px;" id="checkbox1" name="edrequired">
                                                </div>
                                            </div>

                                            <div class="form-row" id="expiryDateContainer" style="display: none;">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Expiry Date</label>
                                                    <input type="Date" class="form-control" id="validationCustom03" placeholder="Product Price" name="expirydate">
                                                    <div class="invalid-feedback">Please provide a valid product Expiry Date.</div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Stock</label>
                                                    <input type="number" class="form-control" id="validationCustom03" placeholder="0" name="stock" min="0" required oninput="validateInput(this)">
                                                    <div class="invalid-feedback">Please provide a valid product stock number.</div>
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

        <style>
            .error-alert {
                background-color: #ffdddd;
                border: 1px solid #f44336;
                color: green;
                padding: 15px;
                margin-bottom: 20px;
            }
        </style>

        <script>
            function validateInput(input) {
                if (input.value < 0) {
                    input.setCustomValidity('Please enter a positive number.');
                } else {
                    input.setCustomValidity('');
                }
            }
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const checkbox = document.getElementById("checkbox1");
                const expiryDateContainer = document.getElementById("expiryDateContainer");

                checkbox.addEventListener("change", function() {
                    if (checkbox.checked) {
                        expiryDateContainer.style.display = "block";
                    } else {
                        expiryDateContainer.style.display = "none";
                    }
                });
            });
        </script>


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