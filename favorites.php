<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];

$result = $conn->query("
    SELECT p.*
    FROM Favorites f
    JOIN Properties p ON f.propertyId = p.propertyId
    WHERE f.userId = $userId
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Favorites</title>
</head>
<body>

<h2>My Favorite Properties</h2>

<a href="properties.php">Back to Properties</a><br><br>

<?php
if (!$result || $result->num_rows == 0) {
    echo "No favorites saved.";
}

while ($row = $result->fetch_assoc()) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";

    if (!empty($row['image'])) {
        echo "<img src='" . $row['image'] . "' width='200'><br>";
    }

    echo "<b>" . $row['title'] . "</b><br>";
    echo $row['city'] . "<br>";
    echo "$" . $row['price'] . "<br>";
    echo "<a href='property_details.php?id=".$row['propertyId']."'>View Details</a>";

    echo "</div>";
}
?>

</body>
</html>