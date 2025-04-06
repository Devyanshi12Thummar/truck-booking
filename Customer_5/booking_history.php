<?php

session_start();
require('conection.php');

// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
// }

$sq = "select NOW() as CURRENT;";
$r = mysqli_query($conn, $sq);
$rok = mysqli_fetch_assoc($r);
$now = $rok["CURRENT"];
// die($now);

$custid = $_SESSION['user_id'];

if (isset($_POST['feed-submit'])) {
    // Assuming you have established the database connection earlier and stored it in $conn
    // $conn = mysqli_connect(...);

    $ratingService = mysqli_real_escape_string($conn, $_POST["rating_service"]);
    $ratingPerformance = mysqli_real_escape_string($conn, $_POST["rating_performance"]);
    $feedback = mysqli_real_escape_string($conn, $_POST["about"]);

    if (!$feedback) {
        // Using prepared statement to prevent SQL injection
        $query = "INSERT INTO feedback (user_id, rating_service, rating_performance) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt, "iss", $custid, $ratingService, $ratingPerformance);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Feedback submitted successfully.....!');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        // mysqli_close($conn);
    } else {
        $sql = "INSERT INTO user_feedback (user_id, rating_service, rating_performance, feedback_description) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "isss", $custid, $ratingService, $ratingPerformance, $feedback);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Feedback submitted successfully.....!');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        // mysqli_close($conn);
    }
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
    <link rel="stylesheet" href="css/summary_css.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="css/feed.css">

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
                    <li class="nav-item"><a href="our_truck.php" class="nav-link">Our Truck</a></li>
                    <li class="nav-item active"><a href="booking_history.php" class="nav-link">Booking History</a></li>
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
                        <h1 class="mb-4">Booking<span>History</span></h1>
                        <p style="font-size: 18px;">A small river named Duden flows by their place and supplies it with
                            the necessary regelialia. It is a paradisematic country, in which roasted parts</p>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <section class="ftco-section ftco-no-pb ftco-no-pt">
        <div class="container" class="request-form ftco-animate">
            <br>

            <h2 style="text-align:center;">Booking History</h2>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Booking Details</h5>
                                <div class="table-responsive">
                                    <form method="POST">
                                        <table class="table text-center table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Truck Name</th>
                                                    <th>Pickup Date</th>
                                                    <th>Droup Date</th>
                                                    <th>PickupAddress</th>
                                                    <th>DropAddress</th>
                                                    <th>Max Weight</th>
                                                    <th>Action/Feedback</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // include "conection.php";
                                                $sql = "SELECT * FROM `truck_booking` WHERE user_id=$custid;";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $r = $row['truck_id'];
                                                    echo '<tr>';
                                                    echo '<td>' . $row['booking_id'] . '</td>';
                                                    echo '<td>' . $row['truck_id'] . '</td>';
                                                    echo '<td>' . $row['pickup_address'] . '</td>';
                                                    echo '<td>' . $row['drop_address'] . '</td>';
                                                    echo '<td>' . $row['pickup_address'] . '</td>';
                                                    echo '<td>' . $row['drop_address'] . '</td>';
                                                    echo '<td>' . $row['goods_weight'] . '</td>';

                                                    if ($now < $row["pickup_date"]) {
                                                        echo "<td><a href=Delete_booking.php?id={$row['booking_id']}  class='link-dark'> <i class='mdi mdi-delete menu-icon'></i>   <center>Delete<center><span class='material-symbols-outlined'></span></a></td>";
                                                    } else {
                                                        echo "<td>
                                                            <form id='feedbackForm' method='post'>
                                                                <span class='star-rating'>
                                                                  <input type='radio' name='rating' value='1'><i></i>
                                                                  <input type='radio' name='rating' value='2'><i></i>
                                                                  <input type='radio' name='rating' value='3'><i></i>
                                                                  <input type='radio' name='rating' value='4'><i></i>
                                                                  <input type='radio' name='rating' value='5'><i></i>
                                                                  </span>
                                                                  <input type='submit' class='btn btn-primary'name='sub' value='rating'>
                                                               </form>
                                                        </td>";
                                                    }
                                                   
                                                    echo "</tr>";
                                                }
                                                if (isset($_POST['sub'])) {


                                                    // $truckid = $row['truck_id'];
                                                    $rating = mysqli_real_escape_string($conn, $_POST['rating']);

                                                    // die($rating.$r);


                                                    // echo $rating;
                                                    // echo $r;
                                                    $sqlrate = "INSERT INTO truck_feedback VALUES (`feedback_id`,$r,$rating)";

                                                    if ($sqlrate == true) {
                                                        echo "Rating submitted successfully";
                                                    } 
                                                    $resultrating = mysqli_query($conn,$sqlrate);
                                                    // else {
                                                    //     echo "Error: " .  mysqli_error($conn);
                                                    // }

                                                    // $conn->close();
                                                    
                                                }
                                                ?>
                                               
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br><br>
    </section>
    <script>
        const starRating = document.querySelector('.star-rating');
        const selectedRatingInput = document.getElementById('selectedRating');

        starRating.addEventListener('change', (event) => {
            const selectedRating = event.target.value;
            selectedRatingInput.value = selectedRating;

            // Trigger the AJAX request to save the rating
            saveRating(selectedRating);
        });

        function saveRating(rating) {
            // Make an AJAX request to submit the rating
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_rating.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log('Rating submitted successfully');
                }
            };
            xhr.send('rating=' + rating);
        }
    </script>
    <section class="feed">
        <button class="show-modal"><i class="bi bi-wechat" style="font-size:30px;"></i></button>
        <span class="overlay"></span>

        <div class="modal-box">
            <!-- <i class="fa-regular fa-circle-check"></i> -->
            <div id="close" style="margin-left:85%; margin-top:2%   ">
                <span class="close">&times;</span>
            </div>
            <h2>Feedback</h2>
            <form class="" method="post">
                <div class="">
                    <div>
                        <h3 style="margin-left:-49%;">Ratting of the service</h3>
                        <input type="radio" name="rating_service" id="" value="0"> <label>Excellent</label>
                        &emsp;
                        <input type="radio" name="rating_service" id="" value="1"> <label>Good</label> &emsp;
                        <input type="radio" name="rating_service" id="" value="2"> <label>Poor</label>
                    </div>
                    <br>
                    <div>
                        <h3 style="margin-left:-35%;">Ratting of the performance</h3>
                        <input type="radio" name="rating_performance" id="" value="0"> <label>Excellent</label>
                        &emsp;
                        <input type="radio" name="rating_performance" id="" value="1"> <label>Good</label> &emsp;
                        <input type="radio" name="rating_performance" id="" value="2"> <label>Poor</label>
                    </div>
                    <br>
                    <div>
                        <h3 style="margin-left:-30%;">Write your feedback(optional)</h3>
                        <textarea name="about" cols="40" placeholder="write your feedback"></textarea>
                    </div>
                </div>
                <div class="buttons">
                    <input type="submit" name="feed-submit" style="margin-left: 70%;" class="btn btn-outline-warning " value="submit">
                </div>
                <br>
            </form>
        </div>
    </section>

    <script>
        const section = document.querySelector(".feed"),
            overlay = document.querySelector(".overlay"),
            showBtn = document.querySelector(".show-modal"),
            closeBtn = document.querySelector(".close");

        showBtn.addEventListener("click", () => section.classList.add("active"));

        overlay.addEventListener("click", () =>
            section.classList.remove("active")
        );

        closeBtn.addEventListener("click", () =>
            section.classList.remove("active")
        );
    </script>




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