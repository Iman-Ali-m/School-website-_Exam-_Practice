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
    <title>اضافه کردن کاربر جدید</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>اضافه کردن کاربر جدید</h1>
        <form action="add_user_process.php" method="POST">
            <div class="form-group">
                <label for="username">نام کاربری:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">رمز عبور:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="fullname">نام کامل:</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="email">ایمیل:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="user_type">نقش:</label>
                <select id="user_type" name="user_type" required>
                    <option value="student">دانشجو</option>
                    <option value="professor">استاد</option>
                </select>
            </div>
            <button type="submit" class="btn">ذخیره</button>
        </form>
        <a href="manage_users.php" class="btn">بازگشت</a>
    </div>
</body>
</html>