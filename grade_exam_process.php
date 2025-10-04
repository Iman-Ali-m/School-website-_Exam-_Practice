<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professor') {
    header("Location: login.php");
    exit();
}
require 'db.php';
$course_id = $_POST['course_id'];
$student_id = $_POST['student_id'];
$exam_id = $_POST['exam_id'];
$grades = $_POST['grades'];
foreach ($grades as $answer_id => $grade) {
    $stmt = $conn->prepare("UPDATE StudentAnswers SET Grade = ? WHERE AnswerID = ?");
    $stmt->execute([$grade, $answer_id]);
}
$stmt = $conn->prepare("SELECT SUM(Grade) AS ExamGrade FROM StudentAnswers WHERE StudentID = ? AND QuestionID IN (SELECT QuestionID FROM ExamQuestions WHERE ExamID = ?)");
$stmt->execute([$student_id, $exam_id]);
$exam_grade = $stmt->fetch(PDO::FETCH_ASSOC)['ExamGrade'];
$stmt = $conn->prepare("SELECT SUM(Grade) AS AssignmentGrade FROM AssignmentSubmissions WHERE StudentID = ? AND CourseID = ?");
$stmt->execute([$student_id, $course_id]);
$assignment_grade = $stmt->fetch(PDO::FETCH_ASSOC)['AssignmentGrade'];
$total_grade = $exam_grade + $assignment_grade;
$stmt = $conn->prepare("INSERT INTO Grades (StudentID, CourseID, ExamGrade, AssignmentGrade, TotalGrade) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE ExamGrade = VALUES(ExamGrade), AssignmentGrade = VALUES(AssignmentGrade),TotalGrade = VALUES(TotalGrade)");
$stmt->execute([$student_id, $course_id, $exam_grade, $assignment_grade, $total_grade]);
header("Location: view_exam_answers.php?course_id=$course_id&exam_id=$exam_id&student_id=$student_id");
exit();
