<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

if (!isset($_GET['id'])) {
    die("Property not found.");
}

$id = (int)$_GET['id'];

$sql = "SELECT * FROM PropertyListingView WHERE propertyId = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("Property not found.");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Property Details</title>
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

        .container {
            width: 80%;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }

        img {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            border-radius: 10px;
        }

        .price {
            color: #27ae60;
            font-size: 24px;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background: #2980b9;
        }

        textarea {
            width: 100%;
            height: 100px;
            margin-top: 15px;
            padding: 10px;
        }
    </style>
</head>

<body>

<div class="header">
    <h2>Property Details</h2>
</div>

<div class="container">

    <?php
    if (!empty($row['image'])) {
        echo "<img src='" . $row['image'] . "'>";
    }
    ?>

    <h1><?php echo $row['title']; ?></h1>

    <p class="price">$<?php echo $row['price']; ?></p>

    <p><b>Type:</b> <?php echo $row['propertyType']; ?></p>
    <p><b>City:</b> <?php echo $row['city']; ?></p>
    <p><b>Status:</b> <?php echo $row['status']; ?></p>
    <p><b>Agent:</b> <?php echo $row['agentName']; ?></p>

    <!-- INQUIRY SECTION -->
    <?php if (isset($_SESSION['userId'])) { ?>
        <form method="POST" action="submit_inquiry.php">
            <input type="hidden" name="propertyId" value="<?php echo $row['propertyId']; ?>">
            <textarea name="message" placeholder="Enter your inquiry message..." required></textarea>
            <button class="btn" type="submit">Submit Inquiry</button>
        </form>
    <?php } else { ?>
        <a class="btn" href="login.php">Login to Submit Inquiry</a>
    <?php } ?>

    <br>
    <a class="btn" href="properties.php">Back to Properties</a>

</div>

</body>
</html>