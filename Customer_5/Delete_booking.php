<?php
require('conection.php');
$id = $_GET['id'];
$sql = "DELETE FROM truck_booking WHERE booking_id ='$id'";
$result = mysqli_query($conn, $sql);

if ($result) 
{
    header("location: booking_history.php");
}
else
{
    echo "Failed: " . mysqli_error($conn);
}
?>