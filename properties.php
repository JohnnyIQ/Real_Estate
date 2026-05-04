<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Properties</title>
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

        .search-box {
            text-align: center;
            margin: 20px;
        }

        input {
            padding: 10px;
            margin: 5px;
        }

        button {
            padding: 10px 15px;
            background: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            background: white;
            width: 280px;
            margin: 15px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
        }

        .price {
            color: #27ae60;
            font-weight: bold;
        }

        .status {
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 5px;
            background: #eee;
            display: inline-block;
        }

        .actions a {
            margin-right: 10px;
            font-size: 12px;
        }

        .details-link {
            display: inline-block;
            margin-top: 10px;
            color: #3498db;
            text-decoration: none;
        }

        .details-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="header">
    <h2>Available Properties</h2>
</div>

<div class="search-box">
    <form method="GET">
        <input type="text" name="city" placeholder="City">
        <input type="number" name="max_price" placeholder="Max Price">
        <button type="submit">Search</button>
    </form>
</div>

<div class="container">

<?php

$sql = "SELECT * FROM PropertyListingView WHERE 1=1";

$city = isset($_GET['city']) ? $conn->real_escape_string($_GET['city']) : '';
$price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 0;

if ($city != '') {
    $sql .= " AND city LIKE '%$city%'";
}

if ($price > 0) {
    $sql .= " AND price <= $price";
}

$result = $conn->query($sql);

if (!$result) {
    die($conn->error);
}

while ($row = $result->fetch_assoc()) {
    echo "<div class='card'>";

    if (!empty($row['image']) && file_exists($row['image'])) {
        echo "<img src='" . $row['image'] . "'>";
    } else {
        echo "<img src='https://via.placeholder.com/300x200'>";
    }

    echo "<div class='card-body'>";
    echo "<h3>" . $row['title'] . "</h3>";
    echo "<p>" . $row['city'] . "</p>";
    echo "<p class='price'>$" . $row['price'] . "</p>";
    echo "<span class='status'>" . $row['status'] . "</span>";
    echo "<p>Agent: " . $row['agentName'] . "</p>";

    echo "<a class='details-link' href='property_details.php?id=".$row['propertyId']."'>View Details</a>";

    $userId = $_SESSION['userId'] ?? 0;

    if ($userId) {
        $checkFav = $conn->query("SELECT * FROM Favorites WHERE userId=$userId AND propertyId=".$row['propertyId']);

        if ($checkFav && $checkFav->num_rows > 0) {
            echo "<br><a class='details-link' href='toggle_favorite.php?id=".$row['propertyId']."'>❌ Remove Favorite</a>";
        } else {
            echo "<br><a class='details-link' href='toggle_favorite.php?id=".$row['propertyId']."'>❤️ Save Favorite</a>";
        }
    }

    if (isset($_SESSION['userType']) && $_SESSION['userType'] == 'agent') {
        echo "<div class='actions'>";
        echo "<a href='edit_property.php?id=".$row['propertyId']."'>Edit</a>";
        echo "<a href='delete_property.php?id=".$row['propertyId']."' onclick=\"return confirm('Are you sure you want to delete this property?')\">Delete</a>";
        echo "</div>";
    }

    echo "</div></div>";
}

?>

</div>

</body>
</html>