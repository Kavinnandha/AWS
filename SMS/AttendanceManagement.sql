-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 18, 2024 at 07:59 AM
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
-- Database: `sms_structure`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `academic_year_id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advisor_mapping`
--

CREATE TABLE `advisor_mapping` (
  `advisor_mapping_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mapping_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `approved_certificates`
--

CREATE TABLE `approved_certificates` (
  `cert_id` int(11) NOT NULL,
  `event_name` varchar(150) NOT NULL,
  `points_awarded` int(11) DEFAULT NULL,
  `register_no` bigint(20) NOT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `session_id` int(11) NOT NULL,
  `register_no` bigint(20) NOT NULL,
  `status` varchar(15) NOT NULL,
  `remark` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_type`
--

CREATE TABLE `attendance_type` (
  `type_id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_type`
--

INSERT INTO `attendance_type` (`type_id`, `description`, `value`) VALUES
(1, 'Present', 1),
(2, 'Absent', 0),
(3, 'On-Duty', -1);

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `batch_id` int(11) NOT NULL,
  `batch_name` varchar(10) NOT NULL,
  `current_semester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `register_no` bigint(20) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_data` longblob NOT NULL,
  `name` varchar(155) NOT NULL,
  `position_secured` varchar(100) DEFAULT NULL,
  `held_date` date NOT NULL DEFAULT current_timestamp(),
  `description` varchar(255) DEFAULT NULL,
  `issued_by` varchar(100) DEFAULT NULL,
  `publication_name` varchar(100) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` varchar(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_type`
--

CREATE TABLE `course_type` (
  `type_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_type`
--

INSERT INTO `course_type` (`type_id`, `type`) VALUES
(1, 'Theory'),
(2, 'Laboratory'),
(3, 'Project'),
(4, 'Blended');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `name`) VALUES
(107, 'Computer Science and Engineering(Cyber Secuirty)');

-- --------------------------------------------------------

--
-- Table structure for table `hod_mapping`
--

CREATE TABLE `hod_mapping` (
  `hod_mapping_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_record`
--

CREATE TABLE `leave_record` (
  `leave_id` int(11) NOT NULL,
  `reference_id` bigint(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `no_of_days` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `remark` varchar(150) NOT NULL DEFAULT '-',
  `out_time` time DEFAULT NULL,
  `in_time` time DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_status`
--

CREATE TABLE `leave_status` (
  `status_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `user_id` int(11) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `gender` char(1) NOT NULL,
  `designation` varchar(25) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `suspended` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user_id`, `email_id`, `name`, `department_id`, `gender`, `designation`, `password`, `role_id`, `suspended`) VALUES
(2, 'rkarthiban@siet.ac.in', 'R Karthiban', 107, 'M', 'HOD', '*A4B6157319038724E3560894F7F932C8886EBFCF', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mapping_course_department_batch`
--

CREATE TABLE `mapping_course_department_batch` (
  `course_mapping_id` int(11) NOT NULL,
  `course_id` varchar(15) DEFAULT NULL,
  `mapping_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `semester` int(11) NOT NULL,
  `section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mapping_program_department`
--

CREATE TABLE `mapping_program_department` (
  `mapping_id` int(11) NOT NULL,
  `programme_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mapping_teacher_course`
--

CREATE TABLE `mapping_teacher_course` (
  `new_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_mapping_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programme`
--

CREATE TABLE `programme` (
  `programme_id` int(11) NOT NULL,
  `programme_name` varchar(50) DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `no_of_semesters` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `reference_id` bigint(20) NOT NULL,
  `request` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(0, 'Staff'),
(1, 'HOD'),
(2, 'Principal'),
(3, 'Dean'),
(4, 'Chairman'),
(5, 'Admin'),
(6, 'Advisor'),
(7, 'Warden'),
(8, 'Department Coordinator');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `section_name` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `section_name`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `session_id` int(11) NOT NULL,
  `new_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `date_of_session` date NOT NULL,
  `period` int(11) NOT NULL,
  `topics_covered` varchar(100) DEFAULT NULL,
  `no_of_present` int(11) NOT NULL,
  `no_of_absent` int(11) NOT NULL,
  `no_of_od` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_information`
--

CREATE TABLE `student_information` (
  `register_no` bigint(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `DOB` date NOT NULL,
  `gender` char(1) NOT NULL,
  `boarding_status` char(1) NOT NULL,
  `mapping_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL DEFAULT 'NA',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`academic_year_id`);

--
-- Indexes for table `advisor_mapping`
--
ALTER TABLE `advisor_mapping`
  ADD PRIMARY KEY (`advisor_mapping_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `mapping_id` (`mapping_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `approved_certificates`
--
ALTER TABLE `approved_certificates`
  ADD PRIMARY KEY (`cert_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `attendance_type`
--
ALTER TABLE `attendance_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`batch_id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `register_no` (`register_no`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `course_type`
--
ALTER TABLE `course_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `hod_mapping`
--
ALTER TABLE `hod_mapping`
  ADD PRIMARY KEY (`hod_mapping_id`),
  ADD UNIQUE KEY `department_id` (`department_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `leave_record`
--
ALTER TABLE `leave_record`
  ADD PRIMARY KEY (`leave_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `leave_status`
--
ALTER TABLE `leave_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`email_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `mapping_course_department_batch`
--
ALTER TABLE `mapping_course_department_batch`
  ADD PRIMARY KEY (`course_mapping_id`),
  ADD KEY `mapping_id` (`mapping_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `mapping_program_department`
--
ALTER TABLE `mapping_program_department`
  ADD PRIMARY KEY (`mapping_id`),
  ADD KEY `programme_id` (`programme_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `mapping_teacher_course`
--
ALTER TABLE `mapping_teacher_course`
  ADD PRIMARY KEY (`new_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_mapping_id` (`course_mapping_id`),
  ADD KEY `mapping_teacher_course_ibfk_3` (`section_id`);

--
-- Indexes for table `programme`
--
ALTER TABLE `programme`
  ADD PRIMARY KEY (`programme_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `new_id` (`new_id`),
  ADD KEY `academic_year_id` (`academic_year_id`);

--
-- Indexes for table `student_information`
--
ALTER TABLE `student_information`
  ADD PRIMARY KEY (`register_no`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `mapping_id` (`mapping_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `academic_year_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advisor_mapping`
--
ALTER TABLE `advisor_mapping`
  MODIFY `advisor_mapping_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approved_certificates`
--
ALTER TABLE `approved_certificates`
  MODIFY `cert_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `batch_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hod_mapping`
--
ALTER TABLE `hod_mapping`
  MODIFY `hod_mapping_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_record`
--
ALTER TABLE `leave_record`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mapping_course_department_batch`
--
ALTER TABLE `mapping_course_department_batch`
  MODIFY `course_mapping_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mapping_program_department`
--
ALTER TABLE `mapping_program_department`
  MODIFY `mapping_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mapping_teacher_course`
--
ALTER TABLE `mapping_teacher_course`
  MODIFY `new_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programme`
--
ALTER TABLE `programme`
  MODIFY `programme_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `advisor_mapping`
--
ALTER TABLE `advisor_mapping`
  ADD CONSTRAINT `advisor_mapping_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`user_id`),
  ADD CONSTRAINT `advisor_mapping_ibfk_2` FOREIGN KEY (`mapping_id`) REFERENCES `mapping_program_department` (`mapping_id`),
  ADD CONSTRAINT `advisor_mapping_ibfk_3` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `advisor_mapping_ibfk_4` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `session` (`session_id`);

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`register_no`) REFERENCES `student_information` (`register_no`);

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `course_type` (`type_id`);

--
-- Constraints for table `hod_mapping`
--
ALTER TABLE `hod_mapping`
  ADD CONSTRAINT `hod_mapping_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`user_id`),
  ADD CONSTRAINT `hod_mapping_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `leave_record`
--
ALTER TABLE `leave_record`
  ADD CONSTRAINT `leave_record_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `attendance_type` (`type_id`),
  ADD CONSTRAINT `leave_record_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `leave_status` (`status_id`);

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `login_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);

--
-- Constraints for table `mapping_course_department_batch`
--
ALTER TABLE `mapping_course_department_batch`
  ADD CONSTRAINT `mapping_course_department_batch_ibfk_1` FOREIGN KEY (`mapping_id`) REFERENCES `mapping_program_department` (`mapping_id`),
  ADD CONSTRAINT `mapping_course_department_batch_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `mapping_course_department_batch_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);

--
-- Constraints for table `mapping_program_department`
--
ALTER TABLE `mapping_program_department`
  ADD CONSTRAINT `mapping_program_department_ibfk_1` FOREIGN KEY (`programme_id`) REFERENCES `programme` (`programme_id`),
  ADD CONSTRAINT `mapping_program_department_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `mapping_teacher_course`
--
ALTER TABLE `mapping_teacher_course`
  ADD CONSTRAINT `mapping_teacher_course_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`user_id`),
  ADD CONSTRAINT `mapping_teacher_course_ibfk_2` FOREIGN KEY (`course_mapping_id`) REFERENCES `mapping_course_department_batch` (`course_mapping_id`),
  ADD CONSTRAINT `mapping_teacher_course_ibfk_3` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`);

--
-- Constraints for table `student_information`
--
ALTER TABLE `student_information`
  ADD CONSTRAINT `student_information_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `student_information_ibfk_2` FOREIGN KEY (`mapping_id`) REFERENCES `mapping_program_department` (`mapping_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
