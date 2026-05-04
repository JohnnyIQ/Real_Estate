<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Real Estate Portal</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f4f6f9;
        }

        .navbar {
            background: #2c3e50;
            padding: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            margin-left: 10px;
            text-decoration: none;
        }

        .hero {
            text-align: center;
            padding: 80px 20px;
            background: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa') no-repeat center;
            background-size: cover;
            color: white;
        }

        .hero h1 {
            font-size: 40px;
        }

        .buttons a {
            display: inline-block;
            margin: 10px;
            padding: 12px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .buttons a:hover {
            background: #2980b9;
        }

        .section {
            padding: 40px;
            text-align: center;
        }

        .card {
            display: inline-block;
            width: 250px;
            margin: 10px;
            padding: 15px;
            background: white;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
    </style>
</head>

<body>

<div class="navbar">
    <div><b>Real Estate Portal</b></div>

    <div>
        <a href="properties.php">Properties</a>

        <?php if (isset($_SESSION['userId'])) { ?>
            <a href="favorites.php">Favorites</a>

            <?php if ($_SESSION['userType'] == 'agent') { ?>
                <a href="add_property.php">Add Property</a>
            <?php } ?>

            <a href="logout.php">Logout</a>
        <?php } else { ?>
            <a href="login.php">Login</a>
        <?php } ?>
    </div>
</div>

<div class="hero">
    <h1>Find Your Dream Property</h1>
    <p>Buy, Rent, or Sell Properties Easily</p>

    <div class="buttons">
        <a href="properties.php">Browse Properties</a>

        <?php if (isset($_SESSION['userId']) && $_SESSION['userType'] == 'agent') { ?>
            <a href="add_property.php">Add Property</a>
        <?php } ?>

        <?php if (!isset($_SESSION['userId'])) { ?>
            <a href="login.php">Login</a>
        <?php } ?>
    </div>
</div>

<div class="section">
    <h2>Why Choose Us?</h2>

    <div class="card">
        <h3>Verified Listings</h3>
        <p>All properties are verified by agents.</p>
    </div>

    <div class="card">
        <h3>Easy Search</h3>
        <p>Filter by city, price, and type.</p>
    </div>

    <div class="card">
        <h3>Fast Deals</h3>
        <p>Buy or rent properties quickly.</p>
    </div>
</div>

</body>
</html>