<?php
include "conection.php";

$id = $_GET["id"];
// truck details fatch
$sql = "select * from truck_detials where truck_id  = $id ";
$result = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_assoc($result);

// truck company name fatch
$sql1 = "SELECT truck_detials.truck_company_id, truck_company.truck_company_id,truck_company.truck_company_name FROM truck_detials INNER JOIN truck_company ON truck_detials.truck_company_id = truck_company.truck_company_id where truck_detials.truck_id= '$id'";
$result1 = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($result1);

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
  <link rel="stylesheet" href="css_2/bootstrap/detailcss.css">
  <link rel="stylesheet" href="css_2/zoom.css">

  <style>
    
    /* .preview {
        display: flex; 
    }
    
    .zoom {
        transition: transform 0.2s; 
        width: 100%; 
        height: auto; 
        background-size: cover; 
        background-repeat: no-repeat; 
    }

    .zoom:hover {
        transform: scale(1.1); 
    } */
    .zoom {
      transition: transform 0.2s;
      width: 100%;
      height: auto;
    }

    .zoom:hover {
      transform: scale(1.1);
    }

    /* .zoom {
        position: relative;
        overflow: hidden;
    }

    .zoom img {
        transition: transform 0.3s ease;
    }

    .zoom:hover img {
        transform: scale(1.2);
    } */
    .preview-pic {
      display: flex;
    }

    .preview-image {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }
  </style>
</head>


<script>
  function zoom(e) {
    var zoomer = e.currentTarget;
    e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
    e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
    x = offsetX / zoomer.offsetWidth * 200
    y = offsetY / zoomer.offsetHeight * 200
    zoomer.style.backgroundPosition = x + '%' + y + '%';
  }
</script>

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
          <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
          <li class="nav-item"><a href="pricing.php	" class="nav-link">Pricing</a></li>
          <li class="nav-item"><a href="our_truck.php" class="nav-link">Our Truck</a></li>
          <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>

        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->

  <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/a.jpg');"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <br><br>


    <div class="container">
      <div class="card">
        <div id="close">
          <a href="our_truck.php"><span class="close">&times;</span></a>
        </div>
        <div class="container-fliud">

          <div class="wrapper row">

            <!-- <div class="preview col-md-6">
              <div class="preview-pic tab-content">
                <?php for ($i = 1; $i <= 3; $i++) { ?>
                  <div class="tab-pane w-30" id="pic-<?php echo $i; ?>">
                    <figure class="zoom" style="width:10;background-image: url(<?php echo $row1["truck_image$i"]; ?>)"
                      onmousemove="zoom(event)">
                      <img width="10" src="<?php echo $row1["truck_image$i"]; ?>" />
                    </figure>
                  </div>
                <?php } ?>
              </div>
              <div class="w-30">
                <ul class="preview-thumbnail nav nav-tabs">
                  <?php for ($i = 1; $i <= 3; $i++) { ?>
                    <li <?php if ($i === 1) {
                      echo 'class="active"';
                    } ?>>
                      <a data-target="#pic-<?php echo $i; ?>" data-toggle="tab">
                        <img src="<?php echo $row1["truck_image$i"]; ?>" />
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div> -->


            <!-- <div class="preview col-md-6">
              <div class="preview-pic tab-content">
                <?php for ($i = 1; $i <= 3; $i++) { ?>
                  <div class="tab-pane w-30" id="pic-<?php echo $i; ?>">
                    <figure class="zoom" style="width:100%; background-image: url(<?php echo $row1["truck_image$i"]; ?>)"
                      onmousemove="zoom(event)">
                      <img src="<?php echo $row1["truck_image$i"]; ?>" />
                    </figure>
                  </div>
                <?php } ?>
              </div>
              <div class="w-30">
                <ul class="preview-thumbnail nav nav-tabs">
                  <?php for ($i = 1; $i <= 3; $i++) { ?>
                    <li <?php if ($i === 1) {
                      echo 'class="active"';
                    } ?>>
                      <a data-target="#pic-<?php echo $i; ?>" data-toggle="tab">
                        <img src="<?php echo $row1["truck_image$i"]; ?>" />
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div> -->
            <div class="preview col-md-6">
              <div class="preview-pic tab-content">
                <?php for ($i = 1; $i <= 3; $i++) { ?>
                  <div class="tab-pane w-30 <?php if ($i === 1)
                    echo 'active'; ?>" id="pic-<?php echo $i; ?>">
                    <figure class="zoom" style="width:100%; background-image: url(<?php echo $row1["truck_image$i"]; ?>)"
                      onmousemove="zoom(event)">
                      <img src="<?php echo $row1["truck_image$i"]; ?>" />
                    </figure>
                  </div>
                <?php } ?>
              </div>
              <div class="w-30">
                <ul class="preview-thumbnail nav nav-tabs">
                  <?php for ($i = 1; $i <= 3; $i++) { ?>
                    <li <?php if ($i === 1) {
                      echo 'class="active"';
                    } ?>>
                      <a data-target="#pic-<?php echo $i; ?>" data-toggle="tab">
                        <img src="<?php echo $row1["truck_image$i"]; ?>" />
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>



            <div class="details col-md-6">

              <!-- name truck -->
              <h3 class="product-title">
                <?php echo $row1["truck_name"]; ?>
              </h3>
              <div class="rating">
                <div class="stars">
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                </div>
              </div>
              <!-- <p class="product-description">Suspendisse quos? Tempus cras iure temporibus? Eu laudantium cubilia sem sem! Repudiandae et! Massa senectus enim minim sociosqu delectus posuere.</p> -->
              <p class="review-no">Company Name :
                <?php echo $row["truck_company_name"]; ?>
              </p>

              <p class="review-no">Truck Size :
                <?php echo $row1["truck_size"];
                ?>
              </p>

              <p class="review-no">Truck Capacity :
                <?php echo $row1["truck_capacity"];
                ?>
              </p>

              <p class="review-no">Truck Model :
                <?php echo $row1["truck_model"];
                ?>
              </p>
              <p class="review-no">Truck Register No :
                <?php echo $row1["truck_register_number"];
                ?>
              </p>
              <?php

              $sql = "SELECT truck_rating FROM truck_feedback WHERE truck_id = $id";
              $result = $conn->query($sql);

              $total_ratings = 0;
              $sum_ratings = 0;

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $total_ratings++;
                  $sum_ratings += $row['truck_rating'];
                }

                // Calculate the average rating
                $average_rating = $sum_ratings / $total_ratings;
              } else {
                $average_rating = 0;
              }

              // Close the database connection
              $conn->close();
              ?>


              <p>
              <div class="star-rating">
                <?php
                // Convert average rating to star representation
                for ($i = 1; $i <= 5; $i++) {
                  if ($i <= $average_rating) {
                    echo '<span>&#9733;</span>'; // Filled star
                  } else {
                    echo '<span>&#9734;</span>'; // Empty star
                  }
                }
                ?>
                </p>

                <!-- <h4 class="price">current price: <span>$180</span></h4>
            <p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong></p>
            <h5 class="sizes">sizes:
              <span class="size" data-toggle="tooltip" title="small">s</span>
              <span class="size" data-toggle="tooltip" title="medium">m</span>
              <span class="size" data-toggle="tooltip" title="large">l</span>
              <span class="size" data-toggle="tooltip" title="xtra large">xl</span>
            </h5> -->

                <div class="action">
                  <!-- <button class="add-to-cart btn btn-default" type="button">add to cart</button> -->
                  <button type="button" class="btn btn-block btn-primary">Book Now</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>





  <footer class="ftco-footer ftco-bg-dark ftco-section">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">About Autoroad</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the
              blind texts.</p>
            <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
              <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md">
          <div class="ftco-footer-widget mb-4 ml-md-5">
            <h2 class="ftco-heading-2">Information</h2>
            <ul class="list-unstyled">
              <li><a href="#" class="py-2 d-block">About</a></li>
              <li><a href="#" class="py-2 d-block">Services</a></li>
              <li><a href="#" class="py-2 d-block">Term and Conditions</a></li>
              <li><a href="#" class="py-2 d-block">Best Price Guarantee</a></li>
              <li><a href="#" class="py-2 d-block">Privacy &amp; Cookies Policy</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">Customer Support</h2>
            <ul class="list-unstyled">
              <li><a href="#" class="py-2 d-block">FAQ</a></li>
              <li><a href="#" class="py-2 d-block">Payment Option</a></li>
              <li><a href="#" class="py-2 d-block">Booking Tips</a></li>
              <li><a href="#" class="py-2 d-block">How it works</a></li>
              <li><a href="#" class="py-2 d-block">Contact Us</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">Have a Questions?</h2>
            <div class="block-23 mb-3">
              <ul>
                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San
                    Francisco, California, USA</span></li>
                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                <li><a href="#"><span class="icon icon-envelope"></span><span
                      class="text">info@yourdomain.com</span></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">

          <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;
            <script>
              document.write(new Date().getFullYear());
            </script> All rights reserved | This template is made with <i class="icon-heart color-danger"
              aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          </p>
        </div>
      </div>
    </div>
  </footer>



  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
        stroke="#F96D00" />
    </svg></div>


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
