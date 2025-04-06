<?php
session_start();
include "conection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// $_SESSION['cust_id'] = $_GET['custid'];
if (isset($_POST["submit"])) {
    // die($_SESSION["otp"]);
    $userotp = $_POST["1"] . $_POST["2"] . $_POST["3"] . $_POST["4"] . $_POST["5"] . $_POST["6"];
    if ("{$_SESSION["forgot_otp"]}" === $userotp) {

        if ("{$_SESSION["old_password"]}" == "{$_SESSION["new_password"]}") {
            if ("{$_SESSION["email"]}" != 0) {
                $link = "update user_master set user_password='{$_SESSION["new_password"]}' where user_email='{$_SESSION["email"]}'";
                $ok = mysqli_query($conn, $link);
                header("Location:login.php");
            } else {
                echo "error";
            }
            // header("Location:forget.php");
        }
    } else {
        echo "<script>alert('please enter correct otp');</script>";
    }
} else {
    ob_start();


    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'truckbooking2023@gmail.com'; //Your Gmail Id
        $mail->Password = 'senlfsrimmdrxogo'; //Your App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
        $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('truckbooking2023@gmail.com', 'rushil');
        $mail->addAddress($_SESSION['f_email'], 'truck booking'); //Add a recipient

        $mail->addReplyTo('truckbooking2023@gmail.com', 'rushil');


        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Forgot Password OTP';
        $mail->Body = $_SESSION["forgot_otp"];
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';

        // header("location:booking?id={$_GET["id"]}");
        ob_clean();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="./images/fj.png" type="image/gif" sizes="16x16">
    <title>TBTS</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background: #eee;
        }

        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: 1rem;
        }

        .img-thumbnail {
            padding: .25rem;
            background-color: #ecf2f5;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            max-width: 100%;
            height: auto;
        }

        .avatar-lg {
            height: 150px;
            width: 150px;
        }
    </style>
</head>

<body>
    <br><br>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-lg-5 col-md-7 mx-auto my-auto">
                <div class="card">
                    <div class="card-body px-lg-5 py-lg-5 text-center">
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" class="rounded-circle avatar-lg img-thumbnail mb-4" alt="profile-image">
                        <h6 class="text-warning">OTP send in Your email</h6>
                        <p class="mb-4">Enter 6-digits code from your athenticatior app.</p>
                        <form method="post">
                            <div class="row mb-4">
                                <div class="col-lg-2 col-md-2 col-2 ps-0 ps-md-2">
                                    <input type="text" class="form-control text-lg text-center" placeholder="_" name="1" minlength="1" maxlength="1" aria-label="2fa">
                                </div>
                                <div class="col-lg-2 col-md-2 col-2 ps-0 ps-md-2">
                                    <input type="text" class="form-control text-lg text-center" placeholder="_" name="2" minlength="1" maxlength="1" aria-label="2fa">
                                </div>
                                <div class="col-lg-2 col-md-2 col-2 ps-0 ps-md-2">
                                    <input type="text" class="form-control text-lg text-center" placeholder="_" name="3" minlength="1" maxlength="1" aria-label="2fa">
                                </div>
                                <div class="col-lg-2 col-md-2 col-2 pe-0 pe-md-2">
                                    <input type="text" class="form-control text-lg text-center" placeholder="_" name="4" minlength="1" maxlength="1" aria-label="2fa">
                                </div>
                                <div class="col-lg-2 col-md-2 col-2 pe-0 pe-md-2">
                                    <input type="text" class="form-control text-lg text-center" placeholder="_" name="5" minlength="1" maxlength="1" aria-label="2fa">
                                </div>
                                <div class="col-lg-2 col-md-2 col-2 pe-0 pe-md-2">
                                    <input type="text" class="form-control text-lg text-center" placeholder="_" name="6" minlength="1" maxlength="1" aria-label="2fa">
                                </div>
                            </div>
                            <div class="text-center">
                                <input type="submit" name="submit" class="btn bg-warning btn-lg my-4">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>