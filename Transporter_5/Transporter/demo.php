<?php
include "connection.php";
if(isset($_POST["year"]))
{

    
    $year=$_POST["year"];

    // $query="SELECT truck_id, COUNT(*) AS booking_count,MonthName(booking_date) AS month FROM truck_booking WHERE YEAR(booking_date) = $year GROUP BY month; ";
    // $query = "SELECT truck_id, COUNT(*) AS booking_count,MonthName(booking_date) AS month FROM truck_booking WHERE YEAR(booking_date) = $year GROUP BY truck_id; ";
    // $result = mysqli_query($conn,$query);
    // while($row =mysqli_fetch_assoc($result))
    // {
    //     $output[] = array(
    //         'month'   => $row["truck_id"],
    //         'profit'  => $row["booking_count"]
    //        );

    // }
    // echo json_encode($output);
//     $statement = $conn->prepare($query);
// $statement->execute();
// $result = $statement->fetchAll();

// $output = array(); // Initialize the output array

// foreach ($result as $row) {
//     $output[] = array(
//         'truck_id' => $row["truck_id"],         // Corrected column name
//         'booking_count' => $row["booking_count"] // Corrected column name
//     );
// }

// echo json_encode($output);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "truckbooking";
$connect = mysqli_connect($servername, $username, $password, $dbname);

// if (!$conn) {
//     echo "Error in Database";

// }

// $connect = new PDO("mysql:host=localhost;dbname=truckbooking", "root", "");


//  $query = "SELECT truck_id, COUNT(*) AS booking_count,MonthName(booking_date) AS month FROM truck_booking WHERE YEAR(booking_date) = $year GROUP BY month";
//  $statement = $connect->prepare($query);
//  $statement->execute();
//  $result = mysqli_query($conn,$query);

// //  $result = $statement->fe();

//  while($row =mysqli_fetch_array($result))
//  {
//      $output[] = array(
//          'month'   => $row["truck_id"],
//          'profit'  => $row["booking_count"],
//         );
//  echo json_encode($output);

// $query = "SELECT truck_id, COUNT(*) AS booking_count, MonthName(booking_date) AS month FROM truck_booking WHERE YEAR(booking_date) = $year GROUP BY truck_id, month";
// $statement = $connect->prepare($query);
// $statement->execute();
// $result = $statement->get_result(); // Use get_result() to fetch result for prepared statement

// $output = array(); // Initialize the output array

// while ($row = $result->fetch_assoc()) {
//     $output[] = array(
//         'truck_id' => $row["truck_id"],
//         'month'    => $row["month"],
//     );
// }

// echo json_encode($output);


$query = "SELECT truck_id, COUNT(*) AS booking_count, MonthName(booking_date) AS month FROM truck_booking WHERE YEAR(booking_date) = $year GROUP BY truck_id, month";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->get_result(); // Use get_result() to fetch result for prepared statement

$output = array(); // Initialize the output array

while ($row = $result->fetch_assoc()) {
    $output[] = array(
        'truck_id' => $row["truck_id"],
        'month'    => $row["month"],
        'booking_count' => $row["booking_count"],
    );
}

echo json_encode($output);









 }










//  foreach($result as $row)
//  {
//   $output[] = array(
//     'truck_id' => $row["truck_id"],
//     'booking_count' => $row["booking_count"]
//   );
//  }


//  echo json_encode($output);


?>


