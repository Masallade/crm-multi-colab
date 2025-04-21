-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2025 at 10:20 AM
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
-- Database: `crm2.0.0`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `added_by` varchar(40) DEFAULT NULL,
  `is_notify` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appraisals`
--

CREATE TABLE `appraisals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `designation_id` bigint(20) UNSIGNED NOT NULL,
  `customer_experience` varchar(191) NOT NULL,
  `marketing` varchar(191) DEFAULT NULL,
  `administration` varchar(191) DEFAULT NULL,
  `professionalism` varchar(191) DEFAULT NULL,
  `integrity` varchar(191) DEFAULT NULL,
  `attendance` varchar(191) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `date` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appraisal_sections`
--

CREATE TABLE `appraisal_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appraisal_section_indicators`
--

CREATE TABLE `appraisal_section_indicators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_name` varchar(50) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `asset_code` varchar(80) NOT NULL,
  `assets_category_id` bigint(20) UNSIGNED NOT NULL,
  `Asset_note` mediumtext DEFAULT NULL,
  `manufacturer` varchar(191) NOT NULL,
  `serial_number` varchar(191) NOT NULL,
  `invoice_number` varchar(191) NOT NULL,
  `asset_image` varchar(191) DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `warranty_date` date NOT NULL,
  `status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_categories`
--

CREATE TABLE `asset_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_categories`
--

INSERT INTO `asset_categories` (`id`, `company_id`, `category_name`, `created_at`, `updated_at`) VALUES
(2, NULL, 'Vehicles', '2025-01-28 08:26:24', '2025-01-28 08:26:24'),
(3, NULL, 'Laptops', '2025-01-28 08:26:33', '2025-01-28 08:26:33'),
(4, NULL, 'Bikes', '2025-01-28 08:26:40', '2025-01-28 08:26:40'),
(5, NULL, 'Computer Systems', '2025-01-28 08:26:50', '2025-01-28 08:26:50');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `attendance_date` date NOT NULL,
  `clock_in` varchar(191) NOT NULL,
  `clock_in_ip` varchar(45) NOT NULL,
  `clock_out` varchar(191) NOT NULL,
  `clock_out_ip` varchar(45) NOT NULL,
  `clock_in_out` tinyint(4) NOT NULL,
  `time_late` varchar(191) NOT NULL DEFAULT '00:00',
  `early_leaving` varchar(191) NOT NULL DEFAULT '00:00',
  `overtime` varchar(191) NOT NULL DEFAULT '00:00',
  `total_work` varchar(191) NOT NULL DEFAULT '00:00',
  `total_rest` varchar(191) NOT NULL DEFAULT '00:00',
  `attendance_status` varchar(191) NOT NULL DEFAULT 'present'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `employee_id`, `attendance_date`, `clock_in`, `clock_in_ip`, `clock_out`, `clock_out_ip`, `clock_in_out`, `time_late`, `early_leaving`, `overtime`, `total_work`, `total_rest`, `attendance_status`) VALUES
(3, 9, '2022-06-08', '10:10', '::1', '11:14', '::1', 0, '00:10', '05:46', '00:00', '01:04', '00:00', 'present'),
(5, 10, '2021-03-30', '10:00', '', '14:00', '', 0, '00:00', '00:00', '00:00', '04:00', '00:00', 'present'),
(6, 11, '2021-03-30', '10:05', '', '14:05', '', 0, '00:05', '00:00', '00:05', '04:00', '00:00', 'present'),
(7, 12, '2021-03-30', '10:20', '', '14:50', '', 0, '00:20', '00:00', '00:50', '04:30', '00:00', 'present'),
(9, 9, '2022-06-07', '10:25', '::1', '12:40', '::1', 0, '00:25', '04:20', '00:40', '02:15', '00:11', 'present'),
(10, 9, '2021-03-29', '10:00', '::1', '14:00', '::1', 0, '00:00', '00:00', '00:00', '04:00', '00:00', 'present'),
(11, 9, '2021-03-29', '10:00', '::1', '14:20', '::1', 0, '00:00', '00:00', '00:20', '04:20', '00:00', 'present'),
(12, 9, '2021-03-29', '10:00', '::1', '13:20', '::1', 0, '00:00', '40:00', '00:00', '03:20', '00:00', 'present'),
(15, 12, '2021-03-29', '12:00', '', '17:00', '', 0, '00:00', '00:00', '00:00', '05:00', '00:00', 'present'),
(16, 11, '2021-03-29', '10:00', '', '17:00', '', 0, '00:00', '00:00', '03:00', '08:00', '00:00', 'present'),
(17, 11, '2021-03-29', '09:00', '', '15:00', '', 0, '00:00', '00:00', '00:00', '06:00', '00:00', 'present'),
(18, 9, '2021-03-29', '11:24', '127.0.0.1', '11:29', '127.0.0.1', 0, '01:24', '05:30', '00:00', '00:05', '00:00', 'present'),
(19, 9, '2021-03-29', '10:00', '127.0.0.1', '00:28', '127.0.0.1', 0, '00:00', '16:31', '00:00', '09:31', '00:00', 'present'),
(23, 38, '2021-03-29', '19:00', '', '15:00', '', 0, '09:00', '02:00', '00:00', '04:00', '00:00', 'present'),
(25, 11, '2021-06-30', '10:00', '', '17:00', '', 0, '00:00', '00:00', '00:00', '08:00', '00:00', 'present'),
(26, 11, '2021-07-01', '22:00', '', '17:00', '', 0, '12:00', '00:00', '03:00', '05:00', '00:00', 'present'),
(27, 9, '2021-07-04', '20:32', '::1', '20:32', '::1', 0, '00:00', '00:00', '00:00', '00:00', '00:00', 'present'),
(29, 9, '2021-09-12', '09:56', '::1', '10:07', '::1', 0, '00:01', '00:00', '00:07', '00:11', '00:00', 'present'),
(36, 9, '2021-11-13', '13:31', '127.0.0.1', '13:40', '127.0.0.1', 0, '04:31', '03:20', '00:00', '00:09', '00:00', 'present'),
(37, 9, '2021-11-15', '09:00', '127.0.0.1', '07:55', '127.0.0.1', 0, '00:00', '09:05', '00:00', '01:04', '00:00', 'present'),
(38, 9, '2021-11-14', '09:40', '154.136.171.168', '19:03', '154.136.171.168', 0, '00:40', '00:00', '02:03', '09:23', '00:00', 'present'),
(39, 9, '2021-11-14', '19:03', '154.136.171.168', '19:03', '154.136.171.168', 0, '00:00', '00:00', '02:03', '00:00', '00:00', 'present'),
(40, 9, '2021-11-14', '19:03', '154.136.171.168', '19:03', '154.136.171.168', 0, '00:00', '00:00', '02:03', '00:00', '00:00', 'present'),
(41, 9, '2021-11-14', '19:03', '154.136.171.168', '19:03', '154.136.171.168', 0, '00:00', '00:00', '02:03', '00:00', '00:00', 'present'),
(42, 9, '2021-11-14', '19:03', '154.136.171.168', '19:04', '154.136.171.168', 0, '00:00', '00:00', '02:04', '00:01', '00:00', 'present'),
(46, 12, '2021-11-15', '14:17', '127.0.0.1', '14:23', '127.0.0.1', 0, '00:17', '00:17', '00:00', '00:06', '00:00', 'present'),
(47, 12, '2021-11-15', '14:24', '127.0.0.1', '14:27', '127.0.0.1', 0, '00:00', '00:13', '00:00', '00:03', '00:01', 'present'),
(48, 12, '2021-11-15', '14:32', '127.0.0.1', '14:34', '127.0.0.1', 0, '00:00', '00:06', '00:00', '00:02', '00:05', 'present'),
(49, 12, '2021-11-15', '14:36', '127.0.0.1', '14:43', '127.0.0.1', 0, '00:00', '00:00', '00:03', '00:07', '00:02', 'present'),
(50, 12, '2021-11-15', '14:46', '127.0.0.1', '15:27', '127.0.0.1', 0, '00:00', '00:00', '00:41', '00:41', '00:03', 'present'),
(60, 9, '2022-08-21', '08:59', '::1', '17:11', '::1', 0, '00:00', '00:00', '00:00', '00:00', '00:00', 'present'),
(63, 9, '2022-09-17', '18:21', '::1', '18:46', '::1', 0, '00:00', '00:00', '00:00', '00:00', '01:10', 'present'),
(64, 9, '2022-09-17', '19:47', '::1', '20:48', '::1', 0, '00:00', '00:00', '01:38', '09:38', '01:01', 'present'),
(69, 9, '2022-10-02', '09:16', '', '13:00', '', 0, '00:16', '04:00', '00:00', '00:00', '00:00', 'present'),
(70, 9, '2022-10-02', '13:30', '', '18:00', '', 0, '00:00', '00:00', '00:14', '08:14', '00:30', 'present'),
(72, 9, '2023-09-06', '10:07', '127.0.0.1', '10:07', '127.0.0.1', 0, '01:07', '06:53', '00:00', '00:00', '00:00', 'present'),
(73, 9, '2023-09-06', '10:09', '127.0.0.1', '10:09', '127.0.0.1', 0, '00:00', '06:51', '00:00', '00:00', '00:02', 'present'),
(74, 185, '2025-01-28', '17:56', '127.0.0.1', '18:04', '127.0.0.1', 0, '04:56', '03:26', '00:00', '00:08', '00:00', 'present'),
(75, 157, '2025-01-01', '13:05', '', '21:47', '', 0, '00:05', '00:00', '00:12', '08:42', '00:00', 'present'),
(76, 157, '2025-01-02', '13:13', '', '21:41', '', 0, '00:13', '00:00', '00:00', '08:28', '00:00', 'present'),
(77, 157, '2025-01-03', '14:07', '', '22:36', '', 0, '00:07', '00:00', '00:29', '08:29', '00:00', 'present'),
(78, 157, '2025-01-04', '13:14', '', '22:21', '', 0, '02:00', '00:00', '09:06', '09:06', '00:00', 'present'),
(79, 157, '2025-01-05', '13:07', '', '22:51', '', 0, '01:52', '00:00', '09:44', '09:44', '00:00', 'present'),
(80, 157, '2025-01-06', '12:32', '', '21:35', '', 0, '00:00', '00:00', '00:33', '09:03', '00:00', 'present'),
(81, 157, '2025-01-07', '12:51', '', '21:38', '', 0, '00:00', '00:00', '00:16', '08:46', '00:00', 'present'),
(82, 157, '2025-01-08', '14:09', '', '22:05', '', 0, '01:09', '00:00', '00:00', '07:56', '00:00', 'present'),
(83, 157, '2025-01-09', '13:10', '', '21:35', '', 0, '00:10', '00:00', '00:00', '08:24', '00:00', 'present'),
(84, 157, '2025-01-10', '13:11', '', '21:39', '', 0, '00:00', '00:20', '00:28', '08:28', '00:00', 'present'),
(85, 157, '2025-01-13', '12:57', '', '21:44', '', 0, '00:00', '00:00', '00:16', '08:46', '00:00', 'present'),
(86, 157, '2025-01-14', '12:37', '', '21:47', '', 0, '00:00', '00:00', '00:39', '09:09', '00:00', 'present'),
(87, 157, '2025-01-15', '14:01', '', '22:16', '', 0, '01:01', '00:00', '00:00', '08:14', '00:00', 'present'),
(88, 157, '2025-01-16', '12:56', '', '21:44', '', 0, '00:00', '00:00', '00:17', '08:47', '00:00', 'present'),
(89, 157, '2025-01-17', '12:52', '', '21:34', '', 0, '00:00', '00:25', '00:42', '08:42', '00:00', 'present'),
(90, 157, '2025-01-20', '12:45', '', '21:33', '', 0, '00:00', '00:00', '00:17', '08:47', '00:00', 'present'),
(91, 157, '2025-01-21', '12:37', '', '21:41', '', 0, '00:00', '00:00', '00:34', '09:04', '00:00', 'present'),
(92, 157, '2025-01-22', '12:42', '', '22:09', '', 0, '00:00', '00:00', '00:56', '09:26', '00:00', 'present'),
(93, 157, '2025-01-23', '12:46', '', '21:37', '', 0, '00:00', '00:00', '00:21', '08:51', '00:00', 'present'),
(94, 157, '2025-01-27', '13:05', '', '21:47', '', 0, '00:05', '00:00', '00:12', '08:42', '00:00', 'present'),
(95, 157, '2025-01-28', '13:13', '', '21:41', '', 0, '00:13', '00:00', '00:00', '08:28', '00:00', 'present'),
(96, 158, '2025-01-29', '11:45', '192.168.18.77', '11:48', '192.168.18.77', 0, '00:00', '09:42', '00:00', '00:00', '00:00', 'present'),
(97, 158, '2025-01-29', '11:51', '192.168.18.77', '11:56', '192.168.18.77', 0, '00:00', '09:34', '00:00', '00:00', '00:03', 'present'),
(98, 158, '2025-01-29', '11:57', '192.168.18.77', '', '', 1, '00:00', '00:00', '00:00', '00:08', '00:01', 'present'),
(99, 166, '2025-01-28', '12:41', '', '12:52', '', 0, '00:00', '08:37', '00:00', '00:00', '00:00', 'present'),
(100, 166, '2025-01-28', '13:02', '', '14:11', '', 0, '00:00', '07:18', '00:00', '00:00', '00:10', 'present'),
(101, 166, '2025-01-28', '14:21', '', '15:32', '', 0, '00:00', '05:57', '00:00', '00:00', '00:10', 'present'),
(102, 166, '2025-01-28', '15:47', '', '16:28', '', 0, '00:00', '05:01', '00:00', '00:00', '00:15', 'present'),
(103, 166, '2025-01-28', '16:47', '', '17:18', '', 0, '00:00', '04:11', '00:00', '00:00', '00:19', 'present'),
(104, 166, '2025-01-28', '17:24', '', '17:35', '', 0, '00:00', '03:54', '00:00', '00:00', '00:06', 'present'),
(105, 166, '2025-01-28', '17:24', '', '18:18', '', 0, '00:00', '03:11', '00:00', '00:00', '00:10', 'present'),
(106, 166, '2025-01-28', '18:24', '', '18:53', '', 0, '00:00', '02:36', '00:00', '00:00', '00:06', 'present'),
(107, 166, '2025-01-28', '20:01', '', '20:44', '', 0, '00:00', '00:45', '00:00', '00:00', '01:08', 'present'),
(108, 166, '2025-01-28', '21:08', '', '21:30', '', 0, '00:00', '00:00', '00:00', '06:19', '00:24', 'present');

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE `awards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `award_information` mediumtext DEFAULT NULL,
  `award_date` date NOT NULL,
  `gift` varchar(40) DEFAULT NULL,
  `cash` varchar(40) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `award_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `award_photo` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `awards`
--

INSERT INTO `awards` (`id`, `award_information`, `award_date`, `gift`, `cash`, `company_id`, `department_id`, `employee_id`, `award_type_id`, `award_photo`, `created_at`, `updated_at`) VALUES
(1, '\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system,', '2021-03-25', 'Flower', '500', 1, 2, 10, NULL, 'award_1595848708.jpg', '2020-07-27 11:18:28', '2020-07-27 11:19:55'),
(2, 'dfsdf', '2021-03-17', 'watch', '100', 1, 1, 9, 1, NULL, '2020-08-18 06:46:49', '2020-08-18 06:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `award_types`
--

CREATE TABLE `award_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `award_name` varchar(40) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `award_types`
--

INSERT INTO `award_types` (`id`, `award_name`, `created_at`, `updated_at`) VALUES
(1, 'Employee Of The Year', '2020-07-26 20:19:34', '2025-01-28 07:50:32');

-- --------------------------------------------------------

--
-- Table structure for table `calendarables`
--

CREATE TABLE `calendarables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_interview`
--

CREATE TABLE `candidate_interview` (
  `interview_id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_interview`
--

INSERT INTO `candidate_interview` (`interview_id`, `candidate_id`) VALUES
(1, 3),
(2, 3),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `contact_no` varchar(15) NOT NULL,
  `username` varchar(64) NOT NULL,
  `profile` varchar(191) DEFAULT NULL,
  `company_name` varchar(191) NOT NULL,
  `gender` varchar(40) NOT NULL,
  `website` varchar(40) DEFAULT NULL,
  `address1` mediumtext DEFAULT NULL,
  `address2` mediumtext DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `zip` varchar(191) DEFAULT NULL,
  `country` tinyint(4) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(191) NOT NULL,
  `company_type_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `trading_name` varchar(191) DEFAULT NULL,
  `registration_no` varchar(191) DEFAULT NULL,
  `contact_no` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `website` varchar(191) DEFAULT NULL,
  `tax_no` varchar(191) DEFAULT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_logo` varchar(191) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `company_type_id`, `trading_name`, `registration_no`, `contact_no`, `email`, `website`, `tax_no`, `location_id`, `company_logo`, `is_active`, `created_at`, `updated_at`) VALUES
(9, 'Base Practice Support', 7, 'Base Practice Support', '442344234', '0514440266', 'faisalc@basepracticesupport.co.uk', 'https://www.bazomyki.biz', '7979797', 1, '398800695_1737983884.png', NULL, '2024-07-22 13:28:00', '2025-01-27 14:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `company_types`
--

CREATE TABLE `company_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_types`
--

INSERT INTO `company_types` (`id`, `type_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Software Firm', '2024-07-22 09:55:31', '2024-07-22 10:19:33', NULL),
(3, 'Test', '2024-07-22 10:19:53', '2024-07-22 10:21:29', '2024-07-22 10:21:29'),
(4, 'Test 2', '2024-07-22 10:20:15', '2024-07-22 10:21:34', '2024-07-22 10:21:34'),
(5, 'Coorporation', '2024-07-22 10:22:32', '2024-07-22 10:22:32', NULL),
(6, 'Organization', '2024-07-22 10:22:57', '2024-07-22 10:22:57', NULL),
(7, 'Partnership', '2024-07-22 10:23:08', '2024-07-22 10:23:08', NULL),
(8, 'Private Foundation', '2024-07-22 10:23:18', '2024-07-22 10:23:18', NULL),
(9, 'Limited Liability Company', '2024-07-22 10:23:31', '2024-07-22 10:23:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `complaint_title` varchar(40) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `complaint_from` bigint(20) UNSIGNED NOT NULL,
  `complaint_against` bigint(20) UNSIGNED NOT NULL,
  `complaint_date` date NOT NULL,
  `status` varchar(40) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `complaint_title`, `description`, `company_id`, `complaint_from`, `complaint_against`, `complaint_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Irritating', 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur', 1, 13, 11, '2021-03-25', 'Yes', '2020-07-27 17:24:57', '2020-07-27 17:24:57');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `code`, `name`) VALUES
(1, 'US', 'United States'),
(2, 'CA', 'Canada'),
(3, 'AF', 'Afghanistan'),
(4, 'AL', 'Albania'),
(5, 'DZ', 'Algeria'),
(6, 'DS', 'American Samoa'),
(7, 'AD', 'Andorra'),
(8, 'AO', 'Angola'),
(9, 'AI', 'Anguilla'),
(10, 'AQ', 'Antarctica'),
(11, 'AG', 'Antigua and/or Barbuda'),
(12, 'AR', 'Argentina'),
(13, 'AM', 'Armenia'),
(14, 'AW', 'Aruba'),
(15, 'AU', 'Australia'),
(16, 'AT', 'Austria'),
(17, 'AZ', 'Azerbaijan'),
(18, 'BS', 'Bahamas'),
(19, 'BH', 'Bahrain'),
(20, 'BD', 'Bangladesh'),
(21, 'BB', 'Barbados'),
(22, 'BY', 'Belarus'),
(23, 'BE', 'Belgium'),
(24, 'BZ', 'Belize'),
(25, 'BJ', 'Benin'),
(26, 'BM', 'Bermuda'),
(27, 'BT', 'Bhutan'),
(28, 'BO', 'Bolivia'),
(29, 'BA', 'Bosnia and Herzegovina'),
(30, 'BW', 'Botswana'),
(31, 'BV', 'Bouvet Island'),
(32, 'BR', 'Brazil'),
(33, 'IO', 'British lndian Ocean Territory'),
(34, 'BN', 'Brunei Darussalam'),
(35, 'BG', 'Bulgaria'),
(36, 'BF', 'Burkina Faso'),
(37, 'BI', 'Burundi'),
(38, 'KH', 'Cambodia'),
(39, 'CM', 'Cameroon'),
(40, 'CV', 'Cape Verde'),
(41, 'KY', 'Cayman Islands'),
(42, 'CF', 'Central African Republic'),
(43, 'TD', 'Chad'),
(44, 'CL', 'Chile'),
(45, 'CN', 'China'),
(46, 'CX', 'Christmas Island'),
(47, 'CC', 'Cocos (Keeling) Islands'),
(48, 'CO', 'Colombia'),
(49, 'KM', 'Comoros'),
(50, 'CG', 'Congo'),
(51, 'CK', 'Cook Islands'),
(52, 'CR', 'Costa Rica'),
(53, 'HR', 'Croatia (Hrvatska)'),
(54, 'CU', 'Cuba'),
(55, 'CY', 'Cyprus'),
(56, 'CZ', 'Czech Republic'),
(57, 'DK', 'Denmark'),
(58, 'DJ', 'Djibouti'),
(59, 'DM', 'Dominica'),
(60, 'DO', 'Dominican Republic'),
(61, 'TP', 'East Timor'),
(62, 'EC', 'Ecudaor'),
(63, 'EG', 'Egypt'),
(64, 'SV', 'El Salvador'),
(65, 'GQ', 'Equatorial Guinea'),
(66, 'ER', 'Eritrea'),
(67, 'EE', 'Estonia'),
(68, 'ET', 'Ethiopia'),
(69, 'FK', 'Falkland Islands (Malvinas)'),
(70, 'FO', 'Faroe Islands'),
(71, 'FJ', 'Fiji'),
(72, 'FI', 'Finland'),
(73, 'FR', 'France'),
(74, 'FX', 'France, Metropolitan'),
(75, 'GF', 'French Guiana'),
(76, 'PF', 'French Polynesia'),
(77, 'TF', 'French Southern Territories'),
(78, 'GA', 'Gabon'),
(79, 'GM', 'Gambia'),
(80, 'GE', 'Georgia'),
(81, 'DE', 'Germany'),
(82, 'GH', 'Ghana'),
(83, 'GI', 'Gibraltar'),
(84, 'GR', 'Greece'),
(85, 'GL', 'Greenland'),
(86, 'GD', 'Grenada'),
(87, 'GP', 'Guadeloupe'),
(88, 'GU', 'Guam'),
(89, 'GT', 'Guatemala'),
(90, 'GN', 'Guinea'),
(91, 'GW', 'Guinea-Bissau'),
(92, 'GY', 'Guyana'),
(93, 'HT', 'Haiti'),
(94, 'HM', 'Heard and Mc Donald Islands'),
(95, 'HN', 'Honduras'),
(96, 'HK', 'Hong Kong'),
(97, 'HU', 'Hungary'),
(98, 'IS', 'Iceland'),
(99, 'IN', 'India'),
(100, 'ID', 'Indonesia'),
(101, 'IR', 'Iran (Islamic Republic of)'),
(102, 'IQ', 'Iraq'),
(103, 'IE', 'Ireland'),
(104, 'IL', 'Israel'),
(105, 'IT', 'Italy'),
(106, 'CI', 'Ivory Coast'),
(107, 'JM', 'Jamaica'),
(108, 'JP', 'Japan'),
(109, 'JO', 'Jordan'),
(110, 'KZ', 'Kazakhstan'),
(111, 'KE', 'Kenya'),
(112, 'KI', 'Kiribati'),
(113, 'KP', 'Korea, Democratic People\'s Republic of'),
(114, 'KR', 'Korea, Republic of'),
(115, 'KW', 'Kuwait'),
(116, 'KG', 'Kyrgyzstan'),
(117, 'LA', 'Lao People\'s Democratic Republic'),
(118, 'LV', 'Latvia'),
(119, 'LB', 'Lebanon'),
(120, 'LS', 'Lesotho'),
(121, 'LR', 'Liberia'),
(122, 'LY', 'Libyan Arab Jamahiriya'),
(123, 'LI', 'Liechtenstein'),
(124, 'LT', 'Lithuania'),
(125, 'LU', 'Luxembourg'),
(126, 'MO', 'Macau'),
(127, 'MK', 'Macedonia'),
(128, 'MG', 'Madagascar'),
(129, 'MW', 'Malawi'),
(130, 'MY', 'Malaysia'),
(131, 'MV', 'Maldives'),
(132, 'ML', 'Mali'),
(133, 'MT', 'Malta'),
(134, 'MH', 'Marshall Islands'),
(135, 'MQ', 'Martinique'),
(136, 'MR', 'Mauritania'),
(137, 'MU', 'Mauritius'),
(138, 'TY', 'Mayotte'),
(139, 'MX', 'Mexico'),
(140, 'FM', 'Micronesia, Federated States of'),
(141, 'MD', 'Moldova, Republic of'),
(142, 'MC', 'Monaco'),
(143, 'MN', 'Mongolia'),
(144, 'MS', 'Montserrat'),
(145, 'MA', 'Morocco'),
(146, 'MZ', 'Mozambique'),
(147, 'MM', 'Myanmar'),
(148, 'NA', 'Namibia'),
(149, 'NR', 'Nauru'),
(150, 'NP', 'Nepal'),
(151, 'NL', 'Netherlands'),
(152, 'AN', 'Netherlands Antilles'),
(153, 'NC', 'New Caledonia'),
(154, 'NZ', 'New Zealand'),
(155, 'NI', 'Nicaragua'),
(156, 'NE', 'Niger'),
(157, 'NG', 'Nigeria'),
(158, 'NU', 'Niue'),
(159, 'NF', 'Norfork Island'),
(160, 'MP', 'Northern Mariana Islands'),
(161, 'NO', 'Norway'),
(162, 'OM', 'Oman'),
(163, 'PK', 'Pakistan'),
(164, 'PW', 'Palau'),
(165, 'PA', 'Panama'),
(166, 'PG', 'Papua New Guinea'),
(167, 'PY', 'Paraguay'),
(168, 'PE', 'Peru'),
(169, 'PH', 'Philippines'),
(170, 'PN', 'Pitcairn'),
(171, 'PL', 'Poland'),
(172, 'PT', 'Portugal'),
(173, 'PR', 'Puerto Rico'),
(174, 'QA', 'Qatar'),
(175, 'RE', 'Reunion'),
(176, 'RO', 'Romania'),
(177, 'RU', 'Russian Federation'),
(178, 'RW', 'Rwanda'),
(179, 'KN', 'Saint Kitts and Nevis'),
(180, 'LC', 'Saint Lucia'),
(181, 'VC', 'Saint Vincent and the Grenadines'),
(182, 'WS', 'Samoa'),
(183, 'SM', 'San Marino'),
(184, 'ST', 'Sao Tome and Principe'),
(185, 'SA', 'Saudi Arabia'),
(186, 'SN', 'Senegal'),
(187, 'SC', 'Seychelles'),
(188, 'SL', 'Sierra Leone'),
(189, 'SG', 'Singapore'),
(190, 'SK', 'Slovakia'),
(191, 'SI', 'Slovenia'),
(192, 'SB', 'Solomon Islands'),
(193, 'SO', 'Somalia'),
(194, 'ZA', 'South Africa'),
(195, 'GS', 'South Georgia South Sandwich Islands'),
(196, 'ES', 'Spain'),
(197, 'LK', 'Sri Lanka'),
(198, 'SH', 'St. Helena'),
(199, 'PM', 'St. Pierre and Miquelon'),
(200, 'SD', 'Sudan'),
(201, 'SR', 'Suriname'),
(202, 'SJ', 'Svalbarn and Jan Mayen Islands'),
(203, 'SZ', 'Swaziland'),
(204, 'SE', 'Sweden'),
(205, 'CH', 'Switzerland'),
(206, 'SY', 'Syrian Arab Republic'),
(207, 'TW', 'Taiwan'),
(208, 'TJ', 'Tajikistan'),
(209, 'TZ', 'Tanzania, United Republic of'),
(210, 'TH', 'Thailand'),
(211, 'TG', 'Togo'),
(212, 'TK', 'Tokelau'),
(213, 'TO', 'Tonga'),
(214, 'TT', 'Trinidad and Tobago'),
(215, 'TN', 'Tunisia'),
(216, 'TR', 'Turkey'),
(217, 'TM', 'Turkmenistan'),
(218, 'TC', 'Turks and Caicos Islands'),
(219, 'TV', 'Tuvalu'),
(220, 'UG', 'Uganda'),
(221, 'UA', 'Ukraine'),
(222, 'AE', 'United Arab Emirates'),
(223, 'GB', 'United Kingdom'),
(224, 'UM', 'United States minor outlying islands'),
(225, 'UY', 'Uruguay'),
(226, 'UZ', 'Uzbekistan'),
(227, 'VU', 'Vanuatu'),
(228, 'VA', 'Vatican City State'),
(229, 'VE', 'Venezuela'),
(230, 'VN', 'Vietnam'),
(231, 'VG', 'Virigan Islands (British)'),
(232, 'VI', 'Virgin Islands (U.S.)'),
(233, 'WF', 'Wallis and Futuna Islands'),
(234, 'EH', 'Western Sahara'),
(235, 'YE', 'Yemen'),
(236, 'YU', 'Yugoslavia'),
(237, 'ZR', 'Zaire'),
(238, 'ZM', 'Zambia'),
(239, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `c_m_s`
--

CREATE TABLE `c_m_s` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `home` longtext DEFAULT NULL,
  `about` longtext DEFAULT NULL,
  `contact` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `c_m_s`
--

INSERT INTO `c_m_s` (`id`, `home`, `about`, `contact`, `created_at`, `updated_at`) VALUES
(1, '&lt;div class=&quot;container&quot;&gt;\r\n&lt;p&gt;Home Page, You can add your page design here&lt;/p&gt;\r\n&lt;/div&gt;', '&lt;p&gt;About Page, You can add your page design here&lt;/p&gt;', '&lt;div class=&quot;details&quot;&gt;\r\n&lt;h3&gt;Address&lt;/h3&gt;\r\nLahore&lt;/div&gt;\r\n&lt;div class=&quot;details mar-top-30&quot;&gt;\r\n&lt;h3&gt;&amp;nbsp;&lt;/h3&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;h3&gt;Email&lt;/h3&gt;\r\ninfo@avantcoretech.com&lt;/div&gt;', '2020-07-27 09:19:39', '2025-01-28 08:17:33');

-- --------------------------------------------------------

--
-- Table structure for table `deduction_types`
--

CREATE TABLE `deduction_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deduction_types`
--

INSERT INTO `deduction_types` (`id`, `type_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Social Security System', '2024-07-23 06:32:09', '2024-07-23 07:11:18', NULL),
(3, 'Health Insurance Corporation', '2024-07-23 07:11:34', '2025-01-28 07:53:20', '2025-01-28 07:53:20'),
(4, 'Home Development Mutual Fund', '2024-07-23 07:11:45', '2025-01-28 07:53:12', '2025-01-28 07:53:12'),
(5, 'Withholding Tax On Wages', '2024-07-23 07:11:57', '2025-01-28 07:53:26', '2025-01-28 07:53:26'),
(6, 'Other Statutory Deduction', '2024-07-23 07:12:11', '2025-01-28 07:53:04', '2025-01-28 07:53:04'),
(7, 'Test', '2024-07-23 07:39:14', '2024-07-23 07:39:41', '2024-07-23 07:39:41');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_name` varchar(191) NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_head` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `company_id`, `department_head`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Accounts-Arman Arif', 9, NULL, 1, NULL, NULL),
(2, 'Accounts-Awais Liaqat', 9, NULL, 1, NULL, NULL),
(3, 'Accounts-Aziz ur Rehman', 9, NULL, 1, NULL, NULL),
(4, 'Accounts-Faheem Ul Hassan', 9, NULL, 1, NULL, NULL),
(5, 'Accounts-General', 9, NULL, 1, NULL, NULL),
(6, 'Accounts-Ghulam Ghous', 9, NULL, 1, NULL, NULL),
(7, 'Accounts-Hamza Khan', 9, NULL, 1, NULL, NULL),
(8, 'Accounts-Hina Iftikhar', 9, NULL, 1, NULL, NULL),
(9, 'Accounts-Imran Khattak', 9, NULL, 1, NULL, NULL),
(10, 'Accounts-Imtinan Fazal Haq', 9, NULL, 1, NULL, NULL),
(11, 'Accounts-Muhammad Khawar', 9, NULL, 1, NULL, NULL),
(12, 'Accounts-Muhammad Umer Hayat', 9, NULL, 1, NULL, NULL),
(13, 'Accounts-Muhammad Waqas', 9, NULL, 1, NULL, NULL),
(14, 'Accounts-Musadiq Mehmood', 9, NULL, 1, NULL, NULL),
(15, 'Accounts-Saeed Ur Rehman', 9, NULL, 1, NULL, NULL),
(16, 'Accounts-Syed Ibad Hussain', 9, NULL, 1, NULL, NULL),
(17, 'Accounts-Zahid Hassan', 9, NULL, 1, NULL, NULL),
(18, 'Accounts-Zohaib Hassan', 9, NULL, 1, NULL, NULL),
(19, 'Accounts-Zubair Ali Chachar', 9, NULL, 1, NULL, NULL),
(20, 'Admin', 9, NULL, 1, NULL, NULL),
(21, 'HR-Team Lead', 9, NULL, 1, NULL, NULL),
(22, 'Human Resource (HR)', 9, NULL, 1, NULL, NULL),
(23, 'IT', 9, NULL, 1, NULL, NULL),
(24, 'Management', 9, NULL, 1, NULL, NULL),
(25, 'Payroll', 9, NULL, 1, NULL, NULL),
(26, 'Tax', 9, NULL, 1, NULL, NULL),
(27, 'Trainee Accountant', 9, 229, NULL, '2025-01-28 11:58:03', '2025-01-28 11:58:03');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_categories`
--

CREATE TABLE `deposit_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposit_categories`
--

INSERT INTO `deposit_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Envato', '2024-07-23 15:32:56', '2024-07-23 15:33:20'),
(4, 'Salary', '2024-07-23 15:34:35', '2024-07-23 15:34:35'),
(5, 'Interest Income', '2024-07-23 15:34:44', '2024-07-23 15:34:44'),
(6, 'Regular Income', '2024-07-23 15:34:53', '2024-07-23 15:34:53'),
(7, 'Part Time Work', '2024-07-23 15:35:03', '2024-07-23 15:35:03'),
(8, 'Other Income', '2024-07-23 15:35:12', '2024-07-23 15:35:12');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation_name` varchar(191) NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `designation_name`, `company_id`, `department_id`, `is_active`, `created_at`, `updated_at`) VALUES
(24, 'CEO', 9, 24, NULL, '2025-01-27 11:50:40', '2025-01-27 11:50:40'),
(25, 'Assistant Manager', 9, 1, NULL, '2025-01-28 09:21:47', '2025-01-28 09:21:47'),
(26, 'Junior Accountant', 9, 11, NULL, '2025-01-28 09:33:16', '2025-01-28 09:33:16'),
(27, 'Manager', 9, 2, NULL, '2025-01-28 09:42:37', '2025-01-28 09:42:37'),
(28, 'Senior Accountant', 9, 10, NULL, '2025-01-28 10:04:03', '2025-01-28 10:04:03'),
(29, 'Senior Payroll Officer', 9, 25, NULL, '2025-01-28 10:11:48', '2025-01-28 10:11:48'),
(30, 'COO', 9, 24, NULL, '2025-01-28 10:51:01', '2025-01-28 10:51:01'),
(31, 'Director', 9, 5, NULL, '2025-01-28 11:04:37', '2025-01-28 11:04:37'),
(32, 'Senior Manager Admin', 9, 20, NULL, '2025-01-28 11:08:34', '2025-01-28 11:08:34'),
(33, 'Payroll Manager', 9, 25, NULL, '2025-01-28 11:15:12', '2025-01-28 11:15:12'),
(34, 'IT Manager', 9, 23, NULL, '2025-01-28 11:18:34', '2025-01-28 11:18:34'),
(35, 'Senior Accountant', 9, 26, NULL, '2025-01-28 11:36:37', '2025-01-28 11:36:37'),
(36, 'Trainee Accountant', 9, 5, NULL, '2025-01-28 11:41:42', '2025-01-28 11:41:42'),
(37, 'HR Manager', 9, 22, NULL, '2025-01-28 11:45:57', '2025-01-28 11:45:57'),
(38, 'Senior Accountant', 9, 5, NULL, '2025-01-28 11:47:21', '2025-01-28 11:47:21'),
(39, 'Senior HR &amp; Admin Officer', 9, 22, NULL, '2025-01-28 11:49:19', '2025-01-28 11:49:19'),
(40, 'Semi Senior Accountant', 9, 5, NULL, '2025-01-28 11:52:08', '2025-01-28 11:52:08'),
(41, 'Junior HR Officer', 9, 22, NULL, '2025-01-28 11:52:12', '2025-01-28 11:52:12'),
(42, 'Junior Accountant', 9, 26, NULL, '2025-01-28 11:58:40', '2025-01-28 11:58:40'),
(43, 'Trainee Accountant', 9, 4, NULL, '2025-01-28 12:00:50', '2025-01-28 12:00:50'),
(44, 'Junior Accountant', 9, 7, NULL, '2025-01-28 12:01:26', '2025-01-28 12:01:26'),
(45, 'Trainee Accountant', 9, 10, NULL, '2025-01-28 12:03:13', '2025-01-28 12:03:13'),
(46, 'Trainee Accountant', 9, 26, NULL, '2025-01-28 12:06:38', '2025-01-28 12:06:38'),
(47, 'Assistant Manager', 9, 5, NULL, '2025-01-28 12:08:05', '2025-01-28 12:08:05'),
(48, 'Junior Accountant', 9, 4, NULL, '2025-01-28 12:10:35', '2025-01-28 12:10:35'),
(49, 'Manager', 9, 5, NULL, '2025-01-28 12:11:05', '2025-01-28 12:11:05'),
(50, 'Senior Accountant', 9, 4, NULL, '2025-01-28 12:15:03', '2025-01-28 12:15:03'),
(51, 'Semi Senior Accountant', 9, 7, NULL, '2025-01-28 12:20:38', '2025-01-28 12:20:38'),
(52, 'Assistant Manager', 9, 2, NULL, '2025-01-28 12:21:11', '2025-01-28 12:21:11'),
(53, 'Senior Accountant', 9, 7, NULL, '2025-01-28 12:27:54', '2025-01-28 12:27:54'),
(54, 'Senior Accountant', 9, 2, NULL, '2025-01-28 12:31:37', '2025-01-28 12:31:37'),
(55, 'Manager', 9, 1, NULL, '2025-01-28 12:32:38', '2025-01-28 12:32:38'),
(56, 'Trainee Accountant', 9, 3, NULL, '2025-01-28 12:38:15', '2025-01-28 12:38:15'),
(57, 'Semi Senior Accountant', 9, 3, NULL, '2025-01-28 12:40:31', '2025-01-28 12:40:31'),
(58, 'Senior Accountant', 9, 3, NULL, '2025-01-28 12:42:12', '2025-01-28 12:42:12'),
(59, 'Manager', 9, 3, NULL, '2025-01-28 12:45:22', '2025-01-28 12:45:22'),
(60, 'Junior Accountant', 9, 9, NULL, '2025-01-28 12:47:04', '2025-01-28 12:47:04'),
(61, 'Assistant Manager', 9, 3, NULL, '2025-01-28 12:49:25', '2025-01-28 12:49:25'),
(62, 'Junior Accountant', 9, 19, NULL, '2025-01-28 12:51:11', '2025-01-28 12:51:11'),
(63, 'Senior Manager', 9, 1, NULL, '2025-01-28 12:51:49', '2025-01-28 12:51:49'),
(64, 'Social Media Manager', 9, 23, NULL, '2025-01-28 12:52:08', '2025-01-28 12:52:08'),
(65, 'Junior Accountant', 9, 18, NULL, '2025-01-28 12:54:01', '2025-01-28 12:54:01'),
(66, 'Semi Senior Accountant', 9, 18, NULL, '2025-01-28 12:56:05', '2025-01-28 12:56:05'),
(67, 'Junior Accountant', 9, 17, NULL, '2025-01-28 12:56:59', '2025-01-28 12:56:59'),
(68, 'Junior Payroll Officer', 9, 25, NULL, '2025-01-28 12:58:51', '2025-01-28 12:58:51'),
(69, 'Senior Accountant', 9, 18, NULL, '2025-01-28 12:59:10', '2025-01-28 12:59:10'),
(70, 'Semi Senior Accountant', 9, 17, NULL, '2025-01-28 12:59:56', '2025-01-28 12:59:56'),
(71, 'Junior Accountant', 9, 6, NULL, '2025-01-28 13:05:25', '2025-01-28 13:05:25'),
(72, 'Trainee Accountant', 9, 15, NULL, '2025-01-28 13:05:35', '2025-01-28 13:05:35'),
(73, 'Senior Accountant', 9, 6, NULL, '2025-01-28 13:07:54', '2025-01-28 13:07:54'),
(74, 'Trainee Accountant', 9, 11, NULL, '2025-01-28 13:11:33', '2025-01-28 13:11:33'),
(75, 'Semi Senior Accountant', 9, 11, NULL, '2025-01-28 13:17:42', '2025-01-28 13:17:42'),
(76, 'Semi Senior Accountant', 9, 10, NULL, '2025-01-28 13:17:44', '2025-01-28 13:17:44'),
(77, 'Senior Accountant', 9, 11, NULL, '2025-01-28 13:19:13', '2025-01-28 13:19:13'),
(78, 'Trainee Accountant', 9, 13, NULL, '2025-01-28 13:20:34', '2025-01-28 13:20:34'),
(79, 'Trainee Accountant', 9, 12, NULL, '2025-01-28 13:24:31', '2025-01-28 13:24:31'),
(80, 'Senior Accountant', 9, 16, NULL, '2025-01-28 13:25:28', '2025-01-28 13:25:28'),
(81, 'Junior Accountant', 9, 12, NULL, '2025-01-28 13:26:06', '2025-01-28 13:26:06'),
(82, 'Trainee Accountant', 9, 16, NULL, '2025-01-28 13:27:52', '2025-01-28 13:27:52'),
(83, 'Semi Senior Accountant', 9, 16, NULL, '2025-01-28 13:29:06', '2025-01-28 13:29:06'),
(84, 'Trainee Accountant', 9, 14, NULL, '2025-01-28 13:38:38', '2025-01-28 13:38:38'),
(85, 'Assistant Manager', 9, 16, NULL, '2025-01-28 13:41:19', '2025-01-28 13:41:19'),
(86, 'Junior Accountant', 9, 8, NULL, '2025-01-28 13:43:54', '2025-01-28 13:43:54');

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE `document_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_types`
--

INSERT INTO `document_types` (`id`, `document_type`, `created_at`, `updated_at`) VALUES
(1, 'Driving Licesnse', '2020-07-26 20:27:04', '2020-07-26 20:27:04'),
(2, 'Passport', '2020-07-26 20:27:16', '2020-07-26 20:27:16'),
(3, 'National Id', '2020-07-26 20:27:40', '2020-07-26 20:27:40'),
(8, 'test', '2024-07-22 08:16:20', '2024-07-22 08:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_lead` int(11) DEFAULT NULL,
  `first_name` varchar(191) DEFAULT NULL,
  `last_name` varchar(191) DEFAULT NULL,
  `staff_id` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `contact_no` varchar(15) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(191) DEFAULT NULL,
  `office_shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `designation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role_users_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `probation_period` date DEFAULT NULL,
  `exit_date` date DEFAULT NULL,
  `marital_status` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `state` varchar(64) DEFAULT NULL,
  `country` varchar(64) DEFAULT NULL,
  `zip_code` varchar(24) DEFAULT NULL,
  `cv` varchar(64) DEFAULT NULL,
  `skype_id` varchar(64) DEFAULT NULL,
  `fb_id` varchar(64) DEFAULT NULL,
  `twitter_id` varchar(64) DEFAULT NULL,
  `linkedIn_id` varchar(64) DEFAULT NULL,
  `whatsapp_id` varchar(64) DEFAULT NULL,
  `basic_salary` double DEFAULT 0,
  `payslip_type` varchar(191) DEFAULT NULL,
  `attendance_type` varchar(191) DEFAULT NULL,
  `pension_type` varchar(50) DEFAULT NULL,
  `pension_amount` double(8,2) DEFAULT 0.00,
  `is_active` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `team_lead`, `first_name`, `last_name`, `staff_id`, `email`, `contact_no`, `date_of_birth`, `gender`, `office_shift_id`, `company_id`, `department_id`, `designation_id`, `location_id`, `role_users_id`, `status_id`, `joining_date`, `probation_period`, `exit_date`, `marital_status`, `address`, `city`, `state`, `country`, `zip_code`, `cv`, `skype_id`, `fb_id`, `twitter_id`, `linkedIn_id`, `whatsapp_id`, `basic_salary`, `payslip_type`, `attendance_type`, `pension_type`, `pension_amount`, `is_active`, `created_at`, `updated_at`) VALUES
(157, 238, 'Zohaib', 'Hassan', 'BPS-0000070', 'zohaib.hassan@basepracticesupport.co.uk', '03456608699', '2000-05-25', 'Male', 1, 9, 1, 55, NULL, 4, 1, '2022-04-25', '2025-01-28', NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:10:16'),
(158, 179, 'Zayan', 'Rashid', 'BPS-0000315', 'zk649192@gmail.com', '03365980889', '2001-05-25', 'Male', 1, 9, 11, 26, NULL, 2, 1, '2023-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 09:39:08'),
(159, 232, 'Zahid', 'Hassan', 'BPS-0000191', 'zahid.hassan@basepracticesupport.co.uk', '03335362749', '2002-05-25', 'Male', 1, 9, 2, 27, NULL, 4, 1, '2024-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 09:43:24'),
(160, 210, 'Wasif', 'Ali', 'BPS-0000233', 'wasif.ali@basepracticesupport.co.uk', '03175779484', '2004-05-25', 'Male', 1, 9, 10, 28, NULL, 2, 1, '2026-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 10:05:15'),
(161, 246, 'Wajeeha', 'Ahsan Butt', 'BPS-0000000', 'abc@g.com', '03309258670', '2005-05-25', 'Female', 1, 9, 25, 29, NULL, 2, 1, '2027-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 10:14:29'),
(162, 174, 'Usam-', 'Ul-Haq', 'BPS-0000169', 'usam.ulhaq@basepracticesupport.co.uk', '03335627176', '2006-05-25', 'Male', 1, 9, 5, 47, NULL, 2, 1, '2028-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:09:25'),
(163, 174, 'Umar', 'Saleem', 'BPS-0000247', 'umar.butt@basepracticesupport.co.uk', '03338506805', '2007-05-25', 'Male', 1, 9, 5, 38, NULL, 2, 1, '2029-04-25', '2025-01-29', NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:25:48'),
(164, 232, 'Syed', 'Ibad Hussain', 'BPS-0000013', 'ibadh@basepracticesupport.co.uk', '3365198971', '2008-05-25', 'Male', 1, 9, 2, 27, NULL, 4, 1, '2030-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:48:42'),
(165, 226, 'Shehryar', 'Hussain', 'BPS-0000259', 'shehryarh@basepracticesupport.co.uk', '03158208007', '2009-05-25', 'Male', 1, 9, 26, 35, NULL, 4, 1, '2031-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 11:37:48'),
(166, 251, 'Shahneel', 'Fatima', 'BPS-0000206', 'shahneel.fatima@basepracticesupport.co.uk', '03185294905', '2010-05-25', 'Female', 1, 9, 22, 41, NULL, 2, 1, '2032-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 11:53:18'),
(167, 179, 'Saud', 'Khan', 'BPS-0000291', 'saudkhan@basepracticesupport.co.uk', '0346-9688622', '2011-05-25', 'Male', 1, 9, 11, 26, NULL, 2, 1, '2033-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:17:08'),
(168, 246, 'Sarmad', 'Hassan Tariq', 'BPS-0000130', 'sarmad.hassan@basepracticesupport.co.uk', '03475871330', '2012-05-25', 'Male', 1, 9, 25, 29, NULL, 2, 1, '2034-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:56:40'),
(169, 159, 'Sana', 'Ullah', 'BPS-0000267', 'sanaullahkhan@basepracticesupport.co.uk', '03365237766', '2013-05-25', 'Male', 1, 9, 17, 70, NULL, 2, 1, '2035-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:00:41'),
(170, 157, 'Saeed', 'Ur Rehman', 'BPS-0000187', 'saeed.rehman@basepracticesupport.co.uk', '0301-5491916', '2014-05-25', 'Male', 1, 9, 18, 69, NULL, 2, 1, '2036-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:54:02'),
(171, 157, 'Sabir', 'Khan', 'BPS-0000312', 'sabirkhan@basepracticesupport.co.uk', '0310-0003922', '2015-05-25', 'Male', 1, 9, 18, 66, NULL, 2, 1, '2037-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:56:57'),
(172, 231, 'Rafeh', 'Hafeez', 'BPS-0000253', 'abdulrafay@basepracticesupport.co.uk', '0349-8936901', '2016-05-25', 'Male', 1, 9, 10, 28, NULL, 2, 1, '2038-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:43:00'),
(173, 231, 'Noman', 'Hayat', 'BPS-0000320', 'noumanhayat302@gmail.com', '0340-1691834', '2017-05-25', 'Male', 1, 9, 3, 56, NULL, 2, 1, '2039-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:38:58'),
(174, 227, 'Naveed', 'Iqbal', 'BPS-0000177', 'naveed.iqbal@basepracticesupport.co.uk', '0315-909377', '2018-05-25', 'Male', 1, 9, 5, 49, NULL, 4, 1, '2040-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:12:19'),
(175, 164, 'Musadiq', 'Mehmood', 'BPS-0000136', 'musadiq.mehmood@basepracticesupport.co.uk', '03159510545', '2019-05-25', 'Male', 1, 9, 16, 85, NULL, 4, 1, '2041-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:42:10'),
(176, 218, 'Munaam', 'Malik', 'BPS-0000196', 'munnam.malik@basepracticesupport.co.uk', '0336-0505798', '2020-05-25', 'Male', 1, 9, 7, 53, NULL, 2, 1, '2042-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:28:53'),
(177, 229, 'Mukashfa', '-', 'BPS-0000165', 'mukashfa.khattak@basepracticesupport.co.uk', '03179779324', '2021-05-25', 'Female', 1, 9, 4, 50, NULL, 2, 1, '2043-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:17:30'),
(178, 251, 'Muhammad', 'Zishan', 'BPS-0000027', 'zishanm@basepracticesupport.co.uk', '03456939009', '2022-05-25', 'Male', 1, 9, 22, 39, NULL, 2, 1, '2044-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 11:51:13'),
(179, 238, 'Muhammad', 'Khawar', 'BPS-0000043', 'muhammad.khawar@basepracticesupport.co.uk', '051-8431386, 03', '2023-05-25', 'Male', 1, 9, 1, 63, NULL, 2, 1, '2045-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:32:18'),
(180, 179, 'Muhammad', 'Umer Hayat', 'BPS-0000175', 'umar.hayat@basepracticesupport.co.uk', '0348-5055518', '2024-05-25', 'Male', 1, 9, 11, 77, NULL, 2, 1, '2046-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:31:02'),
(181, 210, 'Muhammad', 'Sameer Javed', 'BPS-0000179', 'sameer.javed@basepracticesupport.co.uk', '03075704199', '2025-05-25', 'Male', 1, 9, 10, 76, NULL, 2, 1, '2047-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:18:38'),
(182, 179, 'Muhammad', 'Waqas', 'BPS-0000205', 'muhammad.waqas@basepracticesupport.co.uk', '0324-9583678', '2026-05-25', 'Male', 1, 9, 11, 77, NULL, 2, 1, '2048-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:23:27'),
(183, 179, 'Muhammad', 'Afaq', 'BPS-0000214', 'afaq.shahid@basepracticesupport.co.uk', '0313-9761629', '2027-05-25', 'Male', 1, 9, 11, 77, NULL, 2, 1, '2049-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:20:01'),
(184, 165, 'Muhammad', 'Daniyal Javed', 'BPS-0000280', 'muhammaddaniyal@basepracticesupport.co.uk', '03352643141', '2028-05-25', 'Male', 1, 9, 26, 42, NULL, 2, 1, '2050-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:02:29'),
(185, 165, 'Muhammad', 'Waleed', 'BPS-0000284', 'muhammadwaleed@basepracticesupport.co.uk', '03165146106', '2029-05-25', 'Male', 1, 9, 26, 42, NULL, 2, 1, '2051-04-25', NULL, '2025-01-28', '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:03:59'),
(186, 165, 'Muhammad', 'Rayyan', 'BPS-0000288', 'muhammad.rayyan@basepracticesupport.co.uk', '03370300332', '2030-05-25', 'Male', 1, 9, 26, 46, NULL, 2, 1, '2052-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:08:35'),
(187, 218, 'Muhammad', 'Bilal Amin', 'BPS-0000290', 'bilalamin@basepracticesupport.co.uk', '0317-0798211', '2031-05-25', 'Male', 1, 9, 7, 44, NULL, 2, 1, '2053-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:14:02'),
(188, 229, 'Muhammad', 'Umair', 'BPS-0000300', 'muhammad.umair@basepracticesupport.co.uk', '03468107198', '2032-05-25', 'Male', 1, 9, 4, 48, NULL, 2, 1, '2054-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:11:28'),
(189, 164, 'Muhammad', 'Faizan Arshad', 'BPS-0000304', 'faizan.jutt123@gmail.com', '03219581677', '2033-05-25', 'Male', 1, 9, 16, 83, NULL, 2, 1, '2055-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:33:33'),
(190, 165, 'Muhammad', 'Ibrahim Khan', 'BPS-0000314', 'muhammad.ibrahim@basepracticesupport.co.uk', '03100908525', '2034-05-25', 'Male', 1, 9, 26, 42, NULL, 2, 1, '2056-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:10:52'),
(191, 164, 'Muhammad', 'Abdullah', 'BPS-0000309', 'abdullahrajpoot78695@gmail.com', '00000000000', '2035-05-25', 'Male', 1, 9, 16, 82, NULL, 2, 1, '2057-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:28:28'),
(192, 157, 'Muhammad', 'Salar Asif', 'BPS-0000316', 'salar.asif7.sa@gmail.com', '00000000001', '2036-05-25', 'Male', 1, 9, 18, 65, NULL, 2, 1, '2058-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:55:25'),
(193, 164, 'Muhammad', 'Ahmed', 'BPS-0000317', 'muhmeddk97@gmail.com', '00000000002', '2037-05-25', 'Male', 1, 9, 16, 80, NULL, 2, 1, '2059-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:26:12'),
(194, 224, 'Muhammad', 'Ali Hussain', 'BPS-0000322', 'malihussain.4434@outlook.com', '00000000003', '2038-05-25', 'Male', 1, 9, 6, 71, NULL, 2, 1, '2060-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:06:24'),
(195, 182, 'Muhammad', 'Danyal', 'BPS-0000324', 'daniyal143h@gmail.com', '00000000004', '2039-05-25', 'Male', 1, 9, 13, 78, NULL, 2, 1, '2061-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:21:21'),
(196, 170, 'Muhammad', 'Faisal Irfan', 'BPS-0000325', 'jnbfasi07@gmail.com', '00000000005', '2040-05-25', 'Male', 1, 9, 15, 72, NULL, 2, 1, '2062-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:06:57'),
(197, 210, 'Muhammad', 'Wahaj', 'BPS-0000327', 'mnudwahad28@gmail.com', '00000000006', '2041-05-25', 'Male', 1, 9, 10, 45, NULL, 2, 1, '2063-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:13:34'),
(198, 179, 'Muhammad', 'Hassan Iqbal', 'BPS-0000332', 'shhassanshhassan60@gmail.com', '00000000007', '2042-05-25', 'Male', 1, 9, 11, 74, NULL, 2, 1, '2064-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:13:01'),
(199, 164, 'Mathew', 'Francis', 'BPS-0000292', 'mathewfrancis@basepracticesupport.co.uk', '03498577596', '2043-05-25', 'Male', 1, 9, 16, 83, NULL, 2, 1, '2065-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:36:47'),
(200, 229, 'Mahnoor', 'Rehman', 'BPS-0000319', 'mahnoorrehman769@gmail.com', '00000000008', '2044-05-25', 'Male', 1, 9, 4, 43, NULL, 2, 1, '2066-04-25', NULL, '2025-01-28', '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:06:18'),
(201, 175, 'M Ashir', 'Saddique Qureshi', 'BPS-0000328', 'ashir.siddique76@gmail.com', '00000000009', '2045-05-25', 'Male', 1, 9, 14, 84, NULL, 2, 1, '2067-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:39:21'),
(202, 174, 'Laiba', 'Naveed', 'BPS-0000216', 'laiba.naveed@basepracticesupport.co.uk', '03315243664', '2046-05-25', 'Female', 1, 9, 5, 38, NULL, 2, 1, '2068-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:01:03'),
(203, 226, 'Khurram', 'Ali Butt', 'BPS-0000009', 'khurramb@basepracticesupport.co.uk', '0333312500703', '2047-05-25', 'Male', 1, 9, 20, 32, NULL, 2, 1, '2069-04-25', NULL, NULL, 'married', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 11:09:26'),
(204, 180, 'Khawaja', 'Ans', 'BPS-0000275', 'ansshoaib@basepracticesupport.co.uk', '0318-5190425', '2048-05-25', 'Male', 1, 9, 12, 81, NULL, 2, 1, '2070-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:27:11'),
(205, 165, 'Kamran', 'Khalid', 'BPS-0000131', 'kamran091998@gmail.com', '00000000010', '2049-05-25', 'Male', 1, 9, 26, 42, NULL, 2, 1, '2071-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:12:37'),
(206, 218, 'Junaid', 'Rasheed', 'BPS-0000293', 'junaid.rasheed@basepracticesupport.co.uk', '0311-7505550', '2050-05-25', 'Male', 1, 9, 7, 44, NULL, 2, 1, '2072-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:05:26'),
(207, 210, 'Junaid', 'Babar', 'BPS-0000313', 'arceusjunaid@gmail.com', '03135348151', '2051-05-25', 'Male', 1, 9, 10, 45, NULL, 2, 1, '2073-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:15:04'),
(208, 231, 'Jawad', 'Hussain', 'BPS-0000330', 'jawadqqq053@gmail.com', '00000000011', '2052-05-25', 'Male', 1, 9, 5, 36, NULL, 2, 1, '2074-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:37:26'),
(209, 231, 'Irfan', 'Azam Baig', 'BPS-0000318', 'irfanazam15202@gmail.com', '0307-8392822', '2053-05-25', 'Male', 1, 9, 3, 57, NULL, 2, 1, '2075-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:41:19'),
(210, 232, 'Imtinan', 'Fazal Haq', 'BPS-0000028', 'imtinanc@basepracticesupport.co.uk', '03344843119', '2054-05-25', 'Male', 1, 9, 2, 27, NULL, 2, 1, '2076-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:20:10'),
(211, 231, 'Imran', 'Khattak', 'BPS-0000117', 'imran.khattak@basepracticesupport.co.uk', '0336-9098451', '2055-05-25', 'Male', 1, 9, 3, 61, NULL, 2, 1, '2077-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:50:32'),
(212, 229, 'Ibtisam', 'Shahid', 'BPS-0000289', 'ibtisamshahid@basepracticesupport.co.uk', '03369859728', '2056-05-25', 'Male', 1, 9, 4, 43, NULL, 2, 1, '2078-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:14:01'),
(213, 231, 'Iatzaz', 'Ahsan', 'BPS-0000173', 'iatzaz.ahsan@basepracticesupport.co.uk', '0343-8854955', '2057-05-25', 'Male', 1, 9, 3, 59, NULL, 2, 1, '2079-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:46:07'),
(214, 164, 'Hina', 'Iftikhar', 'BPS-0000051', 'hina.iftikhar@basepracticesupport.co.uk', '03125403814', '2058-05-25', 'Female', 1, 9, 16, 80, NULL, 4, 1, '2080-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:49:44'),
(215, 164, 'Hassan', 'Tahir', 'BPS-0000305', 'hassantahir@basepracticesupport.co.uk', '03398887263', '2059-05-25', 'Male', 1, 9, 16, 83, NULL, 2, 1, '2081-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:35:16'),
(216, 179, 'Haris', 'Ahmed Khan', 'BPS-0000282', 'harrisahmed@basepracticesupport.co.uk', '0344-5027913', '2060-05-25', 'Male', 1, 9, 11, 75, NULL, 2, 1, '2082-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:18:23'),
(217, 174, 'Haram', 'Mustafa', 'BPS-0000221', 'haram.mustafa@basepracticesupport.co.uk', '03175515362', '2061-05-25', 'Female', 1, 9, 5, 40, NULL, 2, 1, '2083-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 11:57:29'),
(218, 238, 'Hamza', 'Khan', 'BPS-0000106', 'hamza.khan@basepracticesupport.co.uk', '0323-9732422', '2062-05-25', 'Male', 1, 9, 1, 55, NULL, 2, 1, '2084-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:34:06'),
(219, 165, 'Hamza', 'Waheed', 'BPS-0000331', 'hamzawaheed20200978@gmail.com', '00000000012', '2063-05-25', 'Male', 1, 9, 26, 42, NULL, 2, 1, '2085-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:15:36'),
(220, 165, 'Hamza', 'Qamar', 'BPS-0000334', 'rajahamza.qamar2002@gmail.com', '00000000013', '2064-05-25', 'Male', 1, 9, 26, 46, NULL, 2, 1, '2086-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:22:46'),
(221, 157, 'Hammad', 'Hussain', 'BPS-0000268', 'hammadhussain@basepracticesupport.co.uk', '0333-6239284', '2065-05-25', 'Male', 1, 9, 18, 66, NULL, 2, 1, '2087-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:58:25'),
(222, 174, 'Hadi', 'Raza', 'BPS-0000335', 'hadi.raza3726@gmail.com', '00000000014', '2066-05-25', 'Male', 1, 9, 5, 36, NULL, 2, 1, '2088-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 11:43:30'),
(223, 157, 'Hadayat', 'Ullah', 'BPS-0000231', 'hidayat.malik@basepracticesupport.co.uk', '0345-3636682', '2067-05-25', 'Male', 1, 9, 18, 69, NULL, 2, 1, '2089-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:03:39'),
(224, 232, 'Ghulam', 'Ghous', 'BPS-0000167', 'ghulam.ghous@basepracticesupport.co.uk', '03007390847', '2068-05-25', 'Male', 1, 9, 2, 27, NULL, 4, 1, '2090-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:11:47'),
(225, 224, 'Fawad', 'Ahmed', 'BPS-0000302', 'fawadahmad@basepracticesupport.co.uk', '03229188545', '2069-05-25', 'Male', 1, 9, 6, 73, NULL, 2, 1, '2091-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:08:35'),
(226, NULL, 'Faisal', 'Tariq Chaudhary', 'BPS-0000001', 'faisalc@basepracticesupport.co.uk', '03335479498', '2070-05-25', 'Male', 1, 9, 24, 24, NULL, 1, 1, '2025-04-25', '2024-01-28', '2025-01-28', '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 10:01:13'),
(227, 226, 'Faisal', 'Ayub', 'BPS-0000002', 'faisala@basepracticesupport.co.uk', '03218474239', '2071-05-25', 'Male', 1, 9, 24, 30, NULL, 4, 1, '2093-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 10:54:05'),
(228, 214, 'Faisal', 'Zeb', 'BPS-0000225', 'faisal.zeb@basepracticesupport.co.uk', '03138432211', '2072-05-25', 'Male', 1, 9, 8, 86, NULL, 2, 1, '2094-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:44:40'),
(229, 232, 'Faheem', 'Ul Hassan', 'BPS-0000274', 'faheem.hassan@basepracticesupport.co.uk', '03049903255', '2073-05-25', 'Male', 1, 9, 2, 52, NULL, 4, 1, '2095-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:22:20'),
(230, 224, 'Bilal', 'Khan', 'BPS-0000294', 'bilalkhan@basepracticesupport.co.uk', '03340591803', '2074-05-25', 'Male', 1, 9, 6, 71, NULL, 2, 1, '2096-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:09:43'),
(231, 238, 'Aziz', 'ur Rehman', 'BPS-000074', 'aziz.rehman@basepracticesupport.co.uk', '0332-7670806', '2075-05-25', 'Male', 1, 9, 1, 63, NULL, 2, 1, '2097-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:53:10'),
(232, 226, 'Awais', 'Liaqat', 'BPS-0000005', 'awaisl@basepracticesupport.co.uk', '03488134124', '2076-05-25', 'Male', 1, 9, 5, 31, NULL, 4, 1, '2098-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 11:05:43'),
(233, NULL, 'Athar', 'Butt', 'BPS-0000999', 'athar@avantcoretech.com', '00000000015', '2077-05-25', 'Male', 1, 9, 24, 24, NULL, 2, NULL, '2099-04-25', NULL, NULL, NULL, 'Islamabad', 'Islamabad', NULL, '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 08:00:48'),
(234, 254, 'Ateeq', 'Ur Rehman', 'BPS-0000310', 'ateeq2326@gmail.com', '03476371799', '2078-05-25', 'Male', 1, 9, 19, 62, NULL, 2, 1, '2100-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:51:46'),
(235, 246, 'Ashfaq', 'Ahmed Khan', 'BPS-0000279', 'ashfaqahmed@basepracticesupport.co.uk', '03425020360', '2079-05-25', 'Male', 1, 9, 25, 68, NULL, 2, 1, '2101-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:04:08'),
(236, 157, 'Asghar', 'Ali', 'BPS-0000248', 'asghar.ali@basepracticesupport.co.uk', '0343-6996091', '2080-05-25', 'Male', 1, 9, 18, 69, NULL, 2, 1, '2102-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:59:54'),
(237, 240, 'Asad', 'Mehmood', 'BPS-0000303', 'asadmahmood@basepracticesupport.co.uk', '03361110322', '2081-05-25', 'Male', 1, 9, 23, 64, NULL, 2, 1, '2103-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:53:15'),
(238, 226, 'Arman', 'Arif', 'BPS-0000024', 'armana@basepracticesupport.co.uk', '0332178924303', '2082-05-25', 'Male', 1, 9, 5, 31, NULL, 4, 1, '2104-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 11:13:37'),
(239, 246, 'Areej', 'Fatima', 'BPS-0000249', 'areej.fatima@basepracticesupport.co.uk', '03117886835', '2083-05-25', 'Female', 1, 9, 25, 68, NULL, 2, 1, '2105-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:59:41'),
(240, 226, 'Amir', 'Asghar Butt', 'BPS-0000072', 'amirbutt@basepracticesupport.co.uk', '0321-4800558', '2084-05-25', 'Male', 1, 9, 23, 34, NULL, 4, 1, '2106-04-25', NULL, NULL, 'married', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 11:35:11'),
(241, 159, 'Alyan', 'Hijazi', 'BPS-0000308', 'alyanhijazi@gmail.com', '03368182445', '2085-05-25', 'Male', 1, 9, 17, 67, NULL, 2, 1, '2107-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:58:05'),
(242, 165, 'Ali', 'Abid', 'BPS-0000333', 'ali.abid2941@gmail.com', '000000001', '2086-05-25', 'Male', 1, 9, 26, 46, NULL, 2, 1, '2108-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:20:09'),
(243, 232, 'Ajmal', 'Farooq', 'BPS-0000244', 'ajmal.farooq89@gmail.com', '03025707511', '2087-05-25', 'Male', 1, 9, 2, 54, NULL, 2, 1, '2109-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:55:08'),
(244, 231, 'Ain UI', 'Afin', 'BPS-0000199', 'ainafeen@basepracticesupport.co.uk', '0312-5605475', '2088-05-25', 'Male', 1, 9, 3, 58, NULL, 2, 1, '2110-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:44:28'),
(245, 227, 'Ahsan', 'Masood', 'BPS-0000008', 'ahsanm@basepracticesupport.co.uk', '03065546533', '2089-05-25', 'Male', 1, 9, 5, 38, NULL, 2, 1, '2111-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:15:51'),
(246, 226, 'Ahsan', 'Sadiq Butt', 'BPS-0000033', 'ahsanbutt@basepracticesupport.co.uk', '03365221383', '2090-05-25', 'Male', 1, 9, 25, 33, NULL, 4, 1, '2112-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 11:16:52'),
(247, 211, 'Ahmed', 'Hayat', 'BPS-0000311', 'hayatkahmed606@gmail.com', '0343-5644425', '2091-05-25', 'Male', 1, 9, 9, 60, NULL, 2, 1, '2113-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:48:26'),
(248, 180, 'Afnan', 'Ahmad', 'BPS-0000323', 'afnaankhan.109@gmail.com', '00000000016', '2092-05-25', 'Male', 1, 9, 12, 79, NULL, 2, 1, '2114-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:25:16'),
(249, 179, 'Abdur', 'Rehman', 'BPS-0000307', 'rehmankhan1240@gmail.com', '0306-9817642', '2093-05-25', 'Male', 1, 9, 11, 26, NULL, 2, 1, '2115-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 13:16:17'),
(250, 218, 'Abdul', 'Hanan', 'BPS-0000230', 'abdul.hanan@basepracticesupport.co.uk', '0301-6873063', '2094-05-25', 'Male', 1, 9, 7, 51, NULL, 2, 1, '2116-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 12:22:27'),
(251, 226, 'Abdul', 'Manaan Butt', 'BPS-0000321', 'hr@basepracticesupport.co.uk', '03361158414', '2095-05-25', 'Male', 1, 9, 22, 37, NULL, 6, 1, '2117-04-25', NULL, NULL, '', 'Islamabad', 'Islamabad', '', '163', '44000', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 08:00:48', '2025-01-28 14:27:43'),
(254, 232, 'Zubair Ali', 'Chachar', 'BPS-0000182', 'zubair.ali@basepracticesupport.co.uk', '03073490940', '2002-01-28', 'Male', 1, 9, 2, 54, NULL, 4, 1, '2020-01-28', '1970-01-01', NULL, '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'general', NULL, 0.00, 1, '2025-01-28 12:48:27', '2025-01-28 12:53:23');

-- --------------------------------------------------------

--
-- Table structure for table `employee_bank_accounts`
--

CREATE TABLE `employee_bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `account_title` varchar(191) NOT NULL,
  `account_number` varchar(191) NOT NULL,
  `bank_name` varchar(191) NOT NULL,
  `bank_code` varchar(191) NOT NULL,
  `bank_branch` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_bank_accounts`
--

INSERT INTO `employee_bank_accounts` (`id`, `employee_id`, `account_title`, `account_number`, `bank_name`, `bank_code`, `bank_branch`, `created_at`, `updated_at`) VALUES
(1, 12, 'Bob638', '674638', 'Standard Charterd', '6738', 'GEC', '2020-10-20 03:45:31', '2020-10-20 03:45:31'),
(2, 11, 'Nei-Dezhi', 'P-123', 'Prime Bank', 'P-987', 'Muradpur', '2021-01-25 21:12:02', '2021-01-25 21:18:32'),
(3, 14, 'Mayanak Agarwal', 'SE-123456', 'South-East Bank', 'SE-123', 'GEC', '2021-01-25 18:18:10', '2021-01-25 18:18:10'),
(4, 15, 'Mansoor-Ahmed', 'D-123456', 'Dutch Bangla', 'D-987', 'Agrabad', '2021-01-25 18:22:58', '2021-01-25 18:22:58'),
(5, 9, 'Sabiha', 'M-123456', 'Mutual Trust Bank', 'MTB-123', 'Dhaka', '2021-01-25 18:25:10', '2021-01-25 18:25:10'),
(6, 10, 'Jhon-Chena', 'IB-1234567', 'Islami Bank', 'IB-4567', 'Chawkbazar', '2021-01-25 18:28:46', '2021-01-25 18:28:46'),
(8, 13, 'Alice B', '1564788541', 'Sonali Bank', 'Sonali Bank-156', 'Agrabad', '2021-01-27 01:09:26', '2021-01-27 01:09:26');

-- --------------------------------------------------------

--
-- Table structure for table `employee_contacts`
--

CREATE TABLE `employee_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `relation_type_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `is_primary` tinyint(4) DEFAULT 0,
  `is_dependent` tinyint(4) DEFAULT 0,
  `contact_name` varchar(191) NOT NULL,
  `work_phone` varchar(191) DEFAULT NULL,
  `work_phone_ext` varchar(191) DEFAULT NULL,
  `personal_phone` varchar(191) DEFAULT NULL,
  `home_phone` varchar(191) DEFAULT NULL,
  `work_email` varchar(191) DEFAULT NULL,
  `personal_email` varchar(191) DEFAULT NULL,
  `address1` varchar(191) DEFAULT NULL,
  `address2` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `zip` varchar(191) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_contacts`
--

INSERT INTO `employee_contacts` (`id`, `employee_id`, `relation_type_id`, `is_primary`, `is_dependent`, `contact_name`, `work_phone`, `work_phone_ext`, `personal_phone`, `home_phone`, `work_email`, `personal_email`, `address1`, `address2`, `city`, `state`, `zip`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 12, 1, 1, NULL, 'Hogg Hobert', NULL, NULL, '67869689', NULL, NULL, 'Hogg34@gmail.com', '2869  University Street', NULL, 'Seattle', 'Washington', '98155', 1, '2020-10-20 03:09:31', '2020-10-20 03:09:31'),
(2, 9, 2, NULL, NULL, 'Haley Miranda', '4422443423', '2434234234', '2334234', '2342423423', 'myliwulun@mailinator.com', 'suguroxuz@mailinator.com', '43 Oak Court', 'Ab earum tempor in c', 'Et quia temporibus r', 'Perspiciatis eos e', '36865', 226, '2024-07-22 17:11:49', '2024-07-22 17:20:57');

-- --------------------------------------------------------

--
-- Table structure for table `employee_documents`
--

CREATE TABLE `employee_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `document_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `document_title` varchar(191) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `document_file` varchar(191) DEFAULT NULL,
  `expiry_date` date NOT NULL,
  `is_notify` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_documents`
--

INSERT INTO `employee_documents` (`id`, `employee_id`, `document_type_id`, `document_title`, `description`, `document_file`, `expiry_date`, `is_notify`, `created_at`, `updated_at`) VALUES
(3, 12, 1, 'My driving licence', 'driving licesnse for review', 'My driving licence.1603175008.png', '2023-03-30', NULL, '2020-10-20 03:23:28', '2020-10-20 03:23:28'),
(4, 38, 2, 'Testing', 'This is Testing', 'Testing.1618469061.png', '2021-04-16', 1, '2021-04-15 06:44:22', '2021-04-15 06:44:22'),
(5, 27, 3, 'Test', 'Test', 'Test.1633321238.png', '2021-10-05', NULL, '2021-10-04 04:20:38', '2021-10-04 04:20:38'),
(6, 9, 1, 'Test', '', 'Test.1674448248.jpeg', '2023-01-26', 1, '2023-01-23 04:30:48', '2023-01-23 05:37:26');

-- --------------------------------------------------------

--
-- Table structure for table `employee_immigrations`
--

CREATE TABLE `employee_immigrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `document_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `document_number` varchar(191) NOT NULL,
  `document_file` varchar(191) DEFAULT NULL,
  `issue_date` date NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `eligible_review_date` date DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_immigrations`
--

INSERT INTO `employee_immigrations` (`id`, `employee_id`, `document_type_id`, `document_number`, `document_file`, `issue_date`, `expiry_date`, `eligible_review_date`, `country_id`, `created_at`, `updated_at`) VALUES
(2, 12, 3, '673627839', 'immigration_673627839.png', '2015-08-14', '2023-05-19', '2023-03-30', 1, '2020-10-20 02:51:16', '2020-10-20 02:51:16'),
(3, 9, 1, '56757577657', 'immigration_56757577657.pdf', '0000-00-00', '2022-05-15', '2022-05-21', 1, '2022-05-26 03:59:37', '2022-05-26 04:24:47'),
(4, 9, 2, '7868688676', 'immigration_7868688676.pdf', '2022-05-01', '2022-05-10', '2022-05-15', 1, '2022-05-26 04:14:50', '2022-05-26 04:14:50'),
(6, 9, 2, 'Test', 'immigration_Test.jpeg', '2023-01-23', '2023-01-30', '2023-01-30', 20, '2023-01-23 05:57:37', '2023-01-23 05:57:37'),
(7, 9, 1, '76686', 'immigration_76686.jpg', '2024-07-17', '2024-07-18', '2024-07-10', 19, '2024-07-09 10:39:45', '2024-07-09 10:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `employee_interview`
--

CREATE TABLE `employee_interview` (
  `interview_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_interview`
--

INSERT INTO `employee_interview` (`interview_id`, `employee_id`) VALUES
(1, 9),
(1, 11),
(2, 9),
(3, 9);

-- --------------------------------------------------------

--
-- Table structure for table `employee_leave_type_details`
--

CREATE TABLE `employee_leave_type_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_detail` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_leave_type_details`
--

INSERT INTO `employee_leave_type_details` (`id`, `employee_id`, `leave_type_detail`, `created_at`, `updated_at`) VALUES
(2, 10, 'a:7:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;s:23:\"remaining_allocated_day\";i:150;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:2;a:4:{s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:3;a:4:{s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:4;a:4:{s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-03 05:40:35', '2023-11-07 05:46:42'),
(3, 11, 'a:7:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;s:23:\"remaining_allocated_day\";i:150;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:2;a:4:{s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:6;}i:3;a:4:{s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:4;a:4:{s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-03 05:40:35', '2023-11-07 05:46:42'),
(4, 12, 'a:7:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;s:23:\"remaining_allocated_day\";i:150;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:2;a:4:{s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:3;a:4:{s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:4;a:4:{s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-03 05:40:35', '2023-11-07 05:46:42'),
(5, 13, 'a:7:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;s:23:\"remaining_allocated_day\";i:150;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:2;a:4:{s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:3;a:4:{s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:4;a:4:{s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-03 05:40:35', '2023-11-07 05:46:42'),
(6, 14, 'a:7:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;s:23:\"remaining_allocated_day\";i:150;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:2;a:4:{s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:3;a:4:{s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:4;a:4:{s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-03 05:40:35', '2023-11-07 05:46:42'),
(7, 15, 'a:7:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;s:23:\"remaining_allocated_day\";i:150;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:2;a:4:{s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:3;a:4:{s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:4;a:4:{s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-03 05:40:35', '2023-11-07 05:46:42'),
(8, 27, 'a:7:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;s:23:\"remaining_allocated_day\";i:150;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:2;a:4:{s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:8;}i:3;a:4:{s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:4;a:4:{s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-03 05:40:35', '2023-11-07 05:46:42'),
(9, 34, 'a:7:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;s:23:\"remaining_allocated_day\";i:150;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:2;a:4:{s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:3;a:4:{s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:4;a:4:{s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-03 05:40:35', '2023-11-07 05:46:42'),
(10, 38, 'a:7:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;s:23:\"remaining_allocated_day\";i:150;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:2;a:4:{s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:3;a:4:{s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:4;a:4:{s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-03 05:40:35', '2023-11-07 05:46:42'),
(11, 45, 'a:7:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;s:23:\"remaining_allocated_day\";i:150;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:2;a:4:{s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:3;a:4:{s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:4;a:4:{s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-03 05:40:35', '2023-11-07 05:46:42'),
(12, 49, 'a:7:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;s:23:\"remaining_allocated_day\";i:150;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:2;a:4:{s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:3;a:4:{s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:4;a:4:{s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-03 05:40:35', '2023-11-07 05:46:42'),
(13, 51, 'a:7:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;s:23:\"remaining_allocated_day\";i:150;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:2;a:4:{s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:3;a:4:{s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:4;a:4:{s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-03 05:40:35', '2023-11-07 05:46:42'),
(14, 54, 'a:7:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;s:23:\"remaining_allocated_day\";i:150;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:2;a:4:{s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:3;a:4:{s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:4;a:4:{s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-03 05:40:35', '2023-11-07 05:46:42'),
(16, 9, 'a:7:{i:0;a:4:{s:23:\"remaining_allocated_day\";i:130;s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;}i:1;a:4:{s:23:\"remaining_allocated_day\";i:5;s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;}i:2;a:4:{s:23:\"remaining_allocated_day\";i:8;s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;}i:3;a:4:{s:23:\"remaining_allocated_day\";i:6;s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;}i:4;a:4:{s:23:\"remaining_allocated_day\";i:5;s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-12 09:17:43', '2023-11-07 05:46:42'),
(17, 57, 'a:7:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:7:\"Medical\";s:13:\"allocated_day\";i:150;s:23:\"remaining_allocated_day\";i:150;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:6:\"Casual\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:2;a:4:{s:13:\"leave_type_id\";i:3;s:10:\"leave_type\";s:6:\"Others\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:3;a:4:{s:13:\"leave_type_id\";i:6;s:10:\"leave_type\";s:4:\"Test\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}i:4;a:4:{s:13:\"leave_type_id\";i:7;s:10:\"leave_type\";s:6:\"Ramdan\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:5;a:4:{s:10:\"leave_type\";s:8:\"Maternal\";s:13:\"allocated_day\";s:2:\"30\";s:13:\"leave_type_id\";i:12;s:23:\"remaining_allocated_day\";s:2:\"30\";}i:6;a:4:{s:10:\"leave_type\";s:6:\"Test22\";s:13:\"allocated_day\";s:2:\"22\";s:13:\"leave_type_id\";i:13;s:23:\"remaining_allocated_day\";s:2:\"22\";}}', '2023-04-19 22:25:46', '2023-11-07 05:46:42'),
(21, 157, 'a:2:{i:0;a:4:{s:23:\"remaining_allocated_day\";i:1;s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;}i:1;a:4:{s:23:\"remaining_allocated_day\";i:10;s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 13:31:32'),
(22, 158, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(23, 159, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(24, 160, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(25, 161, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(26, 162, 'a:2:{i:0;a:4:{s:23:\"remaining_allocated_day\";i:4;s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;}i:1;a:4:{s:23:\"remaining_allocated_day\";i:8;s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-29 08:10:21'),
(27, 163, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(28, 164, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(29, 165, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(30, 166, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(31, 167, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(32, 168, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(33, 169, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(34, 170, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(35, 171, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(36, 172, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(37, 173, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(39, 175, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(40, 176, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(41, 177, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(42, 178, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(43, 179, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(44, 180, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(45, 181, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(46, 182, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(47, 183, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(48, 184, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(49, 185, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(50, 186, 'a:2:{i:0;a:4:{s:23:\"remaining_allocated_day\";i:3;s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;}i:1;a:4:{s:23:\"remaining_allocated_day\";i:10;s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 13:50:21'),
(51, 187, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(52, 188, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(53, 189, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(54, 190, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(55, 191, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(56, 192, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(57, 193, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(58, 194, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(59, 195, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(60, 196, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(61, 197, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(62, 198, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(63, 199, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(64, 200, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(65, 201, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(66, 202, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(67, 203, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(68, 204, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(69, 205, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(70, 206, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(71, 207, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(72, 208, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(73, 209, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(74, 210, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(75, 211, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(76, 212, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(77, 213, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(78, 214, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(79, 215, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(80, 216, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(81, 217, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(82, 218, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(83, 219, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(84, 220, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(85, 221, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(86, 222, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(87, 223, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(88, 224, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(89, 225, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(90, 226, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(91, 227, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(92, 228, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(93, 229, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(94, 230, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(95, 231, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(96, 232, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(97, 233, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(98, 234, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(99, 235, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(100, 236, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(101, 237, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(102, 238, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(103, 239, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(104, 240, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(105, 241, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(106, 242, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(107, 243, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(108, 244, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(109, 245, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(110, 246, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(111, 247, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(112, 248, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(113, 249, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(114, 250, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(115, 251, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 07:47:32', '2025-01-28 07:49:21'),
(117, 254, 'a:2:{i:0;a:4:{s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;s:23:\"remaining_allocated_day\";i:5;}i:1;a:4:{s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;s:23:\"remaining_allocated_day\";i:10;}}', '2025-01-28 12:48:27', '2025-01-28 12:48:27'),
(118, 174, 'a:2:{i:0;a:4:{s:23:\"remaining_allocated_day\";i:0;s:13:\"leave_type_id\";i:1;s:10:\"leave_type\";s:10:\"Sick Leave\";s:13:\"allocated_day\";i:5;}i:1;a:4:{s:23:\"remaining_allocated_day\";i:10;s:13:\"leave_type_id\";i:2;s:10:\"leave_type\";s:12:\"Annual Leave\";s:13:\"allocated_day\";i:10;}}', NULL, '2025-01-29 08:46:26');

-- --------------------------------------------------------

--
-- Table structure for table `employee_meeting`
--

CREATE TABLE `employee_meeting` (
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `meeting_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_meeting`
--

INSERT INTO `employee_meeting` (`employee_id`, `meeting_id`) VALUES
(251, 6);

-- --------------------------------------------------------

--
-- Table structure for table `employee_project`
--

CREATE TABLE `employee_project` (
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_project`
--

INSERT INTO `employee_project` (`employee_id`, `project_id`) VALUES
(9, 1),
(9, 3),
(9, 4),
(11, 1),
(12, 1),
(13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_qualificaitons`
--

CREATE TABLE `employee_qualificaitons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `education_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `institution_name` varchar(191) NOT NULL,
  `from_year` date DEFAULT NULL,
  `to_year` date DEFAULT NULL,
  `language_skill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `general_skill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_qualificaitons`
--

INSERT INTO `employee_qualificaitons` (`id`, `employee_id`, `education_level_id`, `institution_name`, `from_year`, `to_year`, `language_skill_id`, `general_skill_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 12, 1, 'Boston University', '2014-07-09', '2018-10-01', 1, 2, NULL, '2020-10-20 03:34:11', '2020-10-20 03:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `employee_support_ticket`
--

CREATE TABLE `employee_support_ticket` (
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_task`
--

CREATE TABLE `employee_task` (
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_task`
--

INSERT INTO `employee_task` (`employee_id`, `task_id`) VALUES
(9, 7),
(11, 1),
(157, 9),
(157, 10),
(158, 10),
(159, 9),
(160, 9);

-- --------------------------------------------------------

--
-- Table structure for table `employee_training_list`
--

CREATE TABLE `employee_training_list` (
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `training_list_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_training_list`
--

INSERT INTO `employee_training_list` (`employee_id`, `training_list_id`) VALUES
(240, 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_work_experience`
--

CREATE TABLE `employee_work_experience` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(191) NOT NULL,
  `from_year` date DEFAULT NULL,
  `to_year` date DEFAULT NULL,
  `post` varchar(191) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_work_experience`
--

INSERT INTO `employee_work_experience` (`id`, `employee_id`, `company_name`, `from_year`, `to_year`, `post`, `description`, `created_at`, `updated_at`) VALUES
(1, 12, 'RanksFc', '2017-08-05', '2019-01-29', 'Junior Executive', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English', '2020-10-20 03:42:50', '2020-10-20 03:42:50'),
(2, 9, 'dsfdsf', '2022-12-20', '2022-12-21', 'sdfdsfs', 'fdsfdsfsdfdfsd', '2022-12-19 07:29:12', '2022-12-19 07:29:12');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `event_title` varchar(191) NOT NULL,
  `event_note` mediumtext NOT NULL,
  `event_date` date NOT NULL,
  `event_time` varchar(191) NOT NULL,
  `status` varchar(30) NOT NULL,
  `is_notify` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `company_id`, `department_id`, `event_title`, `event_note`, `event_date`, `event_time`, `status`, `is_notify`, `created_at`, `updated_at`) VALUES
(5, 9, 22, 'Test Event', 'Test Event', '2025-01-30', '05:30PM', 'pending', 1, '2025-01-28 08:19:41', '2025-01-28 08:19:41');

-- --------------------------------------------------------

--
-- Table structure for table `expense_types`
--

CREATE TABLE `expense_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(40) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_types`
--

INSERT INTO `expense_types` (`id`, `company_id`, `type`, `created_at`, `updated_at`) VALUES
(5, 9, 'Utility', '2025-01-28 07:51:22', '2025-01-28 07:51:22');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_managers`
--

CREATE TABLE `file_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `file_name` varchar(191) NOT NULL,
  `file_size` varchar(191) DEFAULT NULL,
  `file_extension` varchar(191) DEFAULT NULL,
  `external_link` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_managers`
--

INSERT INTO `file_managers` (`id`, `department_id`, `added_by`, `file_name`, `file_size`, `file_extension`, `external_link`, `created_at`, `updated_at`) VALUES
(2, 22, 226, 'Test Policy Document', '78.37 KB', 'png', '', '2025-01-28 08:50:41', '2025-01-28 08:50:41');

-- --------------------------------------------------------

--
-- Table structure for table `file_manager_settings`
--

CREATE TABLE `file_manager_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `allowed_extensions` mediumtext NOT NULL,
  `max_file_size` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_manager_settings`
--

INSERT INTO `file_manager_settings` (`id`, `allowed_extensions`, `max_file_size`, `created_at`, `updated_at`) VALUES
(1, 'jpg,png,doc,docx,pdf,csv,xls,jpeg', 20, '2020-07-29 05:59:20', '2020-07-29 05:59:20');

-- --------------------------------------------------------

--
-- Table structure for table `finance_bank_cashes`
--

CREATE TABLE `finance_bank_cashes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_name` varchar(50) NOT NULL,
  `account_balance` varchar(191) NOT NULL,
  `initial_balance` varchar(191) NOT NULL,
  `account_number` varchar(191) NOT NULL,
  `branch_code` varchar(191) NOT NULL,
  `bank_branch` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finance_bank_cashes`
--

INSERT INTO `finance_bank_cashes` (`id`, `account_name`, `account_balance`, `initial_balance`, `account_number`, `branch_code`, `bank_branch`, `created_at`, `updated_at`) VALUES
(1, 'Central Bank', '18117', '50000', '5635636', '676', 'Ethopia', '2020-07-28 17:17:21', '2024-07-23 17:33:59'),
(2, 'New Horizon', '144845', '35000', '5534677', '453', 'Orchestra', '2020-07-28 17:18:15', '2024-07-23 17:15:46');

-- --------------------------------------------------------

--
-- Table structure for table `finance_deposits`
--

CREATE TABLE `finance_deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` varchar(30) NOT NULL,
  `deposit_category_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `description` mediumtext DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deposit_reference` varchar(191) NOT NULL,
  `deposit_file` varchar(191) DEFAULT NULL,
  `deposit_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finance_deposits`
--

INSERT INTO `finance_deposits` (`id`, `company_id`, `account_id`, `amount`, `deposit_category_id`, `description`, `payment_method_id`, `payer_id`, `deposit_reference`, `deposit_file`, `deposit_date`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, '110500', 1, 'gfddds', 3, 1, '564534', NULL, '2021-03-28', '2020-07-28 17:24:20', '2020-07-28 17:26:37'),
(5, NULL, 2, '110500', 1, NULL, 1, 2, '37763', NULL, '2021-03-27', '2020-07-28 18:12:31', '2020-07-29 05:28:25'),
(111, NULL, 1, '78', 1, 'khkhhk', 1, 1, '7878', NULL, '2024-02-13', '2024-02-13 04:20:41', '2024-02-13 04:20:41'),
(118, NULL, 2, '345', 6, 'Veniam in et volupt', 2, 1, '35435', NULL, '2024-07-17', '2024-07-23 17:15:46', '2024-07-23 17:15:46'),
(119, NULL, 1, '90', 8, 'Consequatur consequa', 1, 2, 'uioj99', NULL, '2024-07-26', '2024-07-23 17:16:23', '2024-07-23 17:33:59');

-- --------------------------------------------------------

--
-- Table structure for table `finance_expenses`
--

CREATE TABLE `finance_expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` varchar(30) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expense_reference` varchar(191) NOT NULL,
  `expense_file` varchar(191) DEFAULT NULL,
  `expense_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finance_expenses`
--

INSERT INTO `finance_expenses` (`id`, `company_id`, `account_id`, `amount`, `category_id`, `description`, `payment_method_id`, `payee_id`, `expense_reference`, `expense_file`, `expense_date`, `created_at`, `updated_at`) VALUES
(9, NULL, 1, '20000', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-26', '2020-07-29 07:20:58', '2020-07-29 07:20:58'),
(10, NULL, 1, '1000', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-26', '2020-07-29 07:38:34', '2020-07-29 07:38:34'),
(11, NULL, 1, '1500', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-26', '2020-07-29 09:11:51', '2020-07-29 09:11:51'),
(12, NULL, 1, '1500', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-26', '2020-07-29 09:33:49', '2020-07-29 09:33:49'),
(13, NULL, 1, '2190', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-26', '2020-07-29 18:25:19', '2020-07-29 18:25:19'),
(14, NULL, 1, '1500', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-26', '2020-07-29 19:08:48', '2020-07-29 19:08:48'),
(16, NULL, 1, '310', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-26', '2020-07-29 20:32:34', '2020-07-29 20:32:34'),
(19, NULL, 1, '965', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-02-28', '2020-10-15 06:27:00', '2020-10-15 06:27:00'),
(20, NULL, 1, '310', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-02-28', '2020-10-19 11:54:47', '2020-10-19 11:54:47'),
(21, NULL, 1, '3690', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-01-24', '2020-10-19 11:57:30', '2020-10-19 11:57:30'),
(22, NULL, 1, '310', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-05', '2021-03-05 12:49:44', '2021-03-05 12:49:44'),
(23, NULL, 1, '49800', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 06:18:02', '2021-03-12 06:18:02'),
(24, NULL, 1, '110', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 06:40:21', '2021-03-12 06:40:21'),
(25, NULL, 1, '1705', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 06:52:46', '2021-03-12 06:52:46'),
(26, NULL, 1, '3880', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 07:20:57', '2021-03-12 07:20:57'),
(27, NULL, 1, '3880', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 07:27:15', '2021-03-12 07:27:15'),
(28, NULL, 1, '1110', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 07:31:31', '2021-03-12 07:31:31'),
(29, NULL, 1, '2590', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 10:24:41', '2021-03-12 10:24:41'),
(30, NULL, 1, '175', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 10:26:26', '2021-03-12 10:26:26'),
(31, NULL, 1, '110', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 10:34:06', '2021-03-12 10:34:06'),
(32, NULL, 1, '310', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 11:03:09', '2021-03-12 11:03:09'),
(33, NULL, 1, '2590', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 11:27:41', '2021-03-12 11:27:41'),
(34, NULL, 1, '0', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 11:40:29', '2021-03-12 11:40:29'),
(35, NULL, 1, '2305', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 11:46:25', '2021-03-12 11:46:25'),
(36, NULL, 1, '110', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 13:03:55', '2021-03-12 13:03:55'),
(37, NULL, 1, '660', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 13:07:59', '2021-03-12 13:07:59'),
(38, NULL, 1, '660', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 13:08:48', '2021-03-12 13:08:48'),
(39, NULL, 1, '420', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 13:12:40', '2021-03-12 13:12:40'),
(40, NULL, 1, '650', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 13:16:06', '2021-03-12 13:16:06'),
(41, NULL, 1, '310', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', '2021-03-12 13:17:02', '2021-03-12 13:17:02'),
(42, NULL, 1, '660', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-13', '2021-03-13 10:07:03', '2021-03-13 10:07:03'),
(43, NULL, 1, '0', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-13', '2021-03-13 10:07:25', '2021-03-13 10:07:25'),
(44, NULL, 1, '1490', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-20', '2021-03-20 14:25:41', '2021-03-20 14:25:41'),
(45, NULL, 1, '2090', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-20', '2021-03-20 14:37:54', '2021-03-20 14:37:54'),
(46, NULL, 1, '2090', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-22', '2021-03-22 13:44:20', '2021-03-22 13:44:20'),
(47, NULL, 1, '340', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-22', '2021-03-22 14:30:06', '2021-03-22 14:30:06'),
(48, NULL, 1, '175', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-22', '2021-03-22 14:36:02', '2021-03-22 14:36:02'),
(49, NULL, 1, '375', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-06', '2021-04-06 03:31:41', '2021-04-06 03:31:41'),
(50, NULL, 1, '110', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-06', '2021-04-06 03:36:28', '2021-04-06 03:36:28'),
(51, NULL, 1, '200', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-06', '2021-04-06 05:07:42', '2021-04-06 05:07:42'),
(52, NULL, 1, '775', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-08', '2021-04-08 17:35:48', '2021-04-08 17:35:48'),
(53, NULL, 1, '675', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-08', '2021-04-08 17:36:12', '2021-04-08 17:36:12'),
(54, NULL, 1, '675', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-09', '2021-04-09 07:27:31', '2021-04-09 07:27:31'),
(55, NULL, 1, '800', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-09', '2021-04-09 07:29:25', '2021-04-09 07:29:25'),
(56, NULL, 1, '1050', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-09', '2021-04-09 16:48:46', '2021-04-09 16:48:46'),
(57, NULL, 1, '950', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-10', '2021-04-10 13:45:13', '2021-04-10 13:45:13'),
(58, NULL, 1, '1050', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-10', '2021-04-10 16:01:21', '2021-04-10 16:01:21'),
(59, NULL, 1, '905', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-10', '2021-04-10 17:06:06', '2021-04-10 17:06:06'),
(60, NULL, 1, '1090', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-10', '2021-04-10 17:07:24', '2021-04-10 17:07:24'),
(61, NULL, 1, '990', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', '2021-04-11 02:29:36', '2021-04-11 02:29:36'),
(62, NULL, 1, '950', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', '2021-04-11 02:49:48', '2021-04-11 02:49:48'),
(63, NULL, 1, '83.333', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', '2021-04-11 04:01:42', '2021-04-11 04:01:42'),
(64, NULL, 1, '83.333', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', '2021-04-11 04:03:00', '2021-04-11 04:03:00'),
(65, NULL, 1, '83.333', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', '2021-04-11 04:03:57', '2021-04-11 04:03:57'),
(66, NULL, 1, '83.333', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', '2021-04-11 04:11:40', '2021-04-11 04:11:40'),
(67, NULL, 1, '715', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', '2021-04-11 17:40:48', '2021-04-11 17:40:48'),
(68, NULL, 1, '715', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', '2021-04-11 17:52:03', '2021-04-11 17:52:03'),
(69, NULL, 1, '605', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-12', '2021-04-12 01:16:42', '2021-04-12 01:16:42'),
(70, NULL, 1, '605', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-12', '2021-04-12 01:19:09', '2021-04-12 01:19:09'),
(71, NULL, 1, '1615', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-12', '2021-04-12 17:33:37', '2021-04-12 17:33:37'),
(72, NULL, 1, '215', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-12', '2021-04-12 17:34:45', '2021-04-12 17:34:45'),
(73, NULL, 1, '215', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-12', '2021-04-12 17:35:23', '2021-04-12 17:35:23'),
(74, NULL, 1, '215', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-12', '2021-04-12 17:36:32', '2021-04-12 17:36:32'),
(75, NULL, 1, '215', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-12', '2021-04-12 17:36:32', '2021-04-12 17:36:32'),
(76, NULL, 1, '85', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-13', '2021-04-13 05:06:17', '2021-04-13 05:06:17'),
(77, NULL, 1, '4055', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-13', '2021-04-13 15:28:42', '2021-04-13 15:28:42'),
(78, NULL, 1, '165', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-13', '2021-04-13 15:36:59', '2021-04-13 15:36:59'),
(79, NULL, 1, '410', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-14', '2021-04-13 21:41:16', '2021-04-13 21:41:16'),
(82, NULL, 1, '165', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-14', '2021-04-14 16:15:33', '2021-04-14 16:15:33'),
(83, NULL, 1, '75', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-14', '2021-04-14 16:17:30', '2021-04-14 16:17:30'),
(84, NULL, 1, '200', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-14', '2021-04-14 16:37:09', '2021-04-14 16:37:09'),
(85, NULL, 1, '275', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-15', '2021-04-14 20:39:45', '2021-04-14 20:39:45'),
(86, NULL, 1, '139', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-15', '2021-04-14 21:07:53', '2021-04-14 21:07:53'),
(87, NULL, 1, '740', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-07-03', '2021-07-03 13:48:19', '2021-07-03 13:48:19'),
(88, NULL, 1, '350', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-07-23', '2022-07-23 08:15:27', '2022-07-23 08:15:27'),
(89, NULL, 1, '70', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-18', '2022-10-18 15:22:39', '2022-10-18 15:22:39'),
(90, NULL, 1, '195', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', '2022-10-24 06:59:00', '2022-10-24 06:59:00'),
(91, NULL, 1, '195', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', '2022-10-24 06:59:26', '2022-10-24 06:59:26'),
(92, NULL, 1, '195', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', '2022-10-24 07:02:13', '2022-10-24 07:02:13'),
(93, NULL, 1, '205', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', '2022-10-24 07:03:42', '2022-10-24 07:03:42'),
(94, NULL, 1, '185', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', '2022-10-24 07:13:06', '2022-10-24 07:13:06'),
(95, NULL, 1, '185', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', '2022-10-24 07:14:39', '2022-10-24 07:14:39'),
(96, NULL, 1, '185', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', '2022-10-24 07:16:11', '2022-10-24 07:16:11'),
(97, NULL, 1, '185', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', '2022-10-24 07:19:20', '2022-10-24 07:19:20'),
(98, NULL, 1, '185', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', '2022-10-24 07:19:55', '2022-10-24 07:19:55'),
(99, NULL, 1, '185', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', '2022-10-24 09:17:34', '2022-10-24 09:17:34'),
(100, NULL, 1, '185', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', '2022-10-24 09:18:13', '2022-10-24 09:18:13'),
(101, NULL, 1, '195', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', '2022-10-24 09:37:13', '2022-10-24 09:37:13'),
(102, NULL, 1, '195', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', '2022-10-24 09:37:26', '2022-10-24 09:37:26'),
(103, NULL, 1, '195', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-25', '2022-10-25 07:41:16', '2022-10-25 07:41:16'),
(104, NULL, 1, '195', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-25', '2022-10-25 07:41:53', '2022-10-25 07:41:53'),
(105, NULL, 1, '205', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-25', '2022-10-25 07:42:42', '2022-10-25 07:42:42'),
(106, NULL, 1, '195', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-26', '2022-10-26 09:16:28', '2022-10-26 09:16:28'),
(107, NULL, 1, '195', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-26', '2022-10-26 09:17:07', '2022-10-26 09:17:07'),
(108, NULL, 1, '350', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2023-04-15', '2023-04-15 05:18:37', '2023-04-15 05:18:37'),
(109, NULL, 1, '55', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2023-04-15', '2023-04-15 07:58:00', '2023-04-15 07:58:00'),
(110, NULL, 1, '350', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2023-09-12', '2023-09-12 04:39:31', '2023-09-12 04:39:31'),
(112, NULL, 1, '20', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2024-04-25', '2024-04-25 11:43:54', '2024-04-25 11:43:54'),
(113, NULL, 1, '120', NULL, NULL, NULL, NULL, 'Payroll', NULL, '2024-04-25', '2024-04-25 11:47:33', '2024-04-25 11:47:33');

-- --------------------------------------------------------

--
-- Table structure for table `finance_payees`
--

CREATE TABLE `finance_payees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payee_name` varchar(50) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finance_payees`
--

INSERT INTO `finance_payees` (`id`, `payee_name`, `contact_no`, `created_at`, `updated_at`) VALUES
(1, 'Mr. A', '563345', '2020-07-28 17:22:13', '2020-07-28 17:22:13'),
(2, 'Mr. B', '5656353', '2020-07-28 17:22:31', '2020-07-28 17:22:31');

-- --------------------------------------------------------

--
-- Table structure for table `finance_payers`
--

CREATE TABLE `finance_payers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payer_name` varchar(50) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finance_payers`
--

INSERT INTO `finance_payers` (`id`, `payer_name`, `contact_no`, `created_at`, `updated_at`) VALUES
(1, 'Mr. X', '34242', '2020-07-28 17:23:01', '2020-07-28 17:23:01'),
(2, 'Mr. Z', '54563', '2020-07-28 17:23:19', '2020-07-28 17:23:19');

-- --------------------------------------------------------

--
-- Table structure for table `finance_transactions`
--

CREATE TABLE `finance_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` varchar(30) NOT NULL,
  `category` varchar(30) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expense_reference` varchar(191) DEFAULT NULL,
  `expense_file` varchar(191) DEFAULT NULL,
  `expense_date` date DEFAULT NULL,
  `deposit_reference` varchar(191) DEFAULT NULL,
  `deposit_file` varchar(191) DEFAULT NULL,
  `deposit_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finance_transactions`
--

INSERT INTO `finance_transactions` (`id`, `company_id`, `account_id`, `amount`, `category`, `category_id`, `description`, `payment_method_id`, `payee_id`, `payer_id`, `expense_reference`, `expense_file`, `expense_date`, `deposit_reference`, `deposit_file`, `deposit_date`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, '110500', 'interest income', NULL, 'gfddds', 3, NULL, 1, NULL, NULL, NULL, '564534', NULL, '2021-03-28', '2020-07-28 17:24:20', '2020-07-28 17:26:37'),
(5, NULL, 2, '110500', 'interest income', NULL, NULL, 1, NULL, 2, NULL, NULL, NULL, '37763', NULL, '2021-03-27', '2020-07-28 18:12:31', '2020-07-29 05:28:25'),
(6, NULL, 2, '2000', 'transfer', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '6736', NULL, '2021-03-30', '2020-07-29 05:36:41', '2020-07-29 05:36:41'),
(7, NULL, 1, '2000', 'transfer', NULL, NULL, 1, NULL, NULL, '6736', NULL, '2021-03-30', NULL, NULL, NULL, '2020-07-29 05:36:41', '2020-07-29 05:36:41'),
(9, NULL, 1, '20000', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-26', NULL, NULL, NULL, '2020-07-29 07:20:58', '2020-07-29 07:20:58'),
(10, NULL, 1, '1000', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-26', NULL, NULL, NULL, '2020-07-29 07:38:34', '2020-07-29 07:38:34'),
(11, NULL, 1, '1500', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-26', NULL, NULL, NULL, '2020-07-29 09:11:51', '2020-07-29 09:11:51'),
(12, NULL, 1, '1500', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-26', NULL, NULL, NULL, '2020-07-29 09:33:49', '2020-07-29 09:33:49'),
(13, NULL, 1, '2190', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-26', NULL, NULL, NULL, '2020-07-29 18:25:19', '2020-07-29 18:25:19'),
(14, NULL, 1, '1500', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-26', NULL, NULL, NULL, '2020-07-29 19:08:47', '2020-07-29 19:08:47'),
(16, NULL, 1, '310', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-26', NULL, NULL, NULL, '2020-07-29 20:32:34', '2020-07-29 20:32:34'),
(19, NULL, 1, '965', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-02-28', NULL, NULL, NULL, '2020-10-15 06:27:00', '2020-10-15 06:27:00'),
(20, NULL, 1, '310', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-02-28', NULL, NULL, NULL, '2020-10-19 11:54:47', '2020-10-19 11:54:47'),
(21, NULL, 1, '3690', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-01-24', NULL, NULL, NULL, '2020-10-19 11:57:30', '2020-10-19 11:57:30'),
(22, NULL, 1, '310', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-05', NULL, NULL, NULL, '2021-03-05 12:49:44', '2021-03-05 12:49:44'),
(23, NULL, 1, '49800', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 06:18:02', '2021-03-12 06:18:02'),
(24, NULL, 1, '110', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 06:40:21', '2021-03-12 06:40:21'),
(25, NULL, 1, '1705', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 06:52:46', '2021-03-12 06:52:46'),
(26, NULL, 1, '3880', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 07:20:57', '2021-03-12 07:20:57'),
(27, NULL, 1, '3880', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 07:27:15', '2021-03-12 07:27:15'),
(28, NULL, 1, '1110', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 07:31:31', '2021-03-12 07:31:31'),
(29, NULL, 1, '2590', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 10:24:41', '2021-03-12 10:24:41'),
(30, NULL, 1, '175', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 10:26:26', '2021-03-12 10:26:26'),
(31, NULL, 1, '110', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 10:34:06', '2021-03-12 10:34:06'),
(32, NULL, 1, '310', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 11:03:09', '2021-03-12 11:03:09'),
(33, NULL, 1, '2590', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 11:27:41', '2021-03-12 11:27:41'),
(34, NULL, 1, '0', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 11:40:29', '2021-03-12 11:40:29'),
(35, NULL, 1, '2305', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 11:46:24', '2021-03-12 11:46:24'),
(36, NULL, 1, '110', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 13:03:55', '2021-03-12 13:03:55'),
(37, NULL, 1, '660', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 13:07:59', '2021-03-12 13:07:59'),
(38, NULL, 1, '660', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 13:08:48', '2021-03-12 13:08:48'),
(39, NULL, 1, '420', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 13:12:40', '2021-03-12 13:12:40'),
(40, NULL, 1, '650', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 13:16:06', '2021-03-12 13:16:06'),
(41, NULL, 1, '310', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-12', NULL, NULL, NULL, '2021-03-12 13:17:02', '2021-03-12 13:17:02'),
(42, NULL, 1, '660', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-13', NULL, NULL, NULL, '2021-03-13 10:07:03', '2021-03-13 10:07:03'),
(43, NULL, 1, '0', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-13', NULL, NULL, NULL, '2021-03-13 10:07:25', '2021-03-13 10:07:25'),
(44, NULL, 1, '1490', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-20', NULL, NULL, NULL, '2021-03-20 14:25:41', '2021-03-20 14:25:41'),
(45, NULL, 1, '2090', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-20', NULL, NULL, NULL, '2021-03-20 14:37:54', '2021-03-20 14:37:54'),
(46, NULL, 1, '2090', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-22', NULL, NULL, NULL, '2021-03-22 13:44:20', '2021-03-22 13:44:20'),
(47, NULL, 1, '340', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-22', NULL, NULL, NULL, '2021-03-22 14:30:06', '2021-03-22 14:30:06'),
(48, NULL, 1, '175', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-03-22', NULL, NULL, NULL, '2021-03-22 14:36:02', '2021-03-22 14:36:02'),
(49, NULL, 1, '375', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-06', NULL, NULL, NULL, '2021-04-06 03:31:41', '2021-04-06 03:31:41'),
(50, NULL, 1, '110', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-06', NULL, NULL, NULL, '2021-04-06 03:36:28', '2021-04-06 03:36:28'),
(51, NULL, 1, '200', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-06', NULL, NULL, NULL, '2021-04-06 05:07:42', '2021-04-06 05:07:42'),
(52, NULL, 1, '775', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-08', NULL, NULL, NULL, '2021-04-08 17:35:47', '2021-04-08 17:35:47'),
(53, NULL, 1, '675', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-08', NULL, NULL, NULL, '2021-04-08 17:36:12', '2021-04-08 17:36:12'),
(54, NULL, 1, '675', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-09', NULL, NULL, NULL, '2021-04-09 07:27:31', '2021-04-09 07:27:31'),
(55, NULL, 1, '800', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-09', NULL, NULL, NULL, '2021-04-09 07:29:25', '2021-04-09 07:29:25'),
(56, NULL, 1, '1050', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-09', NULL, NULL, NULL, '2021-04-09 16:48:46', '2021-04-09 16:48:46'),
(57, NULL, 1, '950', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-10', NULL, NULL, NULL, '2021-04-10 13:45:13', '2021-04-10 13:45:13'),
(58, NULL, 1, '1050', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-10', NULL, NULL, NULL, '2021-04-10 16:01:21', '2021-04-10 16:01:21'),
(59, NULL, 1, '905', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-10', NULL, NULL, NULL, '2021-04-10 17:06:06', '2021-04-10 17:06:06'),
(60, NULL, 1, '1090', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-10', NULL, NULL, NULL, '2021-04-10 17:07:24', '2021-04-10 17:07:24'),
(61, NULL, 1, '990', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', NULL, NULL, NULL, '2021-04-11 02:29:36', '2021-04-11 02:29:36'),
(62, NULL, 1, '950', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', NULL, NULL, NULL, '2021-04-11 02:49:48', '2021-04-11 02:49:48'),
(63, NULL, 1, '83.333', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', NULL, NULL, NULL, '2021-04-11 04:01:42', '2021-04-11 04:01:42'),
(64, NULL, 1, '83.333', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', NULL, NULL, NULL, '2021-04-11 04:03:00', '2021-04-11 04:03:00'),
(65, NULL, 1, '83.333', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', NULL, NULL, NULL, '2021-04-11 04:03:57', '2021-04-11 04:03:57'),
(66, NULL, 1, '83.333', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', NULL, NULL, NULL, '2021-04-11 04:11:40', '2021-04-11 04:11:40'),
(67, NULL, 1, '715', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', NULL, NULL, NULL, '2021-04-11 17:40:47', '2021-04-11 17:40:47'),
(68, NULL, 1, '715', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-11', NULL, NULL, NULL, '2021-04-11 17:52:03', '2021-04-11 17:52:03'),
(69, NULL, 1, '605', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-12', NULL, NULL, NULL, '2021-04-12 01:16:41', '2021-04-12 01:16:41'),
(70, NULL, 1, '605', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-12', NULL, NULL, NULL, '2021-04-12 01:19:09', '2021-04-12 01:19:09'),
(71, NULL, 1, '1615', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-12', NULL, NULL, NULL, '2021-04-12 17:33:37', '2021-04-12 17:33:37'),
(72, NULL, 1, '215', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-12', NULL, NULL, NULL, '2021-04-12 17:34:45', '2021-04-12 17:34:45'),
(73, NULL, 1, '215', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-12', NULL, NULL, NULL, '2021-04-12 17:35:23', '2021-04-12 17:35:23'),
(74, NULL, 1, '215', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-12', NULL, NULL, NULL, '2021-04-12 17:36:32', '2021-04-12 17:36:32'),
(75, NULL, 1, '215', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-12', NULL, NULL, NULL, '2021-04-12 17:36:32', '2021-04-12 17:36:32'),
(76, NULL, 1, '85', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-13', NULL, NULL, NULL, '2021-04-13 05:06:17', '2021-04-13 05:06:17'),
(77, NULL, 1, '4055', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-13', NULL, NULL, NULL, '2021-04-13 15:28:42', '2021-04-13 15:28:42'),
(78, NULL, 1, '165', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-13', NULL, NULL, NULL, '2021-04-13 15:36:59', '2021-04-13 15:36:59'),
(79, NULL, 1, '410', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-14', NULL, NULL, NULL, '2021-04-13 21:41:16', '2021-04-13 21:41:16'),
(82, NULL, 1, '165', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-14', NULL, NULL, NULL, '2021-04-14 16:15:33', '2021-04-14 16:15:33'),
(83, NULL, 1, '75', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-14', NULL, NULL, NULL, '2021-04-14 16:17:30', '2021-04-14 16:17:30'),
(84, NULL, 1, '200', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-14', NULL, NULL, NULL, '2021-04-14 16:37:09', '2021-04-14 16:37:09'),
(85, NULL, 1, '275', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-15', NULL, NULL, NULL, '2021-04-14 20:39:45', '2021-04-14 20:39:45'),
(86, NULL, 1, '139', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-04-15', NULL, NULL, NULL, '2021-04-14 21:07:53', '2021-04-14 21:07:53'),
(87, NULL, 1, '740', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2021-07-03', NULL, NULL, NULL, '2021-07-03 13:48:19', '2021-07-03 13:48:19'),
(88, NULL, 1, '350', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-07-23', NULL, NULL, NULL, '2022-07-23 08:15:27', '2022-07-23 08:15:27'),
(89, NULL, 1, '70', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-18', NULL, NULL, NULL, '2022-10-18 15:22:39', '2022-10-18 15:22:39'),
(90, NULL, 1, '195', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', NULL, NULL, NULL, '2022-10-24 06:59:00', '2022-10-24 06:59:00'),
(91, NULL, 1, '195', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', NULL, NULL, NULL, '2022-10-24 06:59:26', '2022-10-24 06:59:26'),
(92, NULL, 1, '195', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', NULL, NULL, NULL, '2022-10-24 07:02:13', '2022-10-24 07:02:13'),
(93, NULL, 1, '205', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', NULL, NULL, NULL, '2022-10-24 07:03:42', '2022-10-24 07:03:42'),
(94, NULL, 1, '185', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', NULL, NULL, NULL, '2022-10-24 07:13:06', '2022-10-24 07:13:06'),
(95, NULL, 1, '185', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', NULL, NULL, NULL, '2022-10-24 07:14:39', '2022-10-24 07:14:39'),
(96, NULL, 1, '185', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', NULL, NULL, NULL, '2022-10-24 07:16:11', '2022-10-24 07:16:11'),
(97, NULL, 1, '185', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', NULL, NULL, NULL, '2022-10-24 07:19:20', '2022-10-24 07:19:20'),
(98, NULL, 1, '185', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', NULL, NULL, NULL, '2022-10-24 07:19:55', '2022-10-24 07:19:55'),
(99, NULL, 1, '185', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', NULL, NULL, NULL, '2022-10-24 09:17:34', '2022-10-24 09:17:34'),
(100, NULL, 1, '185', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', NULL, NULL, NULL, '2022-10-24 09:18:13', '2022-10-24 09:18:13'),
(101, NULL, 1, '195', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', NULL, NULL, NULL, '2022-10-24 09:37:13', '2022-10-24 09:37:13'),
(102, NULL, 1, '195', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-24', NULL, NULL, NULL, '2022-10-24 09:37:26', '2022-10-24 09:37:26'),
(103, NULL, 1, '195', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-25', NULL, NULL, NULL, '2022-10-25 07:41:16', '2022-10-25 07:41:16'),
(104, NULL, 1, '195', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-25', NULL, NULL, NULL, '2022-10-25 07:41:53', '2022-10-25 07:41:53'),
(105, NULL, 1, '205', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-25', NULL, NULL, NULL, '2022-10-25 07:42:42', '2022-10-25 07:42:42'),
(106, NULL, 1, '195', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-26', NULL, NULL, NULL, '2022-10-26 09:16:28', '2022-10-26 09:16:28'),
(107, NULL, 1, '195', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2022-10-26', NULL, NULL, NULL, '2022-10-26 09:17:07', '2022-10-26 09:17:07'),
(108, NULL, 1, '350', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2023-04-15', NULL, NULL, NULL, '2023-04-15 05:18:37', '2023-04-15 05:18:37'),
(109, NULL, 1, '55', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2023-04-15', NULL, NULL, NULL, '2023-04-15 07:58:00', '2023-04-15 07:58:00'),
(110, NULL, 1, '350', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2023-09-12', NULL, NULL, NULL, '2023-09-12 04:39:31', '2023-09-12 04:39:31'),
(111, NULL, 1, '78', 'Envato', NULL, 'khkhhk', 1, NULL, 1, NULL, NULL, NULL, '7878', NULL, '2024-02-13', '2024-02-13 04:20:41', '2024-02-13 04:20:41'),
(112, NULL, 1, '20', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2024-04-25', NULL, NULL, NULL, '2024-04-25 11:43:54', '2024-04-25 11:43:54'),
(113, NULL, 1, '120', '', NULL, NULL, NULL, NULL, NULL, 'Payroll', NULL, '2024-04-25', NULL, NULL, NULL, '2024-04-25 11:47:33', '2024-04-25 11:47:33'),
(118, NULL, 2, '345', '', NULL, 'Veniam in et volupt', 2, NULL, 1, NULL, NULL, NULL, '35435', NULL, '2024-07-17', '2024-07-23 17:15:46', '2024-07-23 17:15:46'),
(119, NULL, 1, '90', '', NULL, 'Consequatur consequa', 1, NULL, 2, NULL, NULL, NULL, 'uioj99', NULL, '2024-07-26', '2024-07-23 17:16:23', '2024-07-23 17:16:23');

-- --------------------------------------------------------

--
-- Table structure for table `finance_transfers`
--

CREATE TABLE `finance_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `to_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` varchar(30) NOT NULL,
  `reference` varchar(191) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finance_transfers`
--

INSERT INTO `finance_transfers` (`id`, `company_id`, `from_account_id`, `to_account_id`, `amount`, `reference`, `description`, `payment_method_id`, `date`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 2, '2000', '6736', NULL, 1, '2021-03-30', '2020-07-29 05:36:41', '2020-07-29 05:36:41');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `site_title` varchar(191) NOT NULL,
  `site_logo` varchar(191) DEFAULT NULL,
  `time_zone` varchar(191) DEFAULT NULL,
  `currency` varchar(191) DEFAULT NULL,
  `currency_format` varchar(191) DEFAULT NULL,
  `default_payment_bank` varchar(191) DEFAULT NULL,
  `date_format` varchar(191) DEFAULT NULL,
  `theme` varchar(191) DEFAULT NULL,
  `footer` varchar(191) DEFAULT NULL,
  `footer_link` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_title`, `site_logo`, `time_zone`, `currency`, `currency_format`, `default_payment_bank`, `date_format`, `theme`, `footer`, `footer_link`, `created_at`, `updated_at`) VALUES
(1, 'Base Practice Support', 'logo.png', 'Asia/Karachi', 'PKR', 'prefix', '1', 'd-m-Y', 'default.css', 'AVANTCORE TECHNOLOGIES', 'https://avantcoretech.com', '2020-07-25 19:00:00', '2025-01-28 08:08:52');

-- --------------------------------------------------------

--
-- Table structure for table `goal_trackings`
--

CREATE TABLE `goal_trackings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `goal_type_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(191) NOT NULL,
  `target_achievement` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` varchar(191) NOT NULL,
  `end_date` varchar(191) NOT NULL,
  `progress` int(11) NOT NULL,
  `status` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `goal_trackings`
--

INSERT INTO `goal_trackings` (`id`, `company_id`, `goal_type_id`, `subject`, `target_achievement`, `description`, `start_date`, `end_date`, `progress`, `status`, `created_at`, `updated_at`) VALUES
(5, 9, 3, '503 Error on Newly Created Subdomain', 'Bugs Fixing - Code level', '', '01-02-2025', '21-02-2025', 100, 'In Progress', '2025-01-28 08:06:40', '2025-01-28 08:07:50');

-- --------------------------------------------------------

--
-- Table structure for table `goal_types`
--

CREATE TABLE `goal_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `goal_type` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `goal_types`
--

INSERT INTO `goal_types` (`id`, `goal_type`, `created_at`, `updated_at`) VALUES
(1, 'Event Goal', '2021-01-17 04:14:44', '2021-01-17 04:14:44'),
(2, 'Success Goal', '2021-01-17 04:14:58', '2021-01-17 04:14:58'),
(3, 'Complete', '2021-01-17 04:40:18', '2021-01-17 04:40:18');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_name` varchar(191) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_publish` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `event_name`, `description`, `company_id`, `department_id`, `start_date`, `end_date`, `is_publish`, `created_at`, `updated_at`) VALUES
(6, 'Indepence Day - 14 AUG', 'Indepence Day - 14 AUG', 9, NULL, '2025-08-14', '2025-08-14', 2, '2025-01-28 08:01:01', '2025-01-28 08:01:01'),
(7, 'Kashmir Day - 5 May', 'Kashmir Day - 5 May', 9, NULL, '2025-05-05', '2025-05-05', 2, '2025-01-28 08:02:17', '2025-01-28 08:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `indicators`
--

CREATE TABLE `indicators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `designation_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `customer_experience` varchar(191) NOT NULL,
  `marketing` varchar(191) NOT NULL,
  `administrator` varchar(191) NOT NULL,
  `professionalism` varchar(191) NOT NULL,
  `integrity` varchar(191) NOT NULL,
  `attendance` varchar(191) NOT NULL,
  `added_by` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(191) NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_date` date NOT NULL,
  `invoice_due_date` date NOT NULL,
  `sub_total` double NOT NULL,
  `discount_type` tinyint(4) DEFAULT NULL,
  `discount_figure` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_discount` double NOT NULL,
  `grand_total` double NOT NULL,
  `invoice_note` mediumtext DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_name` varchar(191) NOT NULL,
  `item_tax_type` int(11) NOT NULL DEFAULT 0,
  `item_tax_rate` decimal(5,2) NOT NULL,
  `item_qty` int(11) NOT NULL DEFAULT 0,
  `item_unit_price` decimal(10,2) NOT NULL,
  `item_sub_total` double NOT NULL,
  `sub_total` double NOT NULL,
  `discount_type` tinyint(4) DEFAULT NULL,
  `discount_figure` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_discount` double NOT NULL,
  `grand_total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ip_settings`
--

CREATE TABLE `ip_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `ip_address` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ip_settings`
--

INSERT INTO `ip_settings` (`id`, `name`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 'FNF', '103.120.140.1', '2021-03-28 14:34:42', '2021-03-28 16:57:27'),
(14, 'Lion-Coders', '127.54.03.1', '2021-03-28 16:58:02', '2021-03-28 16:58:02'),
(15, 'Local', '127.0.0.2', '2021-03-28 17:26:13', '2021-03-29 05:39:40'),
(16, 'XYZ', '103.161.152.57', '2021-07-05 03:36:35', '2021-08-01 13:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `job_candidates`
--

CREATE TABLE `job_candidates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `address` text DEFAULT NULL,
  `cover_letter` longtext NOT NULL,
  `fb_id` varchar(191) DEFAULT NULL,
  `linkedin_id` varchar(191) DEFAULT NULL,
  `cv` varchar(191) NOT NULL,
  `status` varchar(191) NOT NULL,
  `remarks` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_candidates`
--

INSERT INTO `job_candidates` (`id`, `job_id`, `full_name`, `email`, `phone`, `address`, `cover_letter`, `fb_id`, `linkedin_id`, `cv`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(3, 1, 'Fahim Chowdhury', 'irfanchowdhury434@gmail.com', '2212221212', 'Dewanhat, Chittagong.', 'Dear Hiring Manager,\r\n\r\nI would like to apply for the position of Software Developer (PHP-Laravel) as advertised on Facebook. I have extensive experience in web development specializing in PHP-Laravel, JavaScript, jQuery, Ajax, API, little experience with React and others that perfectly fit the advertised job requirements. \r\n\r\nI received my B.Sc. in Computer Science &amp; Engineering from International Islamic University Chittagong and have more than 2.5 years in software development as Junior Software Engineer at Lion Coders , Chittagong. \r\n\r\nPlease find my resume attached. Feel free to contact me if you have any further questions you would like to discuss. Thank you for taking the time to consider my application. I look forward to hearing from you.\r\n\r\n\r\nThanks &amp; Regards,\r\n\r\nMd Irfan Chowdhury\r\n.', '', '', 'FahimChowdhury_1700042575.jpg', 'Called For Interview', '', '2023-11-15 09:32:55', '2023-11-15 17:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `job_categories`
--

CREATE TABLE `job_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_category` mediumtext NOT NULL,
  `url` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_categories`
--

INSERT INTO `job_categories` (`id`, `job_category`, `url`) VALUES
(2, 'PHP', 'xdBCMHJABdhRlMqXkA0G'),
(3, 'Seo', 'YoHOIZmN5jdNLG6gMp3x'),
(5, 'Analyst', 'gDCJcrUn9M7tt5xVK3wh');

-- --------------------------------------------------------

--
-- Table structure for table `job_experiences`
--

CREATE TABLE `job_experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_experiences`
--

INSERT INTO `job_experiences` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Fresher', '2024-07-28 08:39:14', '2024-07-28 08:39:14'),
(2, '1 Year', '2024-07-28 08:39:23', '2024-07-28 08:39:23'),
(4, '2 Years', '2024-07-28 08:44:55', '2024-07-28 08:44:55'),
(5, '3 Years', '2024-07-28 09:08:19', '2024-07-28 09:08:19'),
(6, '4 Years', '2024-07-28 09:08:49', '2024-07-28 09:08:49'),
(7, '5 Years', '2024-07-28 09:08:52', '2024-07-28 09:08:52'),
(8, '6 Years', '2024-07-28 09:08:57', '2024-07-28 09:08:57'),
(9, '7 Years', '2024-07-28 09:09:07', '2024-07-28 09:09:07'),
(10, '8 Years', '2024-07-28 09:09:11', '2024-07-28 09:09:11'),
(11, '9 Years', '2024-07-28 09:09:25', '2024-07-28 09:09:25'),
(12, '10 Years', '2024-07-28 09:09:30', '2024-07-28 09:09:30');

-- --------------------------------------------------------

--
-- Table structure for table `job_interviews`
--

CREATE TABLE `job_interviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `interview_place` varchar(191) NOT NULL,
  `interview_date` date NOT NULL,
  `interview_time` time NOT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_interviews`
--

INSERT INTO `job_interviews` (`id`, `job_id`, `added_by`, `interview_place`, `interview_date`, `interview_time`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Dewanhat, Chittagong', '2023-11-17', '03:00:00', '&lt;p&gt;&lt;span style=&quot;background-color: #ffffff; color: #718096; font-family: -apple-system, BlinkMacSystemFont, &#039;Segoe UI&#039;, Roboto, Helvetica, Arial, sans-serif, &#039;Apple Color Emoji&#039;, &#039;Segoe UI Emoji&#039;, &#039;Segoe UI Symbol&#039;; font-size: 16px;&quot;&gt;Interview for caregiver position kghomehealth&lt;/span&gt;&lt;/p&gt;', '2023-11-15 09:40:26', '2023-11-15 09:40:26'),
(2, 1, 1, 'dhaka bangladesh', '2023-11-16', '03:00:00', '&lt;p&gt;&lt;span style=&quot;background-color: #ffffff; color: #718096; font-family: -apple-system, BlinkMacSystemFont, &#039;Segoe UI&#039;, Roboto, Helvetica, Arial, sans-serif, &#039;Apple Color Emoji&#039;, &#039;Segoe UI Emoji&#039;, &#039;Segoe UI Symbol&#039;; font-size: 16px;&quot;&gt;Interview for caregiver position kghomehealth&lt;/span&gt;&lt;/p&gt;', '2023-11-15 17:14:24', '2023-11-15 17:14:24'),
(3, 1, 1, 'CTG, BD', '2023-11-18', '03:00:00', '&lt;p&gt;Interview for caregiver position kghomehealth&lt;/p&gt;', '2023-11-15 17:24:36', '2023-11-15 17:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `job_posts`
--

CREATE TABLE `job_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `job_category_id` bigint(20) UNSIGNED NOT NULL,
  `job_title` varchar(191) NOT NULL,
  `job_type` varchar(191) NOT NULL,
  `no_of_vacancy` int(11) NOT NULL,
  `job_url` varchar(191) NOT NULL,
  `gender` varchar(30) NOT NULL,
  `job_experience_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `short_description` mediumtext NOT NULL,
  `long_description` longtext NOT NULL,
  `closing_date` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `is_featured` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_posts`
--

INSERT INTO `job_posts` (`id`, `company_id`, `job_category_id`, `job_title`, `job_type`, `no_of_vacancy`, `job_url`, `gender`, `job_experience_id`, `short_description`, `long_description`, `closing_date`, `status`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Laravel Developer', 'full_time', 2, 'qPnZoMWx83Qb0YnTVl5F', 'No Preference', 1, 'Lion-Coders is looking for Intermediate level Software Developers (3) for its Laravel based software developments. The primary role of these developers will be to develop/debug new desktop/xamarin/web applications for its overseas clients.', '&lt;p&gt;&amp;bull; Should have experience in working on framework such as Laravel,&lt;br /&gt;Symphony etc&lt;br /&gt;&amp;bull; Excellent working knowledge of Web application development&lt;br /&gt;&amp;bull; Advance coding Skills in PHP, HTML, CSS, JavaScript, and scripting&lt;br /&gt;languages desirable&lt;br /&gt;&amp;bull; Excellent working knowledge of MySQL database&lt;br /&gt;&amp;bull; Good understanding of database performance tuning and sql queries&lt;br /&gt;&amp;bull; Experience working with a PHP framework such as CodeIgniter/Laravel&lt;br /&gt;&amp;bull; Experience in both Front End / Back End Developer.&lt;br /&gt;&amp;bull; Good Knowledge and understanding of CRM, CMS, SHOPPING-CART,&lt;br /&gt;PAYMENT GATEWAY &amp;amp; other API INTEGRATION&lt;/p&gt;', '2021-03-06', 1, 1, '2021-02-22 00:00:00', '2021-03-24 01:46:04'),
(2, 1, 5, 'Business Analyst', 'part_time', 3, 'OhBIUt70qzUGfzfWifEI', 'Male', 1, 'Business analysts work with organizations to help them improve their processes and systems. They conduct research and analysis in order to come up with solutions to business problems and help to introduce these systems to businesses and their clients.', '&lt;p&gt;Important skills needed :&lt;/p&gt;\r\n&lt;ul&gt;\r\n&lt;li&gt;Oral and written communication skills&lt;/li&gt;\r\n&lt;li&gt;nterpersonal and consultative skills&lt;/li&gt;\r\n&lt;li&gt;Facilitation skills&lt;/li&gt;\r\n&lt;li&gt;Analytical thinking and problem solving&lt;/li&gt;\r\n&lt;li&gt;Being detail-oriented and capable of delivering a high level of accuracy&lt;/li&gt;\r\n&lt;li&gt;Organizational skills&lt;/li&gt;\r\n&lt;/ul&gt;', '2021-03-03', 1, 1, '2021-02-23 00:00:00', '2021-03-24 01:46:46'),
(4, 1, 2, 'dfdfds', 'full_time', 1, 'XTWZGx3nl9LVvaIMHuN8', 'Male', 1, 'dczcz', '&lt;p&gt;xczxczczx&lt;/p&gt;', '2023-08-03', 1, 1, '2023-08-01 20:22:01', '2023-08-01 20:22:01'),
(6, 1, 2, 'Ipsum eveniet unde', 'internship', 8, 'tpH2FtqLT75Nac0HmWdD', 'Female', 4, 'Dolor sequi velit v', '&lt;p&gt;Vel in commodi excep.&lt;/p&gt;', '2024-07-28', 1, 1, '2024-07-28 09:39:17', '2024-07-28 09:41:47');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `language` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `language`, `created_at`, `updated_at`) VALUES
(1, NULL, 'English', '2023-05-06 05:39:11', '2023-05-06 05:39:11');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_days` int(11) NOT NULL,
  `leave_reason` mediumtext DEFAULT NULL,
  `remarks` varchar(191) DEFAULT NULL,
  `status` varchar(40) NOT NULL,
  `is_notify` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `leave_type_id`, `company_id`, `department_id`, `employee_id`, `start_date`, `end_date`, `total_days`, `leave_reason`, `remarks`, `status`, `is_notify`, `created_at`, `updated_at`) VALUES
(26, 1, 1, 1, 9, '2023-01-23', '2023-01-24', 2, '', '', 'approved', 1, '2023-01-22 13:05:33', '2023-01-22 13:05:33'),
(39, 1, 1, 1, 9, '2023-04-10', '2023-04-13', 4, '', '', 'approved', NULL, '2023-04-02 06:05:29', '2023-04-11 10:12:37'),
(40, 1, 1, 1, 9, '2023-04-03', '2023-04-03', 1, '', '', 'approved', NULL, '2023-04-02 07:14:06', '2023-04-02 07:14:06'),
(41, 1, 1, 1, 9, '2023-04-06', '2023-04-06', 1, '', '', 'approved', NULL, '2023-04-02 07:15:09', '2023-04-02 07:15:09'),
(42, 1, 1, 1, 9, '2023-04-07', '2023-04-07', 1, '', '', 'approved', NULL, '2023-04-02 07:16:10', '2023-04-02 07:16:10'),
(43, 1, 1, 1, 9, '2023-04-05', '2023-04-05', 1, '', '', 'approved', NULL, '2023-04-02 08:21:16', '2023-04-02 08:22:44'),
(44, 1, 1, 1, 9, '2023-04-03', '2023-04-03', 1, '', '', 'approved', NULL, '2023-04-02 09:04:09', '2023-04-02 09:04:09'),
(45, 1, 1, 1, 9, '2023-04-05', '2023-04-06', 2, '', '', 'rejected', NULL, '2023-04-02 09:07:25', '2023-04-03 09:25:04'),
(46, 1, 1, 1, 9, '2023-04-08', '2023-04-14', 7, '', '', 'approved', NULL, '2023-04-11 10:56:35', '2023-04-12 08:47:01'),
(47, 1, 1, 1, 9, '2023-04-10', '2023-04-12', 3, '', '', 'pending', NULL, '2023-04-11 11:01:36', '2023-04-12 09:19:57'),
(48, 1, 1, 1, 9, '2023-04-17', '2023-04-18', 2, '', '', 'approved', NULL, '2023-04-12 09:33:19', '2023-04-12 09:33:48'),
(49, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:12:55', '2023-12-10 05:12:55'),
(50, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:12:59', '2023-12-10 05:12:59'),
(51, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:12:59', '2023-12-10 05:12:59'),
(52, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:00', '2023-12-10 05:13:00'),
(53, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:00', '2023-12-10 05:13:00'),
(54, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:00', '2023-12-10 05:13:00'),
(55, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:00', '2023-12-10 05:13:00'),
(56, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:00', '2023-12-10 05:13:00'),
(57, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:01', '2023-12-10 05:13:01'),
(58, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:02', '2023-12-10 05:13:02'),
(59, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:02', '2023-12-10 05:13:02'),
(60, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:03', '2023-12-10 05:13:03'),
(61, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:03', '2023-12-10 05:13:03'),
(62, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:03', '2023-12-10 05:13:03'),
(63, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:10', '2023-12-10 05:13:10'),
(64, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:10', '2023-12-10 05:13:10'),
(65, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:10', '2023-12-10 05:13:10'),
(66, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:11', '2023-12-10 05:13:11'),
(67, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:11', '2023-12-10 05:13:11'),
(68, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:11', '2023-12-10 05:13:11'),
(69, 1, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:13:11', '2023-12-10 05:13:11'),
(70, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:39:20', '2023-12-10 05:39:20'),
(71, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:43:15', '2023-12-10 05:43:15'),
(72, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:44:04', '2023-12-10 05:44:04'),
(73, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:44:35', '2023-12-10 05:44:35'),
(74, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:44:57', '2023-12-10 05:44:57'),
(75, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:45:48', '2023-12-10 05:45:48'),
(76, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:47:31', '2023-12-10 05:47:31'),
(77, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:48:20', '2023-12-10 05:48:20'),
(78, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 05:49:41', '2023-12-10 05:49:41'),
(79, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 06:13:20', '2023-12-10 06:13:20'),
(80, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 06:13:46', '2023-12-10 06:13:46'),
(81, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 06:16:45', '2023-12-10 06:16:45'),
(82, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 06:16:48', '2023-12-10 06:16:48'),
(83, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 06:17:21', '2023-12-10 06:17:21'),
(84, 2, 1, 1, 9, '2023-12-10', '2023-12-11', 2, 'test', NULL, 'pending', NULL, '2023-12-10 06:19:32', '2023-12-10 06:19:32'),
(85, 2, 1, 1, 9, '2023-12-10', '2023-12-13', 4, 'gggg', NULL, 'pending', NULL, '2023-12-10 06:21:16', '2023-12-10 06:21:16'),
(86, 2, 1, 1, 9, '2023-12-10', '2023-12-13', 4, 'gggg', NULL, 'pending', NULL, '2023-12-10 06:21:35', '2023-12-10 06:21:35'),
(87, 2, 1, 1, 9, '2023-12-10', '2023-12-13', 4, 'gggg', NULL, 'pending', NULL, '2023-12-10 06:27:17', '2023-12-10 06:27:17'),
(88, 2, 1, 1, 9, '2023-12-10', '2023-12-13', 4, 'gggg', NULL, 'pending', NULL, '2023-12-10 06:28:53', '2023-12-10 06:28:53'),
(89, 1, 9, 1, 157, '2025-01-28', '2025-01-31', 4, 'Sick leaves - Requests', '', 'approved', NULL, '2025-01-28 13:24:04', '2025-01-28 13:31:32'),
(90, 1, 9, 1, 157, '2025-01-28', '2025-02-01', 5, '', NULL, 'pending', NULL, '2025-01-28 13:39:17', '2025-01-28 13:39:17'),
(91, 1, 9, 1, 157, '2025-02-01', '2025-02-04', 4, '', NULL, 'pending', NULL, '2025-01-28 13:40:06', '2025-01-28 13:40:06'),
(92, 1, 9, 26, 186, '2025-01-29', '2025-01-30', 2, '', '', 'approved', 1, '2025-01-28 13:48:03', '2025-01-28 13:50:21'),
(93, 2, 9, 26, 165, '2025-01-28', '2025-01-31', 4, 'adjustment', NULL, 'pending', NULL, '2025-01-28 14:00:58', '2025-01-28 14:00:58'),
(94, 2, 9, 5, 174, '2025-01-31', '2025-02-01', 2, '', '', 'approved', 1, '2025-01-29 06:04:52', '2025-01-29 07:32:39'),
(95, 1, 9, 5, 162, '2025-01-30', '2025-01-30', 1, '', '', 'approved', NULL, '2025-01-29 07:05:31', '2025-01-29 07:31:11'),
(96, 1, 9, 5, 162, '2025-01-30', '2025-02-01', 3, '', NULL, 'pending', NULL, '2025-01-29 07:34:36', '2025-01-29 07:34:36'),
(97, 2, 9, 5, 162, '2025-01-30', '2025-01-31', 2, '', NULL, 'pending', NULL, '2025-01-29 07:37:07', '2025-01-29 07:37:07'),
(98, 2, 9, 5, 162, '2025-02-01', '2025-02-02', 2, '', NULL, 'pending', NULL, '2025-01-29 07:52:35', '2025-01-29 07:52:35'),
(99, 2, 9, 5, 162, '2025-01-30', '2025-01-30', 1, '', NULL, 'pending', NULL, '2025-01-29 07:58:00', '2025-01-29 07:58:00'),
(100, 2, 9, 5, 174, '2025-01-30', '2025-01-31', 2, '', NULL, 'pending', NULL, '2025-01-29 07:59:01', '2025-01-29 07:59:01'),
(101, 2, 9, 5, 162, '2025-01-30', '2025-01-31', 2, '', '', 'approved', NULL, '2025-01-29 08:06:02', '2025-01-29 08:10:21'),
(102, 2, 9, 5, 174, '2025-01-30', '2025-01-31', 2, '', '', 'rejected', 1, '2025-01-29 08:11:12', '2025-01-29 08:17:32'),
(103, 1, 9, 1, 157, '2025-01-30', '2025-02-01', 3, '', NULL, 'pending', NULL, '2025-01-29 08:11:46', '2025-01-29 08:11:46'),
(104, 1, 9, 5, 174, '2025-01-29', '2025-02-02', 5, '', '', 'approved', NULL, '2025-01-29 08:15:50', '2025-01-29 08:16:21'),
(105, 1, 9, 5, 174, '2025-01-30', '2025-01-30', 1, '', '', 'approved', NULL, '2025-01-29 08:19:09', '2025-01-29 08:36:30'),
(106, 1, 9, 5, 174, '2025-01-30', '2025-02-07', 9, '', '', 'approved', NULL, '2025-01-29 08:37:09', '2025-01-29 08:37:53'),
(107, 1, 9, 5, 174, '2025-01-29', '2025-02-01', 4, '', '', 'approved', NULL, '2025-01-29 08:42:18', '2025-01-29 08:43:29'),
(108, 1, 9, 5, 174, '2025-02-05', '2025-02-05', 1, '', '', 'approved', NULL, '2025-01-29 08:44:58', '2025-01-29 08:46:26');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `allocated_day` int(11) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `leave_type`, `allocated_day`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 'Sick Leave', 5, NULL, '2020-07-26 20:18:04', '2025-01-28 07:48:33'),
(2, 'Annual Leave', 10, NULL, '2020-07-26 20:18:39', '2025-01-28 07:48:49');

-- --------------------------------------------------------

--
-- Table structure for table `loan_types`
--

CREATE TABLE `loan_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_types`
--

INSERT INTO `loan_types` (`id`, `type_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Social Security System Loan', '2024-07-23 03:41:22', '2024-07-23 03:41:22', NULL),
(3, 'Home Development Mutual Fund Loan', '2024-07-23 03:43:09', '2025-01-28 07:52:34', '2025-01-28 07:52:34'),
(4, 'Other Loan', '2024-07-23 03:45:02', '2025-01-28 07:52:46', '2025-01-28 07:52:46');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_name` varchar(191) NOT NULL,
  `location_head` bigint(20) UNSIGNED DEFAULT NULL,
  `address1` varchar(191) DEFAULT NULL,
  `address2` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `country` int(10) UNSIGNED DEFAULT NULL,
  `zip` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location_name`, `location_head`, `address1`, `address2`, `city`, `state`, `country`, `zip`, `created_at`, `updated_at`) VALUES
(1, 'Islamabad', NULL, 'Plot 146, RMT Plaza, Business Square, Gulberg Greens, Islamabad, Pakistan', '', 'Islamabad', 'ICT', 163, 44000, '2020-07-26 18:12:19', '2025-01-27 14:20:07');

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `meeting_title` varchar(191) NOT NULL,
  `meeting_note` mediumtext NOT NULL,
  `meeting_date` date NOT NULL,
  `meeting_time` varchar(191) NOT NULL,
  `status` varchar(30) NOT NULL,
  `is_notify` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `company_id`, `meeting_title`, `meeting_note`, `meeting_date`, `meeting_time`, `status`, `is_notify`, `created_at`, `updated_at`) VALUES
(6, 9, 'Test Meeting', 'Test Meeting', '2025-01-30', '05:30PM', 'pending', 1, '2025-01-28 08:21:02', '2025-01-28 08:21:02');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(106, '2023_05_06_053210_create_countries_table', 1),
(107, '2023_05_06_053211_create_locations_table', 1),
(108, '2023_05_06_053212_create_companies_table', 1),
(109, '2023_05_06_053213_create_departments_table', 1),
(110, '2023_05_06_053214_create_designations_table', 1),
(111, '2023_05_06_053215_create_roles_table', 1),
(112, '2023_05_06_053217_create_users_table', 1),
(113, '2023_05_06_053218_create_office_shifts_table', 1),
(114, '2023_05_06_053219_create_statuses_table', 1),
(115, '2023_05_06_053220_create_employees_table', 1),
(116, '2023_05_06_053221_create_announcements_table', 1),
(117, '2023_05_06_053222_create_appraisals_table', 1),
(118, '2023_05_06_053223_create_asset_categories_table', 1),
(119, '2023_05_06_053224_create_assets_table', 1),
(120, '2023_05_06_053225_create_attendances_table', 1),
(121, '2023_05_06_053226_create_award_types_table', 1),
(122, '2023_05_06_053227_create_awards_table', 1),
(123, '2023_05_06_053228_create_c_m_s_table', 1),
(124, '2023_05_06_053229_create_calendarables_table', 1),
(125, '2023_05_06_053231_create_clients_table', 1),
(126, '2023_05_06_053232_create_complaints_table', 1),
(127, '2023_05_06_053233_create_document_types_table', 1),
(128, '2023_05_06_053234_create_employee_bank_accounts_table', 1),
(129, '2023_05_06_053235_create_employee_contacts_table', 1),
(130, '2023_05_06_053236_create_employee_documents_table', 1),
(131, '2023_05_06_053237_create_employee_immigrations_table', 1),
(132, '2023_05_06_053238_create_employee_leave_type_details_table', 1),
(133, '2023_05_06_053239_create_job_categories_table', 1),
(134, '2023_05_06_053240_create_job_posts_table', 1),
(135, '2023_05_06_053241_create_job_interviews_table', 1),
(136, '2023_05_06_053242_create_employee_interview_table', 1),
(137, '2023_05_06_053243_create_meetings_table', 1),
(138, '2023_05_06_053244_create_employee_meeting_table', 1),
(139, '2023_05_06_053245_create_projects_table', 1),
(140, '2023_05_06_053246_create_employee_project_table', 1),
(141, '2023_05_06_053247_create_qualification_languages_table', 1),
(142, '2023_05_06_053248_create_qualification_skills_table', 1),
(143, '2023_05_06_053249_create_qualification_education_levels_table', 1),
(144, '2023_05_06_053250_create_employee_qualificaitons_table', 1),
(145, '2023_05_06_053251_create_support_tickets_table', 1),
(146, '2023_05_06_053252_create_employee_support_ticket_table', 1),
(147, '2023_05_06_053253_create_tasks_table', 1),
(148, '2023_05_06_053254_create_employee_task_table', 1),
(149, '2023_05_06_053255_create_trainers_table', 1),
(150, '2023_05_06_053256_create_training_types_table', 1),
(151, '2023_05_06_053257_create_training_lists_table', 1),
(152, '2023_05_06_053258_create_employee_training_list_table', 1),
(153, '2023_05_06_053259_create_employee_work_experience_table', 1),
(154, '2023_05_06_053260_create_events_table', 1),
(155, '2023_05_06_053261_create_expense_types_table', 1),
(156, '2023_05_06_053262_create_failed_jobs_table', 1),
(157, '2023_05_06_053263_create_file_manager_settings_table', 1),
(158, '2023_05_06_053265_create_file_managers_table', 1),
(159, '2023_05_06_053265_create_finance_bank_cashes_table', 1),
(160, '2023_05_06_053266_create_finance_payers_table', 1),
(161, '2023_05_06_053267_create_payment_methods_table', 1),
(162, '2023_05_06_053268_create_finance_deposits_table', 1),
(163, '2023_05_06_053269_create_finance_payees_table', 1),
(164, '2023_05_06_053270_create_finance_expenses_table', 1),
(165, '2023_05_06_053271_create_finance_transactions_table', 1),
(166, '2023_05_06_053272_create_finance_transfers_table', 1),
(167, '2023_05_06_053273_create_general_settings_table', 1),
(168, '2023_05_06_053274_create_goal_types_table', 1),
(169, '2023_05_06_053275_create_goal_trackings_table', 1),
(170, '2023_05_06_053276_create_holidays_table', 1),
(171, '2023_05_06_053277_create_indicators_table', 1),
(172, '2023_05_06_053278_create_invoices_table', 1),
(173, '2023_05_06_053279_create_invoice_items_table', 1),
(174, '2023_05_06_053280_create_ip_settings_table', 1),
(175, '2023_05_06_053281_create_job_candidates_table', 1),
(176, '2023_05_06_053282_create_leave_types_table', 1),
(177, '2023_05_06_053283_create_leaves_table', 1),
(178, '2023_05_06_053284_create_permissions_table', 1),
(179, '2023_05_06_053285_create_model_has_permissions_table', 1),
(180, '2023_05_06_053287_create_model_has_roles_table', 1),
(181, '2023_05_06_053288_create_notifications_table', 1),
(182, '2023_05_06_053289_create_official_documents_table', 1),
(183, '2023_05_06_053290_create_password_resets_table', 1),
(184, '2023_05_06_053291_create_payslips_table', 1),
(185, '2023_05_06_053292_create_policies_table', 1),
(186, '2023_05_06_053293_create_project_bugs_table', 1),
(187, '2023_05_06_053294_create_project_discussions_table', 1),
(188, '2023_05_06_053295_create_project_files_table', 1),
(189, '2023_05_06_053296_create_promotions_table', 1),
(190, '2023_05_06_053297_create_resignations_table', 1),
(191, '2023_05_06_053298_create_role_has_permissions_table', 1),
(192, '2023_05_06_053299_create_salary_allowances_table', 1),
(193, '2023_05_06_053300_create_salary_basics_table', 1),
(194, '2023_05_06_053301_create_salary_commissions_table', 1),
(195, '2023_05_06_053302_create_salary_deductions_table', 1),
(196, '2023_05_06_053303_create_salary_loans_table', 1),
(197, '2023_05_06_053304_create_salary_other_payments_table', 1),
(198, '2023_05_06_053305_create_salary_overtimes_table', 1),
(199, '2023_05_06_053306_create_task_discussions_table', 1),
(200, '2023_05_06_053307_create_task_files_table', 1),
(201, '2023_05_06_053308_create_tax_types_table', 1),
(202, '2023_05_06_053309_create_termination_types_table', 1),
(203, '2023_05_06_053310_create_terminations_table', 1),
(204, '2023_05_06_053311_create_ticket_comments_table', 1),
(205, '2023_05_06_053312_create_transfers_table', 1),
(206, '2023_05_06_053313_create_travel_types_table', 1),
(207, '2023_05_06_053314_create_travels_table', 1),
(208, '2023_05_06_053315_create_warnings_type_table', 1),
(209, '2023_05_06_053316_create_warnings_table', 1),
(210, '2023_05_06_053317_create_candidate_interview_table', 1),
(211, '2023_05_06_151650_delete_column_from_document_types_table', 2),
(212, '2023_05_06_153653_update_foreign_key_to_employees_table', 2),
(213, '2023_05_07_163304_update_foreign_key_to_projects_table', 2),
(214, '2023_05_08_004033_update_foreign_key_to_support_tickets_table', 2),
(215, '2023_05_08_094247_update_foreign_key_to_tasks_table', 2),
(216, '2023_05_08_101326_add_foreign_key_to_training_types_table', 2),
(217, '2023_05_08_152355_update_foreign_key_to_file_managers_table', 2),
(218, '2023_05_08_165246_update_foreign_key_to_payment_methods_table', 2),
(219, '2023_05_08_165419_update_foreign_key_to_finance_deposits_table', 2),
(220, '2023_05_09_112302_update_foreign_key_to_finance_expenses_table', 2),
(221, '2023_05_09_115226_update_foreign_key_to_finance_transactions_table', 2),
(222, '2023_05_09_122727_update_foreign_key_to_finance_transfers_table', 2),
(223, '2023_05_09_130054_add_foreign_key_to_goal_trackings_table', 2),
(224, '2023_05_09_134538_update_foreign_key_to_holidays_table', 2),
(225, '2023_05_09_134626_add_foreign_key_to_indicators_table', 2),
(226, '2023_05_09_134702_update_foreign_key_to_invoices_table', 2),
(227, '2023_05_09_134831_update_foreign_key_to_invoice_items_table', 2),
(228, '2023_05_09_162641_update_foreign_key_to_leaves_table', 2),
(229, '2023_05_09_181324_update_foreign_key_to_official_documents_table', 2),
(230, '2023_05_09_190434_update_foreign_key_to_policies_table', 2),
(231, '2023_05_09_193007_update_foreign_key_to_terminations_table', 2),
(232, '2023_05_09_195431_update_foreign_key_to_travel_types_table', 2),
(233, '2023_05_09_195925_update_foreign_key_to_travels_table', 2),
(234, '2023_05_09_200229_update_foreign_key_to_warnings_table', 2),
(235, '2023_08_02_113953_delete_company_id_column_to_training_types_table', 2),
(236, '2024_04_15_143831_add_column_to_users_table', 3),
(238, '2024_06_09_114933_create_company_types_table', 4),
(239, '2018_08_08_100000_create_telescope_entries_table', 5),
(240, '2024_05_13_123951_update_column_type_to_invoice_items_table', 6),
(243, '2024_07_22_184915_add_company_type_id_column_to_companies_table', 7),
(244, '2024_07_22_201241_create_relation_types_table', 8),
(245, '2024_07_22_230352_add_relation_type_id_column_to_employee_contacts_table', 9),
(246, '2024_07_23_091947_create_loan_types_table', 10),
(248, '2024_07_22_230356_add_loan_type_id_column_to_salary_loans_table', 11),
(249, '2024_07_23_113537_create_deduction_types_table', 12),
(250, '2024_07_22_230367_add_deduction_type_id_column_to_salary_loans_table', 13),
(251, '2024_07_23_201134_create_deposit_categories_table', 14),
(252, '2024_07_22_230368_add_deposit_category_id_column_to_finance_deposits_table', 15),
(255, '2024_07_22_230370_add_job_experience_id_column_to_job_posts_table', 16),
(256, '2024_07_28_140520_create_job_experiences_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 8),
(1, 'App\\Models\\User', 28),
(1, 'App\\Models\\User', 29),
(1, 'App\\Models\\User', 30),
(1, 'App\\Models\\User', 31),
(1, 'App\\Models\\User', 36),
(1, 'App\\Models\\User', 40),
(1, 'App\\Models\\User', 44),
(1, 'App\\Models\\User', 46),
(1, 'App\\Models\\User', 47),
(1, 'App\\Models\\User', 48),
(1, 'App\\Models\\User', 51),
(1, 'App\\Models\\User', 60),
(1, 'App\\Models\\User', 61),
(1, 'App\\Models\\User', 62),
(1, 'App\\Models\\User', 66),
(1, 'App\\Models\\User', 67),
(1, 'App\\Models\\User', 68),
(1, 'App\\Models\\User', 226),
(1, 'App\\Models\\User', 253),
(2, 'App\\Models\\User', 12),
(2, 'App\\Models\\User', 13),
(2, 'App\\Models\\User', 14),
(2, 'App\\Models\\User', 15),
(2, 'App\\Models\\User', 24),
(2, 'App\\Models\\User', 25),
(2, 'App\\Models\\User', 27),
(2, 'App\\Models\\User', 32),
(2, 'App\\Models\\User', 33),
(2, 'App\\Models\\User', 34),
(2, 'App\\Models\\User', 37),
(2, 'App\\Models\\User', 38),
(2, 'App\\Models\\User', 41),
(2, 'App\\Models\\User', 42),
(2, 'App\\Models\\User', 43),
(2, 'App\\Models\\User', 49),
(2, 'App\\Models\\User', 50),
(2, 'App\\Models\\User', 54),
(2, 'App\\Models\\User', 56),
(2, 'App\\Models\\User', 57),
(2, 'App\\Models\\User', 58),
(2, 'App\\Models\\User', 59),
(2, 'App\\Models\\User', 158),
(2, 'App\\Models\\User', 160),
(2, 'App\\Models\\User', 161),
(2, 'App\\Models\\User', 162),
(2, 'App\\Models\\User', 163),
(2, 'App\\Models\\User', 166),
(2, 'App\\Models\\User', 167),
(2, 'App\\Models\\User', 168),
(2, 'App\\Models\\User', 169),
(2, 'App\\Models\\User', 170),
(2, 'App\\Models\\User', 171),
(2, 'App\\Models\\User', 172),
(2, 'App\\Models\\User', 173),
(2, 'App\\Models\\User', 176),
(2, 'App\\Models\\User', 177),
(2, 'App\\Models\\User', 178),
(2, 'App\\Models\\User', 179),
(2, 'App\\Models\\User', 180),
(2, 'App\\Models\\User', 181),
(2, 'App\\Models\\User', 182),
(2, 'App\\Models\\User', 183),
(2, 'App\\Models\\User', 184),
(2, 'App\\Models\\User', 185),
(2, 'App\\Models\\User', 186),
(2, 'App\\Models\\User', 187),
(2, 'App\\Models\\User', 188),
(2, 'App\\Models\\User', 189),
(2, 'App\\Models\\User', 190),
(2, 'App\\Models\\User', 191),
(2, 'App\\Models\\User', 192),
(2, 'App\\Models\\User', 193),
(2, 'App\\Models\\User', 194),
(2, 'App\\Models\\User', 195),
(2, 'App\\Models\\User', 196),
(2, 'App\\Models\\User', 197),
(2, 'App\\Models\\User', 198),
(2, 'App\\Models\\User', 199),
(2, 'App\\Models\\User', 200),
(2, 'App\\Models\\User', 201),
(2, 'App\\Models\\User', 202),
(2, 'App\\Models\\User', 203),
(2, 'App\\Models\\User', 204),
(2, 'App\\Models\\User', 205),
(2, 'App\\Models\\User', 206),
(2, 'App\\Models\\User', 207),
(2, 'App\\Models\\User', 208),
(2, 'App\\Models\\User', 209),
(2, 'App\\Models\\User', 210),
(2, 'App\\Models\\User', 211),
(2, 'App\\Models\\User', 212),
(2, 'App\\Models\\User', 213),
(2, 'App\\Models\\User', 215),
(2, 'App\\Models\\User', 216),
(2, 'App\\Models\\User', 217),
(2, 'App\\Models\\User', 218),
(2, 'App\\Models\\User', 219),
(2, 'App\\Models\\User', 220),
(2, 'App\\Models\\User', 221),
(2, 'App\\Models\\User', 222),
(2, 'App\\Models\\User', 223),
(2, 'App\\Models\\User', 225),
(2, 'App\\Models\\User', 228),
(2, 'App\\Models\\User', 230),
(2, 'App\\Models\\User', 231),
(2, 'App\\Models\\User', 234),
(2, 'App\\Models\\User', 235),
(2, 'App\\Models\\User', 236),
(2, 'App\\Models\\User', 237),
(2, 'App\\Models\\User', 239),
(2, 'App\\Models\\User', 241),
(2, 'App\\Models\\User', 242),
(2, 'App\\Models\\User', 243),
(2, 'App\\Models\\User', 244),
(2, 'App\\Models\\User', 245),
(2, 'App\\Models\\User', 247),
(2, 'App\\Models\\User', 248),
(2, 'App\\Models\\User', 249),
(2, 'App\\Models\\User', 250),
(2, 'App\\Models\\User', 252),
(3, 'App\\Models\\User', 39),
(3, 'App\\Models\\User', 52),
(3, 'App\\Models\\User', 53),
(4, 'App\\Models\\User', 9),
(4, 'App\\Models\\User', 23),
(4, 'App\\Models\\User', 26),
(4, 'App\\Models\\User', 45),
(4, 'App\\Models\\User', 156),
(4, 'App\\Models\\User', 157),
(4, 'App\\Models\\User', 159),
(4, 'App\\Models\\User', 164),
(4, 'App\\Models\\User', 165),
(4, 'App\\Models\\User', 174),
(4, 'App\\Models\\User', 175),
(4, 'App\\Models\\User', 214),
(4, 'App\\Models\\User', 224),
(4, 'App\\Models\\User', 227),
(4, 'App\\Models\\User', 229),
(4, 'App\\Models\\User', 232),
(4, 'App\\Models\\User', 238),
(4, 'App\\Models\\User', 240),
(4, 'App\\Models\\User', 246),
(4, 'App\\Models\\User', 254),
(5, 'App\\Models\\User', 21),
(5, 'App\\Models\\User', 22),
(6, 'App\\Models\\User', 10),
(6, 'App\\Models\\User', 11),
(6, 'App\\Models\\User', 251);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(191) NOT NULL,
  `notifiable_type` varchar(191) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('1100da08-eefc-4267-a40e-6f0da2bbe71f', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 226, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/timesheet\\/leaves\"}', '2025-01-29 08:11:47', '2025-01-29 08:11:13', '2025-01-29 08:11:47'),
('1e87aac5-2f2e-4d0a-a910-c55297973cb9', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 253, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/timesheet\\/leaves\"}', NULL, '2025-01-29 08:44:58', '2025-01-29 08:44:58'),
('2b045382-465d-4265-a6ef-5722893b5582', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 226, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/timesheet\\/leaves\"}', NULL, '2025-01-29 08:19:09', '2025-01-29 08:19:09'),
('3751f775-97d1-46eb-8ef4-2ae4ebe6e1d5', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 253, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/timesheet\\/leaves\"}', NULL, '2025-01-29 08:37:10', '2025-01-29 08:37:10'),
('3bf710eb-a41c-4692-a9c4-f251788fffb0', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 253, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/timesheet\\/leaves\"}', NULL, '2025-01-29 08:19:09', '2025-01-29 08:19:09'),
('4006df5f-562c-4c45-92f8-ca1b075a3060', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 253, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/timesheet\\/leaves\"}', NULL, '2025-01-29 08:15:50', '2025-01-29 08:15:50'),
('5ef31c09-4a41-48ca-b1c8-39d4cfffe1c6', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 226, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/timesheet\\/leaves\"}', NULL, '2025-01-29 08:44:58', '2025-01-29 08:44:58'),
('72cd2315-6d83-499e-9cf2-c03e54357d26', 'App\\Notifications\\LeaveNotification', 'App\\Models\\User', 174, '{\"data\":\"A leave-notification has been updated\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/profile#Leave\"}', '2025-01-29 08:17:49', '2025-01-29 08:17:32', '2025-01-29 08:17:49'),
('7f058dff-f926-41a0-97f3-d6732897118d', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 226, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/timesheet\\/leaves\"}', NULL, '2025-01-29 08:37:10', '2025-01-29 08:37:10'),
('8764e798-42c5-4014-9029-f0cd014f7696', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 253, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/timesheet\\/leaves\"}', NULL, '2025-01-29 08:11:13', '2025-01-29 08:11:13'),
('893b5c0e-b049-43b9-814b-d68dc9d3657b', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 253, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/192.168.18.10:8080\\/timesheet\\/leaves\"}', NULL, '2025-01-29 08:11:47', '2025-01-29 08:11:47'),
('9f0389b0-63e0-40ef-b74c-5b9e3d61062b', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 253, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/timesheet\\/leaves\"}', NULL, '2025-01-29 08:06:02', '2025-01-29 08:06:02'),
('aa82feb1-271f-4ef4-a8b3-b2d01e2cc6be', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 226, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/192.168.18.10:8080\\/timesheet\\/leaves\"}', '2025-01-29 08:11:47', '2025-01-29 08:11:47', '2025-01-29 08:11:47'),
('b079475f-dbae-4f6b-a44e-ddc65e0972a6', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 253, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/timesheet\\/leaves\"}', NULL, '2025-01-29 08:42:18', '2025-01-29 08:42:18'),
('b244f7df-269a-4976-85d1-cfcf566221b1', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 226, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/timesheet\\/leaves\"}', '2025-01-29 08:06:21', '2025-01-29 08:06:02', '2025-01-29 08:06:21'),
('cf505a38-8db7-4916-9830-85ab05064538', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 226, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/timesheet\\/leaves\"}', NULL, '2025-01-29 08:15:50', '2025-01-29 08:15:50'),
('f1dc3101-520b-44ff-8765-f505afedf6fb', 'App\\Notifications\\LeaveNotificationToAdmin', 'App\\Models\\User', 226, '{\"data\":\"A new leave-notification\",\"link\":\"http:\\/\\/127.0.0.1:8080\\/timesheet\\/leaves\"}', NULL, '2025-01-29 08:42:18', '2025-01-29 08:42:18');

-- --------------------------------------------------------

--
-- Table structure for table `office_shifts`
--

CREATE TABLE `office_shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shift_name` varchar(191) NOT NULL,
  `default_shift` varchar(191) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `sunday_in` varchar(191) DEFAULT NULL,
  `sunday_out` varchar(191) DEFAULT NULL,
  `saturday_in` varchar(191) DEFAULT NULL,
  `saturday_out` varchar(191) DEFAULT NULL,
  `friday_in` varchar(191) DEFAULT NULL,
  `friday_out` varchar(191) DEFAULT NULL,
  `thursday_in` varchar(191) DEFAULT NULL,
  `thursday_out` varchar(191) DEFAULT NULL,
  `wednesday_in` varchar(191) DEFAULT NULL,
  `wednesday_out` varchar(191) DEFAULT NULL,
  `tuesday_in` varchar(191) DEFAULT NULL,
  `tuesday_out` varchar(191) DEFAULT NULL,
  `monday_in` varchar(191) DEFAULT NULL,
  `monday_out` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `office_shifts`
--

INSERT INTO `office_shifts` (`id`, `shift_name`, `default_shift`, `company_id`, `sunday_in`, `sunday_out`, `saturday_in`, `saturday_out`, `friday_in`, `friday_out`, `thursday_in`, `thursday_out`, `wednesday_in`, `wednesday_out`, `tuesday_in`, `tuesday_out`, `monday_in`, `monday_out`, `created_at`, `updated_at`) VALUES
(1, 'Morning Shift', NULL, 9, '', '', '', '', '02:00PM', '10:00PM', '01:00PM', '09:30PM', '01:00PM', '09:30PM', '01:00PM', '09:30PM', '01:00PM', '09:30PM', '2020-07-27 04:06:46', '2025-01-29 06:44:01');

-- --------------------------------------------------------

--
-- Table structure for table `official_documents`
--

CREATE TABLE `official_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `document_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `document_title` varchar(191) NOT NULL,
  `identification_number` varchar(191) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `document_file` varchar(191) DEFAULT NULL,
  `expiry_date` date NOT NULL,
  `is_notify` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `official_documents`
--

INSERT INTO `official_documents` (`id`, `company_id`, `document_type_id`, `added_by`, `document_title`, `identification_number`, `description`, `document_file`, `expiry_date`, `is_notify`, `created_at`, `updated_at`) VALUES
(1, 9, 8, 226, 'Test Project', '8739320', 'Test Project', 'Test Project.1738140998.png', '2025-01-31', 30, '2020-10-22 08:32:35', '2025-01-29 08:56:39');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('new@gmail.com', '$2y$10$day4AQ4g8sFvMwhMrTxpJuLXZCpVF2IK9kVS.6qZxeR6b7CVt2eGy', '2020-10-06 04:22:35'),
('irfanchowdhury80@gmail.com', '$2y$10$3Opuz3k6NY0WRJbDgHO8gOz2UlR4GOumTVsQgu61.mPbmzt8DnYi6', '2024-01-14 08:13:48'),
('irfanchowdhury434@gmail.com', '$2y$10$Xzahp1UflMrb3lzE/C9lQeGQ0z.E9UoA.1XjW7KRLIuuwTGdfp.NS', '2024-03-31 07:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `method_name` varchar(40) NOT NULL,
  `payment_percentage` varchar(100) DEFAULT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `company_id`, `method_name`, `payment_percentage`, `account_number`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Paypal', '10%', '123', '2020-07-27 03:52:20', '2020-07-27 03:53:03'),
(2, NULL, 'Bank', '5%', '786', '2020-07-27 03:53:17', '2020-07-27 03:53:17'),
(3, NULL, 'Cash', '2%%', '999', '2020-07-27 03:53:29', '2023-11-07 06:39:23');

-- --------------------------------------------------------

--
-- Table structure for table `payslips`
--

CREATE TABLE `payslips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payslip_key` char(36) NOT NULL,
  `payslip_number` varchar(191) DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `payment_type` varchar(191) NOT NULL,
  `basic_salary` double NOT NULL,
  `net_salary` double NOT NULL,
  `allowances` text NOT NULL,
  `commissions` text NOT NULL,
  `loans` text NOT NULL,
  `deductions` text NOT NULL,
  `overtimes` text NOT NULL,
  `other_payments` text NOT NULL,
  `pension_type` varchar(50) DEFAULT NULL,
  `pension_amount` double NOT NULL,
  `hours_worked` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `month_year` varchar(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payslips`
--

INSERT INTO `payslips` (`id`, `payslip_key`, `payslip_number`, `employee_id`, `company_id`, `payment_type`, `basic_salary`, `net_salary`, `allowances`, `commissions`, `loans`, `deductions`, `overtimes`, `other_payments`, `pension_type`, `pension_amount`, `hours_worked`, `status`, `month_year`, `created_at`, `updated_at`) VALUES
(23, 'Heizf4TsdYLCOgt8GBOQ', '1685181828', 12, 1, 'Monthly', 1500, 1705, '[{\"id\":3,\"employee_id\":12,\"allowance_title\":\"Snacks\",\"allowance_amount\":\"50\"},{\"id\":4,\"employee_id\":12,\"allowance_title\":\"Transport\",\"allowance_amount\":\"60\"}]', '[{\"id\":2,\"employee_id\":12,\"commission_title\":\"Sale Increase\",\"commission_amount\":\"15\"},{\"id\":13,\"employee_id\":12,\"commission_title\":\"Work Rate\",\"commission_amount\":\"10\"}]', '[]', '[{\"id\":2,\"employee_id\":12,\"deduction_title\":\"Development tax\",\"deduction_amount\":\"5\"}]', '[{\"id\":3,\"employee_id\":12,\"overtime_title\":\"Night Shift\",\"no_of_days\":\"5\",\"overtime_hours\":\"10\",\"overtime_rate\":\"5\",\"overtime_amount\":\"50\"},{\"id\":4,\"employee_id\":12,\"overtime_title\":\"Production Hour\",\"no_of_days\":\"2\",\"overtime_hours\":\"2\",\"overtime_rate\":\"5\",\"overtime_amount\":\"10\"}]', '[]', NULL, 0, 0, 1, 'January-2021', '2021-01-27 01:22:07', '2021-01-27 01:22:07'),
(24, 'JlvmZMOa5lI5jLCjiJhG', '4271987981', 14, 2, 'Monthly', 200, 310, '[{\"id\":12,\"employee_id\":14,\"allowance_title\":\"Tea\",\"allowance_amount\":\"10\"}]', '[{\"id\":19,\"employee_id\":14,\"commission_title\":\"Sale\",\"commission_amount\":\"10\"}]', '[]', '[{\"id\":7,\"employee_id\":14,\"deduction_title\":\"Health\",\"deduction_amount\":\"10\"}]', '[{\"id\":10,\"employee_id\":14,\"overtime_title\":\"Advance Work\",\"no_of_days\":\"7\",\"overtime_hours\":\"10\",\"overtime_rate\":\"10\",\"overtime_amount\":\"100\"}]', '[]', NULL, 0, 0, 1, 'January-2021', '2021-01-27 01:36:45', '2021-01-27 01:36:45'),
(35, 'qaFrFw7u42ttOPtdUg3X', '1470327139', 14, 2, 'Monthly', 200, 310, '[{\"id\":12,\"employee_id\":14,\"allowance_title\":\"Tea\",\"allowance_amount\":\"10\"}]', '[{\"id\":19,\"employee_id\":14,\"commission_title\":\"Sale\",\"commission_amount\":\"10\"}]', '[]', '[{\"id\":7,\"employee_id\":14,\"deduction_title\":\"Health\",\"deduction_amount\":\"10\"}]', '[{\"id\":10,\"employee_id\":14,\"overtime_title\":\"Advance Work\",\"no_of_days\":\"7\",\"overtime_hours\":\"10\",\"overtime_rate\":\"10\",\"overtime_amount\":\"100\"}]', '[]', NULL, 0, 0, 1, 'February-2021', '2021-03-05 12:49:44', '2021-03-05 12:49:44'),
(64, '5egHnALK1DikDtw3qpC9', '9276867492', 15, 2, 'Monthly', 110, 110, '[]', '[]', '[]', '[]', '[]', '[]', NULL, 0, 0, 1, 'February-2021', '2021-03-12 06:40:21', '2021-03-12 06:40:21'),
(65, 'rqKgatx6fEzWtiITw81J', '7754626331', 10, 1, 'Monthly', 2500, 1705, '[{\"id\":3,\"employee_id\":12,\"allowance_title\":\"Snacks\",\"allowance_amount\":\"50\"},{\"id\":4,\"employee_id\":12,\"allowance_title\":\"Transport\",\"allowance_amount\":\"60\"}]', '[{\"id\":2,\"employee_id\":12,\"commission_title\":\"Sale Increase\",\"commission_amount\":\"15\"},{\"id\":13,\"employee_id\":12,\"commission_title\":\"Work Rate\",\"commission_amount\":\"10\"}]', '[]', '[{\"id\":2,\"employee_id\":12,\"deduction_title\":\"Development tax\",\"deduction_amount\":\"5\"}]', '[{\"id\":3,\"employee_id\":12,\"overtime_title\":\"Night Shift\",\"no_of_days\":\"5\",\"overtime_hours\":\"10\",\"overtime_rate\":\"5\",\"overtime_amount\":\"50\"},{\"id\":4,\"employee_id\":12,\"overtime_title\":\"Production Hour\",\"no_of_days\":\"2\",\"overtime_hours\":\"2\",\"overtime_rate\":\"5\",\"overtime_amount\":\"10\"}]', '[{\"id\":1,\"employee_id\":12,\"other_payment_title\":\"Pefomance Bonus\",\"other_payment_amount\":\"15\"}]', NULL, 0, 0, 1, 'February-2021', '2021-03-12 06:52:46', '2021-03-12 06:52:46'),
(146, 'ix7eieBNAuWw5hU3wVWp', '8080407568', 14, 2, 'Monthly', 200, 310, '[{\"id\":12,\"employee_id\":14,\"allowance_title\":\"Tea\",\"allowance_amount\":\"10\"}]', '[{\"id\":19,\"employee_id\":14,\"commission_title\":\"Sale\",\"commission_amount\":\"10\"}]', '[]', '[{\"id\":7,\"employee_id\":14,\"deduction_title\":\"Health\",\"deduction_amount\":\"10\"}]', '[{\"id\":10,\"employee_id\":14,\"overtime_title\":\"Advance Work\",\"no_of_days\":\"7\",\"overtime_hours\":\"10\",\"overtime_rate\":\"10\",\"overtime_amount\":\"100\"}]', '[]', NULL, 0, 0, 1, 'March-2021', '2021-03-12 13:17:02', '2021-03-12 13:17:02'),
(147, 'ET6AArlpGdCmexpWMeLi', '2925821330', 10, 1, 'Monthly', 100, 660, '[{\"id\":8,\"employee_id\":10,\"allowance_title\":\"Tea\",\"allowance_amount\":\"10\"},{\"id\":9,\"employee_id\":10,\"allowance_title\":\"Snacks\",\"allowance_amount\":\"50\"}]', '[{\"id\":17,\"employee_id\":10,\"commission_title\":\"Sale\",\"commission_amount\":\"50\"}]', '[]', '[{\"id\":5,\"employee_id\":10,\"deduction_title\":\"Testing\",\"deduction_amount\":\"50\"}]', '[{\"id\":8,\"employee_id\":10,\"overtime_title\":\"Advance Work\",\"no_of_days\":\"5\",\"overtime_hours\":\"25\",\"overtime_rate\":\"20\",\"overtime_amount\":\"500\"}]', '[]', NULL, 0, 0, 1, 'March-2021', '2021-03-13 10:07:03', '2021-03-13 10:07:03'),
(152, 'Y8QZy53anJrYBSQDIrvS', '4959778575', 13, 1, 'Monthly', 300, 375, '[{\"id\":5,\"employee_id\":9,\"allowance_title\":\"xyz\",\"allowance_amount\":\"100\"}]', '[{\"id\":14,\"employee_id\":9,\"commission_title\":\"Cofee\",\"commission_amount\":\"15\"},{\"id\":15,\"employee_id\":9,\"commission_title\":\"Tea\",\"commission_amount\":\"10\"}]', '[]', '[{\"id\":3,\"employee_id\":9,\"deduction_title\":\"Test Deduction\",\"deduction_amount\":\"50\"}]', '[]', '[]', NULL, 0, 0, 1, 'April-2021', '2021-04-06 03:31:41', '2021-04-06 03:31:41'),
(153, 'MojiX0BrB2nPkGB8GLEo', '9462137854', 11, 1, 'Hourly', 100, 1615, '[{\"id\":1,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Home\",\"allowance_amount\":\"200\",\"is_taxable\":0,\"created_at\":\"2020-07-29 22:10:53\",\"updated_at\":\"2020-07-29 22:10:53\"},{\"id\":2,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Tea\",\"allowance_amount\":\"50\",\"is_taxable\":0,\"created_at\":\"2020-07-30 00:08:42\",\"updated_at\":\"2020-07-30 00:08:42\"}]', '[]', '[{\"id\":8,\"employee_id\":11,\"loan_title\":\"Home\",\"loan_amount\":\"100\",\"time_remaining\":\"3\",\"amount_remaining\":\"75\",\"monthly_payable\":\"25.000\"}]', '[{\"id\":1,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"deduction_title\":\"Test\",\"deduction_amount\":\"10\",\"deduction_type\":\"Health Insurance Corporation\",\"created_at\":\"2020-07-30 00:21:22\",\"updated_at\":\"2020-07-30 00:21:22\"}]', '[]', '[]', NULL, 0, 14, 1, 'March-2021', '2021-04-12 17:33:37', '2021-04-12 17:33:37'),
(154, 'tSGyONwrlCeMjeWOemTl', '5146547430', 11, 1, 'Hourly', 100, 215, '[{\"id\":1,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Home\",\"allowance_amount\":\"200\",\"is_taxable\":0,\"created_at\":\"2020-07-29 22:10:53\",\"updated_at\":\"2020-07-29 22:10:53\"},{\"id\":2,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Tea\",\"allowance_amount\":\"50\",\"is_taxable\":0,\"created_at\":\"2020-07-30 00:08:42\",\"updated_at\":\"2020-07-30 00:08:42\"}]', '[]', '[{\"id\":8,\"employee_id\":11,\"loan_title\":\"Home\",\"loan_amount\":\"100\",\"time_remaining\":\"2\",\"amount_remaining\":\"50\",\"monthly_payable\":\"25.000\"}]', '[{\"id\":1,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"deduction_title\":\"Test\",\"deduction_amount\":\"10\",\"deduction_type\":\"Health Insurance Corporation\",\"created_at\":\"2020-07-30 00:21:22\",\"updated_at\":\"2020-07-30 00:21:22\"}]', '[]', '[]', NULL, 0, 0, 1, 'April-2021', '2021-04-12 17:34:45', '2021-04-12 17:34:45'),
(155, '02fZCnP2WZPMvoAe03C7', '3205941835', 11, 1, 'Hourly', 100, 215, '[{\"id\":1,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Home\",\"allowance_amount\":\"200\",\"is_taxable\":0,\"created_at\":\"2020-07-29 22:10:53\",\"updated_at\":\"2020-07-29 22:10:53\"},{\"id\":2,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Tea\",\"allowance_amount\":\"50\",\"is_taxable\":0,\"created_at\":\"2020-07-30 00:08:42\",\"updated_at\":\"2020-07-30 00:08:42\"}]', '[]', '[{\"id\":8,\"employee_id\":11,\"loan_title\":\"Home\",\"loan_amount\":\"100\",\"time_remaining\":\"1\",\"amount_remaining\":\"25\",\"monthly_payable\":\"25.000\"}]', '[{\"id\":1,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"deduction_title\":\"Test\",\"deduction_amount\":\"10\",\"deduction_type\":\"Health Insurance Corporation\",\"created_at\":\"2020-07-30 00:21:22\",\"updated_at\":\"2020-07-30 00:21:22\"}]', '[]', '[]', NULL, 0, 0, 1, 'May-2021', '2021-04-12 17:35:23', '2021-04-12 17:35:23'),
(156, 'VIM8lgr0qjgan1fJyOZJ', '5926261822', 11, 1, 'Hourly', 100, 215, '[{\"id\":1,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Home\",\"allowance_amount\":\"200\",\"is_taxable\":0,\"created_at\":\"2020-07-29 22:10:53\",\"updated_at\":\"2020-07-29 22:10:53\"},{\"id\":2,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Tea\",\"allowance_amount\":\"50\",\"is_taxable\":0,\"created_at\":\"2020-07-30 00:08:42\",\"updated_at\":\"2020-07-30 00:08:42\"}]', '[]', '[{\"id\":8,\"employee_id\":11,\"loan_title\":\"Home\",\"loan_amount\":\"100\",\"time_remaining\":\"0\",\"amount_remaining\":\"0\",\"monthly_payable\":\"25.000\"}]', '[{\"id\":1,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"deduction_title\":\"Test\",\"deduction_amount\":\"10\",\"deduction_type\":\"Health Insurance Corporation\",\"created_at\":\"2020-07-30 00:21:22\",\"updated_at\":\"2020-07-30 00:21:22\"}]', '[]', '[]', NULL, 0, 0, 1, 'June-2021', '2021-04-12 17:36:32', '2021-04-12 17:36:32'),
(164, 'wyJzh8L8YlJjstjyczbA', '3637185451', 12, 1, 'Monthly', 100, 205, '[{\"id\":3,\"employee_id\":12,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Snacks\",\"allowance_amount\":\"50\",\"is_taxable\":0,\"created_at\":\"2020-10-20 10:01:55\",\"updated_at\":\"2020-10-20 10:01:55\"},{\"id\":4,\"employee_id\":12,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Transport\",\"allowance_amount\":\"60\",\"is_taxable\":0,\"created_at\":\"2020-10-20 10:02:25\",\"updated_at\":\"2020-10-20 10:02:25\"}]', '[]', '[]', '[{\"id\":2,\"employee_id\":12,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"deduction_title\":\"Development tax\",\"deduction_amount\":\"5\",\"deduction_type\":\"Home Development Mutual Fund\",\"created_at\":\"2020-10-20 10:50:01\",\"updated_at\":\"2020-10-20 10:50:01\"}]', '[]', '[]', NULL, 0, 0, 1, 'May-2021', '2021-05-01 23:15:07', '2021-05-01 23:15:07'),
(165, 'pww8lAyuz98inC21rMpA', '5538729615', 27, 1, 'Monthly', 100, 100, '[]', '[]', '[]', '[]', '[]', '[]', NULL, 0, 0, 1, 'May-2021', '2021-05-01 23:15:22', '2021-05-01 23:15:22'),
(166, 'v3n2tmqTTSAz5GqS13LR', '5542732803', 15, 1, 'Monthly', 200, 200, '[]', '[]', '[]', '[]', '[]', '[]', NULL, 0, 0, 1, 'May-2021', '2021-05-01 23:15:33', '2021-05-01 23:15:33'),
(167, 'tHhQ0sudoHhVhDRfIpya', '4457156927', 11, 1, 'Hourly', 100, 740, '[{\"id\":1,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Home\",\"allowance_amount\":\"200\",\"is_taxable\":0,\"created_at\":\"2020-07-29 09:10:53\",\"updated_at\":\"2020-07-29 09:10:53\"},{\"id\":2,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Tea\",\"allowance_amount\":\"50\",\"is_taxable\":0,\"created_at\":\"2020-07-29 11:08:42\",\"updated_at\":\"2020-07-29 11:08:42\"}]', '[]', '[{\"id\":8,\"employee_id\":11,\"loan_title\":\"Home\",\"loan_amount\":\"100\",\"time_remaining\":\"0\",\"amount_remaining\":\"0\",\"monthly_payable\":\"0\"}]', '[{\"id\":1,\"employee_id\":11,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"deduction_title\":\"Test\",\"deduction_amount\":\"10\",\"deduction_type\":\"Health Insurance Corporation\",\"created_at\":\"2020-07-29 11:21:22\",\"updated_at\":\"2020-07-29 11:21:22\"}]', '[]', '[]', NULL, 0, 5, 1, 'July-2021', '2021-07-03 13:48:19', '2021-07-03 13:48:19'),
(168, 'N7ZSEkNPJzeAXwP93juf', '6468694689', 9, 1, 'Monthly', 500, 350, '[{\"id\":15,\"employee_id\":9,\"month_year\":\"August-2021\",\"first_date\":\"2021-08-01\",\"allowance_title\":\"Milk\",\"allowance_amount\":\"200\",\"is_taxable\":0,\"created_at\":\"2021-04-09 11:38:21\",\"updated_at\":\"2021-04-09 11:38:21\"}]', '[]', '[]', '[{\"id\":10,\"employee_id\":9,\"month_year\":\"April-2021\",\"first_date\":\"2021-04-01\",\"deduction_title\":\"Fever\",\"deduction_amount\":\"100\",\"deduction_type\":\"Health Insurance Corporation\",\"created_at\":\"2021-04-10 19:16:30\",\"updated_at\":\"2021-04-10 19:16:30\"}]', '[]', '[]', 'percentage', 250, 0, 1, 'July-2022', '2022-07-23 08:15:27', '2022-07-23 08:15:27'),
(169, 'zGxSMPfXaZPQTLq4V0PJ', '8615826435', 11, 1, 'Monthly', 100, 70, '[{\"id\":16,\"employee_id\":11,\"month_year\":\"October-2022\",\"first_date\":\"2022-10-01\",\"allowance_title\":\"Transportation\",\"allowance_amount\":\"10\",\"is_taxable\":0,\"created_at\":\"2022-10-18 10:17:19\",\"updated_at\":\"2022-10-18 10:17:19\"},{\"id\":17,\"employee_id\":11,\"month_year\":\"October-2022\",\"first_date\":\"2022-10-01\",\"allowance_title\":\"Communication\",\"allowance_amount\":\"10\",\"is_taxable\":0,\"created_at\":\"2022-10-18 10:17:44\",\"updated_at\":\"2022-10-18 10:17:44\"}]', '[]', '[{\"id\":8,\"employee_id\":11,\"loan_title\":\"Home\",\"loan_amount\":\"100\",\"time_remaining\":\"0\",\"amount_remaining\":\"0\",\"monthly_payable\":\"0\"},{\"id\":9,\"employee_id\":11,\"loan_title\":\"Home\",\"loan_amount\":\"50\",\"time_remaining\":\"0\",\"amount_remaining\":\"0\",\"monthly_payable\":\"50.00\"}]', '[{\"id\":11,\"employee_id\":11,\"month_year\":\"October-2022\",\"first_date\":\"2022-10-01\",\"deduction_title\":\"Medical\",\"deduction_amount\":\"15\",\"deduction_type\":\"Health Insurance Corporation\",\"created_at\":\"2022-10-18 10:19:18\",\"updated_at\":\"2022-10-18 10:19:18\"}]', '[{\"id\":14,\"employee_id\":11,\"month_year\":\"October-2022\",\"first_date\":\"2022-10-01\",\"overtime_title\":\"OT\",\"no_of_days\":\"4\",\"overtime_hours\":\"8\",\"overtime_rate\":\"0.5\",\"overtime_amount\":\"4\",\"created_at\":\"2022-10-18 10:20:06\",\"updated_at\":\"2022-10-18 10:20:06\"}]', '[{\"id\":5,\"employee_id\":11,\"month_year\":\"October-2022\",\"first_date\":\"2022-10-01\",\"other_payment_title\":\"Reimbursement\",\"other_payment_amount\":\"11\",\"created_at\":\"2022-10-18 10:19:39\",\"updated_at\":\"2022-10-18 10:19:39\"}]', NULL, 0, 0, 1, 'October-2022', '2022-10-18 15:22:39', '2022-10-18 15:22:39'),
(186, 'zTki473xvAu3SmZKI3Tg', '4679326533', 12, 1, 'Monthly', 100, 195, '[{\"id\":3,\"employee_id\":12,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Snacks\",\"allowance_amount\":\"50\",\"is_taxable\":0,\"created_at\":\"2020-10-20 10:01:55\",\"updated_at\":\"2020-10-20 10:01:55\"},{\"id\":4,\"employee_id\":12,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Transport\",\"allowance_amount\":\"60\",\"is_taxable\":0,\"created_at\":\"2020-10-20 10:02:25\",\"updated_at\":\"2020-10-20 10:02:25\"}]', '[]', '[{\"id\":14,\"employee_id\":12,\"loan_title\":\"Test 20\",\"loan_amount\":\"20\",\"time_remaining\":\"1\",\"amount_remaining\":\"10\",\"monthly_payable\":\"10.00\"}]', '[{\"id\":2,\"employee_id\":12,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"deduction_title\":\"Development tax\",\"deduction_amount\":\"5\",\"deduction_type\":\"Home Development Mutual Fund\",\"created_at\":\"2020-10-20 10:50:01\",\"updated_at\":\"2020-10-20 10:50:01\"}]', '[]', '[]', NULL, 0, 0, 1, 'October-2022', '2022-10-26 09:16:28', '2022-10-26 09:16:28'),
(187, 'Huu1hs1cmPcFHoKjjwpM', '3949991881', 12, 1, 'Monthly', 100, 195, '[{\"id\":3,\"employee_id\":12,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Snacks\",\"allowance_amount\":\"50\",\"is_taxable\":0,\"created_at\":\"2020-10-20 10:01:55\",\"updated_at\":\"2020-10-20 10:01:55\"},{\"id\":4,\"employee_id\":12,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Transport\",\"allowance_amount\":\"60\",\"is_taxable\":0,\"created_at\":\"2020-10-20 10:02:25\",\"updated_at\":\"2020-10-20 10:02:25\"}]', '[]', '[{\"id\":14,\"employee_id\":12,\"loan_title\":\"Test 20\",\"loan_amount\":\"20\",\"time_remaining\":\"0\",\"amount_remaining\":\"0\",\"monthly_payable\":\"0\"}]', '[{\"id\":2,\"employee_id\":12,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"deduction_title\":\"Development tax\",\"deduction_amount\":\"5\",\"deduction_type\":\"Home Development Mutual Fund\",\"created_at\":\"2020-10-20 10:50:01\",\"updated_at\":\"2020-10-20 10:50:01\"}]', '[]', '[]', NULL, 0, 0, 1, 'November-2022', '2022-10-26 09:17:07', '2022-10-26 09:17:07'),
(188, 'bFzWbHiPmtwzu6NMLNmU', '5850643090', 9, 1, 'Monthly', 500, 350, '[{\"id\":15,\"employee_id\":9,\"month_year\":\"August-2021\",\"first_date\":\"2021-08-01\",\"allowance_title\":\"Milk\",\"allowance_amount\":\"200\",\"is_taxable\":0,\"created_at\":\"2021-04-09T05:38:21.000000Z\",\"updated_at\":\"2021-04-09T05:38:21.000000Z\"}]', '[]', '[]', '[{\"id\":10,\"employee_id\":9,\"month_year\":\"April-2021\",\"first_date\":\"2021-04-01\",\"deduction_title\":\"Fever\",\"deduction_amount\":\"100\",\"deduction_type\":\"Health Insurance Corporation\",\"created_at\":\"2021-04-10T13:16:30.000000Z\",\"updated_at\":\"2021-04-10T13:16:30.000000Z\"}]', '[]', '[]', 'percentage', 250, 0, 1, 'April-2023', '2023-04-15 05:18:37', '2023-04-15 05:18:37'),
(189, 'D0Fbmb5URYblJ02QWudb', '6507747581', 11, 1, 'Monthly', 100, 55, '[{\"id\":16,\"employee_id\":11,\"month_year\":\"October-2022\",\"first_date\":\"2022-10-01\",\"allowance_title\":\"Transportation\",\"allowance_amount\":\"10\",\"is_taxable\":0,\"created_at\":\"2022-10-18T15:17:19.000000Z\",\"updated_at\":\"2022-10-18T15:17:19.000000Z\"},{\"id\":17,\"employee_id\":11,\"month_year\":\"October-2022\",\"first_date\":\"2022-10-01\",\"allowance_title\":\"Communication\",\"allowance_amount\":\"10\",\"is_taxable\":0,\"created_at\":\"2022-10-18T15:17:44.000000Z\",\"updated_at\":\"2022-10-18T15:17:44.000000Z\"}]', '[]', '[{\"id\":8,\"employee_id\":11,\"loan_title\":\"Home\",\"loan_amount\":\"100\",\"time_remaining\":\"0\",\"amount_remaining\":\"0\",\"monthly_payable\":\"0\"},{\"id\":9,\"employee_id\":11,\"loan_title\":\"Home\",\"loan_amount\":\"50\",\"time_remaining\":\"0\",\"amount_remaining\":\"0\",\"monthly_payable\":\"0\"}]', '[{\"id\":11,\"employee_id\":11,\"month_year\":\"October-2022\",\"first_date\":\"2022-10-01\",\"deduction_title\":\"Medical\",\"deduction_amount\":\"15\",\"deduction_type\":\"Health Insurance Corporation\",\"created_at\":\"2022-10-18T15:19:18.000000Z\",\"updated_at\":\"2022-10-18T15:19:18.000000Z\"}]', '[]', '[]', NULL, 0, 0, 1, 'April-2023', '2023-04-15 07:58:00', '2023-04-15 07:58:00'),
(190, 'va6pNUvcHDIQ8AgfpucE', '4322269479', 9, 1, 'Monthly', 500, 350, '[{\"id\":15,\"employee_id\":9,\"month_year\":\"August-2021\",\"first_date\":\"2021-08-01\",\"allowance_title\":\"Milk\",\"allowance_amount\":\"200\",\"is_taxable\":0,\"created_at\":\"2021-04-09T06:08:21.000000Z\",\"updated_at\":\"2021-04-09T06:08:21.000000Z\"}]', '[]', '[]', '[{\"id\":10,\"employee_id\":9,\"month_year\":\"April-2021\",\"first_date\":\"2021-04-01\",\"deduction_title\":\"Fever\",\"deduction_amount\":\"100\",\"deduction_type\":\"Health Insurance Corporation\",\"created_at\":\"2021-04-10T13:46:30.000000Z\",\"updated_at\":\"2021-04-10T13:46:30.000000Z\"}]', '[]', '[]', 'percentage', 250, 0, 1, 'September-2023', '2023-09-12 04:39:32', '2023-09-12 04:39:32'),
(192, '04s7eLfAIQEwLd1uv165', '1005356954', 13, 1, 'Monthly', 100, 120, '[{\"id\":10,\"employee_id\":13,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Home\",\"allowance_amount\":\"100\",\"is_taxable\":0,\"created_at\":\"2021-01-27T01:41:57.000000Z\",\"updated_at\":\"2021-01-27T01:41:57.000000Z\"},{\"id\":11,\"employee_id\":13,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"allowance_title\":\"Tea\",\"allowance_amount\":\"20\",\"is_taxable\":0,\"created_at\":\"2021-01-27T01:42:09.000000Z\",\"updated_at\":\"2021-01-27T01:42:09.000000Z\"}]', '[]', '[]', '[{\"id\":6,\"employee_id\":13,\"month_year\":\"January-2021\",\"first_date\":\"2021-01-01\",\"deduction_title\":\"Health\",\"deduction_amount\":\"100\",\"deduction_type\":\"Health Insurance Corporation\",\"created_at\":\"2021-01-27T01:43:31.000000Z\",\"updated_at\":\"2021-01-27T01:43:31.000000Z\"}]', '[]', '[]', NULL, 0, 0, 1, 'April-2024', '2024-04-25 11:47:33', '2024-04-25 11:47:33');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'user', 'web', NULL, NULL),
(2, 'view-user', 'web', NULL, NULL),
(3, 'edit-user', 'web', NULL, NULL),
(4, 'delete-user', 'web', NULL, NULL),
(5, 'last-login-user', 'web', NULL, NULL),
(6, 'role-access-user', 'web', NULL, NULL),
(7, 'details-employee', 'web', NULL, NULL),
(8, 'view-details-employee', 'web', NULL, NULL),
(9, 'store-details-employee', 'web', NULL, NULL),
(10, 'modify-details-employee', 'web', NULL, NULL),
(11, 'customize-setting', 'web', NULL, NULL),
(12, 'role-access', 'web', NULL, NULL),
(13, 'general-setting', 'web', NULL, NULL),
(14, 'view-general-setting', 'web', NULL, NULL),
(15, 'store-general-setting', 'web', NULL, NULL),
(16, 'mail-setting', 'web', NULL, NULL),
(17, 'view-mail-setting', 'web', NULL, NULL),
(18, 'store-mail-setting', 'web', NULL, NULL),
(19, 'language-setting', 'web', NULL, NULL),
(20, 'core_hr', 'web', NULL, NULL),
(21, 'view-calendar', 'web', NULL, NULL),
(22, 'promotion', 'web', NULL, NULL),
(23, 'view-promotion', 'web', NULL, NULL),
(24, 'store-promotion', 'web', NULL, NULL),
(25, 'edit-promotion', 'web', NULL, NULL),
(26, 'delete-promotion', 'web', NULL, NULL),
(27, 'award', 'web', NULL, NULL),
(28, 'view-award', 'web', NULL, NULL),
(29, 'store-award', 'web', NULL, NULL),
(30, 'edit-award', 'web', NULL, NULL),
(31, 'delete-award', 'web', NULL, NULL),
(32, 'transfer', 'web', NULL, NULL),
(33, 'view-transfer', 'web', NULL, NULL),
(34, 'store-transfer', 'web', NULL, NULL),
(35, 'edit-transfer', 'web', NULL, NULL),
(36, 'delete-transfer', 'web', NULL, NULL),
(37, 'travel', 'web', NULL, NULL),
(38, 'view-travel', 'web', NULL, NULL),
(39, 'store-travel', 'web', NULL, NULL),
(40, 'edit-travel', 'web', NULL, NULL),
(41, 'delete-travel', 'web', NULL, NULL),
(42, 'resignation', 'web', NULL, NULL),
(43, 'view-resignation', 'web', NULL, NULL),
(44, 'store-resignation', 'web', NULL, NULL),
(45, 'edit-resignation', 'web', NULL, NULL),
(46, 'delete-resignation', 'web', NULL, NULL),
(47, 'complaint', 'web', NULL, NULL),
(48, 'view-complaint', 'web', NULL, NULL),
(49, 'store-complaint', 'web', NULL, NULL),
(50, 'edit-complaint', 'web', NULL, NULL),
(51, 'delete-complaint', 'web', NULL, NULL),
(52, 'warning', 'web', NULL, NULL),
(53, 'view-warning', 'web', NULL, NULL),
(54, 'store-warning', 'web', NULL, NULL),
(55, 'edit-warning', 'web', NULL, NULL),
(56, 'delete-warning', 'web', NULL, NULL),
(57, 'termination', 'web', NULL, NULL),
(58, 'view-termination', 'web', NULL, NULL),
(59, 'store-termination', 'web', NULL, NULL),
(60, 'edit-termination', 'web', NULL, NULL),
(61, 'delete-termination', 'web', NULL, NULL),
(62, 'timesheet', 'web', NULL, NULL),
(63, 'attendance', 'web', NULL, NULL),
(64, 'view-attendance', 'web', NULL, NULL),
(65, 'edit-attendance', 'web', NULL, NULL),
(66, 'office_shift', 'web', NULL, NULL),
(67, 'view-office_shift', 'web', NULL, NULL),
(68, 'store-office_shift', 'web', NULL, NULL),
(69, 'edit-office_shift', 'web', NULL, NULL),
(70, 'delete-office_shift', 'web', NULL, NULL),
(71, 'holiday', 'web', NULL, NULL),
(72, 'view-holiday', 'web', NULL, NULL),
(73, 'store-holiday', 'web', NULL, NULL),
(74, 'edit-holiday', 'web', NULL, NULL),
(75, 'delete-holiday', 'web', NULL, NULL),
(76, 'leave', 'web', NULL, NULL),
(77, 'view-holiday', 'web', NULL, NULL),
(78, 'store-holiday', 'web', NULL, NULL),
(79, 'edit-holiday', 'web', NULL, NULL),
(80, 'delete-holiday', 'web', NULL, NULL),
(81, 'payment-module', 'web', NULL, NULL),
(82, 'view-payslip', 'web', NULL, NULL),
(83, 'make-payment', 'web', NULL, NULL),
(84, 'make-bulk_payment', 'web', NULL, NULL),
(85, 'view-paylist', 'web', NULL, NULL),
(86, 'set-salary', 'web', NULL, NULL),
(87, 'hr_report', 'web', NULL, NULL),
(88, 'report-payslip', 'web', NULL, NULL),
(89, 'report-attendance', 'web', NULL, NULL),
(90, 'report-training', 'web', NULL, NULL),
(91, 'report-project', 'web', NULL, NULL),
(92, 'report-task', 'web', NULL, NULL),
(93, 'report-employee', 'web', NULL, NULL),
(94, 'report-account', 'web', NULL, NULL),
(95, 'report-deposit', 'web', NULL, NULL),
(96, 'report-expense', 'web', NULL, NULL),
(97, 'report-transaction', 'web', NULL, NULL),
(98, 'recruitment', 'web', NULL, NULL),
(99, 'job_employer', 'web', NULL, NULL),
(100, 'view-job_employer', 'web', NULL, NULL),
(101, 'store-job_employer', 'web', NULL, NULL),
(102, 'edit-job_employer', 'web', NULL, NULL),
(103, 'delete-job_employer', 'web', NULL, NULL),
(104, 'job_post', 'web', NULL, NULL),
(105, 'view-job_post', 'web', NULL, NULL),
(106, 'store-job_post', 'web', NULL, NULL),
(107, 'edit-job_post', 'web', NULL, NULL),
(108, 'delete-job_post', 'web', NULL, NULL),
(109, 'job_candidate', 'web', NULL, NULL),
(110, 'view-job_candidate', 'web', NULL, NULL),
(111, 'store-job_candidate', 'web', NULL, NULL),
(112, 'delete-job_candidate', 'web', NULL, NULL),
(113, 'job_interview', 'web', NULL, NULL),
(114, 'view-job_interview', 'web', NULL, NULL),
(115, 'store-job_interview', 'web', NULL, NULL),
(116, 'delete-job_interview', 'web', NULL, NULL),
(117, 'project-management', 'web', NULL, NULL),
(118, 'project', 'web', NULL, NULL),
(119, 'view-project', 'web', NULL, NULL),
(120, 'store-project', 'web', NULL, NULL),
(121, 'edit-project', 'web', NULL, NULL),
(122, 'delete-project', 'web', NULL, NULL),
(123, 'task', 'web', NULL, NULL),
(124, 'view-task', 'web', NULL, NULL),
(125, 'store-task', 'web', NULL, NULL),
(126, 'edit-task', 'web', NULL, NULL),
(127, 'delete-task', 'web', NULL, NULL),
(128, 'client', 'web', NULL, NULL),
(129, 'view-client', 'web', NULL, NULL),
(130, 'store-client', 'web', NULL, NULL),
(131, 'edit-client', 'web', NULL, NULL),
(132, 'delete-client', 'web', NULL, NULL),
(133, 'invoice', 'web', NULL, NULL),
(134, 'view-invoice', 'web', NULL, NULL),
(135, 'store-invoice', 'web', NULL, NULL),
(136, 'edit-invoice', 'web', NULL, NULL),
(137, 'delete-invoice', 'web', NULL, NULL),
(138, 'ticket', 'web', NULL, NULL),
(139, 'view-ticket', 'web', NULL, NULL),
(140, 'store-ticket', 'web', NULL, NULL),
(141, 'edit-ticket', 'web', NULL, NULL),
(142, 'delete-ticket', 'web', NULL, NULL),
(143, 'import-module', 'web', NULL, NULL),
(144, 'import-attendance', 'web', NULL, NULL),
(145, 'import-employee', 'web', NULL, NULL),
(146, 'file_module', 'web', NULL, NULL),
(147, 'file_manager', 'web', NULL, NULL),
(148, 'view-file_manager', 'web', NULL, NULL),
(149, 'store-file_manager', 'web', NULL, NULL),
(150, 'edit-file_manager', 'web', NULL, NULL),
(151, 'delete-file_manager', 'web', NULL, NULL),
(152, 'view-file_config', 'web', NULL, NULL),
(153, 'official_document', 'web', NULL, NULL),
(154, 'view-official_document', 'web', NULL, NULL),
(155, 'store-official_document', 'web', NULL, NULL),
(156, 'edit-official_document', 'web', NULL, NULL),
(157, 'delete-official_document', 'web', NULL, NULL),
(158, 'event-meeting', 'web', NULL, NULL),
(159, 'meeting', 'web', NULL, NULL),
(160, 'view-meeting', 'web', NULL, NULL),
(161, 'store-meeting', 'web', NULL, NULL),
(162, 'edit-meeting', 'web', NULL, NULL),
(163, 'delete-meeting', 'web', NULL, NULL),
(164, 'event', 'web', NULL, NULL),
(165, 'view-event', 'web', NULL, NULL),
(166, 'store-event', 'web', NULL, NULL),
(167, 'edit-event', 'web', NULL, NULL),
(168, 'delete-event', 'web', NULL, NULL),
(169, 'role', 'web', NULL, NULL),
(170, 'view-role', 'web', NULL, NULL),
(171, 'store-role', 'web', NULL, NULL),
(172, 'edit-role', 'web', NULL, NULL),
(173, 'delete-role', 'web', NULL, NULL),
(174, 'assign-module', 'web', NULL, NULL),
(175, 'assign-role', 'web', NULL, NULL),
(176, 'assign-ticket', 'web', NULL, NULL),
(177, 'assign-project', 'web', NULL, NULL),
(178, 'assign-task', 'web', NULL, NULL),
(179, 'finance', 'web', NULL, NULL),
(180, 'account', 'web', NULL, NULL),
(181, 'view-account', 'web', NULL, NULL),
(182, 'store-account', 'web', NULL, NULL),
(183, 'edit-account', 'web', NULL, NULL),
(184, 'delete-account', 'web', NULL, NULL),
(185, 'view-transaction', 'web', NULL, NULL),
(186, 'view-balance_transfer', 'web', NULL, NULL),
(187, 'store-balance_transfer', 'web', NULL, NULL),
(188, 'expense', 'web', NULL, NULL),
(189, 'view-expense', 'web', NULL, NULL),
(190, 'store-expense', 'web', NULL, NULL),
(191, 'edit-expense', 'web', NULL, NULL),
(192, 'delete-expense', 'web', NULL, NULL),
(193, 'deposit', 'web', NULL, NULL),
(194, 'view-deposit', 'web', NULL, NULL),
(195, 'store-deposit', 'web', NULL, NULL),
(196, 'edit-deposit', 'web', NULL, NULL),
(197, 'delete-deposit', 'web', NULL, NULL),
(198, 'payer', 'web', NULL, NULL),
(199, 'view-payer', 'web', NULL, NULL),
(200, 'store-payer', 'web', NULL, NULL),
(201, 'edit-payer', 'web', NULL, NULL),
(202, 'delete-payer', 'web', NULL, NULL),
(203, 'payee', 'web', NULL, NULL),
(204, 'view-payee', 'web', NULL, NULL),
(205, 'store-payee', 'web', NULL, NULL),
(206, 'edit-payee', 'web', NULL, NULL),
(207, 'delete-payee', 'web', NULL, NULL),
(208, 'training_module', 'web', NULL, NULL),
(209, 'trainer', 'web', NULL, NULL),
(210, 'view-trainer', 'web', NULL, NULL),
(211, 'store-trainer', 'web', NULL, NULL),
(212, 'edit-trainer', 'web', NULL, NULL),
(213, 'delete-trainer', 'web', NULL, NULL),
(214, 'training', 'web', NULL, NULL),
(215, 'view-training', 'web', NULL, NULL),
(216, 'store-training', 'web', NULL, NULL),
(217, 'edit-training', 'web', NULL, NULL),
(218, 'delete-training', 'web', NULL, NULL),
(219, 'access-module', 'web', NULL, NULL),
(220, 'access-variable_type', 'web', NULL, NULL),
(221, 'access-variable_method', 'web', NULL, NULL),
(222, 'access-language', 'web', NULL, NULL),
(223, 'announcement', 'web', NULL, NULL),
(224, 'store-announcement', 'web', NULL, NULL),
(225, 'edit-announcement', 'web', NULL, NULL),
(226, 'delete-announcement', 'web', NULL, NULL),
(227, 'company', 'web', NULL, NULL),
(228, 'view-company', 'web', NULL, NULL),
(229, 'store-company', 'web', NULL, NULL),
(230, 'edit-company', 'web', NULL, NULL),
(231, 'delete-company', 'web', NULL, NULL),
(232, 'department', 'web', NULL, NULL),
(233, 'view-department', 'web', NULL, NULL),
(234, 'store-department', 'web', NULL, NULL),
(235, 'edit-department', 'web', NULL, NULL),
(236, 'delete-department', 'web', NULL, NULL),
(237, 'designation', 'web', NULL, NULL),
(238, 'view-designation', 'web', NULL, NULL),
(239, 'store-designation', 'web', NULL, NULL),
(240, 'edit-designation', 'web', NULL, NULL),
(241, 'delete-designation', 'web', NULL, NULL),
(242, 'location', 'web', NULL, NULL),
(243, 'view-location', 'web', NULL, NULL),
(244, 'store-location', 'web', NULL, NULL),
(245, 'edit-location', 'web', NULL, NULL),
(246, 'delete-location', 'web', NULL, NULL),
(247, 'policy', 'web', NULL, NULL),
(248, 'store-policy', 'web', NULL, NULL),
(249, 'edit-policy', 'web', NULL, NULL),
(250, 'delete-policy', 'web', NULL, NULL),
(251, 'view-cms', 'web', NULL, NULL),
(252, 'store-cms', 'web', NULL, NULL),
(253, 'store-user', 'web', NULL, NULL),
(254, 'delete-attendance', 'web', NULL, NULL),
(255, 'view-leave', 'web', NULL, NULL),
(256, 'store-leave', 'web', NULL, NULL),
(257, 'edit-leave', 'web', NULL, NULL),
(258, 'delete-leave', 'web', NULL, NULL),
(259, 'cms', 'web', NULL, NULL),
(260, 'performance', 'web', NULL, NULL),
(261, 'goal-type', 'web', NULL, NULL),
(262, 'view-goal-type', 'web', NULL, NULL),
(263, 'store-goal-type', 'web', NULL, NULL),
(264, 'edit-goal-type', 'web', NULL, NULL),
(265, 'delete-goal-type', 'web', NULL, NULL),
(266, 'goal-tracking', 'web', NULL, NULL),
(267, 'view-goal-tracking', 'web', NULL, NULL),
(268, 'store-goal-tracking', 'web', NULL, NULL),
(269, 'edit-goal-tracking', 'web', NULL, NULL),
(270, 'delete-goal-tracking', 'web', NULL, NULL),
(271, 'indicator', 'web', NULL, NULL),
(272, 'view-indicator', 'web', NULL, NULL),
(273, 'store-indicator', 'web', NULL, NULL),
(274, 'edit-indicator', 'web', NULL, NULL),
(275, 'delete-indicator', 'web', NULL, NULL),
(276, 'appraisal', 'web', NULL, NULL),
(277, 'view-appraisal', 'web', NULL, NULL),
(278, 'store-appraisal', 'web', NULL, NULL),
(279, 'edit-appraisal', 'web', NULL, NULL),
(280, 'delete-appraisal', 'web', NULL, NULL),
(281, 'assets-and-category', 'web', NULL, NULL),
(282, 'category', 'web', NULL, NULL),
(283, 'view-assets-category', 'web', NULL, NULL),
(284, 'store-assets-category', 'web', NULL, NULL),
(285, 'edit-assets-category', 'web', NULL, NULL),
(286, 'delete-assets-category', 'web', NULL, NULL),
(287, 'assets', 'web', NULL, NULL),
(288, 'view-assets', 'web', NULL, NULL),
(289, 'store-assets', 'web', NULL, NULL),
(290, 'edit-assets', 'web', NULL, NULL),
(291, 'delete-assets', 'web', NULL, NULL),
(292, 'daily-attendances', 'web', NULL, NULL),
(293, 'date-wise-attendances', 'web', NULL, NULL),
(294, 'monthly-attendances', 'web', NULL, NULL),
(295, 'set-permission', 'web', NULL, NULL),
(296, 'get-leave-notification', 'web', NULL, NULL),
(297, 'report-pension', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `policies`
--

CREATE TABLE `policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` longtext DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `added_by` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `policies`
--

INSERT INTO `policies` (`id`, `title`, `description`, `company_id`, `added_by`, `created_at`, `updated_at`) VALUES
(2, 'No smoking', 'No smoking during the office hours.Smoke in the smoking zone if you really have to', 1, 'ash', '2020-07-27 09:56:24', '2020-07-27 09:56:24'),
(3, 'No Social Media', 'You can not use any  social media.', 1, 'admin', '2023-02-01 07:30:21', '2023-02-01 07:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `project_priority` varchar(40) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `summary` mediumtext DEFAULT NULL,
  `project_status` varchar(40) NOT NULL DEFAULT 'not started',
  `project_note` longtext DEFAULT NULL,
  `project_progress` varchar(191) DEFAULT NULL,
  `is_notify` tinyint(4) DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `client_id`, `company_id`, `start_date`, `end_date`, `project_priority`, `description`, `summary`, `project_status`, `project_note`, `project_progress`, `is_notify`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Test1', NULL, 1, '2021-03-29', '2021-04-02', 'medium', '&lt;ul&gt;\r\n&lt;li&gt;Section 2: Functional Objectives&lt;br /&gt;Each objective gives a desired behavior for the system, a business justification, and a measure to determine if the final system has successfully met the objective. These objectives are organized by priority. In order for the new system to be considered successful, all high priority objectives must be met.&lt;/li&gt;\r\n&lt;li&gt;Section 3: Non-Functional Objectives&lt;br /&gt;This section is organized by category. Each objective specifies a technical requirement or constraint on the overall characteristics of the system. Each objective is measurable.&lt;/li&gt;\r\n&lt;li&gt;Section 4: Context Model&lt;br /&gt;This section gives a text description of the goal of the system, and a pictorial description of the scope of the system in a context diagram. Those entities outside the system that interact with the system are described.&lt;/li&gt;\r\n&lt;/ul&gt;', 'tinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will', 'in_progress', 'Note', '36', NULL, NULL, '2020-07-28 14:58:29', '2020-11-02 02:47:03'),
(3, 'test3', NULL, 1, '2021-03-31', '2021-04-04', 'high', '&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;ul&gt;\r\n&lt;li&gt;&lt;strong&gt;A sales agent should be able to use the system in his job after x days of training.&lt;/strong&gt;&lt;/li&gt;\r\n&lt;li&gt;&lt;strong&gt;A user who already knows what product he is interested in should be able to locate and view that page in x seconds.&lt;/strong&gt;&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '', 'not_started', NULL, '55', NULL, NULL, '2020-08-03 09:26:42', '2020-11-02 02:51:05'),
(4, 'Test', NULL, 1, '2023-02-21', '2023-02-22', 'medium', '&lt;p&gt;Test&lt;/p&gt;', '', 'not started', NULL, NULL, NULL, NULL, '2023-02-09 05:02:21', '2023-02-09 05:02:21');

-- --------------------------------------------------------

--
-- Table structure for table `project_bugs`
--

CREATE TABLE `project_bugs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` mediumtext NOT NULL,
  `bug_attachment` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_discussions`
--

CREATE TABLE `project_discussions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `project_discussion` mediumtext NOT NULL,
  `discussion_attachment` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_discussions`
--

INSERT INTO `project_discussions` (`id`, `project_id`, `user_id`, `project_discussion`, `discussion_attachment`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Hola', '', '2020-07-28 15:12:38', '2020-07-28 15:12:38');

-- --------------------------------------------------------

--
-- Table structure for table `project_files`
--

CREATE TABLE `project_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `file_title` varchar(191) NOT NULL,
  `file_attachment` varchar(191) NOT NULL,
  `file_description` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promotion_title` varchar(40) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `promotion_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `promotion_title`, `description`, `company_id`, `employee_id`, `promotion_date`, `created_at`, `updated_at`) VALUES
(1, 'Senior Executive 1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s', 1, 9, '2023-01-31', '2020-07-27 10:04:35', '2023-01-04 05:11:31');

-- --------------------------------------------------------

--
-- Table structure for table `qualification_education_levels`
--

CREATE TABLE `qualification_education_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualification_education_levels`
--

INSERT INTO `qualification_education_levels` (`id`, `company_id`, `name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'BSC', '2020-07-27 03:54:02', '2020-07-27 03:54:02'),
(2, NULL, 'Diploma', '2020-07-27 03:54:06', '2020-07-27 03:54:06'),
(3, NULL, 'BBA', '2020-07-27 03:54:14', '2020-07-27 03:54:14');

-- --------------------------------------------------------

--
-- Table structure for table `qualification_languages`
--

CREATE TABLE `qualification_languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualification_languages`
--

INSERT INTO `qualification_languages` (`id`, `company_id`, `name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'English', '2020-10-20 03:32:36', '2020-10-20 03:32:36'),
(2, NULL, 'Arabic', '2020-10-20 03:32:44', '2020-10-20 03:32:44');

-- --------------------------------------------------------

--
-- Table structure for table `qualification_skills`
--

CREATE TABLE `qualification_skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualification_skills`
--

INSERT INTO `qualification_skills` (`id`, `company_id`, `name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'MS Word', '2020-10-20 03:32:54', '2020-10-20 03:32:54'),
(2, NULL, 'Photoshop', '2020-10-20 03:33:02', '2020-10-20 03:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `relation_types`
--

CREATE TABLE `relation_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `relation_types`
--

INSERT INTO `relation_types` (`id`, `type_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Self', '2024-07-22 15:55:26', '2024-07-22 16:41:26', NULL),
(2, 'Parent', '2024-07-22 15:55:49', '2024-07-22 16:47:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `resignations`
--

CREATE TABLE `resignations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notice_date` date DEFAULT NULL,
  `resignation_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resignations`
--

INSERT INTO `resignations` (`id`, `description`, `company_id`, `department_id`, `employee_id`, `notice_date`, `resignation_date`, `created_at`, `updated_at`) VALUES
(1, 'Sed ut cc unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo', 1, 3, 12, '2021-04-01', '2021-04-08', '2020-07-27 16:54:41', '2020-07-27 17:13:23'),
(10, '', 1, 1, 54, '2023-02-13', '2023-02-14', '2023-02-14 09:00:38', '2023-02-14 09:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', 'Can access and change everything', 1, NULL, NULL),
(2, 'employee', 'web', 'Default access', 1, '2020-07-26 13:50:45', '2020-07-26 13:50:45'),
(3, 'client', 'web', 'When you create a client, this role and associated.', 1, '2020-10-08 03:10:23', '2020-10-08 03:10:23'),
(4, 'Manager', 'web', 'Can Manage', 1, '2021-02-24 10:24:58', '2021-02-24 10:24:58'),
(5, 'Editor', 'web', 'Custom access', 1, '2021-02-24 10:24:58', '2021-02-24 10:24:58'),
(6, 'HR', 'web', '', 1, '2021-09-05 03:12:28', '2021-09-05 03:12:28'),
(8, 'supperadmin', 'web', '', 1, '2025-01-28 07:14:32', '2025-01-28 07:14:32');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 5),
(1, 6),
(1, 8),
(2, 5),
(2, 6),
(2, 8),
(3, 5),
(3, 6),
(3, 8),
(4, 5),
(4, 6),
(4, 8),
(5, 5),
(5, 6),
(5, 8),
(6, 5),
(6, 6),
(6, 8),
(7, 4),
(7, 5),
(7, 6),
(7, 8),
(8, 4),
(8, 5),
(8, 6),
(8, 8),
(9, 5),
(9, 6),
(9, 8),
(10, 5),
(10, 6),
(10, 8),
(11, 5),
(11, 6),
(11, 8),
(13, 5),
(13, 6),
(13, 8),
(14, 5),
(14, 6),
(14, 8),
(15, 5),
(15, 6),
(15, 8),
(16, 5),
(16, 6),
(16, 8),
(17, 5),
(17, 6),
(17, 8),
(18, 5),
(18, 6),
(18, 8),
(20, 5),
(20, 6),
(20, 8),
(21, 5),
(21, 6),
(21, 8),
(22, 5),
(22, 6),
(22, 8),
(23, 5),
(23, 6),
(23, 8),
(24, 5),
(24, 6),
(24, 8),
(25, 5),
(25, 6),
(25, 8),
(26, 5),
(26, 6),
(26, 8),
(27, 5),
(27, 6),
(27, 8),
(28, 5),
(28, 6),
(28, 8),
(29, 5),
(29, 6),
(29, 8),
(30, 5),
(30, 6),
(30, 8),
(31, 5),
(31, 6),
(31, 8),
(32, 5),
(32, 6),
(32, 8),
(33, 5),
(33, 6),
(33, 8),
(34, 5),
(34, 6),
(34, 8),
(35, 5),
(35, 6),
(35, 8),
(36, 5),
(36, 6),
(36, 8),
(37, 5),
(37, 6),
(37, 8),
(38, 5),
(38, 6),
(38, 8),
(39, 5),
(39, 6),
(39, 8),
(41, 5),
(41, 6),
(41, 8),
(42, 5),
(42, 6),
(42, 8),
(43, 5),
(43, 6),
(43, 8),
(44, 5),
(44, 6),
(44, 8),
(46, 5),
(46, 6),
(46, 8),
(47, 5),
(47, 6),
(47, 8),
(48, 5),
(48, 6),
(48, 8),
(49, 5),
(49, 6),
(49, 8),
(50, 5),
(50, 6),
(50, 8),
(51, 5),
(51, 6),
(51, 8),
(52, 5),
(52, 6),
(52, 8),
(53, 5),
(53, 6),
(53, 8),
(54, 5),
(54, 6),
(54, 8),
(55, 5),
(55, 6),
(55, 8),
(56, 5),
(56, 6),
(56, 8),
(57, 5),
(57, 6),
(57, 8),
(58, 5),
(58, 6),
(58, 8),
(59, 5),
(59, 6),
(59, 8),
(60, 5),
(60, 6),
(60, 8),
(61, 5),
(61, 6),
(61, 8),
(62, 2),
(62, 4),
(62, 5),
(62, 6),
(62, 8),
(63, 4),
(63, 5),
(63, 6),
(63, 8),
(64, 4),
(64, 5),
(64, 6),
(64, 8),
(65, 5),
(65, 6),
(65, 8),
(66, 5),
(66, 6),
(66, 8),
(67, 5),
(67, 6),
(67, 8),
(68, 5),
(68, 6),
(68, 8),
(69, 5),
(69, 6),
(69, 8),
(70, 5),
(70, 6),
(70, 8),
(71, 5),
(71, 6),
(71, 8),
(72, 5),
(72, 6),
(72, 8),
(73, 5),
(73, 6),
(73, 8),
(74, 5),
(74, 6),
(74, 8),
(75, 5),
(75, 6),
(75, 8),
(76, 2),
(76, 4),
(76, 5),
(76, 6),
(76, 8),
(81, 5),
(81, 8),
(82, 5),
(82, 8),
(83, 5),
(83, 8),
(84, 5),
(84, 8),
(85, 5),
(85, 8),
(86, 5),
(86, 8),
(87, 5),
(87, 8),
(90, 5),
(90, 8),
(91, 5),
(91, 8),
(92, 5),
(92, 8),
(93, 5),
(93, 8),
(94, 5),
(94, 8),
(95, 5),
(95, 8),
(96, 5),
(96, 8),
(97, 5),
(97, 8),
(98, 5),
(98, 8),
(104, 5),
(104, 8),
(105, 5),
(105, 8),
(106, 5),
(106, 8),
(107, 5),
(107, 8),
(108, 5),
(108, 8),
(109, 5),
(109, 8),
(110, 5),
(110, 8),
(112, 5),
(112, 8),
(113, 5),
(113, 8),
(114, 5),
(114, 8),
(115, 5),
(115, 8),
(116, 5),
(116, 8),
(117, 5),
(117, 8),
(118, 5),
(118, 8),
(119, 5),
(119, 8),
(120, 5),
(120, 8),
(121, 5),
(121, 8),
(122, 5),
(122, 8),
(123, 5),
(123, 8),
(124, 5),
(124, 8),
(125, 5),
(125, 8),
(126, 5),
(126, 8),
(127, 5),
(127, 8),
(128, 5),
(128, 8),
(129, 5),
(129, 8),
(130, 5),
(130, 8),
(131, 5),
(131, 8),
(132, 5),
(132, 8),
(133, 5),
(133, 8),
(134, 5),
(134, 8),
(135, 5),
(135, 8),
(136, 5),
(136, 8),
(137, 5),
(137, 8),
(138, 5),
(138, 8),
(139, 5),
(139, 8),
(140, 5),
(140, 8),
(141, 5),
(141, 8),
(142, 5),
(142, 8),
(144, 5),
(144, 6),
(144, 8),
(145, 5),
(145, 6),
(145, 8),
(146, 4),
(146, 5),
(146, 8),
(147, 4),
(147, 5),
(147, 8),
(148, 4),
(148, 5),
(148, 8),
(149, 5),
(149, 8),
(150, 5),
(150, 8),
(151, 5),
(151, 8),
(152, 5),
(152, 8),
(153, 5),
(153, 8),
(154, 5),
(154, 8),
(156, 5),
(156, 8),
(157, 5),
(157, 8),
(158, 5),
(158, 8),
(159, 5),
(159, 8),
(160, 5),
(160, 8),
(161, 5),
(161, 8),
(162, 5),
(162, 8),
(163, 5),
(163, 8),
(164, 5),
(164, 8),
(165, 5),
(165, 8),
(166, 5),
(166, 8),
(167, 5),
(167, 8),
(168, 5),
(168, 8),
(169, 5),
(169, 6),
(169, 8),
(170, 5),
(170, 6),
(170, 8),
(171, 5),
(171, 6),
(171, 8),
(172, 5),
(172, 6),
(172, 8),
(173, 5),
(173, 6),
(173, 8),
(176, 5),
(176, 8),
(177, 5),
(177, 8),
(178, 5),
(178, 8),
(179, 5),
(180, 5),
(181, 5),
(182, 5),
(183, 5),
(184, 5),
(185, 5),
(186, 5),
(187, 5),
(188, 5),
(189, 5),
(190, 5),
(191, 5),
(192, 5),
(193, 5),
(194, 5),
(195, 5),
(196, 5),
(197, 5),
(198, 5),
(199, 5),
(200, 5),
(201, 5),
(202, 5),
(203, 5),
(204, 5),
(205, 5),
(206, 5),
(207, 5),
(208, 5),
(208, 8),
(209, 5),
(209, 8),
(210, 5),
(210, 8),
(211, 5),
(211, 8),
(212, 5),
(212, 8),
(213, 5),
(213, 8),
(214, 5),
(214, 8),
(215, 5),
(215, 8),
(216, 5),
(216, 8),
(217, 5),
(217, 8),
(218, 5),
(218, 8),
(220, 5),
(220, 6),
(220, 8),
(221, 5),
(221, 6),
(221, 8),
(222, 5),
(222, 6),
(222, 8),
(223, 5),
(223, 8),
(224, 5),
(224, 8),
(225, 5),
(225, 8),
(226, 5),
(226, 8),
(227, 5),
(227, 8),
(228, 5),
(228, 8),
(229, 5),
(229, 8),
(230, 5),
(230, 8),
(231, 5),
(231, 8),
(232, 5),
(232, 8),
(233, 5),
(233, 8),
(234, 5),
(234, 8),
(235, 5),
(235, 8),
(236, 5),
(236, 8),
(237, 5),
(237, 8),
(238, 5),
(238, 8),
(239, 5),
(239, 8),
(240, 5),
(240, 8),
(241, 5),
(241, 8),
(242, 5),
(242, 8),
(243, 5),
(243, 8),
(244, 5),
(244, 8),
(245, 5),
(245, 8),
(246, 5),
(246, 8),
(247, 5),
(247, 8),
(248, 5),
(248, 8),
(249, 5),
(249, 8),
(250, 5),
(250, 8),
(251, 5),
(251, 8),
(252, 5),
(252, 8),
(253, 5),
(253, 6),
(253, 8),
(254, 5),
(254, 6),
(254, 8),
(255, 2),
(255, 4),
(255, 5),
(255, 6),
(255, 8),
(256, 5),
(256, 6),
(256, 8),
(257, 4),
(257, 5),
(257, 6),
(257, 8),
(258, 5),
(258, 6),
(258, 8),
(259, 5),
(259, 8),
(260, 5),
(260, 8),
(261, 5),
(261, 8),
(262, 5),
(262, 8),
(263, 5),
(263, 8),
(264, 5),
(264, 8),
(265, 5),
(265, 8),
(266, 5),
(266, 8),
(267, 5),
(267, 8),
(268, 5),
(268, 8),
(269, 5),
(269, 8),
(270, 5),
(270, 8),
(271, 5),
(271, 8),
(272, 5),
(272, 8),
(273, 5),
(273, 8),
(274, 5),
(274, 8),
(275, 5),
(275, 8),
(276, 5),
(276, 8),
(277, 5),
(277, 8),
(278, 5),
(278, 8),
(279, 5),
(279, 8),
(280, 5),
(280, 8),
(281, 5),
(282, 5),
(283, 5),
(284, 5),
(285, 5),
(286, 5),
(287, 5),
(288, 5),
(289, 5),
(290, 5),
(291, 5),
(292, 5),
(292, 8),
(293, 5),
(293, 8),
(294, 5),
(294, 8),
(295, 5),
(295, 6),
(295, 8),
(296, 2),
(296, 4),
(296, 5),
(296, 6),
(296, 8),
(297, 5),
(297, 8);

-- --------------------------------------------------------

--
-- Table structure for table `salary_allowances`
--

CREATE TABLE `salary_allowances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `month_year` varchar(191) NOT NULL,
  `first_date` date DEFAULT NULL,
  `allowance_title` varchar(191) NOT NULL,
  `allowance_amount` varchar(191) NOT NULL,
  `is_taxable` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_allowances`
--

INSERT INTO `salary_allowances` (`id`, `employee_id`, `month_year`, `first_date`, `allowance_title`, `allowance_amount`, `is_taxable`, `created_at`, `updated_at`) VALUES
(1, 11, 'January-2021', '2021-01-01', 'Home', '200', 0, '2020-07-29 16:10:53', '2020-07-29 16:10:53'),
(2, 11, 'January-2021', '2021-01-01', 'Tea', '50', 0, '2020-07-29 18:08:42', '2020-07-29 18:08:42'),
(3, 12, 'January-2021', '2021-01-01', 'Snacks', '50', 0, '2020-10-20 04:01:55', '2020-10-20 04:01:55'),
(4, 12, 'January-2021', '2021-01-01', 'Transport', '60', 0, '2020-10-20 04:02:25', '2020-10-20 04:02:25'),
(5, 9, 'January-2021', '2021-01-01', 'xyz', '75', 1, '2021-01-25 19:01:56', '2021-04-09 01:37:55'),
(8, 10, 'January-2021', '2021-01-01', 'Tea', '10', 0, '2021-01-27 00:40:48', '2021-01-27 00:40:48'),
(9, 10, 'January-2021', '2021-01-01', 'Snacks', '50', 0, '2021-01-27 00:40:58', '2021-01-27 00:40:58'),
(10, 13, 'January-2021', '2021-01-01', 'Home', '100', 0, '2021-01-27 01:11:57', '2021-01-27 01:11:57'),
(11, 13, 'January-2021', '2021-01-01', 'Tea', '20', 0, '2021-01-27 01:12:09', '2021-01-27 01:12:09'),
(12, 14, 'January-2021', '2021-01-01', 'Tea', '10', 0, '2021-01-27 01:34:45', '2021-01-27 01:34:45'),
(13, 9, 'April-2021', '2021-04-01', 'Tea', '50', 0, '2021-04-09 00:35:35', '2021-04-09 01:47:08'),
(14, 9, 'April-2021', '2021-04-01', 'Coffee', '50', 0, '2021-04-09 01:39:02', '2021-04-09 01:47:22'),
(15, 9, 'August-2021', '2021-08-01', 'Milk', '200', 0, '2021-04-09 05:38:21', '2021-04-09 05:38:21'),
(16, 11, 'October-2022', '2022-10-01', 'Transportation', '10', 0, '2022-10-18 15:17:19', '2022-10-18 15:17:19'),
(17, 11, 'October-2022', '2022-10-01', 'Communication', '10', 0, '2022-10-18 15:17:44', '2022-10-18 15:17:44');

-- --------------------------------------------------------

--
-- Table structure for table `salary_basics`
--

CREATE TABLE `salary_basics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `month_year` varchar(191) NOT NULL,
  `first_date` date DEFAULT NULL,
  `payslip_type` varchar(191) NOT NULL,
  `basic_salary` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_basics`
--

INSERT INTO `salary_basics` (`id`, `employee_id`, `month_year`, `first_date`, `payslip_type`, `basic_salary`, `created_at`, `updated_at`) VALUES
(1, 9, 'January-2021', '2021-01-01', 'Monthly', 500, NULL, '2022-02-27 06:44:40'),
(2, 9, 'April-2021', '2021-04-01', 'Monthly', 700, NULL, '2022-02-27 06:45:00'),
(3, 9, 'February-2021', '2021-02-01', 'Monthly', 10, '2021-04-06 01:29:14', '2022-02-27 06:44:50'),
(4, 15, 'March-2021', '2021-03-01', 'Monthly', 100, '2021-04-06 03:58:59', '2021-04-06 04:36:34'),
(6, 15, 'April-2021', '2021-04-01', 'Monthly', 200, '2021-04-06 04:17:33', '2021-04-06 05:06:44'),
(8, 10, 'March-2021', '2021-03-01', 'Monthly', 200, '2021-04-08 15:10:23', '2021-04-08 15:10:42'),
(9, 10, 'February-2021', '2021-02-01', 'Monthly', 150, '2021-04-08 15:12:21', '2021-04-08 15:12:21'),
(10, 11, 'January-2021', '2021-01-01', 'Hourly', 100, '2021-04-08 15:14:20', '2021-04-08 15:14:20'),
(11, 12, 'January-2021', '2021-01-01', 'Monthly', 100, '2021-04-08 15:14:48', '2021-04-08 15:14:48'),
(12, 13, 'January-2021', '2021-01-01', 'Monthly', 100, '2021-04-08 15:15:05', '2021-04-08 15:15:05'),
(13, 14, 'January-2021', '2021-01-01', 'Monthly', 100, '2021-04-08 15:15:23', '2021-04-08 15:15:23'),
(14, 27, 'January-2021', '2021-01-01', 'Monthly', 100, '2021-04-08 15:15:53', '2021-04-08 15:15:53'),
(15, 34, 'January-2021', '2021-01-01', 'Monthly', 100, '2021-04-08 15:16:21', '2021-04-08 15:16:21'),
(16, 38, 'January-2021', '2021-01-01', 'Monthly', 100, '2021-04-08 15:16:38', '2021-04-08 15:16:38'),
(23, 9, 'July-2021', '2021-07-01', 'Monthly', 500, '2021-07-17 01:16:42', '2022-02-27 06:45:12'),
(24, 49, 'February-2022', '2022-02-01', 'Monthly', 10, '2022-02-26 07:29:12', '2022-02-26 07:29:12'),
(25, 11, 'October-2022', '2022-10-01', 'Monthly', 100, '2022-10-18 15:15:31', '2022-10-18 15:15:31'),
(26, 54, 'January-2023', '2023-01-01', 'Monthly', 500, '2023-02-14 06:52:48', '2023-02-14 06:52:48'),
(27, 9, 'January-2024', '2024-01-01', 'Monthly', 100, '2024-01-15 06:09:50', '2024-01-15 06:09:50'),
(28, 13, 'April-2024', '2024-04-01', 'Monthly', 100, '2024-04-25 11:43:05', '2024-04-25 11:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `salary_commissions`
--

CREATE TABLE `salary_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `month_year` varchar(191) NOT NULL,
  `commission_title` varchar(191) NOT NULL,
  `first_date` date DEFAULT NULL,
  `commission_amount` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_commissions`
--

INSERT INTO `salary_commissions` (`id`, `employee_id`, `month_year`, `commission_title`, `first_date`, `commission_amount`, `created_at`, `updated_at`) VALUES
(1, 11, 'January-2021', 'Sale', '2021-01-01', '20', '2020-07-29 18:13:30', '2020-07-29 18:13:30'),
(2, 12, 'January-2021', 'Sale Increase', '2021-01-01', '15', '2020-10-20 04:04:58', '2020-10-20 04:04:58'),
(13, 12, 'January-2021', 'Work Rate', '2021-01-01', '10', '2020-10-20 04:39:15', '2020-10-20 04:39:15'),
(17, 10, 'January-2021', 'Sale', '2021-01-01', '50', '2021-01-27 01:04:32', '2021-01-27 01:04:32'),
(18, 13, 'January-2021', 'Sale', '2021-01-01', '20', '2021-01-27 01:12:55', '2021-01-27 01:12:55'),
(19, 14, 'January-2021', 'Sale', '2021-01-01', '10', '2021-01-27 01:35:16', '2021-01-27 01:35:16'),
(20, 9, 'January-2021', 'Sale', '2021-01-01', '100', '2021-04-09 15:36:18', '2021-04-09 15:44:58'),
(21, 9, 'April-2021', 'Performance', '2021-04-01', '200', '2021-04-09 15:42:48', '2021-04-09 15:42:48'),
(22, 9, 'April-2021', 'XYZ', '2021-04-01', '50', '2021-04-09 16:01:54', '2021-04-09 16:01:54');

-- --------------------------------------------------------

--
-- Table structure for table `salary_deductions`
--

CREATE TABLE `salary_deductions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `month_year` varchar(50) NOT NULL,
  `first_date` date DEFAULT NULL,
  `deduction_title` varchar(191) NOT NULL,
  `deduction_amount` varchar(191) NOT NULL,
  `deduction_type_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_deductions`
--

INSERT INTO `salary_deductions` (`id`, `employee_id`, `month_year`, `first_date`, `deduction_title`, `deduction_amount`, `deduction_type_id`, `created_at`, `updated_at`) VALUES
(1, 11, 'January-2021', '2021-01-01', 'Test', '10', 1, '2020-07-29 18:21:22', '2020-07-29 18:21:22'),
(2, 12, 'January-2021', '2021-01-01', 'Development tax', '5', 1, '2020-10-20 04:50:01', '2020-10-20 04:50:01'),
(5, 10, 'January-2021', '2021-01-01', 'Testing', '50', 1, '2021-01-27 00:43:37', '2021-01-27 00:43:37'),
(6, 13, 'January-2021', '2021-01-01', 'Health', '100', 1, '2021-01-27 01:13:31', '2021-01-27 01:13:31'),
(7, 14, 'January-2021', '2021-01-01', 'Health', '10', 1, '2021-01-27 01:35:37', '2021-01-27 01:35:37'),
(8, 9, 'January-2021', '2021-01-01', 'Tax', '20', 1, '2021-04-10 12:55:34', '2021-04-10 12:55:34'),
(10, 9, 'April-2021', '2021-04-01', 'Fever', '100', 1, '2021-04-10 13:16:30', '2021-04-10 13:16:30'),
(11, 11, 'October-2022', '2022-10-01', 'Medical', '15', 1, '2022-10-18 15:19:18', '2022-10-18 15:19:18');

-- --------------------------------------------------------

--
-- Table structure for table `salary_loans`
--

CREATE TABLE `salary_loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `month_year` varchar(50) NOT NULL,
  `first_date` date DEFAULT NULL,
  `loan_title` varchar(191) NOT NULL,
  `loan_amount` varchar(191) NOT NULL,
  `loan_type_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `loan_time` varchar(191) NOT NULL,
  `amount_remaining` varchar(191) NOT NULL,
  `time_remaining` varchar(191) NOT NULL,
  `monthly_payable` varchar(50) NOT NULL,
  `reason` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_loans`
--

INSERT INTO `salary_loans` (`id`, `employee_id`, `month_year`, `first_date`, `loan_title`, `loan_amount`, `loan_type_id`, `loan_time`, `amount_remaining`, `time_remaining`, `monthly_payable`, `reason`, `created_at`, `updated_at`) VALUES
(7, 38, 'February-2021', '2021-02-01', '', '100', 1, '4', '50', '2', '25.000', 'Health', '2021-04-11 04:50:18', '2021-04-14 16:17:30'),
(8, 11, 'March-2021', '2021-03-01', '', '100', 1, '4', '0', '0', '0', 'Make House', '2021-04-11 12:43:20', '2023-04-15 07:58:00'),
(9, 11, 'October-2022', '2022-10-01', '', '50', 1, '1', '0', '0', '0', '', '2022-10-18 15:18:13', '2023-04-15 07:58:00'),
(14, 12, 'October-2022', '2022-10-01', '', '20', 1, '2', '0', '0', '0', '', '2022-10-26 09:15:25', '2022-10-26 09:17:07'),
(15, 9, 'July-2024', '2024-07-01', 'test', '20', 3, '4', '20', '4', '5.000', 'test', '2024-07-23 05:19:49', '2024-07-23 05:25:04');

-- --------------------------------------------------------

--
-- Table structure for table `salary_other_payments`
--

CREATE TABLE `salary_other_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `month_year` varchar(50) NOT NULL DEFAULT '',
  `first_date` date DEFAULT NULL,
  `other_payment_title` varchar(191) NOT NULL,
  `other_payment_amount` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_other_payments`
--

INSERT INTO `salary_other_payments` (`id`, `employee_id`, `month_year`, `first_date`, `other_payment_title`, `other_payment_amount`, `created_at`, `updated_at`) VALUES
(1, 12, 'January-2021', '2021-01-01', 'Pefomance Bonus', '15', '2020-10-20 04:54:43', '2020-10-20 04:55:44'),
(2, 9, 'January-2021', '2021-01-01', 'Clean', '150', '2021-04-10 15:05:16', '2021-04-10 15:05:16'),
(3, 9, 'April-2021', '2021-04-01', 'abc', '50', '2021-04-10 15:06:18', '2021-04-10 15:06:18'),
(4, 9, 'April-2021', '2021-04-01', 'xyz', '50', '2021-04-10 15:22:47', '2021-04-10 15:22:47'),
(5, 11, 'October-2022', '2022-10-01', 'Reimbursement', '11', '2022-10-18 15:19:39', '2022-10-18 15:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `salary_overtimes`
--

CREATE TABLE `salary_overtimes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `month_year` varchar(50) NOT NULL,
  `first_date` date DEFAULT NULL,
  `overtime_title` varchar(191) NOT NULL,
  `no_of_days` varchar(191) NOT NULL,
  `overtime_hours` varchar(191) NOT NULL,
  `overtime_rate` varchar(191) NOT NULL,
  `overtime_amount` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_overtimes`
--

INSERT INTO `salary_overtimes` (`id`, `employee_id`, `month_year`, `first_date`, `overtime_title`, `no_of_days`, `overtime_hours`, `overtime_rate`, `overtime_amount`, `created_at`, `updated_at`) VALUES
(1, 11, '', NULL, 'Test Overtime', '2', '20', '20', '400', '2020-07-29 18:23:33', '2020-07-29 18:23:33'),
(2, 11, '', NULL, 'test overtime 2', '3', '10', '3', '30', '2020-07-29 18:24:20', '2020-07-29 18:24:20'),
(3, 12, '', NULL, 'Night Shift', '5', '10', '5', '50', '2020-10-20 05:00:15', '2020-10-20 05:00:15'),
(4, 12, '', NULL, 'Production Hour', '2', '2', '5', '10', '2020-10-20 05:00:47', '2020-10-20 05:00:47'),
(8, 10, '', NULL, 'Advance Work', '5', '25', '20', '500', '2021-01-27 00:45:01', '2021-01-27 00:45:01'),
(9, 13, '', NULL, 'Advance Work', '5', '20', '10', '200', '2021-01-27 01:14:09', '2021-01-27 01:14:09'),
(10, 14, '', NULL, 'Advance Work', '7', '10', '10', '100', '2021-01-27 01:36:03', '2021-01-27 01:36:03'),
(11, 9, 'January-2021', '2021-01-01', 'Project-1', '2', '10', '5', '50', '2021-04-10 16:47:20', '2021-04-10 16:47:37'),
(12, 9, 'April-2021', '2021-04-01', 'Project-2', '5', '10', '3', '30', '2021-04-10 16:52:35', '2021-04-10 17:08:14'),
(13, 9, 'April-2021', '2021-04-01', 'Project-3', '3', '5', '2', '10', '2021-04-10 16:53:13', '2021-04-10 16:53:13'),
(14, 11, 'October-2022', '2022-10-01', 'OT', '4', '8', '0.5', '4', '2022-10-18 15:20:06', '2022-10-18 15:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status_title` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `status_title`, `created_at`, `updated_at`) VALUES
(1, 'Full-Time', '2020-07-26 20:24:16', '2025-01-28 07:51:44'),
(3, 'Internee', '2020-07-26 20:24:42', '2025-01-28 07:52:09'),
(4, 'Terminated', '2020-07-26 20:24:49', '2025-01-28 07:52:20');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ticket_code` varchar(15) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `ticket_priority` varchar(40) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `ticket_remarks` mediumtext DEFAULT NULL,
  `ticket_status` varchar(40) NOT NULL,
  `ticket_note` varchar(191) DEFAULT NULL,
  `is_notify` tinyint(4) DEFAULT NULL,
  `ticket_attachment` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `company_id`, `department_id`, `employee_id`, `ticket_code`, `subject`, `ticket_priority`, `description`, `ticket_remarks`, `ticket_status`, `ticket_note`, `is_notify`, `ticket_attachment`, `created_at`, `updated_at`) VALUES
(4, 9, 24, 251, '0SAiDKZH', 'Test Support Ticket', 'low', '', NULL, 'pending', 'fix system', NULL, NULL, '2025-01-28 08:24:25', '2025-01-28 08:24:25');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_name` varchar(191) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `task_hour` varchar(40) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `task_status` varchar(40) NOT NULL DEFAULT 'not started',
  `task_note` mediumtext DEFAULT NULL,
  `task_progress` varchar(191) DEFAULT NULL,
  `is_notify` tinyint(4) DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `task_name`, `project_id`, `company_id`, `start_date`, `end_date`, `task_hour`, `description`, `task_status`, `task_note`, `task_progress`, `is_notify`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Test1 Task', 1, 1, '2021-03-29', '2021-04-01', '20', '&lt;table style=&quot;border-collapse: collapse; width: 100%; height: 45px;&quot; border=&quot;1&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr style=&quot;height: 15px;&quot;&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;gsba&lt;/td&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;svnba&lt;/td&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;/tr&gt;\r\n&lt;tr style=&quot;height: 15px;&quot;&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;dfsd&lt;/td&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;dfsf&lt;/td&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;/tr&gt;\r\n&lt;tr style=&quot;height: 15px;&quot;&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td style=&quot;width: 20%; height: 15px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;/tr&gt;\r\n&lt;/tbody&gt;\r\n&lt;/table&gt;', '', NULL, '9', NULL, 1, '2020-07-28 15:14:01', '2020-11-02 01:42:14'),
(3, 'aa', 1, 1, '2021-03-31', '2021-04-02', '16', '&lt;p&gt;new&lt;/p&gt;', 'not started', NULL, NULL, NULL, NULL, '2020-10-11 17:12:09', '2020-11-02 01:49:48'),
(7, 'Mission 95', 1, 1, '2023-01-01', '2023-01-07', '56', '&lt;p&gt;Test&lt;/p&gt;', 'not started', NULL, NULL, NULL, 1, '2023-01-01 07:21:58', '2023-01-01 07:21:58'),
(8, 'Task Title', 1, 1, '2023-02-21', '2023-02-22', '50', '&lt;p&gt;Test&lt;/p&gt;', 'completed', NULL, NULL, NULL, 1, '2023-02-09 05:05:12', '2025-01-28 08:01:04'),
(9, 'Task -  Develope the Apprasial System', 1, 9, '2025-01-28', '2025-01-29', '30', '&lt;p&gt;&lt;br data-mce-bogus=&quot;1&quot;&gt;&lt;/p&gt;', 'ongoing', 'Internal System', '50', NULL, 1, '2025-01-28 07:57:23', '2025-01-28 08:00:04'),
(10, 'Need SEO for Websiet - Amazon Products Links', 1, 9, '2025-01-28', '2025-02-01', '30', '', 'completed', NULL, '75', NULL, 1, '2025-01-28 08:02:54', '2025-01-28 08:03:40');

-- --------------------------------------------------------

--
-- Table structure for table `task_discussions`
--

CREATE TABLE `task_discussions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `task_discussion` mediumtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_discussions`
--

INSERT INTO `task_discussions` (`id`, `task_id`, `user_id`, `task_discussion`, `created_at`, `updated_at`) VALUES
(1, 9, 1, 'should be done today', '2025-01-28 07:58:15', '2025-01-28 07:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `task_files`
--

CREATE TABLE `task_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `file_title` varchar(191) NOT NULL,
  `file_attachment` varchar(191) NOT NULL,
  `file_description` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_files`
--

INSERT INTO `task_files` (`id`, `task_id`, `user_id`, `file_title`, `file_attachment`, `file_description`, `created_at`, `updated_at`) VALUES
(2, 7, NULL, 'Task by Sahiba', 'task_file_1672559303.png', 'Test', '2023-01-01 07:48:23', '2023-01-01 07:48:23');

-- --------------------------------------------------------

--
-- Table structure for table `tax_types`
--

CREATE TABLE `tax_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `rate` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_types`
--

INSERT INTO `tax_types` (`id`, `name`, `rate`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'No tax', '0', 'fixed', 'zero tax', '2020-07-28 16:31:42', '2020-07-28 16:31:42'),
(2, 'Vat', '5', 'percentage', '5% vat for all item', '2020-07-28 16:32:12', '2020-07-28 16:32:12');

-- --------------------------------------------------------

--
-- Table structure for table `terminations`
--

CREATE TABLE `terminations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `terminated_employee` bigint(20) UNSIGNED NOT NULL,
  `termination_type` bigint(20) UNSIGNED DEFAULT NULL,
  `termination_date` date NOT NULL,
  `notice_date` date NOT NULL,
  `status` varchar(40) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `termination_types`
--

CREATE TABLE `termination_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `termination_title` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `termination_types`
--

INSERT INTO `termination_types` (`id`, `termination_title`, `created_at`, `updated_at`) VALUES
(2, 'Performance Termination', '2020-07-26 20:22:27', '2020-07-26 20:22:27');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_comments`
--

CREATE TABLE `ticket_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ticket_comments` mediumtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `expertise` mediumtext NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `first_name`, `last_name`, `email`, `contact_no`, `company_id`, `address`, `expertise`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'Trainer', 'trainer@basepracticesupport.co.uk', '07429682461', 9, 'Islamabad', 'Trainings', '', '2020-07-27 19:14:54', '2025-01-28 08:10:38');

-- --------------------------------------------------------

--
-- Table structure for table `training_lists`
--

CREATE TABLE `training_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `training_cost` varchar(191) NOT NULL,
  `status` varchar(30) NOT NULL,
  `remarks` mediumtext DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `trainer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `training_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `training_lists`
--

INSERT INTO `training_lists` (`id`, `description`, `start_date`, `end_date`, `training_cost`, `status`, `remarks`, `company_id`, `trainer_id`, `training_type_id`, `created_at`, `updated_at`) VALUES
(1, 'Test Trainings', '2025-01-28', '2025-01-30', '1000', '', NULL, 9, 1, 1, '2020-07-27 19:17:38', '2025-01-28 08:13:53');

-- --------------------------------------------------------

--
-- Table structure for table `training_types`
--

CREATE TABLE `training_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `training_types`
--

INSERT INTO `training_types` (`id`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Initial Job Training', '', '2020-07-27 19:10:52', '2025-01-28 08:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from_department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `to_department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transfer_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_id` int(10) UNSIGNED NOT NULL,
  `group` varchar(191) DEFAULT NULL,
  `key` text NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `travels`
--

CREATE TABLE `travels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `travel_type` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `purpose_of_visit` varchar(191) DEFAULT NULL,
  `place_of_visit` varchar(191) DEFAULT NULL,
  `expected_budget` varchar(20) DEFAULT NULL,
  `actual_budget` varchar(20) DEFAULT NULL,
  `travel_mode` varchar(20) NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `travels`
--

INSERT INTO `travels` (`id`, `description`, `company_id`, `employee_id`, `travel_type`, `start_date`, `end_date`, `purpose_of_visit`, `place_of_visit`, `expected_budget`, `actual_budget`, `travel_mode`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud', 1, 12, 1, '2021-03-07', '2021-03-04', 'Product Analysis', 'New Delhi', '800', '750', 'By Train', 'first level approval', '2020-07-27 15:53:52', '2020-07-27 15:53:52'),
(2, 'bla bla bla', 1, 9, 3, '2021-03-18', '2021-03-15', 'Rome', 'Athens', '500', NULL, 'By Plane', 'approved', '2020-08-02 07:09:33', '2020-08-18 07:13:03'),
(3, '', 1, 9, 1, '2023-02-21', '2023-02-22', 'Learning Tour', 'Sylhet', '5000', '5000', 'By Bus', 'approved', '2023-02-09 04:36:17', '2023-02-09 04:36:17');

-- --------------------------------------------------------

--
-- Table structure for table `travel_types`
--

CREATE TABLE `travel_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `arrangement_type` varchar(191) NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `travel_types`
--

INSERT INTO `travel_types` (`id`, `arrangement_type`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 'Corporation', NULL, '2020-07-27 03:51:23', '2020-07-27 03:51:23'),
(2, 'Guest House', NULL, '2020-07-27 03:51:34', '2020-07-27 03:51:34'),
(3, 'Hotel', NULL, '2020-07-27 03:51:39', '2020-07-27 03:51:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) DEFAULT NULL,
  `last_name` varchar(191) DEFAULT NULL,
  `username` varchar(64) NOT NULL,
  `email` varchar(64) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `profile_photo` varchar(191) DEFAULT NULL,
  `profile_bg` varchar(191) DEFAULT NULL,
  `role_users_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `contact_no` varchar(15) NOT NULL,
  `last_login_ip` varchar(32) DEFAULT NULL,
  `last_login_date` timestamp(2) NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `email_verified_at`, `password`, `profile_photo`, `profile_bg`, `role_users_id`, `is_active`, `contact_no`, `last_login_ip`, `last_login_date`, `remember_token`, `google_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Mister', 'Admin', 'admin', 'admin@gmail.com', NULL, '$2y$10$WcnC16AXG/mNrVBWQGjfoegFO.1wjiIiBv5LxEHR6uQaJYVciYCOa', 'admin_1722235144.jpg', NULL, 1, 1, '1234', '192.168.18.77', '2025-01-29 09:08:21.00', 'A1vmwsoVxyqiXxadfZ0EytbrkgoVzYLKzAfs408dVIuye3em5bmOsyFJ6lPQ', '112073730973873758091', NULL, '2024-07-29 06:09:13', NULL),
(157, 'Zohaib', 'Hassan', 'zohaib.hassan@basepracticesupport.co.uk', 'zohaib.hassan@basepracticesupport.co.uk', NULL, '$2y$10$NJB5XUwMKmGuMaTKGGXbQ.Bl1oWfVNM5a.10vUNLOh14Q1wg9b1gW', NULL, NULL, 4, 1, '03456608699', '192.168.18.77', '2025-01-29 08:11:17.00', NULL, NULL, '2025-01-28 08:00:36', '2025-01-28 13:10:16', NULL),
(158, 'Zayan', 'Rashid', 'zk649192@gmail.com', 'zk649192@gmail.com', NULL, '$2y$10$lY9OT9sP6w8H04XwWUab6uaG/tgpfn98EZNEbg/WXkbQPYtDeeEsO', NULL, NULL, 2, 1, '03365980889', '192.168.18.77', '2025-01-29 06:48:33.00', NULL, NULL, '2025-01-28 08:00:37', '2025-01-28 13:15:00', NULL),
(159, 'Zahid', 'Hassan', 'zahid.hassan@basepracticesupport.co.uk', 'zahid.hassan@basepracticesupport.co.uk', NULL, '$2y$10$QDr1A8NB9kcXTdT2Ki1CbOOKGip/Kl1B2VJTt2on4ReV7KpGgvN36', NULL, NULL, 4, 1, '03335362749', NULL, NULL, NULL, NULL, '2025-01-28 08:00:37', '2025-01-28 13:02:55', NULL),
(160, 'Wasif', 'Ali', 'wasif.ali@basepracticesupport.co.uk', 'wasif.ali@basepracticesupport.co.uk', NULL, '$2y$10$vAz2d9y1/dm9TeHfbQLWfeuT1yEF2yWNmZb800ten2fH7/bs0Dw/m', NULL, NULL, 2, 1, '03175779484', NULL, NULL, NULL, NULL, '2025-01-28 08:00:37', '2025-01-28 13:15:54', NULL),
(161, 'Wajeeha', 'Ahsan Butt', 'abc@g.com', 'abc@g.com', NULL, '$2y$10$d3ovmdQUuVTXvQa7W/UlEO5pgo4GZ.O.qEYuNIcmf/mBDj0Uip1fW', NULL, NULL, 2, 1, '03309258670', NULL, NULL, NULL, NULL, '2025-01-28 08:00:37', '2025-01-28 10:14:29', NULL),
(162, 'Usam-', 'Ul-Haq', 'usam.ulhaq@basepracticesupport.co.uk', 'usam.ulhaq@basepracticesupport.co.uk', NULL, '$2y$10$0B85Dqy8AB7Rp8Dxq2mWreY.gT6ZoRdDhH7ekK2avG0lTE7/FShIa', NULL, NULL, 2, 1, '03335627176', '127.0.0.1', '2025-01-29 07:05:04.00', NULL, NULL, '2025-01-28 08:00:37', '2025-01-28 12:09:25', NULL),
(163, 'Umar', 'Saleem', 'umar.butt@basepracticesupport.co.uk', 'umar.butt@basepracticesupport.co.uk', NULL, '$2y$10$IGEpDaCiNNiD3TrUUjD9Q.R0wSo410qQnsdU/cby6uZ9wO43jtlom', NULL, NULL, 2, 1, '03338506805', NULL, NULL, NULL, NULL, '2025-01-28 08:00:37', '2025-01-28 12:25:48', NULL),
(164, 'Syed', 'Ibad Hussain', 'ibadh@basepracticesupport.co.uk', 'ibadh@basepracticesupport.co.uk', NULL, '$2y$10$AlxBzeMILCzjNgW8lChGpecyG7IMPUS6dEEMpTvtYzfHkdCE6AShe', NULL, NULL, 4, 1, '3365198971', NULL, NULL, NULL, NULL, '2025-01-28 08:00:38', '2025-01-28 13:48:42', NULL),
(165, 'Shehryar', 'Hussain', 'shehryarh@basepracticesupport.co.uk', 'shehryarh@basepracticesupport.co.uk', NULL, '$2y$10$VyWtRZGn.2sMElIDOjfy5eJp.liJBIhX/tB3scN5jdoc1H0s7llW2', NULL, NULL, 4, 1, '03158208007', '127.0.0.1', '2025-01-28 13:09:35.00', NULL, NULL, '2025-01-28 08:00:38', '2025-01-28 11:37:52', NULL),
(166, 'Shahneel', 'Fatima', 'shahneel.fatima@basepracticesupport.co.uk', 'shahneel.fatima@basepracticesupport.co.uk', NULL, '$2y$10$G1Zs30K7h/slwrkhFw9kDOCcpvinbSCJvfPyK0OYgkd3b8p5/cWra', NULL, NULL, 2, 1, '03185294905', NULL, NULL, NULL, NULL, '2025-01-28 08:00:38', '2025-01-28 11:53:18', NULL),
(167, 'Saud', 'Khan', 'saudkhan@basepracticesupport.co.uk', 'saudkhan@basepracticesupport.co.uk', NULL, '$2y$10$P97/Wh5NYLRCaz0wbl4KPeFdkwlOFj6UyABrkZsuAef1/mu51SRU6', NULL, NULL, 2, 1, '0346-9688622', NULL, NULL, NULL, NULL, '2025-01-28 08:00:38', '2025-01-28 13:17:08', NULL),
(168, 'Sarmad', 'Hassan Tariq', 'sarmad.hassan@basepracticesupport.co.uk', 'sarmad.hassan@basepracticesupport.co.uk', NULL, '$2y$10$JV4qfmC56/Ir6mTk57z1POFb3aP/SlrgJmVskbtgn5JliZ6CXDova', NULL, NULL, 2, 1, '03475871330', NULL, NULL, NULL, NULL, '2025-01-28 08:00:38', '2025-01-28 12:56:40', NULL),
(169, 'Sana', 'Ullah', 'sanaullahkhan@basepracticesupport.co.uk', 'sanaullahkhan@basepracticesupport.co.uk', NULL, '$2y$10$LGq0IDT0WE.MtJ4wnq6w3e5vUXQdCSN.44twcPuFcstuw4vB1BaQq', NULL, NULL, 2, 1, '03365237766', NULL, NULL, NULL, NULL, '2025-01-28 08:00:38', '2025-01-28 13:00:41', NULL),
(170, 'Saeed', 'Ur Rehman', 'saeed.rehman@basepracticesupport.co.uk', 'saeed.rehman@basepracticesupport.co.uk', NULL, '$2y$10$KwpbOzunouZUrMWPlxltE.cSEnWf0orj4rGmjcY9yvT0ht3KohrTa', NULL, NULL, 2, 1, '0301-5491916', NULL, NULL, NULL, NULL, '2025-01-28 08:00:38', '2025-01-28 13:54:02', NULL),
(171, 'Sabir', 'Khan', 'sabirkhan@basepracticesupport.co.uk', 'sabirkhan@basepracticesupport.co.uk', NULL, '$2y$10$ZGHX4JeZ3VvD2vZalpQssuC8.aHdUS2AGbO.xQjq0IG93X3/da4qi', NULL, NULL, 2, 1, '0310-0003922', NULL, NULL, NULL, NULL, '2025-01-28 08:00:38', '2025-01-28 12:56:57', NULL),
(172, 'Rafeh', 'Hafeez', 'abdulrafay@basepracticesupport.co.uk', 'abdulrafay@basepracticesupport.co.uk', NULL, '$2y$10$0tK1M5YDvS9mxgUPP8nUzOpjla1UrjSZdc4jkzoJmlzpLSFfqzCrO', NULL, NULL, 2, 1, '0349-8936901', NULL, NULL, NULL, NULL, '2025-01-28 08:00:39', '2025-01-28 12:43:00', NULL),
(173, 'Noman', 'Hayat', 'noumanhayat302@gmail.com', 'noumanhayat302@gmail.com', NULL, '$2y$10$XbbrPzqwskVLiLk6hV16Kubg8MwoLdHlc769rgVCdE6pnNYy6wzS.', NULL, NULL, 2, 1, '0340-1691834', NULL, NULL, NULL, NULL, '2025-01-28 08:00:39', '2025-01-28 12:38:58', NULL),
(174, 'Naveed', 'Iqbal', 'naveed.iqbal@basepracticesupport.co.uk', 'naveed.iqbal@basepracticesupport.co.uk', NULL, '$2y$10$45tFsEDh36gXkH96wQPMU.svLTv26Yp5VAtpfMCN1roXTn1NcKo4C', NULL, NULL, 4, 1, '0315-909377', '127.0.0.1', '2025-01-29 06:03:20.00', NULL, NULL, '2025-01-28 08:00:39', '2025-01-28 12:12:19', NULL),
(175, 'Musadiq', 'Mehmood', 'musadiq.mehmood@basepracticesupport.co.uk', 'musadiq.mehmood@basepracticesupport.co.uk', NULL, '$2y$10$gDs3UHWRFuGWLBc.8QVzfObToPK1c/3geEn4sR8bdbuhFBlX8RaqO', NULL, NULL, 4, 1, '03159510545', NULL, NULL, NULL, NULL, '2025-01-28 08:00:39', '2025-01-28 13:42:10', NULL),
(176, 'Munaam', 'Malik', 'munnam.malik@basepracticesupport.co.uk', 'munnam.malik@basepracticesupport.co.uk', NULL, '$2y$10$2uowogbyuKC0HfDxlmOdUe9RWAkqpNB3/4ykshFrr00J.IQJCSq2.', NULL, NULL, 2, 1, '0336-0505798', NULL, NULL, NULL, NULL, '2025-01-28 08:00:39', '2025-01-28 12:28:53', NULL),
(177, 'Mukashfa', '-', 'mukashfa.khattak@basepracticesupport.co.uk', 'mukashfa.khattak@basepracticesupport.co.uk', NULL, '$2y$10$KRrZDrb3FCVQrk7OD3WiF.NZHBxLi6xNIB8rjgC60cfs1.1fCdF8G', NULL, NULL, 2, 1, '03179779324', NULL, NULL, NULL, NULL, '2025-01-28 08:00:39', '2025-01-28 12:17:30', NULL),
(178, 'Muhammad', 'Zishan', 'zishanm@basepracticesupport.co.uk', 'zishanm@basepracticesupport.co.uk', NULL, '$2y$10$VSjkZYHYo39Sg0q3Mxm7eeogE6u7lz67vW7WxbVkuenpqRUOkKpGe', NULL, NULL, 2, 1, '03456939009', NULL, NULL, NULL, NULL, '2025-01-28 08:00:39', '2025-01-28 11:51:13', NULL),
(179, 'Muhammad', 'Khawar', 'muhammad.khawar@basepracticesupport.co.uk', 'muhammad.khawar@basepracticesupport.co.uk', NULL, '$2y$10$bcoBBbxxxayKDE.6uPkene15q0QK3zhmbrmC7Ar8x75AKB2uwiiuy', NULL, NULL, 2, 1, '051-8431386, 03', NULL, NULL, NULL, NULL, '2025-01-28 08:00:39', '2025-01-28 13:32:18', NULL),
(180, 'Muhammad', 'Umer Hayat', 'umar.hayat@basepracticesupport.co.uk', 'umar.hayat@basepracticesupport.co.uk', NULL, '$2y$10$a7gj8nhD5NwXJUNtyTz2ouAEget.KITMVEZtTwysontsk0mS7f9vC', NULL, NULL, 2, 1, '0348-5055518', NULL, NULL, NULL, NULL, '2025-01-28 08:00:39', '2025-01-28 13:31:02', NULL),
(181, 'Muhammad', 'Sameer Javed', 'sameer.javed@basepracticesupport.co.uk', 'sameer.javed@basepracticesupport.co.uk', NULL, '$2y$10$ut6xo0saLnHzIyokepkH2OmI6S.Tai5cONjZFptCqxVMoA0Te4eRS', NULL, NULL, 2, 1, '03075704199', NULL, NULL, NULL, NULL, '2025-01-28 08:00:40', '2025-01-28 13:18:38', NULL),
(182, 'Muhammad', 'Waqas', 'muhammad.waqas@basepracticesupport.co.uk', 'muhammad.waqas@basepracticesupport.co.uk', NULL, '$2y$10$d/jMhtj6PrDYlewBVzYrS.iD1sxBemJSkqrrc8FgMNZozrxDcZ27K', NULL, NULL, 2, 1, '0324-9583678', NULL, NULL, NULL, NULL, '2025-01-28 08:00:40', '2025-01-28 13:23:27', NULL),
(183, 'Muhammad', 'Afaq', 'afaq.shahid@basepracticesupport.co.uk', 'afaq.shahid@basepracticesupport.co.uk', NULL, '$2y$10$a/kKtwuXmF119Et6MIWGcu8FaJyeniS1XDls0fLI33l5QFrXZmazm', NULL, NULL, 2, 1, '0313-9761629', NULL, NULL, NULL, NULL, '2025-01-28 08:00:40', '2025-01-28 13:20:01', NULL),
(184, 'Muhammad', 'Daniyal Javed', 'muhammaddaniyal@basepracticesupport.co.uk', 'muhammaddaniyal@basepracticesupport.co.uk', NULL, '$2y$10$UkvuPml42QEdaayM8TTtCe2q81aPngWX7Sr/rscuQbeWtE8z9qny.', NULL, NULL, 2, 1, '03352643141', NULL, NULL, NULL, NULL, '2025-01-28 08:00:40', '2025-01-28 12:02:29', NULL),
(185, 'Muhammad', 'Waleed', 'muhammadwaleed@basepracticesupport.co.uk', 'muhammadwaleed@basepracticesupport.co.uk', NULL, '$2y$10$zxgDc4aY/CFI09hogPHJ7OBndjrnkgWvI1n7j/qcV7asJDkEQJMBy', NULL, NULL, 2, 1, '03165146106', '127.0.0.1', '2025-01-28 12:53:58.00', NULL, NULL, '2025-01-28 08:00:40', '2025-01-28 12:03:59', NULL),
(186, 'Muhammad', 'Rayyan', 'muhammad.rayyan@basepracticesupport.co.uk', 'muhammad.rayyan@basepracticesupport.co.uk', NULL, '$2y$10$DuhGXM3UOOhPxW.RfEdg4eqEv98K2D33Uz/eXdGpCBWfIHcz23Z26', NULL, NULL, 2, 1, '03370300332', '127.0.0.1', '2025-01-28 13:46:55.00', NULL, NULL, '2025-01-28 08:00:40', '2025-01-28 12:08:35', NULL),
(187, 'Muhammad', 'Bilal Amin', 'bilalamin@basepracticesupport.co.uk', 'bilalamin@basepracticesupport.co.uk', NULL, '$2y$10$IGxPo1Z/Ekpmyi9KQzGf.e0LUIZKwTtk0oRmzscLMoNEYC5kDAebO', NULL, NULL, 2, 1, '0317-0798211', NULL, NULL, NULL, NULL, '2025-01-28 08:00:40', '2025-01-28 12:14:02', NULL),
(188, 'Muhammad', 'Umair', 'muhammad.umair@basepracticesupport.co.uk', 'muhammad.umair@basepracticesupport.co.uk', NULL, '$2y$10$5RU5YW44S.1xzaiW.ss/AuzRo9Y8ydpaWGPvSmJrKvjkS428UQ8D6', NULL, NULL, 2, 1, '03468107198', NULL, NULL, NULL, NULL, '2025-01-28 08:00:40', '2025-01-28 12:11:28', NULL),
(189, 'Muhammad', 'Faizan Arshad', 'faizan.jutt123@gmail.com', 'faizan.jutt123@gmail.com', NULL, '$2y$10$.xy3VpTDRHeiYkvwsfwBD.BHKpu1ZJSu8cFXRE0DxcyiaUnzBwIbS', NULL, NULL, 2, 1, '03219581677', NULL, NULL, NULL, NULL, '2025-01-28 08:00:41', '2025-01-28 13:33:33', NULL),
(190, 'Muhammad', 'Ibrahim Khan', 'muhammad.ibrahim@basepracticesupport.co.uk', 'muhammad.ibrahim@basepracticesupport.co.uk', NULL, '$2y$10$zWPQYVCseOjh3TeZMWw69e.worjQ9DdXNWXNfM7xQisWRY11nAzW2', NULL, NULL, 2, 1, '03100908525', NULL, NULL, NULL, NULL, '2025-01-28 08:00:41', '2025-01-28 12:10:52', NULL),
(191, 'Muhammad', 'Abdullah', 'abdullahrajpoot78695@gmail.com', 'abdullahrajpoot78695@gmail.com', NULL, '$2y$10$9EzHTDV8G8xEs3.8BudeiOvzI60I7zSNKpkD3IoYqVtr5OIoBE5XG', NULL, NULL, 2, 1, '00000000000', NULL, NULL, NULL, NULL, '2025-01-28 08:00:41', '2025-01-28 13:28:28', NULL),
(192, 'Muhammad', 'Salar Asif', 'salar.asif7.sa@gmail.com', 'salar.asif7.sa@gmail.com', NULL, '$2y$10$ANvLLM0wVWxgMEKXedOTLOd16JQM7F.VZizTWWSF9ccQeKb7dvl6K', NULL, NULL, 2, 1, '00000000001', NULL, NULL, NULL, NULL, '2025-01-28 08:00:41', '2025-01-28 12:55:25', NULL),
(193, 'Muhammad', 'Ahmed', 'muhmeddk97@gmail.com', 'muhmeddk97@gmail.com', NULL, '$2y$10$oaN1Wvqgpr.3cMcGaIHn8Ovg2kmcps0rN270juw1XquVk6UEDJKUi', NULL, NULL, 2, 1, '00000000002', NULL, NULL, NULL, NULL, '2025-01-28 08:00:41', '2025-01-28 13:26:12', NULL),
(194, 'Muhammad', 'Ali Hussain', 'malihussain.4434@outlook.com', 'malihussain.4434@outlook.com', NULL, '$2y$10$QKqPEaBBOoxXt0IBRbLSSeaKpEPqNK.NPw0.0R0cyGEOJX9xa8/Xa', NULL, NULL, 2, 1, '00000000003', NULL, NULL, NULL, NULL, '2025-01-28 08:00:41', '2025-01-28 13:06:24', NULL),
(195, 'Muhammad', 'Danyal', 'daniyal143h@gmail.com', 'daniyal143h@gmail.com', NULL, '$2y$10$nWLHVbTpKbKuW765cq7f6.zkFDfTJmbvJn1cRfvZ25zaLJ3rdc3/2', NULL, NULL, 2, 1, '00000000004', NULL, NULL, NULL, NULL, '2025-01-28 08:00:41', '2025-01-28 13:21:21', NULL),
(196, 'Muhammad', 'Faisal Irfan', 'jnbfasi07@gmail.com', 'jnbfasi07@gmail.com', NULL, '$2y$10$nBT1BKqmWXLOoCSRePYO8OMc8C3xj6fl069KlvuONjwDe/HLYtsjC', NULL, NULL, 2, 1, '00000000005', NULL, NULL, NULL, NULL, '2025-01-28 08:00:42', '2025-01-28 13:06:57', NULL),
(197, 'Muhammad', 'Wahaj', 'mnudwahad28@gmail.com', 'mnudwahad28@gmail.com', NULL, '$2y$10$o9Ga056pAMwazbZCOzFrpu8qavjZj3DkKZOn2nfZPQ11fpoWuxX86', NULL, NULL, 2, 1, '00000000006', NULL, NULL, NULL, NULL, '2025-01-28 08:00:42', '2025-01-28 13:13:34', NULL),
(198, 'Muhammad', 'Hassan Iqbal', 'shhassanshhassan60@gmail.com', 'shhassanshhassan60@gmail.com', NULL, '$2y$10$MzN7XGgxsZdW9GQQi2SnpuxHcFEAKalEbZqvmJJEKituFUIB/FGrO', NULL, NULL, 2, 1, '00000000007', NULL, NULL, NULL, NULL, '2025-01-28 08:00:42', '2025-01-28 13:13:01', NULL),
(199, 'Mathew', 'Francis', 'mathewfrancis@basepracticesupport.co.uk', 'mathewfrancis@basepracticesupport.co.uk', NULL, '$2y$10$agg15SKGO5EB7rBzTmWkwOy2OMkRtmDbnml/cXEi7e71dL941KaIS', NULL, NULL, 2, 1, '03498577596', NULL, NULL, NULL, NULL, '2025-01-28 08:00:42', '2025-01-28 13:36:47', NULL),
(200, 'Mahnoor', 'Rehman', 'mahnoorrehman769@gmail.com', 'mahnoorrehman769@gmail.com', NULL, '$2y$10$iFuoN2RWke6Fi/SFRIVzC.9kcROOMuPCRuIqomF8ZExD31Nakff3e', NULL, NULL, 2, 1, '00000000008', NULL, NULL, NULL, NULL, '2025-01-28 08:00:42', '2025-01-28 12:06:18', NULL),
(201, 'M Ashir', 'Saddique Qureshi', 'ashir.siddique76@gmail.com', 'ashir.siddique76@gmail.com', NULL, '$2y$10$jbqcm0hEgiAF.WJbRAs4zu7zw90ghOyMGntdNJ.mhcVTd9d3Ry9ze', NULL, NULL, 2, 1, '00000000009', NULL, NULL, NULL, NULL, '2025-01-28 08:00:42', '2025-01-28 13:39:21', NULL),
(202, 'Laiba', 'Naveed', 'laiba.naveed@basepracticesupport.co.uk', 'laiba.naveed@basepracticesupport.co.uk', NULL, '$2y$10$6hCU82LYFyHrbn7ViOOpbeh8JbY5jawHhU8GllUzyTQrGeVbKO/uK', NULL, NULL, 2, 1, '03315243664', NULL, NULL, NULL, NULL, '2025-01-28 08:00:42', '2025-01-28 12:01:06', NULL),
(203, 'Khurram', 'Ali Butt', 'khurramb@basepracticesupport.co.uk', 'khurramb@basepracticesupport.co.uk', NULL, '$2y$10$GgukbhkXKsraKMf5TNFsU.mdtE.u7Mhk6oMHqInQIPSYWgU5XMzD.', NULL, NULL, 2, 1, '0333312500703', NULL, NULL, NULL, NULL, '2025-01-28 08:00:42', '2025-01-28 11:09:26', NULL),
(204, 'Khawaja', 'Ans', 'ansshoaib@basepracticesupport.co.uk', 'ansshoaib@basepracticesupport.co.uk', NULL, '$2y$10$Bw.bRsBUl/azzjoyzhpoeOUVY6F6zpvtd5I5w286Csn3TZsUXsm2C', NULL, NULL, 2, 1, '0318-5190425', NULL, NULL, NULL, NULL, '2025-01-28 08:00:43', '2025-01-28 13:27:11', NULL),
(205, 'Kamran', 'Khalid', 'kamran091998@gmail.com', 'kamran091998@gmail.com', NULL, '$2y$10$Ykt1zQMRk2eUY4yvNM7ikeBWeXLEpLn/UhiAGgxa80prO.QIn2Yfq', NULL, NULL, 2, 1, '00000000010', NULL, NULL, NULL, NULL, '2025-01-28 08:00:43', '2025-01-28 12:12:37', NULL),
(206, 'Junaid', 'Rasheed', 'junaid.rasheed@basepracticesupport.co.uk', 'junaid.rasheed@basepracticesupport.co.uk', NULL, '$2y$10$yLhsZ5NtEv5ajVywUqSD6OYOL22XQP0.sqarKwlLrszdUsG9kcX72', NULL, NULL, 2, 1, '0311-7505550', NULL, NULL, NULL, NULL, '2025-01-28 08:00:43', '2025-01-28 12:05:26', NULL),
(207, 'Junaid', 'Babar', 'arceusjunaid@gmail.com', 'arceusjunaid@gmail.com', NULL, '$2y$10$zoCjD547eSnvlY0H82JGVO1OS5HZdGhMBFRIbDsTL4LU5LEysmBgq', NULL, NULL, 2, 1, '03135348151', NULL, NULL, NULL, NULL, '2025-01-28 08:00:43', '2025-01-28 13:15:03', NULL),
(208, 'Jawad', 'Hussain', 'jawadqqq053@gmail.com', 'jawadqqq053@gmail.com', NULL, '$2y$10$KZRFdwwFXHvGKITuwvyFxOKM7t98E.3VtsgSp4AY35OZngLEMLFeG', NULL, NULL, 2, 1, '00000000011', NULL, NULL, NULL, NULL, '2025-01-28 08:00:43', '2025-01-28 12:37:26', NULL),
(209, 'Irfan', 'Azam Baig', 'irfanazam15202@gmail.com', 'irfanazam15202@gmail.com', NULL, '$2y$10$CM/QfFGiIOLYMVGD5MPeXezq6X1FEXTlJHK9Krs6wB0x8ABukQFqy', NULL, NULL, 2, 1, '0307-8392822', NULL, NULL, NULL, NULL, '2025-01-28 08:00:43', '2025-01-28 12:41:19', NULL),
(210, 'Imtinan', 'Fazal Haq', 'imtinanc@basepracticesupport.co.uk', 'imtinanc@basepracticesupport.co.uk', NULL, '$2y$10$m89OveLhdMg99.J5fx3UKOKjipHdEJFq0L8YzbBbGOK9f1dIlPCa.', NULL, NULL, 2, 1, '03344843119', NULL, NULL, NULL, NULL, '2025-01-28 08:00:43', '2025-01-28 13:20:10', NULL),
(211, 'Imran', 'Khattak', 'imran.khattak@basepracticesupport.co.uk', 'imran.khattak@basepracticesupport.co.uk', NULL, '$2y$10$8wNFus7NZUaDCjJgzE4PW..lZlyVSCWXGoA2NyaUXHVQrIX9Li3fi', NULL, NULL, 2, 1, '0336-9098451', NULL, NULL, NULL, NULL, '2025-01-28 08:00:43', '2025-01-28 12:50:32', NULL),
(212, 'Ibtisam', 'Shahid', 'ibtisamshahid@basepracticesupport.co.uk', 'ibtisamshahid@basepracticesupport.co.uk', NULL, '$2y$10$Baj9u1RTWaapjx7O4CaYYOE4DB4wiCh0DpSf3dR/kuH/XY/jYJXpy', NULL, NULL, 2, 1, '03369859728', NULL, NULL, NULL, NULL, '2025-01-28 08:00:43', '2025-01-28 12:14:01', NULL),
(213, 'Iatzaz', 'Ahsan', 'iatzaz.ahsan@basepracticesupport.co.uk', 'iatzaz.ahsan@basepracticesupport.co.uk', NULL, '$2y$10$bxQ96Ph6SRgJq3/ShQLWBeTaf4o0d44zrTorDAYyDq90KHa4Cz7h.', NULL, NULL, 2, 1, '0343-8854955', NULL, NULL, NULL, NULL, '2025-01-28 08:00:44', '2025-01-28 12:46:07', NULL),
(214, 'Hina', 'Iftikhar', 'hina.iftikhar@basepracticesupport.co.uk', 'hina.iftikhar@basepracticesupport.co.uk', NULL, '$2y$10$3PeaTJgJ3ve3QPuOZotQ4u0o24jSrLgeqCrfQ37Tb8rua5iQcgBVW', NULL, NULL, 4, 1, '03125403814', NULL, NULL, NULL, NULL, '2025-01-28 08:00:44', '2025-01-28 13:49:44', NULL),
(215, 'Hassan', 'Tahir', 'hassantahir@basepracticesupport.co.uk', 'hassantahir@basepracticesupport.co.uk', NULL, '$2y$10$vAjIKwfyg8RCIkkq87XhbO.etE/XhgTqIIih5SoeWAQ4JvBH2Cj7q', NULL, NULL, 2, 1, '03398887263', NULL, NULL, NULL, NULL, '2025-01-28 08:00:44', '2025-01-28 13:35:16', NULL),
(216, 'Haris', 'Ahmed Khan', 'harrisahmed@basepracticesupport.co.uk', 'harrisahmed@basepracticesupport.co.uk', NULL, '$2y$10$A4CGt0CiIXWymfnz6nM03.812G9qF3B4og48nF4PjTr0PNV4vDlSG', NULL, NULL, 2, 1, '0344-5027913', NULL, NULL, NULL, NULL, '2025-01-28 08:00:44', '2025-01-28 13:18:23', NULL),
(217, 'Haram', 'Mustafa', 'haram.mustafa@basepracticesupport.co.uk', 'haram.mustafa@basepracticesupport.co.uk', NULL, '$2y$10$GGlYkznYYhQuBuquxfc0k.Jn2vTOiLumTqUfxkAHHgiSfheExXQzK', NULL, NULL, 2, 1, '03175515362', NULL, NULL, NULL, NULL, '2025-01-28 08:00:44', '2025-01-28 11:57:29', NULL),
(218, 'Hamza', 'Khan', 'hamza.khan@basepracticesupport.co.uk', 'hamza.khan@basepracticesupport.co.uk', NULL, '$2y$10$cKdjcbiITW7c83kaWWgOn.NVF966BTli7rxahPlZ6DCvC/06VkPnW', NULL, NULL, 2, 1, '0323-9732422', NULL, NULL, NULL, NULL, '2025-01-28 08:00:44', '2025-01-28 12:34:06', NULL),
(219, 'Hamza', 'Waheed', 'hamzawaheed20200978@gmail.com', 'hamzawaheed20200978@gmail.com', NULL, '$2y$10$z9WcM0pjUfGK/Kh4ufQoWu8LkTjUBHgE3uzy3v9M0DfPR4XoZEJK6', NULL, NULL, 2, 1, '00000000012', NULL, NULL, NULL, NULL, '2025-01-28 08:00:44', '2025-01-28 12:15:36', NULL),
(220, 'Hamza', 'Qamar', 'rajahamza.qamar2002@gmail.com', 'rajahamza.qamar2002@gmail.com', NULL, '$2y$10$rWp3Wnu/ZIyCQhswwRymj.4gkyLPjAjwZp0KlikeeigSWtt3gW7k.', NULL, NULL, 2, 1, '00000000013', NULL, NULL, NULL, NULL, '2025-01-28 08:00:44', '2025-01-28 12:22:46', NULL),
(221, 'Hammad', 'Hussain', 'hammadhussain@basepracticesupport.co.uk', 'hammadhussain@basepracticesupport.co.uk', NULL, '$2y$10$cc5qAD.DCwRZXmJcAB7rwuzAg8kSboznEDI1Jg.gyn91coyon/Yem', NULL, NULL, 2, 1, '0333-6239284', NULL, NULL, NULL, NULL, '2025-01-28 08:00:44', '2025-01-28 12:58:25', NULL),
(222, 'Hadi', 'Raza', 'hadi.raza3726@gmail.com', 'hadi.raza3726@gmail.com', NULL, '$2y$10$wci9QbWfyWxL5LqYRVAx6ecmM0cJYIfaTItrRBqymCVpRr9il3E2y', NULL, NULL, 2, 1, '00000000014', NULL, NULL, NULL, NULL, '2025-01-28 08:00:45', '2025-01-28 12:20:53', NULL),
(223, 'Hadayat', 'Ullah', 'hidayat.malik@basepracticesupport.co.uk', 'hidayat.malik@basepracticesupport.co.uk', NULL, '$2y$10$4MfMout51aH.b7KsA/5tSOxGILdBJlumW3wdosw5J3Xht421Dexyu', NULL, NULL, 2, 1, '0345-3636682', NULL, NULL, NULL, NULL, '2025-01-28 08:00:45', '2025-01-28 13:03:39', NULL),
(224, 'Ghulam', 'Ghous', 'ghulam.ghous@basepracticesupport.co.uk', 'ghulam.ghous@basepracticesupport.co.uk', NULL, '$2y$10$2OCMzKkmdywcaH4uUkboPuHBfU7jt/m2USXuHDUhnxCbV5tSxSviG', NULL, NULL, 4, 1, '03007390847', NULL, NULL, NULL, NULL, '2025-01-28 08:00:45', '2025-01-28 13:11:47', NULL),
(225, 'Fawad', 'Ahmed', 'fawadahmad@basepracticesupport.co.uk', 'fawadahmad@basepracticesupport.co.uk', NULL, '$2y$10$HV7IxwGm9o416C3jZV7J1uEo8M.WxAfO/TDhifc7cIOMCXIgv9L1m', NULL, NULL, 2, 1, '03229188545', NULL, NULL, NULL, NULL, '2025-01-28 08:00:45', '2025-01-28 13:08:35', NULL),
(226, 'Faisal', 'Tariq Chaudhary', 'faisalc@basepracticesupport.co.uk', 'faisalc@basepracticesupport.co.uk', NULL, '$2y$10$7wH1GKepl8TgufIDalJ8nef0/Dwo1y8QwCWOcxNq/bgITkfhL5WLm', 'faisalc@basepracticesupport.co.uk_1738065963.jpg', NULL, 1, 1, '03335479498', '192.168.18.77', '2025-01-29 09:04:40.00', 'Ct3DGHLd3ikz3TSlNPODwtDzNxBcu9DLyiYXOSlqxtkiB7nn4mii0qHF9nXi', NULL, '2025-01-28 08:00:45', '2025-01-28 12:06:03', NULL),
(227, 'Faisal', 'Ayub', 'faisala@basepracticesupport.co.uk', 'faisala@basepracticesupport.co.uk', NULL, '$2y$10$qKm/Z3U6DO5ZEflydQB25ea5lytFNbz03Cvu0EmNtHnyFFUGViJR.', 'faisala@basepracticesupport.co.uk_1738066068.jpg', NULL, 4, 1, '03218474239', '127.0.0.1', '2025-01-29 05:57:04.00', NULL, NULL, '2025-01-28 08:00:45', '2025-01-28 12:07:48', NULL),
(228, 'Faisal', 'Zeb', 'faisal.zeb@basepracticesupport.co.uk', 'faisal.zeb@basepracticesupport.co.uk', NULL, '$2y$10$Tft3jmUTP.xeSRKwIzw.KOJFxP5U7xiZc/Pv88hQhhsqJ7gPA0.DO', NULL, NULL, 2, 1, '03138432211', NULL, NULL, NULL, NULL, '2025-01-28 08:00:45', '2025-01-28 13:44:40', NULL),
(229, 'Faheem', 'Ul Hassan', 'faheem.hassan@basepracticesupport.co.uk', 'faheem.hassan@basepracticesupport.co.uk', NULL, '$2y$10$Lo6Qe/wcFqLy04/Ymc5nz.nBc05zm1/Zn/KTH9dqG97kdttrwq20e', NULL, NULL, 4, 1, '03049903255', NULL, NULL, NULL, NULL, '2025-01-28 08:00:45', '2025-01-28 12:22:20', NULL),
(230, 'Bilal', 'Khan', 'bilalkhan@basepracticesupport.co.uk', 'bilalkhan@basepracticesupport.co.uk', NULL, '$2y$10$FWaoMx2CzFv/0SYqX4KRsOcFlS/EQ9zJbz2PdqgGkhS/t6ct3bKIa', NULL, NULL, 2, 1, '03340591803', NULL, NULL, NULL, NULL, '2025-01-28 08:00:45', '2025-01-28 13:09:43', NULL),
(231, 'Aziz', 'ur Rehman', 'aziz.rehman@basepracticesupport.co.uk', 'aziz.rehman@basepracticesupport.co.uk', NULL, '$2y$10$sV8GZMNSbNVHxxvvdfpvqeul9jpDlJV/sygNDZEc.8eAKS5mCIkx.', NULL, NULL, 2, 1, '0332-7670806', NULL, NULL, NULL, NULL, '2025-01-28 08:00:46', '2025-01-28 12:53:10', NULL),
(232, 'Awais', 'Liaqat', 'awaisl@basepracticesupport.co.uk', 'awaisl@basepracticesupport.co.uk', NULL, '$2y$10$XfYfeFOTAO3VC3BRWxfqNOxMypJ8HZi7MsbYt7EMupHr2Q2hMCYKS', NULL, NULL, 4, 1, '03488134124', NULL, NULL, NULL, NULL, '2025-01-28 08:00:46', '2025-01-28 11:05:43', NULL),
(233, 'Athar', 'Butt', 'athar@avantcoretech.com', 'athar@avantcoretech.com', NULL, '$2y$10$zQIUX6DwpoF3WxaPqPdLo.JgwRsWF/XLnrMvv9RfVYOd.xg4PRq2K', NULL, NULL, 2, 1, '00000000015', NULL, NULL, NULL, NULL, '2025-01-28 08:00:46', '2025-01-28 08:00:46', NULL),
(234, 'Ateeq', 'Ur Rehman', 'ateeq2326@gmail.com', 'ateeq2326@gmail.com', NULL, '$2y$10$AbT7IcTmbx/RyzqiUyMnkeF52mim4Mh5RflvxLbKJ0pUwdSZJI.Mi', NULL, NULL, 2, 1, '03476371799', NULL, NULL, NULL, NULL, '2025-01-28 08:00:46', '2025-01-28 12:51:46', NULL),
(235, 'Ashfaq', 'Ahmed Khan', 'ashfaqahmed@basepracticesupport.co.uk', 'ashfaqahmed@basepracticesupport.co.uk', NULL, '$2y$10$eUcF/z0EMUfUULv2WQIePuOM8bfpOAZNcnkrVe0rV/6TmVNbUISFO', NULL, NULL, 2, 1, '03425020360', NULL, NULL, NULL, NULL, '2025-01-28 08:00:46', '2025-01-28 13:04:08', NULL),
(236, 'Asghar', 'Ali', 'asghar.ali@basepracticesupport.co.uk', 'asghar.ali@basepracticesupport.co.uk', NULL, '$2y$10$qJF/DghCPYVcGuIpGb0ZwOEI/B.mZqEjvveKz6zb4K.6CrIaITLmu', NULL, NULL, 2, 1, '0343-6996091', NULL, NULL, NULL, NULL, '2025-01-28 08:00:46', '2025-01-28 12:59:54', NULL),
(237, 'Asad', 'Mehmood', 'asadmahmood@basepracticesupport.co.uk', 'asadmahmood@basepracticesupport.co.uk', NULL, '$2y$10$nGbOjzoWz/Xmdq1oheAnPudYwEFGdXeBzbJyExJ27l/Eb7N0wgLom', NULL, NULL, 2, 1, '03361110322', NULL, NULL, NULL, NULL, '2025-01-28 08:00:46', '2025-01-28 12:53:15', NULL),
(238, 'Arman', 'Arif', 'armana@basepracticesupport.co.uk', 'armana@basepracticesupport.co.uk', NULL, '$2y$10$TEf9WL4fRlNgMy1qlq7jD.Kc.ysOEN0mL.l0bmcsJvX3uar84SMJG', NULL, NULL, 4, 1, '0332178924303', '192.168.18.77', '2025-01-28 13:27:48.00', 'KBpRERxBD2lOyrWAD7ylhmhNZLJgkDB5sBlgAeGHw0AC1Hq07kqdH2TySdCY', NULL, '2025-01-28 08:00:46', '2025-01-28 11:13:37', NULL),
(239, 'Areej', 'Fatima', 'areej.fatima@basepracticesupport.co.uk', 'areej.fatima@basepracticesupport.co.uk', NULL, '$2y$10$Ty0xG6DgAPxJMyqpFV4DYOfn4Wxy5uAPm8L7Edldf8r3unOz.6i3i', NULL, NULL, 2, 1, '03117886835', NULL, NULL, NULL, NULL, '2025-01-28 08:00:46', '2025-01-28 12:59:41', NULL),
(240, 'Amir', 'Asghar Butt', 'amirbutt@basepracticesupport.co.uk', 'amirbutt@basepracticesupport.co.uk', NULL, '$2y$10$vzHcC/EFg.LgmAiYQPhbD.uX5215NAAoC5IqU/FkDbGxO6lQ1anjy', NULL, NULL, 4, 1, '0321-4800558', NULL, NULL, NULL, NULL, '2025-01-28 08:00:47', '2025-01-28 11:35:11', NULL),
(241, 'Alyan', 'Hijazi', 'alyanhijazi@gmail.com', 'alyanhijazi@gmail.com', NULL, '$2y$10$JIlF76AcPJUp/R9oerOufutARteO64uIV.ivvPri6NUM824byyhHC', NULL, NULL, 2, 1, '03368182445', NULL, NULL, NULL, NULL, '2025-01-28 08:00:47', '2025-01-28 12:58:05', NULL),
(242, 'Ali', 'Abid', 'ali.abid2941@gmail.com', 'ali.abid2941@gmail.com', NULL, '$2y$10$tj7TYjY9hmhn22ZJx.Pr1u9lPJ7DWw6nzhhvirdUOUUsPY/Kslqku', NULL, NULL, 2, 1, '000000001', NULL, NULL, NULL, NULL, '2025-01-28 08:00:47', '2025-01-28 12:20:09', NULL),
(243, 'Ajmal', 'Farooq', 'ajmal.farooq89@gmail.com', 'ajmal.farooq89@gmail.com', NULL, '$2y$10$q1rOzAMMdigRmdU0VrjHdeMQ6ZTH4vsCd72YQdNnz5jT6xhmejaVa', NULL, NULL, 2, 1, '03025707511', NULL, NULL, NULL, NULL, '2025-01-28 08:00:47', '2025-01-28 12:55:08', NULL),
(244, 'Ain UI', 'Afin', 'ainafeen@basepracticesupport.co.uk', 'ainafeen@basepracticesupport.co.uk', NULL, '$2y$10$3mt/A2p8c31QdXs9mqcB5O0uE62ZceAr9ntzBUg8/q8ftNA4dY73O', NULL, NULL, 2, 1, '0312-5605475', NULL, NULL, NULL, NULL, '2025-01-28 08:00:47', '2025-01-28 12:44:28', NULL),
(245, 'Ahsan', 'Masood', 'ahsanm@basepracticesupport.co.uk', 'ahsanm@basepracticesupport.co.uk', NULL, '$2y$10$6TgujzAQyVV9ICKyX/3nJu6wQD1ZPZAZBMaWNontKwkkZVp66GCn2', NULL, NULL, 2, 1, '03065546533', NULL, NULL, NULL, NULL, '2025-01-28 08:00:47', '2025-01-28 12:15:52', NULL),
(246, 'Ahsan', 'Sadiq Butt', 'ahsanbutt@basepracticesupport.co.uk', 'ahsanbutt@basepracticesupport.co.uk', NULL, '$2y$10$799VKcATgR88W2uI4xl4mu.Hw19dtLbh8ZPt7QBFLK31i6.PC0xSa', NULL, NULL, 4, 1, '03365221383', NULL, NULL, NULL, NULL, '2025-01-28 08:00:47', '2025-01-28 11:16:52', NULL),
(247, 'Ahmed', 'Hayat', 'hayatkahmed606@gmail.com', 'hayatkahmed606@gmail.com', NULL, '$2y$10$d2lDVkNf/OL//9MOgwMc/.yPfNf.YDRfBoDxEg/PWv4n2J0vbZhre', NULL, NULL, 2, 1, '0343-5644425', NULL, NULL, NULL, NULL, '2025-01-28 08:00:47', '2025-01-28 12:48:26', NULL),
(248, 'Afnan', 'Ahmad', 'afnaankhan.109@gmail.com', 'afnaankhan.109@gmail.com', NULL, '$2y$10$cCQZ/AoO58p6OX/nD7WRrO1jM2xplNXZ0RJqKLbkvBT0fgI2yYKce', NULL, NULL, 2, 1, '00000000016', NULL, NULL, NULL, NULL, '2025-01-28 08:00:47', '2025-01-28 13:25:16', NULL),
(249, 'Abdur', 'Rehman', 'rehmankhan1240@gmail.com', 'rehmankhan1240@gmail.com', NULL, '$2y$10$Sq6kVe/j9wu4m1sHqWwjNettA1XN7sRd5KdYcopbQB2xJdW9AanOG', NULL, NULL, 2, 1, '0306-9817642', NULL, NULL, NULL, NULL, '2025-01-28 08:00:48', '2025-01-28 13:16:17', NULL),
(250, 'Abdul', 'Hanan', 'abdul.hanan@basepracticesupport.co.uk', 'abdul.hanan@basepracticesupport.co.uk', NULL, '$2y$10$OLLPLTQXOqFon0b2zuz5iO7FU7tIMlChNfxVpEDlEHIFcl4gATERq', NULL, NULL, 2, 1, '0301-6873063', NULL, NULL, NULL, NULL, '2025-01-28 08:00:48', '2025-01-28 12:22:27', NULL),
(251, 'Abdul', 'Manaan Butt', 'hr@basepracticesupport.co.uk', 'hr@basepracticesupport.co.uk', NULL, '$2y$10$7PtkYFSIIz3VW9cXvLDcJ.s8qtqSEogzb01rxChToaP4RDbTzKcCG', NULL, NULL, 6, 1, '03361158414', '127.0.0.1', '2025-01-29 08:09:44.00', NULL, NULL, '2025-01-28 08:00:48', '2025-01-28 14:27:43', NULL),
(253, 'john', 'smith', 'john', 'john@g.com', NULL, '$2y$10$hJSfjoOEg1EhTjCMoanDp.GroIPu9yBV2vBQG9zLHhPfg2FOi6ADa', NULL, NULL, 1, 1, '00000000', '127.0.0.1', '2025-01-28 09:58:00.00', NULL, NULL, '2025-01-28 09:57:01', '2025-01-28 09:57:01', NULL),
(254, 'Zubair Ali', 'Chachar', 'zubair.ali@basepracticesupport.co.uk', 'zubair.ali@basepracticesupport.co.uk', NULL, '$2y$10$veywaXeM.UacJNrF/cANfe5iKgafyDeQzm3oFPC.dxuM1lw2ajJLm', NULL, NULL, 4, 1, '03073490940', NULL, NULL, NULL, NULL, '2025-01-28 12:48:27', '2025-01-28 12:53:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `warnings`
--

CREATE TABLE `warnings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(191) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `warning_to` bigint(20) UNSIGNED NOT NULL,
  `warning_type` bigint(20) UNSIGNED DEFAULT NULL,
  `warning_date` date NOT NULL,
  `status` varchar(40) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warnings`
--

INSERT INTO `warnings` (`id`, `subject`, `description`, `company_id`, `warning_to`, `warning_type`, `warning_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Harassment', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 11, 1, '2021-04-06', 'unsolved', '2020-07-27 17:35:31', '2020-07-27 17:35:31');

-- --------------------------------------------------------

--
-- Table structure for table `warnings_type`
--

CREATE TABLE `warnings_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warning_title` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warnings_type`
--

INSERT INTO `warnings_type` (`id`, `warning_title`, `created_at`, `updated_at`) VALUES
(1, 'First written warning', '2020-07-26 20:20:57', '2020-07-26 20:20:57'),
(2, 'Verbal Warning', '2020-07-26 20:21:17', '2020-07-26 20:21:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_company_id_foreign` (`company_id`),
  ADD KEY `announcements_department_id_foreign` (`department_id`);

--
-- Indexes for table `appraisals`
--
ALTER TABLE `appraisals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appraisals_company_id_foreign` (`company_id`),
  ADD KEY `appraisals_employee_id_foreign` (`employee_id`),
  ADD KEY `appraisals_department_id_foreign` (`department_id`),
  ADD KEY `appraisals_designation_id_foreign` (`designation_id`);

--
-- Indexes for table `appraisal_sections`
--
ALTER TABLE `appraisal_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`name`),
  ADD KEY `fk_appraisal_sections_company_id` (`company_id`);

--
-- Indexes for table `appraisal_section_indicators`
--
ALTER TABLE `appraisal_section_indicators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assets_company_id_foreign` (`company_id`),
  ADD KEY `assets_employee_id_foreign` (`employee_id`),
  ADD KEY `assets_assets_category_id_foreign` (`assets_category_id`);

--
-- Indexes for table `asset_categories`
--
ALTER TABLE `asset_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_categories_company_id_foreign` (`company_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `awards_company_id_foreign` (`company_id`),
  ADD KEY `awards_department_id_foreign` (`department_id`),
  ADD KEY `awards_employee_id_foreign` (`employee_id`),
  ADD KEY `awards_award_type_id_foreign` (`award_type_id`);

--
-- Indexes for table `award_types`
--
ALTER TABLE `award_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calendarables`
--
ALTER TABLE `calendarables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidate_interview`
--
ALTER TABLE `candidate_interview`
  ADD PRIMARY KEY (`interview_id`,`candidate_id`),
  ADD KEY `candidate_interview_candidate_id_foreign` (`candidate_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_location_id_foreign` (`location_id`),
  ADD KEY `companies_company_type_id_foreign` (`company_type_id`);

--
-- Indexes for table `company_types`
--
ALTER TABLE `company_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaints_company_id_foreign` (`company_id`),
  ADD KEY `complaints_complaint_from_foreign` (`complaint_from`),
  ADD KEY `complaints_complaint_against_foreign` (`complaint_against`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_m_s`
--
ALTER TABLE `c_m_s`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deduction_types`
--
ALTER TABLE `deduction_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_company_id_foreign` (`company_id`),
  ADD KEY `departments_department_head_foreign` (`department_head`);

--
-- Indexes for table `deposit_categories`
--
ALTER TABLE `deposit_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designations_company_id_foreign` (`company_id`),
  ADD KEY `designations_department_id_foreign` (`department_id`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_office_shift_id_foreign` (`office_shift_id`),
  ADD KEY `employees_company_id_foreign` (`company_id`),
  ADD KEY `employees_department_id_foreign` (`department_id`),
  ADD KEY `employees_designation_id_foreign` (`designation_id`),
  ADD KEY `employees_location_id_foreign` (`location_id`),
  ADD KEY `employees_role_users_id_foreign` (`role_users_id`),
  ADD KEY `employees_status_id_foreign` (`status_id`);

--
-- Indexes for table `employee_bank_accounts`
--
ALTER TABLE `employee_bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_bank_accounts_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employee_contacts`
--
ALTER TABLE `employee_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_contacts_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_contacts_relation_type_id_foreign` (`relation_type_id`);

--
-- Indexes for table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_documents_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_documents_document_type_id_foreign` (`document_type_id`);

--
-- Indexes for table `employee_immigrations`
--
ALTER TABLE `employee_immigrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_immigrations_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_immigrations_document_type_id_foreign` (`document_type_id`);

--
-- Indexes for table `employee_interview`
--
ALTER TABLE `employee_interview`
  ADD PRIMARY KEY (`interview_id`,`employee_id`),
  ADD KEY `employee_interview_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employee_leave_type_details`
--
ALTER TABLE `employee_leave_type_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_leave_type_details_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employee_meeting`
--
ALTER TABLE `employee_meeting`
  ADD PRIMARY KEY (`employee_id`,`meeting_id`),
  ADD KEY `employee_meeting_meeting_id_foreign` (`meeting_id`);

--
-- Indexes for table `employee_project`
--
ALTER TABLE `employee_project`
  ADD PRIMARY KEY (`employee_id`,`project_id`),
  ADD KEY `employee_project_project_id_foreign` (`project_id`);

--
-- Indexes for table `employee_qualificaitons`
--
ALTER TABLE `employee_qualificaitons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_qualificaitons_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_qualificaitons_education_level_id_foreign` (`education_level_id`),
  ADD KEY `employee_qualificaitons_language_skill_id_foreign` (`language_skill_id`),
  ADD KEY `employee_qualificaitons_general_skill_id_foreign` (`general_skill_id`);

--
-- Indexes for table `employee_support_ticket`
--
ALTER TABLE `employee_support_ticket`
  ADD PRIMARY KEY (`employee_id`,`support_ticket_id`),
  ADD KEY `employee_support_ticket_support_ticket_id_foreign` (`support_ticket_id`);

--
-- Indexes for table `employee_task`
--
ALTER TABLE `employee_task`
  ADD PRIMARY KEY (`employee_id`,`task_id`),
  ADD KEY `employee_task_task_id_foreign` (`task_id`);

--
-- Indexes for table `employee_training_list`
--
ALTER TABLE `employee_training_list`
  ADD PRIMARY KEY (`employee_id`,`training_list_id`),
  ADD KEY `employee_training_list_training_list_id_foreign` (`training_list_id`);

--
-- Indexes for table `employee_work_experience`
--
ALTER TABLE `employee_work_experience`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_work_experience_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_company_id_foreign` (`company_id`),
  ADD KEY `events_department_id_foreign` (`department_id`);

--
-- Indexes for table `expense_types`
--
ALTER TABLE `expense_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_types_company_id_foreign` (`company_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_managers`
--
ALTER TABLE `file_managers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_managers_department_id_foreign` (`department_id`),
  ADD KEY `file_managers_added_by_foreign` (`added_by`);

--
-- Indexes for table `file_manager_settings`
--
ALTER TABLE `file_manager_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_bank_cashes`
--
ALTER TABLE `finance_bank_cashes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_deposits`
--
ALTER TABLE `finance_deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `finance_deposits_company_id_foreign` (`company_id`),
  ADD KEY `finance_deposits_account_id_foreign` (`account_id`),
  ADD KEY `finance_deposits_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `finance_deposits_payer_id_foreign` (`payer_id`),
  ADD KEY `finance_deposits_deposit_category_id_foreign` (`deposit_category_id`);

--
-- Indexes for table `finance_expenses`
--
ALTER TABLE `finance_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `finance_expenses_company_id_foreign` (`company_id`),
  ADD KEY `finance_expenses_account_id_foreign` (`account_id`),
  ADD KEY `finance_expenses_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `finance_expenses_payee_id_foreign` (`payee_id`),
  ADD KEY `finance_expenses_category_id_foreign` (`category_id`);

--
-- Indexes for table `finance_payees`
--
ALTER TABLE `finance_payees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_payers`
--
ALTER TABLE `finance_payers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_transactions`
--
ALTER TABLE `finance_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `finance_transactions_company_id_foreign` (`company_id`),
  ADD KEY `finance_transactions_account_id_foreign` (`account_id`),
  ADD KEY `finance_transactions_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `finance_transactions_payee_id_foreign` (`payee_id`),
  ADD KEY `finance_transactions_payer_id_foreign` (`payer_id`),
  ADD KEY `finance_transactions_category_id_foreign` (`category_id`);

--
-- Indexes for table `finance_transfers`
--
ALTER TABLE `finance_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `finance_transfers_company_id_foreign` (`company_id`),
  ADD KEY `finance_transfers_from_account_id_foreign` (`from_account_id`),
  ADD KEY `finance_transfers_to_account_id_foreign` (`to_account_id`),
  ADD KEY `finance_transfers_payment_method_id_foreign` (`payment_method_id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goal_trackings`
--
ALTER TABLE `goal_trackings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goal_trackings_company_id_foreign` (`company_id`),
  ADD KEY `goal_trackings_goal_type_id_foreign` (`goal_type_id`);

--
-- Indexes for table `goal_types`
--
ALTER TABLE `goal_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `holidays_company_id_foreign` (`company_id`),
  ADD KEY `holidays_department_id_foreign` (`department_id`);

--
-- Indexes for table `indicators`
--
ALTER TABLE `indicators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indicators_company_id_foreign` (`company_id`),
  ADD KEY `indicators_department_id_foreign` (`department_id`),
  ADD KEY `indicators_designation_id_foreign` (`designation_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_client_id_foreign` (`client_id`),
  ADD KEY `invoices_project_id_foreign` (`project_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_items_project_id_foreign` (`project_id`);

--
-- Indexes for table `ip_settings`
--
ALTER TABLE `ip_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_candidates`
--
ALTER TABLE `job_candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_candidates_job_id_foreign` (`job_id`);

--
-- Indexes for table `job_categories`
--
ALTER TABLE `job_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_experiences`
--
ALTER TABLE `job_experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_interviews`
--
ALTER TABLE `job_interviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_interviews_job_id_foreign` (`job_id`),
  ADD KEY `job_interviews_added_by_foreign` (`added_by`);

--
-- Indexes for table `job_posts`
--
ALTER TABLE `job_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_posts_job_category_id_foreign` (`job_category_id`),
  ADD KEY `job_posts_company_id_foreign` (`company_id`),
  ADD KEY `job_posts_job_experience_id_foreign` (`job_experience_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leaves_company_id_foreign` (`company_id`),
  ADD KEY `leaves_employee_id_foreign` (`employee_id`),
  ADD KEY `leaves_leave_type_id_foreign` (`leave_type_id`),
  ADD KEY `leaves_department_id_foreign` (`department_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_types_company_id_foreign` (`company_id`);

--
-- Indexes for table `loan_types`
--
ALTER TABLE `loan_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locations_location_head_foreign` (`location_head`),
  ADD KEY `locations_country_foreign` (`country`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meetings_company_id_foreign` (`company_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `office_shifts`
--
ALTER TABLE `office_shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `office_shifts_company_id_foreign` (`company_id`);

--
-- Indexes for table `official_documents`
--
ALTER TABLE `official_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `official_documents_company_id_foreign` (`company_id`),
  ADD KEY `official_documents_document_type_id_foreign` (`document_type_id`),
  ADD KEY `official_documents_added_by_foreign` (`added_by`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_methods_company_id_foreign` (`company_id`);

--
-- Indexes for table `payslips`
--
ALTER TABLE `payslips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payslips_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `policies`
--
ALTER TABLE `policies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `policies_company_id_foreign` (`company_id`),
  ADD KEY `policies_added_by_foreign` (`added_by`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_client_id_foreign` (`client_id`),
  ADD KEY `projects_company_id_foreign` (`company_id`),
  ADD KEY `projects_added_by_foreign` (`added_by`);

--
-- Indexes for table `project_bugs`
--
ALTER TABLE `project_bugs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_bugs_user_id_foreign` (`user_id`),
  ADD KEY `project_bugs_project_id_foreign` (`project_id`);

--
-- Indexes for table `project_discussions`
--
ALTER TABLE `project_discussions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_discussions_user_id_foreign` (`user_id`),
  ADD KEY `project_discussions_project_id_foreign` (`project_id`);

--
-- Indexes for table `project_files`
--
ALTER TABLE `project_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_files_user_id_foreign` (`user_id`),
  ADD KEY `project_files_project_id_foreign` (`project_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotions_company_id_foreign` (`company_id`),
  ADD KEY `promotions_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `qualification_education_levels`
--
ALTER TABLE `qualification_education_levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qualification_education_levels_company_id_foreign` (`company_id`);

--
-- Indexes for table `qualification_languages`
--
ALTER TABLE `qualification_languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qualification_languages_company_id_foreign` (`company_id`);

--
-- Indexes for table `qualification_skills`
--
ALTER TABLE `qualification_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qualification_skills_company_id_foreign` (`company_id`);

--
-- Indexes for table `relation_types`
--
ALTER TABLE `relation_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resignations`
--
ALTER TABLE `resignations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resignations_company_id_foreign` (`company_id`),
  ADD KEY `resignations_department_id_foreign` (`department_id`),
  ADD KEY `resignations_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `salary_allowances`
--
ALTER TABLE `salary_allowances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_allowances_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `salary_basics`
--
ALTER TABLE `salary_basics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_basics_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `salary_commissions`
--
ALTER TABLE `salary_commissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_commissions_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `salary_deductions`
--
ALTER TABLE `salary_deductions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_deductions_employee_id_foreign` (`employee_id`),
  ADD KEY `salary_deductions_deduction_type_id_foreign` (`deduction_type_id`);

--
-- Indexes for table `salary_loans`
--
ALTER TABLE `salary_loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_loans_employee_id_foreign` (`employee_id`),
  ADD KEY `salary_loans_loan_type_id_foreign` (`loan_type_id`);

--
-- Indexes for table `salary_other_payments`
--
ALTER TABLE `salary_other_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_other_payments_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `salary_overtimes`
--
ALTER TABLE `salary_overtimes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_overtimes_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `support_tickets_ticket_code_unique` (`ticket_code`),
  ADD KEY `support_tickets_company_id_foreign` (`company_id`),
  ADD KEY `support_tickets_department_id_foreign` (`department_id`),
  ADD KEY `support_tickets_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_project_id_foreign` (`project_id`),
  ADD KEY `tasks_company_id_foreign` (`company_id`),
  ADD KEY `tasks_added_by_foreign` (`added_by`);

--
-- Indexes for table `task_discussions`
--
ALTER TABLE `task_discussions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_discussions_user_id_foreign` (`user_id`),
  ADD KEY `task_discussions_task_id_foreign` (`task_id`);

--
-- Indexes for table `task_files`
--
ALTER TABLE `task_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_files_user_id_foreign` (`user_id`),
  ADD KEY `task_files_task_id_foreign` (`task_id`);

--
-- Indexes for table `tax_types`
--
ALTER TABLE `tax_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terminations`
--
ALTER TABLE `terminations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `terminations_company_id_foreign` (`company_id`),
  ADD KEY `terminations_terminated_employee_foreign` (`terminated_employee`),
  ADD KEY `terminations_termination_type_foreign` (`termination_type`);

--
-- Indexes for table `termination_types`
--
ALTER TABLE `termination_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_comments_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainers_company_id_foreign` (`company_id`);

--
-- Indexes for table `training_lists`
--
ALTER TABLE `training_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `training_lists_company_id_foreign` (`company_id`),
  ADD KEY `training_lists_trainer_id_foreign` (`trainer_id`),
  ADD KEY `training_lists_training_type_id_foreign` (`training_type_id`);

--
-- Indexes for table `training_types`
--
ALTER TABLE `training_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfers_company_id_foreign` (`company_id`),
  ADD KEY `transfers_from_department_id_foreign` (`from_department_id`),
  ADD KEY `transfers_to_department_id_foreign` (`to_department_id`),
  ADD KEY `transfers_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translations_language_id_foreign` (`language_id`);

--
-- Indexes for table `travels`
--
ALTER TABLE `travels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `travels_company_id_foreign` (`company_id`),
  ADD KEY `travels_employee_id_foreign` (`employee_id`),
  ADD KEY `travels_travel_type_foreign` (`travel_type`);

--
-- Indexes for table `travel_types`
--
ALTER TABLE `travel_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `travel_types_company_id_foreign` (`company_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_role_users_id_foreign` (`role_users_id`);

--
-- Indexes for table `warnings`
--
ALTER TABLE `warnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warnings_company_id_foreign` (`company_id`),
  ADD KEY `warnings_warning_to_foreign` (`warning_to`),
  ADD KEY `warnings_warning_type_foreign` (`warning_type`);

--
-- Indexes for table `warnings_type`
--
ALTER TABLE `warnings_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appraisals`
--
ALTER TABLE `appraisals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `appraisal_sections`
--
ALTER TABLE `appraisal_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `appraisal_section_indicators`
--
ALTER TABLE `appraisal_section_indicators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_categories`
--
ALTER TABLE `asset_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `award_types`
--
ALTER TABLE `award_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `calendarables`
--
ALTER TABLE `calendarables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `company_types`
--
ALTER TABLE `company_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `c_m_s`
--
ALTER TABLE `c_m_s`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deduction_types`
--
ALTER TABLE `deduction_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `deposit_categories`
--
ALTER TABLE `deposit_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `employee_bank_accounts`
--
ALTER TABLE `employee_bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employee_contacts`
--
ALTER TABLE `employee_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee_documents`
--
ALTER TABLE `employee_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employee_immigrations`
--
ALTER TABLE `employee_immigrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employee_leave_type_details`
--
ALTER TABLE `employee_leave_type_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `employee_qualificaitons`
--
ALTER TABLE `employee_qualificaitons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_work_experience`
--
ALTER TABLE `employee_work_experience`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expense_types`
--
ALTER TABLE `expense_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_managers`
--
ALTER TABLE `file_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `file_manager_settings`
--
ALTER TABLE `file_manager_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `finance_bank_cashes`
--
ALTER TABLE `finance_bank_cashes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `finance_deposits`
--
ALTER TABLE `finance_deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `finance_expenses`
--
ALTER TABLE `finance_expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `finance_payees`
--
ALTER TABLE `finance_payees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `finance_payers`
--
ALTER TABLE `finance_payers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `finance_transactions`
--
ALTER TABLE `finance_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `finance_transfers`
--
ALTER TABLE `finance_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `goal_trackings`
--
ALTER TABLE `goal_trackings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `goal_types`
--
ALTER TABLE `goal_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `indicators`
--
ALTER TABLE `indicators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ip_settings`
--
ALTER TABLE `ip_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `job_candidates`
--
ALTER TABLE `job_candidates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job_categories`
--
ALTER TABLE `job_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `job_experiences`
--
ALTER TABLE `job_experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `job_interviews`
--
ALTER TABLE `job_interviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `job_posts`
--
ALTER TABLE `job_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `loan_types`
--
ALTER TABLE `loan_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT for table `office_shifts`
--
ALTER TABLE `office_shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `official_documents`
--
ALTER TABLE `official_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payslips`
--
ALTER TABLE `payslips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=298;

--
-- AUTO_INCREMENT for table `policies`
--
ALTER TABLE `policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project_bugs`
--
ALTER TABLE `project_bugs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_discussions`
--
ALTER TABLE `project_discussions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project_files`
--
ALTER TABLE `project_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `qualification_education_levels`
--
ALTER TABLE `qualification_education_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `qualification_languages`
--
ALTER TABLE `qualification_languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `qualification_skills`
--
ALTER TABLE `qualification_skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `relation_types`
--
ALTER TABLE `relation_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `resignations`
--
ALTER TABLE `resignations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `salary_allowances`
--
ALTER TABLE `salary_allowances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `salary_basics`
--
ALTER TABLE `salary_basics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `salary_commissions`
--
ALTER TABLE `salary_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `salary_deductions`
--
ALTER TABLE `salary_deductions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `salary_loans`
--
ALTER TABLE `salary_loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `salary_other_payments`
--
ALTER TABLE `salary_other_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `salary_overtimes`
--
ALTER TABLE `salary_overtimes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `task_discussions`
--
ALTER TABLE `task_discussions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task_files`
--
ALTER TABLE `task_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tax_types`
--
ALTER TABLE `tax_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `terminations`
--
ALTER TABLE `terminations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `termination_types`
--
ALTER TABLE `termination_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `training_lists`
--
ALTER TABLE `training_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `training_types`
--
ALTER TABLE `training_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `travels`
--
ALTER TABLE `travels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `travel_types`
--
ALTER TABLE `travel_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `warnings`
--
ALTER TABLE `warnings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `warnings_type`
--
ALTER TABLE `warnings_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcements_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `appraisals`
--
ALTER TABLE `appraisals`
  ADD CONSTRAINT `appraisals_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appraisals_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appraisals_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appraisals_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `appraisal_sections`
--
ALTER TABLE `appraisal_sections`
  ADD CONSTRAINT `fk_appraisal_sections_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_assets_category_id_foreign` FOREIGN KEY (`assets_category_id`) REFERENCES `asset_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assets_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assets_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `asset_categories`
--
ALTER TABLE `asset_categories`
  ADD CONSTRAINT `asset_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `awards`
--
ALTER TABLE `awards`
  ADD CONSTRAINT `awards_award_type_id_foreign` FOREIGN KEY (`award_type_id`) REFERENCES `award_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `awards_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `awards_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `awards_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `candidate_interview`
--
ALTER TABLE `candidate_interview`
  ADD CONSTRAINT `candidate_interview_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `job_candidates` (`id`),
  ADD CONSTRAINT `candidate_interview_interview_id_foreign` FOREIGN KEY (`interview_id`) REFERENCES `job_interviews` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_company_type_id_foreign` FOREIGN KEY (`company_type_id`) REFERENCES `company_types` (`id`),
  ADD CONSTRAINT `companies_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `complaints_complaint_against_foreign` FOREIGN KEY (`complaint_against`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `complaints_complaint_from_foreign` FOREIGN KEY (`complaint_from`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `departments_department_head_foreign` FOREIGN KEY (`department_head`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `designations`
--
ALTER TABLE `designations`
  ADD CONSTRAINT `designations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `designations_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employees_office_shift_id_foreign` FOREIGN KEY (`office_shift_id`) REFERENCES `office_shifts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employees_role_users_id_foreign` FOREIGN KEY (`role_users_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employees_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employee_bank_accounts`
--
ALTER TABLE `employee_bank_accounts`
  ADD CONSTRAINT `employee_bank_accounts_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_contacts`
--
ALTER TABLE `employee_contacts`
  ADD CONSTRAINT `employee_contacts_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_contacts_relation_type_id_foreign` FOREIGN KEY (`relation_type_id`) REFERENCES `relation_types` (`id`);

--
-- Constraints for table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD CONSTRAINT `employee_documents_document_type_id_foreign` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employee_documents_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_immigrations`
--
ALTER TABLE `employee_immigrations`
  ADD CONSTRAINT `employee_immigrations_document_type_id_foreign` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employee_immigrations_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_interview`
--
ALTER TABLE `employee_interview`
  ADD CONSTRAINT `employee_interview_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `employee_interview_interview_id_foreign` FOREIGN KEY (`interview_id`) REFERENCES `job_interviews` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_leave_type_details`
--
ALTER TABLE `employee_leave_type_details`
  ADD CONSTRAINT `employee_leave_type_details_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_meeting`
--
ALTER TABLE `employee_meeting`
  ADD CONSTRAINT `employee_meeting_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_meeting_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_project`
--
ALTER TABLE `employee_project`
  ADD CONSTRAINT `employee_project_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_project_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_qualificaitons`
--
ALTER TABLE `employee_qualificaitons`
  ADD CONSTRAINT `employee_qualificaitons_education_level_id_foreign` FOREIGN KEY (`education_level_id`) REFERENCES `qualification_education_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employee_qualificaitons_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_qualificaitons_general_skill_id_foreign` FOREIGN KEY (`general_skill_id`) REFERENCES `qualification_skills` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employee_qualificaitons_language_skill_id_foreign` FOREIGN KEY (`language_skill_id`) REFERENCES `qualification_languages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employee_support_ticket`
--
ALTER TABLE `employee_support_ticket`
  ADD CONSTRAINT `employee_support_ticket_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_support_ticket_support_ticket_id_foreign` FOREIGN KEY (`support_ticket_id`) REFERENCES `support_tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_task`
--
ALTER TABLE `employee_task`
  ADD CONSTRAINT `employee_task_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_task_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_training_list`
--
ALTER TABLE `employee_training_list`
  ADD CONSTRAINT `employee_training_list_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_training_list_training_list_id_foreign` FOREIGN KEY (`training_list_id`) REFERENCES `training_lists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_work_experience`
--
ALTER TABLE `employee_work_experience`
  ADD CONSTRAINT `employee_work_experience_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expense_types`
--
ALTER TABLE `expense_types`
  ADD CONSTRAINT `expense_types_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `file_managers`
--
ALTER TABLE `file_managers`
  ADD CONSTRAINT `file_managers_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `file_managers_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `finance_deposits`
--
ALTER TABLE `finance_deposits`
  ADD CONSTRAINT `finance_deposits_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `finance_bank_cashes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_deposits_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_deposits_deposit_category_id_foreign` FOREIGN KEY (`deposit_category_id`) REFERENCES `deposit_categories` (`id`),
  ADD CONSTRAINT `finance_deposits_payer_id_foreign` FOREIGN KEY (`payer_id`) REFERENCES `finance_payers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_deposits_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `finance_expenses`
--
ALTER TABLE `finance_expenses`
  ADD CONSTRAINT `finance_expenses_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `finance_bank_cashes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `expense_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_expenses_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_expenses_payee_id_foreign` FOREIGN KEY (`payee_id`) REFERENCES `finance_payees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_expenses_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `finance_transactions`
--
ALTER TABLE `finance_transactions`
  ADD CONSTRAINT `finance_transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `finance_bank_cashes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_transactions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `expense_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_transactions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_transactions_payee_id_foreign` FOREIGN KEY (`payee_id`) REFERENCES `finance_payees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_transactions_payer_id_foreign` FOREIGN KEY (`payer_id`) REFERENCES `finance_payers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_transactions_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `finance_transfers`
--
ALTER TABLE `finance_transfers`
  ADD CONSTRAINT `finance_transfers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_transfers_from_account_id_foreign` FOREIGN KEY (`from_account_id`) REFERENCES `finance_bank_cashes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_transfers_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `finance_transfers_to_account_id_foreign` FOREIGN KEY (`to_account_id`) REFERENCES `finance_bank_cashes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `goal_trackings`
--
ALTER TABLE `goal_trackings`
  ADD CONSTRAINT `goal_trackings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goal_trackings_goal_type_id_foreign` FOREIGN KEY (`goal_type_id`) REFERENCES `goal_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `holidays`
--
ALTER TABLE `holidays`
  ADD CONSTRAINT `holidays_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `holidays_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `indicators`
--
ALTER TABLE `indicators`
  ADD CONSTRAINT `indicators_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `indicators_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `indicators_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_items_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_candidates`
--
ALTER TABLE `job_candidates`
  ADD CONSTRAINT `job_candidates_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`id`);

--
-- Constraints for table `job_interviews`
--
ALTER TABLE `job_interviews`
  ADD CONSTRAINT `job_interviews_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `job_interviews_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_posts`
--
ALTER TABLE `job_posts`
  ADD CONSTRAINT `job_posts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_posts_job_category_id_foreign` FOREIGN KEY (`job_category_id`) REFERENCES `job_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_posts_job_experience_id_foreign` FOREIGN KEY (`job_experience_id`) REFERENCES `job_experiences` (`id`);

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `leaves_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leaves_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leaves_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leaves_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD CONSTRAINT `leave_types_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_country_foreign` FOREIGN KEY (`country`) REFERENCES `countries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `locations_location_head_foreign` FOREIGN KEY (`location_head`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `meetings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `office_shifts`
--
ALTER TABLE `office_shifts`
  ADD CONSTRAINT `office_shifts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `official_documents`
--
ALTER TABLE `official_documents`
  ADD CONSTRAINT `official_documents_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `official_documents_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `official_documents_document_type_id_foreign` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payslips`
--
ALTER TABLE `payslips`
  ADD CONSTRAINT `payslips_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `policies`
--
ALTER TABLE `policies`
  ADD CONSTRAINT `policies_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `projects_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `projects_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_bugs`
--
ALTER TABLE `project_bugs`
  ADD CONSTRAINT `project_bugs_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_bugs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `project_discussions`
--
ALTER TABLE `project_discussions`
  ADD CONSTRAINT `project_discussions_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_discussions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `project_files`
--
ALTER TABLE `project_files`
  ADD CONSTRAINT `project_files_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `promotions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotions_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `qualification_education_levels`
--
ALTER TABLE `qualification_education_levels`
  ADD CONSTRAINT `qualification_education_levels_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `qualification_languages`
--
ALTER TABLE `qualification_languages`
  ADD CONSTRAINT `qualification_languages_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `qualification_skills`
--
ALTER TABLE `qualification_skills`
  ADD CONSTRAINT `qualification_skills_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resignations`
--
ALTER TABLE `resignations`
  ADD CONSTRAINT `resignations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resignations_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resignations_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salary_allowances`
--
ALTER TABLE `salary_allowances`
  ADD CONSTRAINT `salary_allowances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salary_basics`
--
ALTER TABLE `salary_basics`
  ADD CONSTRAINT `salary_basics_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salary_commissions`
--
ALTER TABLE `salary_commissions`
  ADD CONSTRAINT `salary_commissions_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salary_deductions`
--
ALTER TABLE `salary_deductions`
  ADD CONSTRAINT `salary_deductions_deduction_type_id_foreign` FOREIGN KEY (`deduction_type_id`) REFERENCES `deduction_types` (`id`),
  ADD CONSTRAINT `salary_deductions_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salary_loans`
--
ALTER TABLE `salary_loans`
  ADD CONSTRAINT `salary_loans_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `salary_loans_loan_type_id_foreign` FOREIGN KEY (`loan_type_id`) REFERENCES `loan_types` (`id`);

--
-- Constraints for table `salary_other_payments`
--
ALTER TABLE `salary_other_payments`
  ADD CONSTRAINT `salary_other_payments_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salary_overtimes`
--
ALTER TABLE `salary_overtimes`
  ADD CONSTRAINT `salary_overtimes_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `support_tickets_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `support_tickets_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_discussions`
--
ALTER TABLE `task_discussions`
  ADD CONSTRAINT `task_discussions_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_discussions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `task_files`
--
ALTER TABLE `task_files`
  ADD CONSTRAINT `task_files_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `terminations`
--
ALTER TABLE `terminations`
  ADD CONSTRAINT `terminations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `terminations_terminated_employee_foreign` FOREIGN KEY (`terminated_employee`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `terminations_termination_type_foreign` FOREIGN KEY (`termination_type`) REFERENCES `termination_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD CONSTRAINT `ticket_comments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `support_tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `trainers`
--
ALTER TABLE `trainers`
  ADD CONSTRAINT `trainers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `training_lists`
--
ALTER TABLE `training_lists`
  ADD CONSTRAINT `training_lists_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `training_lists_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `training_lists_training_type_id_foreign` FOREIGN KEY (`training_type_id`) REFERENCES `training_types` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_from_department_id_foreign` FOREIGN KEY (`from_department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_to_department_id_foreign` FOREIGN KEY (`to_department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `translations`
--
ALTER TABLE `translations`
  ADD CONSTRAINT `translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `travels`
--
ALTER TABLE `travels`
  ADD CONSTRAINT `travels_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `travels_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `travels_travel_type_foreign` FOREIGN KEY (`travel_type`) REFERENCES `travel_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `travel_types`
--
ALTER TABLE `travel_types`
  ADD CONSTRAINT `travel_types_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_users_id_foreign` FOREIGN KEY (`role_users_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `warnings`
--
ALTER TABLE `warnings`
  ADD CONSTRAINT `warnings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `warnings_warning_to_foreign` FOREIGN KEY (`warning_to`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `warnings_warning_type_foreign` FOREIGN KEY (`warning_type`) REFERENCES `warnings_type` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
