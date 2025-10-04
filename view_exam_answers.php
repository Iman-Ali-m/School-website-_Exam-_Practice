<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.php");
    exit();
}
require 'db.php';
$exam_id = $_GET['exam_id'];
$course_id = $_GET['course_id'];
$stmt = $conn->prepare("SELECT DISTINCT u.UserID, u.FullName FROM StudentAnswers sa JOIN Users u ON sa.StudentID = u.UserID JOIN ExamQuestions eq ON sa.QuestionID = eq.QuestionID WHERE eq.ExamID = ?");
$stmt->execute([$exam_id]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
$answers = [];
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $stmt = $conn->prepare("SELECT sa.AnswerID, eq.QuestionText, sa.AnswerText, sa.Grade FROM StudentAnswers saJOIN ExamQuestions eq ON sa.QuestionID = eq.QuestionIDWHERE sa.StudentID = ? AND eq.ExamID = ?");
    $stmt->execute([$student_id, $exam_id]);
    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مشاهده پاسخ‌های دانشجو</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>مشاهده پاسخ‌های دانشجو</h1>
        <form method="GET" action="view_exam_answers.php">
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
            <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
            <div class="form-group">
                <label for="student_id">انتخاب دانشجو:</label>
                <select id="student_id" name="student_id" required onchange="this.form.submit()">
                    <option value="">-- انتخاب دانشجو --</option>
                    <?php foreach ($students as $student): ?>
                        <option value="<?php echo $student['UserID']; ?>" <?php echo isset($_GET['student_id']) && $_GET['student_id'] == $student['UserID'] ? 'selected' : ''; ?>>
                            <?php echo $student['FullName']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <?php if (!empty($answers)): ?>
            <form action="grade_exam_process.php" method="POST">
                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
                <table>
                    <thead>
                        <tr>
                            <th>سوال</th>
                            <th>پاسخ</th>
                            <th>نمره</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($answers as $answer): ?>
                            <tr>
                                <td><?php echo $answer['QuestionText']; ?></td>
                                <td><?php echo $answer['AnswerText']; ?></td>
                                <td>
                                    <input type="number" name="grades[<?php echo $answer['AnswerID']; ?>]" value="<?php echo $answer['Grade']; ?>" required>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button href="view_student_answers.php?course_id=<?php echo $course_id; ?>" type="submit" class="btn">ذخیره نمرات</button>
            </form>
        <?php endif; ?>
        <a href="view_student_answers.php?course_id=<?php echo $course_id; ?>" class="btn">بازگشت</a>
    </div>
</body>
</html>