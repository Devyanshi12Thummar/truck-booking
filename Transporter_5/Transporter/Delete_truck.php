<?php
require 'connection.php';
$id = $_GET['id'];
$sql = "DELETE FROM `truck_detials` WHERE truck_id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("location: View_Truck.php?msg=Record Delete Successfuly");
} else {
    echo "Failed: " . mysqli_error($conn);
}
?>