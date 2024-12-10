<?php
use Twilio\Rest\Client;
session_start();
include('includes/config.php');

// Check if the user is logged in
if (empty($_SESSION['aid'])) {
    header('location: logout.php');
} else {
    // Code for Cart
    if (!empty($_GET["action"])) {
        switch ($_GET["action"]) {
            case "add":
                if (!empty($_POST["quantity"])) {
                    $pid = $_GET["pid"];
                    $result = mysqli_query($con, "SELECT * FROM products WHERE id='$pid'");

                    if ($productByCode = mysqli_fetch_array($result)) {
                        $requestedQuantity = intval($_POST["quantity"]);
                        $availableQuantity = $productByCode["Stock"];

                        if (!empty($_SESSION["cart_item"])) {
                            if (array_key_exists($productByCode["id"], $_SESSION["cart_item"])) {
                                // Product is already in the cart
                                $currentQuantityInCart = $_SESSION["cart_item"][$productByCode["id"]]["quantity"];
                                $totalRequestedQuantity = $currentQuantityInCart + $requestedQuantity;

                                if ($totalRequestedQuantity <= $availableQuantity) {
                                    $_SESSION["cart_item"][$productByCode["id"]]["quantity"] = $totalRequestedQuantity;
                                } else {
                                    echo '<script>alert("Not enough stock available!")</script>';
                                }
                            } else {
                                // Product is not in the cart
                                if ($requestedQuantity <= $availableQuantity) {
                                    $_SESSION["cart_item"][$productByCode["id"]] = array(
                                        'catname' => $productByCode["CategoryName"],
                                        'compname' => $productByCode["CompanyName"],
                                        'quantity' => $requestedQuantity,
                                        'pname' => $productByCode["ProductName"],
                                        'price' => $productByCode["ProductPrice"],
                                        'code' => $productByCode["id"]
                                    );
                                } else {
                                    echo '<script>alert("Not enough stock available!")</script>';
                                }
                            }
                        } else {
                            // Cart is empty
                            if ($requestedQuantity <= $availableQuantity) {
                                $_SESSION["cart_item"][$productByCode["id"]] = array(
                                    'catname' => $productByCode["CategoryName"],
                                    'compname' => $productByCode["CompanyName"],
                                    'quantity' => $requestedQuantity,
                                    'pname' => $productByCode["ProductName"],
                                    'price' => $productByCode["ProductPrice"],
                                    'code' => $productByCode["id"]
                                );
                            } else {
                                echo '<script>alert("Not enough stock available!")</script>';
                            }
                        }
                    }
                } else {
                    // echo '<script>alert("Invalid quantity!")</script>';
                }
                break;
            case "remove":
                // Check if the cart is not empty
                if (!empty($_SESSION["cart_item"])) {
                    // Check if the product code exists in the cart
                    if (array_key_exists($_GET["code"], $_SESSION["cart_item"])) {
                        // Remove the specified product from the cart
                        unset($_SESSION["cart_item"][$_GET["code"]]);

                        // Check if the cart is empty after removing the product
                        if (empty($_SESSION["cart_item"])) {
                            // If the cart is empty, unset the entire cart session
                            unset($_SESSION["cart_item"]);
                        }
                    }
                }
                break;
            case "empty":
                unset($_SESSION["cart_item"]);
                break;
        }
    }

    // Code for Checkout
    if (isset($_POST['checkout'])) {
        $cmobileno = $_POST['mobileno'];
        $pattern = '/^[0-9]{10}$/';
        $cname = $_POST['customername'];
        $patternCN = '/^[A-Za-z ]+$/';
        if (preg_match($pattern, $cmobileno) and preg_match($patternCN, $cname)) {
            $userID = $_SESSION['aid'];
            $invoiceno = mt_rand(100000000, 999999999);
            $pid = $_SESSION['productid'];
            $quantity = $_POST['quantity'];

            $pmode = $_POST['paymentmode'];
            $value = array_combine($pid, $quantity);
            foreach ($value as $pdid => $qty) {
                $uopstock = 0;
                $query = mysqli_query($con, "insert into orders(userID,ProductId,Quantity,InvoiceNumber,CustomerName,CustomerContactNo,PaymentMode) values('$userID','$pdid','$qty','$invoiceno','$cname','$cmobileno','$pmode')");
                $getstock = mysqli_query($con, "SELECT Stock FROM products WHERE id='$pdid'");
                $productByStock = mysqli_fetch_array($getstock);
                $stock = $productByStock['Stock'];
                $upstock = intval($stock) - intval($qty);
                $uppro = mysqli_query($con, "update products set Stock='$upstock' where id='$pdid'");
            }
            echo '<script>alert("Invoice generated successfully. Invoice number is ' . $invoiceno . '")</script>';
            unset($_SESSION["cart_item"]);
            $_SESSION['invoice'] = $invoiceno;
            echo "<script>window.location.href='invoice.php'</script>";
        } else {
            echo '<script>alert("enter valid information!")</script>';
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Search Product</title>
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
                        <li class="breadcrumb-item text-white"><a href="#">Search</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Product</li>
                    </ol>
                </nav>
                <!-- /Breadcrumb -->

                <!-- Container -->
                <div class="container">
                    <!-- Title -->
                    <div class="hk-pg-header">
                        <h4 class="hk-pg-title text-white"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Search Product</h4>
                    </div>
                    <!-- /Title -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col-xl-12">
                            <table id="datable_1" border="1" class="table table-hover w-100 display pb-30 bg-white">
                                <thead>
                                    <tr>
                                        <!-- <th>Select</th> -->
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Sub-Category</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form method="POST" action="test.php">
                                        <?php
                                        $userID = $_SESSION['aid'];
                                        $rno = mt_rand(10000, 99999);
                                        $query = mysqli_query($con, "select * from products where userID='$userID'");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo $row['ProductName']; ?></td>
                                                <td><?php echo $row['SubCategoryName']; ?></td>
                                                <td><?php echo $row['Stock']; ?></td>
                                            </tr>
                                        <?php
                                            $cnt++;
                                        } ?>
                                        <!-- <input type="submit" name="submit" value="Delete All Selected"> -->
                                    </form>
                                </tbody>

                            </table>
                            <section class="hk-sec-wrapper">

                                <div class="row">
                                    <div class="col-sm">
                                        <form class="needs-validation" method="post" novalidate>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Product Name</label>
                                                    <input type="text" class="form-control" id="validationCustom03" placeholder="Product Name" name="productname" required>
                                                    <div class="invalid-feedback">Please provide a valid product name.</div>
                                                </div>
                                            </div>


                                            <button class="btn btn-primary" type="submit" name="search">search</button>
                                        </form>
                                    </div>
                                </div>
                            </section>
                            <!--code for search result -->
                            <?php if (isset($_POST['search'])) { ?>
                                <section class="hk-sec-wrapper">

                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="table-wrap">
                                                <table id="datable_1" class="table table-hover w-100 display pb-30">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Category</th>
                                                            <th>Company</th>
                                                            <th>Product</th>
                                                            <th>Pricing</th>
                                                            <th>Quantity</th>
                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $userID = $_SESSION['aid'];
                                                        $pname = $_POST['productname'];
                                                        $query = mysqli_query($con, "select * from products where ProductName like '%$pname%' and userID='$userID'");
                                                        $cnt = 1;
                                                        while ($row = mysqli_fetch_array($query)) {
                                                        ?>
                                                            <form method="post" action="search-product.php?action=add&pid=<?php echo $row["id"]; ?>">
                                                                <tr>
                                                                    <td><?php echo $cnt; ?></td>
                                                                    <td><?php echo $row['CategoryName']; ?></td>
                                                                    <td><?php echo $row['CompanyName']; ?></td>
                                                                    <td><?php echo $row['ProductName']; ?></td>
                                                                    <td><?php echo $row['ProductPrice']; ?></td>
                                                                    <td><input type="text" class="product-quantity" name="quantity" value="1" size="2" /></td>
                                                                    <td>
                                                                        <?php
                                                                        if ($row["Stock"] == 0 || $row["Stock"] < 0) {
                                                                        ?>
                                                                            <input type="submit" value="Out Of Stock" class="btnAddAction" style="padding: 6px; background-color: #FF2E2E; border-radius: 3px; text-align: center; font-weight: 400; border: 1px solid transparent;" />
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <input type="submit" value="Add to Cart" class="btnAddAction" style="padding: 6px; background-color: #20B22F; border-radius: 3px; text-align: center; font-weight: 400; border: 1px solid transparent;" />

                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            </form>
                                                        <?php
                                                            $cnt++;
                                                        } ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            <?php } ?>


                            <form class="needs-validation" method="post" novalidate>

                                <!--- Shopping Cart ---->
                                <section class="hk-sec-wrapper">

                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="table-wrap">
                                                <h4>Shopping Cart</h4>
                                                <hr />

                                                <a id="btnEmpty" href="search-product.php?action=empty">Empty Cart</a>
                                                <?php
                                                if (isset($_SESSION["cart_item"])) {
                                                    $total_quantity = 0;
                                                    $total_price = 0;
                                                ?>
                                                    <table id="datable_1" class="table table-hover w-100 display pb-30" border="1">
                                                        <tbody>
                                                            <tr>
                                                                <th>Product Name</th>
                                                                <th>Category</th>
                                                                <th>Company</th>
                                                                <th width="5%">Quantity</th>
                                                                <th width="10%">Unit Price</th>
                                                                <th width="10%">Price</th>
                                                                <th width="5%">Remove</th>
                                                            </tr>
                                                            <?php
                                                            $productid = array();
                                                            foreach ($_SESSION["cart_item"] as $item) {
                                                                $item_price = $item["quantity"] * $item["price"];
                                                                array_push($productid, $item['code']);

                                                            ?>
                                                                <input type="hidden" value="<?php echo $item['quantity']; ?>" name="quantity[<?php echo $item['code']; ?>]">
                                                                <tr>
                                                                    <td><?php echo $item["pname"]; ?></td>
                                                                    <td><?php echo $item["catname"]; ?></td>
                                                                    <td><?php echo $item["compname"]; ?></td>
                                                                    <td><?php echo $item["quantity"]; ?></td>
                                                                    <td><?php echo $item["price"]; ?></td>
                                                                    <td><?php echo number_format($item_price, 2); ?></td>
                                                                    <td><a href="search-product.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="dist/img/remove.png" alt="Remove Item" /></a></td>
                                                                </tr>
                                                            <?php
                                                                $total_quantity += $item["quantity"];
                                                                $total_price += ($item["price"] * $item["quantity"]);
                                                            }
                                                            $_SESSION['productid'] = $productid;
                                                            ?>

                                                            <tr>
                                                                <td colspan="3" align="right">Total:</td>
                                                                <td colspan="2"><?php echo $total_quantity; ?></td>
                                                                <td colspan=><strong><?php echo number_format($total_price, 2); ?></strong></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-10">
                                                            <label for="validationCustom03">Customer Name</label>
                                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Customer Name" name="customername" required>
                                                            <div class="invalid-feedback">Please provide a valid customer name.</div>
                                                        </div>
                                                        <div class="col-md-6 mb-10">
                                                            <label for="validationCustom03">Customer Mobile Number</label>
                                                            <input type="number" class="form-control" id="validationCustom03" placeholder="Mobile Number" name="mobileno" required>
                                                            <div class="invalid-feedback">Please provide a valid mobile number.</div>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-10">
                                                            <label for="validationCustom03">Payment Mode</label>
                                                            <div class="custom-control custom-radio mb-10">
                                                                <input type="radio" class="custom-control-input" id="customControlValidation2" name="paymentmode" value="cash" required>
                                                                <label class="custom-control-label" for="customControlValidation2">Cash</label>
                                                            </div>
                                                            <!-- <div class="custom-control custom-radio mb-10">
                                                                <input type="radio" class="custom-control-input" id="customControlValidation3" name="paymentmode" value="card" required>
                                                                <label class="custom-control-label" for="customControlValidation3">Card</label>
                                                            </div> -->
                                                        </div>
                                                        <div class="col-md-6 mb-10">
                                                            <button class="btn btn-primary" type="submit" name="checkout">Checkout</button>
                                                        </div>
                                                    </div>
                            </form>

                        <?php
                                                } else {
                        ?>
                            <div style="color:red" align="center">Your Cart is Empty</div>
                        <?php
                                                }
                        ?>
                        </div>
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
        <style type="text/css">
            #btnEmpty {
                background-color: #ffffff;
                border: #d00000 1px solid;
                padding: 5px 10px;
                color: #d00000;
                float: right;
                text-decoration: none;
                border-radius: 3px;
                margin: 10px 0px;
            }
        </style>

    </body>

    </html>
<?php 
/*
// Required if your environment does not handle autoloading
require __DIR__ . '/vendor/autoload.php';
// require __DIR__ . 'twilio-php-main\src\Twilio\autoload.php';

// Your Account SID and Auth Token from console.twilio.com
$sid = "AC0995e863a5a20fcd23b1c24118811d20";
$token = "a6841490f522a5808341b9ee3db2ba0e";
$client = new Client($sid, $token);

// Use the Client to make requests to the Twilio REST API
$client->messages->create(
    // The number you'd like to send the message to
    '+918849097364',
    [
        // A Twilio phone number you purchased at https://console.twilio.com
        'from' => '+13158645338',
        // The body of the text message you'd like to send
        'body' => "Hey Jenny! Good luck on the bar exam!"
    ]
);*/
}
?>