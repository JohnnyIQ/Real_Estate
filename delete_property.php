<?php
include("db.php");

$id = (int)$_GET['id'];

$conn->query("DELETE FROM Favorites WHERE propertyId=$id");
$conn->query("DELETE FROM Inquiries WHERE propertyId=$id");
$conn->query("DELETE FROM Transactions WHERE propertyId=$id");

$conn->query("DELETE FROM Properties WHERE propertyId=$id");

header("Location: properties.php");
exit;
?>