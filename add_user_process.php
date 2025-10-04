<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}
require 'db.php';
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$user_type = $_POST['user_type'];
$stmt = $conn->prepare("INSERT INTO Users (Username, Password, FullName, Email, UserType) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$username, $password, $fullname, $email, $user_type]);

header("Location: manage_users.php");
exit();
