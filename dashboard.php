<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>MoodMap Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main-wrapper">
    <div class="topbar">
        <div class="brand">MoodMap</div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="favourites.php">Favourites</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="dashboard-layout">
        <div class="card-box search-panel">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
            <h1>Mood Based Nearby Place Recommender</h1>
            <p>Select your mood and discover places around you.</p>
            <p class="subtitle">Find nearby places based on your mood</p>

            <label for="mood">Select Mood</label>
            <select id="mood">
                <option value="happy">Happy</option>
                <option value="sad">Sad</option>
                <option value="excited">Excited</option>
                <option value="calm">Calm</option>
                <option value="hungry">Hungry</option>
                <option value="spiritual">Spiritual</option>
            </select>

            <label for="radius">Radius (in meters)</label>
            <input type="number" id="radius" value="5000" min="100" max="10000">

            <button onclick="getNearbyPlaces()">Search Places</button>

            <div class="note">
                Allow location access when browser asks for permission.
            </div>
        </div>

        <div class="card-box results-panel">
            <div id="statusMessage" class="message info">Search results will appear here.</div>
            <div id="placesList" class="places-grid"></div>
        </div>
    </div>
</div>

<script src="script.js?v=3"></script>
</body>
</html>
