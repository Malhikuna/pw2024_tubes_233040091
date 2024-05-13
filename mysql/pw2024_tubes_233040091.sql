-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 13, 2024 at 05:33 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pw2024_tubes_233040091`
--

-- --------------------------------------------------------

--
-- Table structure for table `catagories`
--

CREATE TABLE `catagories` (
  `id` int NOT NULL,
  `catagory_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `catagories`
--

INSERT INTO `catagories` (`id`, `catagory_name`) VALUES
(1, 'Frontend Developer'),
(2, 'Backend Developer');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int NOT NULL,
  `catagory_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `channel_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `catagory_id`, `name`, `channel_name`, `thumbnail`, `price`) VALUES
(1, 1, 'Belajar JavaScript Dasar', 'Hikmal Maulana', 'javascript.jpg', 0),
(2, 1, 'Belajar React', 'Hikmal Maulana', 'react.jpg', 0),
(3, 2, 'Belajar PHP Dasar', 'Malhikuna', 'php.jpg', 0),
(4, 2, 'Belajar Laravel', 'Malhikuna', 'laravel.jpg', 0),
(5, 2, 'Belajar Mysql', 'Malhikuna', 'mysql.jpg', 0),
(6, 2, 'Belajar Node JS', 'Hikmal Maulana', 'nodejs.jpg', 0),
(8, 1, 'Belajar PHP Lanjutan', 'Malhikuna', '663c9cc509ef4.jpg', 0),
(26, 1, 'JavaScript OOP', 'Hikmal Maulana', '663fd586756d5.jpg', 150000);

-- --------------------------------------------------------

--
-- Table structure for table `course_video`
--

CREATE TABLE `course_video` (
  `id` int NOT NULL,
  `video_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `courses_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `course_video`
--

INSERT INTO `course_video` (`id`, `video_name`, `description`, `courses_id`) VALUES
(1, 'Pendahuluan', 'Mempelajari semua tipe data yang ada pada bahasa pemrograman javascript', 1),
(2, 'Tipe Data', 'Mempelajari semua macam variable yang ada pada bahasa pemrograman javascript', 1),
(5, 'Pendahuluan', 'Belajar JavaScript OOP', 26),
(6, 'Variable', '', 1),
(7, 'Pendahuluan', '', 2),
(8, 'Pendahuluan', NULL, 4),
(9, 'Pendahuluan', NULL, 5),
(10, 'Pendahuluan', NULL, 6),
(11, 'Pendahuluan', NULL, 3),
(12, 'Pendahuluan', NULL, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`) VALUES
(2, 'malhikuna@gmail.com', 'malhikuna', '$2y$10$rsehQsOEKPW.jvq.1avaaeScgIwelViAMT82HrvPfo4Nb2krEPJ32'),
(3, 'hikmal767@gmail.com', 'hikmal maulana', '$2y$10$I1sxSFDxizlJWIsZyWR.eelfdz6Lih38zuvNvEOPtSkZjeLAj1KHG'),
(8, '', '', '$2y$10$dwAFkBhshxg84Uy8v8VTXeXD5t2PLn1lAqlstplo6PCPWLQ/37nKm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catagories`
--
ALTER TABLE `catagories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catagory_id` (`catagory_id`);

--
-- Indexes for table `course_video`
--
ALTER TABLE `course_video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_id` (`courses_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catagories`
--
ALTER TABLE `catagories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `course_video`
--
ALTER TABLE `course_video`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`catagory_id`) REFERENCES `catagories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `course_video`
--
ALTER TABLE `course_video`
  ADD CONSTRAINT `course_video_ibfk_1` FOREIGN KEY (`courses_id`) REFERENCES `courses` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
