

<?php
session_start();

include 'conection.php';
    
        if (isset($_POST["forget"])) {
            $email = $_POST['email'];
            $_SESSION['f_email'] = $email;
            $newpass = md5($_POST['newpass']);
            $verpass = md5($_POST['verpass']);
            $_SESSION["old_password"] = $newpass;
            $_SESSION["new_password"] = $verpass;


        //  if($newpass==$verpass)   {
        //  if ($email != 0) {
        //      $link = "update user_master set user_password='$newpass' where user_email='$email'";
        //      $ok = mysqli_query($conn, $link);
        //  }  else{
        //     echo "error";
        //    }
           header("Location:forgot_otp.php");

        // }
    }

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
	<style>
	
	</style>
  </head>
  <body>
    
	  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.php">T B <span>T S</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
	    
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
          		<h2 style="text-align:center">Forgot Password</h2>
              <div class="form-group first">
                  <label for="username">Email</label>
                  <input type="text" class="form-control" name="email" value="<?php if (isset($_COOKIE["email"])) { echo $_COOKIE['email'];  } ?>" placeholder="your-email@gmail.com" id="username">
                </div>
                <div class="form-group last mb-3">
                  <label for="password">New Password</label>
                  <input type="password" class="form-control" name="newpass"  placeholder="Your New Password" id="password">
                </div>

                <div class="form-group last mb-3">
                  <label for="password">confirm Password</label>
                  <input type="password" class="form-control" name="verpass" placeholder="Your confirm Password" id="password">
                </div>
             

                <input type="submit" name="forget" style="background-color:black;"value="Forgot Password" class="btn btn-block py-2 btn-primary">

                <a href="Register.php" ><span class="text-center my-3 d-block">Create Account?</span></a>
                
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
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>