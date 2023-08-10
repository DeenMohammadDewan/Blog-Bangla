-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2022 at 03:56 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mycms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `aname` varchar(30) NOT NULL,
  `aheadline` varchar(30) NOT NULL,
  `abio` varchar(500) NOT NULL,
  `aimage` varchar(60) NOT NULL DEFAULT 'avatar.png',
  `addedby` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `datetime`, `username`, `password`, `aname`, `aheadline`, `abio`, `aimage`, `addedby`) VALUES
(10, 'April-22-2022 23:52:14', 'a', '1234', 'b', '', '', '', 'blogbangla'),
(11, 'April-22-2022 23:52:43', 'x', '1234', '', '', '', 'horlicks.jpg', 'blogbangla'),
(12, 'April-22-2022 23:53:01', 'i', '1234', 'j', '', '', '', 'blogbangla'),
(13, 'April-22-2022 23:53:16', 'p', '1234', 'q', '', '', '', 'blogbangla'),
(14, 'April-23-2022 20:19:06', 'e', '1234', 'f', '', '', 'avatar.png', 'blogbangla'),
(15, 'April-24-2022 05:34:25', 'victor', '1234', 'victor Bhai', 'eihce8coechn;ojeapo', 'ujjjjjjeqf9bxc8t---\n=', 'bournvita.jpg', 'blogbangla');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `datetime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `author`, `datetime`) VALUES
(9, 'Car2', 'blogbangla', 'April-13-2022 21:29:45'),
(12, 'Car5', 'blogbangla', 'April-13-2022 21:30:06'),
(13, 'yjdtryjr', 'admin1', 'April-22-2022 23:51:41'),
(14, 'yrjj', 'admin1', 'April-22-2022 23:51:44'),
(15, 'yjrrrt', 'admin1', 'April-22-2022 23:51:49'),
(16, 'rurjyrr', 'admin1', 'April-22-2022 23:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `approvedby` varchar(50) NOT NULL,
  `status` varchar(3) NOT NULL,
  `post_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `datetime`, `name`, `email`, `comment`, `approvedby`, `status`, `post_id`) VALUES
(4, 'April-15-2022 22:19:33', 'hgds', 'qkjbca@jiod.os', 'qdgvwyduyuieuw', 'Pending', 'OFF', 8),
(5, 'April-15-2022 22:35:19', 'scwkjhnkwdcfh', 'ehbjiwbfiu@kjjdw.jihjs', 'hjwbdgyefiuliwe', 'admin', 'ON', 8),
(6, 'April-22-2022 05:04:26', 'hh', 'qkjbca@jiod.os', 'nnnnnnnnnnnnnnnnnn', 'Pending', 'OFF', 8);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `title` varchar(300) NOT NULL,
  `category` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `post` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `datetime`, `title`, `category`, `author`, `image`, `post`) VALUES
(8, 'April-13-2022 21:35:28', 'Amazing Car uiywieuh', 'Car2', 'blogbangla', 'download.jpg', 'ygey'),
(10, 'April-13-2022 21:36:38', 'Good Car', 'Car5', 'blogbangla', 'Car5.avif', 'For new users, get the insights of a NMVTIS approved provider! A Bumper report can help provide you with information about a vehicle.'),
(12, 'April-22-2022 23:51:23', 'HEllotest', 'Car5', 'admin1', 'download (2)hh.jpg', 'yururtutr'),
(13, 'April-23-2022 00:05:58', 'oihoi', 'yjrrrt', 'admin1', 'download.jpg', ';l'),
(14, 'April-23-2022 00:06:09', 'HEllotestdt', 'Car2', 'admin1', 'download (1).jpg', 'jio'),
(15, 'April-23-2022 00:06:36', 'iubbhnuo', 'Car2', 'admin1', 'download (2)hh.jpg', 'uvuygfui'),
(16, 'April-24-2022 04:18:47', 'tyterytytyt', 'Car2', 'x', 'avatar.png', 'rhtyr'),
(17, 'April-24-2022 04:19:48', 'HEllotestd', 'Car2', 'p', 'avatar.png', 'kbjki'),
(18, 'April-24-2022 05:28:11', 'HEllotest', 'Car2', 'i', 'bournvita.jpg', 'j');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Foreign_Relation` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
