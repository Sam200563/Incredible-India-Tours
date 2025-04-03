<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Search with Map</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
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
      height: 500px;
      margin-top: 20px;
    }

    .hotels-container {
      margin-top: 20px;
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .hotel-card {
      border: 1px solid #ddd;
      border-radius: 8px;
      width: 300px;
      overflow: hidden;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .hotel-card img {
      width: 100%;
      height: 160px;
      object-fit: cover;
    }

    .hotel-card-body {
      padding: 15px;
    }

    .hotel-card-title {
      font-size: 18px;
      font-weight: bold;
    }

    .hotel-card-text {
      margin: 10px 0;
      color: #555;
    }

    .btn-primary {
      background-color: #007bff;
      color: white;
      text-decoration: none;
      padding: 10px 15px;
      border-radius: 5px;
      display: inline-block;
    }
  </style>
</head>

<body>
  <h1>Find Hotels on Map</h1>
  <form id="search-form">
    <div class="form-group">
      <label for="searchstate">Select State:</label>
      <select id="searchstate" class="form-select" onchange="onStateChange()" required>
        <option value="">Select State</option>
      </select>
    </div>
    <div class="form-group">
      <label for="searchcity">Select City:</label>
      <select id="searchcity" class="form-select" onchange="onCityChange()" required>
        <option value="">Select City</option>
      </select>
    </div>
  </form>
  <div id="map"></div>
  <div class="hotels-container" id="hotels-container"></div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    const apiKey = "ETSBpLUhFrIleBXFKSmgVDCayx_0330hfuJ4ytGujIA";

    const platform = new H.service.Platform({
      apikey: apiKey
    });
    const defaultLayers = platform.createDefaultLayers();
    const map = new H.Map(
      document.getElementById("map"),
      defaultLayers.vector.normal.map, {
        center: {
          lat: 20.5937,
          lng: 78.9629
        },
        zoom: 5
      }
    );
    const behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
    const ui = H.ui.UI.createDefault(map, defaultLayers);

    document.addEventListener("DOMContentLoaded", () => {
      loadStates();
    });

    function loadStates() {
      fetch("getStates.php")
        .then(response => response.text())
        .then(data => {
          document.getElementById("searchstate").innerHTML += data;
        })
        .catch(error => console.error("Error fetching states:", error));
    }

    function onStateChange() {
      const stateId = document.getElementById("searchstate").value;
      if (!stateId) {
        document.getElementById("searchcity").innerHTML = '<option value="">Select City</option>';
        return;
      }

      fetch(`getCities.php?state_id=${stateId}`)
        .then(response => response.text())
        .then(data => {
          document.getElementById("searchcity").innerHTML = '<option value="">Select City</option>' + data;
        })
        .catch(error => console.error("Error fetching cities:", error));
    }

    function onCityChange() {
      const cityId = document.getElementById("searchcity").value;

      // Clear the map and hotels container if no city is selected
      if (!cityId) {
        map.removeObjects(map.getObjects());
        map.setCenter({
          lat: 20.5937,
          lng: 78.9629
        });
        map.setZoom(5);
        document.getElementById("hotels-container").innerHTML = "";
        return;
      }

      fetch("get_city_coordinates.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ city_id: cityId })
            })
                .then(response => response.json())
                .then(hotels => {
                    map.removeObjects(map.getObjects()); // Clear existing markers
                    const hotelsContainer = document.getElementById("hotels-container");
                    hotelsContainer.innerHTML = "";
                    if (hotels.length === 0) {
                        alert("No hotels found for the selected city.");
                        return;
                    }

                    // Add markers for hotels
                    hotels.forEach(hotel => {
                        const marker = new H.map.Marker({
                            lat: parseFloat(hotel.latitude),
                            lng: parseFloat(hotel.longitude)
                        });
                        map.addObject(marker);
                        hotelsContainer.innerHTML += `
                            <div class="hotel-card">
                                <img src="${hotel.images}" alt="${hotel.name}" />
                                <div class="hotel-card-body">
                                    <h3 class="hotel-card-title">${hotel.name}</h3>
                                    <p class="hotel-card-text">${hotel.location}</p>
                                    <p class="hotel-card-text"><strong>Price:</strong> ₹${parseFloat(hotel.price_range).toFixed(2)}</p>
                                    <a href="hotel_details.php?id=${hotel.id}" class="btn-primary">View Details</a>
                                </div>
                            </div>`;
                            
                        const bubble = new H.ui.InfoBubble(marker.getGeometry(), {
                            content: `<strong>${hotel.name}</strong>`
                        });
                        marker.addEventListener("tap", () => {
                            ui.addBubble(bubble);
                        });
                    });

                    // Center the map to the first hotel's location
                    map.setCenter({
                        lat: parseFloat(hotels[0].latitude),
                        lng: parseFloat(hotels[0].longitude)
                    });
                    map.setZoom(12);
                })
                .catch(error => {
                    console.error("Error fetching hotels:", error);
                    alert("Failed to load hotels. Please try again.");
                });
    }
  </script>
</body>

</html>