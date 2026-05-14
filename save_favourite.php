<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please login first.";
    exit();
}

if (
    isset($_POST['name']) &&
    isset($_POST['address']) &&
    isset($_POST['mood']) &&
    isset($_POST['latitude']) &&
    isset($_POST['longitude'])
) {
    $user_id = $_SESSION['user_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $mood = mysqli_real_escape_string($conn, $_POST['mood']);
    $latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($conn, $_POST['longitude']);

    $check = "SELECT id FROM favourites 
              WHERE user_id='$user_id' 
              AND place_name='$name' 
              AND latitude='$latitude' 
              AND longitude='$longitude'";
    $checkResult = $conn->query($check);

    if ($checkResult && $checkResult->num_rows > 0) {
        echo "This place is already saved.";
        exit();
    }

    $sql = "INSERT INTO favourites (user_id, place_name, place_address, mood, latitude, longitude)
            VALUES ('$user_id', '$name', '$address', '$mood', '$latitude', '$longitude')";

    if ($conn->query($sql)) {
        echo "Place saved to favourites.";
    } else {
        echo "Save failed: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>