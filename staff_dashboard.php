<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}

require 'db.php';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد پرسنل آموزشی</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>داشبورد پرسنل آموزشی</h1>
        <nav>
            <a href="manage_courses.php" class="btn">مدیریت دروس</a>
            <a href="manage_users.php" class="btn">مدیریت کاربران</a>
            <a href="logout.php" class="btn">خروج</a>
        </nav>
    </div>
</body>
</html>