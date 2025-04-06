<?php
include "connection.php";

// Function to fetch updated user locations from the database
function getUpdatedLocations() {
    global $conn;
    $sql = "SELECT * FROM user_locations";
    $result = mysqli_query($conn, $sql);

    $updatedLocations = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $updatedLocations[] = $row;
    }

    return $updatedLocations;
}

// Fetch and return updated user locations as JSON
$updatedLocations = getUpdatedLocations();
echo json_encode($updatedLocations);
?>
