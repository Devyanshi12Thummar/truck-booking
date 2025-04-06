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





$hostname="localhost";
$username="root";
$password="";
$dbname="truckbooking";

$conn= new mysqli($hostname,$username,$password,$dbname);

if($conn->connect_errno){
    die("connection failed");
}

$q = intval($_GET['q']);

$sql="SELECT pickup_address,MONTHNAME(booking_date), COUNT(DISTINCT booking_id) AS truck_booking_count
FROM truck_booking
WHERE MONTHNAME(booking_date) = $q
GROUP BY pickup_address
ORDER BY truck_booking_count DESC
LIMIT 1";

$result=$conn->query($sql);

echo "<table id='customers'>
<tr>
<th>City Name</th>
<th>Month</th>
<th>No of Booking</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['pickup_address'] . "</td>";
  echo "<td>" .$row['MONTHNAME(booking_date)'] . "</td>";
  echo "<td>" .$row['truck_booking_count'] . "</td>";
  echo "</tr>";
}


echo "</table>";
mysqli_close($conn);
?>

</body>
</html>