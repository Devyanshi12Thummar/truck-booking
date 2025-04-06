<?php
session_set_cookie_params(3600);
session_start();

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once('conection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["email"]) && isset($_POST["booking_id"])) {
        $email = $_POST["email"];
        $bookingid = $_POST["booking_id"];
        $sql = "SELECT * FROM truck_driver WHERE driver_email='$email'";
        $res = mysqli_query($conn, $sql);

        // if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $driver_id = $row["driver_id"];
            $_SESSION["driver_id"] = $driver_id;

            $bookibgupdate = "UPDATE truck_booking SET assign_driver_status='1' where booking_id=$bookingid";
            $result=mysqli_query($conn,$bookibgupdate);
                // $sqlDriverOrder = "INSERT INTO assign_driver (order_id, driver_id, booking_id) VALUES (NULL, '$driver_id', '$bookingid');";
                // $result = mysqli_query($conn, $sqlDriverOrder);

                if ($result) {
                    $response["code"] = "order_accepted";
                } else {
                    $response["code"] = "order_not_accepted";
                }
            
        // } else {
        //     $response["code"] = "order_not_accepted";
        // }

        echo json_encode($response);
    }
}
?>
