<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT CourseID, CourseName FROM Courses WHERE ProfessorID = ?");
$stmt->execute([$user_id]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
$exams = [];
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $stmt = $conn->prepare("SELECT ExamID, ExamName FROM Exams WHERE CourseID = ?");
    $stmt->execute([$course_id]);
    $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مشاهده پاسخ‌های دانشجویان</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>مشاهده پاسخ‌های دانشجویان</h1>
        <form method="GET" action="view_student_answers.php">
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

        <?php if (!empty($exams)): ?>
            <form method="GET" action="view_exam_answers.php">
                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                <div class="form-group">
                    <label for="exam_id">انتخاب امتحان:</label>
                    <select id="exam_id" name="exam_id" required onchange="this.form.submit()">
                        <option value="">-- انتخاب امتحان --</option>
                        <?php foreach ($exams as $exam): ?>
                            <option value="<?php echo $exam['ExamID']; ?>" <?php echo isset($_GET['exam_id']) && $_GET['exam_id'] == $exam['ExamID'] ? 'selected' : ''; ?>>
                                <?php echo $exam['ExamName']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        <?php endif; ?>
        <a href="professor_dashboard.php" class="btn">بازگشت به داشبورد</a>
    </div>
</body>
</html>