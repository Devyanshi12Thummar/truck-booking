
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "truckbooking";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    echo "Error in Database";

}
?>