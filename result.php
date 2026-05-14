<!DOCTYPE html>
<html>
<head>
<title>MoodMap Result</title>
</head>

<body>

<h1>MoodMap Result</h1>

<?php
$mood = $_GET['mood'];
$radius = $_GET['radius'];

echo "<h3>Your Mood: $mood</h3>";
echo "<h3>Search Radius: $radius meters</h3>";

echo "<h2>Recommended Places</h2>";
<form action="save_favourite.php" method="POST">
<input type="text" name="place" placeholder="Enter place to save">
<button type="submit">Save Favourite</button>
</form>

if($mood == "happy"){
echo "• Parks<br>";
echo "• Shopping Malls<br>";
echo "• Movie Theatres<br>";
}

elseif($mood == "sad"){
echo "• Cafes<br>";
echo "• Beaches<br>";
echo "• Temples<br>";
}

elseif($mood == "stressed"){
echo "• Parks<br>";
echo "• Lakes<br>";
echo "• Gardens<br>";
}

elseif($mood == "hungry"){
echo "• Restaurants<br>";
echo "• Food Courts<br>";
echo "• Street Food Areas<br>";
}
?>

<br><br>

<a href="dashboard.php">Search Again</a>

</body>
</html>