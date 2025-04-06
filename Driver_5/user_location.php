<?php
include('conection.php');

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Check if this is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract location data and user ID from the POST request
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $email = $_POST['email']; // Assuming 'user_id' is sent from the app

    $sql="select driver_id from truck_driver where driver_email='$email'";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);
    $userId=$row['driver_id'];   

    // Ensure that the received data is not empty
    if (isset($latitude) && isset($longitude) && isset($userId)) {
        // Escape variables to prevent SQL injection
        $latitude = mysqli_real_escape_string($conn, $latitude);
        $longitude = mysqli_real_escape_string($conn, $longitude);
        $userId = mysqli_real_escape_string($conn, $userId);

        // Check if the user ID already exists in the database
        $query = "SELECT COUNT(*) AS count FROM driver_locations WHERE driver_id = '$userId'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];

        if ($count == 0) {
            // If the user ID doesn't exist, insert a new location
            $insertQuery = "INSERT INTO driver_locations (driver_id, latitude, longitude) VALUES ('$userId', '$latitude', '$longitude')";
            if (mysqli_query($conn, $insertQuery)) {
                echo "Location data inserted successfully.";
            } else {
                echo "Error inserting location data: " . mysqli_error($conn);
            }
        } else {
            // If the user ID already exists, update the location
            $updateQuery = "UPDATE driver_locations SET latitude = '$latitude', longitude = '$longitude' WHERE driver_id = '$userId'";
            if (mysqli_query($conn, $updateQuery)) {
                echo "Location data updated successfully.";
            } else {
                echo "Error updating location data: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Incomplete or missing data.";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>
