<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.php");
    exit();
}

require 'db.php';
$course_id = $_POST['course_id'];
$exam_name = $_POST['exam_name'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$question_texts = $_POST['question_text'];
$question_types = $_POST['question_type'];
$option_texts = $_POST['option_text'];
$is_corrects = $_POST['is_correct'];
$stmt = $conn->prepare("
    INSERT INTO Exams (CourseID, ExamName, StartTime, EndTime)
    VALUES (?, ?, ?, ?)
");
$stmt->execute([$course_id, $exam_name, $start_time, $end_time]);
$exam_id = $conn->lastInsertId();
foreach ($question_texts as $index => $question_text) {
    $stmt = $conn->prepare("
        INSERT INTO ExamQuestions (ExamID, QuestionType, QuestionText)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$exam_id, $question_types[$index], $question_text]);
    $question_id = $conn->lastInsertId();
    if ($question_types[$index] === 'MultipleChoice') {
        foreach ($option_texts[$index] as $option_index => $option_text) {
            $is_correct = $is_corrects[$index][$option_index] ?? 0;
            $stmt = $conn->prepare("
                INSERT INTO ExamOptions (QuestionID, OptionText, IsCorrect)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$question_id, $option_text, $is_correct]);
        }
    }
}

header("Location: professor_dashboard.php");
exit();
