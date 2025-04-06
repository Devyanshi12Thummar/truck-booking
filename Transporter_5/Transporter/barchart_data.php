<?php
include 'connection.php';

// else
// {

// }
// if($year="" || $month ="")
// {

// }
if (isset($_GET['year']) && isset($_GET['month'])) {
    $year = $_GET['year'];
    $month = $_GET['month'];

    $sql = "SELECT tb.year,
        tb.truck_id,
        tb.booking_count,
        td.truck_name,
        MONTHNAME(CONCAT(tb.year, '-', tb.month, '-01')) AS month_name
        FROM (
        SELECT YEAR(booking_date) AS year,
            MONTH(booking_date) AS month,
            truck_id,
            COUNT(*) AS booking_count
        FROM truck_booking
        WHERE YEAR(booking_date) = $year AND MONTH(booking_date) = $month
        GROUP BY year, month, truck_id
        ) tb
        JOIN truck_detials td ON tb.truck_id = td.truck_id
        ORDER BY tb.year, tb.month, tb.truck_id";

    $result = mysqli_query($conn, $sql);

    $labels = array();
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $labels[] = $row["truck_name"];
        $data[] = round($row["booking_count"]);
    }

    $data = [
        'labels' => $labels,
        'data' => $data,
        'backgroundColor' => [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 0, 0, 0.2)',
                'rgba(0, 128, 0, 0.2)',
                'rgba(0, 0, 255, 0.2)',
                'rgba(128, 128, 128, 0.2)', 
        ],
        'borderColor' => [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 0, 0, 1)',
            'rgba(0, 128, 0, 1)',
            'rgba(0, 0, 255, 1)',
            'rgba(128, 128, 128, 1)',
        ],
    ];

    echo json_encode($data);
} 

?>