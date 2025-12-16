-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2025 at 04:43 AM
-- Server version: 11.4.5-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scholarship_system_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `application_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `scholarship_id` int(11) NOT NULL,
  `upload_file` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`application_id`, `student_id`, `scholarship_id`, `upload_file`, `status`, `applied_at`) VALUES
(1, 11, 1, '../uploads/applications/11_1761591028.jpg', 'Approved', '2025-10-27 11:50:28'),
(2, 4, 1, '../uploads/applications/4_1761605452.png', 'Rejected', '2025-10-27 15:50:52'),
(3, 12, 1, '../uploads/applications/12_1761612561.png', 'Rejected', '2025-10-27 17:49:21'),
(4, 13, 5, '../uploads/applications/13_1761622664.png', 'Approved', '2025-10-27 20:37:44');

-- --------------------------------------------------------

--
-- Table structure for table `email_verifications`
--

CREATE TABLE `email_verifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(128) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `verified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_verifications`
--

INSERT INTO `email_verifications` (`id`, `user_id`, `email`, `token`, `is_verified`, `created_at`, `expires_at`, `verified_at`) VALUES
(1, 16, 'eyenight74@gmail.com', 'ae151bcfcdb3be6cf41be8c62a4b7885ae07591257ee3fbc1357fcb00e0463a8', 0, '2025-12-14 23:40:18', '2025-12-15 16:40:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `profile_id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `middleName` varchar(255) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `contactNumber` varchar(50) NOT NULL,
  `gpa` decimal(3,2) NOT NULL,
  `familyIncome` decimal(10,2) NOT NULL,
  `school` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `yearLevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profile_id`, `firstName`, `lastName`, `middleName`, `birthdate`, `address`, `contactNumber`, `gpa`, `familyIncome`, `school`, `course`, `yearLevel`) VALUES
(13, 'John Dave', 'Libradilla', 'Space', '2025-09-29', 'Upper Calarian', '09561272679', 4.00, 10000.00, 'Western Mindanao State University', 'Computer Science', 2),
(18, 'Jane', 'ss', 'Space', '2025-10-22', 'Upper Calarian', '09561272679', 4.00, 100000.00, 'Western Mindanao State University', 'Computer Science', 3),
(19, 'Space', '1000', 'jade', '2025-10-28', 'Upper Calarian', '09561272679', 4.00, 400000.00, 'Western Mindanao State University', 'Computer Science', 3),
(20, 'Al-jamal', 'Ayub', 'jade', '2025-10-09', 'Upper Calarian', '09561272679', 4.00, 10000.00, 'Western Mindanao State University', 'Computer Science', 3),
(21, 'John Dave', 'Libradilla', 'Space', '2003-05-14', 'Upper Calarian', '09561272679', 3.50, 40000.00, 'Western Mindanao State University', '1000', 3),
(22, 'John Dave', 'Libradilla', 'jade', '2003-06-14', 'Upper Calarian', '09561272679', 0.00, 10000.00, 'asdads', 'Computer Science', 3),
(23, 'John Dave', 'Libradilla', 'Space', '2025-12-02', 'Upper Calarian', '09561272679', 4.00, 100000.00, 'asdads', 'Computer Science', 4),
(24, 'John Dave', 'Libradilla', 'Space', '2025-08-05', 'Upper Calarian', '09561272679', 5.00, 10000.00, 'ads', 'Computer Science', 4);

-- --------------------------------------------------------

--
-- Table structure for table `scholarships`
--

CREATE TABLE `scholarships` (
  `scholarship_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `deadline` date NOT NULL,
  `total_slots` int(11) NOT NULL,
  `available_slots` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `min_gpa` decimal(3,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholarships`
--

INSERT INTO `scholarships` (`scholarship_id`, `title`, `description`, `requirements`, `deadline`, `total_slots`, `available_slots`, `created_at`, `min_gpa`) VALUES
(1, 'Merit-based scholarships', 'Merit-based scholarships are the best-known type of scholarship and are awarded to students based on their superior achievements in academia, art, or other similar fields. \r\n\r\nBeyond how well they do in school, many students excel in specific fields and show potential that can genuinely impact our society. In recognition of this talent, many institutions offer scholarships based on research, artistic, or athletic achievements. \r\n\r\nThus, merit-based scholarships aim to recognise the hard work and dedication of students, motivating others to do the same. They manage to attract talent and the brightest minds among students, which leads to a competitive and high-performing learning environment.', 'Upload of Grade Picture', '2025-11-08', 5, 5, '2025-10-27 16:49:05', 4.00),
(2, 'Scholarships for excellent academic results', 'These awards are given to students based on their superior academic performance. They are among the most sought-after forms of financial aid and play an essential role in giving top-performing students the resources to continue their academic pursuits.', 'qualify include:\r\n\r\nGrade Point Average (GPA) scores that shouldn’t be below specified limits;\r\nMinimum scores for standardised tests like SAT, ACT, GRE, or GMAT;\r\nCourse-specific achievements, for subject-specific scholarships.', '2025-10-31', 10, 10, '2025-10-27 16:50:30', 4.50),
(5, 'Paisko ni sir jaydee', 'adsas', 'dawdw', '2025-10-31', 2, 2, '2025-10-28 03:37:00', 3.50);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') DEFAULT NULL,
  `profile_id` int(11) DEFAULT NULL,
  `date_created` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `profile_id`, `date_created`) VALUES
(1, 'Space1000', '$2y$10$gFD8axlIyYNusEv4aSwZrONo6NAnRDQHmClqFE3O2UIyUOZc8wdIS', 'admin', NULL, '2025-10-26 11:09:20'),
(4, 'johndavelibradilla@gmail.com', '$2y$10$teAbjP8Smi4x34xC7oohqevhKGNb6ZrydMz8h5yssRcQdElBM7uXS', 'student', 13, '2025-10-27 10:45:03'),
(7, 'sun', '$2y$10$cDAkji8Q9Wzty2NWQyI5Ie39hKomImngyIkP/Jq/dUYLBQLMUhXX2', 'admin', NULL, '2025-10-27 12:21:02'),
(11, 'eh202201089@wmsu.edu.ph', '$2y$10$xGVHp.8i4hv8lUEYLgh/JuuCGYA8IaZ1EsCsU6eRE7n61ehjHln4q', 'student', 18, '2025-10-27 14:07:00'),
(12, 'hijimenagumo@gmail.com', '$2y$10$idXECV1M4l71/jxxCoWHA.Tey.A2Bns1IwGa9ey4.pD2FZDDGNogW', 'student', 19, '2025-10-27 14:24:23'),
(13, 'space@gmail.com', '$2y$10$XrxIp.p4dLbv5f43IWw2Dea3nOG20Xlk5fjjwfcZWMddPl6.cB/eS', 'student', 20, '2025-10-28 03:27:08'),
(14, 'sankarea', '$2y$10$qH8C90o92c4winPo.qnxwe.ywNO0TT7.2ExTaq3UKahOcbXYjRp6S', 'student', 21, '2025-12-14 15:30:03'),
(15, 'sheela', '$2y$10$DWutX244CQC2o/WfJyjRPO4W9VDOGkmebRG9uWkZ3zBto7dNhhLq6', 'student', 22, '2025-12-14 15:36:47'),
(16, 'hotaru', '$2y$10$0jpslYgaN6qjjLeUElsZ7OluQ9oi9mcwfENUrdqcWkEQplg0x3ofq', 'student', 23, '2025-12-14 15:40:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `fk_student` (`student_id`),
  ADD KEY `fk_scholarship` (`scholarship_id`);

--
-- Indexes for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`profile_id`);

--
-- Indexes for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD PRIMARY KEY (`scholarship_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `scholarships`
--
ALTER TABLE `scholarships`
  MODIFY `scholarship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`scholarship_id`) REFERENCES `scholarships` (`scholarship_id`),
  ADD CONSTRAINT `fk_scholarship` FOREIGN KEY (`scholarship_id`) REFERENCES `scholarships` (`scholarship_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `profile_id` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
