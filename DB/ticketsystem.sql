-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2021 at 12:35 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticketsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` smallint(6) NOT NULL,
  `ticket_id` smallint(6) NOT NULL,
  `username` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `ticket_id`, `username`, `comment`, `time_stamp`) VALUES
(1, 1, 'bwayne', 'Request has been forwarded to Finance for approval.', '2021-04-27 00:04:09'),
(2, 1, 'bwayne', 'Request has been approved. The keyboard will shipped out to the address listed inn your account.', '2021-04-27 00:05:01'),
(3, 2, 'ballen', 'I would like to order this mouse:\r\n\r\nhttps://www.logitech.com/en-us/products/mice/mx-ergo-wireless-trackball-mouse.html', '2021-04-27 01:30:32'),
(4, 2, 'ballen', 'Thank you!', '2021-04-27 01:32:25'),
(5, 2, 'bwayne', 'Forwarded request to Finance for approval.', '2021-04-27 22:03:27'),
(6, 2, 'bwayne', 'Mouse has been shipped.', '2021-04-28 02:03:44'),
(7, 5, 'ballen', 'YAY', '2021-04-28 02:04:32');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` smallint(6) NOT NULL,
  `username` varchar(100) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `priority` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `assigned_to` varchar(100) DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `username`, `date_created`, `priority`, `title`, `description`, `assigned_to`, `status`) VALUES
(1, 'ballen', '2021-04-27 00:03:44', 'Low', 'Ergo Keyboard Request', 'I would like to request an ergo keyboard for my desk, please.', 'bwayne', 'Closed'),
(2, 'ballen', '2021-04-27 01:29:47', 'Low', 'Ergo Mouse Request', 'I would like to request an ergo mouse to use at my desk, please.', 'bwayne', 'Closed'),
(3, 'tdrake', '2021-04-27 01:34:01', 'Low', 'Ergo keyboard request', 'I would like to request an ergo keyboard to use at my desk, please.', 'dschwen', 'Pending'),
(4, 'bwayne', '2021-04-27 01:35:19', 'Low', 'Request for 2nd monitor', 'I\'m requesting a second monitor to use at my desk, to increase productivity.\r\n\r\n\r\nThank you.', NULL, 'Open'),
(5, 'ballen', '2021-04-28 02:04:13', 'Low', 'LAMP', 'I WANT A LAMP', NULL, 'Open');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `f_name` varchar(100) NOT NULL,
  `l_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_num` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `level` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `f_name`, `l_name`, `email`, `phone_num`, `department`, `title`, `level`) VALUES
('ballen', '$2y$10$8DNtOvBxjTUJ/q9z0S9imuDHxV3utIESUjAwNjnNr3TEwO/JXjmTe', 'Barry', 'Allen', 'capstone.normal.user@gmail.com', '123-456-7892', 'Shipping', 'Manager', 1),
('bwayne', '$2y$10$gq7MTzhwyMlo38QOupSORucC9TfpZTQ.f6Yj4voU6XfjpaX.2tB0a', 'Bruce', 'Wayne', 'capstone.it.manager@gmail.com', '123-456-7890', 'IT Support', 'Manager', 3),
('dschwen', '$2y$10$iYIwge13I8KVWL.vS3taUugtrJh7H2J8P6T43fyl9qRGF0OcG3Gq.', 'Daniel', 'Schwen', 'daniel.schwen@my.metrostate.edu', '(651) 341-3972', 'IT Support', 'Department Lead', 2),
('tdrake', '$2y$10$W.8fKPOApcuyMaI6GZyrv.8Kqe7QuJHGfpYVSL/KiPb5PYtTwiWJK', 'Tim', 'Drake', 'capstone.it.user@gmail.com', '123-456-7891', 'IT Support', 'Rep', 2);

-- --------------------------------------------------------

--
-- Table structure for table `userstatus`
--

CREATE TABLE `userstatus` (
  `username` varchar(100) NOT NULL,
  `new_user` varchar(10) NOT NULL DEFAULT 'Yes',
  `password_reset` varchar(10) NOT NULL DEFAULT 'Yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userstatus`
--

INSERT INTO `userstatus` (`username`, `new_user`, `password_reset`) VALUES
('ballen', 'No', 'No'),
('bwayne', 'No', 'No'),
('dschwen', 'Yes', 'No'),
('tdrake', 'No', 'No');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `userstatus`
--
ALTER TABLE `userstatus`
  ADD PRIMARY KEY (`username`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `userstatus`
--
ALTER TABLE `userstatus`
  ADD CONSTRAINT `userstatus_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
