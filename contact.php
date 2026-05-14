<?php
session_start();
include 'config.php';

$success = "";
$error = "";

if(isset($_POST['submit_feedback'])){
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));

    if($name == "" || $email == "" || $message == ""){
        $error = "Please fill in all fields.";
    } else {
        $sql = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')";

        if($conn->query($sql)){
            $success = "Thank you! Your feedback has been submitted successfully.";
        } else {
            $error = "Feedback not saved: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact - MoodMap</title>
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

    <div class="card-box contact-page">
        <h1>Contact / Feedback</h1>
        <p class="subtitle">Share your feedback about MoodMap</p>

        <?php if($success != "") { ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php } ?>

        <?php if($error != "") { ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <label>Your Name</label>
            <input type="text" name="name" placeholder="Enter your name" required>

            <label>Your Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>

            <label>Your Message</label>
            <textarea name="message" placeholder="Write your feedback here..." required></textarea>

            <button type="submit" name="submit_feedback">Submit Feedback</button>
        </form>
    </div>
</div>
</body>
</html>