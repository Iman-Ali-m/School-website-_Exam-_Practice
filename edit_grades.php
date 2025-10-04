<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.php");
    exit();
}
require 'db.php';
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT c.CourseID, c.CourseName 
    FROM Courses c
    WHERE c.ProfessorID = ?
");
$stmt->execute([$user_id]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش نمرات</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>ویرایش نمرات</h1>
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
                            <a href="edit_course_grades.php?course_id=<?php echo $course['CourseID']; ?>" class="btn">ویرایش نمرات</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="professor_dashboard.php" class="btn">بازگشت به داشبورد</a>
    </div>
</body>
</html>