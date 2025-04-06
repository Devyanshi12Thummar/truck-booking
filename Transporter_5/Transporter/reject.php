<?php
include 'connection.php';

$id=$_GET['id'];

$sql="SELECT user_master.user_id, truck_booking.booking_id, user_master.user_contactno_primary FROM truck_booking INNER JOIN user_master ON truck_booking.user_id=user_master.user_id where truck_booking.booking_id=$id " ;
$result1=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result1);

$mobile=$row['user_contactno_primary'];



    $sql1 = "CREATE TRIGGER book_reject AFTER DELETE ON truck_booking FOR EACH ROW BEGIN INSERT INTO reject_booking VALUES ( old.booking_id, old.booking_date, old.pickup_date, old.drop_date, old.pickup_address, old.drop_address, old.goods_weight, old.user_id, old.truck_id, old.goods_id ); END;";
    if (mysqli_query($conn, $sql1))
     {
        $sql2 = "DELETE from truck_booking where booking_id=$id";
        if (mysqli_query($conn, $sql2)) {
            $sql3 = "DROP TRIGGER book_reject";
            $result = mysqli_query($conn, $sql3);
        }
    }




        function sendSMS($mobileNo,$message) {
            $curl = curl_init();
            $api_key = "T3zSZIdPpVWKyPChjdVTa8GDHUwBLBBm8xtAL4Ha4fkMau6A1Js8y3tcUIec";
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=" . $api_key . "&sender_id=TXTIND&message=" . urlencode($message) . "&route=v3&numbers=" . urlencode($mobileNo),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"
                ),
            ));
        
            $response = curl_exec($curl);
            $err = curl_error($curl);
        
            curl_close($curl);
        
        
        }
        $mess="Your Truck Booking has been Rejected!";
        sendSMS($mobile,$mess) ;
        
if ($result) {
    header("location: booking_request.php");
} else {
    echo "Failed: " . mysqli_error($conn);
}
?>