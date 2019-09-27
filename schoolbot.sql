-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 27, 2019 at 08:17 PM
-- Server version: 5.7.19
-- PHP Version: 7.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schoolbot`
--

-- --------------------------------------------------------

--
-- Table structure for table `bells`
--

CREATE TABLE `bells` (
  `lesson` int(2) NOT NULL,
  `breaks` varchar(63) NOT NULL,
  `priority` int(1) NOT NULL,
  `start` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `city` varchar(31) NOT NULL,
  `school` varchar(63) NOT NULL,
  `grade` varchar(7) NOT NULL,
  `profile` varchar(31) NOT NULL,
  `day` varchar(7) NOT NULL,
  `lessons` text NOT NULL,
  `priority` varchar(15) NOT NULL,
  `time_created` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`city`, `school`, `grade`, `profile`, `day`, `lessons`, `priority`, `time_created`) VALUES
('Кемь', 'МБОУСОШ1', '1', 'нет', 'mon', 'Русский_12;Русский_12;Математика_5;Математика_9;Информатика_1;Физкультура_2;Русский_10', 'main', 1569602519);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(31) NOT NULL,
  `city` varchar(31) NOT NULL,
  `school` varchar(31) NOT NULL,
  `grade` varchar(7) NOT NULL,
  `profile` varchar(31) NOT NULL,
  `role` enum('admin','user','poster') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
