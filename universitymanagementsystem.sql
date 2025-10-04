-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2025 at 04:59 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `universitymanagementsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `AssignmentID` int(11) NOT NULL,
  `CourseID` int(11) DEFAULT NULL,
  `AssignmentName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Deadline` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignmentsubmissions`
--

CREATE TABLE `assignmentsubmissions` (
  `SubmissionID` int(11) NOT NULL,
  `CourseID` int(11) DEFAULT NULL,
  `StudentID` int(11) DEFAULT NULL,
  `AssignmentName` varchar(255) NOT NULL,
  `SubmissionFile` varchar(255) NOT NULL,
  `Grade` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignmentsubmissions`
--

INSERT INTO `assignmentsubmissions` (`SubmissionID`, `CourseID`, `StudentID`, `AssignmentName`, `SubmissionFile`, `Grade`) VALUES
(1, 1, 1, 'تمرین1', 'uploads/Screenshot (945).png', 1.00),
(2, 1, 6, 'تمرین1', 'uploads/Screenshot (947).png', 1.00);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `CourseID` int(11) NOT NULL,
  `CourseName` varchar(100) NOT NULL,
  `ProfessorID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`CourseID`, `CourseName`, `ProfessorID`) VALUES
(1, 'گسسته', 7),
(2, 'مهندسی نرم افزار', 7);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `EnrollmentID` int(11) NOT NULL,
  `StudentID` int(11) DEFAULT NULL,
  `CourseID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`EnrollmentID`, `StudentID`, `CourseID`) VALUES
(1, 1, 1),
(2, 6, 1),
(4, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `examoptions`
--

CREATE TABLE `examoptions` (
  `OptionID` int(11) NOT NULL,
  `QuestionID` int(11) DEFAULT NULL,
  `OptionText` text NOT NULL,
  `IsCorrect` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examoptions`
--

INSERT INTO `examoptions` (`OptionID`, `QuestionID`, `OptionText`, `IsCorrect`) VALUES
(1, 1, '1)2', 1),
(2, 1, '2)4', 0),
(3, 1, '3)5', 0),
(4, 1, '6)8', 0),
(5, 5, '1)2', 1),
(6, 5, '2)4', 0),
(7, 5, '3)5', 0),
(8, 5, '6)8', 0);

-- --------------------------------------------------------

--
-- Table structure for table `examquestions`
--

CREATE TABLE `examquestions` (
  `QuestionID` int(11) NOT NULL,
  `ExamID` int(11) DEFAULT NULL,
  `QuestionType` enum('MultipleChoice','TrueFalse','Descriptive','FillInTheBlank') NOT NULL,
  `QuestionText` text NOT NULL,
  `CorrectAnswer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examquestions`
--

INSERT INTO `examquestions` (`QuestionID`, `ExamID`, `QuestionType`, `QuestionText`, `CorrectAnswer`) VALUES
(1, 1, 'MultipleChoice', '2*2=؟', NULL),
(2, 1, 'Descriptive', '6+6=؟', NULL),
(3, 1, 'FillInTheBlank', '8+2=.... است.', NULL),
(4, 1, 'TrueFalse', 'ایا5+6=11 است؟', NULL),
(5, 2, 'MultipleChoice', '19+6=?', NULL),
(6, 2, 'TrueFalse', '6+6=؟', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `ExamID` int(11) NOT NULL,
  `CourseID` int(11) DEFAULT NULL,
  `ExamName` varchar(100) NOT NULL,
  `StartTime` datetime DEFAULT NULL,
  `EndTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`ExamID`, `CourseID`, `ExamName`, `StartTime`, `EndTime`) VALUES
(1, 1, 'پایان ترم ', '2025-03-15 16:26:00', '2025-03-15 18:26:00'),
(2, 1, 'پایان ترم 2', '2025-04-08 10:14:00', '2025-05-08 00:14:00');

-- --------------------------------------------------------

--
-- Table structure for table `fixedcodes`
--

CREATE TABLE `fixedcodes` (
  `CodeID` int(11) NOT NULL,
  `FixedCode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fixedcodes`
--

INSERT INTO `fixedcodes` (`CodeID`, `FixedCode`) VALUES
(1, 'STAFF001'),
(2, 'STAFF002'),
(3, 'STAFF003'),
(4, 'STAFF004'),
(5, 'STAFF005');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `GradeID` int(11) NOT NULL,
  `StudentID` int(11) DEFAULT NULL,
  `CourseID` int(11) DEFAULT NULL,
  `AssignmentGrade` decimal(5,2) DEFAULT NULL,
  `ExamGrade` decimal(5,2) DEFAULT NULL,
  `FinalGrade` decimal(5,2) DEFAULT NULL,
  `TotalGrade` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`GradeID`, `StudentID`, `CourseID`, `AssignmentGrade`, `ExamGrade`, `FinalGrade`, `TotalGrade`) VALUES
(4, 1, 1, 1.00, 11.00, 12.00, 12.00);

-- --------------------------------------------------------

--
-- Table structure for table `studentanswers`
--

CREATE TABLE `studentanswers` (
  `AnswerID` int(11) NOT NULL,
  `QuestionID` int(11) DEFAULT NULL,
  `StudentID` int(11) DEFAULT NULL,
  `AnswerText` text DEFAULT NULL,
  `Grade` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentanswers`
--

INSERT INTO `studentanswers` (`AnswerID`, `QuestionID`, `StudentID`, `AnswerText`, `Grade`) VALUES
(13, 1, 6, '1', NULL),
(14, 2, 6, '12', NULL),
(15, 3, 6, '10', NULL),
(16, 4, 6, 'true', NULL),
(17, 1, 1, '2', 0.00),
(18, 2, 1, '12', 5.00),
(19, 3, 1, '10', 5.00),
(20, 4, 1, 'true', 1.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `UserType` enum('Student','Professor','Staff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `FullName`, `Email`, `UserType`) VALUES
(1, 'iman', '$2y$10$QYR6GFosvki8TQImn7VzOecpPH.FYgEQ9/dfjZhCM6RQjxNaWz6z6', 'iman', 'imani11py@gmail.com', 'Student'),
(4, 'iman1', '$2y$10$3HSQOQs/KA2l7xmhP9sUn.FnhJYdQ7WZcWF5xwWvB8a9JEnvaeWhK', 'iman1', 'imani1111py@gmail.com', 'Staff'),
(5, 'iman2', '$2y$10$EyYL/VZEqe/7IIauOgA.JuWNHNNbeNnNhLw83yNG7vN9M1CIWQuui', 'iman2', 'imani121py@gmail.com', 'Professor'),
(6, 'iman3', '$2y$10$PzpPyOAUrQgmzuYNCaDgQ.647JDl4ITpx0JBUg3fym7OBBJRh6bPC', 'iman3', 'imani11121py@gmail.com', 'Student'),
(7, 'iman4', '$2y$10$OuroYwk6AhAmqXjdNKW0Au.f4eWq2QTa/XLYLwazHLZazMYt4DK5u', 'iman4', 'imani111121py@gmail.com', 'Professor'),
(10, 'r', '$2y$10$o4d1fujN7lWqDwmq7e0wh.iDenU3EdNlkFo75LK4d2NxVt6QYnXyu', 'maede', 'rastegar@gmail.com', 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`AssignmentID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `assignmentsubmissions`
--
ALTER TABLE `assignmentsubmissions`
  ADD PRIMARY KEY (`SubmissionID`),
  ADD KEY `CourseID` (`CourseID`),
  ADD KEY `StudentID` (`StudentID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`CourseID`),
  ADD KEY `ProfessorID` (`ProfessorID`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`EnrollmentID`),
  ADD KEY `StudentID` (`StudentID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `examoptions`
--
ALTER TABLE `examoptions`
  ADD PRIMARY KEY (`OptionID`),
  ADD KEY `QuestionID` (`QuestionID`);

--
-- Indexes for table `examquestions`
--
ALTER TABLE `examquestions`
  ADD PRIMARY KEY (`QuestionID`),
  ADD KEY `ExamID` (`ExamID`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`ExamID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `fixedcodes`
--
ALTER TABLE `fixedcodes`
  ADD PRIMARY KEY (`CodeID`),
  ADD UNIQUE KEY `FixedCode` (`FixedCode`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`GradeID`),
  ADD KEY `StudentID` (`StudentID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `studentanswers`
--
ALTER TABLE `studentanswers`
  ADD PRIMARY KEY (`AnswerID`),
  ADD KEY `QuestionID` (`QuestionID`),
  ADD KEY `StudentID` (`StudentID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `AssignmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignmentsubmissions`
--
ALTER TABLE `assignmentsubmissions`
  MODIFY `SubmissionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `EnrollmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `examoptions`
--
ALTER TABLE `examoptions`
  MODIFY `OptionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `examquestions`
--
ALTER TABLE `examquestions`
  MODIFY `QuestionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `ExamID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fixedcodes`
--
ALTER TABLE `fixedcodes`
  MODIFY `CodeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `GradeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `studentanswers`
--
ALTER TABLE `studentanswers`
  MODIFY `AnswerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`);

--
-- Constraints for table `assignmentsubmissions`
--
ALTER TABLE `assignmentsubmissions`
  ADD CONSTRAINT `assignmentsubmissions_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`),
  ADD CONSTRAINT `assignmentsubmissions_ibfk_2` FOREIGN KEY (`StudentID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`ProfessorID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`);

--
-- Constraints for table `examoptions`
--
ALTER TABLE `examoptions`
  ADD CONSTRAINT `examoptions_ibfk_1` FOREIGN KEY (`QuestionID`) REFERENCES `examquestions` (`QuestionID`);

--
-- Constraints for table `examquestions`
--
ALTER TABLE `examquestions`
  ADD CONSTRAINT `examquestions_ibfk_1` FOREIGN KEY (`ExamID`) REFERENCES `exams` (`ExamID`);

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`);

--
-- Constraints for table `studentanswers`
--
ALTER TABLE `studentanswers`
  ADD CONSTRAINT `studentanswers_ibfk_1` FOREIGN KEY (`QuestionID`) REFERENCES `examquestions` (`QuestionID`),
  ADD CONSTRAINT `studentanswers_ibfk_2` FOREIGN KEY (`StudentID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
