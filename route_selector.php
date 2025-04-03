<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Route Selector</title>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
    <link rel="stylesheet" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #map {
            width: 100%;
            height: 700px;
            margin-top: 20px;
        }

        .controls {
            margin: 20px 0;
        }

        .controls select,
        .controls input,
        .controls button {
            margin-right: 10px;
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <h1>Route Selector</h1>
    <div class="controls">
        <label for="origin">Origin:</label>
        <input type="text" id="origin" placeholder="Enter origin address" />

        <label for="destination">Destination:</label>
        <input type="text" id="destination" placeholder="Enter destination address" />

        <label for="transportMode">Transport Mode:</label>
        <select id="transportMode">
            <option value="car">Car</option>
            <option value="bicycle">Bicycle</option>
            <option value="pedestrian">Walking</option>
        </select>

        <label for="routeType">Route Type:</label>
        <select id="routeType">
            <option value="fastest">Fastest</option>
            <option value="shortest">Shortest</option>
        </select>

        <button onclick="calculateRoute()">Show Route</button>
    </div>

    <div id="map"></div>

    <script>
        const apiKey = "ETSBpLUhFrIleBXFKSmgVDCayx_0330hfuJ4ytGujIA"; // Replace with your actual HERE API key
        const platform = new H.service.Platform({ apikey: apiKey });
        const defaultLayers = platform.createDefaultLayers();

        const map = new H.Map(document.getElementById("map"), defaultLayers.vector.normal.map, {
            center: { lat: 20.5937, lng: 78.9629 },
            zoom: 5,
            pixelRatio: window.devicePixelRatio || 1,
        });

        const behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
        const ui = H.ui.UI.createDefault(map, defaultLayers);

        const geocodeCache = {}; // Cache for geocoded addresses
        const delay = (ms) => new Promise((resolve) => setTimeout(resolve, ms)); // Delay function

        async function geocodeAddress(address) {
            if (!address || address.trim() === "") {
                throw new Error("Address is empty. Please provide a valid address.");
            }

            if (geocodeCache[address]) {
                console.log("Using cached geocode result:", geocodeCache[address]);
                return geocodeCache[address];
            }

            const url = `https://geocode.search.hereapi.com/v1/geocode?q=${encodeURIComponent(address)}&apiKey=${apiKey}`;
            console.log("Geocoding URL:", url);

            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Geocoding failed: ${response.status}`);
            }

            const data = await response.json();
            if (data.items && data.items.length > 0) {
                const location = data.items[0].position;
                geocodeCache[address] = location; // Cache result
                return location;
            } else {
                throw new Error(`No location found for address: "${address}"`);
            }
        }

        function calculateRoute() {
    const originAddress = document.getElementById("origin").value.trim();
    const destinationAddress = document.getElementById("destination").value.trim();
    const transportMode = document.getElementById("transportMode").value;
    const routeType = document.getElementById("routeType").value;

    if (!originAddress || !destinationAddress) {
        alert("Please enter both origin and destination addresses.");
        return;
    }

    Promise.all([geocodeAddress(originAddress), geocodeAddress(destinationAddress)])
        .then(([origin, destination]) => {
            console.log("Origin Coordinates:", origin);
            console.log("Destination Coordinates:", destination);

            // Correct routingMode
            const routingMode = routeType === "shortest" ? "short" : "fast";

            const url = `https://router.hereapi.com/v8/routes?transportMode=${transportMode}&origin=${origin.lat},${origin.lng}&destination=${destination.lat},${destination.lng}&routingMode=${routingMode}&return=polyline,summary&apiKey=${apiKey}`;
            console.log("Routing URL:", url);

            return fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Routing failed: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Routing API Response:", data);

                    if (!data.routes || data.routes.length === 0) {
                        alert("No route found. Please try different options.");
                        return;
                    }

                    const route = data.routes[0];
                    const polyline = route.sections[0].polyline;

                    const routeShape = H.geo.LineString.fromFlexiblePolyline(polyline);

                    const routeLine = new H.map.Polyline(routeShape, {
                        style: {
                            strokeColor: "blue",
                            lineWidth: 5
                        },
                    });

                    map.removeObjects(map.getObjects());
                    map.addObject(routeLine);

                    const startMarker = new H.map.Marker(origin);
                    const endMarker = new H.map.Marker(destination);
                    map.addObject(startMarker);
                    map.addObject(endMarker);

                    map.getViewModel().setLookAtData({
                        bounds: routeLine.getBoundingBox(),
                    });

                    const summary = route.sections[0].summary;
                    alert(`Distance: ${(summary.length / 1000).toFixed(2)} km\nDuration: ${(summary.duration / 60).toFixed(2)} minutes`);
                });
        })
        .catch(error => {
            console.error("Error:", error);
            alert(error.message);
        });
}

    </script>
</body>

</html>
