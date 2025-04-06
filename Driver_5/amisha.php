<?php

include 'conection.php';

$booking = array();

$stmt = mysqli_prepare($conn, "SELECT tb.booking_id, tb.pickup_address, tb.drop_address, tb.booking_date, tb.truck_id, td.truck_image1 FROM truck_booking tb INNER JOIN truck_detials td ON tb.truck_id = td.truck_id");

if ($stmt) {
    // Execute the query
    mysqli_stmt_execute($stmt);

    // Bind results to variables
    mysqli_stmt_bind_result($stmt, $bid, $padd, $dadd, $date, $tid, $image);

    //traversing through all the result
    while (mysqli_stmt_fetch($stmt)) {
        $temp = array();
        $temp['booking_id'] = $bid;
        $temp['pickup_address'] = $padd;
        $temp['drop_address'] = $dadd;
        $temp['order_date'] = $date;
        $temp['image'] = $image;

        array_push($booking, $temp);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($conn);

echo json_encode($booking);
?>
