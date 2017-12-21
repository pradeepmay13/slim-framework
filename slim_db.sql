-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2017 at 11:24 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slim_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `name`, `job`) VALUES
(1, 'Sam', 'Gardener'),
(2, 'Molly', 'Chef'),
(3, 'Evan', 'Web Developer');

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `book_id` int(11) NOT NULL,
  `book_name` varchar(100) NOT NULL,
  `book_isbn` varchar(100) NOT NULL,
  `book_category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `library`
--

INSERT INTO `library` (`book_id`, `book_name`, `book_isbn`, `book_category`) VALUES
(1, 'PHP', 'bk001', 'Server Side'),
(3, 'javascript', 'bk002', 'Client Side'),
(4, 'Python', 'bk003', 'Data Analysis'),
(5, '3Idiots', '3213232', '123456'),
(8, '3Idiots', '3213232', '123456'),
(9, 'dfds', 'fdsfds', 'fsdsfdsf');

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `update_id` int(11) NOT NULL,
  `user_update` text,
  `user_id_fk` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `upload_files`
--

CREATE TABLE `upload_files` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `fileOrigName` varchar(255) NOT NULL,
  `fileNewName` varchar(255) NOT NULL,
  `fileType` varchar(255) NOT NULL,
  `delete_fg` int(2) NOT NULL DEFAULT '0',
  `status_fg` int(2) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `upload_files`
--

INSERT INTO `upload_files` (`id`, `userId`, `fileOrigName`, `fileNewName`, `fileType`, `delete_fg`, `status_fg`, `created_date`) VALUES
(1, 1, '2_20171123 DB Schenker_SAP Application ManagementRfI_Questions_v1.0.xlsx', 'b082f3331daba8e9d2878790995aa57f.xlsx', '.xlsx', 0, 1, '2017-12-21 10:21:33'),
(2, 1, '2_20171123 DB Schenker_SAP Application ManagementRfI_Questions_v1.0.xlsx', 'd9ce81add207fc5dc7389ce2bc56c6c4.xlsx', '.xlsx', 0, 1, '2017-12-21 10:22:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email_id` varchar(255) NOT NULL,
  `profile_pic` varchar(200) DEFAULT NULL,
  `token` varchar(255) NOT NULL DEFAULT 'logged out',
  `status` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `name`, `email_id`, `profile_pic`, `token`, `status`) VALUES
(1, 'admin', 'admin', 'Admin', 'admin@gmail.com', NULL, 'admin | 5a38c4563f0715a38c4563f0715a38c4563f071', 1),
(2, 'pradeep', 'pradeep', 'Pradeep', 'pradeep@gmail.com', NULL, 'logged out', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_temp`
--

CREATE TABLE `users_temp` (
  `userid` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `addressline` varchar(255) NOT NULL,
  `postalCode` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `aboutYou` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `token` varchar(255) NOT NULL DEFAULT 'logged out'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`update_id`);

--
-- Indexes for table `upload_files`
--
ALTER TABLE `upload_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `library`
--
ALTER TABLE `library`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `update_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `upload_files`
--
ALTER TABLE `upload_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
