<?php
session_start();
require('conection.php');
//   $json_data=include('database.php');
// error_reporting(0);

$gsql = "SELECT COUNT(booking_id) AS count, DATE(booking_date) AS booking_date FROM truck_booking GROUP BY DATE(booking_date) ORDER BY booking_date";
$gresult = mysqli_query($conn, $gsql);

$query = mysqli_query($conn, "select * from user_master");
$usercount = mysqli_num_rows($query);
$query = mysqli_query($conn, "select * from truck_detials");
$truckcount = mysqli_num_rows($query);
$query = mysqli_query($conn, "select * from truck_booking");
$bookingcount = mysqli_num_rows($query);

if (!isset($_SESSION['admin_email'])) {
  header("Location: login.php");
  die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <!-- <link href="assets/img/favicon.png" rel="icon"> -->
  <!-- <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="" class="logo d-flex align-items-center">
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <span class="d-none d-lg-block">TBTS</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">
              <?php echo $_SESSION['admin_email']; ?>
            </span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $_SESSION['admin_email']; ?></h6>
              <!-- <span>Web Designer</span> -->
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="user_profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Log Out</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
    <a class="nav-link collapsed" href="Reports.php">
      <i class="bi bi-journal-text"></i>
      <span>Reports</span>
    </a>
  </li>
<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-text"></i><span>users</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="Transporter.php">
          <i class="bi bi-circle"></i><span>Transporter</span>
        </a>
      </li>
    </ul>
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="customer.php">
          <i class="bi bi-person"></i><span>customer</span>
        </a>
      </li>
      </ul>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="booking.php">
      <i class="bi bi-card-list"></i>
      <span>Booking</span>
    </a>
</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="contact.php">
          <i class="bi bi-telephone"></i>
          <span>contact us</span>
        </a>
      </li><!-- End Error 404 Page Nav -->
      <li class="nav-item">
    <a class="nav-link collapsed" href="feedback.php">
      <i class="bi bi-envelope"></i>
      <span>feedback</span>
    </a>
  </li><!-- End Login Page Nav -->
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="pages-blank.html">
          <i class="bi bi-file-earmark"></i>
          <span>Blank</span>
        </a>
      </li>End Blank Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!--End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <!-- <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a> -->
                  <!-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li> -->
                  <!-- </ul> -->
                </div>

                <div class="card-body">
                  <h5 class="card-title">Customer <span></span></h5>

                  <div class="d-flex align-items-center">
                    <!-- <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> -->
                    <!-- <i class="bi bi-cart"></i> -->
                    <!-- </div> -->
                    <div class="d-flex flex-column justify-content-around">
                      <h5 class="me-2 mb-0">
                        <?php echo $usercount ?>
                      </h5>
                      <!-- <h6>145</h6> -->
                      <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <!-- <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a> -->
                  <!-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul> -->
                </div>

                <div class="card-body">
                  <h5 class="card-title">Truck <span></span></h5>

                  <div class="d-flex align-items-center">
                    <!-- <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div> -->
                    <div class="d-flex flex-column justify-content-around">
                      <h5 class="me-2 mb-0">
                        <?php echo $truckcount ?>
                      </h5>
                      <!-- <h6>$3,264</h6> -->
                      <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                </div>

              </div>

            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="filter">
                  <!-- <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul> -->
                </div>

                <div class="card-body">
                  <h5 class="card-title">Booking <span></span></h5>

                  <div class="d-flex align-items-center">
                    <!-- <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div> -->
                    <div class="d-flex flex-column justify-content-around">
                      <h5 class="mb-0 d-inline-block">
                        <?php echo $bookingcount ?>
                      </h5>
                      <!-- <h6>1244</h6>
                      <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> -->

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Reports <span>/Date wise</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart" style="height: 400px"></div>
                  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                  <script type="text/javascript">
                    google.charts.load('current', { 'packages': ['corechart'] });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                      var data = new google.visualization.DataTable();
                      data.addColumn('string', 'Year');
                      data.addColumn('number', 'Count');

                      <?php
                      while ($data1 = mysqli_fetch_array($gresult)) {
                        $date = $data1["booking_date"];
                        $count = $data1["count"];
                        ?>
                        data.addRow(['<?php echo $date; ?>', <?php echo $count; ?>]);
                      <?php
                      }
                      ?>

                      var options = {
                        title: 'Company bookings',
                        curveType: 'function',
                        legend: { position: 'bottom' }
                      };

                      var chart = new google.visualization.LineChart(document.getElementById('reportsChart'));

                      chart.draw(data, options);
                    }

                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>TBTS</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>