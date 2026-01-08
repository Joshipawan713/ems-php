-- phpMyAdmin SQL Dump
-- version 5.2.3-1.el9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 08, 2026 at 11:15 AM
-- Server version: 10.5.29-MariaDB
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `password` varchar(600) NOT NULL,
  `add_date` varchar(20) NOT NULL,
  `add_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `unique_id`, `name`, `email`, `mobile`, `password`, `add_date`, `add_time`) VALUES
(1, 'EMP-ADM-1', 'Admin', 'admin@gmail.com', '9999999999', '827ccb0eea8a706c4c34a16891f84e7b', '2026-01-02', '22:50:08');

-- --------------------------------------------------------

--
-- Table structure for table `advance_payment`
--

CREATE TABLE `advance_payment` (
  `id` int(11) NOT NULL,
  `avd_pay_id` varchar(100) NOT NULL,
  `emp_id` varchar(100) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `remarks` text NOT NULL,
  `emp_salary_id` varchar(100) NOT NULL,
  `paid_date` varchar(20) NOT NULL,
  `paid_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advance_payment`
--

INSERT INTO `advance_payment` (`id`, `avd_pay_id`, `emp_id`, `amount`, `remarks`, `emp_salary_id`, `paid_date`, `paid_time`) VALUES
(1, 'EMP-AVD-PAY-1', 'EMP-USR-1', '2000', 'Adnace Payment For Testing Person', '0', '2026-01-08', '15:33:38');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(100) NOT NULL,
  `attendance_date` varchar(20) NOT NULL,
  `attendance_time` varchar(20) NOT NULL,
  `branch_code` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `emp_id`, `attendance_date`, `attendance_time`, `branch_code`, `status`) VALUES
(1, 'EMP-1', '2025-01-01', '22:17:08', 'BC-2026-1', 'P'),
(2, 'EMP-1', '2025-01-02', '22:17:08', 'BC-2026-1', 'P'),
(3, 'EMP-1', '2025-01-03', '22:17:08', 'BC-2026-1', 'P'),
(4, 'EMP-1', '2025-01-04', '22:17:08', 'BC-2026-1', 'P'),
(5, 'EMP-1', '2025-01-05', '22:17:08', 'BC-2026-1', 'P'),
(6, 'EMP-1', '2025-01-06', '22:17:08', 'BC-2026-1', 'P'),
(7, 'EMP-1', '2025-01-07', '22:17:08', 'BC-2026-1', 'P'),
(8, 'EMP-1', '2025-01-08', '22:17:08', 'BC-2026-1', 'P'),
(9, 'EMP-1', '2025-01-09', '22:17:08', 'BC-2026-1', 'P'),
(10, 'EMP-1', '2025-01-10', '22:17:08', 'BC-2026-1', 'P'),
(11, 'EMP-1', '2025-01-11', '22:17:08', 'BC-2026-1', 'P'),
(12, 'EMP-1', '2025-01-12', '22:17:08', 'BC-2026-1', 'P'),
(13, 'EMP-1', '2025-01-13', '22:17:08', 'BC-2026-1', 'P'),
(14, 'EMP-1', '2025-01-14', '22:17:08', 'BC-2026-1', 'P'),
(15, 'EMP-1', '2025-01-15', '22:17:08', 'BC-2026-1', 'P'),
(16, 'EMP-1', '2025-01-16', '22:17:08', 'BC-2026-1', 'P'),
(17, 'EMP-1', '2025-01-17', '22:17:08', 'BC-2026-1', 'P'),
(18, 'EMP-1', '2025-01-18', '22:17:08', 'BC-2026-1', 'P'),
(19, 'EMP-1', '2025-01-19', '22:17:08', 'BC-2026-1', 'P'),
(20, 'EMP-1', '2025-01-20', '22:17:08', 'BC-2026-1', 'P'),
(21, 'EMP-1', '2025-01-21', '22:17:08', 'BC-2026-1', 'P'),
(22, 'EMP-1', '2025-01-22', '22:17:08', 'BC-2026-1', 'P'),
(23, 'EMP-1', '2025-01-23', '22:17:08', 'BC-2026-1', 'P'),
(24, 'EMP-1', '2025-01-24', '22:17:08', 'BC-2026-1', 'P'),
(25, 'EMP-1', '2025-01-25', '22:17:08', 'BC-2026-1', 'P'),
(26, 'EMP-1', '2025-01-26', '22:17:08', 'BC-2026-1', 'P'),
(27, 'EMP-1', '2025-01-27', '22:17:08', 'BC-2026-1', 'P'),
(28, 'EMP-1', '2025-01-28', '22:17:08', 'BC-2026-1', 'P'),
(29, 'EMP-1', '2025-01-29', '22:17:08', 'BC-2026-1', 'P'),
(30, 'EMP-1', '2025-01-30', '22:17:08', 'BC-2026-1', 'P'),
(31, 'EMP-1', '2025-01-31', '22:17:08', 'BC-2026-1', 'P'),
(32, 'EMP-4', '2025-01-01', '22:17:08', 'BC-2026-1', 'L'),
(33, 'EMP-4', '2025-01-02', '22:17:08', 'BC-2026-1', 'L'),
(34, 'EMP-4', '2025-01-03', '22:17:08', 'BC-2026-1', 'L'),
(35, 'EMP-4', '2025-01-04', '22:17:08', 'BC-2026-1', 'L'),
(36, 'EMP-4', '2025-01-05', '22:17:08', 'BC-2026-1', 'L'),
(37, 'EMP-4', '2025-01-06', '22:17:08', 'BC-2026-1', 'L'),
(38, 'EMP-4', '2025-01-07', '22:17:08', 'BC-2026-1', 'L'),
(39, 'EMP-4', '2025-01-08', '22:17:08', 'BC-2026-1', 'L'),
(40, 'EMP-4', '2025-01-09', '22:17:08', 'BC-2026-1', 'L'),
(41, 'EMP-4', '2025-01-10', '22:17:08', 'BC-2026-1', 'L'),
(42, 'EMP-4', '2025-01-11', '22:17:08', 'BC-2026-1', 'L'),
(43, 'EMP-4', '2025-01-12', '22:17:08', 'BC-2026-1', 'L'),
(44, 'EMP-4', '2025-01-13', '22:17:08', 'BC-2026-1', 'L'),
(45, 'EMP-4', '2025-01-14', '22:17:08', 'BC-2026-1', 'L'),
(46, 'EMP-4', '2025-01-15', '22:17:08', 'BC-2026-1', 'L'),
(47, 'EMP-4', '2025-01-16', '22:17:08', 'BC-2026-1', 'L'),
(48, 'EMP-4', '2025-01-17', '22:17:08', 'BC-2026-1', 'L'),
(49, 'EMP-4', '2025-01-18', '22:17:08', 'BC-2026-1', 'L'),
(50, 'EMP-4', '2025-01-19', '22:17:08', 'BC-2026-1', 'L'),
(51, 'EMP-4', '2025-01-20', '22:17:08', 'BC-2026-1', 'L'),
(52, 'EMP-4', '2025-01-21', '22:17:08', 'BC-2026-1', 'L'),
(53, 'EMP-4', '2025-01-22', '22:17:08', 'BC-2026-1', 'L'),
(54, 'EMP-4', '2025-01-23', '22:17:08', 'BC-2026-1', 'L'),
(55, 'EMP-4', '2025-01-24', '22:17:08', 'BC-2026-1', 'L'),
(56, 'EMP-4', '2025-01-25', '22:17:08', 'BC-2026-1', 'L'),
(57, 'EMP-4', '2025-01-26', '22:17:08', 'BC-2026-1', 'L'),
(58, 'EMP-4', '2025-01-27', '22:17:08', 'BC-2026-1', 'L'),
(59, 'EMP-4', '2025-01-28', '22:17:08', 'BC-2026-1', 'L'),
(60, 'EMP-4', '2025-01-29', '22:17:08', 'BC-2026-1', 'L'),
(61, 'EMP-4', '2025-01-30', '22:17:08', 'BC-2026-1', 'L'),
(62, 'EMP-4', '2025-01-31', '22:17:08', 'BC-2026-1', 'L'),
(63, 'EMP-7', '2025-01-01', '22:17:08', 'BC-2026-1', 'A'),
(64, 'EMP-7', '2025-01-02', '22:17:08', 'BC-2026-1', 'A'),
(65, 'EMP-7', '2025-01-03', '22:17:08', 'BC-2026-1', 'A'),
(66, 'EMP-7', '2025-01-04', '22:17:08', 'BC-2026-1', 'A'),
(67, 'EMP-7', '2025-01-05', '22:17:08', 'BC-2026-1', 'A'),
(68, 'EMP-7', '2025-01-06', '22:17:08', 'BC-2026-1', 'A'),
(69, 'EMP-7', '2025-01-07', '22:17:08', 'BC-2026-1', 'A'),
(70, 'EMP-7', '2025-01-08', '22:17:08', 'BC-2026-1', 'A'),
(71, 'EMP-7', '2025-01-09', '22:17:08', 'BC-2026-1', 'A'),
(72, 'EMP-7', '2025-01-10', '22:17:08', 'BC-2026-1', 'A'),
(73, 'EMP-7', '2025-01-11', '22:17:08', 'BC-2026-1', 'A'),
(74, 'EMP-7', '2025-01-12', '22:17:08', 'BC-2026-1', 'A'),
(75, 'EMP-7', '2025-01-13', '22:17:08', 'BC-2026-1', 'A'),
(76, 'EMP-7', '2025-01-14', '22:17:08', 'BC-2026-1', 'A'),
(77, 'EMP-7', '2025-01-15', '22:17:08', 'BC-2026-1', 'A'),
(78, 'EMP-7', '2025-01-16', '22:17:08', 'BC-2026-1', 'A'),
(79, 'EMP-7', '2025-01-17', '22:17:08', 'BC-2026-1', 'A'),
(80, 'EMP-7', '2025-01-18', '22:17:08', 'BC-2026-1', 'A'),
(81, 'EMP-7', '2025-01-19', '22:17:08', 'BC-2026-1', 'A'),
(82, 'EMP-7', '2025-01-20', '22:17:08', 'BC-2026-1', 'A'),
(83, 'EMP-7', '2025-01-21', '22:17:08', 'BC-2026-1', 'A'),
(84, 'EMP-7', '2025-01-22', '22:17:08', 'BC-2026-1', 'A'),
(85, 'EMP-7', '2025-01-23', '22:17:08', 'BC-2026-1', 'A'),
(86, 'EMP-7', '2025-01-24', '22:17:08', 'BC-2026-1', 'A'),
(87, 'EMP-7', '2025-01-25', '22:17:08', 'BC-2026-1', 'A'),
(88, 'EMP-7', '2025-01-26', '22:17:08', 'BC-2026-1', 'A'),
(89, 'EMP-7', '2025-01-27', '22:17:08', 'BC-2026-1', 'A'),
(90, 'EMP-7', '2025-01-28', '22:17:08', 'BC-2026-1', 'A'),
(91, 'EMP-7', '2025-01-29', '22:17:08', 'BC-2026-1', 'A'),
(92, 'EMP-7', '2025-01-30', '22:17:08', 'BC-2026-1', 'A'),
(93, 'EMP-7', '2025-01-31', '22:17:08', 'BC-2026-1', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `branch_code` varchar(100) NOT NULL,
  `branch_name` varchar(250) NOT NULL,
  `branch_address` text NOT NULL,
  `added_by_id` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `add_date` varchar(20) NOT NULL,
  `add_time` varchar(20) NOT NULL,
  `url` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `branch_code`, `branch_name`, `branch_address`, `added_by_id`, `longitude`, `latitude`, `add_date`, `add_time`, `url`) VALUES
(1, 'BC-2026-1', 'Noida', 'B-508, Bhutani Technopark, Sector-127\r\nNoida, Uttar Pradesh - 201304 IN', 'EMP-ADM-1', '28.5358269', '77.3434946', '2026-01-07', '22:11:24', 'https://www.google.com/maps/dir//JetHat+Cyber+Security+Pvt.+Ltd.,+BHUTANI+TECHNOPARK,+B-508,+Sector+127,+Noida,+Uttar+Pradesh+201313/@28.5358269,77.3434946,17z/data=!4m16!1m7!3m6!1s0x390ce7cf95034cef:0x56b65001f87bc7b4!2sJetHat+Cyber+Security+Pvt.+Ltd.!8m2!3d28.5358222!4d77.3460695!16s%2Fg%2F11y1m7q');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `department` varchar(100) NOT NULL,
  `add_date` varchar(20) NOT NULL,
  `add_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department`, `add_date`, `add_time`) VALUES
(1, 'HR', '2026-01-08', '13:07:56'),
(2, 'Driver', '2026-01-08', '13:08:24'),
(3, 'GunMan', '2026-01-08', '13:08:24'),
(4, 'Accountant', '2026-01-08', '13:08:24');

-- --------------------------------------------------------

--
-- Table structure for table `dress_allot_emp`
--

CREATE TABLE `dress_allot_emp` (
  `id` int(11) NOT NULL,
  `drs_alot_id` varchar(100) NOT NULL,
  `emp_id` varchar(100) NOT NULL,
  `dress_description` text NOT NULL,
  `handover_person_id` varchar(100) NOT NULL,
  `add_date` varchar(20) NOT NULL,
  `add_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dress_allot_emp`
--

INSERT INTO `dress_allot_emp` (`id`, `drs_alot_id`, `emp_id`, `dress_description`, `handover_person_id`, `add_date`, `add_time`) VALUES
(1, 'EMP-DRS-ALT-1', 'EMP-USR-1', '10-Paint,20-Shirt', 'EMP-ADM-1', '2026-01-08', '15:32:25');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `password` varchar(250) NOT NULL,
  `department` varchar(100) NOT NULL,
  `pan_card` varchar(250) NOT NULL,
  `addhar_card` varchar(250) NOT NULL,
  `ten_certficate` varchar(250) NOT NULL,
  `twelve_certficate` varchar(250) NOT NULL,
  `high_certificate` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `state` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `status` enum('Active','Deactive','Rejoin') NOT NULL,
  `add_by_id` varchar(100) NOT NULL,
  `add_date` varchar(20) NOT NULL,
  `add_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `unique_id`, `name`, `email`, `mobile`, `password`, `department`, `pan_card`, `addhar_card`, `ten_certficate`, `twelve_certficate`, `high_certificate`, `address`, `state`, `district`, `pincode`, `status`, `add_by_id`, `add_date`, `add_time`) VALUES
(1, 'EMP-USR-1', 'Testing', 'testing@gmail.com', '9999999999', '827ccb0eea8a706c4c34a16891f84e7b', 'Gun Man', '', '', '', '', '', 'Noida', 'Uttar Pradesh', 'Guatam Buddha Nagar', '201301', 'Active', 'EMP-ADM-1', '2026-01-08', '13:00:35');

-- --------------------------------------------------------

--
-- Table structure for table `employee_salary`
--

CREATE TABLE `employee_salary` (
  `id` int(11) NOT NULL,
  `emp_salary_id` varchar(100) NOT NULL,
  `emp_id` varchar(100) NOT NULL,
  `basic_salary` varchar(30) NOT NULL,
  `epfo` varchar(30) NOT NULL,
  `esi` varchar(30) NOT NULL,
  `conveyance` varchar(30) NOT NULL,
  `hra` varchar(30) NOT NULL,
  `total_salary` varchar(30) NOT NULL,
  `less_amount` varchar(20) NOT NULL,
  `total_amount_paid` varchar(20) NOT NULL,
  `add_date` varchar(20) NOT NULL,
  `add_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_salary`
--

INSERT INTO `employee_salary` (`id`, `emp_salary_id`, `emp_id`, `basic_salary`, `epfo`, `esi`, `conveyance`, `hra`, `total_salary`, `less_amount`, `total_amount_paid`, `add_date`, `add_time`) VALUES
(1, 'EMP-2026-01-1', 'EMP-USR-1', '20000', '2500', '350', '0', '0', '22850', '0', '22850', '2025-12-08', '13:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `office_occasion`
--

CREATE TABLE `office_occasion` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `day` varchar(10) NOT NULL,
  `month` varchar(10) NOT NULL,
  `year` varchar(10) NOT NULL,
  `added_by_id` varchar(100) NOT NULL,
  `add_date` varchar(20) NOT NULL,
  `add_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `office_occasion`
--

INSERT INTO `office_occasion` (`id`, `title`, `day`, `month`, `year`, `added_by_id`, `add_date`, `add_time`) VALUES
(1, 'MAKAR SANKRANTI', '14', 'January', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(2, 'REPUBLIC DAY', '26', 'January', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(3, 'MAHA SHIVARATRI', '15', 'February', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(4, 'HOLI', '04', 'March', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(5, 'RAMANAVAMI', '26', 'March', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(6, 'DR.AMBEDKAR JAYANTI', '14', 'April', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(7, 'BUDDHA PURNIMA', '01', 'May', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(8, 'INDEPENDENCE DAY', '15', 'August', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(9, 'RAKSHA BANDHAN', '28', 'August', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(10, 'JANMASHTAMI', '04', 'September', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(11, 'GANDHI JAYANTI', '02', 'October', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(12, 'DUSSEHRA', '19', 'October', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(13, 'VIJAYA DASHAMI', '20', 'October', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(14, 'DIWALI', '08', 'November', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(15, 'GOVARDHAN PUJA', '09', 'November', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(16, 'BHAI DUI', '11', 'November', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(17, 'GURU NANAK BIRTHDAY', '24', 'November', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11'),
(18, 'CHRISTMAS', '25', 'December', '2026', 'EMP-ADM-1', '2026-01-07', '14:23:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advance_payment`
--
ALTER TABLE `advance_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dress_allot_emp`
--
ALTER TABLE `dress_allot_emp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_salary`
--
ALTER TABLE `employee_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office_occasion`
--
ALTER TABLE `office_occasion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `advance_payment`
--
ALTER TABLE `advance_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dress_allot_emp`
--
ALTER TABLE `dress_allot_emp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_salary`
--
ALTER TABLE `employee_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `office_occasion`
--
ALTER TABLE `office_occasion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
