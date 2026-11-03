<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$user_id=$_SESSION['user_id'];
$stmt=$conn->prepare("SELECT asub.SubmissionID, asub.AssignmentName, c.CourseName, u.FullName, asub.SubmissionFile, asub.Grade FROM AssignmentSubmissions asubJOIN Courses c ON asub.CourseID = c.CourseIDJOIN Users u ON asub.StudentID = u.UserIDWHERE c.ProfessorID = ?");
$stmt->execute([$user_id]);
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مشاهده تمرین‌های دانشجویان</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>تمرین‌های دانشجویان</h1>
        <table>
            <thead>
                <tr>
                    <th>نام درس</th>
                    <th>نام دانشجو</th>
                    <th>نام تمرین</th>
                    <th>فایل تمرین</th>
                    <th>نمره</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assignments as $assignment): ?>
                    <tr>
                        <td><?php echo $assignment['CourseName']; ?></td>
                        <td><?php echo $assignment['FullName']; ?></td>
                        <td><?php echo $assignment['AssignmentName']; ?></td>
                        <td><a href="<?php echo $assignment['SubmissionFile']; ?>" target="_blank">دانلود</a></td>
                        <td><?php echo $assignment['Grade'] ?? 'بدون نمره'; ?></td>
                        <td>
                            <a href="grade_assignment.php?submission_id=<?php echo $assignment['SubmissionID']; ?>" class="btn">نمره‌دهی</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="professor_dashboard.php" class="btn">بازگشت به داشبورد</a>
    </div>
</body>
</html>
