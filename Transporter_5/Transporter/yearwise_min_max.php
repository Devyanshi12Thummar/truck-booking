
<?php
include "connection.php";

    // $year = $_GET['q'];
    // die($year);


    $year=2023;


    $sql = "SELECT t_max.year AS year,
    t_max.truck_id AS max_truck_id,
    t_max.booking_count AS max_booking_count,
    t_min.truck_id AS min_truck_id,
    t_min.booking_count AS min_booking_count
FROM (
 SELECT YEAR(booking_date) AS year,
        truck_id,
        COUNT(*) AS booking_count
 FROM truck_booking
 WHERE YEAR(booking_date) = $year
 GROUP BY year, truck_id
 HAVING booking_count = (
     SELECT MAX(sub.booking_count)
     FROM (
         SELECT COUNT(*) AS booking_count
         FROM truck_booking
         WHERE YEAR(booking_date) = $year
         GROUP BY truck_id
     ) sub
 )
) t_max
JOIN (
 SELECT YEAR(booking_date) AS year,
        truck_id,
        COUNT(*) AS booking_count
 FROM truck_booking
 WHERE YEAR(booking_date) = $year
 GROUP BY year, truck_id
 HAVING booking_count = (
     SELECT MIN(sub.booking_count)
     FROM (
         SELECT COUNT(*) AS booking_count
         FROM truck_booking
         WHERE YEAR(booking_date) = $year
         GROUP BY truck_id
     ) sub
 )
) t_min ON t_max.year = t_min.year
ORDER BY year;
";


$result=mysqli_query($conn,$sql);

    // echo "<table id='customers'>
    //     <tr>
    //     <th>Year</th>
    //     <th>MAX</th>
    //     <th>MAXcount</th>
    //     <th>MIN</th>
    //     <th>MINcount</th>  
    //     </tr>";
    // while ($row = mysqli_fetch_array($result)) {
    //     $max = $row['max_booking_count'];
    //     $min = $row['min_booking_count'];
    //     echo "<tr>";
    //     echo "<td>" . $row['year'] . "</td>";
    //     echo "<td>" . $row['max_truck_id'] . "</td>";
    //     echo "<td>" . $row['max_booking_count'] . "</td>";
    //     echo "<td>" . $row['min_truck_id'] . "</td>";
    //     echo "<td>" . $row['min_booking_count'] . "</td>";
    //     echo "</tr>";
    // }


    // echo "</table>";

    $rowgraph = mysqli_fetch_array($result);
        $maxtruckid=$rowgraph['max_truck_id'];
        $mintruckid=$rowgraph['min_truck_id'];
        $max=$rowgraph['max_booking_count'];
        $min=$rowgraph['min_booking_count'];
      


    $namesql = "SELECT DISTINCT truck_booking.truck_id, truck_detials.truck_id, truck_detials.truck_name 
FROM truck_booking 
INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id 
WHERE  truck_booking.truck_id = $mintruckid";

    $nameres = mysqli_query($conn, $namesql);
    $ro = mysqli_fetch_assoc($nameres);

    $mintruckname = $ro['truck_name'];




    $namesql1 = "SELECT DISTINCT truck_booking.truck_id, truck_detials.truck_id, truck_detials.truck_name 
    FROM truck_booking 
    INNER JOIN truck_detials ON truck_booking.truck_id = truck_detials.truck_id 
    WHERE truck_booking.truck_id = $maxtruckid";

    $nameres1 = mysqli_query($conn, $namesql1);
    $ro1 = mysqli_fetch_assoc($nameres1);



    $maxtruckname = $ro1['truck_name'];


    $chartHTML = "
    <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
    <div style='width: 400px; height: 300px;'>
        <canvas id='myChart'></canvas>
    </div>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['$mintruckname', '$maxtruckname'],
                datasets: [{
                    label: 'Minimum',
                    data: [$min, $max],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
";
echo"<div style='width: 400px; height: 300px;'>
<canvas id='myChart'></canvas>
</div>";
echo $chartHTML;
?>




