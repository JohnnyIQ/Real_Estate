<?php
session_start();
include("db.php");

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Property not found.");
}

$userId = $_SESSION['userId'];
$propertyId = (int)$_GET['id'];

$check = $conn->query("SELECT * FROM Favorites WHERE userId=$userId AND propertyId=$propertyId");

if ($check->num_rows == 0) {
    $conn->query("INSERT INTO Favorites (userId, propertyId, savedDate)
                  VALUES ($userId, $propertyId, NOW())");
}

header("Location: favorites.php");
exit();
?>