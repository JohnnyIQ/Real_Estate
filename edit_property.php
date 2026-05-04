<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

if (!isset($_SESSION['userType']) || $_SESSION['userType'] != "agent") {
    die("Access denied");
}

if (!isset($_GET['id'])) {
    die("Property not found.");
}

$id = (int)$_GET['id'];

$result = $conn->query("SELECT * FROM Properties WHERE propertyId = $id");

if (!$result || $result->num_rows == 0) {
    die("Property not found.");
}

$property = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $type = $conn->real_escape_string($_POST['propertyType']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $price = (float)$_POST['price'];
    $status = $conn->real_escape_string($_POST['status']);

    $imageName = $property['image'];

    if (!empty($_FILES['image']['name'])) {
        $imageName = "images/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imageName);
    }

    $sql = "UPDATE Properties 
            SET title='$title',
                propertyType='$type',
                address='$address',
                city='$city',
                price=$price,
                status='$status',
                image='$imageName'
            WHERE propertyId=$id";

    if ($conn->query($sql)) {
        header("Location: properties.php");
        exit();
    } else {
        echo "Update failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Property</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f4f6f9;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .form-box {
            width: 400px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }

        img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            margin-bottom: 10px;
            border-radius: 6px;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Edit Property</h2>
</div>

<div class="form-box">

    <?php if (!empty($property['image'])) { ?>
        <img src="<?php echo $property['image']; ?>">
    <?php } ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" value="<?php echo $property['title']; ?>" required>

        <input type="text" name="propertyType" value="<?php echo $property['propertyType']; ?>" required>

        <input type="text" name="address" value="<?php echo $property['address']; ?>" required>

        <input type="text" name="city" value="<?php echo $property['city']; ?>" required>

        <input type="number" step="0.01" name="price" value="<?php echo $property['price']; ?>" required>

        <select name="status">
            <option value="available" <?php if ($property['status'] == 'available') echo 'selected'; ?>>Available</option>
            <option value="sold" <?php if ($property['status'] == 'sold') echo 'selected'; ?>>Sold</option>
            <option value="rented" <?php if ($property['status'] == 'rented') echo 'selected'; ?>>Rented</option>
        </select>

        <input type="file" name="image">

        <button type="submit">Update Property</button>
    </form>

    <a href="properties.php">Back to Properties</a>

</div>

</body>
</html>