<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'config.php';

if (isset($_POST['register'])) {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $email    = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password_raw = $_POST['password'];

// Password validation
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password_raw)) {
    $error = "Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.";
} else {

    $password = password_hash($password_raw, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if($conn->query($sql)){
        header("Location: login.php");
        exit();
    } else {
        $error = "Registration failed: " . $conn->error;
    }
}

    if ($username == "" || $email == "" || $password_raw == "") {
        $error = "All fields are required.";
    } else {
        $checkSql = "SELECT id FROM users WHERE username='$username' OR email='$email'";
        $checkResult = $conn->query($checkSql);

        if ($checkResult && $checkResult->num_rows > 0) {
            $error = "Username or email already exists.";
        } else {
            $password = password_hash($password_raw, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

            if ($conn->query($sql)) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Registration failed: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>MoodMap - Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<script>
document.querySelector("form").addEventListener("submit", function(e){
    const password = document.querySelector('input[name="password"]').value;

    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    if(!regex.test(password)){
        alert("Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.");
        e.preventDefault();
    }
});
</script>
<body>
<div class="page-center">
    <div class="card-box auth-box">
        <h1>MoodMap</h1>
        <p class="subtitle">Create your account</p>

        <?php if (isset($error)) { ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email address" required>
            <input type="password" name="password" placeholder="Password" required>

<small style="color:#ddd;">
Password must contain:
• 8+ characters  
• Uppercase & lowercase letters  
• Number  
• Special character
</small>
            <button type="submit" name="register">Register</button>
        </form>

        <p class="small-text">Already have an account? <a href="login.php">Login</a>
        <p class="small-text"><a href="about.php">About MoodMap</a></p>
    </div>
</div>
</body>
</html>