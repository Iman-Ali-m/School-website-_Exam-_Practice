<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.php");
    exit();
}
require 'db.php';
$answer_id = $_POST['answer_id'];
$grade = $_POST['grade'];
$stmt = $conn->prepare("
    UPDATE StudentAnswers 
    SET Grade = ?
    WHERE AnswerID = ?
");
$stmt->execute([$grade, $answer_id]);
$stmt = $conn->prepare("
    SELECT eq.ExamID 
    FROM StudentAnswers sa
    JOIN ExamQuestions eq ON sa.QuestionID = eq.QuestionID
    WHERE sa.AnswerID = ?
");
$stmt->execute([$answer_id]);
$exam = $stmt->fetch(PDO::FETCH_ASSOC);

header("Location: view_exam_answers.php?exam_id=" . $exam['ExamID']);
exit();
