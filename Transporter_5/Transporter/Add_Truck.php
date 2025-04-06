<?php
session_start();
require('connection.php');
// // include('Adminlogin.php');

// if (!isset($_SESSION['managerfullname'])) {
//   // header("Location: Adminlogin.php");
//   die();
// }
if (isset($_FILES['image1'])) {
  $error = array();
  $file_name1 = $_FILES['image1']['name'];
  $Filesize = $_FILES['image1']['size'];
  $filetype = $_FILES['image1']['type'];
  $tem_name = $_FILES['image1']['tmp_name'];
  $error = $_FILES['image1']['error'];

  move_uploaded_file($tem_name, "truck_images/" . $file_name1);
}
if (isset($_FILES['image2'])) {
  $error = array();
  $file_name2 = $_FILES['image2']['name'];
  $Filesize = $_FILES['image2']['size'];
  $filetype = $_FILES['image2']['type'];
  $tem_name = $_FILES['image2']['tmp_name'];
  $error = $_FILES['image2']['error'];

  move_uploaded_file($tem_name, "truck_images/" . $file_name2);
}
if (isset($_FILES['image3'])) {
  $error = array();
  $file_name3 = $_FILES['image3']['name'];
  $Filesize = $_FILES['image3']['size'];
  $filetype = $_FILES['image3']['type'];
  $tem_name = $_FILES['image3']['tmp_name'];
  $error = $_FILES['image3']['error'];

  move_uploaded_file($tem_name, "truck_images/" . $file_name3);
}

$message = "";
try {
  if (isset($_POST['addtruck'])) {

    $truck_name = mysqli_real_escape_string($conn, $_POST['tname']);
    $truck_number = mysqli_real_escape_string($conn, $_POST['tnumber']);
    $c_name = mysqli_real_escape_string($conn, ($_POST['companyname']));
    $fule = mysqli_real_escape_string($conn, ($_POST['fule']));
    $weight = mysqli_real_escape_string($conn, ($_POST['weight']));
    $model = mysqli_real_escape_string($conn, ($_POST['modelnu']));
    $size = mysqli_real_escape_string($conn, ($_POST['size']));
    $image1 = mysqli_real_escape_string($conn, ("truck_images/$file_name1"));
    $image2 = mysqli_real_escape_string($conn, ("truck_images/$file_name2"));
    $image3 = mysqli_real_escape_string($conn, ("truck_images/$file_name3"));
    $hour_rate = mysqli_real_escape_string($conn, ($_POST['hour_rate']));
    $day_rate = mysqli_real_escape_string($conn, ($_POST['day_rate']));
    $fule_rate = mysqli_real_escape_string($conn, ($_POST['fule_rate']));


    $sql1 = "select * from truck_company where truck_company_name = '$c_name'";
    $result1 = mysqli_query($conn, $sql1);

    while ($row = mysqli_fetch_assoc($result1)) {
      $cid = $row['truck_company_id'];
    }

    $select_users = mysqli_query($conn, "SELECT * FROM truck_detials WHERE  truck_register_number = '$truck_number'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
    } elseif ($truck_name == "") {
      echo '<script>alert("Truck Type is EMPTY..")</script>';
    } elseif ($truck_number == "") {
      echo '<script>alert("Truck Number is EMPTY..")</script>';
      $message = "";
    } elseif ($c_name == "") {
      echo '<script>alert("Company Name  is EMPTY..")</script>';
    } elseif ($fule == "") {
      echo '<script>alert("Fuel Type is EMPTY..")</script>';
    } elseif ($model == "") {
      echo '<script>alert("Model number is EMPTY..")</script>';
    } elseif ($size == "") {
      echo '<script>alert("Size is EMPTY..")</script>';
    } elseif ($weight == "") {
      echo '<script>alert("Max Weight is EMPTY..")</script>';
    } elseif ($image1 == "") {
      echo '<script>alert("Image is EMPTY..")</script>';
    } elseif ($image2 == "") {
      echo '<script>alert("Image is EMPTY..")</script>';
    } elseif ($image3 == "") {
      echo '<script>alert("Image is EMPTY..")</script>';
    } else {
      mysqli_query($conn, "insert into truck_detials values(`truck_id`,'$truck_number','$image1','$image2','$image3','$truck_name','$size','$model','$weight','$cid','$fule','$hour_rate','$day_rate','$fule_rate')") or die('query failed');

      echo '<script>alert("Add truck successfully!")</script>';

      // header('location:login.php');
    }
  }
} catch (Exception $e) {
  die($e);
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

  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />

  <!-- 
  <script>
    const truckNumberPlate = document.getElementById("trucknumber");

    truckNumberPlate.addEventListener("keypress", function(event) {
      const key = event.keyCode || event.charCode;
      const inputValue = String.fromCharCode(key);

      // Check if the input value matches the required pattern
      if (!/^[A-Za-z]{0,2}[0-9]{0,2}[a-zA-Z0-9]{0,4}$/.test(truckNumberPlate.value + inputValue)) {
        event.preventDefault(); // Prevent the input from being added to the field
      }
    });
  </script> -->
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
          <a class="navbar-brand brand-logo" href="index.html">TBTS</a>
          <a class="navbar-brand brand-logo-mini" href="Home.php"><img src="images/logo-mini.svg" alt="logo" /></a>
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
      <!-- partial:../../partials/_sidebar.html -->
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

            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title" style="text-align:center;color:blue;">ADD TRUCK Details</h4>


                  <form class="form-sample" method="post" enctype="multipart/form-data">
                    <p class="card-description">
                      <br>
                    </p>

                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <div class="form-outline">
                          <label class="form-label" for="tname">Truck Name<span style="color:red;">*</span></label>
                          <input type="text" id="tname" class="form-control" name="tname"
                            onkeypress="return event.charCode >= 65 && event.charCode <= 123" />

                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-outline">
                          <label class="form-label" for="tname">Truck Register Number<span
                              style="color:red;">*</span></label>
                          <input type="text" id="trucknumber" class="form-control" name="tnumber" />
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-outline">
                          <option value="">Select Company Name<span style="color:red;">*</span></option>
                          <select name="companyname" class="form-control" id="goods">
                            <?php
                            $sql = "select * from truck_company";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                              $comname = $row["truck_company_name"];
                              ?>
                              <option value="<?php echo $row['truck_company_name']; ?>"> <?php echo $row['truck_company_name']; ?> </option>

                            <?php }
                            ?>

                          </select>


                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-outline">
                          <label class="form-label" for="tcode">Fuel Type<span style="color:red;">*</span></label>
                          <select name="fule" id="fule" class="form-control">
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-outline">
                          <label class="form-label" for="tcode">Model Number<span style="color:red;">*</span></label>
                          <input type="text" id="modelnu" class="form-control" name="modelnu" />
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <label class="form-label" for="tcode">Max Capacity<span style="color:red;">*</span></label>
                        <div class="form-outline">
                          <input type="text" id="weight" class="form-control" name="weight"
                            onkeypress="return event.charCode >= 47 && event.charCode <= 57" />
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-outline">
                          <label class="form-label" for="tcode">SIZE (FT)<span style="color:red;">*</span></label>
                          <input type="text" id="size" class="form-control" name="size" />
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div>
                          <label class="form-label" for="tcode">image 1<span style="color:red;">*</span></label><br>
                          <input type="file" id="image1" name="image1" /><br>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div>
                          <label class="form-label" for="tcode">image 2<span style="color:red;">*</span></label><br>
                          <input type="file" id="image2" name="image2" /><br>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div>
                          <label class="form-label" for="tcode">image 3<span style="color:red;">*</span></label><br>
                          <input type="file" id="image3" name="image3" /><br>
                        </div>
                      </div><br>

                      <div class="col-md-6 mb-3">
                        <div class="form-outline">
                          <label class="form-label" for="tcode">Additional Services Charges base Per Hour Rate<span
                              style="color:red;">*</span></label><br>
                          <input type="text" id="size" class="form-control"
                            onkeypress="return event.charCode >= 46 && event.charCode <= 57" name="hour_rate" />
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-outline">
                          <label class="form-label" for="tcode">Additional Services Charges base Per Day Rate<span
                              style="color:red;">*</span></label><br>
                          <input type="text" id="size" class="form-control"
                            onkeypress="return event.charCode >= 46 && event.charCode <= 57" name="day_rate" />
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-outline">
                          <label class="form-label" for="tcode">Fuel Charges base on 1 Km<span
                              style="color:red;">*</span></label>
                          <input type="text" id="size" class="form-control"
                            onkeypress="return event.charCode >= 46 && event.charCode <= 57" name="fule_rate" />
                        </div>
                      </div>
                    </div>

                    <br>
                    <input type="submit" class="btn btn-primary mt-3 p-2 " style="margin-left:45%;" name="addtruck"
                      value="Add Truck" />

                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->

        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
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