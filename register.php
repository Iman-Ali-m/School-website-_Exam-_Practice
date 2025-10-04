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
    <title>ثبت‌نام</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>ثبت‌نام (<?php echo $role; ?>)</h1>
        <form action="register_process.php" method="POST">
            <input type="hidden" name="role" value="<?php echo $role; ?>">
            <div class="form-group">
                <label for="fullname">نام کامل:</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="username">نام کاربری:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">رمز عبور:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="email">ایمیل:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <?php if ($role === 'staff'): ?>
                <div class="form-group">
                    <label for="fixed_code">کد ثابت:</label>
                    <input type="text" id="fixed_code" name="fixed_code" required>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn">ثبت‌نام</button>
        </form>
    </div>
</body>
</html>