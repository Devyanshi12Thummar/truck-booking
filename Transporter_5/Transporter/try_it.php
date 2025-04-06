<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pie Chart with AJAX</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body>
    <h1>Pie Chart with AJAX</h1>
    <div width="400" height="400"><canvas id="pieChart" ></canvas></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the canvas element and create a context
            var ctx = document.getElementById('pieChart').getContext('2d');

            // Function to update the pie chart
            function updateChart() {
                // Make an AJAX request to data.php
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var data = JSON.parse(xhr.responseText);

                        // Data for the pie chart
                        var labels = Object.keys(data);
                        var values = Object.values(data);

                        // Create a new pie chart
                        var pieChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: labels,
                                datasets: [{
                                    data: values,
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.7)',
                                        'rgba(54, 162, 235, 0.7)',
                                        'rgba(255, 206, 86, 0.7)',
                                        'rgba(75, 192, 192, 0.7)'
                                    ]
                                }]
                            }
                        });
                    }
                };

                xhr.open('GET', 'citywise_current_year.php', true);
                xhr.send();
            }

            // Initial chart rendering
            updateChart();
        });
    </script>
</body>
</html>
