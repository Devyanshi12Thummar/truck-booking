<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    #customers {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 50%;
    }

    #customers td,
    #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    #customers tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    #customers tr:hover {
      background-color: #ddd;
    }

    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: black;
      color: white;
    }
  </style>
</head>

<body>

<?php
include "connection.php";

  $q = $_GET['q'];
// echo "okokokoko";
//   die("".$q);


  $sql = "SELECT  pickup_address, booking_date,truck_detials.truck_name,truck_booking.booking_id FROM truck_booking 
INNER JOIN truck_detials 
ON truck_booking.truck_id = truck_detials.truck_id 
WHERE pickup_address = '" . $q . "' and Year(booking_date)= YEAR(NOW()) ";
  $result = $conn->query($sql);

  echo "<table id='customers'>
<tr>City Wise Yearly Reports</tr>
<br><br>
<tr>
<th>City</th>
<th>Date</th>
<th>Truck Name</th>
</tr>";
  while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['pickup_address'] . "</td>";
    echo "<td>" . $row['booking_date'] . "</td>";
    echo "<td>" . $row['truck_name'] . "</td>";
    echo "</tr>";
  }

  echo "</table>";






  // $q = mysqli_real_escape_string($conn, $_GET['q']); // Sanitize user input
  
  $sqlmon = "SELECT pickup_address, MONTHNAME(booking_date) AS month_name, booking_date, truck_detials.truck_name, truck_booking.booking_id
           FROM truck_booking 
           INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id 
           WHERE pickup_address = '$q' AND MONTHNAME(booking_date) = MONTHNAME(NOW())";

  $resultmon = $conn->query($sqlmon);

  echo "<table id='customers'>
<br>
<tr>
<tr>City Wise Monthly Reports</tr>
<br><br>
<tr>
<th>City</th>
<th>Month Name</th>
<th>Truck Name</th>
</tr>";
  while ($rowmon = $resultmon->fetch_assoc()) {
    echo "<tr>";
    // echo "<td>" . $rowmon['booking_id'] . "</td>";
    echo "<td>" . $rowmon['pickup_address'] . "</td>";
    echo "<td>" . $rowmon['month_name'] . "</td>";
    echo "<td>" . $rowmon['truck_name'] . "</td>";
    echo "</tr>";
  }
  echo "</table>";








  $sqlwek = "SELECT pickup_address, WEEK(booking_date) AS week, booking_date, truck_detials.truck_name, truck_booking.booking_id 
           FROM truck_booking 
           INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id 
           WHERE pickup_address = 'barodoli' AND WEEK(booking_date) = 43";

  $resultwek = $conn->query($sqlwek);

  echo "<table id='customers'>
<br>
<tr>
<tr>City Wise Weekly Reports</tr>
<br><br>
<tr>
<th>City</th>
<th>Week</th>
<th>Truck Name</th>
</tr>";
  while ($rowwek = $resultwek->fetch_assoc()) {
    echo "<tr>";
    // echo "<td>" . $rowwek['booking_id'] . "</td>";
    echo "<td>" . $rowwek['pickup_address'] . "</td>";
    echo "<td>" . $rowwek['week'] . "</td>";
    echo "<td>" . $rowwek['truck_name'] . "</td>";
    echo "</tr>";
  }
  echo "</table>";














  mysqli_close($conn);
  ?>

</body>

</html>