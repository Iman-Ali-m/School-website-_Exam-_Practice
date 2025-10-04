<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.php");
    exit();
}
require 'db.php';
$submission_id = $_GET['submission_id'];
$stmt = $conn->prepare("SELECT asub.SubmissionFile, asub.Grade FROM AssignmentSubmissions asubWHERE asub.SubmissionID = ?");
$stmt->execute([$submission_id]);
$assignment = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش نمره تمرین</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>ویرایش نمره تمرین</h1>
        <form action="edit_assignment_grade_process.php" method="POST">
            <input type="hidden" name="submission_id" value="<?php echo $submission_id; ?>">
            <div class="form-group">
                <label>فایل تمرین:</label>
                <p><a href="<?php echo $assignment['SubmissionFile']; ?>" target="_blank">دانلود</a></p>
            </div>
            <div class="form-group">
                <label for="grade">نمره:</label>
                <input type="number" id="grade" name="grade" value="<?php echo $assignment['Grade']; ?>" required>
            </div>
            <button type="submit" class="btn">ذخیره</button>
        </form>
        <a href="view_student_assignments.php" class="btn">بازگشت</a>
    </div>
</body>
</html>