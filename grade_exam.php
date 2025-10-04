<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("    SELECT CourseID, CourseName   FROM Courses    WHERE ProfessorID = ?");
$stmt->execute([$user_id]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
$students = [];
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $stmt = $conn->prepare("SELECT u.UserID, u.FullName  FROM Enrollments e   JOIN Users u ON e.StudentID = u.UserID  WHERE e.CourseID = ? ");
    $stmt->execute([$course_id]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$answers = [];
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $stmt = $conn->prepare(" SELECT sa.AnswerID, eq.QuestionText, sa.AnswerText, sa.Grade  FROM StudentAnswers sa JOIN ExamQuestions eq ON sa.QuestionID = eq.QuestionID JOIN Exams e ON eq.ExamID = e.ExamID  WHERE sa.StudentID = ? AND e.CourseID = ?");
    $stmt->execute([$student_id, $course_id]);
    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تصحیح امتحان</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>تصحیح امتحان</h1>
        <form method="GET" action="grade_exam.php">
            <div class="form-group">
                <label for="course_id">انتخاب درس:</label>
                <select id="course_id" name="course_id" required onchange="this.form.submit()">
                    <option value="">-- انتخاب درس --</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?php echo $course['CourseID']; ?>" <?php echo isset($_GET['course_id']) && $_GET['course_id'] == $course['CourseID'] ? 'selected' : ''; ?>>
                            <?php echo $course['CourseName']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <?php if (!empty($students)): ?>
            <form method="GET" action="grade_exam.php">
                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
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
        <?php endif; ?>

        <?php if (!empty($answers)): ?>
            <form action="grade_exam_process.php" method="POST">
                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
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
                <button type="submit" class="btn">ذخیره نمرات</button>
            </form>
        <?php endif; ?>
        <a href="professor_dashboard.php" class="btn">بازگشت به داشبورد</a>
    </div>
</body>
</html>