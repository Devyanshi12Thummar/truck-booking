<?php
session_start();
          require('conection.php');
        //   $json_data=include('database.php');
          error_reporting(0);
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
<!-- /city book -->

<script>
        function truck_re(str) {
            if (str == "") {
                document.getElementById("dataTable").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
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
        function datewisebooking(str) {
            if (str == "") {
                document.getElementById("dataTable").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("dataTable").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "datewisebooking.php?q=" + str, true);
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
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("dataTable").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "monthwise_higest_city.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>

<!-- /city book -->

    <script>
        function citybook(str) {
            if (str == "") {
                document.getElementById("dataTable").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
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
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("dataTable").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "yearwise_maxcity.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
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
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['admin_email']; ?></span>
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
            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li> --> 

          <!-- </ul>End Profile Dropdown Items -->
        <!-- </li>End Profile Nav -->

      <!-- </ul> -->
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
  <aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="home.php">
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
  </li><!-- End Login Page Nav -->

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
</ul>

</aside><!-- End Sidebar-->


  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Booking reports</h1>
      <nav>
        <!-- <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol> -->
      </nav>
    </div><!--End Page Title -->

    <section class="section dashboard">
    <div class="main-panel">
            <div class="content-wrapper">
    <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex align-items-end flex-wrap">
                                <div class="me-md-3 me-xl-5">
                                    <!-- <h2>Booking Reports</h2> -->
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-outline">
                                            <label class="form-label" for="date"> Enter Date:</label>
                                            <input type="date" id="datewise" class="form-control" placeholder="YYYY-MM-DD"  format="YYYY-MM-DD" name="datewise"  onchange="datewisebooking(this.value)" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                <form method="post">
                                        <div class="form-outline">
                                            <label class="form-label" for="date"> Enter city</label>
                                            <select name="city" class="form-control" onchange="citybook(this.value)">
                                            <option value="">Select city</option>

                                                <?php
                                                require('conection.php');
                                                $sql = "select * from truck_booking";
                                                $result = mysqli_query($conn, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                   ?>
                                                         <option value="<?php echo $row['booking_id']; ?>"> <?php echo $row['pickup_address']; ?>
                                             </option>

                                                <?php 
                                                }

                                                ?>
                                            </select>
                                            <!-- <input type="text" id="city_book" class="form-control" onchange="citybook(this.value)" name="city_book" /> -->

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-outline">
                                            <label class="form-label" for="date"> Enter Month: (Highest booking in city)</label>
                                            <input type="text" id="maxcity" class="form-control" onchange="city(this.value)" name="month" />

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-outline">
                                            <label class="form-label" for="date"> Enter Year: (Highest Booking Truck)</label>
                                            <input type="text" id="maxtruck" class="form-control" onchange="truck_re(this.value)" name="year" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-outline">
                                            <label class="form-label" for="date"> Enter Year: (Highest Booking in City)</label>
                                            <input type="text" id="maxtruck" class="form-control" onchange="yearmaxcity(this.value)" name="year" />

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
    </section>

  </main><!-- End #main -->

 

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