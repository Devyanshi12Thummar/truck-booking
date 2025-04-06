<?php
include "connection.php";

if (isset($_GET['year']) && isset($_GET['month'])) {
    $year = $_GET['year'];
    $month = $_GET['month'];
}   

$sqltotal = "SELECT COUNT(DISTINCT pickup_address) as total from truck_booking where MONTH(booking_date)=$month and YEAR(booking_date)=$year";
$resulttotal = mysqli_query($conn, $sqltotal);
$rowtotal = mysqli_fetch_assoc($resulttotal);
$total = $rowtotal["total"];

$sqlcityyear = "SELECT COUNT(*) as count ,pickup_address from truck_booking WHERE MONTH(booking_date)= $month  and YEAR(booking_date)=$year  GROUP BY pickup_address";
$sqlcity = mysqli_query($conn, $sqlcityyear);

$data = array();
while ($rowcity = mysqli_fetch_assoc($sqlcity)) {
    $pickup_address = $rowcity["pickup_address"];
    $percentage = $rowcity["count"] / $total * 100;
    $data[] = [$pickup_address, $percentage];
}

header('Content-Type: application/json');
echo json_encode($data);
?>
