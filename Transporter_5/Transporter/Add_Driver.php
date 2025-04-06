<?php
session_start();
require('connection.php');

if (isset($_POST['adddriver'])) {

    // $Usertype = 0;
    $Firstname = mysqli_real_escape_string($conn, $_POST['fname']);
    $Lastname = mysqli_real_escape_string($conn, $_POST['lname']);
    $Fullname = $Firstname . " " . $Lastname;
    $Email = mysqli_real_escape_string($conn, $_POST['email']);
    $Primarycontact = mysqli_real_escape_string($conn, $_POST['pno']);
    $Secondarycontact = mysqli_real_escape_string($conn, $_POST['sno']);
    $Address = mysqli_real_escape_string($conn, $_POST['add']);
    $City = mysqli_real_escape_string($conn, $_POST['city']);
    $Pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $license = mysqli_real_escape_string($conn, $_POST['ln']);
    $pass = "password";
    // $mobileNo = $_POST['contact'];

    function validateEmail($Email)
    {
        // Regular expression pattern to validate email addresses
        $pattern = '/^[a-zA-Z0-9._%+-]+@gmail\.com$/i';

        // Use preg_match to check if the email matches the pattern
        if (preg_match($pattern, $Email)) {
            return true; // Email is valid and contains "gmail.com"
        } else {
            return false; // Email is invalid or does not contain "gmail.com"
        }
    }

    function validateIndianContactNumber($Primarycontact)
    {
        // Remove any non-numeric characters from the input
        $number = preg_replace('/[^0-9]/', '', $Primarycontact);

        // Check if the number starts with a valid digit (6, 7, 8, or 9)
        if (preg_match('/^[6-9]\d{9}$/', $Primarycontact)) {
            return true;
        } else {
            return false;
        }
    }


    // Usage example:
    if (empty($Email)) {
        echo "<script>alert('Please Enter Email Id');</script>";
    } else if (!validateEmail($Email)) {
        echo "<script>alert('Please Enter Valid Email Id');</script>";
    } else if (empty($Firstname)) {
        echo "<script>alert('Please Enter First Name');</script>";
    } else if (empty($Lastname)) {
        echo "<script>alert('Please Enter Last Name');</script>";
    } else if (empty($Primarycontact)) {
        echo "<script>alert('Please Enter Contect Number');</script>";
    } else if (!validateIndianContactNumber($Primarycontact)) {
        echo "<script>alert('Please Enter Valid Contact Number');</script>";
    } else if (empty($Address)) {
        echo "<script>alert('Please Enter Your Address');</script>";
    } else if (empty($City)) {
        echo "<script>alert('Please Enter Your City');</script>";
    } else if (empty($Pincode)) {
        echo "<script>alert('Please Enter Your Pincode');</script>";
    } else {
        // echo "<script>alert('Registration SuccessFull');</script>";
        // $hashedPassword = password_hash($PasswordRegister, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("SELECT * FROM truck_driver WHERE driver_email = ?") or die('Query preparation failed.');

        $stmt->bind_param("s", $Email);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<script>alert("User already exists")</script>';
        } else {
            $stmt = $conn->prepare("INSERT INTO truck_driver (driver_fullname, driver_email, driver_contactno_primary, driver_contactno_secoundary, driver_address, driver_city, driver_pincode, driver_license, driver_password) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if (!$stmt) {
                die("Error in prepare statement: ");
            }

            $stmt->bind_param("sssssssss", $Fullname, $Email, $Primarycontact, $Secondarycontact, $Address, $City, $Pincode, $license, $pass);

            if (!$stmt) {
                die("Error in bind parameters: " . $stmt->error);
            }

            if ($stmt->execute()) {
                echo '<script>alert("Registered successfully!");</script>';
            } else {
                die("Error in execution: " . $stmt->error);
            }

            $stmt->close();
            echo '<script>alert("Registered successfully!")</script>';


            $message = "Username: $Email\nPassword: password";
            function sendSMS($Primarycontact, $message)
            {
                $curl = curl_init();
                $api_key = "5kcU3MkS3bGZ89uT2ZNBeTKiXeNptAuTixFsvqC9IU5Hj0OzwW3yYZ252iBC";
                curl_setopt_array(
                    $curl,
                    array(
                        CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=" . $api_key . "&sender_id=TXTIND&message=" . urlencode($message) . "&route=v3&numbers=" . urlencode($Primarycontact),
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
            sendSMS($Primarycontact, $message);

        }
    }
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

    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="images/favicon.png" />

    <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
                    <a class="navbar-brand brand-logo-mini" href="Home.php"><img src="images/logo-mini.svg"
                            alt="logo" /></a>
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-toggle="minimize">
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
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="messageDropdown">
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
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
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

                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align:center;">Add Driver</h4>


                                    <form class="form-sample" method="post" enctype="multipart/form-data">
                                        <p class="card-description">
                                            <br>
                                        </p>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-outline">
                                                    <label class="form-label" for="fname">First Name<span
                                                            style="color:red;">*</span></label>
                                                    <input type="text" id="fname" class="form-control" name="fname"
                                                        onkeypress="return event.charCode >= 65 && event.charCode <= 123" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-outline">
                                                    <label class="form-label" for="lname">Last Name<span
                                                            style="color:red;">*</span></label>
                                                    <input type="text" id="lname" class="form-control" name="lname"
                                                        onkeypress="return event.charCode >= 65 && event.charCode <= 123" />
                                                </div>
                                            </div>
                                            <script>
                                                const fname = document.getElementById('fname');

                                                fname.addEventListener('input', function () {
                                                    const nameValue = fname.value;

                                                    if (nameValue.length > 0) {
                                                        const capitalized = nameValue.charAt(0).toUpperCase() + nameValue.slice(1);
                                                        fname.value = capitalized;
                                                    }
                                                });
                                                const lname = document.getElementById('lname');

                                                lname.addEventListener('input', function () {
                                                    const nameValue = lname.value;

                                                    if (nameValue.length > 0) {
                                                        const capitalized = nameValue.charAt(0).toUpperCase() + nameValue.slice(1);
                                                        lname.value = capitalized;
                                                    }
                                                });
                                            </script>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-outline">
                                                    <label class="form-label" for="email">Email id<span
                                                            style="color:red;">*</span></label>
                                                    <input type="text" id="email" class="form-control" name="email" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-outline">
                                                    <label class="form-label" for="pno">Primary Contact Number <span
                                                            style="color:red;">*</span></label>
                                                    <input type="text" id="pno" class="form-control" name="pno"
                                                        onkeypress="return event.charCode >= 47 && event.charCode <= 57" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" for="sno">Secoundary Contact Number</label>
                                                <div class="form-outline">
                                                    <input type="text" id="sno" class="form-control" name="sno"
                                                        onkeypress="return event.charCode >= 47 && event.charCode <= 57" />
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6 mb-3">
                                                <div class="form-outline">
                                                    <label for="gender" class="form-label">Gender<span
                                                            style="color:red;">*</span></label><br>
                                                    <input type="radio" name="gender" value="m"> Male
                                                    <input type="radio" name="gender" value="f"> Female
                                                </div>
                                            </div> -->
                                            <div class="col-md-6 mb-3">
                                                <div class="form-outline">
                                                    <label class="form-label" for="add">Address<span
                                                            style="color:red;">*</span></label><br>
                                                    <input type="text" id="add" class="form-control"
                                                        onkeypress="return event.charCode >= 65 && event.charCode <= 123"
                                                        name="add" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-outline">
                                                    <label class="form-label" for="city">City<span
                                                            style="color:red;">*</span></label><br>
                                                    <input type="text" id="city" class="form-control"
                                                        onkeypress="return event.charCode >= 65 && event.charCode <= 123"
                                                        name="city" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-outline">
                                                    <label class="form-label" for="pincode">Pincode<span
                                                            style="color:red;">*</span></label>
                                                    <input type="text" id="pincode" class="form-control"
                                                        onkeypress="return event.charCode >= 47 && event.charCode <= 57"
                                                        name="pincode" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-outline">
                                                    <label class="form-label" for="ln">Licens Number<span
                                                            style="color:red;">*</span></label>
                                                    <input type="text" id="ln" class="form-control" name="ln" />
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6 mb-3">
                                                <div class="form-outline">
                                                    <label class="form-label" for="password">Password<span
                                                            style="color:red;">*</span></label>
                                                    <input type="text" id="size" class="form-control" name="password" />
                                                </div>
                                            </div> -->
                                        </div>
                                        <br>
                                        <input type="submit" class="btn btn-primary mt-3 p-2 " style="margin-left:45%;"
                                            name="adddriver" value="Add Driver" />
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