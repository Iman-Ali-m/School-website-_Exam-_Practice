<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT c.CourseID, c.CourseName FROM Enrollments e JOIN Courses c ON e.CourseID = c.CourseID WHERE e.StudentID = ?");
$stmt->execute([$user_id]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ارسال تمرین</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>ارسال تمرین</h1>
        <form action="submit_assignment_process.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="course_id">انتخاب درس:</label>
                <select id="course_id" name="course_id" required>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?php echo $course['CourseID']; ?>">
                            <?php echo $course['CourseName']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="assignment_name">نام تمرین:</label>
                <input type="text" id="assignment_name" name="assignment_name" required>
            </div>
            <div class="form-group">
                <label for="file">فایل تمرین:</label>
                <input type="file" id="file" name="file" required>
            </div>
            <button type="submit" class="btn">ارسال</button>
        </form>
        <a href="student_dashboard.php" class="btn">بازگشت به داشبورد</a>
    </div>
</body>
</html>