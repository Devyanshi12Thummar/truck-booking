<?php

require('conection.php');

require 'map/vendor/autoload.php'; // Path to your Composer autoload file
use GuzzleHttp\Client;

// if (!isset($_SESSION['customerfullname'])) {
//     header("Location: login.php");
// }
session_start();


$pidate = $_SESSION["pick"];
$dropdate = $_SESSION["drop"];
$custid = $_SESSION['cust_id'];
$truckid = $_SESSION['tid'];


$sql = "SELECT * FROM `truck_detials` WHERE truck_id = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $truckid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);




// truck company name fatch
$sql1 = "SELECT truck_detials.truck_company_id, truck_company.truck_company_id, truck_company.truck_company_name
         FROM truck_detials
         INNER JOIN truck_company ON truck_detials.truck_company_id = truck_company.truck_company_id
         WHERE truck_detials.truck_id = ?";

$stmt1 = mysqli_prepare($conn, $sql1);
mysqli_stmt_bind_param($stmt1, "s", $truckid);
mysqli_stmt_execute($stmt1);
$result1 = mysqli_stmt_get_result($stmt1);
$row1 = mysqli_fetch_assoc($result1);


$loginquery = "SELECT * FROM user_master WHERE user_id = ?";
$stmtLi = mysqli_prepare($conn, $loginquery);
mysqli_stmt_bind_param($stmtLi, "i", $custid);
mysqli_stmt_execute($stmtLi);
$resultLi = mysqli_stmt_get_result($stmtLi);


if (isset($_POST['submit'])) {


    $pick_address = mysqli_real_escape_string($conn, ($_POST['pickup_address']));
    $drop_address = mysqli_real_escape_string($conn, ($_POST['drop_address']));
    $goods_weight = mysqli_real_escape_string($conn, ($_POST['goods_weight']));
    $goodsselect = mysqli_real_escape_string($conn, ($_POST['goods_type']));


    if ($goodsselect == "others") {
        $customGoodsType = mysqli_real_escape_string($conn, ($_POST['goods_type_input']));

        // Insert the custom goods type into the database
        $insertGoodsTypeQuery = "INSERT INTO goods (goods_type) VALUES (?)";
        $stmtGoodsType = mysqli_prepare($conn, $insertGoodsTypeQuery);
        mysqli_stmt_bind_param($stmtGoodsType, "s", $customGoodsType);
        mysqli_stmt_execute($stmtGoodsType);

        // Get the ID of the newly inserted goods type
        $newGoodsTypeId = mysqli_insert_id($conn);

        // Use the new goods type ID for the booking
        $goodsselect = $newGoodsTypeId;
    }
    


    if ($pidate <= $dropdate) {
        $select_users = mysqli_query($conn, "SELECT * from  `truck_booking` WHERE pickup_date='$pidate'  and drop_date='$dropdate' and  pickup_address='$pick_address' and drop_address='$drop_address' and goods_weight='$goods_weight'  and truck_id='$truckid' and goods_id='$goodsselect'") or die('query failed');

        if (mysqli_num_rows($select_users) > 0) {
        } elseif ($pick_address == "") {
            echo '<script>alert(" pickup address must be filled out")</script>';
        } elseif ($drop_address == "") {
            echo '<script>alert(" drop Address must be filled out")</script>';
        } elseif ($goods_weight == "") {
            echo '<script>alert("gooda weight must be filled out")</script>';
        } elseif ($goodsselect == "") {
            echo '<script>alert("gooda type must be filled out")</script>';
        } else {
            $_SESSION['piadd'] = $pick_address;
            $_SESSION['dradd'] = $drop_address;
            $_SESSION['goodweight'] = $goods_weight;
            $_SESSION['goodtype'] = $goodsselect;

          
            // Replace with your actual Mapbox access token
            $accessToken = 'pk.eyJ1IjoicnVzaGlsMjMwNCIsImEiOiJjbGxpYmg1cW4xdGQxM3FxaG13ZjFwZTV0In0.dK4uGgaJUUWSb0rQdK137g'; // Replace with your actual Mapbox access token
            
            // Initialize variables to store distance and address
            
            $startAddress = "{$_SESSION['piadd']}";
            $endAddress = "{$_SESSION['dradd']}";
            // Check if the form has been submitted
            // if (isset($_POST['submit'])) {
                // Get addresses of the starting and ending locations from user input
                $startAddress = "{$_SESSION['piadd']}";
                $endAddress =  "{$_SESSION['dradd']}";
            
                // Initialize Guzzle HTTP client
                $client = new Client();
            
                // Geocode starting and ending addresses to get coordinates
                $geocodeEndpoint = "https://api.mapbox.com/geocoding/v5/mapbox.places/";
                $geocodeParams = [
                    'access_token' => $accessToken,
                    'country' => 'IN', // Specify the country for more accurate results
                ];
            
                $responseStart = $client->get($geocodeEndpoint . urlencode($startAddress) . '.json', ['query' => $geocodeParams]);
                $responseEnd = $client->get($geocodeEndpoint . urlencode($endAddress) . '.json', ['query' => $geocodeParams]);
            
                $dataStart = json_decode($responseStart->getBody(), true);
                $dataEnd = json_decode($responseEnd->getBody(), true);
            
                // Extract coordinates from the geocoding responses
                $startCoord = $dataStart['features'][0]['center'];
                $endCoord = $dataEnd['features'][0]['center'];
            
                // Calculate the distance using the Haversine formula
                function haversineDistance($coord1, $coord2) {
                    $radius = 6371; // Earth's radius in kilometers
                
                    list($lon1, $lat1) = $coord1;
                    list($lon2, $lat2) = $coord2;
                
                    $dLat = deg2rad($lat2 - $lat1);
                    $dLon = deg2rad($lon2 - $lon1);
                
                    $a = sin($dLat / 2) * sin($dLat / 2) +
                        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                        sin($dLon / 2) * sin($dLon / 2);
                    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                
                    $distance = $radius * $c; // Distance in kilometers
                    return $distance;
                }
                
                $distance = haversineDistance($startCoord, $endCoord);
               
            
                $sql0 ="select * from truck_detials where truck_id='{$_SESSION["tid"]}'";
                $result0 = mysqli_query($conn,$sql0); 
                $row=mysqli_fetch_assoc($result0);
                $fulechrgeperkm = $row['fule_rate'];
                $truckrateperday = $row['day_rate'];
            
            
            
                $totalfulerate= $fulechrgeperkm * $distance;
                $date1 = new DateTime($_SESSION["pick"]);
                $date2 = new DateTime($_SESSION["drop"]);
            
                $interval = $date1->diff($date2);
                $totaldays = $interval->days;
            
                $daycost = $truckrateperday * $totaldays;
            
            
                $totalingpayment=$daycost + $totalfulerate;
        
                $parts = explode('.', number_format($totalingpayment, 2));
                $totalprice = $parts[0] . '.' . substr($parts[1], 0, 2);

                $payment_amount= sprintf("%.2f", $totalingpayment);

                $_SESSION['pay_amount'] = $payment_amount;

                $_SESSION['totalamount'] = $totalprice;
                
     
                if(isset($_SESSION["totalamount"]))
                {
                    header('location: payment/payment_estiment.php');
                }
            
        }

    } else {
        echo '<script>alert("Pickup date is Not valid beacuse pickup date must be smaller than drop date")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>TBTS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap"
        rel="stylesheet">

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
    <link rel="stylesheet" href="css/summary_css.css">

   
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.html">T B <span>T S</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <!-- <li class="nav-item active"><a href="Booking.php" class="nav-link">Booking</a></li> -->
                    <li class="nav-item"><a href="our_truck.php" class="nav-link">Our Truck</a></li>
                    <li class="nav-item"><a href="booking_history.php" class="nav-link">Booking History</a></li>
                    <li class="nav-item"><a href="profile.php" class="nav-link">My Profile</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->

    <div class="hero-wrap" style="background-image: url('images/a.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text justify-content-start align-items-center">
                <div class="col-lg-6 col-md-6 ftco-animate d-flex align-items-end">
                    <div class="text">
                        <h1 class="mb-4">Booking<span>Now</span></h1>
                        <p style="font-size: 18px;">A small river named Duden flows by their place and supplies it with
                            the necessary regelialia. It is a paradisematic country, in which roasted parts</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section ftco-no-pb ftco-no-pt">
        <div class="container">
            <br>
            <form method="post" class="request-form ftco-animate">
               
                <br>

                <div class="d-flex ">
                    <div class="col-4">

                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

                            <div class="carousel-inner">

                                <div class="carousel-item active">
                                    <img class="d-block " style="width: 300px;;"
                                        src="<?php echo $row['truck_image1']; ?>" alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block" style="width: 300px;" src="<?php echo $row['truck_image2']; ?>"
                                        alt="Second slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block" style="width: 300px;" src="<?php echo $row['truck_image3']; ?>"
                                        alt="Third slide">
                                </div>
                                <a class="carousel-control-prev w-26" href="#carouselExampleIndicators" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" style="background-color:black;"
                                        aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" style="background-color:black;"
                                        aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>

                            <ol class="carousel-indicators">
                                <span class="dot" data-target="#carouselExampleIndicators" class="active"></span>
                                <span class="dot" data-target="#carouselExampleIndicators"></span>
                                <span class="dot" data-target="#carouselExampleIndicators"></span>

                            </ol>
                        </div>
                    </div>

                    <div class="col-8" style="margin-left:200px;">
<br>
                        <p class="product-title" style="color:black;">Truck Name :
                            <?php echo $row["truck_name"]; ?>
                        </p>

                        <p class="review-no"style="color:black;">Company Name :
                            <?php echo $row1["truck_company_name"]; ?>
                        </p>

                        <p class="review-no"style="color:black;">Truck Size :
                            <?php echo $row["truck_size"]; ?>
                        </p>

                        <p class="review-no"style="color:black;">Truck Capacity :
                            <?php echo $row["truck_capacity"]; ?>
                        </p>
                    </div>
                </div>
<br>
                <div class="d-flex">
                    <div class="form-group mr-2">
                    <label for="" class="label">Pick-up Date</label><br>
                    <input type="text"class="form-control" readonly value="<?php echo $pidate ?>">
                    </div>
                    <div class="form-group ml-2">
                    <label for="" class="label">Drop-up Date</label><br>
                    <input  type="text" class="form-control" readonly value="<?php echo $dropdate ?>">
                    </div>
                </div>
               
                <div class="d-flex">
                    <div class="form-group mr-2">
                        <label for="" class="label">Pick-up location<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" name="pickup_address"
                            placeholder="City, Airport, Station, etc">
                    </div>
                    <div class="form-group ml-2">
                        <label for="" class="label">Drop-off location<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" name="drop_address"
                            placeholder="City, Airport, Station, etc">
                    </div>
                </div>
                <div class="d-flex">
                    <div class="form-group mr-2">
                        <label for="" class="label">Goods Weight(kg)<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" name="goods_weight" onkeypress="return event.charCode>=46 && event.charCode<=57"placeholder="goods weight">
                    </div>
                    <div class="form-group ml-2">
                        <label for="" class="label">Select Goods Type<span style="color:red;">*</span></label>

                        <div class="form-field">
                            <div class="select-wrap">
                                <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                <select name="goods_type"  id = "ddlPassport" class="form-control" onchange = "ShowHideDiv()">
                                    <option value="">Select Goods</option>

                                    <?php
                                    require('conection.php');
                                    $sql = "select * from goods";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $row['goods_id']; ?>"> <?php echo $row['goods_type']; ?>
                                        </option>

                                    <?php }

                                    ?>
                                    <option>others</option>
                                </select>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="form-group mr-2"></div>
                    <div class="form-group ml-2">

                        <div class="form-field" id="dvPassport" style="display: none">
                            <div class="select-wrap">

                                <input type="text" placeholder="Enter goods type" id="goods_type_input" class="form-control" name="goods_type_input">
                            </div>
                                <script type="text/javascript">
                                    function ShowHideDiv() {
                                        var ddlPassport = document.getElementById("ddlPassport");
                                        var dvPassport = document.getElementById("dvPassport");
                                        var goodsTypeInput = document.getElementById("goods_type_input");

                                        if (ddlPassport.value == "others") {
                                            dvPassport.style.display = "block";
                                            goodsTypeInput.required = true;
                                        } else {
                                            dvPassport.style.display = "none";
                                            goodsTypeInput.required = false;
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                </div>
              

                <!-- <button type="button" name="submit" style="margin-left: 90%;" class="btn btn-outline-warning changbtn">Book Now</button> -->
                <input type="submit" name="submit" onclick="document.getElementById('id01').style.display='none'"
                    style="margin-left: 45%;" class="btn btn-outline-warning " value="Confirm Booking">

            </form>
        </div><br><br>
    </section>


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
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="js/google-map.js"></script>
    <script src="js/main.js"></script>

</body>

</html>