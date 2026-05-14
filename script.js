function getMoodQuery(mood) {
    switch (mood) {
        case "happy":
            return [
                'node["leisure"="park"]',
                'node["amenity"="cafe"]',
                'node["amenity"="restaurant"]'
            ];
        case "sad":
            return [
                'node["amenity"="cafe"]',
                'node["amenity"="restaurant"]',
                'node["leisure"="park"]'
            ];
        case "excited":
            return [
                'node["amenity"="cinema"]',
                'node["tourism"="attraction"]',
                'node["amenity"="restaurant"]',
                'node["amenity"="cafe"]'
            ];
        case "calm":
            return [
                'node["amenity"="library"]',
                'node["leisure"="park"]',
                'node["amenity"="cafe"]'
            ];
        case "hungry":
            return [
                'node["amenity"="restaurant"]',
                'node["amenity"="fast_food"]',
                'node["amenity"="cafe"]'
            ];
        case "spiritual":
            return [
                'node["amenity"="place_of_worship"]',
                'node["leisure"="park"]'
            ];
        default:
            return [
                'node["amenity"="cafe"]',
                'node["amenity"="restaurant"]'
            ];
    }
}

function getNearbyPlaces() {
    const moodElement = document.getElementById("mood");
    const radiusElement = document.getElementById("radius");
    const statusBox = document.getElementById("statusMessage");
    const placesList = document.getElementById("placesList");

    if (!moodElement || !radiusElement || !statusBox || !placesList) {
        alert("Required page elements not found. Check dashboard.php IDs.");
        return;
    }

    const mood = moodElement.value;
    const radius = parseInt(radiusElement.value);

    placesList.innerHTML = "";
    statusBox.className = "message info";
    statusBox.innerText = "Getting your location...";

    if (!radius || radius < 100) {
        statusBox.className = "message error";
        statusBox.innerText = "Please enter a valid radius.";
        return;
    }

    if (!navigator.geolocation) {
        statusBox.className = "message error";
        statusBox.innerText = "Geolocation is not supported by your browser.";
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            statusBox.innerText = "Searching nearby places...";

            const queries = getMoodQuery(mood)
                .map(q => `${q}(around:${radius},${lat},${lon});`)
                .join("");

            const overpassQuery = `
[out:json][timeout:25];
(
${queries}
);
out body;
`;

            fetch("https://overpass-api.de/api/interpreter", {
                method: "POST",
                body: overpassQuery
            })
            .then(response => response.text())
            .then(text => {
                if (!text || text.trim() === "") {
                    throw new Error("Empty response from API");
                }

                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.log("Raw response:", text);
                    throw new Error("Invalid JSON response");
                }

                if (!data.elements || data.elements.length === 0) {
                    statusBox.className = "message error";
                    statusBox.innerText = "No places found. Try increasing the radius.";
                    return;
                }

                statusBox.className = "message success";
                statusBox.innerText = `Found ${data.elements.length} places.`;

                const seen = new Set();
                const uniquePlaces = [];

                data.elements.forEach(place => {
                    const name = place.tags && place.tags.name ? place.tags.name : "Unnamed Place";

                    const address =
                        place.tags && (
                            place.tags["addr:full"] ||
                            [
                                place.tags["addr:housenumber"],
                                place.tags["addr:street"],
                                place.tags["addr:city"]
                            ].filter(Boolean).join(", ")
                        ) || `Location available (Lat: ${place.lat}, Lng: ${place.lon})`;

                    const key = `${name}|${place.lat}|${place.lon}`;

                    if (!seen.has(key)) {
                        seen.add(key);
                        uniquePlaces.push({
                            name: name,
                            address: address,
                            lat: place.lat,
                            lon: place.lon
                        });
                    }
                });

                placesList.innerHTML = "";

                uniquePlaces.forEach(place => {
                    const card = document.createElement("div");
                    card.className = "place-card";

                    card.innerHTML = `
                        <h3>${escapeHtml(place.name)}</h3>
                        <p><strong>Mood:</strong> ${escapeHtml(mood)}</p>
                        <p><strong>Address:</strong> ${escapeHtml(place.address)}</p>
                        <div class="card-actions">
                            <button onclick="saveFavourite(
                                '${jsEscape(place.name)}',
                                '${jsEscape(place.address)}',
                                '${jsEscape(mood)}',
                                '${place.lat}',
                                '${place.lon}'
                            )">Save Favourite</button>
                            <a class="map-link" target="_blank"
                               href="https://www.openstreetmap.org/?mlat=${place.lat}&mlon=${place.lon}#map=18/${place.lat}/${place.lon}">
                               View Map
                            </a>
                        </div>
                    `;
                    placesList.appendChild(card);
                });
            })
            .catch(error => {
                console.error("Overpass/API Error:", error);
                statusBox.className = "message error";
                statusBox.innerText = "Error fetching places. Check internet, location permission, or try again.";
            });
        },
        function(error) {
            console.error("Geolocation Error:", error);
            statusBox.className = "message error";
            statusBox.innerText = "Location permission denied or unavailable.";
        }
    );
}

function saveFavourite(name, address, mood, lat, lon) {
    fetch("save_favourite.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body:
            "name=" + encodeURIComponent(name) +
            "&address=" + encodeURIComponent(address) +
            "&mood=" + encodeURIComponent(mood) +
            "&latitude=" + encodeURIComponent(lat) +
            "&longitude=" + encodeURIComponent(lon)
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
    })
    .catch(error => {
        alert("Failed to save favourite.");
        console.error(error);
    });
}

function escapeHtml(text) {
    const div = document.createElement("div");
    div.innerText = text;
    return div.innerHTML;
}

function jsEscape(text) {
    return String(text)
        .replace(/\\/g, "\\\\")
        .replace(/'/g, "\\'")
        .replace(/"/g, '\\"')
        .replace(/\n/g, " ");
}