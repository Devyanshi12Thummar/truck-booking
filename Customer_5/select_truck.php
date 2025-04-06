<?php

session_start();
require('conection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>TBTS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">


    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<!-- <style>
    .styled {
        border: 0;
        line-height: 2.5;
        padding: 0 20px;
        font-size: 1rem;
        text-align: center;
        color: black;
        text-shadow: 1px 1px 1px #000;
        border-radius: 10px;
        background-color: #ffa5008f;
        background-image: linear-gradient(to top left, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) 30%, rgba(0, 0, 0, 0));
        box-shadow: inset 2px 2px 3px rgba(255, 255, 255, 0.6), inset -2px -2px 3px rgba(0, 0, 0, 0.6);
    }

    .styled:hover {
        background-color: orange;
    }

    .styled:active {
        box-shadow: inset -2px -2px 3px rgba(255, 255, 255, 0.6), inset 2px 2px 3px rgba(0, 0, 0, 0.6);
    }
</style> -->

<body>



<br>
    <header>
       
        <div class="container">
            <div class="row justify-content-center align-items-center text-center logo-block">
                <div class="col-md-12">
                    <nav class="navbar navbar-light ">
                        <div><a class="navbar-brand" href="">
                                <a style="font-size:30px"class="navbar-brand" href="index.php">T B <span class="text-warning">T S</span></a>
                        </div>
                        <div class="cust-phone">
                            <span class="btn-block"><a href="index.php" > Home</a></span>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        </div>
    </header>

    <div class="header-bottom-block" style=" background: #eee;">
        <div class="container p-1">
            <div class="d-flex justify-content-center align-items-center">
                <div class="mr-2">
                    <svg  width="24" height="24">
                        <g>
                            <g>
                                <path d="M198.608,246.104L382.664,62.04c5.068-5.056,7.856-11.816,7.856-19.024c0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12 C361.476,2.792,354.712,0,347.504,0s-13.964,2.792-19.028,7.864L109.328,227.008c-5.084,5.08-7.868,11.868-7.848,19.084 c-0.02,7.248,2.76,14.028,7.848,19.112l218.944,218.932c5.064,5.072,11.82,7.864,19.032,7.864c7.208,0,13.964-2.792,19.032-7.864 l16.124-16.12c10.492-10.492,10.492-27.572,0-38.06L198.608,246.104z"></path>
                            </g>
                        </g>

                    </svg>
                </div>
                <div class=" d-flex justify-content-center align-items-center" style="flex: 1 1 0%;">
                    <div class="text-center location_text" title="S Andrews Church, Avadhanam Papier Road, Choolai, Chennai, Tamil Nadu, India" style="text-overflow: ellipsis; overflow: hidden; cursor: alias; white-space: normal;">S Andrews Church, Avadhanam Papier Road, Choolai, Chennai, Tamil Nadu, India</div>
                    <div class="d-flex justify-content-center distance">
                        <b class="text-center ">
                            <div class="d-flex flex-column align-items-center">
                                <svg width="32" height="32" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
                                </svg>1300 KM
                            </div>
                        </b>
                    </div>
                    <div class="text-center location_text" title="D Mart, Dattanagar, Badlapur, Maharashtra, India" style="text-overflow: ellipsis; overflow: hidden; cursor: alias; white-space: normal;">D Mart, Dattanagar, Badlapur, Maharashtra, India</div>
                </div>
            </div>
        </div>
    </div>

    
<br><br>
    <div class="container py-4" style="flex: 1 1 0%; overflow: auto;">
        <div class="slide-left-anim">
            <div class="fade-in-anim">
                <form method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <h5> Truck Type</h5>

                                <div class="form-group">
                                    <!-- <span class="form-label">Select Truck</span> -->
                                    <select name="truck" class="form-control" id="goods">
                                        <option value="">Select Truck</option>
                                        <?php
                                        require('conection.php');
                                        $sql = "select * from truck";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <option value="<?php echo $row['t_name']; ?>"> <?php echo $row['t_name']; ?> </option>

                                        <?php } ?>


                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 ">
                            <br><br>
                            &emsp;&emsp;&emsp;  &emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp; <h7 style="color:red"> Esstimate Price :1000</h7>
                        </div>
                    </div>
                    <br><br>
                    <div class="text-center">
                    <a  href="login.php"> Book Now</a>
                       
                    </div>
                </form>


            </div>

        </div>
    </div>

    <!-- END nav -->

    <footer class="bg-light text-center text-lg-start m">
 
  <div class="text-center p-3" style="background-color: black;">
    © 2020 Copyright:
    <a class="text-light" href="https://mdbootstrap.com/">MDBootstrap.com</a>
  </div>
  
</footer>


    <!-- loader -->
    <!-- <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div> -->


    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/jquery.timepicker.min.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="js/google-map.js"></script>
    <script src="js/main.js"></script>

</body>

</html>