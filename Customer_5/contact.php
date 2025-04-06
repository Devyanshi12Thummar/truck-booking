<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require('phpmailer/src/PHPMailerAutoload.php');
require('phpmailer/src/PHPMailer.php');
require('phpmailer/src/SMTP.php');
// error_reporting(0);
session_start();

require('conection.php');

$msg = "";
if (isset($_POST["submit"])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $phoneno = mysqli_real_escape_string($conn, $_POST['phoneno']);
  $subject = mysqli_real_escape_string($conn, $_POST['subject']);
  $message = mysqli_real_escape_string($conn, $_POST['message']);

  // die($email);

  $sql = mysqli_query($conn, "insert into contact(contact_name,contact_email,contact_phoneno,contact_subject,contact_message) values('$name','$email','$phoneno','$subject','$message')");
  $msg = "Thanks message";

  if ($sql == true) {
    $html = "<table><tr><td>Name</td><td>$name</td></tr><tr><td>Email</td><td>$email</td></tr><tr><td>phoneno</td><td>$phoneno</td></tr><tr><td>subject</td><td>$subject</td></tr><tr><td>message</td><td>$message</td></tr></table>";

   


    ob_start();

    // die("{$_SESSION["otp"]}");
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $email;      //Your Gmail Id
        $mail->Password   = 'vkdkrzqxshpnunvl';      //Your App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($email, 'Truck Booking System');
        $mail->addAddress('truckbooking2023@gmail.com', 'truck booking');     //Add a recipient

        $mail->addReplyTo($email, 'Truck Booking System');


        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = '';
        $mail->Body    = $html;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';

        // header("location:booking?id={$_GET["id"]}");
        ob_clean();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }





    // $mail = new PHPMailer(true);
    // $mail->isSMTP();
    // $mail->Host = "smtp.gmail.com";
    // $mail->Port = 587;
    // $mail->SMTPSecure = "tls";
    // // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    // $mail->SMTPAuth = true;
    // $mail->Username = "truckbooking2023@gmail.com";
    // $mail->Password = "senlfsrimmdrxogo";
    // $mail->SetFrom($email);
    // // die($email);
    // $mail->addAddress("truckbooking2023@gmail.com");
    // $mail->IsHTML(true);
    // $mail->Subject = "New Contact Us";
    // $mail->Body = $html;
    // $mail->SMTPOptions = array(
    //   'ssl' => array(
    //     'verify_peer' => false,
    //     'verify_peer_name' => false,
    //     'allow_self_signed' => false
    //   )
    // );
    // if ($mail->send()) {
    //   echo "Mail send";
    // } else {
    //   echo "Error occur";
    // }
    // echo $msg;
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
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.html">T B <span>T S</span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
        aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item "><a href="index.php" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
          <li class="nav-item"><a href="pricing.php	" class="nav-link">Pricing</a></li>
          <li class="nav-item"><a href="our_truck.php" class="nav-link">Our Truck</a></li>
          <li class="nav-item active"><a href="contact.php" class="nav-link">Contact</a></li>

        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->

  <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/a.jpg');"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
        <div class="col-md-9 ftco-animate pb-5">
          <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i
                  class="ion-ios-arrow-forward"></i></a></span> <span>Contact <i
                class="ion-ios-arrow-forward"></i></span></p>
          <h1 class="mb-3 bread">Contact us</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="ftco-section contact-section">
    <div class="container">
      <div class="row d-flex mb-5 contact-info justify-content-center">
        <div class="col-md-8">
          <div class="row mb-5">
            <div class="col-md-4 text-center py-4">
              <div class="icon">
                <span class="icon-map-o"></span>
              </div>
              <p><span>Address:</span> 198 West 21th Street, Suite 721 New York NY 10016</p>
            </div>
            <div class="col-md-4 text-center border-height py-4">
              <div class="icon">
                <span class="icon-mobile-phone"></span>
              </div>
              <p><span>Phone:</span> <a href="tel://1234567920">+ 1235 2355 98</a></p>
            </div>
            <div class="col-md-4 text-center py-4">
              <div class="icon">
                <span class="icon-envelope-o"></span>
              </div>
              <p><span>Email:</span> <a href="mailto:info@yoursite.com">info@yoursite.com</a></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row block-9 justify-content-center mb-5">
        <div class="col-md-8 mb-md-5">

          <h2 class="text-center">If you got any questions <br>please do not hesitate to send us a message</h2>
          <form action="" method="post" class="bg-light p-5 contact-form" id="frmContactus">
            <div class="form-group">
              <input type="text" name="name" class="form-control" placeholder="Your Name">
            </div>
            <div class="form-group">
              <input type="text" name="email" class="form-control" placeholder="Your Email">
            </div>
            <div class="form-group">
              <input type="text" name="phoneno" class="form-control" placeholder="contact no">
            </div>
            <div class="form-group">
              <input type="text" name="subject" class="form-control" placeholder="Subject">
            </div>
            <div class="form-group">
              <textarea name="message" id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
            </div>
            <div class="form-group">
              <input type="submit" name="submit" value="Send Message" class="btn btn-primary py-3 px-5">
              <span style="color:red"></span>
            </div>
          </form>

        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="bg-white"> <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14161.90517571498!2d72.82357193955076!3d21.2048829!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04ef9dc913593%3A0x96106052132786c3!2sSurat!5e1!3m2!1sen!2sus!4v1676086506900!5m2!1sen!2sus"
              width="1000" height="600" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="ftco-footer ftco-bg-dark ftco-section">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">About Autoroad</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the
              blind texts.</p>
            <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
              <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md">
          <div class="ftco-footer-widget mb-4 ml-md-5">
            <h2 class="ftco-heading-2">Information</h2>
            <ul class="list-unstyled">
              <li><a href="#" class="py-2 d-block">About</a></li>
              <li><a href="#" class="py-2 d-block">Services</a></li>
              <li><a href="#" class="py-2 d-block">Term and Conditions</a></li>
              <li><a href="#" class="py-2 d-block">Best Price Guarantee</a></li>
              <li><a href="#" class="py-2 d-block">Privacy &amp; Cookies Policy</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">Customer Support</h2>
            <ul class="list-unstyled">
              <li><a href="#" class="py-2 d-block">FAQ</a></li>
              <li><a href="#" class="py-2 d-block">Payment Option</a></li>
              <li><a href="#" class="py-2 d-block">Booking Tips</a></li>
              <li><a href="#" class="py-2 d-block">How it works</a></li>
              <li><a href="#" class="py-2 d-block">Contact Us</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">Have a Questions?</h2>
            <div class="block-23 mb-3">
              <ul>
                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San
                    Francisco, California, USA</span></li>
                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                <li><a href="#"><span class="icon icon-envelope"></span><span
                      class="text">info@yourdomain.com</span></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">

          <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;
            <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with
            <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com"
              target="_blank">Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          </p>
        </div>
      </div>
    </div>
  </footer>

  <script>
    jQuery('#frmContactus').on('submit', function (e) {
      jQuery('#msg').html('');
      jQuery('#submit').html('Please wait');
      jQuery('#submit').attr('disabled', true);
      jQuery.ajax({
        url: 'contact.php',
        type: 'post',
        data: jQuery('#frmContactus').serialize(),
        success: function (result) {
          jQuery('#msg').html(result);
          jQuery('#submit').html('Submit');
          jQuery('#submit').attr('disabled', false);
          jQuery('#frmContactus')[0].reset();
        }
      });
      e.preventDefault();
    });
  </script>



  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
        stroke="#F96D00" />
    </svg></div>


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