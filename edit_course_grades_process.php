<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$course_id = $_POST['course_id'];
$assignment_grades = $_POST['assignment_grade'];
$exam_grades = $_POST['exam_grade'];
$final_grades = $_POST['final_grade'];
foreach ($assignment_grades as $grade_id => $assignment_grade) {
    $stmt = $conn->prepare("
        UPDATE Grades 
        SET AssignmentGrade = ?, ExamGrade = ?, FinalGrade = ?
        WHERE GradeID = ?
    ");
    $stmt->execute([$assignment_grade, $exam_grades[$grade_id], $final_grades[$grade_id], $grade_id]);
}

header("Location: edit_grades.php");
exit();
