<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$submission_id = $_POST['submission_id'];
$grade = $_POST['grade'];
$stmt = $conn->prepare("
    UPDATE AssignmentSubmissions 
    SET Grade = ?
    WHERE SubmissionID = ?
");
$stmt->execute([$grade, $submission_id]);

header("Location: view_student_assignments.php");
exit();
