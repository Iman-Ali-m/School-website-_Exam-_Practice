<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}
require 'db.php';
$user_id = $_SESSION['user_id'];
$course_id = $_POST['course_id'];
$assignment_name = $_POST['assignment_name'];

$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true); 
}
$target_file = $target_dir . basename($_FILES['file']['name']);

if (file_exists($target_file)) {
    die("فایلی با این نام قبلاً آپلود شده است.");
}
if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
    $stmt = $conn->prepare("INSERT INTO AssignmentSubmissions (CourseID, StudentID, AssignmentName, SubmissionFile) VALUES (?, ?, ?, ?)");
    $stmt->execute([$course_id, $user_id, $assignment_name, $target_file]);
    header("Location: student_dashboard.php");
    exit();
} else {
    die("خطا در آپلود فایل. لطفاً دوباره تلاش کنید.");
}
