<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد استاد</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>داشبورد استاد</h1>
        <nav>
            <a href="create_exam.php" class="btn">طراحی امتحان</a>
            <a href="view_student_answers.php" class="btn">مشاهده پاسخ‌های دانشجویان</a>
            <a href="view_student_assignments.php" class="btn">مشاهده تمرین‌های دانشجویان</a>
            <a href="edit_grades.php" class="btn">ویرایش نمرات</a>
            <a href="logout.php" class="btn">خروج</a>
        </nav>
    </div>
</body>
</html>