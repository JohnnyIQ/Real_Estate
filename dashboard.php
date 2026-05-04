<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
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
            text-align: center;
            margin-top: 40px;
        }

        .card {
            display: inline-block;
            background: white;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }

        a {
            display: block;
            margin: 10px;
            text-decoration: none;
            color: #3498db;
        }
    </style>
</head>

<body>

<div class="header">
    <h2>Dashboard</h2>
</div>

<div class="container">

    <div class="card">
        <h3>Welcome, <?php echo $_SESSION['userName']; ?></h3>
        <p>Role: <?php echo $_SESSION['userType']; ?></p>
    </div>

    <div class="card">
        <a href="properties.php">Browse Properties</a>
        <a href="favorites.php">My Favorites</a>

        <?php if ($_SESSION['userType'] == "agent") { ?>
            <a href="add_property.php">Add Property</a>
        <?php } ?>

        <a href="logout.php">Logout</a>
    </div>

</div>

</body>
</html>