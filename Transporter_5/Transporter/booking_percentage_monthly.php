<?php

include "connection.php";
$sqltotal ="SELECT COUNT(DISTINCT pickup_address) as total from truck_booking";

$resulttotal=mysqli_query($conn,$sqltotal);

$rowtotal=mysqli_fetch_assoc($resulttotal);
$total=$rowtotal["total"];


$sqlcity="SELECT COUNT(*) as count ,pickup_address from truck_booking WHERE YEAR(booking_date)=MONTHNAME(NOW()) and MONTHNAME(booking_date)=MONTHNAME(NOW()) GROUP BY pickup_address; ";
$sqlcity=mysqli_query($conn,$sqlcity);


?>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                            google.charts.load('current', {'packages':['corechart']});
                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {
                                var data = new google.visualization.DataTable();
                                data.addColumn('string', 'City');
                                data.addColumn('number', 'Percentage booking');

                                <?php
                                while ($rowcity = mysqli_fetch_array($sqlcity)) {
                                    $pickup_address = $rowcity["pickup_address"];
                                    $percentage = $rowcity["count"] / $total * 100;
                                    echo "data.addRow(['$pickup_address', $percentage]);";
                                }
                                ?>

                                var options = {
                                    title: 'City wise booking(Yearly)'
                                };

                                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                chart.draw(data, options);
                            }
                        </script>
<div id="piechart" style="width: 700px; height: 500px;"></div>