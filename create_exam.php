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
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طراحی امتحان</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>طراحی امتحان</h1>
        <form action="create_exam_process.php" method="POST">
            <div class="form-group">
                <label for="course">انتخاب درس:</label>
                <select id="course" name="course_id" required>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?php echo $course['CourseID']; ?>">
                            <?php echo $course['CourseName']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="exam_name">نام امتحان:</label>
                <input type="text" id="exam_name" name="exam_name" required>
            </div>
            <div class="form-group">
                <label for="start_time">زمان شروع:</label>
                <input type="datetime-local" id="start_time" name="start_time" required>
            </div>
            <div class="form-group">
                <label for="end_time">زمان پایان:</label>
                <input type="datetime-local" id="end_time" name="end_time" required>
            </div>
            <div id="questions">
                <div class="question">
                    <label>سوال 1:</label>
                    <input type="text" name="question_text[]" required>
                    <select name="question_type[]" required onchange="showOptions(this)">
                        <option value="MultipleChoice">گزینه‌ای</option>
                        <option value="TrueFalse">صحیح/غلط</option>
                        <option value="Descriptive">تشریحی</option>
                        <option value="FillInTheBlank">جای خالی</option>
                    </select>
                    <div class="options" style="display: none;">
                        <label>گزینه‌ها:</label>
                        <input type="text" name="option_text[0][]" placeholder="گزینه ۱">
                        <input type="checkbox" name="is_correct[0][]" value="1"> صحیح
                        <input type="text" name="option_text[0][]" placeholder="گزینه ۲">
                        <input type="checkbox" name="is_correct[0][]" value="1"> صحیح
                        <input type="text" name="option_text[0][]" placeholder="گزینه ۳">
                        <input type="checkbox" name="is_correct[0][]" value="1"> صحیح
                        <input type="text" name="option_text[0][]" placeholder="گزینه ۴">
                        <input type="checkbox" name="is_correct[0][]" value="1"> صحیح
                    </div>
                </div>
            </div>
            <button type="button" onclick="addQuestion()" class="btn">افزودن سوال</button>
            <button type="submit" class="btn">ذخیره امتحان</button>
        </form>
        <a href="professor_dashboard.php" class="btn">بازگشت به داشبورد</a>
    </div>
    <script>
        let questionCount = 1;
        function addQuestion() {
            questionCount++;
            const questionsDiv = document.getElementById('questions');
            const newQuestion = document.createElement('div');
            newQuestion.classList.add('question');
            newQuestion.innerHTML = `
                <label>سوال ${questionCount}:</label>
                <input type="text" name="question_text[]" required>
                <select name="question_type[]" required onchange="showOptions(this)">
                    <option value="MultipleChoice">گزینه‌ای</option>
                    <option value="TrueFalse">صحیح/غلط</option>
                    <option value="Descriptive">تشریحی</option>
                    <option value="FillInTheBlank">جای خالی</option>
                </select>
                <div class="options" style="display: none;">
                    <label>گزینه‌ها:</label>
                    <input type="text" name="option_text[${questionCount - 1}][]" placeholder="گزینه ۱">
                    <input type="checkbox" name="is_correct[${questionCount - 1}][]" value="1"> صحیح
                    <input type="text" name="option_text[${questionCount - 1}][]" placeholder="گزینه ۲">
                    <input type="checkbox" name="is_correct[${questionCount - 1}][]" value="1"> صحیح
                    <input type="text" name="option_text[${questionCount - 1}][]" placeholder="گزینه ۳">
                    <input type="checkbox" name="is_correct[${questionCount - 1}][]" value="1"> صحیح
                    <input type="text" name="option_text[${questionCount - 1}][]" placeholder="گزینه ۴">
                    <input type="checkbox" name="is_correct[${questionCount - 1}][]" value="1"> صحیح
                </div>
            `;
            questionsDiv.appendChild(newQuestion);
        }

        function showOptions(select) {
            const optionsDiv = select.parentElement.querySelector('.options');
            if (select.value === 'MultipleChoice') {
                optionsDiv.style.display = 'block';
            } else {
                optionsDiv.style.display = 'none';
            }
        }
    </script>
</body>
</html>