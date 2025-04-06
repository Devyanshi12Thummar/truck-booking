<!-- Include the Google Charts library -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- Include jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<select id="year" name="year">
    <option value="2023">2023</option>
    <option value="2021">2021</option>
    <option value="2024">2024</option>
    <option value="2025">2025</option>
</select>

<!-- Create a container for the chart -->
<div id="piechart3" style="margin-left:-30px; width: 303px; height: 300px;"></div>

<script type="text/javascript">
    google.charts.load('current', { 'packages': ['corechart'] });

    // Attach an event listener to the dropdown change event
    $('#year').on('change', function () {
        var selectedYear = $(this).val();
        drawChart(selectedYear);
    });

    // Initial chart rendering
    drawChart($('#year').val());

    function drawChart(year) {
        $.ajax({
            url: 'get_data.php', // URL to fetch data
            dataType: 'json',
            data: { year: year }, // Pass the selected year as a parameter
            success: function (data) {
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('string', 'City');
                dataTable.addColumn('number', 'Percentage booking');

                for (var i = 0; i < data.length; i++) {
                    dataTable.addRow([data[i][0], data[i][1]]);
                }

                var options = {
                    title: 'Booking Data for ' + year,
                    legend: 'bottom'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart3'));
                chart.draw(dataTable, options);
            },
            error: function () {
                console.error('Error fetching data via AJAX');
            }
        });
    }
</script>
