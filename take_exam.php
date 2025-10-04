<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$exam_id = $_GET['exam_id'];
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM StudentAnswers WHERE StudentID = ? AND QuestionID IN (SELECT QuestionID FROM ExamQuestions WHERE ExamID = ?)");
$stmt->execute([$user_id, $exam_id]);
if ($stmt->rowCount() > 0) {
    die("شما قبلاً در این امتحان شرکت کرده‌اید.");
}
$stmt = $conn->prepare("SELECT * FROM ExamQuestions WHERE ExamID = ?");
$stmt->execute([$exam_id]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شرکت در امتحان</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>شرکت در امتحان</h1>
        <form action="submit_exam.php" method="POST">
            <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
            <?php foreach ($questions as $question): ?>
                <div class="form-group">
                    <label><?php echo $question['QuestionText']; ?></label>
                    <?php if ($question['QuestionType'] === 'MultipleChoice'): ?>
                        <?php
                        // دریافت گزینه‌های سوال
                        $stmt = $conn->prepare("SELECT * FROM ExamOptions WHERE QuestionID = ?");
                        $stmt->execute([$question['QuestionID']]);
                        $options = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php foreach ($options as $option): ?>
                            <div>
                                <input type="radio" name="answer[<?php echo $question['QuestionID']; ?>]" value="<?php echo $option['OptionID']; ?>" required>
                                <?php echo $option['OptionText']; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php elseif ($question['QuestionType'] === 'TrueFalse'): ?>
                        <select name="answer[<?php echo $question['QuestionID']; ?>]" required>
                            <option value="true">صحیح</option>
                            <option value="false">غلط</option>
                        </select>
                    <?php else: ?>
                        <textarea name="answer[<?php echo $question['QuestionID']; ?>]" required></textarea>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn">تایید و ارسال</button>
        </form>
        <a href="view_exams.php" class="btn">بازگشت</a>
    </div>
</body>
</html>