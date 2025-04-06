<?php
session_start();
include('conection.php');
$uid = $_SESSION["UID"];
$time = time() + 10;
$res = mysqli_query($conn, "update truck_driver set last_login = $time where driver_id = $uid");
?>
