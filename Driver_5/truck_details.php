<?php
include 'conection.php';

$booking = array();

if (isset($_POST["email"])) {
    $email = $_POST["email"];
    $stmt = $conn->prepare("SELECT tb.booking_id, 
    tb.pickup_address, 
    tb.drop_address, 
    tb.booking_date, 
    tb.pickup_date, 
    tb.drop_date, 
    td.truck_image1 as truck_image, 
    td.truck_name, 
    g.goods_type,
    um.user_contactno_primary
FROM truck_booking tb 
INNER JOIN truck_detials td ON tb.truck_id = td.truck_id 
LEFT JOIN truck_driver ON tb.booking_id = truck_driver.booking_id 
INNER JOIN goods g ON tb.goods_id = g.goods_id 
INNER JOIN user_master um ON tb.user_id = um.user_id
WHERE truck_driver.driver_email = '$email' AND tb.booking_id='$bookingid'
;
");

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($bid, $padd, $dadd, $bookdate, $pickupdate, $dropdate, $image, $truckname, $goodtype);

    while ($stmt->fetch()) {
        $temp = array();
        $temp['booking_id'] = $bid;
        $temp['pickup_address'] = $padd;
        $temp['drop_address'] = $dadd;
        $temp['order_date'] = $bookdate;
        $temp['truckimage'] = $image;

        // $temp['pickup_date'] = $pickupdate;
        // $temp['drop_date'] = $dropdate;
        // $temp['truck_name']=$truckname;
        // $temp['goods_type']=$goodtype;
        array_push($booking, $temp);
    }
    $stmt->close();
}

echo json_encode($booking);
$conn->close();
?>