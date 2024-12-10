<?php
error_reporting(0);
session_start();
//error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Dashboard</title>
        <link href="vendors/vectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" type="text/css" />
        <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
        <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
        <link href="vendors/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
        <link href="dist/css/style.css" rel="stylesheet" type="text/css">
        <link href="card.css" rel="stylesheet" type="text/css">
    </head>

    <body>


        <!-- HK Wrapper -->
        <div class="hk-wrapper hk-vertical-nav" style="color: #5e7d8a;">

            <?php include_once('includes/navbar.php');
            include_once('includes/sidebar.php');
            ?>
            <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
            <!-- /Vertical Nav -->
            <!-- Main Content -->
            <div class="hk-pg-wrapper" style="background: #000000;">
                <!-- Container -->
                <div class="container-fluid mt-xl-50 mt-sm-30 mt-15">
                    <!-- Row -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hk-row">

                            <?php
                                $userID = $_SESSION['aid'];
                                $query = mysqli_query($con, "select id from category  where userID='$userID'");
                                $listedcat = mysqli_num_rows($query);
                                ?>

                                <div class="col-lg-3 col-md-6">
                                    <a href="manage-categories.php" style="color: #5e7d8a;">
                                        <div class="card card-sm">
                                            <div class="card-body A ">
                                                <div class="d-flex justify-content-between mb-5 " >
                                                    <div>
                                                        <span class="d-block font-15 text-dark font-weight-500" >Categories</span>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <span class="d-block display-4 text-dark mb-5 font-weight-500"><span class="counter-anim"><?php echo $listedcat; ?></span></span>
                                                    <small class="d-block text-dark font-weight-500">Listed Categories</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <?php
                                $subc = mysqli_query($con, "select id from subcategory where userID='$userID'");
                                $listedscat = mysqli_num_rows($subc);
                                ?>
                               

                                <div class="col-lg-3 col-md-6">
                                    <a href="manage-sub-categories.php" style="color: #5e7d8a;">
                                        <div class="card card-sm">
                                            <div class="card-body B">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <div>
                                                        <span class="d-block font-15 text-dark font-weight-500">Sub-Categories</span>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo $listedscat; ?></span></span>
                                                    <small class="d-block text-dark font-weight-500">Listed Sub-Categories</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                                $ret = mysqli_query($con, "select id from company where userID='$userID'");
                                $listedcomp = mysqli_num_rows($ret);
                                ?>

                              
                                <div class="col-lg-3 col-md-6">
                                    <a href="manage-companies.php" style="color: #5e7d8a;">
                                        <div class="card card-sm">
                                            <div class="card-body C">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <div>
                                                        <span class="d-block font-15 text-dark font-weight-500">Companies</span>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>

                                                <div class="text-center">
                                                    <span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo $listedcomp; ?></span></span>
                                                    <small class="d-block text-dark font-weight-500">Listed Companies</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                                $sql = mysqli_query($con, "select id from products where userID='$userID'");
                                $listedproduct = mysqli_num_rows($sql);
                                ?>
                               
                                <div class="col-lg-3 col-md-6">
                                    <a href="manage-products.php" style="color: #5e7d8a;">
                                        <div class="card card-sm">
                                            <div class="card-body D">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <div>
                                                        <span class="d-block font-15 text-dark font-weight-500">Products</span>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo $listedproduct; ?></span></span>
                                                    <small class="d-block text-dark font-weight-500">Listed Products</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                               <?php
                                $quryss = mysqli_query($con, "SELECT SUM(orders.Quantity * products.ProductPrice) as tt  
                                FROM orders 
                                JOIN products ON products.id = orders.ProductId 
                                WHERE date(orders.InvoiceGenDate) = CURDATE() 
                                  AND orders.userID = '$userID'");
                                $rws = mysqli_fetch_array($quryss);
                                ?>
                                <div class="col-lg-3 col-md-6">
                                    <a href="#" style="color: #5e7d8a;">
                                        <div class="card card-sm">
                                            <div class="card-body E">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <div>
                                                        <span class="d-block font-15 text-dark font-weight-500">Today's Sales</span>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo number_format($rws['tt'], 2); ?></span></span>
                                                    <small class="d-block text-dark font-weight-500">Today's Total Sales</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                                $qurys = mysqli_query($con, "select sum(orders.Quantity* products.ProductPrice) as tt  from  orders join  products on  products.id= orders.ProductId where date( orders.InvoiceGenDate)=CURDATE()-1 AND  orders.userID='$userID'");
                                $rw = mysqli_fetch_array($qurys);
                                ?>


                                <div class="col-lg-3 col-md-6">
                                    <a href="#" style="color: #5e7d8a;">
                                        <div class="card card-sm">
                                            <div class="card-body F" >
                                                <div class="d-flex justify-content-between mb-5">
                                                    <div>
                                                        <span class="d-block font-15 text-dark font-weight-500">Yesterday Sales</span>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo number_format($rw['tt'], 2); ?></span></span>
                                                    <small class="d-block text-dark font-weight-500">Yesterday Total Sales</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>


                                <?php
                                $qury = mysqli_query($con, "select sum( orders.Quantity* products.ProductPrice) as tt  from  orders join  products on  products.id= orders.ProductId where date( orders.InvoiceGenDate)>=(DATE(NOW()) - INTERVAL 7 DAY) AND  orders.userID='$userID'");
                                $row = mysqli_fetch_array($qury);
                                ?>
                                <div class="col-lg-3 col-md-6">
                                    <a href="#" style="color: #5e7d8a;">
                                        <div class="card card-sm">
                                            <div class="card-body G">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <div>
                                                        <span class="d-block font-15 text-dark font-weight-500">Last 7 Days Sales</span>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo number_format($row['tt'], 2); ?></span></span>
                                                    <small class="d-block text-dark font-weight-500">Last 7 Days Total Sales</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <?php
                                $query = mysqli_query($con, "select sum( orders.Quantity* products.ProductPrice) as tt  from  orders join  products on  products.id= orders.ProductId where  orders.userID='$userID'");
                                $row = mysqli_fetch_array($query);
                                ?>
                                <div class="col-lg-3 col-md-6">
                                    <a href="#" style="color: #5e7d8a;">
                                        <div class="card card-sm">
                                            <div class="card-body H">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <div>
                                                        <span class="d-block font-15 text-dark font-weight-500">Total Sales</span>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo number_format($row['tt'], 2); ?></span></span>
                                                    <small class="d-block text-dark font-weight-500">Total sales till date</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            </div>
                            <hr style="border: .2px solid #CECECE;" />



                            <!-- Report Section -->
                            <div class="hk-row">
                            <?php
                                $noproduct = 0;
                                // Fetch the expiration dates from the database
                                $exdate = mysqli_query($con, "SELECT ExpiryDate FROM  products WHERE userID='$userID'");
                                if ($exdate) {
                                    // Create a DateTime object for the current date
                                    $currentDate = new DateTime();

                                    while ($ed = mysqli_fetch_array($exdate)) {
                                        // Convert the fetched date to a DateTime object
                                        $targetDate = new DateTime($ed['ExpiryDate']);

                                        // Calculate the difference in days between targetDate and currentDate
                                        $interval = $currentDate->diff($targetDate);
                                        $daysDifference = $interval->days;

                                        if (empty($ed['ExpiryDate'])) {
                                        } else {
                                            // Check if the difference is less than or equal to 7
                                            if ($daysDifference <= 7) {
                                                $noproduct++;
                                            }
                                        }
                                    }
                                } else { // Handle the case when the query fails
                                    echo "Error: " . mysqli_error($con);
                                } // Output the number of products that expire within 7 days 
                                ?>
                                
                                <div class="col-lg-3 col-md-6">
                                    <a href="expirydate_products.php" style="color: #5e7d8a;" id="expy-a">
                                        <div class="card card-sm" id="expy-c">
                                            <div class="card-body I">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <div>
                                                        <span class="d-block font-15 font-weight-500" id="expy-t">Near ExpiryDate</span>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <span class="d-block display-4 mb-5"><span class="counter-anim" id="expy-n"><?php echo $noproduct; ?></span></span>
                                                    <small class="d-block text-dark font-weight-500">Number of Products</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <?php
                                $stockout = mysqli_query($con, "select Stock from  products where userID='$userID'");
                                $sop = 0;
                                while ($so = mysqli_fetch_array($stockout)) {
                                    if ($so['Stock'] <= 5) {
                                        $sop++;
                                    }
                                }
                                ?>
                                <div class="col-lg-3 col-md-6">
                                    <a href="stockout_products.php" style="color: #5e7d8a;" id="stock-a">
                                        <div class="card card-sm" id="stock-c">
                                            <div class="card-body J">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <div>
                                                        <span class="d-block font-15 font-weight-500" id="stock-t">Near StockOut</span>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>

                                                <div class="text-center">
                                                    <span class="d-block display-4 text-dark mb-5"><span class="counter-anim" id="stock-n"><?php echo $sop; ?></span></span>
                                                    <small class="d-block text-dark font-weight-500">Number of Products</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            </div>
                        </div>
                        <!-- /Container -->

                        <!-- Footer -->
                        <?php include_once('includes/footer.php'); ?>
                        <!-- /Footer -->
                    </div>
                    <!-- /Main Content -->

                </div>
                <!-- /HK Wrapper -->



                <script>
                    // Get the content of the element with ID "ed-pro"
                    var noproduct = document.getElementById("expy-n").innerText;

                    // Parse the content as a number
                    var numProducts = parseInt(noproduct);

                    // Get the element with ID "expy"
                    var expyDiv = document.getElementById("expy-c");
                    var expyDivT = document.getElementById("expy-t");
                    var expyDivN = document.getElementById("expy-n");
                    var expyDivA = document.getElementById("expy-a");

                    // Check if the number of products is greater than 0
                    if (numProducts > 0) {
                        // Set the background color to red
                        expyDiv.style.backgroundColor = "red";
                        expyDivT.style.color = "white";
                        expyDivN.style.color = "white";
                        expyDivA.style.color = "white";
                    } else {
                        expyDivT.style.color = "black";
                        expyDivN.style.color = "black";
                    }
                </script>
                <script>
                    // Get the content of the element with ID "ed-pro"
                    var noproductS = document.getElementById("stock-n").innerText;

                    // Parse the content as a number
                    var numProductsS = parseInt(noproductS);

                    // Get the element with ID "expy"
                    var stockDiv = document.getElementById("stock-c");
                    var stockDivT = document.getElementById("stock-t");
                    var stockDivN = document.getElementById("stock-n");
                    var stockDivA = document.getElementById("stock-a");

                    // Check if the number of products is greater than 0
                    if (numProductsS > 0) {
                        // Set the background color to red
                        stockDiv.style.backgroundColor = "red";
                        stockDivT.style.color = "white";
                        stockDivN.style.color = "white";
                        stockDivA.style.color = "white";
                    } else {
                        stockDivT.style.color = "black";
                        stockDivN.style.color = "black";
                    }
                </script>

                <!-- jQuery -->
                <script src="vendors/jquery/dist/jquery.min.js"></script>
                <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
                <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
                <script src="dist/js/jquery.slimscroll.js"></script>
                <script src="dist/js/dropdown-bootstrap-extended.js"></script>
                <script src="dist/js/feather.min.js"></script>
                <script src="vendors/jquery-toggles/toggles.min.js"></script>
                <script src="dist/js/toggle-data.js"></script>
                <script src="vendors/waypoints/lib/jquery.waypoints.min.js"></script>
                <script src="vendors/jquery.counterup/jquery.counterup.min.js"></script>
                <script src="vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
                <script src="vendors/vectormap/jquery-jvectormap-2.0.3.min.js"></script>
                <script src="vendors/vectormap/jquery-jvectormap-world-mill-en.js"></script>
                <script src="dist/js/vectormap-data.js"></script>
                <script src="vendors/owl.carousel/dist/owl.carousel.min.js"></script>
                <script src="vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
                <script src="vendors/apexcharts/dist/apexcharts.min.js"></script>
                <script src="dist/js/irregular-data-series.js"></script>
                <script src="dist/js/init.js"></script>

    </body>

    </html>
<?php  } ?>