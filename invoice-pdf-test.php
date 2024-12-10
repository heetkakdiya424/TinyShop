<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    // Code for deletion   
    if (isset($_GET['del'])) {
        $cmpid = substr(base64_decode($_GET['del']), 0, -5);
        $query = mysqli_query($con, "delete from  category where id='$cmpid'");
        echo "<script>alert('Category record deleted.');</script>";
        echo "<script>window.location.href='manage-categories.php'</script>";
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Manage Invoices</title>
        <!-- Data Table CSS -->
        <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
        <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
        <link href="dist/css/style.css" rel="stylesheet" type="text/css">

        
    </head>

    <body>
    <script>
        // Use setTimeout to delay the printing for half a second (500 milliseconds)
        setTimeout(function() {

            window.print();
            // After printing, navigate back to the previous page
            window.history.back();
        }, 200);
    </script>
            <!-- Main Content -->
            <div class="hk-pg-wrapper" id="xyz">

                <!-- Container -->
                <div class="container">

                    <!-- Title -->
                    <!-- <div class="hk-pg-header">
                        <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="file"></i></span></span>View Invoice</h4>
                    </div> -->
                    <!-- /Title -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col-xl-12">


                            <section class="hk-sec-wrapper hk-invoice-wrap pa-35" style="border: 2px solid black;">
                                <div class="invoice-from-wrap">
                                    <div class="row">
                                        <div class="col-md-7 mb-20">
                                            <h3 class="mb-35 font-weight-600"> Tinyshop </h3>
                                            <h6 class="mb-5">invantory Management System</h6>

                                        </div>

                                        <?php
                                        //Consumer Details
                                        $inid = substr(base64_decode($_GET['invid']), 0, -5);
                                        // $inid = '144453506';
                                        $query = mysqli_query($con, "select distinct InvoiceNumber,CustomerName,CustomerContactNo,PaymentMode,InvoiceGenDate  from  orders  where InvoiceNumber='$inid'");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                        ?>
                                            <div class="col-md-5 mb-20">
                                                <h4 class="mb-35 font-weight-600">Invoice / Receipt</h4>
                                                <span class="d-block">Date:<span class="pl-10 text-dark"><?php echo $row['InvoiceGenDate']; ?></span></span>
                                                <span class="d-block">Invoice / Receipt #<span class="pl-10 text-dark"><?php echo $row['InvoiceNumber']; ?></span></span>
                                                <span class="d-block">Customer #<span class="pl-10 text-dark"><?php echo $row['CustomerName']; ?></span></span>
                                                <span class="d-block">Customer Mobile No #<span class="pl-10 text-dark"><?php echo $row['CustomerContactNo']; ?></span></span>
                                                <span class="d-block">Payment Mode #<span class="pl-10 text-dark"><?php echo $row['PaymentMode']; ?></span></span>
                                            </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <hr class="mt-0">



                            <div class="row">
                                <div class="col-sm">
                                    <div class="table-wrap">
                                        <table class="table mb-0" border="1">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product Name</th>
                                                    <th>Category</th>
                                                    <th>Company</th>
                                                    <th width="5%">Quantity</th>
                                                    <th width="10%">Unit Price</th>
                                                    <th width="10%">Price</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //Product Details
                                                $query = mysqli_query($con, "select  products.CategoryName, products.ProductName, products.CompanyName, products.ProductPrice, orders.Quantity  from  orders join  products on  products.id= orders.ProductId where  orders.InvoiceNumber='$inid'");
                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $cnt; ?></td>
                                                        <td><?php echo $row['ProductName']; ?></td>
                                                        <td><?php echo $row['CategoryName']; ?></td>
                                                        <td><?php echo $row['CompanyName']; ?></td>
                                                        <td><?php echo $qty = $row['Quantity']; ?></td>
                                                        <td><?php echo $ppu = $row['ProductPrice']; ?></td>
                                                        <td><?php echo $subtotal = number_format($ppu * $qty, 2); ?></td>
                                                    </tr>

                                                <?php
                                                    $grandtotal += $ppu * $qty;
                                                    $totalqty += $qty;
                                                    $cnt++;
                                                } ?>
                                                <tr style="font-weight: bolder; border: 2px solid black;">
                                                    <td></td>
                                                    <td></td>
                                                    <td style="text-align:right; font-size:20px;">Total</td>
                                                    <td></td>
                                                    <td style="text-align:left; font-size:20px;"><?php echo $totalqty; ?></td>
                                                    <td></td>
                                                    <td style="text-align:left; font-size:20px;"><?php echo number_format($grandtotal, 2); ?></td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- <hr style="margin-top: 50px; border-top: dashed 2px">
                            <hr style="margin-top: -18px; border-top: dashed 2px">
                            <h5 style="text-align: center;">GST Breakup Details</h5>
                            <hr style="margin-bottom: 15px; border-top: dashed 2px">

                            <div class="row">
                                <div class="col-sm">
                                    <div class="table-wrap">
                                        <table class="table mb-0" border="1" style="text-align: center;">
                                            <thead>
                                                <tr>
                                                    <th>GST IND</th>
                                                    <th>Taxable Amt</th>
                                                    <th>CGST</th>
                                                    <th>SGST</th>
                                                    <th>Total Amt</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>1</th>
                                                    <th>100.00</th>
                                                    <th>2.5</th>
                                                    <th>2.5</th>
                                                    <th>105.00</th>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr style="border: 2px solid black;">
                                                    <th>1</th>
                                                    <th>100.00</th>
                                                    <th>2.5</th>
                                                    <th>2.5</th>
                                                    <th>105.00</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div> -->
                            </section>
                        </div>
                    </div>
                    <!-- /Row -->

                </div>
                <!-- /Container -->

                <!-- Footer -->
                <?php include_once('includes/footer.php'); ?>
                <!-- /Footer -->
            </div>
            <!-- /Main Content -->

        <script src="vendors/jquery/dist/jquery.min.js"></script>
        <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
        <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="dist/js/jquery.slimscroll.js"></script>
        <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="vendors/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
        <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="vendors/jszip/dist/jszip.min.js"></script>
        <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
        <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
        <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="dist/js/dataTables-data.js"></script>
        <script src="dist/js/feather.min.js"></script>
        <script src="dist/js/dropdown-bootstrap-extended.js"></script>
        <script src="vendors/jquery-toggles/toggles.min.js"></script>
        <script src="dist/js/toggle-data.js"></script>
        <script src="dist/js/init.js"></script>
    </body>

    </html>
<?php } ?>