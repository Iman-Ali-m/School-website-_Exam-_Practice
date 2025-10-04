<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}
require 'db.php';
$stmt_professors = $conn->prepare("SELECT * FROM Users WHERE UserType = 'professor'");
$stmt_professors->execute();
$professors = $stmt_professors->fetchAll(PDO::FETCH_ASSOC);
$stmt_students = $conn->prepare("SELECT * FROM Users WHERE UserType = 'student'");
$stmt_students->execute();
$students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اضافه کردن درس جدید</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>اضافه کردن درس جدید</h1>
        <form action="add_course_process.php" method="POST">
            <div class="form-group">
                <label for="course_name">نام درس:</label>
                <input type="text" id="course_name" name="course_name" required>
            </div>
            <div class="form-group">
                <label for="professor_id">استاد:</label>
                <select id="professor_id" name="professor_id" required>
                    <?php foreach ($professors as $professor): ?>
                        <option value="<?php echo $professor['UserID']; ?>">
                            <?php echo $professor['FullName']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="students">دانشجویان:</label>
                <select id="students" name="students[]" multiple required>
                    <?php foreach ($students as $student): ?>
                        <option value="<?php echo $student['UserID']; ?>">
                            <?php echo $student['FullName']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn">ذخیره</button>
        </form>
        <a href="manage_courses.php" class="btn">بازگشت</a>
    </div>
</body>
</html>