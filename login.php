<?php
session_start();
require 'db.php';

$role = $_GET['role'] ?? ''; 
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به سیستم</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>ورود به سیستم (<?php echo $role; ?>)</h1>
        <form action="authenticate.php" method="POST">
            <input type="hidden" name="role" value="<?php echo $role; ?>">
            <div class="form-group">
                <label for="username">نام کاربری:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">رمز عبور:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">ورود</button>
        </form>
        <p>اگر ثبت‌نام نکرده‌اید، <a href="register.php?role=<?php echo $role; ?>">ثبت‌نام کنید</a>.</p>
    </div>
</body>
</html>