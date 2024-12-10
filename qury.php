<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Add Company</title>
        <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
        <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
        <link href="dist/css/style.css" rel="stylesheet" type="text/css">
        <style>
       

        .comment-form {
            background: #fff;
            padding-left: 20px;
            padding-right: 45px;
            padding-top: 20px;
            padding-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .comment-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .comment-form label {
            display: block;
            margin-bottom: 5px;
        }

        .comment-form input,
        .comment-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .comment-form textarea {
            height: 100px;
            resize: vertical;
        }

        .comment-form button {
            
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        
    </style>
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
                        <!-- <li class="breadcrumb-item text-white"><a href="#">Company</a></li> -->
                        <li class="breadcrumb-item active text-white" aria-current="page">Quary form</li>
                    </ol>
                </nav>
                <!-- /Breadcrumb -->

                <!-- Container -->
                <div class="container">
                    <!-- Title -->
                    <div class="hk-pg-header">
                        <h4 class="hk-pg-title text-white"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Quary form</h4>
                        <h6 class="text-red">*make sure your internet is connect</h6>
                    </div>
                    <!-- /Title -->

                    <!-- Row -->
                    <div class="row">
                        <div class="col-xl-12">
                            <section class="hk-sec-wrapper">

                                <div class="row">
                                    <div class="col-sm">
                                    <div class="comment-form">
                                        <h2>Leave a Comment</h2>
                                        <form action="https://api.web3forms.com/submit" method="POST">
                                            <input type="hidden" name="access_key" value="3b3575bd-ce65-4492-be05-3833db42f401">

                                            <label for="name">Name</label>
                                            <input type="text" name="name" required>

                                            <label for="email">Email</label>
                                            <input type="email" name="email" required>

                                            <label for="comment">Comment</label>
                                            <textarea id="comment" name="message" required></textarea>

                                            <!-- Honeypot Spam Protection -->
                                            <input type="checkbox" name="botcheck" class="hidden" style="display: none;">

                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </form>
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

    </body>

    </html>