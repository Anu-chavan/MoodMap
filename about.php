<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>About MoodMap</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main-wrapper">

    <!-- Navbar -->
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

    <!-- Hero Section -->
    <div class="card-box about-hero">
        <h1>Discover Places That Match Your Mood</h1>
        <p class="subtitle">
            Feeling happy, calm, or bored? Let MoodMap guide you to the perfect place nearby.
        </p>
    </div>

    <!-- Content Section -->
    <div class="about-grid">

        <div class="card-box about-card">
            <h2>🌟 What is MoodMap?</h2>
            <p>
                MoodMap is your personal guide to finding nearby places based on your current mood.
                Whether you want to relax, explore, or have fun, MoodMap helps you decide where to go.
            </p>
        </div>

        <div class="card-box about-card">
            <h2>😊 How It Works</h2>
            <ul>
                <li>Select your current mood</li>
                <li>Set your preferred distance</li>
                <li>Instantly get nearby place suggestions</li>
                <li>View locations on map</li>
            </ul>
        </div>

        <div class="card-box about-card">
            <h2>💡 Why Use MoodMap?</h2>
            <ul>
                <li>No confusion about where to go</li>
                <li>Discover new places around you</li>
                <li>Quick and easy to use</li>
                <li>Perfect for daily outings</li>
            </ul>
        </div>

        <div class="card-box about-card">
            <h2>❤️ Save Your Favourites</h2>
            <p>
                Like a place? Save it to your favourites and revisit anytime without searching again.
            </p>
        </div>

        <div class="card-box about-card">
            <h2>📍 Explore Nearby</h2>
            <p>
                MoodMap uses your location to recommend places near you, making suggestions relevant and useful.
            </p>
        </div>

        <div class="card-box about-card">
            <h2>🚀 Simple & Fast</h2>
            <p>
                Just choose your mood and get results instantly. No complicated steps.
            </p>
        </div>

    </div>

</div>
</body>
</html>