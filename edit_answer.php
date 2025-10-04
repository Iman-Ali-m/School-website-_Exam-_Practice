<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.php");
    exit();
}
require 'db.php';
$answer_id = $_GET['answer_id'];
$stmt = $conn->prepare("
    SELECT sa.AnswerText, sa.Grade, eq.ExamID 
    FROM StudentAnswers sa
    JOIN ExamQuestions eq ON sa.QuestionID = eq.QuestionID
    WHERE sa.AnswerID = ?
");
$stmt->execute([$answer_id]);
$answer = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$answer) {
    die("پاسخ مورد نظر یافت نشد.");
}
$exam_id = $answer['ExamID']; // دریافت exam_id از پاسخ دانشجو
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش نمره</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>ویرایش نمره</h1>
        <form action="edit_answer_process.php" method="POST">
            <input type="hidden" name="answer_id" value="<?php echo $answer_id; ?>">
            <div class="form-group">
                <label>پاسخ دانشجو:</label>
                <p><?php echo $answer['AnswerText']; ?></p>
            </div>
            <div class="form-group">
                <label for="grade">نمره:</label>
                <input type="number" id="grade" name="grade" value="<?php echo $answer['Grade']; ?>" required>
            </div>
            <button type="submit" class="btn">ذخیره</button>
        </form>
        <a href="view_exam_answers.php?exam_id=<?php echo $exam_id; ?>" class="btn">بازگشت</a>
    </div>
</body>
</html>