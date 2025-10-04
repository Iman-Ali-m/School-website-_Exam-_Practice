<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT c.CourseName, g.ExamGrade, g.AssignmentGrade, g.TotalGrade FROM Grades g JOIN Courses c ON g.CourseID = c.CourseID WHERE g.StudentID = ?");
$stmt->execute([$user_id]);
$grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد دانشجو</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>داشبورد دانشجو</h1>
        <nav>
            <a href="view_courses.php" class="btn">دروس ثبت‌نام‌شده</a>
            <a href="submit_assignment.php" class="btn">ارسال تمرین</a>
            <a href="view_exams.php" class="btn">امتحانات</a>
            <a href="view_grades.php" class="btn">مشاهده نمرات</a>
            <a href="logout.php" class="btn">خروج</a>
        </nav>
        <h2>نمرات شما</h2>
        <table>
            <thead>
                <tr>
                    <th>نام درس</th>
                    <th>نمره امتحان</th>
                    <th>نمره تمرین</th>
                    <th>نمره کل</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($grades)): ?>
                    <?php foreach ($grades as $grade): ?>
                        <tr>
                            <td><?php echo $grade['CourseName']; ?></td>
                            <td><?php echo $grade['ExamGrade']; ?></td>
                            <td><?php echo $grade['AssignmentGrade']; ?></td>
                            <td><?php echo $grade['TotalGrade']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">هنوز نمره‌ای ثبت نشده است.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>