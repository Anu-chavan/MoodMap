<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['login'])) {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>MoodMap - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-center">
    <div class="card-box auth-box">
        <h1>MoodMap</h1>
        <p class="subtitle">Mood-based nearby place recommender</p>

        <?php if (isset($error)) { ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>

        <p class="small-text">New user? <a href="register.php">Register</a></p>
        <p class="small-text"><a href="about.php">About MoodMap</a></p>
    </div>
</div>
</body>
</html>