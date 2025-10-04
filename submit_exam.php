<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$user_id = $_SESSION['user_id'];
$exam_id = $_POST['exam_id'];
$answers = $_POST['answer'];

foreach ($answers as $question_id => $answer) {
    $stmt = $conn->prepare("INSERT INTO StudentAnswers (QuestionID, StudentID, AnswerText) VALUES (?, ?, ?)");
    $stmt->execute([$question_id, $user_id, $answer]);
}
header("Location: student_dashboard.php");
exit();
