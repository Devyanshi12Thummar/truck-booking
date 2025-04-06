<?php
include "conection.php";


$sql = "SELECT * FROM `truck_detials`";
$result = mysqli_query($conn, $sql);


$q1 = "SELECT min(truck_capacity) AS min,max(truck_capacity) AS max FROM `truck_detials`";
$res = mysqli_query($conn, $q1);
$ROW = mysqli_fetch_assoc($res);
$MIN = $ROW['min'];
$MAX = $ROW['max'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Get the values from the POST request
	$pidate = $_POST['pi'];
	$dropdate = $_POST['dr'];

	$_SESSION["pick"] = $pidate;
	$_SESSION["drop"] = $dropdate;


	exit(); // End the PHP script after sending the response
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Autoroad - Free Bootstrap 4 Template by Colorlib</title>
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


	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- Include jQuery UI -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>



	<link rel="stylesheet" href="css/flaticon.css">
	<link rel="stylesheet" href="css/icomoon.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<style>
	</style>
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
					<li class="nav-item x"><a href="index.php" class="nav-link">Home</a></li>
					<li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
					<li class="nav-item"><a href="pricing.php	" class="nav-link">Pricing</a></li>
					<li class="nav-item active"><a href="our_truck.php" class="nav-link">Our Truck</a></li>
					<li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>

				</ul>
			</div>
		</div>
	</nav>
	<!-- END nav -->

	<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/a.jpg');"
		data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
				<div class="col-md-9 ftco-animate pb-5">
					<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i
									class="ion-ios-arrow-forward"></i></a></span> <span>Our truck <i
								class="ion-ios-arrow-forward"></i></span></p>
					<h1 class="mb-3 bread">Choose Your Truck</h1>
				</div>
			</div>
		</div>
	</section>

	<section class="ftco-section">
		<div class="col-md-12 heading-section text-center ftco-animate mb-2">
			<span class="subheading">What we offer</span>
			<h2 class="mb-2">Choose Your Truck</h2>
		</div>
		<div class="col-lg-12 col-md-5 mt-0 mt-md-1 d-flex  justify-content-center">
			<form id="availabilityForm" class="request-form ftco-animate"m method="POST">
				<!-- Your form fields here -->
				<h2>Filtter Trucks</h2>
				<div class="d-flex">
					<div class="form-group mr-2">
						<div id="date-wrap">

							<label for="" class="label">Pick-up date</label>
							<input type="datetime-local" id="from" autocomplete="off" class="form-control"
								 required onchange="validateDates();validatePickdate();">
						</div>

						<!-- <input type="datetime-local" class="form-control" name="pi" id="checkInDate" placeholder="Date"> -->
					</div>
					<div class="form-group ml-2">
						<div id="date-wrap">

							<label for="" class="label">Drop-off date</label>
							<input type="datetime-local" id="to" autocomplete="off" class="form-control"
								placeholder="Date" required onchange="validateDates();validatePickdate();">
						</div>
						<!-- <input type="datetime-local" class="form-control" name="dr"  id="checkOutDate"
							placeholder="Date"> -->
					</div>
					<div class="form-group ml-2">
						<div class="form-group ml-2">
							<div id="main">
								<div id="slider-wrap">
									<div>
										<label>Range Between:</label>
										<span id="capacity"></span>
									</div>
									<div id="slider-range"></div>
								</div>
								<div id="content">
									<div id="table-data" class="col-md-3">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Rest of your form content -->
			</form>

			<!-- <button class="btn btn-info btn-lg " onclick="calcRoute();"><i class="fas fa-map-signs"></i></button> -->
			<!-- <input type="submit" value="Search Truck" name="submit" class="btn btn-primary py-3 px-4"> -->

		</div>
		<br><br><br>
		<div class="row" id="row">

			<?php
			// die( var_dump($result));
			while ($row = mysqli_fetch_assoc($result)) {

				$id = $row["truck_id"];

				?>

				<div class="col-md-3">
					<div class="car-wrap ftco-animate">
						<div class="img d-flex align-items-end"
							style="background-image: url(<?php echo $row["truck_image1"]; ?>);">

						</div>

						<div class="text p-4 text-center">
							<h2 class="mb-0"><a href="#">
									<?php echo $row["truck_name"] ?>
								</a></h2>

							<span>
								<?php echo "Truck Capacity : " . $row["truck_capacity"] ?>
							</span>
							<?php
							// if(isset($_SESSION["pick"]) && isset($_SESSION["drop"]))
							// {
							// ?>
							<p class="d-flex mb-0 d-block"><a href="#"
							onclick="showAlert()"
									class="btn btn-black btn-outline-black mr-1">Book now</a> 
									
								
									<a
									href="truck_details.php?id=<?php echo $id ?>"
									class="btn btn-black btn-outline-black ml-1">Details</a></p>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>


		<div class="row mt-5">
			<div class="col text-center">
				<div class="block-27">
					<ul>
						<li><a href="#">&lt;</a></li>
						<li class="active"><span>1</span></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li><a href="#">&gt;</a></li>
					</ul>
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
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
							there live the blind texts.</p>
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
								<li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain
										View, San Francisco, California, USA</span></li>
								<li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929
											210</span></a></li>
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



<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Range Slider</title>
	<!-- jquery ui css -->
	<link rel="stylesheet" href="css/jquery-ui.min.css">
	<!-- style.css -->
	<link rel="stylesheet" href="css/style.css">


	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="/resources/demos/style.css">
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
</head>

<body>

	<script src="js/jquery-ui-1.12.1.min.js"></script>




<script>
function showAlert() {
    alert('Please enter your truck drop datetime and pickup datetime'); 
  }

		function validatePickdate() {
			const fromDateInput = document.getElementById("from");
			const toDateInput = document.getElementById("to");

			const fromDateValue = fromDateInput.value.trim();
			const toDateValue = toDateInput.value.trim();

			if (fromDateValue === '') {
				alert("pick up date are required.");
				return false;
			}

			return true;
		}




		function validateDropdate() {
			const fromDateInput = document.getElementById("from");
			const toDateInput = document.getElementById("to");

			const fromDateValue = fromDateInput.value.trim();
			const toDateValue = toDateInput.value.trim();

			if (toDateValue === '') {
				alert("Droup date are required");
				return false;
			}

			return true;
		}



		function validateDates() {
			const fromDateInput = document.getElementById("from");
			const toDateInput = document.getElementById("to");

			const fromDateValue = new Date(fromDateInput.value);
			const toDateValue = new Date(toDateInput.value);

			if (fromDateValue >= toDateValue) {
				alert("The 'Pikup' date must be smaller than 'Droup' date.");
			}
		}
	</script>



	<!-- Include jQuery and jQuery UI -->
	<script src="js/jquery-3.6.0.min.js"></script>
	<script src="js/jquery-ui-1.12.1.min.js"></script>

	<!-- HTML and other code (if any) before the JavaScript section -->

	<script>
		$(document).ready(function () {
			var v1 = "<?php echo $MIN; ?>";
			var v2 = "<?php echo $MAX; ?>";
			var minD;
			var maxD;

			var dateFormat = "yy-mm-dd";

			$("#slider-range").slider({

				range: true,
				min: parseInt(v1),
				max: parseInt(v2),
				values: [v1, v2],
				slide: function (event, ui) {
					$("#capacity").html(ui.values[0] + " - " + ui.values[1]);
					v1 = ui.values[0];
					v2 = ui.values[1];
					loadTable(v1, v2, minD, maxD);
				}
			});

			$("#capacity").html($("#slider-range").slider("values", 0) + " - " + $("#slider-range").slider("values", 1));

			var from = $("#from").datepicker({
				changeMonth: true,
				changeYear: true,
				numberOfMonths: 1,
				yearRange: "1990:2005",
				showOn: ""
			}).on("change", function () {
				to.datepicker("option", "minDate", getDate(this));
				minD = $(this).val();
				if (minD !== '' && maxD !== '') {
					loadTable(v1, v2, minD, maxD);
				}
			});

			var to = $("#to").datepicker({
				changeMonth: true,
				changeYear: true,
				numberOfMonths: 1,
				yearRange: "1990:2005",
				showOn: ""
			}).on("change", function () {
				from.datepicker("option", "maxDate", getDate(this));
				maxD = $(this).val();
				if (minD !== '' && maxD !== '') {
					loadTable(v1, v2, minD, maxD);
				}
			});

			// Change date format
			function getDate(element) {
				var date;
				try {
					date = $.datepicker.parseDate(dateFormat, element.value);
				} catch (error) {
					date = null;
				}
				return date;
			}

			// Load table
			function loadTable(range1, range2, date1, date2) {
				$.ajax({
					url: "truck_details_ajax.php",
					type: "POST",
					data: {
						range1: range1,
						range2: range2,
						date1: date1,
						date2: date2
					},
					success: function (response) {
						$("#row").html(response);
					}
				});
			}

			<?php
			if (isset($_SESSION["pick"]) && isset($_SESSION["drop"])) {
				$pidate = $_SESSION["pick"];
				$dropdate = $_SESSION["drop"];
				?>
				loadTable(v1, v2, "<?php echo $pidate; ?>", "<?php echo $dropdate; ?>");
			<?php } ?>

		});
	</script>
</body>

</html>


<!-- 
	<script src="js/jquery-ui-1.12.1.min.js"></script>
	<script>
		$(document).ready(function () {
			var v1 = 1;
			var v2 = 250;
			var minD;
			var maxD;
			var dateFormat = "yyyy-mm-dd";

			$("#slider-range").slider({
				range: true,
				min: 1,
				max: 850,
				values: [v1, v2],
				slide: function (event, ui) {
					$("#capacity").html(ui.values[0] + " - " + ui.values[1]);
					v1 = ui.values[0];
					v2 = ui.values[1];
					loadTable(v1, v2, minD, maxD);
				}
			});

			$("#capacity").html($("#slider-range").slider("values", 0) +
				" - " + $("#slider-range").slider("values", 1));

			var from = $("#from").datepicker({
				changeMonth: true,
				changeYear: true,
				numberOfMonths: 1,
				yearRange: "1990:2005",
				showOn: ""
			}).on("change", function () {
				to.datepicker("option", "minDate", getDate(this));
				minD = $(this).val();
				if (minD !== '' && maxD !== '') {
					loadTable(v1, v2, minD, maxD);
				}
			});

			var to = $("#to").datepicker({
				changeMonth: true,
				changeYear: true,
				numberOfMonths: 1,
				yearRange: "1990:2005",
				showOn: ""
			}).on("change", function () {
				from.datepicker("option", "maxDate", getDate(this));
				maxD = $(this).val();
				if (minD !== '' && maxD !== '') {
					loadTable(v1, v2, minD, maxD);
				}
			});

			// change date format
			function getDate(element) {
				var date;
				try {
					date = $.datepicker.parseDate(dateFormat, element.value);
				} catch (error) {
					date = null;
				}
				return date;
			}

			// load table
			function loadTable(range1, range2, date1, date2) {
				$.ajax({
					url: "truck_details_ajax.php",
					type: "POST",
					data: {
						range1: range1,
						range2: range2,
						date1: date1,
						date2: date2
					},
					success: function (response) {
						$("#truckResultsContainer").html(response);
					}
				});
			}

			loadTable(v1, v2, minD, maxD);
		});
	</script>

 -->
















<!-- <script>
		$(document).ready(function () {

			var v1 = 300;
			var v2 = 800;

			$("#slider-range").slider({
				range: true,
				min: 10,
				max: 900,
				values: [v1, v2],
				slide: function (event, ui) {
					$("#capacity").html(ui.values[0] + " - " + ui.values[1]);
					v1 = ui.values[0];
					v2 = ui.values[1];
					loadTable(v1, v2);

				}
			});
			$("#capacity").html($("#slider-range").slider("values", 0) +
				" - " + $("#slider-range").slider("values", 1));

			function loadTable(range1, range2) {
				$.ajax({
					url:  "dateajex.php",
					type: "POST",
					data: { range1: range1, range2: range2 },
					success: function (data) {
						$("#truckResultsContainer").html(data);
					}
				});
			}

			loadTable(v1, v2);
		});
</script>  -->

<!-- <script>
		$(document).ready(function () {
			var v1 = 300;
			var v2 = 800;

			function loadTable(range1, range2, formData) {
				$.ajax({
					url: "get-data.php", // The PHP script that retrieves truck results
					type: "POST",
					data: { range1: range1, range2: range2, formData: formData },
					success: function (data) {
						$("#truckResultsContainer").html(data);
					}
				});
			}

			$("#slider-range").slider({
				range: true,
				min: 10,
				max: 900,
				values: [v1, v2],
				slide: function (event, ui) {
					$("#capacity").html(ui.values[0] + " - " + ui.values[1]);
				},
				change: function (event, ui) {
					v1 = ui.values[0];
					v2 = ui.values[1];
					loadTable(v1, v2, $('#availabilityForm').serialize());
				}
			});

			$("#capacity").html($("#slider-range").slider("values", 0) + " - " + $("#slider-range").slider("values", 1));

			$('#availabilityForm input').on('input', function () {
				var formData = $('#availabilityForm').serialize();
				loadTable(v1, v2, formData);
			});

			loadTable(v1, v2, $('#availabilityForm').serialize());
		});
	</script>


-->
<!-- </body>

</html> -->
<?php


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// 	// Get the values from the POST request
// 	$pidate = $_POST['pi'];
// 	$dropdate = $_POST['dr'];

// 	$_SESSION["pick"] = $pidate;
// 	$_SESSION["drop"] = $dropdate;


// 	exit(); // End the PHP script after sending the response
// }
?>