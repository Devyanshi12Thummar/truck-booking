<!-- 
<!DOCTYPE html>
<html>
  <head>
    <title>Booking Successful</title>
    <style>
      body {
        background-color: #f8f8f8;
        font-family: Arial, sans-serif;
      }
      .success {
        text-align: center;
        margin-top: 100px;
      }
      .success h1 {
        color: green;
        font-size: 4em;
        margin-bottom: 20px;
      }
      h1:hover {
        color: black;
      }
      .success p {
        color: gray;
        font-size: 1.5em;
        margin-bottom: 50px;
      }
      .button {
        display: inline-block;
        padding: 10px 20px;
        background-color: green;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 1.2em;
        transition: background-color 0.3s ease;
      }
      .button:hover {
        background-color: black;
      }
    </style>
  </head>
  <body>
    <div class="success">
      <h1>Booking Successful!</h1>
      <p>Thank you for Truck Booking. We have received your booking request and will confirm it shortly.</p>
      <a href="../booking_history.php" class="button">Go back</a>
    </div>
  </body>
</html> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: 0 auto;
        }
        h1 {
            color: #2ecc71;
        }
        .icon {
            font-size: 60px;
            color: #2ecc71;
        }
        p {
            font-size: 18px;
        }
        a {
            text-decoration: none;
            color: #3498db;
        }
    </style>
</head>
<body>
  <br><br><br><br>
    <div class="container">
        <div class="icon">&#10004;</div>
        <h1>Payment Successful</h1>
        <p>Your payment was successfully processed.</p>
        <!-- <p>Thank you for your Truck Booked!</p> -->
           <p>For any questions or concerns, please <a href="../contact.php">contact support</a>.</p>
  
        <p><a href="../booking_history.php">Done</a></p>
        <button type="button" class="btn btn-warning">Warning</button>
    </div>
</body>
</html>
