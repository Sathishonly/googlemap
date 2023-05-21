<!DOCTYPE html>
<html>
<head>
    <title>Google Maps Example</title>
    <style>
        #map {
            height: 400px;
        }
    </style>
</head>
<body>
    <h1>Google Maps Example</h1>
    <div id="map"></div>

    <form id="directions-form">
        <label for="origin">Origin:</label>
        <input type="text" id="origin" name="origin" required>

        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" required>

        <button type="submit">Get Directions</button>
    </form>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDrwHSGE-dNWozVWERcfdWZ8tVrpnw1Xa8"></script>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12, // Initial zoom level
                center: { lat: 0, lng: 0 }, // Initial center coordinates
            });

            // Add a marker for the current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    var marker = new google.maps.Marker({
                        position: pos,
                        map: map,
                        title: 'Current Location'
                    });

                    map.setCenter(pos); // Center the map on the current location
                }, function() {
                    // Handle geolocation error
                });
            }

            // Get directions
            var directionsService = new google.maps.DirectionsService();
            var directionsDisplay = new google.maps.DirectionsRenderer();
            directionsDisplay.setMap(map);

            var directionsForm = document.getElementById('directions-form');
            directionsForm.addEventListener('submit', function(event) {
                event.preventDefault();
                calculateDirections(directionsService, directionsDisplay);
            });

            function calculateDirections(service, display) {
                var origin = document.getElementById('origin').value;
                var destination = document.getElementById('destination').value;

                service.route({
                    origin: origin,
                    destination: destination,
                    travelMode: google.maps.TravelMode.DRIVING
                }, function(response, status) {
                    if (status === google.maps.DirectionsStatus.OK) {
                        display.setDirections(response);
                    } else {
                        alert('Directions request failed due to ' + status);
                    }
                });
            }

            // Zoom in button
            var zoomInButton = document.getElementById('zoom-in');
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(zoomInButton);
            zoomInButton.addEventListener('click', function() {
                map.setZoom(map.getZoom() + 1);
            });

            // Zoom out button
            var zoomOutButton = document.getElementById('zoom-out');
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(zoomOutButton);
            zoomOutButton.addEventListener('click', function() {
                map.setZoom(map.getZoom() - 1);
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDrwHSGE-dNWozVWERcfdWZ8tVrpnw1Xa8&callback=initMap"></script>
</body>
</html>
