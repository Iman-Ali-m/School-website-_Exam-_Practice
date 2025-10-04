<?php
session_start();
require 'db.php';

$role = $_POST['role'];
$username = $_POST['username'];
$password = $_POST['password'];
$stmt = $conn->prepare("SELECT * FROM Users WHERE Username = ? AND UserType = ?");
$stmt->execute([$username, $role]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['Password'])) {
    $_SESSION['user_id'] = $user['UserID'];
    $_SESSION['role'] = $role;
    switch ($role) {
        case 'student':
            header("Location: student_dashboard.php");
            break;
        case 'professor':
            header("Location: professor_dashboard.php");
            break;
        case 'staff':
            header("Location: staff_dashboard.php");
            break;
        default:
            die("نقش کاربر نامعتبر است.");
    }
    exit();
} else {
    die("نام کاربری یا رمز عبور اشتباه است.");
}
