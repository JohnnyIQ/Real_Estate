<?php
session_start();
include("db.php");

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = trim($_POST['userName']);
    $contactInfo = trim($_POST['contactInfo']);
    $password = $_POST['password'];
    $userType = $_POST['userType'];

    $check = $conn->prepare("SELECT userId FROM Users WHERE userName = ?");
    $check->bind_param("s", $userName);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "Username already exists.";
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO Users (userName, contactInfo, passwordHash, userType)
                                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $userName, $contactInfo, $passwordHash, $userType);

        if ($stmt->execute()) {
            $success = "Account created! You can now log in.";
        } else {
            $error = "Registration failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: linear-gradient(120deg, #2c3e50, #3498db);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            background: white;
            padding: 30px;
            width: 320px;
            border-radius: 10px;
            box-shadow: 0px 5px 20px rgba(0,0,0,0.3);
            text-align: center;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #3498db;
            color: white;
            border: none;
        }

        .error { color: red; }
        .success { color: green; }
    </style>
</head>

<body>

<div class="box">
    <h2>Register</h2>

    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <?php if ($success) echo "<p class='success'>$success</p>"; ?>

    <form method="POST">
        <input name="userName" placeholder="Username" required>
        <input name="contactInfo" placeholder="Contact Info">
        <input type="password" name="password" placeholder="Password" required>

        <select name="userType">
            <option value="agent">Agent</option>
            <option value="buyer">Buyer</option>
            <option value="renter">Renter</option>
        </select>

        <button>Register</button>
    </form>

    <a href="login.php">Login</a>
</div>

</body>
</html>