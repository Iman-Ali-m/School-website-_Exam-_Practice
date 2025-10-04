<?php
session_start();
require 'db.php';

$role = $_POST['role'];
$fullname = $_POST['fullname'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$email = $_POST['email'];

if ($role === 'staff') {
    $fixed_code = $_POST['fixed_code'];
    $stmt = $conn->prepare("SELECT * FROM FixedCodes WHERE FixedCode = ?");
    $stmt->execute([$fixed_code]);
    if ($stmt->rowCount() === 0) {
        die("کد ثابت نامعتبر است.");
    }
}

$stmt = $conn->prepare("INSERT INTO Users (Username, Password, FullName, Email, UserType) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$username, $password, $fullname, $email, $role]);

header("Location: login.php?role=$role");
exit();
