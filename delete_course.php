<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$course_id = $_GET['course_id'];
$stmt = $conn->prepare("DELETE FROM Courses WHERE CourseID = ?");
$stmt->execute([$course_id]);

header("Location: manage_courses.php");
exit();
