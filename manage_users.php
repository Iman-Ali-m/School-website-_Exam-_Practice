<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$stmt = $conn->prepare("SELECT * FROM Users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت کاربران</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>مدیریت کاربران</h1>
        <a href="add_user.php" class="btn">اضافه کردن کاربر جدید</a>
        <table>
            <thead>
                <tr>
                    <th>نام کاربری</th>
                    <th>نام کامل</th>
                    <th>نقش</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['Username']; ?></td>
                        <td><?php echo $user['FullName']; ?></td>
                        <td><?php echo $user['UserType']; ?></td>
                        <td>
                            <a href="delete_user.php?user_id=<?php echo $user['UserID']; ?>" class="btn">حذف</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="staff_dashboard.php" class="btn">بازگشت به داشبورد</a>
    </div>
</body>
</html>