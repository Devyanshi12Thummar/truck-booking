<?php
session_set_cookie_params(3600);
session_start();

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once('conection.php');
require_once('auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $loginResponse = login($conn, $email, $password);
        
        if ($loginResponse["code"] === "success") {
            $_SESSION["UID"] = session_setting($conn, $email, $password);

            if (isset($_SESSION["UID"])) {
                $sql = "INSERT INTO session_driver_id (session_id) VALUES ('{$_SESSION["UID"]}')";
                $res = mysqli_query($conn, $sql);
                
                echo json_encode($loginResponse);
            } else {
                echo json_encode(["code" => "session_not_set", "message" => "Session ID not set"]);
            }
        } else {
            echo json_encode($loginResponse);
        }
    } 

    



    else {
        echo json_encode(["code" => "invalid_input", "message" => "Missing email or password"]);
    }
} else {
    echo json_encode(["code" => "invalid_request", "message" => "Invalid HTTP request method"]);
}

mysqli_close($conn);
?>
