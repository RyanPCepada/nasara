-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2024 at 02:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nasara`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activity_logs`
--

CREATE TABLE `tbl_activity_logs` (
  `activity_ID` int(20) NOT NULL,
  `activity` text NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customer_ID` int(20) NOT NULL,
  `admin_ID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_activity_logs`
--

INSERT INTO `tbl_activity_logs` (`activity_ID`, `activity`, `dateAdded`, `customer_ID`, `admin_ID`) VALUES
(1, 'Registered an account', '2024-04-23 11:28:45', 1, 0),
(2, 'Registered an account', '2024-05-05 13:35:28', 2, 0),
(3, 'Logged in an account', '2024-05-05 13:35:36', 2, 0),
(4, 'Logged in an account', '2024-05-05 13:38:25', 2, 0),
(5, 'Logged in an account', '2024-05-05 13:38:39', 2, 0),
(6, 'Logged in an account', '2024-05-05 13:54:46', 2, 0),
(7, 'Logged in an account', '2024-05-05 14:10:30', 2, 0),
(8, 'Logged out an account', '2024-05-05 14:37:44', 2, 0),
(9, 'Logged in an account', '2024-05-05 14:38:48', 2, 0),
(10, 'Logged out an account', '2024-05-05 14:38:56', 2, 0),
(11, 'Logged in an account', '2024-05-05 14:39:02', 2, 0),
(12, 'Changed Profile Picture', '2024-05-05 14:44:56', 2, 0),
(13, 'Changed Profile Picture', '2024-05-05 14:45:12', 2, 0),
(14, 'Updated the profile', '2024-05-05 14:46:36', 2, 0),
(15, 'Changed Profile Picture', '2024-05-05 14:48:56', 2, 0),
(16, 'Changed Profile Picture', '2024-05-05 14:49:07', 2, 0),
(17, 'Logged out an account', '2024-05-05 15:56:34', 2, 0),
(18, 'Logged in an account', '2024-05-08 14:10:24', 2, 0),
(19, 'Changed Profile Picture', '2024-05-08 14:14:14', 2, 0),
(20, 'Sent feedback', '2024-05-08 14:17:00', 2, 0),
(21, 'Sent feedback', '2024-05-08 14:50:48', 2, 0),
(22, 'Logged out an account', '2024-05-08 15:37:05', 2, 0),
(23, 'Logged in an account', '2024-05-08 15:37:27', 2, 0),
(24, 'Changed the password', '2024-05-08 15:51:52', 2, 0),
(25, 'Changed the password', '2024-05-08 15:52:35', 2, 0),
(26, 'Changed the password', '2024-05-08 15:52:59', 2, 0),
(27, 'Changed Profile Picture', '2024-05-08 15:53:22', 2, 0),
(28, 'Logged out an account', '2024-05-08 15:57:23', 2, 0),
(29, 'Logged in an account', '2024-05-08 16:22:35', 2, 0),
(30, 'Logged out an account', '2024-05-08 16:30:17', 2, 0),
(31, 'Logged in an account', '2024-05-08 16:34:39', 2, 0),
(32, 'Logged in an account', '2024-05-09 12:49:15', 2, 0),
(33, 'Registered an account', '2024-05-11 11:12:20', 3, 0),
(34, 'Logged in an account', '2024-05-11 11:15:03', 2, 0),
(35, 'Logged out an account', '2024-05-11 11:15:35', 2, 0),
(36, 'Logged in an account', '2024-05-11 11:15:57', 2, 0),
(37, 'Logged out an account', '2024-05-11 11:17:02', 2, 0),
(38, 'Registered an account', '2024-05-11 11:17:32', 4, 0),
(39, 'Logged in an account', '2024-05-11 11:17:40', 4, 0),
(40, 'Logged out an account', '2024-05-11 11:18:31', 4, 0),
(41, 'Registered an account', '2024-05-11 11:19:06', 5, 0),
(42, 'Logged in an account', '2024-05-11 11:19:13', 5, 0),
(43, 'Logged out an account', '2024-05-11 11:20:17', 5, 0),
(44, 'Registered an account', '2024-05-11 11:20:56', 6, 0),
(45, 'Logged in an account', '2024-05-11 11:21:04', 6, 0),
(46, 'Changed Profile Picture', '2024-05-11 11:21:38', 6, 0),
(47, 'Logged out an account', '2024-05-11 11:21:39', 6, 0),
(48, 'Logged in an account', '2024-05-11 11:21:46', 2, 0),
(49, 'Logged out an account', '2024-05-11 11:21:50', 2, 0),
(50, 'Logged in an account', '2024-05-11 11:21:59', 6, 0),
(51, 'Logged out an account', '2024-05-11 11:25:06', 6, 0),
(52, 'Logged in an account', '2024-05-11 11:25:20', 2, 0),
(53, 'Logged in an account', '2024-05-11 13:00:01', 2, 0),
(54, 'Logged in an account', '2024-05-11 13:16:09', 2, 0),
(55, 'Logged in an account', '2024-05-11 13:22:45', 2, 0),
(56, 'Sent audio feedback', '2024-05-11 13:36:53', 2, 0),
(57, 'Sent audio feedback', '2024-05-11 13:36:54', 2, 0),
(58, 'Sent audio feedback', '2024-05-11 13:39:28', 2, 0),
(59, 'Sent audio feedback', '2024-05-11 13:39:30', 2, 0),
(60, 'Sent audio feedback', '2024-05-11 13:39:30', 2, 0),
(61, 'Sent audio feedback', '2024-05-11 13:40:53', 2, 0),
(62, 'Sent audio feedback', '2024-05-11 13:40:54', 2, 0),
(63, 'Sent audio feedback', '2024-05-11 13:40:55', 2, 0),
(64, 'Logged in an account', '2024-05-13 14:34:57', 2, 0),
(65, 'Logged in an account', '2024-05-13 14:43:09', 2, 0),
(66, 'Logged in an account', '2024-05-13 15:00:24', 2, 0),
(67, 'Logged out an account', '2024-05-13 15:02:34', 2, 0),
(68, 'Logged in an account', '2024-05-13 15:35:14', 2, 0),
(69, 'Sent feedback', '2024-05-13 16:03:54', 2, 0),
(70, 'Logged in an account', '2024-05-13 16:30:36', 2, 0),
(71, 'Logged out an account', '2024-05-13 16:30:41', 2, 0),
(72, 'Logged in an account', '2024-05-14 02:13:32', 2, 0),
(73, 'Logged out an account', '2024-05-14 02:44:35', 2, 0),
(74, 'Logged in an account', '2024-05-14 02:47:29', 2, 0),
(75, 'Registered an account', '2024-05-14 06:15:32', 7, 0),
(76, 'Logged in an account', '2024-05-14 06:15:44', 7, 0),
(77, 'Sent feedback', '2024-05-14 06:16:28', 7, 0),
(78, 'Changed Profile Picture', '2024-05-14 06:17:08', 7, 0),
(79, 'Logged out an account', '2024-05-14 06:17:21', 7, 0),
(80, 'Registered an account', '2024-05-14 10:09:51', 8, 0),
(81, 'Logged in an account', '2024-05-14 10:10:24', 8, 0),
(82, 'Updated the profile', '2024-05-14 10:11:36', 8, 0),
(83, 'Changed Profile Picture', '2024-05-14 10:12:05', 8, 0),
(84, 'Sent feedback', '2024-05-14 10:14:17', 8, 0),
(85, 'Sent audio feedback', '2024-05-14 10:14:51', 8, 0),
(86, 'Sent audio feedback', '2024-05-14 10:14:53', 8, 0),
(87, 'Logged out an account', '2024-05-14 10:15:45', 8, 0),
(88, 'Logged in an account', '2024-05-14 10:15:54', 8, 0),
(89, 'Changed the password', '2024-05-14 10:16:26', 8, 0),
(90, 'Changed the password', '2024-05-14 10:16:55', 8, 0),
(91, 'Logged out an account', '2024-05-14 10:17:07', 8, 0),
(92, 'Logged in an account', '2024-05-14 10:18:27', 2, 0),
(93, 'Sent feedback', '2024-05-14 10:19:07', 2, 0),
(94, 'Sent feedback', '2024-05-14 10:20:36', 2, 0),
(95, 'Logged in an account', '2024-05-14 11:31:12', 2, 0),
(96, 'You logged in of your account', '2024-05-14 14:44:58', 0, 1),
(97, 'Logged in an account', '2024-05-14 12:50:28', 2, 0),
(98, 'Logged out an account', '2024-05-14 12:52:17', 2, 0),
(99, 'You logged in of your account', '2024-05-14 14:45:29', 0, 1),
(100, 'You logged out of your account', '2024-05-14 14:45:45', 0, 1),
(101, 'You logged in of your account', '2024-05-14 14:45:56', 0, 1),
(102, 'You logged out of your account', '2024-05-14 14:46:10', 0, 1),
(103, 'You logged in of your account', '2024-05-14 14:46:20', 0, 1),
(104, 'You logged out of your account', '2024-05-14 14:46:31', 0, 1),
(105, 'You logged in of your account', '2024-05-14 14:46:40', 0, 1),
(106, 'You logged out of your account', '2024-05-14 14:46:52', 0, 1),
(107, 'You logged in of your account', '2024-05-14 14:47:01', 0, 1),
(108, 'You logged out of your account', '2024-05-14 14:43:52', 0, 1),
(109, 'You logged in of your account', '2024-05-14 14:44:23', 0, 1),
(110, 'You logged in of your account', '2024-05-14 14:51:22', 0, 1),
(111, 'You logged out of your account', '2024-05-14 14:55:38', 0, 1),
(112, 'You logged in of your account', '2024-05-14 14:55:42', 0, 1),
(113, 'You logged out of your account', '2024-05-14 15:01:06', 0, 1),
(114, 'You logged in of your account', '2024-05-14 15:01:10', 0, 1),
(115, 'Registered an account', '2024-05-14 15:37:38', 9, 0),
(116, 'Registered an account', '2024-05-14 15:38:22', 10, 0),
(117, 'You logged in of your account', '2024-05-14 15:38:31', 0, 1),
(118, 'Changed Profile Picture', '2024-05-14 15:39:38', 9, 0),
(119, 'Logged out an account', '2024-05-14 15:40:11', 9, 0),
(120, 'Registered an account', '2024-05-14 15:41:38', 11, 0),
(121, 'You logged in of your account', '2024-05-14 15:41:55', 0, 1),
(122, 'Registered an account', '2024-05-14 15:49:28', 12, 0),
(123, 'You logged in of your account', '2024-05-14 15:56:29', 0, 1),
(124, 'You logged in of your account', '2024-05-15 01:49:23', 0, 1),
(125, 'Registered an account', '2024-05-15 02:02:39', 13, 0),
(126, 'You logged in of your account', '2024-05-15 02:05:28', 0, 1),
(127, 'You logged in of your account', '2024-05-15 02:05:34', 0, 1),
(128, 'You logged in of your account', '2024-05-15 02:05:43', 0, 1),
(129, 'Sent feedback', '2024-05-15 02:07:18', 2, 0),
(130, 'Logged out an account', '2024-05-15 02:23:35', 2, 0),
(131, 'Logged in an account', '2024-05-15 02:23:49', 9, 0),
(132, 'Sent feedback', '2024-05-15 02:24:58', 9, 0),
(133, 'You logged in of your account', '2024-05-15 02:25:12', 0, 1),
(134, 'Sent feedback', '2024-05-15 02:25:32', 9, 0),
(135, 'Logged out an account', '2024-05-15 03:11:08', 9, 0),
(136, 'Logged in an account', '2024-05-15 03:11:20', 11, 0),
(137, 'Sent feedback', '2024-05-15 03:11:47', 11, 0),
(138, 'You logged in of your account', '2024-05-15 03:12:01', 0, 1),
(139, 'You changed your profile picture', '2024-05-15 06:55:25', 0, 1),
(140, 'You changed your profile picture', '2024-05-15 09:47:31', 0, 1),
(141, 'You changed your profile picture', '2024-05-15 09:48:23', 0, 1),
(142, 'You logged in of your account', '2024-05-16 00:52:07', 0, 1),
(143, 'You changed your profile picture', '2024-05-16 02:19:16', 0, 1),
(144, 'You changed your profile picture', '2024-05-16 02:20:06', 0, 1),
(145, 'You changed your profile picture', '2024-05-16 02:24:07', 0, 1),
(146, 'You changed your profile picture', '2024-05-16 02:24:16', 0, 1),
(147, 'You logged in of your account', '2024-05-16 05:07:44', 0, 1),
(148, 'You logged in of your account', '2024-05-16 05:16:53', 0, 1),
(149, 'You updated your profile', '2024-05-16 05:40:11', 0, 1),
(150, 'You updated your profile', '2024-05-16 05:42:25', 0, 1),
(151, 'You updated your profile', '2024-05-16 05:42:42', 0, 1),
(152, 'You updated your profile', '2024-05-16 05:45:43', 0, 1),
(153, 'You updated your profile', '2024-05-16 05:51:58', 0, 1),
(154, 'You updated your profile', '2024-05-16 05:52:14', 0, 1),
(155, 'You changed your profile picture', '2024-05-16 05:54:32', 0, 1),
(156, 'You changed your profile picture', '2024-05-16 05:54:40', 0, 1),
(157, 'Changed Profile Picture', '2024-05-16 05:55:36', 2, 0),
(158, 'You updated your profile', '2024-05-16 06:00:36', 0, 1),
(159, 'You updated your profile', '2024-05-16 06:00:54', 0, 1),
(160, 'You logged in of your account', '2024-05-16 06:01:33', 0, 1),
(161, 'Changed Profile Picture', '2024-05-16 06:02:31', 2, 0),
(162, 'Sent feedback', '2024-05-16 06:04:02', 2, 0),
(163, 'Updated the profile', '2024-05-16 06:07:07', 2, 0),
(164, 'Logged out an account', '2024-05-16 06:08:35', 2, 0),
(165, 'Logged in an account', '2024-05-16 06:08:49', 4, 0),
(166, 'Updated the profile', '2024-05-16 06:09:14', 4, 0),
(167, 'Logged in an account', '2024-05-16 06:10:13', 4, 0),
(168, 'You logged in of your account', '2024-05-16 06:10:18', 0, 1),
(169, 'Updated the profile', '2024-05-16 06:12:57', 4, 0),
(170, 'Updated the profile', '2024-05-16 06:23:32', 4, 0),
(171, 'You logged out of your account', '2024-05-16 06:23:52', 0, 1),
(172, 'Logged in an account', '2024-05-16 06:24:16', 7, 0),
(173, 'Updated the profile', '2024-05-16 06:24:30', 7, 0),
(174, 'You logged in of your account', '2024-05-16 06:24:37', 0, 1),
(175, 'You logged in of your account', '2024-05-16 08:58:36', 0, 1),
(176, 'You logged in of your account', '2024-05-16 09:42:32', 0, 1),
(177, 'You logged in of your account', '2024-05-16 09:43:28', 0, 1),
(178, 'You logged in of your account', '2024-05-16 09:43:37', 0, 1),
(179, 'You logged in of your account', '2024-05-16 09:43:47', 0, 1),
(180, 'You logged in of your account', '2024-05-16 09:45:42', 0, 1),
(181, 'You logged in of your account', '2024-05-16 09:46:13', 0, 1),
(182, 'You logged in of your account', '2024-05-16 09:46:31', 0, 1),
(183, 'You logged in of your account', '2024-05-16 09:46:42', 0, 1),
(184, 'You logged in of your account', '2024-05-16 09:46:49', 0, 1),
(185, 'You logged in of your account', '2024-05-16 10:10:38', 0, 1),
(186, 'You logged in of your account', '2024-05-16 10:15:12', 0, 1),
(187, 'You logged in of your account', '2024-05-16 10:19:54', 0, 1),
(188, 'You logged in of your account', '2024-05-16 10:20:03', 0, 1),
(189, 'You logged in of your account', '2024-05-16 10:21:36', 0, 1),
(190, 'You changed your profile picture', '2024-05-16 15:13:46', 0, 1),
(191, 'You changed your profile picture', '2024-05-16 15:14:09', 0, 1),
(192, 'You logged in of your account', '2024-05-16 15:16:16', 0, 1),
(193, 'You updated your profile', '2024-05-16 15:16:27', 0, 1),
(194, 'You updated your profile', '2024-05-16 15:16:32', 0, 1),
(195, 'You logged in of your account', '2024-05-16 15:21:30', 0, 1),
(196, 'You logged in of your account', '2024-05-16 15:24:07', 0, 1),
(197, 'You logged in of your account', '2024-05-16 15:24:31', 0, 1),
(198, 'You logged out of your account', '2024-05-16 15:32:00', 0, 1),
(199, 'You logged in of your account', '2024-05-16 15:32:37', 0, 1),
(200, 'You logged out of your account', '2024-05-16 15:32:43', 0, 1),
(201, 'You logged in of your account', '2024-05-16 15:33:28', 0, 1),
(202, 'You logged out of your account', '2024-05-16 15:33:32', 0, 1),
(203, 'You logged in of your account', '2024-05-16 15:33:46', 0, 1),
(204, 'You logged out of your account', '2024-05-16 15:33:51', 0, 1),
(205, 'You logged in of your account', '2024-05-16 15:34:20', 0, 1),
(206, 'You logged in of your account', '2024-05-16 15:34:44', 0, 1),
(207, 'You logged out of your account', '2024-05-16 15:34:50', 0, 1),
(208, 'You logged in of your account', '2024-05-16 15:34:58', 0, 1),
(209, 'You logged out of your account', '2024-05-16 15:35:18', 0, 1),
(210, 'You logged in of your account', '2024-05-16 15:38:52', 0, 1),
(211, 'You logged out of your account', '2024-05-16 15:39:17', 0, 1),
(212, 'You logged in of your account', '2024-05-16 15:39:20', 0, 1),
(213, 'You logged out of your account', '2024-05-16 15:43:13', 0, 1),
(214, 'You logged in of your account', '2024-05-16 15:43:16', 0, 1),
(215, 'You logged out of your account', '2024-05-16 15:45:39', 0, 1),
(216, 'You logged in of your account', '2024-05-16 15:46:11', 0, 1),
(217, 'You logged in of your account', '2024-05-16 15:50:02', 0, 1),
(218, 'You logged out of your account', '2024-05-16 15:51:42', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_ID` int(20) NOT NULL,
  `userName` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_ID`, `userName`, `email`, `password`, `image`) VALUES
(1, 'Hermenia Nasara', 'hermenianasara@gmail.com', '1', '1_2024.05.16_05.14.09pm.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audio_feedback`
--

CREATE TABLE `tbl_audio_feedback` (
  `voice_ID` int(20) NOT NULL,
  `audio` blob NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customer_ID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_audio_feedback`
--

INSERT INTO `tbl_audio_feedback` (`voice_ID`, `audio`, `dateAdded`, `customer_ID`) VALUES
(1, '', '2024-05-11 13:36:53', 2),
(2, '', '2024-05-11 13:36:54', 2),
(3, '', '2024-05-11 13:39:28', 2),
(4, '', '2024-05-11 13:39:30', 2),
(5, '', '2024-05-11 13:39:30', 2),
(6, '', '2024-05-11 13:40:53', 2),
(7, '', '2024-05-11 13:40:54', 2),
(8, '', '2024-05-11 13:40:55', 2),
(9, '', '2024-05-14 10:14:51', 8),
(10, '', '2024-05-14 10:14:53', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_info`
--

CREATE TABLE `tbl_customer_info` (
  `customer_ID` int(20) NOT NULL,
  `firstName` varchar(200) NOT NULL,
  `middleName` varchar(200) NOT NULL,
  `lastName` varchar(200) NOT NULL,
  `street` varchar(200) NOT NULL,
  `barangay` varchar(200) NOT NULL,
  `municipality` varchar(200) NOT NULL,
  `province` varchar(200) NOT NULL,
  `zipcode` varchar(200) NOT NULL,
  `birthDate` date NOT NULL,
  `gender` varchar(200) NOT NULL,
  `phoneNumber` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dateModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer_info`
--

INSERT INTO `tbl_customer_info` (`customer_ID`, `firstName`, `middleName`, `lastName`, `street`, `barangay`, `municipality`, `province`, `zipcode`, `birthDate`, `gender`, `phoneNumber`, `email`, `password`, `dateAdded`, `dateModified`, `image`) VALUES
(1, 'Firstname', '', 'Lastname', '', '', '', '', '', '0000-00-00', '', '', 'Firstandlast@gmail.com', 'fal', '2024-05-16 06:05:23', '2024-05-16 06:05:23', '25_2023.11.14_03.40.18am'),
(2, 'Ryan', 'P.', 'Cepada', 'Zone 2', 'Dicklum', 'Manolo Fortich', 'Bukidnon', '8703', '2024-01-01', 'Male', '09614588546', 'Rhayeancepada@yahoo.com', '1', '2024-05-16 06:02:31', '2024-05-16 06:07:07', '2_2024.05.16_08.02.31am.png'),
(3, '', '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '2024-05-11 11:12:20', '2024-05-11 11:12:20', '25_2023.11.14_03.40.18am'),
(4, 'Firstname', 'M.', 'Lastname', 'Street', '', '', '', '', '2024-01-01', 'Female', '', 'Email', '1', '2024-05-16 06:23:32', '2024-05-16 06:23:32', '25_2023.11.14_03.40.18am'),
(5, 'FN', '', 'LN', '', '', '', '', '', '0000-00-00', '', '', 'EM', 'PW', '2024-05-11 11:19:06', '2024-05-11 11:19:06', 'profpic'),
(6, 'F', '', 'L', '', '', '', '', '', '0000-00-00', '', '', 'E', 'P', '2024-05-11 11:21:38', '2024-05-11 11:21:38', '6_2024.05.11_01.21.38pm.png'),
(7, 'Emman', 'O.', 'Ayco', '', '', '', '', '', '2024-01-01', 'Male', '', 'Dakiesayco@gmail.com', 'Baboyko17', '2024-05-16 06:24:30', '2024-05-16 06:24:30', '7_2024.05.14_08.17.08am.png'),
(8, 'Arnel', 'Neri', 'Puagang', 'Zone 4', 'Dicklum', 'Manolo Fortich', 'Bukidnon', '8703', '1999-10-22', 'Male', '0987654321', 'Arnelpuagang@gmail.com', '1', '2024-05-14 10:12:05', '2024-05-14 10:16:55', '8_2024.05.14_12.12.05pm.png'),
(9, 'Tamtam', '', 'Gwapo', '', '', '', '', '', '0000-00-00', '', '', 'Tamtam@gmail.com', 'meow', '2024-05-14 15:39:38', '2024-05-14 15:39:38', '9_2024.05.14_05.39.38pm.jpg'),
(10, 'Zebedee', '', 'Gift', '', '', '', '', '', '0000-00-00', '', '', 'Zebedeegift@gmail.com', 'awaw', '2024-05-14 15:38:22', '2024-05-14 15:38:22', '2_2024.05.05_04.48.56pm'),
(11, 'Pumba', '', 'Pumbz', '', '', '', '', '', '0000-00-00', '', '', 'Pumba@gmail.com', 'oink', '2024-05-14 15:41:38', '2024-05-14 15:41:38', '2_2024.05.05_04.48.56pm'),
(12, 'Fivey', '', 'Lopeytopey', '', '', '', '', '', '0000-00-00', '', '', 'Fivey@gmail.com', '5', '2024-05-14 15:49:28', '2024-05-14 15:49:28', '2_2024.05.05_04.48.56pm'),
(13, 'Sample', '', 'Sample', '', '', '', '', '', '0000-00-00', '', '', 'Sample@gmail.com', 'Sample', '2024-05-15 02:02:39', '2024-05-15 02:02:39', '2_2024.05.05_04.48.56pm');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedback`
--

CREATE TABLE `tbl_feedback` (
  `feedback_ID` int(20) NOT NULL,
  `opinion` text NOT NULL,
  `suggestion` text NOT NULL,
  `question` text NOT NULL,
  `rating` int(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customer_ID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_feedback`
--

INSERT INTO `tbl_feedback` (`feedback_ID`, `opinion`, `suggestion`, `question`, `rating`, `date`, `customer_ID`) VALUES
(1, 'sample ', 'sample', 'sample', 5, '2024-05-08 14:17:00', 2),
(2, 'a', 'a', 'a', 5, '2024-05-08 14:50:48', 2),
(3, 'Your product is one of the best for me!', 'Continue your service!', 'None', 5, '2024-05-13 16:03:54', 2),
(4, 'Naaaaah', 'more improvement', 'why am i single', 5, '2024-05-14 06:16:28', 7),
(5, 'All gooooods!', 'Consistency', 'Why?', 5, '2024-05-14 10:14:17', 8),
(6, 'Thank you!', 'Keep it up!', 'Are you open sunday?', 5, '2024-05-14 10:19:07', 2),
(7, 'sample', 'sample', 'sample', 4, '2024-05-14 10:20:36', 2),
(8, 'The best store in town', 'Keep your service consistenly', 'Do you have branches from different cities nearby?', 5, '2024-05-15 02:07:18', 2),
(9, 'What I needed in school are all in your store', 'Please open earlier', 'Are you open weekends?', 5, '2024-05-15 02:24:58', 9),
(10, 'Nice', 'None', 'None', 4, '2024-05-15 02:25:32', 9),
(11, 'thank you for the service', 'keep it up', 'None', 5, '2024-05-15 03:11:47', 11),
(12, 'Thank you so much for providing all my needs!', 'keet it up and more blessings!', 'None for now', 5, '2024-05-16 06:04:02', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_activity_logs`
--
ALTER TABLE `tbl_activity_logs`
  ADD PRIMARY KEY (`activity_ID`),
  ADD KEY `activity_ID` (`customer_ID`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_ID`);

--
-- Indexes for table `tbl_audio_feedback`
--
ALTER TABLE `tbl_audio_feedback`
  ADD PRIMARY KEY (`voice_ID`);

--
-- Indexes for table `tbl_customer_info`
--
ALTER TABLE `tbl_customer_info`
  ADD PRIMARY KEY (`customer_ID`);

--
-- Indexes for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  ADD PRIMARY KEY (`feedback_ID`),
  ADD KEY `feedback_ID` (`customer_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_activity_logs`
--
ALTER TABLE `tbl_activity_logs`
  MODIFY `activity_ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_audio_feedback`
--
ALTER TABLE `tbl_audio_feedback`
  MODIFY `voice_ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_customer_info`
--
ALTER TABLE `tbl_customer_info`
  MODIFY `customer_ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  MODIFY `feedback_ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
