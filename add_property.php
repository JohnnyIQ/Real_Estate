<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

if (!isset($_SESSION['userType']) || $_SESSION['userType'] != "agent") {
    die("Access denied");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $conn->real_escape_string($_POST['title']);
    $type = $conn->real_escape_string($_POST['type']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $price = (float)$_POST['price'];
    $status = $conn->real_escape_string($_POST['status']);
    $agentId = $_SESSION['userId'];

    $imageName = "";

    if (!empty($_FILES['image']['name'])) {
        $imageName = "images/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imageName);
    }

    $stmt = $conn->prepare("INSERT INTO Properties (title, propertyType, address, city, price, status, image, agentId)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdssi", $title, $type, $address, $city, $price, $status, $imageName, $agentId);
    $stmt->execute();

    header("Location: properties.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Property</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f4f6f9;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 18px;
            text-align: center;
        }

        .form-container {
            width: 450px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 2px 12px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 12px;
        }

        input, select {
            width: 100%;
            padding: 11px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #2980b9;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>Add New Property</h1>
</div>

<div class="form-container">
    <h2>Property Information</h2>

    <form method="POST" enctype="multipart/form-data">
        <label>Title</label>
        <input name="title" placeholder="Example: Modern Downtown Loft" required>

        <label>Property Type</label>
        <input name="type" placeholder="Apartment, House, Condo..." required>

        <label>Address</label>
        <input name="address" placeholder="Street address" required>

        <label>City</label>
        <input name="city" placeholder="City" required>

        <label>Price</label>
        <input type="number" step="0.01" name="price" placeholder="Price" required>

        <label>Status</label>
        <select name="status">
            <option value="available">Available</option>
            <option value="sold">Sold</option>
            <option value="rented">Rented</option>
        </select>

        <label>Property Image</label>
        <input type="file" name="image">

        <button type="submit">Add Property</button>
    </form>

    <a class="back-link" href="properties.php">Back to Properties</a>
</div>

</body>
</html>