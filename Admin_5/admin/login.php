<?php

include 'conection.php';
session_start();
$message = "";
if (isset($_POST['login'])) {


    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['admin_email']=$email;


    $sql = "select * from admin where admin_email = '$email' and admin_password = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if ($row) {
        if (!empty($_POST['remember'])) {
            setcookie("email", $email, time() + (1 * 60 * 60));
            setcookie("password", $password, time() + (1 * 60 * 60));
            // $_SESSION["admin_name"];
        } else {
            if (isset($_COOKIE["email"])) {
                setcookie("email", "");
            }
            if (isset($_COOKIE["password"])) {
                setcookie("password", "");
            }
        }
    }
    $count = mysqli_num_rows($result);

    $fetch = mysqli_fetch_row($result);

    if ($count == 1) {
        $_SESSION['adminemail'] = $row['admin_email'];
        // $_SESSION['Name'] = $_POST['name'];
        // echo $_SESSION['Name'];
        header("location:home.php");
    } else {
        $message = "Invalid Username or Password!";
        echo '<script>alert("Invalid Username or Password!")</script>';
    }
}



?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home_b.css"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css_2/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css_2/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="css_2/style.css">

    <title>Admin Login</title>
  </head>
  <body>
  <nav class="sticky navbar" style="background-color:black;">
        <div class="brand  display__logo">
            <a href="home_page.php" class="nav__link"> <span class="logo">TBS </span></a>
        </div>

        <!-- <input type="checkbox" id="nav" class="hidden" /> -->
        <label for="nav" class="nav__open"><i></i><i></i><i></i></label>
        <div class="nav">
            <ul class="nav__items">
                <li><a href="home_page.php" class="nav__link ">Admin</a></li>
                
            </ul>
        </div>
    </nav>
  

  <div class="d-md-flex half">
    <!-- <div class="bg" src="images/download.jpeg"></div> -->
    <!-- <div class="contents"> -->

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-12">
            <div class="form-block mx-auto">
              <div class="text-center mb-5">
                <h3 class="text-uppercase">Login</h3>
              </div>
              <form action="#" method="post">
                <div class="form-group first">
                  <label for="username">Email</label>
                  <input type="text" class="form-control" name="email" value="<?php if (isset($_COOKIE["email"])) { echo $_COOKIE['email'];  } ?>" required placeholder="your-email@gmail.com" id="username">
                </div>
                <div class="form-group last mb-3">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="password" value="<?php if (isset($_COOKIE["password"])) { echo $_COOKIE['password'];  } ?>" placeholder="Your Password" id="password">
                </div>
                
                <div class="d-sm-flex mb-5 align-items-center">
                  <label class="control control--checkbox mb-3 mb-sm-0"><span class="caption">Remember me</span>
                  <input id="check" type="checkbox" checked name="remember" <?php if (isset($_COOKIE["email"])) { ?><?php } ?>class="check">
                   
                  <div class="control__indicator"></div>
                  </label>
                  <span class="ml-auto"><a href="forget.php" class="forgot-pass">Forgot Password</a></span> 
                </div>

                <input type="submit" name="login" style="background-color:black;"value="Log In" class="btn btn-block py-2 btn-primary">

              

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    
  </div>
    
    

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>