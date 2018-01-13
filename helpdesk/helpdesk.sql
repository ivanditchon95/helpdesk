-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2018 at 05:32 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helpdesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `acc_id` int(10) NOT NULL,
  `acc_type` varchar(10) NOT NULL,
  `acc_username` varchar(50) NOT NULL,
  `acc_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`acc_id`, `acc_type`, `acc_username`, `acc_password`) VALUES
(1, 'admin', 'admin', 'admin'),
(62, 'user', 'ivan', '123');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department`) VALUES
(1, 'CCS'),
(2, 'CAS'),
(3, 'CBA'),
(4, 'CEN'),
(5, 'CHS'),
(6, 'CED');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(10) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `emp_fname` varchar(50) NOT NULL,
  `emp_mname` varchar(50) NOT NULL,
  `emp_lname` varchar(50) NOT NULL,
  `emp_email` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `acc_id`, `emp_fname`, `emp_mname`, `emp_lname`, `emp_email`) VALUES
(55, 62, 'ivan', 'singayen', 'ditchon', 'ivan@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `helpdesk`
--

CREATE TABLE `helpdesk` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `severity_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `concerns` text NOT NULL,
  `date` text NOT NULL,
  `date2` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `helpdesk`
--

INSERT INTO `helpdesk` (`id`, `employee_id`, `severity_id`, `status_id`, `department_id`, `concerns`, `date`, `date2`) VALUES
(137, 55, 1, 4, 1, 'sdadgggffvvttt', 'Thursday 11th of January 2018 01:39:29 PM', 'Thursday 11th of January 2018 02:47:06 PM'),
(138, 55, 1, 4, 1, 'sfdfdf', 'Thursday 11th of January 2018 01:39:38 PM', 'Saturday 13th of January 2018 01:14:25 AM'),
(139, 55, 1, 4, 4, 'gggg', 'Friday 12th of January 2018 01:23:59 PM', 'Saturday 13th of January 2018 01:21:19 AM'),
(140, 55, 1, 4, 1, 's', 'Friday 12th of January 2018 11:16:58 PM', 'Saturday 13th of January 2018 01:21:19 AM'),
(141, 55, 1, 4, 1, 'fff', 'Saturday 13th of January 2018 12:15:42 AM', 'Saturday 13th of January 2018 01:21:19 AM'),
(142, 55, 1, 4, 1, 'fff', 'Saturday 13th of January 2018 12:15:45 AM', 'Saturday 13th of January 2018 01:21:19 AM'),
(143, 55, 1, 4, 1, 'dfdf', 'Saturday 13th of January 2018 12:15:50 AM', 'Saturday 13th of January 2018 01:21:19 AM'),
(144, 55, 1, 4, 1, 'd', 'Saturday 13th of January 2018 01:22:20 AM', 'Saturday 13th of January 2018 01:22:28 AM'),
(145, 55, 1, 4, 1, 'ddd', 'Saturday 13th of January 2018 01:25:26 AM', 'Saturday 13th of January 2018 01:25:32 AM'),
(146, 55, 1, 4, 1, 'ddddd', 'Saturday 13th of January 2018 01:25:46 AM', 'Saturday 13th of January 2018 01:26:13 AM');

-- --------------------------------------------------------

--
-- Table structure for table `severity`
--

CREATE TABLE `severity` (
  `severity_id` int(11) NOT NULL,
  `severity` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `severity`
--

INSERT INTO `severity` (`severity_id`, `severity`) VALUES
(1, 'MINOR'),
(2, 'MAJOR'),
(3, 'CRITICAL');

-- --------------------------------------------------------

--
-- Table structure for table `stat`
--

CREATE TABLE `stat` (
  `status_id` int(10) NOT NULL,
  `stat` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stat`
--

INSERT INTO `stat` (`status_id`, `stat`) VALUES
(1, 'Pending'),
(2, 'Approved'),
(3, 'Ongoing'),
(4, 'Solved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `acc_id` (`acc_id`);

--
-- Indexes for table `helpdesk`
--
ALTER TABLE `helpdesk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `severity_id` (`severity_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `severity`
--
ALTER TABLE `severity`
  ADD PRIMARY KEY (`severity_id`);

--
-- Indexes for table `stat`
--
ALTER TABLE `stat`
  ADD PRIMARY KEY (`status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `acc_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `helpdesk`
--
ALTER TABLE `helpdesk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `severity`
--
ALTER TABLE `severity`
  MODIFY `severity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stat`
--
ALTER TABLE `stat`
  MODIFY `status_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
