<?php


session_start();
require('connection.php');


if (!isset($_SESSION['managerfullname'])) {
  header("Location: ../../Customer_5/login.php");
  die();
}


// if (isset($_POST["submit"])) {


if (isset($_POST["year"])) {
  $year = $_POST["year"];
  $graph = "

    SELECT t_max.year AS year,
        t_max.truck_id AS max_truck_id,
        t_max.booking_count AS max_booking_count,
        t_min.truck_id AS min_truck_id,
        t_min.booking_count AS min_booking_count
    FROM (
     SELECT YEAR(booking_date) AS year,
            truck_id,
            COUNT(*) AS booking_count
     FROM truck_booking
     WHERE YEAR(booking_date) =  $year
     GROUP BY year, truck_id
     HAVING booking_count = (
         SELECT MAX(sub.booking_count)
         FROM (
             SELECT COUNT(*) AS booking_count
             FROM truck_booking
             WHERE YEAR(booking_date) =  $year
             GROUP BY truck_id
         ) sub
     )
    ) t_max
    JOIN (
     SELECT YEAR(booking_date) AS year,
            truck_id,
            COUNT(*) AS booking_count
     FROM truck_booking
     WHERE YEAR(booking_date) =  $year
     GROUP BY year, truck_id
     HAVING booking_count = (
         SELECT MIN(sub.booking_count)
         FROM (
             SELECT COUNT(*) AS booking_count
             FROM truck_booking
             WHERE YEAR(booking_date) =  $year
             GROUP BY truck_id
         ) sub
     )
    ) t_min ON t_max.year = t_min.year
    ORDER BY year;
    ";

  $graphresult = mysqli_query($conn, $graph);

  // while ($rowgraph = mysqli_fetch_array($graphresult)) {
  //   $maxtruckid = ['max_truck_id'];
  //   $mintruckid = ['min_truck_id'];
  //   $max = $rowgraph['max_booking_count'];
  //   $min = $rowgraph['min_booking_count'];
  // }



  $rowgraph = mysqli_fetch_array($graphresult);
  $maxtruckid = $rowgraph['max_truck_id'];
  $mintruckid = $rowgraph['min_truck_id'];
  $max = $rowgraph['max_booking_count'];
  $min = $rowgraph['min_booking_count'];



  $namesql = "SELECT DISTINCT truck_booking.truck_id, truck_detials.truck_id, truck_detials.truck_name 
    FROM truck_booking 
    INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id 
    WHERE  truck_booking.truck_id = $mintruckid";

  $nameres = mysqli_query($conn, $namesql);
  $ro = mysqli_fetch_assoc($nameres);

  $mintruckname = $ro['truck_name'];




  $namesql1 = "SELECT DISTINCT truck_booking.truck_id, truck_detials.truck_id, truck_detials.truck_name 
        FROM truck_booking 
        INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id 
        WHERE truck_booking.truck_id = $maxtruckid";

  $nameres1 = mysqli_query($conn, $namesql1);
  $ro1 = mysqli_fetch_assoc($nameres1);


  $maxtruckname = $ro1['truck_name'];
} else {
  $year = 2023;
  $graph = "

    SELECT t_max.year AS year,
        t_max.truck_id AS max_truck_id,
        t_max.booking_count AS max_booking_count,
        t_min.truck_id AS min_truck_id,
        t_min.booking_count AS min_booking_count
    FROM (
     SELECT YEAR(booking_date) AS year,
            truck_id,
            COUNT(*) AS booking_count
     FROM truck_booking
     WHERE YEAR(booking_date) =  $year
     GROUP BY year, truck_id
     HAVING booking_count = (
         SELECT MAX(sub.booking_count)
         FROM (
             SELECT COUNT(*) AS booking_count
             FROM truck_booking
             WHERE YEAR(booking_date) =  $year
             GROUP BY truck_id
         ) sub
     )
    ) t_max
    JOIN (
     SELECT YEAR(booking_date) AS year,
            truck_id,
            COUNT(*) AS booking_count
     FROM truck_booking
     WHERE YEAR(booking_date) =  $year
     GROUP BY year, truck_id
     HAVING booking_count = (
         SELECT MIN(sub.booking_count)
         FROM (
             SELECT COUNT(*) AS booking_count
             FROM truck_booking
             WHERE YEAR(booking_date) =  $year
             GROUP BY truck_id
         ) sub
     )
    ) t_min ON t_max.year = t_min.year
    ORDER BY year;
    ";

  $graphresult = mysqli_query($conn, $graph);

  // while ($rowgraph = mysqli_fetch_array($graphresult)) {
  //   $maxtruckid = ['max_truck_id'];
  //   $mintruckid = ['min_truck_id'];
  //   $max = $rowgraph['max_booking_count'];
  //   $min = $rowgraph['min_booking_count'];
  // }



  $rowgraph = mysqli_fetch_array($graphresult);
  $maxtruckid = $rowgraph['max_truck_id'];
  $mintruckid = $rowgraph['min_truck_id'];
  $max = $rowgraph['max_booking_count'];
  $min = $rowgraph['min_booking_count'];



  $namesql = "SELECT DISTINCT truck_booking.truck_id, truck_detials.truck_id, truck_detials.truck_name 
    FROM truck_booking 
    INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id 
    WHERE  truck_booking.truck_id = $mintruckid";

  $nameres = mysqli_query($conn, $namesql);
  $ro = mysqli_fetch_assoc($nameres);

  $mintruckname = $ro['truck_name'];




  $namesql1 = "SELECT DISTINCT truck_booking.truck_id, truck_detials.truck_id, truck_detials.truck_name 
        FROM truck_booking 
        INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id 
        WHERE truck_booking.truck_id = $maxtruckid";

  $nameres1 = mysqli_query($conn, $namesql1);
  $ro1 = mysqli_fetch_assoc($nameres1);


  $maxtruckname = $ro1['truck_name'];
}


// }
// else

// {
// $graph = "

// SELECT t_max.year AS year,
//     t_max.truck_id AS max_truck_id,
//     t_max.booking_count AS max_booking_count,
//     t_min.truck_id AS min_truck_id,
//     t_min.booking_count AS min_booking_count
// FROM (
//  SELECT YEAR(booking_date) AS year,
//         truck_id,
//         COUNT(*) AS booking_count
//  FROM truck_booking
//  WHERE YEAR(booking_date) = YEAR(NOW())
//  GROUP BY year, truck_id
//  HAVING booking_count = (
//      SELECT MAX(sub.booking_count)
//      FROM (
//          SELECT COUNT(*) AS booking_count
//          FROM truck_booking
//          WHERE YEAR(booking_date) = YEAR(NOW())
//          GROUP BY truck_id
//      ) sub
//  )
// ) t_max
// JOIN (
//  SELECT YEAR(booking_date) AS year,
//         truck_id,
//         COUNT(*) AS booking_count
//  FROM truck_booking
//  WHERE YEAR(booking_date) =  YEAR()
//  GROUP BY year, truck_id
//  HAVING booking_count = (
//      SELECT MIN(sub.booking_count)
//      FROM (
//          SELECT COUNT(*) AS booking_count
//          FROM truck_booking
//          WHERE YEAR(booking_date) =  YEAR(NOW())
//          GROUP BY truck_id
//      ) sub
//  )
// ) t_min ON t_max.year = t_min.year
// ORDER BY year;
// ";

//   $graphresult = mysqli_query($conn, $graph);

//   // while ($rowgraph = mysqli_fetch_array($graphresult)) {
//   //   $maxtruckid = ['max_truck_id'];
//   //   $mintruckid = ['min_truck_id'];
//   //   $max = $rowgraph['max_booking_count'];
//   //   $min = $rowgraph['min_booking_count'];
//   // }



//   $rowgraph = mysqli_fetch_array($graphresult);
//   $maxtruckid = $rowgraph['max_truck_id'];
//   $mintruckid = $rowgraph['min_truck_id'];
//   $max = $rowgraph['max_booking_count'];
//   $min = $rowgraph['min_booking_count'];



//   $namesql = "SELECT DISTINCT truck_booking.truck_id, truck_detials.truck_id, truck_detials.truck_name 
// FROM truck_booking 
// INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id 
// WHERE  truck_booking.truck_id = $mintruckid";

//   $nameres = mysqli_query($conn, $namesql);
//   $ro = mysqli_fetch_assoc($nameres);

//   $mintruckname = $ro['truck_name'];




//   $namesql1 = "SELECT DISTINCT truck_booking.truck_id, truck_detials.truck_id, truck_detials.truck_name 
//     FROM truck_booking 
//     INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id 
//     WHERE truck_booking.truck_id = $maxtruckid";

//   $nameres1 = mysqli_query($conn, $namesql1);
//   $ro1 = mysqli_fetch_assoc($nameres1);


//   $maxtruckname = $ro1['truck_name'];



// }



$gsql = "SELECT COUNT(booking_id) AS count, MONTH(booking_date) AS booking_month FROM truck_booking GROUP BY booking_month ORDER BY booking_month;";
$gresult = mysqli_query($conn, $gsql);


if (isset($_POST['sms'])) {
  function sendSMS($mobileNo, $message)
  {
    $curl = curl_init();
    $api_key = "5kcU3MkS3bGZ89uT2ZNBeTKiXeNptAuTixFsvqC9IU5Hj0OzwW3yYZ252iBC";
    curl_setopt_array(
      $curl,
      array(
        CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=" . $api_key . "&sender_id=TXTIND&message=" . urlencode($message) . "&route=v3&numbers=" . urlencode($mobileNo),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache"
        ),
      )
    );

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
  }
  sendSMS("9604477844", " Your Truck Book Successfully!");
}


?>


<!DOCTYPE html>
<html lang="en">

<head>


  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Truck Booking</title>
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
  <!-- <div class="container-scroller"> -->

  <!-- partial:partials/_navbar.html -->
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
      <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
        <a class="navbar-brand brand-logo" href="index.html">TBTS</a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo" /></a>
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
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown">
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
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
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
          <a class="nav-link" href="driver_location.php">
            <i class="mdi mdi-google-maps menu-icon"></i>
            <span class="menu-title">Driver Loaction</span>
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
              </div>
            </div>
          </div>

          <?php
          require('connection.php');
          $query = mysqli_query($conn, "select * from user_master");
          $usercount = mysqli_num_rows($query);
          $query = mysqli_query($conn, "select * from truck_detials");
          $truckcount = mysqli_num_rows($query);
          $query = mysqli_query($conn, "select * from truck_booking");
          $bookingcount = mysqli_num_rows($query);

          ?>
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body dashboard-tabs p-0">
                  <ul class="nav nav-tabs px-4" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" href="#overview" role="tab"
                        aria-controls="overview" aria-selected="true">Overview</a>
                    </li>
                    <!-- <li class="nav-item">
                      <a class="nav-link" id="sales-tab" data-bs-toggle="tab" href="#sales" role="tab" aria-controls="sales" aria-selected="false">Sales</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="purchases-tab" data-bs-toggle="tab" href="#purchases" role="tab" aria-controls="purchases" aria-selected="false">Purchases</a>
                    </li> -->
                  </ul>
                  <div class="tab-content py-0 px-0">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                      <div class="d-flex flex-wrap justify-content-xl-between">
                        <div
                          class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi mdi-book-minus icon-lg me-3 text-primary"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Booking</small>
                            <h5 class="mb-0 d-inline-block">
                              <?php echo $bookingcount ?>
                            </h5>
                          </div>
                        </div>
                        <!-- <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi mdi-account me-3 icon-lg text-danger"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Transporter</small>
                            <h5 class="me-2 mb-0">1</h5>
                          </div>
                        </div> -->
                        <!-- <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi mdi-account me-3 icon-lg text-danger"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Customer</small>
                            <h5 class="me-2 mb-0"><?php echo $usercount ?></h5>
                          </div>
                        </div> -->
                        <div
                          class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-truck me-3 icon-lg text-success"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Truck</small>
                            <h5 class="me-2 mb-0">
                              <?php echo $truckcount ?>
                            </h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
              <div class="card">
                <div id="reportsChart" style=" margin-left:-25px;height: 400px; width: 650px;" class="card-body">
                  <p class="card-title">Monthly Booking Reports</p>



                  <!-- <div id="reportsChart" style=" margin-left:-80px;height: 400px; width: 700px;"></div> -->

                  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                  <script type="text/javascript">
                    google.charts.load('current', { 'packages': ['corechart'] });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                      var data = new google.visualization.DataTable();
                      data.addColumn('string', 'Month');
                      data.addColumn('number', 'Month');

                      <?php
                      $monthNames = array(
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December"
                      );

                      // Initialize an array to hold the counts for each month
                      $monthCounts = array_fill(0, 12, 0);

                      while ($data1 = mysqli_fetch_array($gresult)) {
                        $monthIndex = $data1["booking_month"] - 1; // Subtract 1 to get the correct array index
                        $count = $data1["count"];
                        // Update the count for the corresponding month
                        $monthCounts[$monthIndex] = $count;
                      }

                      // Calculate the maximum value
                      $maxValue = max($monthCounts);

                      // Loop through all months and add them to the chart data
                      for ($i = 0; $i < 12; $i++) {
                        $monthName = $monthNames[$i];
                        $count = $monthCounts[$i];
                        ?>
                        data.addRow(['<?php echo $monthName; ?>', <?php echo $count; ?>]);
                        <?php
                      }
                      ?>

                      var options = {
                        title: 'No of bookings',
                        curveType: 'function',
                        legend: { position: 'bottom' },
                        vAxis: {
                          format: '0',
                          viewWindow: {
                            min: 0,
                            max: <?php echo $maxValue; ?> // Use the calculated max value here
                          },
                          ticks: [
                            <?php
                            for ($i = 0; $i <= $maxValue; $i++) {
                              echo $i;
                              if ($i < $maxValue) {
                                echo ', ';
                              }
                            }
                            ?>
                          ]
                        }
                      };

                      var chart = new google.visualization.LineChart(document.getElementById('reportsChart'));

                      chart.draw(data, options);
                    }
                  </script>

                </div>
              </div>
            </div>
            <div class="col-md-5 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Total Booking</p>
                  <h1>10</h1>
                  <h4>Booking over the years</h4>
                  <p class="text-muted">Today, many people rely on computers to do homework, work, and create or store
                    useful information. Therefore, it is important </p>
                  <div id="total-sales-chart-legend"></div>
                </div>
                <canvas id="total-sales-chart"></canvas>
              </div>
            </div>
          </div>







          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">

                    <!-- <p class="card-title">Truck Booking Status(Yearly)</p>


                    <div width="100" height="200"> <canvas id="myChart"></canvas></div>



                    <script>
                      var ctx = document.getElementById('myChart').getContext('2d');
                      var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                          labels: ['<?php echo $mintruckname . "', '" . $maxtruckname ?>'],
                          datasets: [{
                            label: ['Minimum'],

                            data: [<?php echo $min; ?>, <?php echo $max; ?>],
                            backgroundColor: [
                              'rgba(255, 99, 132, 0.2)', // Red with transparency
                              'rgba(54, 162, 235, 0.2)'  // Blue with transparency
                            ],
                            borderColor: [
                              'rgba(255, 99, 132, 1)', // Solid red
                              'rgba(54, 162, 235, 1)'  // Solid blue
                            ],
                            borderWidth: 1
                          }]

                        },
                        options: {
                          scales: {
                            y: {
                              beginAtZero: true
                            }
                          }
                        }
                      });
                    </script> -->






                    




                      <script>
                        document.getElementById("yearInput").addEventListener("select", function () {
                          var year = this.value;

                          // Make an AJAX request to retrieve data
                          var xhr = new XMLHttpRequest();
                          xhr.open("POST", "data-retrieval.php", true);
                          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                          xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                              document.getElementById("resultDiv").innerHTML = xhr.responseText;
                            }
                          };
                          xhr.send("year=" + year);
                        });
                      </script>







                      <br><br>
                      <table id="recent-purchases-listing">
                        <thead>
                          <p class="card-title">Today Booking</p>

                          <tr>
                            <th>Booking Id</th>
                            <th>PickupAddress</th>
                            <th>DropAddress</th>
                            <th>Max Weight</th>
                            <th>Goods</th>
                            <th>Truck Name</th>
                            <th>Customer Id</th>
                            <th>Reject</th>

                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          include "connection.php";

                          // $date = date('Y-m-d', time());
                          // echo $date;
                          

                          $d = "select NOW() as curdate";
                          $resu = mysqli_query($conn, $d);
                          $date = mysqli_fetch_assoc($resu);

                          $sql = "SELECT * FROM `truck_booking` where Date(booking_date)=CURDATE(); ";
                          $result = mysqli_query($conn, $sql);
                          while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['booking_id'] . '</td>';
                            $bookid = $row['booking_id'];
                            echo '<td>' . $row['pickup_address'] . '</td>';
                            echo '<td>' . $row['drop_address'] . '</td>';
                            echo '<td>' . $row['goods_weight'] . '</td>';
                            echo '<td>' . $row['goods_id'] . '</td>';
                            echo '<td>' . $row['truck_id'] . '</td>';
                            echo '<td>' . $row['user_id'] . '</td>';
                            echo " <td>.<a href='reject.php?id=$row[booking_id]' class='link-dark'><span class='material-symbols-outlined'>Reject</span></a>.</td>";

                            echo "</tr>";
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
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
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