<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$stmt = $conn->prepare("SELECT * FROM Courses");
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت دروس</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>مدیریت دروس</h1>
        <a href="add_course.php" class="btn">اضافه کردن درس جدید</a>
        <table>
            <thead>
                <tr>
                    <th>نام درس</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?php echo $course['CourseName']; ?></td>
                        <td>
                            <a href="delete_course.php?course_id=<?php echo $course['CourseID']; ?>" class="btn">حذف</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="staff_dashboard.php" class="btn">بازگشت به داشبورد</a>
    </div>
</body>
</html>