<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT e.ExamID, e.ExamName, c.CourseName FROM Exams eJOIN Courses c ON e.CourseID = c.CourseIDJOIN Enrollments en ON c.CourseID = en.CourseIDWHERE en.StudentID = ? AND e.EndTime > NOW()");
$stmt->execute([$user_id]);
$exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>امتحانات</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>امتحانات</h1>
        <table>
            <thead>
                <tr>
                    <th>نام درس</th>
                    <th>نام امتحان</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exams as $exam): ?>
                    <tr>
                        <td><?php echo $exam['CourseName']; ?></td>
                        <td><?php echo $exam['ExamName']; ?></td>
                        <td>
                            <a href="take_exam.php?exam_id=<?php echo $exam['ExamID']; ?>" class="btn">شرکت در امتحان</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="student_dashboard.php" class="btn">بازگشت به داشبورد</a>
    </div>
</body>
</html>