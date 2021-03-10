-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2021 at 04:53 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prototypev1`
--

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `priority` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `assigned_to` varchar(100) DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `date_created`, `priority`, `description`, `created_by`, `assigned_to`, `status`) VALUES
(1, '2021-02-16 21:35:17', 'HIGH', 'Please add the following member to our team:\r\n                                                                      Carol Danvers\r\n                                                                      (651) 123-5555\r\n                                                                      pewpewpew@fakedomain.com\r\n                                                                      Position: intern', 'dlance', NULL, 'Open'),
(2, '2021-02-16 21:38:31', 'High', 'My computer keeps showing a driver error, but I took the bus to work this morning!\r\n                                                                      FIX IT!!', 'ckent', NULL, 'Open'),
(3, '2021-02-16 21:39:03', 'Low', 'Could I get an ergo keyboard at my desk, please?', 'ballen', NULL, 'Open'),
(4, '2021-02-16 22:11:25', 'Medium', 'Can\'t connect to the printer with my computer, but I can transfer files to print on the printer using a USB thumb drive. This is just a temporary work-around, as we REALLY need to be able to connect to the printer via our computers.\r\n                                                                       \r\n                                                                       Thanks!', 'zzatara', NULL, 'Open'),
(5, '2021-02-17 18:15:24', 'Medium', 'My laptop only has USB C ports, but I need to be able to connect to other devices via USB A. I need an adapter/hub.\r\n                                                                      \r\n                                                                      Thanks!\r\n                                                                      \r\n                                                                      Barry Allen', 'ballen', NULL, 'Open'),
(6, '2021-02-17 20:52:52', 'Low', 'Could I also get an ergo mouse at my desk, perhaps something like the Logitech mx ergo plus?', 'ballen', NULL, 'Open'),
(9, '2021-02-17 20:58:04', 'High', 'OMG,IDROPPEDMYLAPTOP,ANDNOWTHESPACEBARDOESN\'TWORK!!\r\n\r\nHELPME!!', 'ballen', NULL, 'Open'),
(10, '2021-02-17 21:00:11', 'HIGH', 'OH,GREAT,NOWCAPSLOCKWON\'TTURNOFFASWELL!!\r\n\r\nIREALLYNEEDANEWLAPTOP!!!', 'ballen', NULL, 'Open');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `password`, `first_name`, `last_name`, `email`, `phone_number`, `department`, `position`) VALUES
('ballen', 'bd2f6a1d5242c962a05619c56fa47ba6', 'Barry', 'Allen', 'fastguy@fakedomain.com', '(651) 123-4567', 'Shipping', 'Manager'),
('bwayne', 'ec0e2603172c73a8b644bb9456c1ff6e', 'Bruce', 'Wayne', 'richguy@fakedomain.com', '(651) 123-4568', 'Leadership', 'CFO'),
('ckent', '84d961568a65073a3bcf0eb216b2a576', 'Clark', 'Kent', 'farmville@fakedomain.com', '(651) 123-4569', 'Leadership', 'COO'),
('dlance', 'e9c301173ce21989606bc4ae36587aea', 'Dinah', 'Lance', 'loleardrums@fakedomain.com', '(651) 123-4570', 'HR', 'Manager'),
('dprince', '03e5bf83eef4b1d1dbb3c566bdef703f', 'Diana', 'Prince', 'princessbadass@fakedomain.com', '(651) 123-4571', 'Leadership', 'CEO'),
('dschwen', '827ccb0eea8a706c4c34a16891f84e7b', 'Daniel', 'Schwen', 'daniel.schwen@fakedomain.com', '(651) 123-4572', 'IT Support', 'Manager'),
('hjordan', '0ea32a4dcab9c7efbe6f5eca3b9b8417', 'Hal', 'Jordan', 'ringslinger@fakedomain.com', '(651) 123-4573', 'Marketing', 'Manager'),
('jcruz', '0ea32a4dcab9c7efbe6f5eca3b9b8417', 'Jessica', 'Cruz', 'betterringslinger@fakedomain.com', '(651) 123-4574', 'Shipping', 'Manager'),
('jjones', 'c0016d525ff2fd7238ec68982f19426c', 'John', 'Jones', 'imissmars@fakedomain.com', '(651) 123-4575', 'HR', 'Manager'),
('jsmith01', '827ccb0eea8a706c4c34a16891f84e7b', 'John', 'Smith', 'john.smith.01@fakedomain.com', '(651) 123-4576', 'Finance', 'Manager'),
('jsmith02', '827ccb0eea8a706c4c34a16891f84e7b', 'Jacob', 'Smith', 'john.smith.02@fakedomain.com', '(651) 123-4577', 'IT Support', 'Level 1 Support'),
('shol', '7f6d8fc21e102e4284d48c0368438d87', 'Shayera', 'Hol', 'hammertime@fakedomain.com', '(651) 123-4578', 'Legal', 'Manager'),
('zzatara', '159909c551b3be76bf772bb0275558ac', 'Zatanna', 'Zatara', 'spellsgopewpew@fakedomain.com', '(651) 123-4579', 'Finance', 'Manager');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
