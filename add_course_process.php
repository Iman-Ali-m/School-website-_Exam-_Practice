<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$course_name = $_POST['course_name'];
$professor_id = $_POST['professor_id'];
$students = $_POST['students'];
$stmt = $conn->prepare("INSERT INTO Courses (CourseName, ProfessorID) VALUES (?, ?)");
$stmt->execute([$course_name, $professor_id]);
$course_id = $conn->lastInsertId();
foreach ($students as $student_id) {
    $stmt = $conn->prepare("INSERT INTO Enrollments (StudentID, CourseID) VALUES (?, ?)");
    $stmt->execute([$student_id, $course_id]);
}

header("Location: manage_courses.php");
exit();
