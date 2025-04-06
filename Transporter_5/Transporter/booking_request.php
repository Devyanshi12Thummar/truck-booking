<?php
session_start();
require('connection.php');

if (!isset($_SESSION['managerfullname'])) {
    // header("Location: Adminlogin.php");
    die();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



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
                    <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false"
                        aria-controls="auth">
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

                <!-- <li class="nav-item">
          <a class="nav-link" href="map.php">
            <i class="mdi mdi-google-maps menu-icon"></i>
            <span class="menu-title">Map</span>
          </a>
        </li> -->
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
                                    <h2>Booking</h2>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title">Booking Details</p>
                                    <div class="table-responsive">
                                        <form method='POST'>

                                            <table id="recent-purchases-listing">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>PickupAddress</th>
                                                        <th>DropAddress</th>
                                                        <th>Max Weight</th>
                                                        <th>Goods Type</th>
                                                        <th>Truck Name</th>
                                                        <th>Customer Name</th>
                                                        <th>Assign Driver</th>                                                        
                                                        <th>Reject</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include "connection.php";
                                                    $sql = "SELECT truck_detials.*, truck_booking.*, user_master.*,goods.* FROM truck_booking INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id INNER JOIN user_master ON truck_booking.user_id = user_master.user_id INNER JOIN goods ON truck_booking.goods_id = goods.goods_id where assign_driver_status='0'";
                                                    $result = mysqli_query($conn, $sql);
                                                    $i=1;
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<tr>';
                                                        echo '<td>' . $i . '</td>'; 
                                                        echo '<td>' . $row['pickup_address'] . '</td>';
                                                        echo '<td>' . $row['drop_address'] . '</td>';
                                                        echo '<td>' . $row['goods_weight'] . '</td>';
                                                        echo '<td>' . $row['goods_type'] . '</td>';
                                                        echo '<td>' . $row['truck_name'] . '</td>';
                                                        echo '<td>' . $row['user_fullname'] . '</td>';
                                                        echo " <td>.<a href='view_driver.php?id=$row[booking_id]' class='link-dark'><span class='material-symbols-outlined'>Assign Driver</span></a>.</td>";
                                                        echo " <td>.<a href='reject.php?id=$row[booking_id]' class='link-dark'><span class='material-symbols-outlined'>Reject</span></a>.</td>";
                                                        $i++;
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