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
        $catname = $_POST['category'];
        $catcode = $_POST['categorycode'];

        // add Category in database
        $query = mysqli_query($con, "insert into category(userID,CategoryName,CategoryCode) values('$userID','$catname','$catcode')");

        // add SubCategory in database 
        for ($i = 1; $i <= 100; $i++) {
            if ($GLOBALS['total_sub_category'] == 20) {
                break;
            } else {
                if (isset($_POST['subcategory' . $i])) {
                    $subcatname = $_POST['subcategory' . $i];
                    $subcatcode = $_POST['subcategorycode' . $i];
                    $query1 = mysqli_query($con, "insert into subcategory(userID,category_code,sub_category_code,sub_category_name) values('$userID','$catcode','$subcatcode','$subcatname')");
                    $GLOBALS['total_sub_category']++;
                }
            }
        }

        if ($query & $query1) {
            echo "<script>alert('Category added successfully.');</script>";
            echo "<script>window.location.href='add-category.php'</script>";
        } else {
            if (!$query) {
                // Handle the error for the first query
                echo "<script>alert('Query 1 failed: " . mysqli_error($con) . "');</script>";
            }
            if (!$query1) {
                // Handle the error for the second query
                echo "<script>alert('Query 2 failed: " . mysqli_error($con) . "');</script>";
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
                    <ol class="breadcrumb breadcrumb-light bg-transparent ">
                        <li class="breadcrumb-item active text-white"><a href="#">Category</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Add Category</li>
                    </ol>
                </nav>
                <!-- /Breadcrumb -->

                <!-- Container -->
                <div class="container">
                    <!-- Title -->
                    <div class="hk-pg-header">
                        <h4 class="hk-pg-title text-white"><span class="pg-title-icon "><span class="feather-icon"><i data-feather="external-link"></i></span></span>Add Category</h4>
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
                                                    <label for="validationCustom03">Category</label>
                                                    <input type="text" class="form-control" id="validationCustom03" placeholder="Category" name="category" required>
                                                    <div class="invalid-feedback">Please provide a valid category name.</div>
                                                </div>
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Category Code</label>
                                                    <input type="text" class="form-control" id="validationCustom03" placeholder="Category Code" name="categorycode" required>
                                                    <div class="invalid-feedback">Please provide a valid category code.</div>
                                                </div>
                                            </div>

                                            <div class="form-row" id="dynamic-container">
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Sub Category</label>
                                                    <input type="text" class="form-control" id="validationCustom03" placeholder="Sub Category" name="subcategory1" required>
                                                    <div class="invalid-feedback">Please provide a valid category name.</div>
                                                </div>
                                                <div class="col-md-6 mb-10">
                                                    <label for="validationCustom03">Sub Category Code</label>
                                                    <input type="text" class="form-control" id="validationCustom03" placeholder="Sub Category Code" name="subcategorycode1" required>
                                                    <div class="invalid-feedback">Please provide a valid category code.</div>
                                                </div>
                                            </div>
                                            <button class="btn btn-success" type="button" id="add-button">+</button>
                                            <span id="sc-left" style="margin-left:20px; color:brown;">19 sub category left</span>
                                            <span style="margin-left:518px; color:brown;">* At a time, 20 subcategories will be accepted</span>
                                            <br>
                                            <br>

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


        <script>
            var total_sub_category = 2;
            var scleftnum = 19;
            document.addEventListener("DOMContentLoaded", function() {
                const addButton = document.getElementById("add-button");
                const container = document.getElementById("dynamic-container");
                var scleft = document.getElementById("sc-left");

                if (scleftnum != 0) {
                    addButton.addEventListener("click", function() {

                        // Create a new div element
                        const newDiv = document.createElement("div");
                        newDiv.className = "col-md-6 mb-10";

                        // Create a div to contain the input and remove button
                        const inputContainer = document.createElement("div");
                        inputContainer.className = "input-container";

                        // Create the elements within the new div
                        const label = document.createElement("label");
                        label.setAttribute("for", "validationCustom03");
                        label.textContent = "Sub Category";

                        const input = document.createElement("input");
                        input.type = "text";
                        input.className = "form-control";
                        input.id = "validationCustom03";
                        input.placeholder = "Sub Category";
                        input.name = "subcategory" + total_sub_category;
                        input.required = true;

                        // Create a Remove button
                        const removeButton = document.createElement("button");
                        removeButton.type = "button";
                        removeButton.className = "remove-button"; // Apply the classes
                        removeButton.addEventListener("click", function() {
                            container.removeChild(newDiv);
                            container.removeChild(newDiv1); // Remove the clicked div
                            scleftnum++;
                            scleft.innerText = scleftnum + " sub category left";
                        });




                        // Create a new div element
                        const newDiv1 = document.createElement("div");
                        newDiv1.className = "col-md-6 mb-10";

                        // Create a div to contain the input and remove button
                        const inputContainer1 = document.createElement("div");
                        inputContainer1.className = "input-container";

                        // Create the elements within the new div
                        const label1 = document.createElement("label");
                        label1.setAttribute("for", "validationCustom03");
                        label1.textContent = "Sub Category Code";

                        const input1 = document.createElement("input");
                        input1.type = "text";
                        input1.className = "form-control";
                        input1.id = "validationCustom03";
                        input1.placeholder = "Sub Category Code";
                        input1.name = "subcategorycode" + total_sub_category;
                        input1.required = true;

                        // Append the elements to the input container div
                        inputContainer.appendChild(input);
                        // inputContainer.appendChild(removeButton); // Append the Remove button

                        // Append the elements to the new div
                        newDiv.appendChild(label);
                        newDiv.appendChild(inputContainer);

                        // Append the new div to the container
                        container.appendChild(newDiv);


                        // Append the elements to the input container div
                        inputContainer1.appendChild(input1);
                        inputContainer1.appendChild(removeButton); // Append the Remove button

                        // Append the elements to the new div
                        newDiv1.appendChild(label1);
                        newDiv1.appendChild(inputContainer1);

                        // Append the new div to the container
                        container.appendChild(newDiv1);

                        // document.getElementById('inputField').innerHTML = this.responseText;

                        scleftnum--;
                        scleft.innerText = scleftnum + " sub category left";
                        total_sub_category++;
                    });
                }
            });
        </script>


        <style>
            /* Style for the Remove button */
            .remove-button {
                margin-left: 7px;
                background-color: red;
                /* Red background color */
                color: white;
                /* White text color */
                border: none;
                /* No border */
                border-radius: 50%;
                /* Round shape */
                width: 30px;
                /* Set the width */
                height: 30px;
                /* Set the height */
                cursor: pointer;
                /* Change cursor to pointer on hover */
                font-weight: bold;
                /* Make the text bold */
                display: flex;
                /* Use flexbox to center content vertically and horizontally */
                justify-content: center;
                align-items: center;
                transition: background-color 0.3s;
                /* Smooth background color transition on hover */
            }

            /* Style for the 'X' symbol inside the button */
            .remove-button::before {
                content: "✖";
                /* Unicode '✖' symbol (multiplication sign) */
                font-size: 1.2rem;
                /* Adjust the size of the 'X' symbol */
            }

            /* Add some padding to the button */
            .remove-button-padding {
                padding: 5px;
            }

            /* Hover effect: darken the background color */
            .remove-button:hover {
                background-color: darkred;
            }

            .input-container {
                display: flex;
                align-items: center;
            }
        </style>


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