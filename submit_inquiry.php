<?php
session_start();
include("db.php");

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userId = $_SESSION['userId'];
    $propertyId = (int)$_POST['propertyId'];
    $message = $conn->real_escape_string($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO Inquiries (userId, propertyId, message, inquiryDate)
                            VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $userId, $propertyId, $message);
    $stmt->execute();

    header("Location: property_details.php?id=$propertyId&success=1");
    exit();
}
?>