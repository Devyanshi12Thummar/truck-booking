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
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color:black;
  color: white;
}
</style>
</head>





<?php
include "connection.php";
$year=$_GET['param1'];
$month=$_GET['param2'];
$week=$_GET['param3'];


$sqlmon = "SELECT pickup_address, MONTHNAME(booking_date) AS month_name, booking_date, truck_detials.truck_name, truck_booking.booking_id
FROM truck_booking 
INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id 
WHERE YEAR(booking_date) = '$year' AND MONTH(booking_date) = $month AND WEEK(booking_date)=$week";

$resultmon = $conn->query($sqlmon);

echo "<table id='customers'>
<br>
<tr>
<tr>City Wise Monthly Reports</tr>
<br><br>
<tr>
<th>City</th>
<th>Booking Date</th>
<th>Truck Name</th>
</tr>";
while ($rowmon = $resultmon->fetch_assoc()) {
echo "<tr>";
// echo "<td>" . $rowmon['booking_id'] . "</td>";
echo "<td>" . $rowmon['pickup_address'] . "</td>";
echo "<td>" . $rowmon['booking_date'] . "</td>";
echo "<td>" . $rowmon['truck_name'] . "</td>";
echo "</tr>";
}
echo "</table>";


?>