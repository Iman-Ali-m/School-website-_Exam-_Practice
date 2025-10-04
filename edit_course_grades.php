<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.php");
    exit();
}
require 'db.php';
$course_id = $_GET['course_id'];
$stmt = $conn->prepare("
    SELECT u.FullName, g.GradeID, g.AssignmentGrade, g.ExamGrade, g.FinalGrade 
    FROM Grades g
    JOIN Users u ON g.StudentID = u.UserID
    WHERE g.CourseID = ?
");
$stmt->execute([$course_id]);
$grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش نمرات درس</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>ویرایش نمرات درس</h1>
        <form action="edit_course_grades_process.php" method="POST">
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
            <table>
                <thead>
                    <tr>
                        <th>نام دانشجو</th>
                        <th>نمره تمرین</th>
                        <th>نمره امتحان</th>
                        <th>نمره نهایی</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($grades as $grade): ?>
                        <tr>
                            <td><?php echo $grade['FullName']; ?></td>
                            <td>
                                <input type="number" name="assignment_grade[<?php echo $grade['GradeID']; ?>]" value="<?php echo $grade['AssignmentGrade']; ?>">
                            </td>
                            <td>
                                <input type="number" name="exam_grade[<?php echo $grade['GradeID']; ?>]" value="<?php echo $grade['ExamGrade']; ?>">
                            </td>
                            <td>
                                <input type="number" name="final_grade[<?php echo $grade['GradeID']; ?>]" value="<?php echo $grade['FinalGrade']; ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn">ذخیره تغییرات</button>
        </form>
        <a href="edit_grades.php" class="btn">بازگشت</a>
    </div>
</body>
</html>