<?php
//login
session_start();


if (isset($_SESSION['cust_id'])) {
  header("location:booking_history.php");
}

if (isset($_SESSION['cust_id'] ) && isset($_SESSION["tid"])) {
  header("location:booking.php");
}

error_reporting(0);
include 'conection.php';
$otp = rand(111111,999999);
$_SESSION["forgot_otp"] = rand(111111,999999);

if (isset($_POST['login'])) {

  //to prevent from mysqli injection  
  $EmailLogin = mysqli_real_escape_string($conn, ($_POST["email"]));
  $PasswordLogin = mysqli_real_escape_string($conn, (md5($_POST["password"])));

  $sql = "select *from user_master where user_email = '$EmailLogin' and user_password = '$PasswordLogin'";
  $result = mysqli_query($conn, $sql);
  $nom = mysqli_fetch_array($result);

  $_SESSION["otp"] = $otp;
  $_SESSION["email"] = $EmailLogin;
  $_SESSION["password"] = $PasswordLogin;


  
  if ($nom) {
    if (!empty($_POST['remember'])) {
      setcookie("email", $EmailLogin, time() + (1 * 60 * 60));
      setcookie("password", $PasswordLogin, time() + (1 * 60 * 60));
    } else {
      if (isset($_COOKIE["email"])) {
        setcookie("email", "");
      }
      if (isset($_COOKIE["password"])) {
        setcookie("password", "");
      }
    }
  }

  // $hashedPassword = password_hash($PasswordLogin, PASSWORD_DEFAULT);

  if ($PasswordLogin == $nom['user_password']) {
    if ($nom['user_type'] == 1) {
      // if (md5($password) == $row['Password']) {
      $_SESSION['managerfullname'] = $nom['user_fullname'];
      // $_SESSION['Pharmacy_Company_Email_id'] = $row['Email_Id'];
      // $_SESSION['Pharmacy_Company_id'] = $row['User_Id'];
      header('location: ../Transporter_5/Transporter/Home.php');
      // }

    } else {
      $_SESSION['customerfullname'] = $nom['user_fullname'];
      $_SESSION['user_id'] = $nom['user_id'];
      $_SESSION['emial'] = $nom['user_email'];
      header("Location: verify.php?custid={$nom['user_id']}");
    }
  }
  else {
      echo '<script>alert("Invalid Username or Password!")</script>';
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
          <li class="nav-item "><a href="index.php" class="nav-link">Home</a></li>
          <li class="nav-item active"><a href="login.php" class="nav-link">Login</a></li>
          <li class="nav-item"><a href="Register.php" class="nav-link">Register</a></li>
          <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
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
          <form method="post" class="request-form ftco-animate">
            <h2 style="text-align:center">Login</h2>
            <div class="form-group first">
              <label for="username">Email</label>
              <input type="text" class="form-control" name="email" value="<?php if (isset($_COOKIE["email"])) {
                echo $_COOKIE['email'];
              } ?>" placeholder="your-email@gmail.com" id="username">
            </div>
            <div class="form-group last mb-3">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" value="<?php if (isset($_COOKIE["password"])) {
                echo $_COOKIE['password'];
              } ?>" placeholder="Your Password" id="password">
            </div>

            <div class="d-sm-flex mb-5 align-items-center">
              <label class="control control--checkbox mb-3 mb-sm-0"><span class="caption">Remember me</span>
                <input type="checkbox" name="remember" <?php if (isset($_COOKIE["name"])) { ?>checked<?php } ?> />
                <div class="control__indicator"></div>
              </label>
              <span class="ml-auto"><a href="forget.php" class="forgot-pass">Forgot Password</a></span>
            </div>

            <input type="submit" name="login" style="background-color:black;" value="Log In"
              class="btn btn-block py-2 btn-primary">

            <a href="Register.php"><span class="text-center my-3 d-block">Create Account?</span></a>

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