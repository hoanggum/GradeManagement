-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 11, 2024 at 01:53 PM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_grademanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `ClassID` int NOT NULL,
  `DepartmentID` int DEFAULT NULL,
  `TeacherID` int DEFAULT NULL,
  `className` varchar(155) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`ClassID`, `DepartmentID`, `TeacherID`, `className`) VALUES
(1, 4, 1, '12DHTH15');

-- --------------------------------------------------------

--
-- Table structure for table `degree`
--

CREATE TABLE `degree` (
  `DegreeID` int NOT NULL,
  `DegreeName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `GrantTime` date DEFAULT NULL,
  `TeacherID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `DepartmentID` int NOT NULL,
  `DepartmentName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`DepartmentID`, `DepartmentName`) VALUES
(4, 'Khoa công nghệ thông tin'),
(5, 'Khoa tài chính - ngân hàng'),
(6, 'Khoa ngoại ngữ');

-- --------------------------------------------------------

--
-- Table structure for table `examroom`
--

CREATE TABLE `examroom` (
  `room_id` int NOT NULL,
  `room_name` varchar(155) COLLATE utf8mb4_general_ci NOT NULL,
  `capacity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examroom`
--

INSERT INTO `examroom` (`room_id`, `room_name`, `capacity`) VALUES
(1, 'A101', 50),
(2, 'A102', 60),
(3, 'A103', 60),
(4, 'A104', 60);

-- --------------------------------------------------------

--
-- Table structure for table `examschedule`
--

CREATE TABLE `examschedule` (
  `Exam_ID` int NOT NULL,
  `ExamDate` date NOT NULL,
  `ExamRound` int NOT NULL,
  `ExamTime` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Duration` int NOT NULL,
  `section_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examschedule`
--

INSERT INTO `examschedule` (`Exam_ID`, `ExamDate`, `ExamRound`, `ExamTime`, `Duration`, `section_ID`) VALUES
(1, '2024-06-26', 1, '9:00', 120, 1),
(2, '2024-06-20', 1, '10:00', 120, 2);

-- --------------------------------------------------------

--
-- Table structure for table `examscheduledetail`
--

CREATE TABLE `examscheduledetail` (
  `Exam_ID` int NOT NULL,
  `StudentID` int NOT NULL,
  `room_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examscheduledetail`
--

INSERT INTO `examscheduledetail` (`Exam_ID`, `StudentID`, `room_id`) VALUES
(1, 1, 1),
(2, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `exam_invigilation`
--

CREATE TABLE `exam_invigilation` (
  `exam_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `room_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_invigilation`
--

INSERT INTO `exam_invigilation` (`exam_id`, `teacher_id`, `room_id`) VALUES
(1, 1, 1),
(2, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `exam_room_assignments`
--

CREATE TABLE `exam_room_assignments` (
  `Exam_ID` int NOT NULL,
  `room_id` int NOT NULL,
  `RoomAssignmentID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_room_assignments`
--

INSERT INTO `exam_room_assignments` (`Exam_ID`, `room_id`, `RoomAssignmentID`) VALUES
(1, 1, 1),
(2, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `ImageID` int NOT NULL,
  `Urls` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `Comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `UserID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`ImageID`, `Urls`, `Comments`, `UserID`) VALUES
(1, 'nv1.jpg', 'Ảnh đại diện', 3),
(2, 'nv1.jpg', 'Ảnh đại diện', 4),
(3, 'nv1.jpg', 'Ảnh đại diện', 1),
(4, 'nv1.jpg', 'Ảnh đại diện', 2);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `StudentID` int NOT NULL,
  `UserID` int DEFAULT NULL,
  `ClassID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`StudentID`, `UserID`, `ClassID`) VALUES
(1, 3, 1),
(2, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_semester`
--

CREATE TABLE `student_semester` (
  `SemesterID` int NOT NULL,
  `SectionID` int DEFAULT NULL,
  `StudentID` int DEFAULT NULL,
  `Grade` float DEFAULT NULL,
  `semester` int NOT NULL,
  `GradeInClass` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_semester`
--

INSERT INTO `student_semester` (`SemesterID`, `SectionID`, `StudentID`, `Grade`, `semester`, `GradeInClass`) VALUES
(1, 1, 1, 8, 1, 7),
(2, 2, 1, 8, 2, 7),
(3, 2, 2, 9, 2, 9),
(4, 1, 2, 5, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `SubjectID` int NOT NULL,
  `SubjectName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `NumOfCredits` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`SubjectID`, `SubjectName`, `NumOfCredits`) VALUES
(1, 'Cấu trúc rời rạc', 3),
(2, 'Cấu trúc dữ liệu và giải thuật', 3);

-- --------------------------------------------------------

--
-- Table structure for table `subjects_section`
--

CREATE TABLE `subjects_section` (
  `SectionID` int NOT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `Schedule` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `SubjectID` int DEFAULT NULL,
  `Semester` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects_section`
--

INSERT INTO `subjects_section` (`SectionID`, `StartDate`, `EndDate`, `Schedule`, `SubjectID`, `Semester`) VALUES
(1, '2024-01-11', '2024-06-20', 'Thứ 2 Tiết 1-3', 1, 1),
(2, '2024-01-05', '2024-06-15', 'Thứ 5 Tiết 7-9', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `subjects_section_detail`
--

CREATE TABLE `subjects_section_detail` (
  `Subjects_Section_DetailID` int NOT NULL,
  `TeacherID` int DEFAULT NULL,
  `SectionID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects_section_detail`
--

INSERT INTO `subjects_section_detail` (`Subjects_Section_DetailID`, `TeacherID`, `SectionID`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `TeacherID` int NOT NULL,
  `UserID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`TeacherID`, `UserID`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int NOT NULL,
  `FullName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `Email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Phone` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Gender` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FullName`, `Email`, `Address`, `Phone`, `Username`, `Password`, `Role`, `DateOfBirth`, `Gender`) VALUES
(1, 'Nguyễn Minh Thư', 'vnn12@gmail.com', '144 Lê trọng tấn', '0931551533', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Admin', '2004-06-10', 'Nam'),
(2, 'Nguyễn Huy Hoàng', 'huyhoang23@gmail.com', '241 Lê trọng tấn', '0987654321', 'huyhoang123', 'e10adc3949ba59abbe56e057f20f883e', 'Teacher', '2000-06-10', 'Nam'),
(3, 'Trương Quốc Huy', 'huy@gmail.com', '32 Bình Hưng Hòa B', '0412414123', 'huy111', 'e10adc3949ba59abbe56e057f20f883e', 'Student', '2005-06-03', 'Nam'),
(4, 'Hà trọng thắng', 'thang22@gmail.com', '412 Phú nhuận', '0241421511', 'thang123', 'e10adc3949ba59abbe56e057f20f883e', 'Student', '2004-06-11', 'Nam');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`ClassID`),
  ADD KEY `DepartmentID` (`DepartmentID`),
  ADD KEY `TeacherID` (`TeacherID`);

--
-- Indexes for table `degree`
--
ALTER TABLE `degree`
  ADD PRIMARY KEY (`DegreeID`),
  ADD KEY `TeacherID` (`TeacherID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DepartmentID`);

--
-- Indexes for table `examroom`
--
ALTER TABLE `examroom`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `examschedule`
--
ALTER TABLE `examschedule`
  ADD PRIMARY KEY (`Exam_ID`),
  ADD KEY `section_ID` (`section_ID`);

--
-- Indexes for table `examscheduledetail`
--
ALTER TABLE `examscheduledetail`
  ADD PRIMARY KEY (`Exam_ID`,`StudentID`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `examscheduledetail_ibfk_1` (`StudentID`);

--
-- Indexes for table `exam_invigilation`
--
ALTER TABLE `exam_invigilation`
  ADD PRIMARY KEY (`exam_id`,`teacher_id`,`room_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `exam_room_assignments`
--
ALTER TABLE `exam_room_assignments`
  ADD PRIMARY KEY (`RoomAssignmentID`),
  ADD KEY `Exam_ID` (`Exam_ID`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`ImageID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`StudentID`),
  ADD UNIQUE KEY `UserID` (`UserID`),
  ADD KEY `ClassID` (`ClassID`);

--
-- Indexes for table `student_semester`
--
ALTER TABLE `student_semester`
  ADD PRIMARY KEY (`SemesterID`),
  ADD KEY `StudentID` (`StudentID`),
  ADD KEY `SectionID` (`SectionID`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`SubjectID`);

--
-- Indexes for table `subjects_section`
--
ALTER TABLE `subjects_section`
  ADD PRIMARY KEY (`SectionID`),
  ADD KEY `SubjectID` (`SubjectID`);

--
-- Indexes for table `subjects_section_detail`
--
ALTER TABLE `subjects_section_detail`
  ADD PRIMARY KEY (`Subjects_Section_DetailID`),
  ADD KEY `TeacherID` (`TeacherID`),
  ADD KEY `SectionID` (`SectionID`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`TeacherID`),
  ADD UNIQUE KEY `UserID` (`UserID`),
  ADD UNIQUE KEY `UserID_2` (`UserID`),
  ADD UNIQUE KEY `UserID_3` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `ClassID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `degree`
--
ALTER TABLE `degree`
  MODIFY `DegreeID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `DepartmentID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `examroom`
--
ALTER TABLE `examroom`
  MODIFY `room_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `examschedule`
--
ALTER TABLE `examschedule`
  MODIFY `Exam_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exam_room_assignments`
--
ALTER TABLE `exam_room_assignments`
  MODIFY `RoomAssignmentID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `ImageID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `StudentID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_semester`
--
ALTER TABLE `student_semester`
  MODIFY `SemesterID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `SubjectID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subjects_section`
--
ALTER TABLE `subjects_section`
  MODIFY `SectionID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subjects_section_detail`
--
ALTER TABLE `subjects_section_detail`
  MODIFY `Subjects_Section_DetailID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `TeacherID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_3` FOREIGN KEY (`DepartmentID`) REFERENCES `department` (`DepartmentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_ibfk_4` FOREIGN KEY (`TeacherID`) REFERENCES `teacher` (`TeacherID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `degree`
--
ALTER TABLE `degree`
  ADD CONSTRAINT `degree_ibfk_1` FOREIGN KEY (`TeacherID`) REFERENCES `teacher` (`TeacherID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `examschedule`
--
ALTER TABLE `examschedule`
  ADD CONSTRAINT `examschedule_ibfk_1` FOREIGN KEY (`section_ID`) REFERENCES `subjects_section` (`SectionID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `examscheduledetail`
--
ALTER TABLE `examscheduledetail`
  ADD CONSTRAINT `examscheduledetail_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `examscheduledetail_ibfk_2` FOREIGN KEY (`Exam_ID`) REFERENCES `examschedule` (`Exam_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `examscheduledetail_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `examroom` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_invigilation`
--
ALTER TABLE `exam_invigilation`
  ADD CONSTRAINT `exam_invigilation_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `examschedule` (`Exam_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_invigilation_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `examroom` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_invigilation_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`TeacherID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_room_assignments`
--
ALTER TABLE `exam_room_assignments`
  ADD CONSTRAINT `exam_room_assignments_ibfk_1` FOREIGN KEY (`Exam_ID`) REFERENCES `examschedule` (`Exam_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_room_assignments_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `examroom` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`ClassID`) REFERENCES `class` (`ClassID`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Constraints for table `student_semester`
--
ALTER TABLE `student_semester`
  ADD CONSTRAINT `student_semester_ibfk_1` FOREIGN KEY (`SectionID`) REFERENCES `subjects_section` (`SectionID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_semester_ibfk_2` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjects_section`
--
ALTER TABLE `subjects_section`
  ADD CONSTRAINT `subjects_section_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`SubjectID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjects_section_detail`
--
ALTER TABLE `subjects_section_detail`
  ADD CONSTRAINT `subjects_section_detail_ibfk_1` FOREIGN KEY (`TeacherID`) REFERENCES `teacher` (`TeacherID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects_section_detail_ibfk_2` FOREIGN KEY (`SectionID`) REFERENCES `subjects_section` (`SectionID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
