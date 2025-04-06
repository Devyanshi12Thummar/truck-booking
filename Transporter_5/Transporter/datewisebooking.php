<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    #customers {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #customers td,
    #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    #customers tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    #customers tr:hover {
      background-color: #ddd;
    }

    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: black;
      color: white;
    }
  </style>
</head>

<body>

  <?php





  $hostname = "localhost";
  $username = "root";
  $password = "";
  $dbname = "truckbooking";

  $conn = new mysqli($hostname, $username, $password, $dbname);

  if ($conn->connect_errno) {
    die("connection failed");
  }


  $q = $_GET['q'];
  $p = $_GET['p'];
// die($q);
  // die("".$q."".$p);
  
  echo $q;
  // $sql="SELECT * FROM truck_booking WHERE booking_date='$q'";
  
  if (isset($q) && isset($p)) {

    
    $sql = "SELECT truck_detials.*, truck_booking.* FROM truck_booking INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id WHERE DATE(truck_booking.booking_date) = '$q' ";
    // and pickup_address = '" . $p . "' 
    // DATE(truck_booking.booking_date) = '$q' 
// $in="SELECT
// tb.pickup_address,
// tb.drop_address,
// tb.goods_weights,
// g.goods_type,
// td.truck_name,
// tb.booking_id
// FROM
// truck_booking tb
// INNER JOIN
// truck_detials td ON tb.truck_id = td.truck_id
// INNER JOIN
// goods g ON tb.goods_id = g.goods_id
// WHERE
// tb.booking_date = '$q'";
    $result = $conn->query($sql);
    // echo $result;
  
    echo "<table id='customers'>
<tr>
    <th>Booking Id</th>
    <th>PickupAddress</th>
    <th>DropAddress</th>

    <th>Truck Name</th>                    
</tr>";
    // <th>Goods Weight</th>
// <th>Goods</th>
    while ($row = mysqli_fetch_array($result)) {
      echo "<tr>";
      echo "<td>" . $row["booking_id"] . "</td>";
      echo "<td>" . $row['pickup_address'] . "</td>";
      echo "<td>" . $row['drop_address'] . "</td>";
      // echo "<td>" . $row['goods_weight'] . "</td>";
      // echo "<td>" . $row['goods_type'] . "</td>";
      echo "<td>" . $row['truck_name'] . "</td>";
      // echo "<td>" . $row['CustomerId'] . "</td>";
  

      echo "</tr>";
    }

    echo "</table>";
    // mysqli_close($conn);
  }


  // else 
  // {
  //   $sql="SELECT truck_detials.*, truck_booking.* FROM truck_booking INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id WHERE DATE(truck_booking.booking_date) = '$q' ";

  //   $result = $conn->query($sql);
  //   echo "<table id='customers'>
  //   <tr>
  //       <th>Booking Id</th>
  //       <th>PickupAddress</th>
  //       <th>DropAddress</th>
    
  //       <th>Truck Name</th>                    
  //   </tr>";
  //       // <th>Goods Weight</th>
  //   // <th>Goods</th>
  //       while ($row = mysqli_fetch_array($result)) {
  //         echo "<tr>";
  //         echo "<td>" . $row["booking_id"] . "</td>";
  //         echo "<td>" . $row['pickup_address'] . "</td>";
  //         echo "<td>" . $row['drop_address'] . "</td>";
  //         // echo "<td>" . $row['goods_weight'] . "</td>";
  //         // echo "<td>" . $row['goods_type'] . "</td>";
  //         echo "<td>" . $row['truck_name'] . "</td>";
  //         // echo "<td>" . $row['CustomerId'] . "</td>";
      
    
  //         echo "</tr>";
  //       }
    
  //       echo "</table>";
  //       // mysqli_close($conn);
  //     }
     
  ?>

</body>

</html>