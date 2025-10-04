<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}
require 'db.php';
$user_id = $_GET['user_id'];
$stmt = $conn->prepare("DELETE FROM Users WHERE UserID = ?");
$stmt->execute([$user_id]);
header("Location: manage_users.php");
exit();
