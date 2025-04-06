<?php
include "conection.php";
session_start();
error_reporting(0);

?>

<html>

<head>
    <script>
        function showAlert() {
            alert('Please enter your truck drop datetime and pickup datetime');
        }
    </script>
</head>

</html>
<?php
include "conection.php";

if (isset($_POST['date1']) && isset($_POST['date2'])) {
    if (isset($_POST['range1']) && isset($_POST['range2'])) {
        $min = mysqli_real_escape_string($conn, $_POST['range1']);
        $max = mysqli_real_escape_string($conn, $_POST['range2']);
        $pickupDate = mysqli_real_escape_string($conn, $_POST['date1']);
        $dropDate = mysqli_real_escape_string($conn, $_POST['date2']);

        $_SESSION["pick"] = $pickupDate;
        $_SESSION["drop"] = $dropDate;


        $sql = "SELECT t.*
        FROM truck_detials t
        WHERE NOT EXISTS (
            SELECT 1
            FROM truck_booking b
            WHERE t.truck_id = b.truck_id
            AND (
                (b.pickup_date <= '$pickupDate' AND b.drop_date >= '$pickupDate')
                OR (b.pickup_date <= '$dropDate' AND b.drop_date >= '$dropDate')
                OR (b.pickup_date >= '$pickupDate' AND b.drop_date <= '$dropDate')
                OR (b.pickup_date >= '$pickupDate' AND b.drop_date <= '$dropDate')
                OR (b.pickup_date <= '$pickupDate' AND b.drop_date >= '$dropDate')
            )
        )
        AND t.truck_capacity BETWEEN $min AND $max;";




        $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
        $output = '';

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row["truck_id"];
                    // $_SESSION["tid"] = $id;
                    $output .= "
                <div class=col-md-3>
                <div class=car-wrap ftco-animate>
                <div class=img d-flex align-items-end style='background-image: url($row[truck_image1])';>
                </div>
                <div class='text p-4 text-center'>
                <h2 class='mb-0'><a href='#'> {$row['truck_name']} </a></h2>
                <span>Truck Capacity: {$row['truck_capacity']}</span>
                <p class='d-flex mb-0 d-block'>
                <a href='Register.php?id={$id}' class='btn btn-black btn-outline-black mr-1'>Book now</a>
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
} else if (isset($_POST['date1']) || isset($_POST['date2']) || isset($_POST["range1"]) || isset($_POST["range2"])) {


    $sql = "SELECT * FROM truck_detials";

    $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
    $output = '';

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row["truck_id"];
                $_SESSION["tid"] = $id;
                $output .= "
                <div class=col-md-3>
                <div class=car-wrap ftco-animate>
                <div class=img d-flex align-items-end style='background-image: url($row[truck_image1])';>
                </div>
                <div class='text p-4 text-center'>
                <h2 class='mb-0'><a href='#'> {$row['truck_name']} </a></h2>
                <span>Truck Capacity: {$row['truck_capacity']}</span>
                <p class='d-flex mb-0 d-block'>
                <a href='' onclick='showAlert()'
                class='btn btn-black btn-outline-black mr-1'>Book now</a>
                <a href='truck_details.php?id={$id}' class='btn btn-black btn-outline-black ml-1'>Details</a>
                </p>
                </div>
                </div>
                </div>";
            }
            echo $output;
        }
    }
}

mysqli_close($conn);
?>