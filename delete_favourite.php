<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $sql = "DELETE FROM favourites WHERE id='$id' AND user_id='$user_id'";
    $conn->query($sql);
}

header("Location: favourites.php");
exit();
?>