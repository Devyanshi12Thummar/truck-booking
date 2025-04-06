<?php

include 'conection.php';

if (!$conn) {
    echo "Error in Database";
}

$user_email = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT * FROM truck_driver WHERE driver_email = '$user_email' AND driver_password = '$password';";
$result = mysqli_query($conn, $sql);

$response = array();

if (mysqli_num_rows($result) > 0) 
{
    $row = mysqli_fetch_assoc($result);
    $email = $row["driver_email"];
    $password = $row["driver_password"];
    $code = 'login_successfully';
    $response["code"] = $code;
    $response["email"] = $email;
    $response["password"] = $password;
} 
else 
{
    $code = "login_failed";
    $mess = "Invalid emailid and password";
    $response["code"] = $code;
    $response["message"] = $mess;
}

echo json_encode($response);
mysqli_close($conn);
?>
