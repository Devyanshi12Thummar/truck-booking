<?php
include 'conection.php';
session_start();


$custid = $_SESSION['user_id'];

$sql = "SELECT * FROM user_master WHERE user_id = ?";
$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $custid);


$stmt->execute();


$result = $stmt->get_result();


$userData = $result->fetch_assoc();


$stmt->close();
$conn->close();

$name = $userData['user_fullname'];
$email = $userData['user_email'];

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
  <style>

  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.php">T B <span>T S</span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
        aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="our_truck.php" class="nav-link">Our Truck</a></li>
          <li class="nav-item"><a href="booking_history.php" class="nav-link">Booking History</a></li>
          <li class="nav-item active"><a href="profile.php" class="nav-link">My Profile</a></li>
          <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
          <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>

        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->

  <div class="hero-wrap" style="background-image: url('images/a.jpg');" data-stellar-background-ratio="0.1">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text justify-content-start align-items-center">
        <div class="col-lg-5 col-md-5 mt-0 mt-md-5">
          <form action="#" class="request-form ftco-animate">
            <img src="images/pro.png" width="100" style="margin-left: 37%;">
            <p style="text-align:center;"><span style="color:#919aa3"><?php echo $name;?></span></p>
            <p>Email : <span style="color:#919aa3"><?php echo $email;?></span></p>
            <p>Contact Number : <span style="color:#919aa3" ;><?php echo $userData['user_contactno_primary'];?> </span></p>
            <button type="button" style="margin-left: 80%;" class="btn btn-outline-dark changbtn"><a href="update.php">Change</a></button>
          </form>
        </div>
      </div>
    </div>
  </div>




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