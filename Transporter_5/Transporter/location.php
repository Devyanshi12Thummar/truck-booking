<?php
include "connection.php";
// Fetch all user locations
$sql = "SELECT * FROM user_locations";
$result = mysqli_query($conn, $sql);

// Create an array to store all user locations
$userLocations = array();

while ($row = mysqli_fetch_assoc($result)) {
    $userLocations[] = $row;
}

// Replace 'YOUR_API_KEY' with your actual Google Maps API key
$apiKey = 'AIzaSyBbesu2aKgpgMVqKQzj_Hz7SByfGNHNiUU  ';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Location Map</title>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <script>
        var userLocations = <?php echo json_encode($userLocations); ?>;
        
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 0, lng: 0 }, // Center the map initially at (0,0)
                zoom: 10 // Adjust the initial zoom level as needed
            });

            // Create a LatLngBounds object to encompass all user locations
            var bounds = new google.maps.LatLngBounds();

            // Loop through user locations and create markers
            for (var i = 0; i < userLocations.length; i++) {
                var location = { 
                    lat: parseFloat(userLocations[i].latitude), 
                    lng: parseFloat(userLocations[i].longitude)
                };

                var marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    label: userLocations[i].user_id.toString(), // Use the user_id as the label
                });

                // Extend the bounds to include this location
                bounds.extend(location);
            }

            // Fit the map to the bounds
            map.fitBounds(bounds);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $apiKey; ?>&callback=initMap" async defer></script>
</body>
</html>

