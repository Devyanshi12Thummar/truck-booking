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
<body>
    
<?php



error_reporting(0);

$hostname="localhost";
$username="root";
$password="";
$dbname="truckbooking";

$conn= new mysqli($hostname,$username,$password,$dbname);

if($conn->connect_errno){
    die("connection failed");
}

$q = intval($_GET['q']);
// $q = "surat";
echo $q;


$sql="SELECT  pickup_address, booking_date,truck_detials.truck_name,truck_booking.booking_id FROM truck_booking 
INNER JOIN truck_detials 
ON truck_booking.truck_id = truck_detials.truck_id 
WHERE pickup_address = '".$q."' ";
$result=$conn->query($sql);

echo "<table id='customers'>
<tr>
<th>Booking Id</th>
<th>City</th>
<th>Date</th>
<th>Truck Name</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['booking_id'] . "</td>";
  echo "<td>" . $row['pickup_address'] . "</td>";
  echo "<td>" . $row['booking_date'] . "</td>";
  echo "<td>" . $row['truck_name'] . "</td>";
  echo "</tr>";
}


echo "</table>";
mysqli_close($conn);
?>

</body>
</html>