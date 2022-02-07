-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2022 at 04:38 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `share_learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` bigint(20) NOT NULL,
  `incoming_id` int(255) NOT NULL,
  `outgoing_id` int(255) NOT NULL,
  `message` text NOT NULL,
  `message_sent_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `incoming_id`, `outgoing_id`, `message`, `message_sent_date`) VALUES
(1, 2, 1, 'This is aa test', '2021-12-25 02:21:22'),
(2, 1, 2, 'Okay I got it !!', '2021-12-25 03:00:44'),
(3, 2, 1, 'kl', '2021-12-25 03:21:22'),
(4, 2, 1, 'Is it okay?', '2021-12-25 03:22:54'),
(5, 1, 2, 'Yup, Perfect', '2021-12-25 03:23:35'),
(22, 2, 1, 'hello', '2021-12-27 00:30:48'),
(23, 2, 1, 'who are you', '2021-12-27 00:30:57'),
(24, 2, 1, 'who are you?', '2021-12-27 00:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `bookName` varchar(256) NOT NULL,
  `author` varchar(256) DEFAULT NULL,
  `description` text NOT NULL,
  `boughtDate` date NOT NULL,
  `price` float NOT NULL,
  `bookCount` int(5) NOT NULL,
  `wishlisted` tinyint(1) NOT NULL DEFAULT 2,
  `postType` enum('S','B') NOT NULL DEFAULT 'S',
  `postRating` float DEFAULT NULL,
  `postedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `userId`, `bookName`, `author`, `description`, `boughtDate`, `price`, `bookCount`, `wishlisted`, `postType`, `postRating`, `postedOn`) VALUES
(1, 1, 'C Programming Fundamentals II Edition', 'Rahul Rimal', 'This is a test book. Sell it here!!', '2020-11-05', 600, 2, 1, 'S', 4, '2021-07-26 08:51:28'),
(2, 1, 'Data Structures and Algorithms Revised Edition', 'Rahul Rimal', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2021-05-01', 900, 1, 2, 'B', 3.5, '2021-07-26 08:51:28'),
(3, 1, 'Mathematics II', 'Surendra Jha', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2021-02-17', 400, 4, 1, 'B', 2, '2021-07-26 08:53:17'),
(4, 3, 'Computer Networking', 'Krishna Prasad Rimal', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2021-07-02', 900, 2, 1, 'S', 2.5, '2021-07-26 08:53:17'),
(13, 1, 'Test Book name with api', 'Krishna Pd. Rimal', 'This is a test description of test book with api', '2020-01-01', 500, 5, 2, 'S', 5, '2021-11-01 13:22:10');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` bigint(20) NOT NULL,
  `postId` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `body` text NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `postId`, `userId`, `body`, `createdDate`) VALUES
(1, 0, 0, 'This is a great book. Hope I\'ll be able to get this book one day.', '2021-07-29 17:48:28'),
(2, 2, 0, 'I\'ll like to get this one !!', '2021-07-29 17:48:28');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` bigint(20) NOT NULL COMMENT 'Session ID',
  `userId` bigint(20) NOT NULL,
  `accessToken` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'access token',
  `accessTokenExpiry` datetime NOT NULL COMMENT 'Access token expiry date/time',
  `refreshToken` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'refresh token',
  `refreshTokenExpiry` datetime NOT NULL COMMENT 'refresh token expiry date/time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Sessions Table';

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `userId`, `accessToken`, `accessTokenExpiry`, `refreshToken`, `refreshTokenExpiry`) VALUES
(2, 0, 'OGYwYTQ3YTA1ZGJlMTY3MTY5MzM2NTJkNDgxMzkzNWM4OTc4OWQ2OWYxYzMxYmEw1635066980', '2021-10-24 15:21:20', 'OGNhZjExMWM2NjA0YmI2MGY1NTFiZTcyYjM3ZWUxNjA4ZThkZWVkNDIwOGM4ZWYw1635066980', '2022-11-07 15:01:20'),
(23, 1, 'MmJkMjU5MTM5NmNmNTkyNTdmMGEzY2EzOTExY2U2ZWE3YTU0ZDk3NDAxM2ZiMzViMzEzNjMzMzUzNzM3MzEzOTM1MzY=', '2021-11-05 19:24:37', 'ZDRlMzFmNzgzMWJmNDE4NzJkYmYyMTU0MzQ4YjExOGNkODY3ODdkZDBlMDRiOGU3MzEzNjMzMzUzNzM3MzEzOTM1MzY=', '2022-11-01 19:24:37'),
(69, 1, 'NDJlY2RlMTczMWZiODIxNDhkMjc0NDA1MDhmODdiZDMwOGVlZDYzNjFiZDlkNjA5MzEzNjM0MzAzNzMwMzgzMDMzMzA=', '2021-12-28 22:32:31', 'ODBhNDZkMzFkNmU1YjIwMTVlNWY1MTUxZGU0NTA4NjI5Mjg2YTljYTU2MzM0YmJlMzEzNjM0MzAzNzMwMzgzMDMzMzA=', '2021-12-28 22:32:32'),
(70, 1, 'NDkyYTZlMjQ0Mjg5YmUwOTA1YjkxOTkxNzQ2ZDEyZDU5Mjg3OTdhMTNjMjFmNWUzMzEzNjM0MzAzNzMwMzgzNDM1MzM=', '2021-12-28 22:39:34', 'ZDliODk4YzhjMjQ0NzUyZjk2N2YwNzQ2ZjVjNzAwMTIxMjBkMGE4YzJiNDc4ZjFiMzEzNjM0MzAzNzMwMzgzNDM1MzM=', '2021-12-28 22:39:35'),
(71, 1, 'ZGNmOWRkMjhiNjViYTAwM2I0MjY5NDA2NjI2ZDUyYjY4YmE4NTY2YmM0YjY3YWVkMzEzNjM0MzAzNzMwMzgzNDM5MzY=', '2021-12-28 22:40:17', 'NDg2ZTE5MzQyMzAxY2I3OTQyNzFmYTgwZWRmNDM0ODEyNGM1M2EwNWNmOGI5NTY2MzEzNjM0MzAzNzMwMzgzNDM5MzY=', '2021-12-28 22:40:18'),
(72, 1, 'NjNmNDU0MDBmMGQ4ZDFlMzExNTU0NjFkZTFiZjUzYjRmNGQ5ODY4OWEwNDhlYzhjMzEzNjM0MzAzNzMwMzgzODM4Mzg=', '2021-12-28 22:46:49', 'ODhmYThlYTNkM2I2YWM2ZjA0Yzk1ZmU4Mjg4NTEyMTRiYzVjYzAyYmQ3YTVhMTYyMzEzNjM0MzAzNzMwMzgzODM4Mzg=', '2021-12-28 22:46:50'),
(73, 1, 'YjY3Y2I0ZWNhZGNmMmM1MGUxOWQ1NmE2YWM0YTRmNGY0MTgyZTNlYTA2MGEyNjIwMzEzNjM0MzAzNzMwMzkzMDMwMzA=', '2021-12-28 22:48:41', 'MjMzMGMwMGFmNjgwYWZkZjFmMzU3OGQ1MWVmOTJhZDE4NDIyOTllNTA5MjQ0YTY4MzEzNjM0MzAzNzMwMzkzMDMwMzA=', '2021-12-28 22:48:42'),
(74, 1, 'MWFhOWI5ZGY1NDFiZTkwMWVlNzA1NjcwMjdjNTdmMGYyODZkNGE2MWZkNjgzMDJmMzEzNjM0MzAzNzMxMzAzNTM3MzQ=', '2021-12-28 23:14:55', 'ZGZlYWE2ODkxMDdhOWVlNmNjYTM4MTA3MDc5ZjgyMzY4MjcyYzk1M2NmYjJlMmY4MzEzNjM0MzAzNzMxMzAzNTM3MzQ=', '2021-12-28 23:14:56'),
(75, 1, 'MGZkZTA2MTRhYzcwNTY3YjA3MDY4N2Y1YTFhMDUzNTZiYzk3ZDZkOGQ2OTI0YTUwMzEzNjM0MzAzNzMxMzEzNTMxMzc=', '2021-12-28 23:30:38', 'MjU1MTAxNGFmNTc3MmI3Zjk0NDM0NTY5ODhlOGFlMDBmOTE4MGZjODJjOGRiOTAyMzEzNjM0MzAzNzMxMzEzNTMxMzc=', '2021-12-28 23:30:39');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(256) DEFAULT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `picture` varchar(256) DEFAULT NULL,
  `class` varchar(256) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `followers` text DEFAULT NULL,
  `userCreatedDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `firstName`, `lastName`, `picture`, `class`, `description`, `followers`, `userCreatedDate`) VALUES
(1, 'rahulR', '12345678', 'rahul@mail.com', 'Rahul', 'Rimal', 'portrait.jpg', '15', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2,3', '2021-07-26 09:00:19'),
(2, 'shreeR', 'newTestPass', 'shree@mail.com', 'Srijana', 'Rimal', 'Share Your Learning.png', 'Bachelors', NULL, '1', '2021-07-26 09:02:20'),
(3, 'surendra_R', '123', 'surendra@mail.com', 'Surendra', 'Rana', 'portrait.jpg', '9', NULL, NULL, '2021-07-26 09:02:20'),
(23, 'ewTdfdfest,', 'sadkkkkass', 'test@mail.com', 'newFirst', 'newLast', NULL, 'CSIT', 'hy thereeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee', NULL, '2021-10-29 03:25:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accesstoken` (`accessToken`),
  ADD UNIQUE KEY `refreshtoken` (`refreshToken`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Session ID', AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
