<?php
include('includes/config.php');
 $query="SELECT orders.* , products.ProductPrice FROM orders,products where orders.ProductId=products.id";
 $result=mysqli_query($con,$query);
 while($row=mysqli_fetch_array($result)){
    echo 'Invoice / Receipt #'.$row['InvoiceNumber'];
                                                    echo 'Customer name #'.$row['CustomerName'];
                                                    // echo 'Customer Mobile No #'.$row['InvoiceNumber'];
                                                    echo 'Payment Mode #'.$row['PaymentMode'];
                                                    $ppu = $row['ProductPrice'];
                                                    $qty = $row['Quantity'];
                                                    $subtotal = number_format($ppu * $qty, 2);
                                                    echo 'price #'.$subtotal;
 }  

?>