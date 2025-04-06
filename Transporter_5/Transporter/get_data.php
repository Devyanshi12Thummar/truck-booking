<?php
include "connection.php";

if (isset($_GET['year'])) {
$year = $_GET['year'];
}
else
{
    $year=2023;
}



$sqltotal = "SELECT COUNT(DISTINCT pickup_address) as total from truck_booking  where YEAR(booking_date)=$year";
$resulttotal = mysqli_query($conn, $sqltotal);
$rowtotal = mysqli_fetch_assoc($resulttotal);
$total = $rowtotal["total"];

$sqlcityyear = "SELECT COUNT(DISTINCT pickup_address) as count ,pickup_address from truck_booking where YEAR(booking_date)=$year GROUP BY pickup_address";
$sqlcity = mysqli_query($conn, $sqlcityyear);

$data = array();
while ($rowcity = mysqli_fetch_assoc($sqlcity)) {
    $pickup_address = $rowcity["pickup_address"];
    $percentage = $rowcity["count"] / $total * 100;
    $data[] = [$pickup_address, $percentage];
}

header('Content-Type: application/json');
echo json_encode($data);
// }


?>
