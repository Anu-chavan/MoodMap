<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM favourites WHERE user_id='$user_id' ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Favourites - MoodMap</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>
<body>
<div class="navbar">
    <h2 class="logo">MoodMap</h2>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="favourites.php">Favourites</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="logout.php">Logout</a>
    </div>
</div>
<div class="main-wrapper">
    <div class="topbar">
        <div class="brand">MoodMap</div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="favourites.php">Favourites</a>
            <a href="about.php">About</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="card-box">
        <h2>Your Favourite Places</h2>

        <div class="places-grid">
            <?php if ($result && $result->num_rows > 0) { ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="place-card">
                        <h3><?php echo htmlspecialchars($row['place_name']); ?></h3>
                        <p><strong>Mood:</strong> <?php echo htmlspecialchars($row['mood']); ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($row['place_address']); ?></p>
                        <p><strong>Saved on:</strong> <?php echo htmlspecialchars($row['created_at']); ?></p>

                        <div class="card-actions">
                            <a class="map-link" target="_blank"
                               href="https://www.openstreetmap.org/?mlat=<?php echo $row['latitude']; ?>&mlon=<?php echo $row['longitude']; ?>#map=18/<?php echo $row['latitude']; ?>/<?php echo $row['longitude']; ?>">
                               View Map
                            </a>

                            <a class="danger-link"
                               href="delete_favourite.php?id=<?php echo $row['id']; ?>"
                               onclick="return confirm('Delete this favourite place?')">
                               Delete
                            </a>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="message info">No favourite places saved yet.</div>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>