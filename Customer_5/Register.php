<?php
session_start();

include 'conection.php';
error_reporting(0);

$_SESSION["tid"] = $_GET["id"];

if (isset($_SESSION['cust_id'] ) && isset($_SESSION["tid"])) {
  header("location:booking.php");
}


if (isset($_POST['register'])) {

  $Usertype = 0;
  $Firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
  $Lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
  $Fullname = $Firstname . " " . $Lastname;
  $Email = mysqli_real_escape_string($conn, $_POST['email']);
  $Primarycontact = mysqli_real_escape_string($conn, $_POST['primarycontact']);
  $Secondarycontact = mysqli_real_escape_string($conn, $_POST['secondarycontact']);
  $Address = mysqli_real_escape_string($conn, $_POST['address']);
  $City = mysqli_real_escape_string($conn, $_POST['city']);
  $Pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
  $Gender = mysqli_real_escape_string($conn, $_POST['gender']);
  $PasswordRegister = mysqli_real_escape_string($conn, md5($_POST['password']));
  $ConformPasswordRegister = mysqli_real_escape_string($conn, md5($_POST['conpass']));
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
  } else if (empty($Gender)) {
    echo "<script>alert('Please Select Your Gender');</script>";
  } else if (empty($Address)) {
    echo "<script>alert('Please Enter Your Address');</script>";
  } else if (empty($City)) {
    echo "<script>alert('Please Enter Your City');</script>";
  } else if (empty($Pincode)) {
    echo "<script>alert('Please Enter Your Pincode');</script>";
  } else {
    // echo "<script>alert('Registration SuccessFull');</script>";
    // $hashedPassword = password_hash($PasswordRegister, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM user_master WHERE user_email = ?") or die('Query preparation failed.');

    $stmt->bind_param("s", $Email);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      echo '<script>alert("User already exists")</script>';
    } else {
      $stmt = $conn->prepare("INSERT INTO user_master (user_type, user_fullname, user_email, user_contactno_primary, user_contactno_secoundary, user_address, user_city, user_pincode, user_gender, user_password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

      // $hashedPassword = password_hash($PasswordRegister, PASSWORD_DEFAULT);

      $stmt->bind_param("isssssssss", $Usertype, $Fullname, $Email, $Primarycontact, $Secondarycontact, $Address, $City, $Pincode, $Gender, $PasswordRegister);
      $stmt->execute();

      $stmt->close();

      echo '<script>alert("Registered successfully!")</script>';


      $message = "TBTS Register Successfully";
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

      header("Location: login.php");
    }
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <title>TBTS</title>
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


  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/icomoon.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <style>
    .message {
      font-size: 14px;
      margin-top: 5px;
    }

    .valid {
      color: green;
    }

    .invalid {
      color: red;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.php">T B <span>T S</span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
        aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item "><a href="index.php" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
          <li class="nav-item active"><a href="Register.php" class="nav-link">Register</a></li>
          <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->

  <div class="hero-wrap" style="background-image: url('images/a.jpg'); width: 100%;
  height: 150%;" data-stellar-background-ratio="0.1">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text justify-content-start align-items-center">
        <div class="col-lg-8 col-md-5 mt-12 mt-md-5"><br>
          <form method="post" class="request-form ftco-animate">
            <h2 style="text-align:center">Register</h2>
            <div class="form-group">
              <label for="username">Email<span style="color:red;">*</span></label>
              <input type="text" class="form-control" placeholder="your-email@gmail.com" name="email" id="email">
              <span id="emailError" style="color: red;"></span>
            </div>
            <script>
              const emailInput = document.getElementById('email');
              const emailError = document.getElementById('emailError');

              emailInput.addEventListener('keyup', function () {
                const emailValue = emailInput.value.trim();
                const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/i;

                if (emailValue === '') {
                  emailError.textContent = '';
                } else if (!emailRegex.test(emailValue)) {
                  emailError.textContent = 'Enter corrct Email id';
                } else {
                  emailError.textContent = '';
                }
              });
            </script>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group last mb-3">
                  <label for="firstname">First Name<span style="color:red;">*</span></label>
                  <input type="text" class="form-control" name="firstname"
                    onkeypress="return event.charCode >= 65 && event.charCode <= 123" maxlength=""
                    placeholder="Enter Your First Name" id="firstname">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group last mb-3">
                  <label for="lastname">Last Name<span style="color:red;">*</span></label>
                  <input type="text" class="form-control" name="lastname"
                    onkeypress="return event.charCode >= 65 && event.charCode <= 123" maxlength=""
                    placeholder="Enter Your Last Name" id="lastname">
                </div>
              </div>
            </div>
            <script>
              const fname = document.getElementById('firstname');

              fname.addEventListener('input', function () {
                const nameValue = fname.value;

                if (nameValue.length > 0) {
                  const capitalized = nameValue.charAt(0).toUpperCase() + nameValue.slice(1);
                  fname.value = capitalized;
                }
              });
              const lname = document.getElementById('lastname');

              lname.addEventListener('input', function () {
                const nameValue = lname.value;

                if (nameValue.length > 0) {
                  const capitalized = nameValue.charAt(0).toUpperCase() + nameValue.slice(1);
                  lname.value = capitalized;
                }
              });
            </script>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6">
                  <label for="username">Primary Contact Number<span style="color:red;">*</span></label>
                  <input type="text" class="form-control" name="primarycontact" maxlength="10"
                    pattern="[6789]{1}[0-9]{9}" onkeypress="return event.charCode >= 47 && event.charCode <= 57"
                    placeholder="Enter your Contact Number" id="contact">
                  <span id="primarycon" style="color: red;"></span>
                </div>
                <script>
                  const primarycontact = document.getElementById('contact');
                  const errorprimary = document.getElementById('primarycon');

                  primarycontact.addEventListener('keyup', function () {
                    const primaryvalue = primarycontact.value.trim();
                    const primaryregex = /^[6-9]\d{9}$/;

                    if (primaryvalue === '') {
                      errorprimary.textContent = '';
                    } else if (!primaryregex.test(primaryvalue)) {
                      errorprimary.textContent = 'Enter corrct Contect Number';
                    } else {
                      errorprimary.textContent = '';
                    }
                  });
                </script>
                <div class="col-lg-6">
                  <label for="username">Secondary Contact Number</label>
                  <input type="text" class="form-control" name="secondarycontact" maxlength="10"
                    pattern="[6789]{1}[0-9]{9}" onkeypress="return event.charCode >= 47 && event.charCode <= 57"
                    placeholder="Enter your Contact Number" id="secondarycontact">
                  <span id="secondarycon" style="color: red;"></span>
                </div>
              </div>
            </div>
            <script>
              const sec = document.getElementById('secondarycontact');
              const err = document.getElementById('secondarycon');

              sec.addEventListener('keyup', function () {
                const secv = sec.value.trim();
                const rag = /^[6-9]\d{9}$/;

                if (secv === '') {
                  err.textContent = '';
                } else if (!rag.test(secv)) {
                  err.textContent = 'Enter corrct Contect Number';
                } else {
                  err.textContent = '';
                }
              });
            </script>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6">
                  <label for="gender">Gender<span style="color:red;">*</span></label><br>
                  <input type="radio" name="gender" value="m"> Male
                  <input type="radio" name="gender" value="f"> Female
                </div>

                <div class="col-sm-6">
                  <label for="add">Address<span style="color:red;">*</span></label>
                  <input type="text" class="form-control" name="address" maxlength="" placeholder="Enter your Address"
                    id="add">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6">
                  <label for="">City<span style="color:red;">*</span></label>
                  <input type="text" class="form-control" name="city" maxlength="8" placeholder="Enter your city"
                    id="city" onkeypress="return event.charCode >= 65 && event.charCode <= 123">
                </div>
                <div class="col-lg-6">
                  <label for="pin">Pincode<span style="color:red;">*</span></label>
                  <input type="text" class="form-control" name="pincode" maxlength="" placeholder="Pincode" id="pin"
                    onkeypress="return event.charCode >= 47 && event.charCode <= 57">
                </div>
              </div>
            </div>
            <div class="form-gorup">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group last mb-3">
                    <label for="password">Password<span style="color:red;">*</span></label>
                    <input type="password" class="form-control" name="password" maxlength="8"
                      placeholder="Your Password" id="passwordInput">
                    <div class="message" id="lengthMsg"></div>
                    <div class="message" id="alphaMsg"></div>
                    <div class="message" id="specialMsg"></div>
                    <div class="message" id="numberMsg"></div>
                  </div>
                </div>
                <script>
                  const passwordInput = document.getElementById('passwordInput');
                  const lengthMsg = document.getElementById('lengthMsg');
                  const alphaMsg = document.getElementById('alphaMsg');
                  const specialMsg = document.getElementById('specialMsg');
                  const numberMsg = document.getElementById('numberMsg');

                  passwordInput.addEventListener('keyup', function () {
                    const password = passwordInput.value;
                    let valid = true;

                    lengthMsg.textContent = (password.length >= 6 && password.length <= 8) ? 'Password length is valid.' : 'Password length should be between 6 and 8 characters.';
                    lengthMsg.className = (password.length >= 6 && password.length <= 8) ? 'valid' : 'invalid';
                    valid = valid && (password.length >= 6 && password.length <= 8);

                    alphaMsg.textContent = /[A-Za-z]/.test(password) ? 'Contains alphabets.' : 'Should contain alphabets.';
                    alphaMsg.className = /[A-Za-z]/.test(password) ? 'valid' : 'invalid';
                    valid = valid && /[A-Za-z]/.test(password);

                    specialMsg.textContent = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(password) ? 'Contains special symbols.' : 'Should contain special symbols.';
                    specialMsg.className = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(password) ? 'valid' : 'invalid';
                    valid = valid && /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(password);

                    numberMsg.textContent = /\d/.test(password) ? 'Contains numbers.' : 'Should contain numbers.';
                    numberMsg.className = /\d/.test(password) ? 'valid' : 'invalid';
                    valid = valid && /\d/.test(password);

                    if (valid) {
                      passwordInput.style.borderColor = 'green';
                    } else {
                      passwordInput.style.borderColor = 'red';
                    }
                  });
                </script>
                <div class="col-lg-6">
                  <div class="form-group last mb-3">
                    <label for="password">Confirm Password<span style="color:red;">*</span></label>
                    <input type="password" class="form-control" name="conpass" maxlength="8"
                      placeholder="confirm password" id="confirmpasswordInput">
                  </div>
                </div>
              </div>
              <input type="submit" name="register" style="background-color:black;" value="Sign Up"
                class="btn btn-block py-2 btn-primary"><br>
              <a href="login.php"><span class="text-center  d-block">Already Member?</span></a>
          </form>
        </div>
      </div>
    </div>
  </div>
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
  <script>

    function isPasswordValid(password) {
      const regex = /^(?=.*[A-Z])(?=.*[!@#$%^&])(?=.*[0-9]).{6, 8}$/;
      return regex.test(password);
    }

    function validatePassword() {
      const passwordInput = document.getElementById("passwordInput");
      const confirmPasswordInput = document.getElementById("confirmpasswordInput");
      const passwordError = document.getElementById("passwordError");

      const password = passwordInput.value;
      const confirmPassword = confirmPasswordInput.value;

      if (isPasswordValid(password)) {
        passwordError.textContent = "";
        passwordInput.style.color = "black";
      } else {
        passwordError.textContent = "Password is invalid!(eg:Ami@23)";
        passwordError.style.color = "red";
      }
      if (isPasswordValid(password) == true) {
        if (password == confirmPassword) {
          passwordError.textContent = "";
          passwordInput.style.color = "black";
        } else {
          passwordError.textContent = "Password are not Match";
          passwordError.style.color = "red";
        }
      }
    }

    const password = document.getElementById("passwordInput");
    const confirmPasswordInput = document.getElementById("confirmpasswordInput");

    password.addEventListener("input", validatePassword);
    confirmPasswordInput.addEventListener("input", validatePassword);
  </script>
</body>

</html>