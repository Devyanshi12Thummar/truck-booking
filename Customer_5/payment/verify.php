<?php

require('config.php');

session_start();

require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false) {
    $api = new Api($keyId, $keySecret);

    try {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    } catch (SignatureVerificationError $e) {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "truckbooking";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        echo "Error in Database";
    }

    $pik_add = $_SESSION['piadd'];
    $dro_add = $_SESSION['dradd'];
    $goodweight = $_SESSION['goodweight'];
    $goodtype = $_SESSION['goodtype'];
    $pidate = $_SESSION["pick"];
    $dropdate = $_SESSION["drop"];
    $custid = $_SESSION['cust_id'];
    $truckid = $_SESSION['tid'];
    $amount = $_SESSION['pay_amount'];

    $sql = "INSERT INTO truck_booking (`booking_date`, `pickup_date`, `drop_date`, `pickup_address`, `drop_address`, `goods_weight`, `user_id`, `truck_id`, `goods_id`,`assign_driver_status`) VALUES (NOW(), '$pidate', '$dropdate', '$pik_add', '$dro_add', '$goodweight', '$custid', '$truckid', '$goodtype','0')";
    $oo = mysqli_query($conn, $sql);
    
    if ($oo) {
        $booking_id = mysqli_insert_id($conn); // Get the last inserted ID
        // echo '<script>alert(" Your Booking Successfully Done")</script>';
        $transaction_id = $_POST['razorpay_payment_id'];

        // Check if a payment with the given transaction_id already exists
        $sql_check = "SELECT COUNT(*) FROM payment WHERE transaction_id = '$transaction_id'";
        // die($transaction_id);
        $result_check = mysqli_query($conn, $sql_check);
        $count = mysqli_fetch_row($result_check)[0];
        mysqli_free_result($result_check);
        
        if ($transaction_id != '' && $count <= 0) {
            // If the payment does not already exist, insert a new payment record
            $sqlpay = "INSERT INTO payment (`payment_id`, `booking_id`, `payment_amount`, `payment_date`, `transaction_id`) VALUES (NULL, '$booking_id', '$amount', NOW(), '$transaction_id')";
            
            if (mysqli_query($conn, $sqlpay)) {

                header('location: sucess.php');
                
            } else {
                echo '<script>alert("Error: ' . mysqli_error($conn) . '")</script>';
            }
        }

    } 

    
    
} else {

    echo '<script>alert("Your payment failed ")</script>';

    // $html = "<p>Your payment failed</p>
    //          <p>{$error}</p>";
}


