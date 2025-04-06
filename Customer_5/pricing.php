<?php 
include "conection.php";
$sql = "SELECT td.*, COALESCE(CAST(ROUND(AVG(truck_feedback.truck_rating)) AS INT), NULL) AS average_rating FROM truck_detials td LEFT JOIN truck_feedback truck_feedback ON td.truck_id = truck_feedback.truck_id GROUP BY td.truck_id";


// $sql = "SELECT truck_rating FROM truck_feedback WHERE truck_id = $id";
//               $result = $conn->query($sql);

//               $total_ratings = 0;
//               $sum_ratings = 0;

//               if ($result->num_rows > 0) {
//                 while ($row = $result->fetch_assoc()) {
//                   $total_ratings++;
//                   $sum_ratings += $row['truck_rating'];
//                 }

//                 // Calculate the average rating
//                 $average_rating = $sum_ratings / $total_ratings;
//               } else {
//                 $average_rating = 0;
//               }


$result = mysqli_query($conn,$sql);

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
  <body>
    
	  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.html">T B <span>T S</span></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
		  <ul class="navbar-nav ml-auto">
	          <li class="nav-item "><a href="index.php" class="nav-link">Home</a></li>
	          <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
	          <li class="nav-item active"><a href="pricing.php	" class="nav-link">Pricing</a></li>
	          <li class="nav-item"><a href="our_truck.php" class="nav-link">Our Truck</a></li>
            <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
	          <li class="nav-item"><a href="Register.php" class="nav-link">Register</a></li>
					<li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>

	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/a.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Pricing <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Truck Rates Pricing</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-cart">
			<div class="container">
				<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div class="car-list">
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <th>&nbsp;</th>
						        <th>&nbsp;</th>
						        <th class="bg-primary heading">Per Hour Rate</th>
						        <th class="bg-dark heading">Per Day Rate</th>
						        <th class="bg-black heading">Leasing</th>
						      </tr>
						    </thead>
						    <tbody>
							<!-- start -->

							<?php   while($row=mysqli_fetch_assoc($result))
							{?>
						      <tr class="">
						      	<td class="car-image"><div class="img" style="background-image:url(<?php echo $row["truck_image1"]?>);"></div></td>
						        <td class="product-name">
						        	<h3><?php echo $row["truck_name"]?></h3>
						        	<p class="mb-0 rated">

										<?php 
										if($row["average_rating"]!=null)
										{
											echo"<span>rated:</span>";

											for($i=0;$i<=$row["average_rating"];$i++)
											{
												
												echo"<span class=ion-ios-star></span>";
											}
										}
										else
										{
											echo"<span>Not rated:</span>";

										}
										?>
						        	
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">₹</small> <?php echo $row["hour_rate"]?></span>
							        		<span class="per">/per hour</span>
							        	</h3>
							        	<span class="subheading">₹<?php echo $row["fule_rate"]?>/hour fuel surcharges</span>
						        	</div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">₹</small> <?php echo $row["day_rate"]?></span>
							        		<span class="per">/per day</span>
							        	</h3>
							        	<span class="subheading">₹<?php echo $row["fule_rate"]?>/hour fuel surcharges</span>
						        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency"></small></span>
							        		<span class="per">Now Unable/per month</span>
							        	</h3>
							        	<span class="subheading">₹<?php echo $row["fule_rate"]?>/hour fuel surcharges</span>
							        </div>
						        </td>
						      </tr>
							  <?php }?><!-- END TR-->

						      <!-- <tr class="">
						      	<td class="car-image"><div class="img" style="background-image:url(images/t_2.jpg);"></div></td>
						        <td class="product-name">
						        	<h3>Cheverolet SUV Car</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 10.99</span>
							        		<span class="per">/per hour</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 60.99</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 995.99</span>
							        		<span class="per">/per month</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>
						      </tr>END TR -->

						      <!-- <tr class="">
						      	<td class="car-image"><div class="img" style="background-image:url(images/t_3.jpg);"></div></td>
						        <td class="product-name">
						        	<h3>Cheverolet SUV Car</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 10.99</span>
							        		<span class="per">/per hour</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 60.99</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 995.99</span>
							        		<span class="per">/per month</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>
						      </tr>END TR -->

						      <!-- <tr class="">
						      	<td class="car-image"><div class="img" style="background-image:url(images/t_4.jpg);"></div></td>
						        <td class="product-name">
						        	<h3>Cheverolet SUV Car</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 10.99</span>
							        		<span class="per">/per hour</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 60.99</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 995.99</span>
							        		<span class="per">/per month</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>
						      </tr>END TR -->


						      <!-- <tr class="">
						      	<td class="car-image"><div class="img" style="background-image:url(images/t_5.jpg);"></div></td>
						        <td class="product-name">
						        	<h3>Cheverolet SUV Car</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 10.99</span>
							        		<span class="per">/per hour</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 60.99</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 995.99</span>
							        		<span class="per">/per month</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>
						      </tr>END TR -->


						      <!-- <tr class="">
						      	<td class="car-image"><div class="img" style="background-image:url(images/t_6.jpg);"></div></td>
						        <td class="product-name">
						        	<h3>Cheverolet SUV Car</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 10.99</span>
							        		<span class="per">/per hour</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 60.99</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom"><a href="#">Rent a Truck</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><small class="currency">$</small> 995.99</span>
							        		<span class="per">/per month</span>
							        	</h3>
							        	<span class="subheading">$3/hour fuel surcharges</span>
							        </div>
						        </td>
						      </tr>END TR -->
						    </tbody>
						  </table>
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
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
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
	                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


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