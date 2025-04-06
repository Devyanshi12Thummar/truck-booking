<?php
include 'conection.php';
session_start();


$custid = $_SESSION['user_id'];

$sql = "SELECT * FROM user_master WHERE user_id = ?";
$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $custid);


$stmt->execute();


$result = $stmt->get_result();


$userData = $result->fetch_assoc();


$stmt->close();




$name = $userData['user_fullname'];
$password = $userData['user_password'];
// $email = $userData['user_email'];

$nameParts = explode(" ", $name);

$firstName = $nameParts[0];
$lastName = count($nameParts) > 1 ? $nameParts[count($nameParts) - 1] : "";



$secondarycontact='';

if (isset($_POST['update'])) {
    // Get user inputs from the form
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $userfullname = $firstname . " " . $lastname;
    $primarycontact = $_POST['primarycontact'];
    $secondarycontact = $_POST['secondarycontact'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $ppassword = md5($_POST['password']); // Using MD5 for demonstration, but not recommended
    $conpass = md5($_POST['conpass']);
    $oldpass = md5($_POST['oldpass']);

    // if ($firstname == $firstName  ) {
    if ($oldpass == $password) {

        if ($oldpass != $ppassword) {

            if ($ppassword == $conpass) {

                $query = "UPDATE user_master SET user_fullname = '$userfullname', user_contactno_primary = '$primarycontact', user_contactno_secoundary = '$secondarycontact', user_city = '$city', user_pincode ='$pincode', user_password = '$ppassword' WHERE user_id = $custid";
                $res = mysqli_query($conn, $query);
                if ($result) {
                    echo "<script>alert('User information and password updated successfully.')</script>";
                    header('location: profile.php');
                } else {
                    echo "<script>alert('Error updating user information: " . mysqli_error($conn) . "')</script>";
                }
            } else {
                echo "<script>alert('Password and confirm password do not match.')</script>";
            }
        } else {
            echo "<script>alert('New password is the same as the old password.')</script>";
        }
    } else {
        echo "<script>alert('Old password is incorrect.')</script>";
    }
}
// }
$conn->close();

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
                    <li class="nav-item"><a href="Booking.php" class="nav-link">Booking</a></li>
                    <li class="nav-item"><a href="our_truck.php" class="nav-link">Our Truck</a></li>
                    <li class="nav-item"><a href="booking_history.php" class="nav-link">Booking History</a></li>
                    <li class="nav-item active"><a href="profile.php" class="nav-link">My Profile</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>

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
                        <h2 style="text-align:center">UPDATE</h2>
                        <div class="form-group">
                            <label for="username">Email</label>
                            <input type="text" class="form-control" value="<?php echo $userData['user_email']; ?>"
                                placeholder="your-email@gmail.com" name="email" id="email" disabled>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group last mb-3">
                                    <label for="firstname">First Name<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="firstname"
                                        value="<?php echo $firstName; ?>"
                                        onkeypress="return event.charCode >= 65 && event.charCode <= 123"
                                        oninput="convertToTitleCase(this)" maxlength=""
                                        placeholder="Enter Your First Name" id="firstname">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group last mb-3">
                                    <label for="lastname">Last Name<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="lastname"
                                        value="<?php echo $lastName; ?>"
                                        onkeypress="return event.charCode >= 65 && event.charCode <= 123"
                                        oninput="convertToTitleCase(this)" maxlength=""
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
                                    <label for="username">Primary Contact Number<span
                                            style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="primarycontact" maxlength="10"
                                        value="<?php echo $userData['user_contactno_primary']; ?>"
                                        pattern="[6789]{1}[0-9]{9}"
                                        onkeypress="return event.charCode >= 47 && event.charCode <= 57"
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
                                        value="<?php echo $userData['user_contactno_secoundary']; ?>"
                                        pattern="[6789]{1}[0-9]{9}"
                                        onkeypress="return event.charCode >= 47 && event.charCode <= 57"
                                        placeholder="Enter your Contact Number" id="secondarycontact">
                                    <span id="secondarycon" style="color: red;"></span>
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
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">City<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="city" maxlength=""
                                        value="<?php echo $userData['user_city']; ?>"
                                        onkeypress="return event.charCode >= 65 && event.charCode <= 123"
                                        placeholder="Enter your city" id="city">
                                </div>
                                <div class="col-lg-6">
                                    <label for="pin">Pincode<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="pincode" maxlength="6"
                                        onkeypress="return event.charCode >= 47 && event.charCode <= 57"
                                        value="<?php echo $userData['user_pincode']; ?>" placeholder="Pincode" id="pin">
                                </div>
                            </div>
                        </div>
                        <div class="form-gorup">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group last mb-3">
                                        <label for="password">Old Password<span style="color:red;">*</span></label>
                                        <input type="password" class="form-control" name="oldpass" maxlength="8"
                                            placeholder="Your Password" id="passwordInput">
                                        <span id="passwordError"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group last mb-3">
                                        <label for="password"> Password<span style="color:red;">*</span></label>
                                        <input type="password" class="form-control" name="password" maxlength="8"
                                            placeholder="Your Password" id="password">
                                        <!-- <span id="passwordError"></span> -->

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group last mb-3">
                                        <label for="password">Confirm Password<span style="color:red;">*</span></label>
                                        <input type="password" class="form-control" name="conpass" maxlength="8"
                                            placeholder="confirm password" id="confirmpasswordInput">
                                    </div>
                                </div>
                            </div>
                            <div class="message" id="lengthMsg"></div>
                            <div class="message" id="alphaMsg"></div>
                            <div class="message" id="specialMsg"></div>
                            <div class="message" id="numberMsg"></div>
                            <script>
                                const passwordInput = document.getElementById('password');
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
                            <input type="submit" name="update" style="background-color:black;" value="Update"
                                class="btn btn-block py-2 btn-primary"><br>
                            <!-- <a href="login.php"><span class="text-center  d-block">Already Member?</span></a> -->
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

</body>

</html>