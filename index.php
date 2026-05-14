<?php
session_start();

// If user already logged in → go to dashboard
if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>MoodMap - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-wrapper">

    <div class="topbar">
        <div class="brand">MoodMap</div>
        <div class="nav-links">
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
        </div>
    </div>

    <section class="landing-hero">
        <div class="landing-left">
            <span class="badge">Mood Based Nearby Place Recommender</span>
            <h1>Find the right place for the way you feel.</h1>
            <p>
                MoodMap helps you discover nearby places based on your mood, your location,
                and how far you want to explore. From parks and cafes to libraries and restaurants,
                your next destination is just one click away.
            </p>

            <div class="hero-btns">
                <?php if(isset($_SESSION['user_id'])){ ?>
    <a href="dashboard.php" class="hero-btn primary-btn">Go to Dashboard</a>
<?php } else { ?>
    <a href="register.php" class="hero-btn primary-btn">Get Started</a>
    <a href="login.php" class="hero-btn secondary-btn">Login</a>
<?php } ?>
            </div>
        </div>

        <div class="landing-right">
            <div class="hero-card floating-card card-one">
                <h3>😊 Happy</h3>
                <p>Parks, cafes and fun places nearby</p>
            </div>

            <div class="hero-card floating-card card-two">
                <h3>😌 Calm</h3>
                <p>Find peaceful libraries and green spaces</p>
            </div>

            <div class="hero-card floating-card card-three">
                <h3>🍔 Hungry</h3>
                <p>Discover restaurants and cafes around you</p>
            </div>
        </div>
    </section>

    <section class="home-features">
        <div class="card-box home-feature-card">
            <div class="feature-icon">📍</div>
            <h2>Nearby Recommendations</h2>
            <p>Get place suggestions around your current location within your selected radius.</p>
        </div>

        <div class="card-box home-feature-card">
            <div class="feature-icon">🎭</div>
            <h2>Mood Based Search</h2>
            <p>Choose your mood and let MoodMap recommend places that match how you feel.</p>
        </div>

        <div class="card-box home-feature-card">
            <div class="feature-icon">❤️</div>
            <h2>Save Favourites</h2>
            <p>Keep your favorite places saved so you can revisit them anytime.</p>
        </div>
    </section>

    <section class="how-it-works">
        <div class="section-title">
            <h2>How It Works</h2>
            <p>Simple steps to discover your next place</p>
        </div>

        <div class="steps-grid">
            <div class="card-box step-card">
                <div class="step-number">1</div>
                <h3>Select Your Mood</h3>
                <p>Choose how you are feeling right now.</p>
            </div>

            <div class="card-box step-card">
                <div class="step-number">2</div>
                <h3>Choose Radius</h3>
                <p>Set how far you want to search nearby places.</p>
            </div>

            <div class="card-box step-card">
                <div class="step-number">3</div>
                <h3>Explore Results</h3>
                <p>View places, open map links, and save favourites.</p>
            </div>
        </div>
    </section>

</div>

</body>
</html>