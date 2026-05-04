<?php
session_start();
include("db.php");

if (!isset($_SESSION['userType']) || $_SESSION['userType'] != "agent") {
    die("Access denied");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $type = $_POST['type'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $price = $_POST['price'];
    $agentId = $_SESSION['userId'];

    $imageName = "";

    if (!empty($_FILES['image']['name'])) {
        $imageName = "images/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imageName);
    }

    $conn->query("INSERT INTO Properties (title, propertyType, address, city, price, image, agentId)
    VALUES ('$title','$type','$address','$city','$price','$imageName','$agentId')");

    header("Location: properties.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Property</title>
</head>
<body>

<h2>Add Property</h2>

<form method="POST" enctype="multipart/form-data">
    <input name="title" placeholder="Title" required><br><br>
    <input name="type" placeholder="Type" required><br><br>
    <input name="address" placeholder="Address" required><br><br>
    <input name="city" placeholder="City" required><br><br>
    <input name="price" placeholder="Price" required><br><br>

    <input type="file" name="image"><br><br>

    <button type="submit">Add Property</button>
</form>

<br>
<a href="properties.php">Back to Properties</a>

</body>
</html>