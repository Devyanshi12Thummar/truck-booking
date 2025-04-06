<?php
session_start();
require('connection.php');


if (!isset($_SESSION['managerfullname'])) {
    header("Location: ../Customer_5/login.php");
    die();
}

//YEARLY

$sqltotal = "SELECT COUNT(DISTINCT pickup_address) as total from truck_booking  where YEAR(booking_date)=YEAR(NOW())";

$resulttotal = mysqli_query($conn, $sqltotal);

$rowtotal = mysqli_fetch_assoc($resulttotal);
$total = $rowtotal["total"];

// $sql= "SELECT COUNT(*) as count ,pickup_address from truck_booking GROUP BY pickup_address";
$sqlcityyear = "SELECT COUNT(DISTINCT pickup_address) as count ,pickup_address from truck_booking where YEAR(booking_date)=YEAR(NOW()) GROUP BY pickup_address";
$sqlcity = mysqli_query($conn, $sqlcityyear);



//MONTHLY



$sqltotalmon = "SELECT COUNT(DISTINCT pickup_address) as total from truck_booking where MONTHNAME(booking_date)=MONTHNAME(NOW())";

$resulttotalmon = mysqli_query($conn, $sqltotalmon);

$rowtotalmon = mysqli_fetch_assoc($resulttotalmon);
$totalmon = $rowtotalmon["total"];

$sqlcitymonth = "SELECT COUNT(*) as count ,pickup_address from truck_booking WHERE MONTHNAME(booking_date)= MONTHNAME(NOW()) GROUP BY pickup_address; ";
$sqlcitymon = mysqli_query($conn, $sqlcitymonth);


//WEEKLY


$sqltotalweek = "SELECT COUNT(DISTINCT pickup_address) as total from truck_booking where WEEK(booking_date,3)=WEEK(NOW())";

$resulttotalweek = mysqli_query($conn, $sqltotalweek);

$rowtotalweek = mysqli_fetch_assoc($resulttotalweek);
$totalweek = $rowtotalweek["total"];

$sqlcityweeks = "SELECT COUNT(*) as count,pickup_address FROM truck_booking WHERE WEEK(booking_date, 3) = WEEK(NOW()) GROUP BY pickup_address; ";
$sqlcityweek = mysqli_query($conn, $sqlcityweeks);




?>






<?php
if (isset($_POST["submit"])) {
    $year = $_POST['year'];


    // $year=2023;


    //     $sql = "SELECT t_max.year AS year,
//     t_max.truck_id AS max_truck_id,
//     t_max.booking_count AS max_booking_count,
//     t_min.truck_id AS min_truck_id,
//     t_min.booking_count AS min_booking_count
// FROM (
//  SELECT YEAR(booking_date) AS year,
//         truck_id,
//         COUNT(*) AS booking_count
//  FROM truck_booking
//  WHERE YEAR(booking_date) = $year
//  GROUP BY year, truck_id
//  HAVING booking_count = (
//      SELECT MAX(sub.booking_count)
//      FROM (
//          SELECT COUNT(*) AS booking_count
//          FROM truck_booking
//          WHERE YEAR(booking_date) = $year
//          GROUP BY truck_id
//      ) sub
//  )
// ) t_max
// JOIN (
//  SELECT YEAR(booking_date) AS year,
//         truck_id,
//         COUNT(*) AS booking_count
//  FROM truck_booking
//  WHERE YEAR(booking_date) = $year
//  GROUP BY year, truck_id
//  HAVING booking_count = (
//      SELECT MIN(sub.booking_count)
//      FROM (
//          SELECT COUNT(*) AS booking_count
//          FROM truck_booking
//          WHERE YEAR(booking_date) = $year
//          GROUP BY truck_id
//      ) sub
//  )
// ) t_min ON t_max.year = t_min.year
// ORDER BY year;
// ";


    // $result=mysqli_query($conn,$sql);



    //     $rowgraph = mysqli_fetch_array($result);
//         $maxtruckid=$rowgraph['max_truck_id'];
//         $mintruckid=$rowgraph['min_truck_id'];
//         $max=$rowgraph['max_booking_count'];
//         $min=$rowgraph['min_booking_count'];



    //     $namesql = "SELECT DISTINCT truck_booking.truck_id, truck_detials.truck_id, truck_detials.truck_name 
// FROM truck_booking 
// INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id 
// WHERE  truck_booking.truck_id = $mintruckid";

    //     $nameres = mysqli_query($conn, $namesql);
//     $ro = mysqli_fetch_assoc($nameres);

    //     $mintruckname = $ro['truck_name'];




    //     $namesql1 = "SELECT DISTINCT truck_booking.truck_id, truck_detials.truck_id, truck_detials.truck_name 
//     FROM truck_booking 
//     INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id 
//     WHERE truck_booking.truck_id = $maxtruckid";

    //     $nameres1 = mysqli_query($conn, $namesql1);
//     $ro1 = mysqli_fetch_assoc($nameres1);



    //     $maxtruckname = $ro1['truck_name'];

    //     $labels = ['Min Truck', 'Max Truck'];
//     $data = [$min, $max];




}

$sql = "SELECT tb.year,
tb.truck_id,
tb.booking_count,
td.truck_name
FROM (
SELECT YEAR(booking_date) AS year,
    truck_id,
    COUNT(*) AS booking_count
FROM truck_booking
WHERE YEAR(booking_date) = 2023
GROUP BY year, truck_id
) tb
JOIN truck_detials td ON tb.truck_id = td.truck_id
ORDER BY tb.year, tb.truck_id;
";

$result = mysqli_query($conn, $sql);


?>







<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- <script>
        function truck_re(str) {
            if (str == "") {
                document.getElementById("dataTable").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("dataTable").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "yearwise_maxtruck.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>




    <script>
        function datewisebooking(str, str1) {
            if (str == "") {
                document.getElementById("dataTable").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("dataTable").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "datewisebooking.php?q=" + str + "&p=" + str1, true);
                xmlhttp.send();
            }
        }
    </script>


    <script>
        function city(str) {
            if (str == "") {
                document.getElementById("dataTable").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("dataTable").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "monthwise_higest_city.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script> -->

    <!-- /city book -->

    <!-- <script>
        function citybook(str) {
            if (str == "") {
                document.getElementById("dataTable").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("dataTable").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "citymax.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>


    <script>
        function yearmaxcity(str) {
            if (str == "") {
                document.getElementById("dataTable").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("dataTable").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "yearwise_maxcity.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
-->





</head>

<body>

    <!-- <div class="container-scroller"> -->

    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex justify-content-center">
            <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                <a class="navbar-brand brand-logo" href="index.html">TBTS</a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg"
                        alt="logo" /></a>
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-sort-variant"></span>
                </button>
            </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <ul class="navbar-nav mr-lg-4 w-100">
                <li class="nav-item nav-search d-none d-lg-block w-100">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="search">
                                <i class="mdi mdi-magnify"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search now" aria-label="search"
                            aria-describedby="search">
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown me-1">
                    <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
                        id="messageDropdown" href="#" data-bs-toggle="dropdown">
                        <i class="mdi mdi-message-text mx-0"></i>
                        <span class="count"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="messageDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <img src="images/faces/face4.jpg" alt="image" class="profile-pic">
                            </div>
                            <div class="item-content flex-grow">
                                <h6 class="ellipsis font-weight-normal">David Grey
                                </h6>
                                <p class="font-weight-light small-text text-muted mb-0">
                                    The meeting is cancelled
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <img src="images/faces/face2.jpg" alt="image" class="profile-pic">
                            </div>
                            <div class="item-content flex-grow">
                                <h6 class="ellipsis font-weight-normal">Tim Cook
                                </h6>
                                <p class="font-weight-light small-text text-muted mb-0">
                                    New product launch
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
                            </div>
                            <div class="item-content flex-grow">
                                <h6 class="ellipsis font-weight-normal"> Johnson
                                </h6>
                                <p class="font-weight-light small-text text-muted mb-0">
                                    Upcoming board meeting
                                </p>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown me-4">
                    <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown"
                        id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                        <i class="mdi mdi-bell mx-0"></i>
                        <span class="count"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                        aria-labelledby="notificationDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-success">
                                    <i class="mdi mdi-information mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">Application Error</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    Just now
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-warning">
                                    <i class="mdi mdi-settings mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">Settings</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    Private message
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-info">
                                    <i class="mdi mdi-account-box mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">New user registration</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    2 days ago
                                </p>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" id="profileDropdown">
                        <img src="images/faces/face5.jpg" alt="profile" />
                        <span class="nav-profile-name">
                            <?php echo $_SESSION['managerfullname']; ?>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item">
                            <i class="mdi mdi-settings text-primary"></i>
                            Settings
                        </a>
                        <a href="AdminLogout.php" class="dropdown-item">
                            <i class="mdi mdi-logout text-primary"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">

        <li class="nav-item">
          <a class="nav-link" href="Home.php">
            <i class="mdi mdi-home menu-icon"></i>
            <span class="menu-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="booking_request.php">
            <i class="mdi mdi-book-open menu-icon"></i>
            <span class="menu-title">Booking</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Add_Driver.php">
            <i class="mdi mdi-car menu-icon"></i>
            <span class="menu-title">Add Driver</span>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
            <i class="mdi mdi-book menu-icon"></i>
              <span class="menu-title">Booking Reports</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="Reports.php"> City Wise </a></li>
                <li class="nav-item"> <a class="nav-link" href="datewise.php">Date Wise</a></li>
              </ul>
            </div>
          </li>

        <li class="nav-item">
          <a class="nav-link" href="Add_Truck.php">
            <i class="mdi mdi-truck menu-icon"></i>
            <span class="menu-title">Add Truck</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="View_Truck.php">
            <i class="mdi mdi-view-headline menu-icon"></i>
            <span class="menu-title">View Truck</span>
          </a>
        </li>

      </ul>
    </nav>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex align-items-end flex-wrap">
                                <div class="me-md-3 me-xl-5">
                                    <h2> Date Wise Booking Reports</h2>
                                </div>

                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-outline">
                                            <label class="form-label" for="date">Booking Date </label>
                                            <!-- <input type="date" id="datewise" class="form-control"
                                                placeholder="YYYY-MM-DD" format="YYYY-MM-DD" name="datewise"
                                                onchange="datewisebooking(this.value)" /> -->


                                            <!-- <input type="date" name="booking_date" id="booking_date" class="form-control"> -->

                                            <!-- <input type="date" name="booking_date" id="booking_date"
                                                class="form-control">
                                            <label class="form-label" for="date">Booking Date Based Selected Months Top
                                                booked truck</label>

                                            <div style="width: 70%; margin: auto;">
                                                <canvas id="myChart"></canvas>
                                            </div>

                                            <script>
                                                var year;
                                                var ctx = document.getElementById('myChart').getContext('2d');
                                                var myChart = new Chart(ctx, {
                                                    type: 'bar',
                                                    data: {
                                                        labels: [],
                                                        datasets: [{
                                                            label: 'Truck',
                                                            data: [],
                                                            backgroundColor: [],
                                                            borderColor: [],
                                                            borderWidth: 1
                                                        }]
                                                    },
                                                    options: {
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true,
                                                                suggestedMin: 0,
                                                                suggestedMax: 10,
                                                                stepSize: 1
                                                            }
                                                        }
                                                    }
                                                });

                                                // Function to fetch data based on the selected year and month
                                                function fetchData(year, month) {
                                                    $.ajax({
                                                        url: 'barchart_data.php',
                                                        type: 'GET',
                                                        data: { year: year, month: month }, // Pass the selected year and month as parameters
                                                        dataType: 'json',
                                                        success: function (data) {
                                                            myChart.data.labels = data.labels;
                                                            myChart.data.datasets[0].data = data.data;
                                                            myChart.data.datasets[0].backgroundColor = data.backgroundColor;
                                                            myChart.data.datasets[0].borderColor = data.borderColor;
                                                            myChart.update();
                                                        }
                                                    });
                                                }

                                                $("#booking_date").on("change", function () {
                                                    var selectedDate = $(this).val();
                                                    if (selectedDate) {
                                                        var dateObject = new Date(selectedDate);
                                                        year = dateObject.getFullYear();
                                                        var month = dateObject.getMonth() + 1; // Add 1 because months are 0-indexed
                                                        fetchData(year, month);
                                                        booking_date_month(year, month);
                                                    } else {
                                                        // Default values if no date is selected
                                                        year = 2023;
                                                        month = 5;
                                                        fetchData(year, month);
                                                        booking_date_month(year, month);
                                                    }
                                                });

                                                var defaultDate = new Date(); // You can set a default date here
                                                var defaultYear = defaultDate.getFullYear();
                                                var defaultMonth = defaultDate.getMonth() + 1; // Add 1 because months are 0-indexed
                                                fetchData(defaultYear, defaultMonth);
                                            </script> -->


                                            <input type="date" name="booking_date" id="booking_date"
                                                class="form-control">
                                                <br><br>
                                            <center><label class="form-label" for="date"> Top 10 booked truck</label></center>
                                                <br>
                                            <div style="width: 70%; margin: auto;">
                                                <canvas id="myChart"></canvas>
                                            </div>

                                            <script>
                                                var ctx = document.getElementById('myChart').getContext('2d');
                                                var myChart;

                                                // Function to initialize the chart with default values
                                                function initChart(year, month) {
                                                    myChart = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: {
                                                            labels: [],
                                                            datasets: [{
                                                                label: 'Truck',
                                                                data: [],
                                                                backgroundColor: [],
                                                                borderColor: [],
                                                                borderWidth: 1
                                                            }]
                                                        },
                                                        options: {
                                                            scales: {
                                                                y: {
                                                                    beginAtZero: true,
                                                                    suggestedMin: 0,
                                                                    suggestedMax: 10,
                                                                    stepSize: 1
                                                                }
                                                            }
                                                        }
                                                    });

                                                    fetchData(year, month); // Load data for the default year and month
                                                }

                                                // Function to fetch data based on the selected year and month
                                                function fetchData(year, month) {
                                                    $.ajax({
                                                        url: 'barchart_data.php',
                                                        type: 'GET',
                                                        data: { year: year, month: month }, // Pass the selected year and month as parameters
                                                        dataType: 'json',
                                                        success: function (data) {
                                                            myChart.data.labels = data.labels;
                                                            myChart.data.datasets[0].data = data.data;
                                                            myChart.data.datasets[0].backgroundColor = data.backgroundColor;
                                                            myChart.data.datasets[0].borderColor = data.borderColor;
                                                            myChart.update();
                                                        }
                                                    });
                                                }

                                                // Initialize the chart with default values (2023, 5)
                                                initChart(2023, 5);

                                                // Listen for changes in the date input field
                                                $("#booking_date").on("change", function () {
                                                    var selectedDate = $(this).val();
                                                    if (selectedDate) {
                                                        var dateObject = new Date(selectedDate);
                                                        var year = dateObject.getFullYear();
                                                        var month = dateObject.getMonth() + 1; // Add 1 because months are 0-indexed
                                                        fetchData(year, month); // Update the chart with new data
                                                    }
                                                });
                                            </script>




                                            <script>
                                                function booking_date_month(value1, value2) {
                                                    if (value1 == "" || value2 == "") {
                                                        document.getElementById("dataTable").innerHTML = "";
                                                        return;
                                                    } else {
                                                        var xmlhttp = new XMLHttpRequest();
                                                        xmlhttp.onreadystatechange = function () {
                                                            if (this.readyState == 4 && this.status == 200) {
                                                                document.getElementById("dataTable").innerHTML = this.responseText;
                                                            }
                                                        };
                                                        // Modify the URL to include both values as query parameters
                                                        xmlhttp.open("GET", "tabular_monthwise.php?param1=" + value1 + "&param2=" + value2, true);
                                                        xmlhttp.send();
                                                    }
                                                }
                                            </script>





                                            <script>
                                                function booking_date_week(value1, value2, value3) {
                                                    if (value1 == "" || value2 == "" || value3 == "") {
                                                        document.getElementById("dataTableWeek").innerHTML = "";
                                                        return;
                                                    } else {
                                                        var xmlhttp = new XMLHttpRequest();
                                                        xmlhttp.onreadystatechange = function () {
                                                            if (this.readyState == 4 && this.status == 200) {
                                                                document.getElementById("dataTableWeek").innerHTML = this.responseText;
                                                            }
                                                        };
                                                        // Modify the URL to include both values as query parameters
                                                        xmlhttp.open("GET", "tabular_monthwise.php?param1=" + value1 + "&param2=" + value2 + "&param3=" + value3, true);
                                                        xmlhttp.send();
                                                    }
                                                }
                                            </script>




                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-outline">
                                            <label class="form-label" for="date">Select Month</label>
                                            <select id="month" class="form-control" name="month"
                                                onchange="booking_date_month(year,this.value)">
                                                <option value="select month">Select month</option>

                                                <option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="10">December</option>
                                            </select>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <div id="dataTable" class="container"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-outline">
                                            <label class="form-label" for="date">Current Week</label> -->
                        <!-- <select id="month" class="form-control" name="month"
                                                onchange="booking_date_week(year,month.value,this.value)">
                                                <option value="">Select week</option>
                                                <option value="1">First</option>
                                                <option value="2">Secound</option>
                                                <option value="3">Third</option>
                                                <option value="4">Fourth</option>
                                                <option value="5">Fifth</option>
                                            </select> -->
                        <!-- <div class="table-responsive">
                                                <div id="dataTableWeek" class="container"></div>
                                            </div> -->

                        <!-- </div>
                                    </form>
                                </div>
                            </div>
                        </div> -->
                    </div>



                    <!-- <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title">Reports Generate</p>
                                    <div class="table-responsive">
                                        <div id="dataTable" class="container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->


                    <footer class="footer">

                    </footer>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->

        <!-- plugins:js -->
        <script src="vendors/base/vendor.bundle.base.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page-->
        <script src="vendors/chart.js/Chart.min.js"></script>
        <script src="vendors/datatables.net/jquery.dataTables.js"></script>
        <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
        <!-- End plugin js for this page-->
        <!-- inject:js -->
        <script src="js/off-canvas.js"></script>
        <script src="js/hoverable-collapse.js"></script>
        <script src="js/template.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="js/dashboard.js"></script>
        <script src="js/data-table.js"></script>
        <script src="js/jquery.dataTables.js"></script>
        <script src="js/dataTables.bootstrap4.js"></script>
        <!-- End custom js for this page-->

        <script src="js/jquery.cookie.js" type="text/javascript"></script>
</body>

</html>