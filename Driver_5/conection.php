
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "truckbooking";

// Create a database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Error in Database: " . mysqli_connect_error());
}
?>
