<?php
include 'conection.php';

// $mindate = "select min(pickup_date) AS pd from truck_detials";
// $r = mysqli_query($conn, $sql);
// $RE = mysqli_fetch_assoc($r);
// $MI = $row['pd'];


// $maxdate = "select max(drop_date) AS DD from truck_booking;";
// $r1 = mysqli_query($conn, $sql);
// $RES = mysqli_fetch_assoc($r1);
// $MAX = $row['dd'];


if (isset($_POST['pi']) && isset($_POST['dr'])) 
{

    if (isset($_POST['range1']) && isset($_POST['range2'])) 
    {

        $max = isset($_POST['range1']) ? $_POST['range1'] : $MI;
        $max = isset($_POST['range2']) ? $_POST['range2'] : $MAX;

        $checkInDate = isset($_POST['pi']) ? $_POST['pi'] : '';
        $checkOutDate = isset($_POST['dr']) ? $_POST['dr'] : '';



        $sql = " SELECT t.*
            FROM truck_detials t
            WHERE NOT EXISTS (
                SELECT 1
                FROM truck_booking b
                WHERE t.truck_id = b.truck_id
                AND (b.pickup_date <= '$checkOutDate' AND b.drop_date >= '$checkInDate')
            )     AND truck_capacity BETWEEN {$min} AND {$max}";


        $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
        $output = '';





        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row["truck_id"];

                    $output .= "
            <div class=col-md-3>
            <div class=car-wrap ftco-animate>
            <div class=img d-flex align-items-end style='background-image: url($row[truck_image1])';>
            </div>
            <div class='text p-4 text-center'>
            <h2 class='mb-0'><a href='#'> {$row['truck_name']} </a></h2>
            <span>Truck Capacity: {$row['truck_capacity']}</span>
            <p class='d-flex mb-0 d-block'>
            <a href='Register.php?truckid={$id}' class='btn btn-black btn-outline-black mr-1'>Book now</a>
            <a href='truck_details.php?id={$id}' class='btn btn-black btn-outline-black ml-1'>Details</a>
            </p>
            </div>
            </div>
            </div>
        ";
                }
                echo $output;
            }
        }
    }
}

mysqli_close($conn);

?>