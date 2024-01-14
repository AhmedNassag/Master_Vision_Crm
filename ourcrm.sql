-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2023 at 04:13 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ourcrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `activates`
--

CREATE TABLE `activates` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activates`
--

INSERT INTO `activates` (`id`, `deleted_at`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, '2023-09-03 11:30:06', '2023-09-03 11:30:06', 'رحلات داخليه'),
(2, NULL, '2023-09-03 11:30:13', '2023-09-03 11:30:13', 'حج وعمرة');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `city_id` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `deleted_at`, `created_at`, `updated_at`, `name`, `city_id`) VALUES
(1, NULL, '2023-09-03 11:41:27', '2023-09-03 11:41:27', 'Haram', 1);

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `attachment_name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `deleted_at`, `created_at`, `updated_at`, `customer_id`, `attachment_name`, `attachment`) VALUES
(1, NULL, '2023-09-06 19:48:18', '2023-09-06 19:49:51', 3, 'National ID', '0'),
(2, NULL, '2023-09-06 19:49:10', '2023-09-06 19:49:10', 1, 'adsas', '0'),
(3, NULL, '2023-09-07 13:26:10', '2023-09-07 13:26:10', 1, 'ID', 'uploads/1694093170_laraadmin.PNG'),
(4, NULL, '2023-09-07 13:27:10', '2023-09-07 13:27:10', 1, 'ID 2', 'uploads/1694093230_laraadmin.PNG'),
(5, NULL, '2023-09-07 13:43:22', '2023-09-07 13:43:22', 1, 'Test', 'uploads/1694094202_laraadmin.PNG'),
(6, '2023-09-07 14:01:09', '2023-09-07 13:46:23', '2023-09-07 14:01:09', 1, 'Test 2', 'uploads/1694094383_laraadmin.PNG'),
(7, NULL, '2023-09-07 14:09:16', '2023-09-07 14:09:16', 1, 'Testdsd', 'uploads/1694095756_laraadmin.PNG'),
(8, NULL, '2023-09-07 14:09:56', '2023-09-07 14:09:56', 1, 'adasd', 'uploads/1694095796_laraadmin.PNG'),
(9, '2023-09-07 14:12:06', '2023-09-07 14:12:00', '2023-09-07 14:12:06', 1, 'dasasdsad', 'uploads/1694095920_laraadmin.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `deleted_at`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, '2023-09-03 11:41:18', '2023-09-03 11:41:18', 'Giza');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mobile2` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `area_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `contact_source_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `job_title_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `industry_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `major_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('new','contacted','qualified','converted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_category_id` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '[]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `deleted_at`, `created_at`, `updated_at`, `name`, `mobile`, `mobile2`, `email`, `company_name`, `city_id`, `area_id`, `contact_source_id`, `created_by`, `job_title_id`, `industry_id`, `major_id`, `notes`, `activity_id`, `gender`, `customer_id`, `status`, `employee_id`, `contact_category_id`) VALUES
(1, NULL, '2023-09-04 06:51:08', '2023-09-06 10:57:02', 'Abdelrahman', '01118187035', '', 'admin@ourcrm.info', 'Test', 1, 1, 1, 1, 1, 1, 1, '', 1, 'Male', 1, 'converted', 2, '[]'),
(2, NULL, '2023-09-04 13:20:40', '2023-09-06 10:57:02', 'Test Lead', '01091932580', '', 'test@gmail.com', 'Test', 1, 1, 1, 1, 1, 1, 1, 'Test Notes', 1, 'Male', 2, 'converted', 2, '[]'),
(3, NULL, '2023-09-05 07:40:56', '2023-09-06 19:34:30', 'Lead Name', '01091932583', '', 'testemail@gmail.com', 'Test', 1, 1, 1, 1, 1, 1, 1, 'adasdsad', 2, 'Male', NULL, 'contacted', NULL, '[]'),
(4, NULL, '2023-09-06 07:35:24', '2023-09-06 07:42:54', 'Waleed Test', '01099933586', '01099933586', 'testwaleed@gmail.com', 'Test Company', 1, 1, 1, 1, 1, 1, 1, 'يطلب مفاوضة', 2, 'Male', 3, 'converted', NULL, '[]'),
(5, NULL, '2023-09-07 12:20:59', '2023-09-07 12:20:59', 'Abddelrahman Abddelrahman', '01091932236', '', 'adsadasd@gmail.com', 'asdasd', 1, 1, 1, 1, 1, 1, 1, '', 1, 'Male', NULL, 'new', NULL, '[\"1\"]'),
(6, NULL, '2023-09-07 12:21:15', '2023-09-07 12:21:15', 'Abddelrahman Abddelrahman', '01091932236', '', 'adsadasd@gmail.com', 'asdasd', 1, 1, 1, 1, 1, 1, 1, '', 1, 'Male', NULL, 'new', NULL, '[\"1\"]'),
(7, NULL, '2023-09-07 12:21:47', '2023-09-07 12:21:47', 'Abddelrahman Abddelrahman', '01091932236', '', 'adsadasd@gmail.com', 'asdasd', 1, 1, 1, 1, 1, 1, 1, '', 1, 'Male', NULL, 'new', NULL, '[\"1\"]'),
(8, NULL, '2023-09-07 12:45:14', '2023-09-07 12:47:03', 'Abddelrahman Asdss', '01000932586', '', 'adsadadsd@gmail.com', 'Test', 1, 1, 1, 1, 1, 1, 1, '', 1, 'Male', NULL, 'new', NULL, '[\"1\",\"2\"]');

-- --------------------------------------------------------

--
-- Table structure for table `contact_categories`
--

CREATE TABLE `contact_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_categories`
--

INSERT INTO `contact_categories` (`id`, `deleted_at`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, '2023-09-03 11:40:12', '2023-09-03 11:40:12', 'Test Category'),
(2, NULL, '2023-09-07 12:44:27', '2023-09-07 12:44:27', 'A+');

-- --------------------------------------------------------

--
-- Table structure for table `contact_sources`
--

CREATE TABLE `contact_sources` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_sources`
--

INSERT INTO `contact_sources` (`id`, `deleted_at`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, '2023-09-03 11:41:03', '2023-09-03 11:41:03', 'facebook');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mobile` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mobile2` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_title_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `contact_category_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `contact_source_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `city_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `area_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `major_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `activity_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `industry_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `gender`, `name`, `mobile`, `mobile2`, `email`, `company_name`, `job_title_id`, `contact_category_id`, `contact_source_id`, `city_id`, `area_id`, `major_id`, `activity_id`, `created_by`, `notes`, `industry_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '', 'Abdelrahman', '01118187035', '', 'admin@ourcrm.info', 'Test', 1, 1, 1, 1, 1, 1, 1, 1, '', 1, NULL, '2023-09-04 11:03:18', '2023-09-04 11:03:18'),
(2, 'Male', 'Test Lead', '01091932580', '', 'test@gmail.com', 'Test', 1, 1, 1, 1, 1, 1, 1, 1, 'Test Notes', 1, NULL, '2023-09-05 07:47:37', '2023-09-05 07:47:37'),
(3, 'Male', 'Waleed Test', '01099933586', '01099933586', 'testwaleed@gmail.com', 'Test Company', 1, 1, 1, 1, 1, 1, 1, 1, 'يطلب مفاوضة', 1, NULL, '2023-09-06 07:42:54', '2023-09-06 07:42:54');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `dept` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `mobile`, `email`, `dept`, `deleted_at`, `created_at`, `updated_at`, `active`) VALUES
(1, 'Admin', '8888888888', 'admin@ourcrm.info', 1, NULL, '2021-02-10 14:10:32', '2021-02-10 14:10:32', 1),
(2, 'Test Employee', '01091932522', 'sales@gmail.com', 1, NULL, '2023-09-06 08:25:20', '2023-09-06 08:25:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_targets`
--

CREATE TABLE `employee_targets` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `month` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `target_amount` decimal(15,3) NOT NULL DEFAULT 0.000,
  `target_meeting` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_targets`
--

INSERT INTO `employee_targets` (`id`, `deleted_at`, `created_at`, `updated_at`, `employee_id`, `month`, `target_amount`, `target_meeting`) VALUES
(1, '2023-09-06 10:13:41', '2023-09-06 10:06:06', '2023-09-06 10:13:41', 2, '2023-09', '10.000', 20),
(2, NULL, '2023-09-06 10:09:16', '2023-09-06 10:09:16', 2, '2023-10', '10.000', 100),
(3, NULL, '2023-09-06 10:14:08', '2023-09-06 10:14:08', 2, '2023-09', '20.000', 20),
(4, NULL, '2023-09-07 10:54:59', '2023-09-07 10:54:59', 2, '2023-12', '200.000', 100);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `industries`
--

CREATE TABLE `industries` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `industries`
--

INSERT INTO `industries` (`id`, `deleted_at`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, '2023-09-03 11:40:33', '2023-09-03 11:40:33', 'Test Industry'),
(2, NULL, '2023-09-07 09:46:42', '2023-09-07 09:46:42', 'Test 2');

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE `interests` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `activity_id` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `interests`
--

INSERT INTO `interests` (`id`, `deleted_at`, `created_at`, `updated_at`, `name`, `activity_id`) VALUES
(1, NULL, '2023-09-03 11:30:34', '2023-09-03 11:30:34', 'اسوان', 1);

-- --------------------------------------------------------

--
-- Table structure for table `interest_meeting`
--

CREATE TABLE `interest_meeting` (
  `interest_id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `interest_meeting`
--

INSERT INTO `interest_meeting` (`interest_id`, `meeting_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `debt` decimal(10,2) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','sent','paid','void') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'void',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `invoice_date`, `total_amount`, `amount_paid`, `debt`, `customer_id`, `activity_id`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, '4324234', '2023-09-05', '100.00', '100.00', '0.00', 1, 1, 'تيسست', 'paid', '2023-09-04 12:18:58', '2023-09-04 12:18:58'),
(3, '43242343223', '2023-09-05', '100.00', '90.00', '0.00', 1, 1, 'تيسست', 'paid', '2023-09-04 12:18:58', '2023-09-04 12:18:58'),
(4, '4324234782', '2023-09-07', '100.00', '70.00', '30.00', 2, 2, 'Test Description', 'paid', '2023-09-05 07:47:37', '2023-09-05 07:47:37'),
(5, '4564636', '2023-09-06', '100.00', '70.00', '30.00', 3, 1, 'Test Invoice', 'paid', '2023-09-06 07:42:54', '2023-09-06 07:42:54');

-- --------------------------------------------------------

--
-- Table structure for table `job_titles`
--

CREATE TABLE `job_titles` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_titles`
--

INSERT INTO `job_titles` (`id`, `deleted_at`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, NULL, NULL, 'Test Job');

-- --------------------------------------------------------

--
-- Table structure for table `la_configs`
--

CREATE TABLE `la_configs` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `la_configs`
--

INSERT INTO `la_configs` (`id`, `key`, `section`, `value`, `created_at`, `updated_at`) VALUES
(1, 'sitename', '', 'Our Crm', '2020-06-04 08:15:25', '2021-04-02 23:51:14'),
(2, 'sitename_part1', '', 'Our', '2020-06-04 08:15:25', '2021-04-02 23:51:14'),
(3, 'sitename_part2', '', 'CRM', '2020-06-04 08:15:26', '2021-04-02 23:51:14'),
(4, 'sitename_short', '', 'OC', '2020-06-04 08:15:26', '2021-04-02 23:51:14'),
(6, 'sidebar_search', '', '0', '2020-06-04 08:15:26', '2021-04-02 23:51:15'),
(7, 'show_messages', '', '0', '2020-06-04 08:15:26', '2021-04-02 23:51:15'),
(8, 'show_notifications', '', '1', '2020-06-04 08:15:26', '2021-04-02 23:51:14'),
(9, 'show_tasks', '', '0', '2020-06-04 08:15:26', '2021-04-02 23:51:15'),
(10, 'show_rightsidebar', '', '0', '2020-06-04 08:15:26', '2021-04-02 23:51:15'),
(11, 'skin', '', 'skin-purple', '2020-06-04 08:15:26', '2021-04-02 23:51:14'),
(12, 'layout', '', 'fixed', '2020-06-04 08:15:26', '2021-04-02 23:51:14'),
(13, 'default_email', '', 'info@ourcrm.info', '2020-06-04 08:15:26', '2021-04-02 23:51:14'),
(14, 'site_description', '', '', NULL, '2021-04-02 23:51:14'),
(15, 'currency_symbol', '', 'EGP', NULL, '2021-04-02 23:51:15'),
(16, 'end_date', '', '2023-10-30', NULL, NULL),
(17, 'max_users', '', '10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `la_menus`
--

CREATE TABLE `la_menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fa-cube',
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'module',
  `parent` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `hierarchy` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `la_menus`
--

INSERT INTO `la_menus` (`id`, `label`, `name`, `url`, `icon`, `type`, `parent`, `hierarchy`, `created_at`, `updated_at`) VALUES
(1, 'Team', 'Team', '#', 'fa-users', 'custom', 0, 8, '2021-02-13 14:50:02', '2023-09-03 14:08:10'),
(3, 'Roles', 'Roles', 'roles', 'fa-user-plus', 'module', 1, 1, '2021-02-13 14:50:15', '2021-02-13 14:50:50'),
(5, 'Departments', 'Departments', 'departments', 'fa-tags', 'module', 1, 2, '2021-02-13 14:50:35', '2021-03-27 12:58:14'),
(6, 'Employees', 'Employees', 'employees', 'fa-group', 'module', 1, 3, '2021-02-13 14:50:39', '2021-03-27 12:58:14'),
(11, 'Interests', 'Interests', 'interests', 'fa fa-cubes', 'module', 0, 4, '2021-03-27 12:36:06', '2023-09-03 14:06:40'),
(12, 'Contact_sources', 'Contact_sources', 'contact_sources', 'fa fa-bullhorn', 'module', 18, 5, '2021-03-27 12:42:14', '2023-09-03 11:29:29'),
(13, 'Cities', 'Cities', 'cities', 'fa fa-map-marker', 'module', 17, 1, '2021-03-27 12:51:51', '2021-03-27 12:58:14'),
(14, 'Areas', 'Areas', 'areas', 'fa fa-map-pin', 'module', 17, 2, '2021-03-27 12:52:46', '2021-03-27 12:58:22'),
(15, 'Contact_categories', 'Contact_categories', 'contact_categories', 'fa fa-sitemap', 'module', 18, 6, '2021-03-27 12:54:21', '2023-09-03 11:29:29'),
(16, 'Contacts', 'Contacts', 'contacts', 'fa fa-user-secret', 'module', 32, 1, '2021-03-27 12:57:26', '2023-09-03 14:06:40'),
(17, 'Locations', 'Locations', '#', 'fa-map-marker', 'custom', 0, 3, '2021-03-27 12:58:07', '2023-09-03 14:06:40'),
(18, 'Main Data', 'Main Data', '#', 'fa-user-plus', 'custom', 0, 1, '2021-03-27 12:58:44', '2023-09-03 14:06:13'),
(19, 'Calls / Meetings', 'Meetings', 'meetings', 'fa fa-phone', 'module', 32, 3, '2021-03-27 18:09:52', '2023-09-03 14:08:10'),
(21, 'reports', 'reports', '#', 'fa-files-o', 'custom', 0, 6, '2021-03-28 09:38:40', '2023-09-03 14:08:10'),
(22, 'Calls / Meetings Report', 'Meetings Report', 'meetings_report', 'fa-phone', 'custom', 21, 1, '2021-03-28 09:39:17', '2021-03-28 09:39:21'),
(23, 'Contacts Report', 'Contacts Report', 'contacts_report', 'fa-files-o', 'custom', 21, 2, '2021-03-28 09:59:39', '2021-03-28 09:59:50'),
(24, 'Job_titles', 'Job_titles', 'job_titles', 'fa fa-align-justify', 'module', 18, 4, '2021-03-29 07:29:01', '2023-09-03 11:29:29'),
(25, 'Industries', 'Industries', 'industries', 'fa fa-sitemap', 'module', 18, 2, '2021-03-29 07:30:14', '2023-09-03 11:29:29'),
(26, 'Majors', 'Majors', 'majors', 'fa fa-align-center', 'module', 18, 3, '2021-03-29 07:31:20', '2023-09-03 11:29:29'),
(27, 'Employee_targets', 'Employee_targets', 'employee_targets', 'fa fa-long-arrow-up', 'module', 0, 5, '2021-03-30 06:47:42', '2023-09-03 14:08:10'),
(28, 'Notifications', 'Notifications', 'notifications', 'fa fa-bell', 'module', 0, 7, '2021-03-31 16:54:24', '2023-09-03 14:08:10'),
(29, 'Activates', 'Activates', 'activates', 'fa fa-book', 'module', 18, 1, '2023-09-03 11:28:46', '2023-09-03 11:29:29'),
(31, 'Customers', 'Customers', 'customers', 'fa fa-users', 'module', 32, 2, '2023-09-03 12:36:59', '2023-09-03 14:06:40'),
(32, 'CRM', 'CRM', '#', 'fa-cube', 'custom', 0, 2, '2023-09-03 14:05:57', '2023-09-03 14:06:35'),
(33, 'Attachments', 'Attachments', 'attachments', 'fa fa-file-photo-o', 'module', 0, 0, '2023-09-06 19:42:05', '2023-09-06 19:42:05'),
(34, 'Lead_cteagories', 'Lead_cteagories', 'lead_cteagories', 'fa fa-cube', 'module', 0, 0, '2023-09-07 09:59:17', '2023-09-07 09:59:17');

-- --------------------------------------------------------

--
-- Table structure for table `lead_cteagories`
--

CREATE TABLE `lead_cteagories` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `contact_category_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `contact_id` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_cteagories`
--

INSERT INTO `lead_cteagories` (`id`, `deleted_at`, `created_at`, `updated_at`, `contact_category_id`, `contact_id`) VALUES
(2, NULL, NULL, NULL, 1, 7),
(3, NULL, NULL, NULL, 1, 8),
(5, NULL, NULL, NULL, 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `lead_histories`
--

CREATE TABLE `lead_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `action` int(11) NOT NULL,
  `related_model_id` bigint(20) UNSIGNED NOT NULL,
  `placeholders` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`placeholders`)),
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_histories`
--

INSERT INTO `lead_histories` (`id`, `contact_id`, `action`, `related_model_id`, `placeholders`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, '{\"notes\":\"adas\",\"follow_date\":\"2023-09-04\",\"meeting_id\":2,\"created_by\":1}', 1, '2023-09-05 08:57:50', '2023-09-04 08:57:50'),
(2, 1, 1, 3, '{\"notes\":\"asdsadasasdas\",\"follow_date\":\"2023-09-04\",\"meeting_id\":3,\"created_by\":1}', 1, '2023-09-04 10:28:18', '2023-09-04 10:28:18'),
(3, 1, 2, 1, '{\"from\":\"new\",\"to\":\"contacted\"}', 1, '2023-09-04 10:50:31', '2023-09-04 10:50:31'),
(4, 1, 2, 1, '{\"from\":\"contacted\",\"to\":\"qualified\"}', 1, '2023-09-04 11:00:11', '2023-09-04 11:00:11'),
(5, 1, 2, 1, '{\"from\":\"qualified\",\"to\":\"converted\"}', 1, '2023-09-04 11:03:18', '2023-09-04 11:03:18'),
(6, 1, 2, 1, '{\"from\":\"converted\",\"to\":\"converted\"}', 1, '2023-09-04 12:18:58', '2023-09-04 12:18:58'),
(7, 2, 1, 4, '{\"notes\":\"Test Note\",\"follow_date\":\"2023-09-06\",\"meeting_id\":4,\"created_by\":1}', 1, '2023-09-05 07:42:49', '2023-09-05 07:42:49'),
(8, 2, 2, 2, '{\"from\":\"new\",\"to\":\"contacted\"}', 1, '2023-09-05 07:45:55', '2023-09-05 07:45:55'),
(9, 2, 2, 2, '{\"from\":\"contacted\",\"to\":\"qualified\"}', 1, '2023-09-05 07:46:12', '2023-09-05 07:46:12'),
(10, 2, 2, 2, '{\"from\":\"qualified\",\"to\":\"converted\"}', 1, '2023-09-05 07:47:37', '2023-09-05 07:47:37'),
(11, 4, 1, 5, '{\"notes\":\"Test Note\",\"follow_date\":\"2023-09-06\",\"meeting_id\":5,\"created_by\":1}', 1, '2023-09-06 07:36:15', '2023-09-06 07:36:15'),
(12, 4, 2, 4, '{\"from\":\"new\",\"to\":\"contacted\"}', 1, '2023-09-06 07:36:40', '2023-09-06 07:36:40'),
(13, 4, 2, 4, '{\"from\":\"contacted\",\"to\":\"converted\"}', 1, '2023-09-06 07:42:54', '2023-09-06 07:42:54'),
(14, 3, 2, 3, '{\"from\":\"new\",\"to\":\"contacted\"}', 1, '2023-09-06 19:34:30', '2023-09-06 19:34:30');

-- --------------------------------------------------------

--
-- Table structure for table `majors`
--

CREATE TABLE `majors` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `industry_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `majors`
--

INSERT INTO `majors` (`id`, `deleted_at`, `created_at`, `updated_at`, `industry_id`, `name`) VALUES
(1, NULL, '2023-09-03 11:40:50', '2023-09-03 11:40:50', 1, 'Test Majors'),
(2, NULL, '2023-09-07 09:46:54', '2023-09-07 09:48:16', 2, 'Major 2');

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `interests_ids` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '[]',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `meeting_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `meeting_date` date NOT NULL DEFAULT '2020-01-01',
  `revenue` decimal(15,3) NOT NULL DEFAULT 0.000,
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `deleted_at`, `created_at`, `updated_at`, `contact_id`, `interests_ids`, `type`, `meeting_place`, `meeting_date`, `revenue`, `created_by`) VALUES
(1, NULL, '2023-09-04 08:56:13', '2023-09-04 08:56:13', 1, '[\"1\"]', 'meeting', 'in', '2023-09-04', '0.000', 1),
(2, NULL, '2023-09-04 08:57:50', '2023-09-04 08:57:50', 1, '[\"1\"]', 'meeting', 'in', '2023-09-04', '0.000', 1),
(3, NULL, '2023-09-04 10:28:18', '2023-09-04 10:28:18', 1, '[\"1\"]', 'meeting', 'out', '2023-09-04', '0.000', 1),
(4, NULL, '2023-09-05 07:42:49', '2023-09-05 07:42:49', 2, '[\"1\"]', 'meeting', 'in', '2023-09-05', '0.000', 1),
(5, NULL, '2023-09-06 07:36:15', '2023-09-06 07:36:15', 4, '[\"1\"]', 'meeting', 'in', '2023-09-06', '0.000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `meeting_notes`
--

CREATE TABLE `meeting_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `meeting_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `follow_date` date NOT NULL DEFAULT '2020-01-01',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meeting_notes`
--

INSERT INTO `meeting_notes` (`id`, `deleted_at`, `created_at`, `updated_at`, `meeting_id`, `notes`, `follow_date`, `created_by`) VALUES
(1, NULL, '2023-09-04 08:57:50', '2023-09-04 08:57:50', 2, 'adas', '2023-09-04', 1),
(2, NULL, '2023-09-04 10:28:18', '2023-09-04 10:28:18', 3, 'asdsadasasdas', '2023-09-04', 1),
(3, NULL, '2023-09-05 07:42:49', '2023-09-05 07:42:49', 4, 'Test Note', '2023-09-06', 1),
(4, NULL, '2023-09-06 07:36:15', '2023-09-06 07:36:15', 5, 'Test Note', '2023-09-06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(102, '2014_05_26_050000_create_modules_table', 1),
(103, '2014_05_26_055000_create_module_field_types_table', 1),
(104, '2014_05_26_060000_create_module_fields_table', 1),
(105, '2014_10_12_000000_create_users_table', 1),
(106, '2014_10_12_100000_create_password_resets_table', 1),
(107, '2014_12_01_000000_create_uploads_table', 1),
(108, '2016_05_26_064006_create_departments_table', 1),
(109, '2016_05_26_064007_create_employees_table', 1),
(110, '2016_05_26_064446_create_roles_table', 1),
(111, '2016_07_05_115343_create_role_user_table', 1),
(112, '2016_07_06_140637_create_organizations_table', 1),
(113, '2016_07_07_134058_create_backups_table', 1),
(114, '2016_07_07_134058_create_menus_table', 1),
(115, '2016_09_10_163337_create_permissions_table', 1),
(116, '2016_09_10_163520_create_permission_role_table', 1),
(117, '2016_09_22_105958_role_module_fields_table', 1),
(118, '2016_09_22_110008_role_module_table', 1),
(119, '2016_10_06_115413_create_la_configs_table', 1),
(120, '2019_08_19_000000_create_failed_jobs_table', 1),
(121, '2021_02_10_175120_create_permission_tables', 2),
(122, '2023_09_03_143659_create_customers_table', 3),
(123, '2023_09_03_163801_alter_contacts_table_add_status', 4),
(124, '2023_09_04_093613_create_lead_history_table', 5),
(125, '2023_09_04_133136_create_invoices_table', 6),
(126, '2023_09_06_111327_create_targets_table', 7),
(127, '2023_09_06_111555_add_employee_target_id_targets_table', 8),
(128, '2023_09_06_112056_add_activity_to_targets_table', 9),
(129, '2023_09_06_124901_add_employee_to_contacts_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(78, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_db` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view_col` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `controller` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fa_icon` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fa-cube',
  `is_gen` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `label`, `name_db`, `view_col`, `model`, `controller`, `fa_icon`, `is_gen`, `created_at`, `updated_at`) VALUES
(1, 'Users', 'Users', 'users', 'name', 'User', 'UsersController', 'fa-group', 1, '2021-02-10 14:09:28', '2021-02-10 14:09:28'),
(2, 'Uploads', 'Uploads', 'uploads', 'name', 'Upload', 'UploadsController', 'fa-files-o', 1, '2021-02-10 14:09:31', '2021-02-10 14:09:31'),
(3, 'Departments', 'Departments', 'departments', 'name', 'Department', 'DepartmentsController', 'fa-tags', 1, '2021-02-10 14:09:33', '2021-02-10 14:09:33'),
(4, 'Employees', 'Employees', 'employees', 'name', 'Employee', 'EmployeesController', 'fa-group', 1, '2021-02-10 14:09:34', '2021-02-10 14:09:34'),
(5, 'Roles', 'Roles', 'roles', 'name', 'Role', 'RolesController', 'fa-user-plus', 1, '2021-02-10 14:09:38', '2021-02-10 14:09:38'),
(6, 'Organizations', 'Organizations', 'organizations', 'name', 'Organization', 'OrganizationsController', 'fa-university', 1, '2021-02-10 14:09:43', '2021-02-10 14:09:43'),
(8, 'Permissions', 'Permissions', 'permissions', 'name', 'Permission', 'PermissionsController', 'fa-magic', 1, '2021-02-10 14:09:48', '2021-02-10 14:09:48'),
(9, 'Interests', 'Interests', 'interests', 'activity_id', 'Interest', 'InterestsController', 'fa-cubes', 1, '2021-03-27 12:34:23', '2023-09-03 11:31:04'),
(10, 'Contact_sources', 'Contact_sources', 'contact_sources', 'name', 'Contact_source', 'Contact_sourcesController', 'fa-bullhorn', 1, '2021-03-27 12:38:51', '2021-03-27 12:42:14'),
(11, 'Contacts', 'Contacts', 'contacts', 'name', 'Contact', 'ContactsController', 'fa-user-secret', 1, '2021-03-27 12:48:15', '2023-09-04 11:12:16'),
(12, 'Cities', 'Cities', 'cities', 'name', 'City', 'CitiesController', 'fa-map-marker', 1, '2021-03-27 12:51:29', '2021-03-27 12:51:51'),
(13, 'Areas', 'Areas', 'areas', 'name', 'Area', 'AreasController', 'fa-map-pin', 1, '2021-03-27 12:52:10', '2021-03-27 12:52:46'),
(14, 'Contact_categories', 'Contact_categories', 'contact_categories', 'name', 'Contact_category', 'Contact_categoriesController', 'fa-sitemap', 1, '2021-03-27 12:54:01', '2021-03-27 12:54:21'),
(15, 'Meetings', 'Meetings', 'meetings', 'meeting_date', 'Meeting', 'MeetingsController', 'fa-phone', 1, '2021-03-27 17:59:59', '2021-03-27 18:09:52'),
(16, 'Meeting_notes', 'Meeting_notes', 'meeting_notes', 'follow_date', 'Meeting_note', 'Meeting_notesController', 'fa-sticky-note-o', 1, '2021-03-27 18:10:23', '2021-03-27 18:12:07'),
(17, 'Job_titles', 'Job_titles', 'job_titles', 'name', 'Job_title', 'Job_titlesController', 'fa-align-justify', 1, '2021-03-29 07:27:22', '2021-03-29 07:29:01'),
(18, 'Industries', 'Industries', 'industries', 'name', 'Industry', 'IndustriesController', 'fa-sitemap', 1, '2021-03-29 07:29:52', '2021-03-29 07:30:14'),
(19, 'Majors', 'Majors', 'majors', 'name', 'Major', 'MajorsController', 'fa-align-center', 1, '2021-03-29 07:30:31', '2021-03-29 07:31:20'),
(20, 'Employee_targets', 'Employee_targets', 'employee_targets', 'month', 'Employee_target', 'Employee_targetsController', 'fa-long-arrow-up', 1, '2021-03-30 06:36:32', '2021-03-30 06:47:42'),
(21, 'Notifications', 'Notifications', 'notifications', 'notification', 'Notification', 'NotificationsController', 'fa-bell', 1, '2021-03-31 16:52:24', '2021-03-31 16:54:24'),
(22, 'Activates', 'Activates', 'activates', 'name', 'Activate', 'ActivatesController', 'fa-book', 1, '2023-09-03 11:21:51', '2023-09-03 11:28:46'),
(25, 'Customers', 'Customers', 'customers', 'gender', 'Customer', 'CustomersController', 'fa-users', 1, '2023-09-03 12:35:49', '2023-09-03 12:36:59'),
(26, 'Attachments', 'Attachments', 'attachments', 'customer_id', 'Attachment', 'AttachmentsController', 'fa-file-photo-o', 1, '2023-09-06 19:39:02', '2023-09-06 19:42:05'),
(27, 'Lead_cteagories', 'Lead_cteagories', 'lead_cteagories', 'contact_category_id', 'Lead_cteagory', 'Lead_cteagoriesController', 'fa-cube', 1, '2023-09-07 09:57:10', '2023-09-07 09:59:17');

-- --------------------------------------------------------

--
-- Table structure for table `module_fields`
--

CREATE TABLE `module_fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `colname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` int(10) UNSIGNED NOT NULL,
  `field_type` int(10) UNSIGNED NOT NULL,
  `unique` tinyint(1) NOT NULL DEFAULT 0,
  `defaultvalue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minlength` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `maxlength` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `popup_vals` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `module_fields`
--

INSERT INTO `module_fields` (`id`, `colname`, `label`, `module`, `field_type`, `unique`, `defaultvalue`, `minlength`, `maxlength`, `required`, `popup_vals`, `sort`, `created_at`, `updated_at`) VALUES
(1, 'name', 'Name', 1, 16, 0, '', 5, 250, 1, '', 0, '2021-02-10 14:09:28', '2021-02-10 14:09:28'),
(2, 'context_id', 'Context', 1, 13, 0, '0', 0, 0, 0, '', 0, '2021-02-10 14:09:28', '2021-02-10 14:09:28'),
(3, 'email', 'Email', 1, 8, 1, '', 0, 250, 0, '', 0, '2021-02-10 14:09:29', '2021-02-10 14:09:29'),
(4, 'password', 'Password', 1, 17, 0, '', 6, 250, 1, '', 0, '2021-02-10 14:09:29', '2021-02-10 14:09:29'),
(5, 'type', 'User Type', 1, 7, 0, 'Employee', 0, 0, 0, '[\"Employee\",\"Client\"]', 0, '2021-02-10 14:09:29', '2021-02-10 14:09:29'),
(6, 'name', 'Name', 2, 16, 0, '', 5, 250, 1, '', 0, '2021-02-10 14:09:31', '2021-02-10 14:09:31'),
(7, 'path', 'Path', 2, 19, 0, '', 0, 250, 0, '', 0, '2021-02-10 14:09:31', '2021-02-10 14:09:31'),
(8, 'extension', 'Extension', 2, 19, 0, '', 0, 20, 0, '', 0, '2021-02-10 14:09:31', '2021-02-10 14:09:31'),
(9, 'caption', 'Caption', 2, 19, 0, '', 0, 250, 0, '', 0, '2021-02-10 14:09:31', '2021-02-10 14:09:31'),
(10, 'user_id', 'Owner', 2, 7, 0, '1', 0, 0, 0, '@users', 0, '2021-02-10 14:09:31', '2021-02-10 14:09:31'),
(11, 'hash', 'Hash', 2, 19, 0, '', 0, 250, 0, '', 0, '2021-02-10 14:09:31', '2021-02-10 14:09:31'),
(12, 'public', 'Is Public', 2, 2, 0, '0', 0, 0, 0, '', 0, '2021-02-10 14:09:31', '2021-02-10 14:09:31'),
(13, 'name', 'Name', 3, 16, 1, '', 1, 250, 1, '', 0, '2021-02-10 14:09:33', '2021-02-10 14:09:33'),
(16, 'name', 'Name', 4, 16, 0, '', 5, 250, 1, '', 2, '2021-02-10 14:09:34', '2021-02-10 14:09:34'),
(19, 'mobile', 'Mobile', 4, 14, 0, '', 10, 20, 1, '', 3, '2021-02-10 14:09:35', '2021-02-10 14:09:35'),
(21, 'email', 'Email', 4, 8, 1, '', 5, 250, 1, '', 5, '2021-02-10 14:09:35', '2021-02-10 14:09:35'),
(22, 'dept', 'Department', 4, 7, 0, '0', 0, 0, 1, '@departments', 1, '2021-02-10 14:09:35', '2021-02-10 14:09:35'),
(30, 'name', 'Name', 5, 16, 1, '', 1, 250, 1, '', 0, '2021-02-10 14:09:38', '2021-02-10 14:09:38'),
(33, 'parent', 'Parent Role', 5, 7, 0, '1', 0, 0, 0, '@roles', 0, '2021-02-10 14:09:38', '2021-02-10 14:09:38'),
(35, 'name', 'Name', 6, 16, 1, '', 5, 250, 1, '', 0, '2021-02-10 14:09:43', '2021-02-10 14:09:43'),
(36, 'email', 'Email', 6, 8, 1, '', 0, 250, 0, '', 0, '2021-02-10 14:09:43', '2021-02-10 14:09:43'),
(37, 'phone', 'Phone', 6, 14, 0, '', 0, 20, 0, '', 0, '2021-02-10 14:09:43', '2021-02-10 14:09:43'),
(38, 'website', 'Website', 6, 23, 0, 'http://', 0, 250, 0, '', 0, '2021-02-10 14:09:43', '2021-02-10 14:09:43'),
(39, 'assigned_to', 'Assigned to', 6, 7, 0, '0', 0, 0, 0, '@employees', 0, '2021-02-10 14:09:43', '2021-02-10 14:09:43'),
(40, 'connect_since', 'Connected Since', 6, 4, 0, 'date(\'Y-m-d\')', 0, 0, 0, '', 0, '2021-02-10 14:09:43', '2021-02-10 14:09:43'),
(41, 'address', 'Address', 6, 1, 0, '', 0, 1000, 1, '', 0, '2021-02-10 14:09:43', '2021-02-10 14:09:43'),
(42, 'city', 'City', 6, 19, 0, '', 0, 250, 1, '', 0, '2021-02-10 14:09:43', '2021-02-10 14:09:43'),
(43, 'description', 'Description', 6, 21, 0, '', 0, 1000, 0, '', 0, '2021-02-10 14:09:43', '2021-02-10 14:09:43'),
(44, 'profile_image', 'Profile Image', 6, 12, 0, '', 0, 250, 0, '', 0, '2021-02-10 14:09:43', '2021-02-10 14:09:43'),
(45, 'profile', 'Company Profile', 6, 9, 0, '', 0, 250, 0, '', 0, '2021-02-10 14:09:43', '2021-02-10 14:09:43'),
(49, 'name', 'Name', 8, 16, 1, '', 1, 250, 1, '', 0, '2021-02-10 14:09:48', '2021-02-10 14:09:48'),
(50, 'active', 'Active', 4, 2, 0, '1', 0, 0, 1, '', 4, '2021-03-27 10:37:45', '2021-03-27 10:37:45'),
(51, 'view_data', 'View his data only', 5, 2, 0, '0', 0, 0, 1, '', 0, '2021-03-27 10:52:16', '2021-03-27 10:54:37'),
(52, 'view_dept', 'View his dept only', 5, 2, 0, '0', 0, 0, 1, '', 0, '2021-03-27 10:52:47', '2021-03-27 10:54:49'),
(53, 'name', 'Name', 9, 16, 1, NULL, 0, 256, 1, '', 0, '2021-03-27 12:34:49', '2021-03-27 12:34:49'),
(54, 'name', 'Name', 10, 16, 1, NULL, 0, 256, 1, '', 0, '2021-03-27 12:42:05', '2021-03-27 12:42:05'),
(55, 'name', 'Name', 11, 16, 0, NULL, 0, 256, 1, '', 1, '2021-03-27 12:48:39', '2021-03-27 12:48:39'),
(56, 'mobile', 'Mobile', 11, 14, 1, '', 0, 20, 1, '', 2, '2021-03-27 12:50:10', '2021-03-29 06:45:39'),
(57, 'mobile2', 'Another mobile', 11, 14, 0, NULL, 0, 20, 0, '', 3, '2021-03-27 12:50:41', '2021-03-27 12:50:41'),
(58, 'email', 'Email', 11, 8, 0, NULL, 0, 256, 0, '', 4, '2021-03-27 12:50:51', '2021-03-27 12:50:51'),
(59, 'name', 'Name', 12, 16, 1, NULL, 0, 256, 1, '', 0, '2021-03-27 12:51:41', '2021-03-27 12:51:41'),
(60, 'name', 'Name', 13, 16, 0, NULL, 0, 256, 1, '', 0, '2021-03-27 12:52:21', '2021-03-27 12:52:21'),
(61, 'city_id', 'City', 13, 7, 0, NULL, 0, 0, 1, '@cities', 0, '2021-03-27 12:52:37', '2021-03-27 12:52:37'),
(62, 'company_name', 'Company name', 11, 16, 0, NULL, 0, 256, 0, '', 5, '2021-03-27 12:53:04', '2021-03-27 12:53:04'),
(64, 'name', 'Name', 14, 16, 1, NULL, 0, 256, 1, '', 0, '2021-03-27 12:54:13', '2021-03-27 12:54:13'),
(66, 'city_id', 'City', 11, 7, 0, NULL, 0, 0, 1, '@cities', 9, '2021-03-27 12:55:15', '2021-03-27 12:55:15'),
(67, 'area_id', 'Area', 11, 7, 0, NULL, 0, 0, 1, '@areas', 10, '2021-03-27 12:55:29', '2021-03-27 12:55:29'),
(68, 'contact_source_id', 'Contact Source', 11, 7, 0, NULL, 0, 0, 1, '@contact_sources', 8, '2021-03-27 12:55:50', '2021-03-27 12:55:50'),
(69, 'created_by', 'Created By', 11, 7, 0, NULL, 0, 0, 1, '@employees', 14, '2021-03-27 12:56:32', '2021-03-27 12:56:32'),
(70, 'contact_id', 'Contact', 15, 7, 0, NULL, 0, 0, 1, '@contacts', 1, '2021-03-27 18:01:11', '2021-03-27 18:01:11'),
(71, 'interests_ids', 'Interests', 15, 15, 0, NULL, 0, 0, 1, '@interests', 2, '2021-03-27 18:02:14', '2021-03-27 18:02:14'),
(72, 'type', 'Meeting type', 15, 7, 0, NULL, 0, 0, 1, '[\"meeting\",\"call\"]', 3, '2021-03-27 18:02:48', '2021-03-27 18:03:46'),
(73, 'meeting_place', 'In / Out', 15, 7, 0, '', 0, 0, 1, '[\"in\",\"out\"]', 4, '2021-03-27 18:03:31', '2021-03-29 06:29:06'),
(74, 'meeting_date', 'meeting date', 15, 4, 0, 'now', 0, 0, 1, '', 5, '2021-03-27 18:04:26', '2021-03-27 18:05:56'),
(75, 'revenue', 'Revenue', 15, 6, 0, '0', 0, 11, 0, '', 6, '2021-03-27 18:09:04', '2021-03-27 18:09:04'),
(76, 'created_by', 'Created By', 15, 7, 0, NULL, 0, 0, 1, '@employees', 8, '2021-03-27 18:09:46', '2021-03-27 18:09:46'),
(77, 'meeting_id', 'meeting', 16, 7, 0, NULL, 0, 0, 1, '@meetings', 0, '2021-03-27 18:10:47', '2021-03-27 18:10:47'),
(78, 'notes', 'notes', 16, 21, 0, NULL, 0, 0, 1, '', 0, '2021-03-27 18:10:59', '2021-03-27 18:10:59'),
(79, 'follow_date', 'Follow date', 16, 4, 0, NULL, 0, 0, 1, '', 0, '2021-03-27 18:11:32', '2021-03-27 18:11:32'),
(80, 'created_by', 'Created By', 16, 7, 0, NULL, 0, 0, 1, '@employees', 0, '2021-03-27 18:11:50', '2021-03-27 18:11:50'),
(81, 'active', 'Active', 1, 2, 0, '1', 0, 0, 1, '', 0, '2021-03-29 04:36:23', '2021-03-29 04:36:23'),
(82, 'name', 'Name', 17, 16, 1, '', 0, 256, 1, '', 0, '2021-03-29 07:27:35', '2021-03-29 07:27:35'),
(83, 'name', 'Name', 18, 16, 1, '', 0, 256, 1, '', 0, '2021-03-29 07:30:05', '2021-03-29 07:30:05'),
(84, 'industry_id', 'industry', 19, 7, 0, '', 0, 0, 1, '@industries', 0, '2021-03-29 07:30:54', '2021-03-29 07:30:54'),
(85, 'name', 'Name', 19, 16, 1, '', 0, 256, 1, '', 0, '2021-03-29 07:31:08', '2021-03-29 07:31:08'),
(86, 'job_title_id', 'Job title', 11, 7, 0, '', 0, 0, 1, '@job_titles', 6, '2021-03-29 07:36:37', '2021-03-29 07:36:37'),
(87, 'industry_id', 'industry', 11, 7, 0, '', 0, 0, 1, '@industries', 11, '2021-03-29 07:38:02', '2021-03-29 07:38:02'),
(88, 'major_id', 'Major', 11, 7, 0, '', 0, 0, 1, '@majors', 12, '2021-03-29 07:38:25', '2021-03-29 07:38:25'),
(90, 'employee_id', 'Employee', 20, 7, 0, '', 0, 0, 1, '@employees', 0, '2021-03-30 06:36:57', '2021-03-30 06:36:57'),
(91, 'month', 'month', 20, 7, 0, '', 0, 0, 1, '[\"date(\'M-Y\')\"]', 0, '2021-03-30 06:39:04', '2021-03-30 06:39:04'),
(92, 'target_amount', 'Amount Target', 20, 6, 0, '0', 0, 11, 1, '', 0, '2021-03-30 06:39:43', '2021-03-30 09:10:57'),
(93, 'target_meeting', 'Calls / Meetings Target', 20, 13, 0, '0', 0, 11, 1, '', 0, '2021-03-30 06:40:19', '2021-03-30 06:40:19'),
(94, 'dept', 'Department', 21, 7, 0, '', 0, 0, 0, '@departments', 0, '2021-03-31 16:52:56', '2021-03-31 16:52:56'),
(95, 'employee_id', 'Employee', 21, 7, 0, '', 0, 0, 0, '@employees', 0, '2021-03-31 16:53:16', '2021-03-31 16:53:16'),
(96, 'notification', 'Notification', 21, 19, 0, '', 0, 256, 1, '', 0, '2021-03-31 16:53:38', '2021-03-31 16:53:38'),
(97, 'created_by', 'Created By', 21, 7, 0, '', 0, 0, 1, '@employees', 0, '2021-03-31 16:54:03', '2021-03-31 16:54:03'),
(98, 'notes', 'Notes', 11, 21, 0, '', 0, 0, 0, '', 15, '2021-03-31 16:54:03', '2021-03-31 16:54:03'),
(99, 'name', 'Name', 22, 16, 0, '', 0, 256, 1, '', 0, '2023-09-03 11:23:25', '2023-09-03 11:23:25'),
(100, 'activity_id', 'Activity', 9, 7, 0, '', 0, 0, 1, '@activates', 0, '2023-09-03 11:26:18', '2023-09-03 11:26:18'),
(101, 'activity_id', 'Activity', 11, 7, 0, '', 0, 0, 1, '@activates', 13, '2023-09-03 11:33:34', '2023-09-03 11:33:34'),
(102, 'gender', 'Gender', 11, 7, 0, '', 0, 0, 1, '[\"Male\",\"Female\"]', 0, '2023-09-03 11:37:25', '2023-09-03 11:37:25'),
(136, 'name', 'Name', 25, 16, 0, NULL, 0, 256, 1, '', 1, '2021-03-27 12:48:39', '2021-03-27 12:48:39'),
(137, 'mobile', 'Mobile', 25, 14, 1, '', 0, 20, 1, '', 2, '2021-03-27 12:50:10', '2021-03-29 06:45:39'),
(138, 'mobile2', 'Another mobile', 25, 14, 0, NULL, 0, 20, 0, '', 3, '2021-03-27 12:50:41', '2021-03-27 12:50:41'),
(139, 'email', 'Email', 25, 8, 0, NULL, 0, 256, 0, '', 4, '2021-03-27 12:50:51', '2021-03-27 12:50:51'),
(140, 'company_name', 'Company name', 25, 16, 0, NULL, 0, 256, 0, '', 5, '2021-03-27 12:53:04', '2021-03-27 12:53:04'),
(141, 'contact_category_id', 'Category', 25, 7, 0, NULL, 0, 0, 1, '@contact_categories', 7, '2021-03-27 12:54:54', '2021-03-27 12:54:54'),
(142, 'city_id', 'City', 25, 7, 0, NULL, 0, 0, 1, '@cities', 9, '2021-03-27 12:55:15', '2021-03-27 12:55:15'),
(143, 'area_id', 'Area', 25, 7, 0, NULL, 0, 0, 1, '@areas', 10, '2021-03-27 12:55:29', '2021-03-27 12:55:29'),
(144, 'contact_source_id', 'Contact Source', 25, 7, 0, NULL, 0, 0, 1, '@contact_sources', 8, '2021-03-27 12:55:50', '2021-03-27 12:55:50'),
(145, 'created_by', 'Created By', 25, 7, 0, NULL, 0, 0, 1, '@employees', 14, '2021-03-27 12:56:32', '2021-03-27 12:56:32'),
(146, 'job_title_id', 'Job title', 25, 7, 0, '', 0, 0, 1, '@job_titles', 6, '2021-03-29 07:36:37', '2021-03-29 07:36:37'),
(147, 'industry_id', 'industry', 25, 7, 0, '', 0, 0, 1, '@industries', 25, '2021-03-29 07:38:02', '2021-03-29 07:38:02'),
(148, 'major_id', 'Major', 25, 7, 0, '', 0, 0, 1, '@majors', 12, '2021-03-29 07:38:25', '2021-03-29 07:38:25'),
(149, 'notes', 'Notes', 25, 21, 0, '', 0, 0, 0, '', 15, '2021-03-31 16:54:03', '2021-03-31 16:54:03'),
(150, 'activity_id', 'Activity', 25, 7, 0, '', 0, 0, 1, '@activates', 13, '2023-09-03 11:33:34', '2023-09-03 11:33:34'),
(151, 'gender', 'Gender', 25, 7, 0, '', 0, 0, 1, '[\"Male\",\"Female\"]', 0, '2023-09-03 11:37:25', '2023-09-03 11:37:25'),
(155, 'customer_id', 'Customer', 11, 7, 0, '', 0, 0, 0, '@customers', 0, '2023-09-03 14:22:58', '2023-09-03 14:22:58'),
(156, 'customer_id', 'Customer', 26, 7, 0, '', 0, 0, 0, '@customers', 0, '2023-09-06 19:39:43', '2023-09-06 19:39:43'),
(157, 'attachment_name', 'Attachment Name', 26, 19, 0, '', 0, 256, 0, '', 0, '2023-09-06 19:40:49', '2023-09-06 19:40:49'),
(158, 'attachment', 'Attachment', 26, 9, 0, '', 0, 0, 1, '', 0, '2023-09-06 19:41:51', '2023-09-06 19:41:51'),
(159, 'contact_category_id', 'Category', 27, 7, 0, '', 0, 0, 1, '@contact_categories', 0, '2023-09-07 09:58:12', '2023-09-07 09:58:12'),
(160, 'contact_id', 'Contact', 27, 7, 0, '', 0, 0, 1, '@contacts', 0, '2023-09-07 09:58:55', '2023-09-07 09:58:55'),
(161, 'contact_category_id', 'Category', 11, 15, 0, '', 0, 0, 0, '@contact_categories', 0, '2023-09-07 12:14:53', '2023-09-07 12:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `module_field_types`
--

CREATE TABLE `module_field_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `module_field_types`
--

INSERT INTO `module_field_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Address', '2021-02-10 14:09:23', '2021-02-10 14:09:23'),
(2, 'Checkbox', '2021-02-10 14:09:23', '2021-02-10 14:09:23'),
(3, 'Currency', '2021-02-10 14:09:23', '2021-02-10 14:09:23'),
(4, 'Date', '2021-02-10 14:09:23', '2021-02-10 14:09:23'),
(5, 'Datetime', '2021-02-10 14:09:23', '2021-02-10 14:09:23'),
(6, 'Decimal', '2021-02-10 14:09:23', '2021-02-10 14:09:23'),
(7, 'Dropdown', '2021-02-10 14:09:23', '2021-02-10 14:09:23'),
(8, 'Email', '2021-02-10 14:09:23', '2021-02-10 14:09:23'),
(9, 'File', '2021-02-10 14:09:23', '2021-02-10 14:09:23'),
(10, 'Float', '2021-02-10 14:09:23', '2021-02-10 14:09:23'),
(11, 'HTML', '2021-02-10 14:09:23', '2021-02-10 14:09:23'),
(12, 'Image', '2021-02-10 14:09:23', '2021-02-10 14:09:23'),
(13, 'Integer', '2021-02-10 14:09:24', '2021-02-10 14:09:24'),
(14, 'Mobile', '2021-02-10 14:09:24', '2021-02-10 14:09:24'),
(15, 'Multiselect', '2021-02-10 14:09:24', '2021-02-10 14:09:24'),
(16, 'Name', '2021-02-10 14:09:24', '2021-02-10 14:09:24'),
(17, 'Password', '2021-02-10 14:09:24', '2021-02-10 14:09:24'),
(18, 'Radio', '2021-02-10 14:09:24', '2021-02-10 14:09:24'),
(19, 'String', '2021-02-10 14:09:24', '2021-02-10 14:09:24'),
(20, 'Taginput', '2021-02-10 14:09:24', '2021-02-10 14:09:24'),
(21, 'Textarea', '2021-02-10 14:09:24', '2021-02-10 14:09:24'),
(22, 'TextField', '2021-02-10 14:09:24', '2021-02-10 14:09:24'),
(23, 'URL', '2021-02-10 14:09:24', '2021-02-10 14:09:24'),
(24, 'Files', '2021-02-10 14:09:25', '2021-02-10 14:09:25');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dept` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `employee_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `notification` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'http://',
  `assigned_to` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `connect_since` date NOT NULL,
  `address` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` int(11) NOT NULL,
  `profile` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `email`, `phone`, `website`, `assigned_to`, `connect_since`, `address`, `city`, `description`, `profile_image`, `profile`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Organization', 'org@example.com', NULL, 'http://', 1, '1970-01-01', 'address', 'city', NULL, 0, 0, NULL, '2021-02-13 15:10:13', '2021-02-13 15:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ADMIN_PANEL', 'web', '2021-02-11 15:19:46', '2021-02-11 15:19:46', NULL),
(2, 'Permissions-view', 'web', '2021-02-11 15:19:46', '2021-02-11 15:19:46', NULL),
(3, 'Permissions-create', 'web', '2021-02-11 17:15:26', '2021-02-11 17:15:26', NULL),
(4, 'Permissions-edit', 'web', '2021-02-11 15:19:46', '2021-02-11 15:19:46', NULL),
(5, 'Permissions-delete', 'web', NULL, NULL, NULL),
(6, 'Roles-view', 'web', '2021-02-11 15:19:46', '2021-02-11 15:19:46', NULL),
(7, 'Roles-create', 'web', '2021-02-11 15:19:46', '2021-02-11 15:19:46', NULL),
(8, 'Roles-edit', 'web', '2021-02-11 17:15:26', '2021-02-11 17:15:26', NULL),
(9, 'Roles-delete', 'web', '2021-02-11 15:19:46', '2021-02-11 15:19:46', NULL),
(10, 'Organizations-view', 'web', NULL, NULL, NULL),
(11, 'Organizations-create', 'web', NULL, NULL, NULL),
(12, 'Organizations-edit', 'web', NULL, NULL, NULL),
(13, 'Organizations-delete', 'web', NULL, NULL, NULL),
(14, 'Employees-view', 'web', NULL, NULL, NULL),
(15, 'Employees-create', 'web', NULL, NULL, NULL),
(16, 'Employees-edit', 'web', NULL, NULL, NULL),
(17, 'Employees-delete', 'web', NULL, NULL, NULL),
(18, 'Departments-view', 'web', NULL, NULL, NULL),
(19, 'Departments-create', 'web', NULL, NULL, NULL),
(20, 'Departments-edit', 'web', NULL, NULL, NULL),
(21, 'Departments-delete', 'web', NULL, NULL, NULL),
(22, 'Users-view', 'web', NULL, NULL, NULL),
(23, 'Users-create', 'web', NULL, NULL, NULL),
(24, 'Users-edit', 'web', NULL, NULL, NULL),
(25, 'Users-delete', 'web', NULL, NULL, NULL),
(26, 'Uploads-view', 'web', NULL, NULL, NULL),
(27, 'Uploads-create', 'web', NULL, NULL, NULL),
(28, 'Uploads-edit', 'web', NULL, NULL, NULL),
(29, 'Uploads-delete', 'web', NULL, NULL, NULL),
(30, 'Interests-view', 'web', '2021-03-27 12:34:24', '2021-03-27 12:34:24', NULL),
(31, 'Interests-create', 'web', '2021-03-27 12:34:24', '2021-03-27 12:34:24', NULL),
(32, 'Interests-edit', 'web', '2021-03-27 12:34:24', '2021-03-27 12:34:24', NULL),
(33, 'Interests-delete', 'web', '2021-03-27 12:34:24', '2021-03-27 12:34:24', NULL),
(34, 'Contact_sources-view', 'web', '2021-03-27 12:38:51', '2021-03-27 12:38:51', NULL),
(35, 'Contact_sources-create', 'web', '2021-03-27 12:38:51', '2021-03-27 12:38:51', NULL),
(36, 'Contact_sources-edit', 'web', '2021-03-27 12:38:51', '2021-03-27 12:38:51', NULL),
(37, 'Contact_sources-delete', 'web', '2021-03-27 12:38:51', '2021-03-27 12:38:51', NULL),
(38, 'Contacts-view', 'web', '2021-03-27 12:48:15', '2021-03-27 12:48:15', NULL),
(39, 'Contacts-create', 'web', '2021-03-27 12:48:15', '2021-03-27 12:48:15', NULL),
(40, 'Contacts-edit', 'web', '2021-03-27 12:48:15', '2021-03-27 12:48:15', NULL),
(41, 'Contacts-delete', 'web', '2021-03-27 12:48:15', '2021-03-27 12:48:15', NULL),
(42, 'Cities-view', 'web', '2021-03-27 12:51:30', '2021-03-27 12:51:30', NULL),
(43, 'Cities-create', 'web', '2021-03-27 12:51:30', '2021-03-27 12:51:30', NULL),
(44, 'Cities-edit', 'web', '2021-03-27 12:51:30', '2021-03-27 12:51:30', NULL),
(45, 'Cities-delete', 'web', '2021-03-27 12:51:30', '2021-03-27 12:51:30', NULL),
(46, 'Areas-view', 'web', '2021-03-27 12:52:10', '2021-03-27 12:52:10', NULL),
(47, 'Areas-create', 'web', '2021-03-27 12:52:10', '2021-03-27 12:52:10', NULL),
(48, 'Areas-edit', 'web', '2021-03-27 12:52:10', '2021-03-27 12:52:10', NULL),
(49, 'Areas-delete', 'web', '2021-03-27 12:52:10', '2021-03-27 12:52:10', NULL),
(50, 'Contact_categories-view', 'web', '2021-03-27 12:54:01', '2021-03-27 12:54:01', NULL),
(51, 'Contact_categories-create', 'web', '2021-03-27 12:54:01', '2021-03-27 12:54:01', NULL),
(52, 'Contact_categories-edit', 'web', '2021-03-27 12:54:01', '2021-03-27 12:54:01', NULL),
(53, 'Contact_categories-delete', 'web', '2021-03-27 12:54:01', '2021-03-27 12:54:01', NULL),
(54, 'Meetings-view', 'web', '2021-03-27 17:59:59', '2021-03-27 17:59:59', NULL),
(55, 'Meetings-create', 'web', '2021-03-27 17:59:59', '2021-03-27 17:59:59', NULL),
(56, 'Meetings-edit', 'web', '2021-03-27 17:59:59', '2021-03-27 17:59:59', NULL),
(57, 'Meetings-delete', 'web', '2021-03-27 17:59:59', '2021-03-27 17:59:59', NULL),
(58, 'Meeting_notes-view', 'web', '2021-03-27 18:10:23', '2021-03-27 18:10:23', NULL),
(59, 'Meeting_notes-create', 'web', '2021-03-27 18:10:23', '2021-03-27 18:10:23', NULL),
(60, 'Meeting_notes-edit', 'web', '2021-03-27 18:10:23', '2021-03-27 18:10:23', NULL),
(61, 'Meeting_notes-delete', 'web', '2021-03-27 18:10:23', '2021-03-27 18:10:23', NULL),
(62, 'Job_titles-view', 'web', '2021-03-29 07:27:22', '2021-03-29 07:27:22', NULL),
(63, 'Job_titles-create', 'web', '2021-03-29 07:27:22', '2021-03-29 07:27:22', NULL),
(64, 'Job_titles-edit', 'web', '2021-03-29 07:27:22', '2021-03-29 07:27:22', NULL),
(65, 'Job_titles-delete', 'web', '2021-03-29 07:27:22', '2021-03-29 07:27:22', NULL),
(66, 'Industries-view', 'web', '2021-03-29 07:29:52', '2021-03-29 07:29:52', NULL),
(67, 'Industries-create', 'web', '2021-03-29 07:29:52', '2021-03-29 07:29:52', NULL),
(68, 'Industries-edit', 'web', '2021-03-29 07:29:52', '2021-03-29 07:29:52', NULL),
(69, 'Industries-delete', 'web', '2021-03-29 07:29:52', '2021-03-29 07:29:52', NULL),
(70, 'Majors-view', 'web', '2021-03-29 07:30:31', '2021-03-29 07:30:31', NULL),
(71, 'Majors-create', 'web', '2021-03-29 07:30:31', '2021-03-29 07:30:31', NULL),
(72, 'Majors-edit', 'web', '2021-03-29 07:30:31', '2021-03-29 07:30:31', NULL),
(73, 'Majors-delete', 'web', '2021-03-29 07:30:31', '2021-03-29 07:30:31', NULL),
(74, 'Employee_targets-view', 'web', '2021-03-30 06:36:33', '2021-03-30 06:36:33', NULL),
(75, 'Employee_targets-create', 'web', '2021-03-30 06:36:33', '2021-03-30 06:36:33', NULL),
(76, 'Employee_targets-edit', 'web', '2021-03-30 06:36:33', '2021-03-30 06:36:33', NULL),
(77, 'Employee_targets-delete', 'web', '2021-03-30 06:36:33', '2021-03-30 06:36:33', NULL),
(78, 'SUPER_ADMIN', 'web', NULL, NULL, NULL),
(79, 'Notifications-view', 'web', '2021-03-31 16:52:24', '2021-03-31 16:52:24', NULL),
(80, 'Notifications-create', 'web', '2021-03-31 16:52:24', '2021-03-31 16:52:24', NULL),
(81, 'Notifications-edit', 'web', '2021-03-31 16:52:24', '2021-03-31 16:52:24', NULL),
(82, 'Notifications-delete', 'web', '2021-03-31 16:52:24', '2021-03-31 16:52:24', NULL),
(83, 'Activates-view', 'web', '2023-09-03 11:21:51', '2023-09-03 11:21:51', NULL),
(84, 'Activates-create', 'web', '2023-09-03 11:21:51', '2023-09-03 11:21:51', NULL),
(85, 'Activates-edit', 'web', '2023-09-03 11:21:51', '2023-09-03 11:21:51', NULL),
(86, 'Activates-delete', 'web', '2023-09-03 11:21:51', '2023-09-03 11:21:51', NULL),
(92, 'Customers-view', 'web', '2023-09-03 12:35:49', '2023-09-03 12:35:49', NULL),
(93, 'Customers-create', 'web', '2023-09-03 12:35:49', '2023-09-03 12:35:49', NULL),
(94, 'Customers-edit', 'web', '2023-09-03 12:35:49', '2023-09-03 12:35:49', NULL),
(95, 'Customers-delete', 'web', '2023-09-03 12:35:50', '2023-09-03 12:35:50', NULL),
(96, 'Attachments-view', 'web', '2023-09-06 19:39:02', '2023-09-06 19:39:02', NULL),
(97, 'Attachments-create', 'web', '2023-09-06 19:39:02', '2023-09-06 19:39:02', NULL),
(98, 'Attachments-edit', 'web', '2023-09-06 19:39:02', '2023-09-06 19:39:02', NULL),
(99, 'Attachments-delete', 'web', '2023-09-06 19:39:02', '2023-09-06 19:39:02', NULL),
(100, 'Lead_cteagories-view', 'web', '2023-09-07 09:57:10', '2023-09-07 09:57:10', NULL),
(101, 'Lead_cteagories-create', 'web', '2023-09-07 09:57:10', '2023-09-07 09:57:10', NULL),
(102, 'Lead_cteagories-edit', 'web', '2023-09-07 09:57:10', '2023-09-07 09:57:10', NULL),
(103, 'Lead_cteagories-delete', 'web', '2023-09-07 09:57:10', '2023-09-07 09:57:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `view_data` tinyint(1) NOT NULL DEFAULT 0,
  `view_dept` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `parent`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`, `view_data`, `view_dept`) VALUES
(1, 0, 'SUPER_ADMIN', 'web', NULL, '2021-02-13 14:02:09', NULL, 0, 0),
(2, 1, 'ADMIN', 'web', NULL, '2021-02-13 14:02:28', NULL, 0, 0),
(4, 2, 'SUPERVISOR', 'web', '2021-03-27 11:02:48', '2021-03-27 11:02:48', NULL, 0, 1),
(5, 4, 'EMPLOYEE', 'web', '2021-03-27 11:03:33', '2021-03-27 11:03:33', NULL, 1, 0);

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
(1, 1),
(1, 2),
(1, 4),
(1, 5),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(6, 2),
(8, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(14, 2),
(14, 4),
(14, 5),
(15, 1),
(15, 2),
(15, 4),
(16, 1),
(16, 2),
(16, 4),
(16, 5),
(17, 1),
(17, 2),
(17, 4),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(22, 2),
(22, 4),
(22, 5),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(30, 2),
(30, 4),
(31, 1),
(31, 2),
(31, 4),
(32, 1),
(32, 2),
(32, 4),
(33, 1),
(33, 2),
(33, 4),
(34, 1),
(34, 2),
(34, 4),
(35, 1),
(35, 2),
(35, 4),
(36, 1),
(36, 2),
(36, 4),
(37, 1),
(37, 2),
(37, 4),
(38, 1),
(38, 2),
(38, 4),
(38, 5),
(39, 1),
(39, 2),
(39, 4),
(39, 5),
(40, 1),
(40, 2),
(40, 4),
(40, 5),
(41, 1),
(41, 2),
(41, 4),
(41, 5),
(42, 1),
(42, 2),
(42, 4),
(43, 1),
(43, 2),
(43, 4),
(44, 1),
(44, 2),
(44, 4),
(45, 1),
(45, 2),
(45, 4),
(46, 1),
(46, 2),
(46, 4),
(47, 1),
(47, 2),
(47, 4),
(48, 1),
(48, 2),
(48, 4),
(49, 1),
(49, 2),
(49, 4),
(50, 1),
(50, 2),
(50, 4),
(51, 1),
(51, 2),
(51, 4),
(52, 1),
(52, 2),
(52, 4),
(53, 1),
(53, 2),
(53, 4),
(54, 1),
(54, 2),
(54, 4),
(54, 5),
(55, 1),
(55, 2),
(55, 4),
(55, 5),
(56, 1),
(56, 2),
(56, 4),
(56, 5),
(57, 1),
(57, 2),
(57, 4),
(57, 5),
(58, 1),
(58, 2),
(58, 4),
(58, 5),
(59, 1),
(59, 2),
(59, 4),
(59, 5),
(60, 1),
(60, 2),
(60, 4),
(60, 5),
(61, 1),
(61, 2),
(61, 4),
(61, 5),
(62, 1),
(62, 2),
(62, 4),
(63, 1),
(63, 2),
(63, 4),
(64, 1),
(64, 2),
(65, 1),
(65, 2),
(66, 1),
(66, 2),
(66, 4),
(67, 1),
(67, 2),
(67, 4),
(68, 1),
(68, 2),
(69, 1),
(69, 2),
(70, 1),
(70, 2),
(70, 4),
(71, 1),
(71, 2),
(71, 4),
(72, 1),
(72, 2),
(73, 1),
(73, 2),
(74, 1),
(74, 2),
(74, 4),
(75, 1),
(75, 2),
(75, 4),
(76, 1),
(76, 2),
(76, 4),
(77, 1),
(77, 2),
(77, 4),
(79, 1),
(79, 2),
(80, 1),
(80, 2),
(81, 1),
(81, 2),
(82, 1),
(82, 2),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_module`
--

CREATE TABLE `role_module` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `module_id` int(10) UNSIGNED NOT NULL,
  `acc_view` tinyint(1) NOT NULL,
  `acc_create` tinyint(1) NOT NULL,
  `acc_edit` tinyint(1) NOT NULL,
  `acc_delete` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_module`
--

INSERT INTO `role_module` (`id`, `role_id`, `module_id`, `acc_view`, `acc_create`, `acc_edit`, `acc_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 1, 1, 1, 1, '2021-02-11 18:07:08', '2021-02-11 18:07:08'),
(2, 2, 5, 1, 0, 0, 0, '2021-02-11 18:07:08', '2021-02-11 18:07:08');

-- --------------------------------------------------------

--
-- Table structure for table `role_module_fields`
--

CREATE TABLE `role_module_fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `field_id` int(10) UNSIGNED NOT NULL,
  `access` enum('invisible','readonly','write') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_module_fields`
--

INSERT INTO `role_module_fields` (`id`, `role_id`, `field_id`, `access`, `created_at`, `updated_at`) VALUES
(1, 1, 30, 'write', '2021-02-11 18:07:08', '2021-02-11 18:07:08'),
(2, 1, 33, 'write', '2021-02-11 18:07:08', '2021-02-11 18:07:08'),
(3, 2, 30, 'readonly', '2021-02-11 18:07:08', '2021-02-11 18:07:08'),
(4, 2, 33, 'readonly', '2021-02-11 18:07:08', '2021-02-11 18:07:08'),
(5, 1, 1, 'write', '2021-02-13 14:53:11', '2021-02-13 14:53:11'),
(6, 1, 2, 'readonly', '2021-02-13 14:53:11', '2021-02-13 14:53:11'),
(7, 1, 3, 'write', '2021-02-13 14:53:11', '2021-02-13 14:53:11'),
(8, 1, 4, 'write', '2021-02-13 14:53:11', '2021-02-13 14:53:11'),
(9, 1, 5, 'write', '2021-02-13 14:53:11', '2021-02-13 14:53:11'),
(10, 1, 6, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(11, 1, 7, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(12, 1, 8, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(13, 1, 9, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(14, 1, 10, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(15, 1, 11, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(16, 1, 12, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(17, 1, 13, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(20, 1, 16, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(23, 1, 19, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(25, 1, 21, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(26, 1, 22, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(34, 1, 35, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(35, 1, 36, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(36, 1, 37, 'readonly', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(37, 1, 38, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(38, 1, 39, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(39, 1, 40, 'readonly', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(40, 1, 41, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(41, 1, 42, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(42, 1, 43, 'readonly', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(43, 1, 44, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(44, 1, 45, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(45, 1, 49, 'write', '2021-02-13 14:54:21', '2021-02-13 14:54:21'),
(46, 2, 1, 'readonly', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(47, 2, 2, 'readonly', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(48, 2, 3, 'readonly', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(49, 2, 4, 'readonly', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(50, 2, 5, 'readonly', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(51, 2, 6, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(52, 2, 7, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(53, 2, 8, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(54, 2, 9, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(55, 2, 10, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(56, 2, 11, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(57, 2, 12, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(58, 2, 13, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(61, 2, 16, 'write', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(64, 2, 19, 'write', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(66, 2, 21, 'write', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(67, 2, 22, 'write', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(75, 2, 35, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(76, 2, 36, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(77, 2, 37, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(78, 2, 38, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(79, 2, 39, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(80, 2, 40, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(81, 2, 41, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(82, 2, 42, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(83, 2, 43, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(84, 2, 44, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(85, 2, 45, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(86, 2, 49, 'invisible', '2021-02-13 14:54:54', '2021-02-13 14:54:54'),
(87, 3, 1, 'readonly', '2021-02-13 15:08:06', '2021-02-13 15:08:06'),
(88, 3, 2, 'readonly', '2021-02-13 15:08:06', '2021-02-13 15:08:06'),
(89, 3, 3, 'readonly', '2021-02-13 15:08:06', '2021-02-13 15:08:06'),
(90, 3, 4, 'readonly', '2021-02-13 15:08:06', '2021-02-13 15:08:06'),
(91, 3, 5, 'readonly', '2021-02-13 15:08:06', '2021-02-13 15:08:06'),
(92, 3, 6, 'readonly', '2021-02-13 15:08:06', '2021-02-13 15:08:06'),
(93, 3, 7, 'readonly', '2021-02-13 15:08:06', '2021-02-13 15:08:06'),
(94, 3, 8, 'readonly', '2021-02-13 15:08:06', '2021-02-13 15:08:06'),
(95, 3, 9, 'readonly', '2021-02-13 15:08:06', '2021-02-13 15:08:06'),
(96, 3, 10, 'readonly', '2021-02-13 15:08:06', '2021-02-13 15:08:06'),
(97, 3, 11, 'readonly', '2021-02-13 15:08:06', '2021-02-13 15:08:06'),
(98, 3, 12, 'readonly', '2021-02-13 15:08:06', '2021-02-13 15:08:06'),
(99, 3, 13, 'readonly', '2021-02-13 15:08:07', '2021-02-13 15:08:07'),
(102, 3, 16, 'readonly', '2021-02-13 15:08:07', '2021-02-13 15:08:07'),
(105, 3, 19, 'readonly', '2021-02-13 15:08:07', '2021-02-13 15:08:07'),
(107, 3, 21, 'readonly', '2021-02-13 15:08:07', '2021-02-13 15:08:07'),
(108, 3, 22, 'readonly', '2021-02-13 15:08:07', '2021-02-13 15:08:07'),
(116, 3, 30, 'readonly', '2021-02-13 15:08:08', '2021-02-13 15:08:08'),
(117, 3, 33, 'readonly', '2021-02-13 15:08:08', '2021-02-13 15:08:08'),
(118, 3, 35, 'readonly', '2021-02-13 15:08:08', '2021-02-13 15:08:08'),
(119, 3, 36, 'readonly', '2021-02-13 15:08:08', '2021-02-13 15:08:08'),
(120, 3, 37, 'readonly', '2021-02-13 15:08:08', '2021-02-13 15:08:08'),
(121, 3, 38, 'readonly', '2021-02-13 15:08:08', '2021-02-13 15:08:08'),
(122, 3, 39, 'readonly', '2021-02-13 15:08:08', '2021-02-13 15:08:08'),
(123, 3, 40, 'readonly', '2021-02-13 15:08:08', '2021-02-13 15:08:08'),
(124, 3, 41, 'readonly', '2021-02-13 15:08:08', '2021-02-13 15:08:08'),
(125, 3, 42, 'readonly', '2021-02-13 15:08:08', '2021-02-13 15:08:08'),
(126, 3, 43, 'readonly', '2021-02-13 15:08:08', '2021-02-13 15:08:08'),
(127, 3, 44, 'readonly', '2021-02-13 15:08:08', '2021-02-13 15:08:08'),
(128, 3, 45, 'readonly', '2021-02-13 15:08:08', '2021-02-13 15:08:08'),
(129, 3, 49, 'readonly', '2021-02-13 15:08:09', '2021-02-13 15:08:09'),
(133, 1, 50, 'write', '2021-03-27 10:37:45', '2021-03-27 10:37:45'),
(134, 1, 51, 'write', '2021-03-27 10:52:17', '2021-03-27 10:52:17'),
(135, 1, 52, 'write', '2021-03-27 10:52:47', '2021-03-27 10:52:47'),
(136, 4, 1, 'readonly', '2021-03-27 11:02:48', '2021-03-27 11:02:48'),
(137, 4, 2, 'readonly', '2021-03-27 11:02:48', '2021-03-27 11:02:48'),
(138, 4, 3, 'readonly', '2021-03-27 11:02:48', '2021-03-27 11:02:48'),
(139, 4, 4, 'readonly', '2021-03-27 11:02:48', '2021-03-27 11:02:48'),
(140, 4, 5, 'readonly', '2021-03-27 11:02:48', '2021-03-27 11:02:48'),
(141, 4, 6, 'readonly', '2021-03-27 11:02:48', '2021-03-27 11:02:48'),
(142, 4, 7, 'readonly', '2021-03-27 11:02:48', '2021-03-27 11:02:48'),
(143, 4, 8, 'readonly', '2021-03-27 11:02:48', '2021-03-27 11:02:48'),
(144, 4, 9, 'readonly', '2021-03-27 11:02:48', '2021-03-27 11:02:48'),
(145, 4, 10, 'readonly', '2021-03-27 11:02:48', '2021-03-27 11:02:48'),
(146, 4, 11, 'readonly', '2021-03-27 11:02:48', '2021-03-27 11:02:48'),
(147, 4, 12, 'readonly', '2021-03-27 11:02:48', '2021-03-27 11:02:48'),
(148, 4, 13, 'readonly', '2021-03-27 11:02:48', '2021-03-27 11:02:48'),
(149, 4, 22, 'write', '2021-03-27 11:02:49', '2021-03-27 11:02:49'),
(150, 4, 16, 'write', '2021-03-27 11:02:49', '2021-03-27 11:02:49'),
(151, 4, 19, 'write', '2021-03-27 11:02:49', '2021-03-27 11:02:49'),
(152, 4, 50, 'write', '2021-03-27 11:02:49', '2021-03-27 11:02:49'),
(153, 4, 21, 'write', '2021-03-27 11:02:49', '2021-03-27 11:02:49'),
(154, 4, 30, 'readonly', '2021-03-27 11:02:49', '2021-03-27 11:02:49'),
(155, 4, 33, 'readonly', '2021-03-27 11:02:49', '2021-03-27 11:02:49'),
(156, 4, 51, 'readonly', '2021-03-27 11:02:49', '2021-03-27 11:02:49'),
(157, 4, 52, 'readonly', '2021-03-27 11:02:49', '2021-03-27 11:02:49'),
(158, 4, 35, 'readonly', '2021-03-27 11:02:50', '2021-03-27 11:02:50'),
(159, 4, 36, 'readonly', '2021-03-27 11:02:50', '2021-03-27 11:02:50'),
(160, 4, 37, 'readonly', '2021-03-27 11:02:50', '2021-03-27 11:02:50'),
(161, 4, 38, 'readonly', '2021-03-27 11:02:50', '2021-03-27 11:02:50'),
(162, 4, 39, 'readonly', '2021-03-27 11:02:50', '2021-03-27 11:02:50'),
(163, 4, 40, 'readonly', '2021-03-27 11:02:50', '2021-03-27 11:02:50'),
(164, 4, 41, 'readonly', '2021-03-27 11:02:50', '2021-03-27 11:02:50'),
(165, 4, 42, 'readonly', '2021-03-27 11:02:50', '2021-03-27 11:02:50'),
(166, 4, 43, 'readonly', '2021-03-27 11:02:50', '2021-03-27 11:02:50'),
(167, 4, 44, 'readonly', '2021-03-27 11:02:50', '2021-03-27 11:02:50'),
(168, 4, 45, 'readonly', '2021-03-27 11:02:50', '2021-03-27 11:02:50'),
(169, 4, 49, 'readonly', '2021-03-27 11:02:50', '2021-03-27 11:02:50'),
(170, 5, 1, 'readonly', '2021-03-27 11:03:33', '2021-03-27 11:03:33'),
(171, 5, 2, 'readonly', '2021-03-27 11:03:33', '2021-03-27 11:03:33'),
(172, 5, 3, 'readonly', '2021-03-27 11:03:33', '2021-03-27 11:03:33'),
(173, 5, 4, 'readonly', '2021-03-27 11:03:33', '2021-03-27 11:03:33'),
(174, 5, 5, 'readonly', '2021-03-27 11:03:33', '2021-03-27 11:03:33'),
(175, 5, 6, 'readonly', '2021-03-27 11:03:33', '2021-03-27 11:03:33'),
(176, 5, 7, 'readonly', '2021-03-27 11:03:33', '2021-03-27 11:03:33'),
(177, 5, 8, 'readonly', '2021-03-27 11:03:33', '2021-03-27 11:03:33'),
(178, 5, 9, 'readonly', '2021-03-27 11:03:33', '2021-03-27 11:03:33'),
(179, 5, 10, 'readonly', '2021-03-27 11:03:33', '2021-03-27 11:03:33'),
(180, 5, 11, 'readonly', '2021-03-27 11:03:33', '2021-03-27 11:03:33'),
(181, 5, 12, 'readonly', '2021-03-27 11:03:33', '2021-03-27 11:03:33'),
(182, 5, 13, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(183, 5, 22, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(184, 5, 16, 'write', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(185, 5, 19, 'write', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(186, 5, 50, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(187, 5, 21, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(188, 5, 30, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(189, 5, 33, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(190, 5, 51, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(191, 5, 52, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(192, 5, 35, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(193, 5, 36, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(194, 5, 37, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(195, 5, 38, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(196, 5, 39, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(197, 5, 40, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(198, 5, 41, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(199, 5, 42, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(200, 5, 43, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(201, 5, 44, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(202, 5, 45, 'readonly', '2021-03-27 11:03:34', '2021-03-27 11:03:34'),
(203, 5, 49, 'readonly', '2021-03-27 11:03:35', '2021-03-27 11:03:35'),
(204, 1, 53, 'write', '2021-03-27 12:34:51', '2021-03-27 12:34:51'),
(205, 1, 54, 'write', '2021-03-27 12:42:05', '2021-03-27 12:42:05'),
(206, 1, 55, 'write', '2021-03-27 12:48:39', '2021-03-27 12:48:39'),
(207, 1, 56, 'write', '2021-03-27 12:50:11', '2021-03-27 12:50:11'),
(208, 1, 57, 'write', '2021-03-27 12:50:41', '2021-03-27 12:50:41'),
(209, 1, 58, 'write', '2021-03-27 12:50:51', '2021-03-27 12:50:51'),
(210, 1, 59, 'write', '2021-03-27 12:51:42', '2021-03-27 12:51:42'),
(211, 1, 60, 'write', '2021-03-27 12:52:22', '2021-03-27 12:52:22'),
(212, 1, 61, 'write', '2021-03-27 12:52:38', '2021-03-27 12:52:38'),
(213, 1, 62, 'write', '2021-03-27 12:53:04', '2021-03-27 12:53:04'),
(215, 1, 64, 'write', '2021-03-27 12:54:14', '2021-03-27 12:54:14'),
(217, 1, 66, 'write', '2021-03-27 12:55:16', '2021-03-27 12:55:16'),
(218, 1, 67, 'write', '2021-03-27 12:55:30', '2021-03-27 12:55:30'),
(219, 1, 68, 'write', '2021-03-27 12:55:51', '2021-03-27 12:55:51'),
(220, 1, 69, 'readonly', '2021-03-27 12:56:33', '2021-03-27 12:56:33'),
(221, 2, 55, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(222, 2, 56, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(223, 2, 57, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(224, 2, 58, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(225, 2, 62, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(228, 2, 66, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(229, 2, 67, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(230, 2, 68, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(231, 2, 69, 'readonly', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(232, 4, 55, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(233, 4, 56, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(234, 4, 57, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(235, 4, 58, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(236, 4, 62, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(239, 4, 66, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(240, 4, 67, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(241, 4, 68, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(242, 4, 69, 'readonly', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(243, 5, 55, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(244, 5, 56, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(245, 5, 57, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(246, 5, 58, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(247, 5, 62, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(250, 5, 66, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(251, 5, 67, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(252, 5, 68, 'write', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(253, 5, 69, 'readonly', '2021-03-27 17:54:30', '2021-03-27 17:54:30'),
(254, 1, 70, 'write', '2021-03-27 18:01:13', '2021-03-27 18:01:13'),
(255, 1, 71, 'write', '2021-03-27 18:02:15', '2021-03-27 18:02:15'),
(256, 1, 72, 'write', '2021-03-27 18:02:48', '2021-03-27 18:02:48'),
(257, 1, 73, 'write', '2021-03-27 18:03:31', '2021-03-27 18:03:31'),
(258, 1, 74, 'write', '2021-03-27 18:04:26', '2021-03-27 18:04:26'),
(259, 1, 75, 'write', '2021-03-27 18:09:05', '2021-03-27 18:09:05'),
(260, 1, 76, 'readonly', '2021-03-27 18:09:47', '2021-03-27 18:09:47'),
(261, 2, 70, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(262, 2, 71, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(263, 2, 72, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(264, 2, 73, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(265, 2, 74, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(266, 2, 75, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(267, 2, 76, 'readonly', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(268, 4, 70, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(269, 4, 71, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(270, 4, 72, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(271, 4, 73, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(272, 4, 74, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(273, 4, 75, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(274, 4, 76, 'readonly', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(275, 5, 70, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(276, 5, 71, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(277, 5, 72, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(278, 5, 73, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(279, 5, 74, 'write', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(280, 5, 75, 'invisible', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(281, 5, 76, 'readonly', '2021-03-27 18:10:01', '2021-03-27 18:10:01'),
(282, 1, 77, 'write', '2021-03-27 18:10:49', '2021-03-27 18:10:49'),
(283, 1, 78, 'write', '2021-03-27 18:11:00', '2021-03-27 18:11:00'),
(284, 1, 79, 'write', '2021-03-27 18:11:32', '2021-03-27 18:11:32'),
(285, 1, 80, 'write', '2021-03-27 18:11:51', '2021-03-27 18:11:51'),
(286, 4, 53, 'write', '2021-03-29 04:16:04', '2021-03-29 04:16:04'),
(287, 4, 54, 'write', '2021-03-29 04:16:04', '2021-03-29 04:16:04'),
(288, 4, 59, 'write', '2021-03-29 04:16:04', '2021-03-29 04:16:04'),
(289, 4, 60, 'write', '2021-03-29 04:16:04', '2021-03-29 04:16:04'),
(290, 4, 61, 'write', '2021-03-29 04:16:04', '2021-03-29 04:16:04'),
(291, 4, 64, 'write', '2021-03-29 04:16:04', '2021-03-29 04:16:04'),
(292, 4, 77, 'write', '2021-03-29 04:16:04', '2021-03-29 04:16:04'),
(293, 4, 78, 'write', '2021-03-29 04:16:04', '2021-03-29 04:16:04'),
(294, 4, 79, 'write', '2021-03-29 04:16:04', '2021-03-29 04:16:04'),
(295, 4, 80, 'readonly', '2021-03-29 04:16:04', '2021-03-29 04:16:04'),
(296, 1, 81, 'write', '2021-03-29 04:36:24', '2021-03-29 04:36:24'),
(297, 4, 81, 'readonly', '2021-03-29 05:07:08', '2021-03-29 05:07:08'),
(298, 5, 81, 'invisible', '2021-03-29 05:11:43', '2021-03-29 05:11:43'),
(299, 5, 53, 'write', '2021-03-29 05:11:43', '2021-03-29 05:11:43'),
(300, 5, 54, 'write', '2021-03-29 05:11:43', '2021-03-29 05:11:43'),
(301, 5, 59, 'write', '2021-03-29 05:11:43', '2021-03-29 05:11:43'),
(302, 5, 60, 'write', '2021-03-29 05:11:43', '2021-03-29 05:11:43'),
(303, 5, 61, 'write', '2021-03-29 05:11:43', '2021-03-29 05:11:43'),
(304, 5, 64, 'write', '2021-03-29 05:11:43', '2021-03-29 05:11:43'),
(305, 5, 77, 'write', '2021-03-29 05:11:43', '2021-03-29 05:11:43'),
(306, 5, 78, 'write', '2021-03-29 05:11:43', '2021-03-29 05:11:43'),
(307, 5, 79, 'write', '2021-03-29 05:11:43', '2021-03-29 05:11:43'),
(308, 5, 80, 'readonly', '2021-03-29 05:11:43', '2021-03-29 05:11:43'),
(309, 1, 82, 'write', '2021-03-29 07:27:37', '2021-03-29 07:27:37'),
(310, 1, 83, 'write', '2021-03-29 07:30:06', '2021-03-29 07:30:06'),
(311, 1, 84, 'write', '2021-03-29 07:30:56', '2021-03-29 07:30:56'),
(312, 1, 85, 'write', '2021-03-29 07:31:08', '2021-03-29 07:31:08'),
(313, 1, 86, 'write', '2021-03-29 07:36:40', '2021-03-29 07:36:40'),
(314, 1, 87, 'write', '2021-03-29 07:38:05', '2021-03-29 07:38:05'),
(315, 1, 88, 'write', '2021-03-29 07:38:28', '2021-03-29 07:38:28'),
(317, 1, 90, 'write', '2021-03-30 06:36:59', '2021-03-30 06:36:59'),
(318, 1, 91, 'write', '2021-03-30 06:39:04', '2021-03-30 06:39:04'),
(319, 1, 92, 'write', '2021-03-30 06:39:43', '2021-03-30 06:39:43'),
(320, 1, 93, 'write', '2021-03-30 06:40:20', '2021-03-30 06:40:20'),
(321, 4, 86, 'write', '2021-03-30 07:53:44', '2021-03-30 07:53:44'),
(322, 4, 87, 'write', '2021-03-30 07:53:44', '2021-03-30 07:53:44'),
(323, 4, 88, 'write', '2021-03-30 07:53:44', '2021-03-30 07:53:44'),
(325, 4, 82, 'write', '2021-03-30 07:53:44', '2021-03-30 07:53:44'),
(326, 4, 83, 'write', '2021-03-30 07:53:44', '2021-03-30 07:53:44'),
(327, 4, 84, 'write', '2021-03-30 07:53:44', '2021-03-30 07:53:44'),
(328, 4, 85, 'write', '2021-03-30 07:53:44', '2021-03-30 07:53:44'),
(329, 4, 90, 'write', '2021-03-30 07:53:44', '2021-03-30 07:53:44'),
(330, 4, 91, 'write', '2021-03-30 07:53:44', '2021-03-30 07:53:44'),
(331, 4, 92, 'write', '2021-03-30 07:53:44', '2021-03-30 07:53:44'),
(332, 4, 93, 'write', '2021-03-30 07:53:44', '2021-03-30 07:53:44'),
(333, 5, 86, 'write', '2021-03-31 13:03:33', '2021-03-31 13:03:33'),
(334, 5, 87, 'write', '2021-03-31 13:03:33', '2021-03-31 13:03:33'),
(335, 5, 88, 'write', '2021-03-31 13:03:33', '2021-03-31 13:03:33'),
(337, 5, 82, 'write', '2021-03-31 13:03:33', '2021-03-31 13:03:33'),
(338, 5, 83, 'write', '2021-03-31 13:03:33', '2021-03-31 13:03:33'),
(339, 5, 84, 'write', '2021-03-31 13:03:33', '2021-03-31 13:03:33'),
(340, 5, 85, 'write', '2021-03-31 13:03:33', '2021-03-31 13:03:33'),
(341, 5, 90, 'invisible', '2021-03-31 13:03:33', '2021-03-31 13:03:33'),
(342, 5, 91, 'invisible', '2021-03-31 13:03:33', '2021-03-31 13:03:33'),
(343, 5, 92, 'invisible', '2021-03-31 13:03:33', '2021-03-31 13:03:33'),
(344, 5, 93, 'invisible', '2021-03-31 13:03:33', '2021-03-31 13:03:33'),
(345, 1, 94, 'write', '2021-03-31 16:52:57', '2021-03-31 16:52:57'),
(346, 1, 95, 'write', '2021-03-31 16:53:17', '2021-03-31 16:53:17'),
(347, 1, 96, 'write', '2021-03-31 16:53:39', '2021-03-31 16:53:39'),
(348, 1, 97, 'readonly', '2021-03-31 16:54:04', '2021-03-31 16:54:04'),
(349, 2, 94, 'write', '2021-03-31 17:05:47', '2021-03-31 17:05:47'),
(350, 2, 95, 'write', '2021-03-31 17:05:47', '2021-03-31 17:05:47'),
(351, 2, 96, 'write', '2021-03-31 17:05:47', '2021-03-31 17:05:47'),
(352, 2, 97, 'readonly', '2021-03-31 17:05:47', '2021-03-31 17:05:47'),
(353, 4, 94, 'invisible', '2021-03-31 17:05:47', '2021-03-31 17:05:47'),
(354, 4, 95, 'invisible', '2021-03-31 17:05:47', '2021-03-31 17:05:47'),
(355, 4, 96, 'invisible', '2021-03-31 17:05:47', '2021-03-31 17:05:47'),
(356, 4, 97, 'invisible', '2021-03-31 17:05:47', '2021-03-31 17:05:47'),
(357, 5, 94, 'invisible', '2021-03-31 17:05:47', '2021-03-31 17:05:47'),
(358, 5, 95, 'invisible', '2021-03-31 17:05:47', '2021-03-31 17:05:47'),
(359, 5, 96, 'invisible', '2021-03-31 17:05:47', '2021-03-31 17:05:47'),
(360, 5, 97, 'invisible', '2021-03-31 17:05:47', '2021-03-31 17:05:47'),
(361, 6, 1, 'readonly', '2021-04-01 13:09:10', '2021-04-01 13:09:10'),
(362, 6, 2, 'readonly', '2021-04-01 13:09:10', '2021-04-01 13:09:10'),
(363, 6, 3, 'readonly', '2021-04-01 13:09:10', '2021-04-01 13:09:10'),
(364, 6, 4, 'readonly', '2021-04-01 13:09:10', '2021-04-01 13:09:10'),
(365, 6, 5, 'readonly', '2021-04-01 13:09:10', '2021-04-01 13:09:10'),
(366, 6, 81, 'readonly', '2021-04-01 13:09:10', '2021-04-01 13:09:10'),
(367, 6, 6, 'readonly', '2021-04-01 13:09:11', '2021-04-01 13:09:11'),
(368, 6, 7, 'readonly', '2021-04-01 13:09:11', '2021-04-01 13:09:11'),
(369, 6, 8, 'readonly', '2021-04-01 13:09:11', '2021-04-01 13:09:11'),
(370, 6, 9, 'readonly', '2021-04-01 13:09:11', '2021-04-01 13:09:11'),
(371, 6, 10, 'readonly', '2021-04-01 13:09:11', '2021-04-01 13:09:11'),
(372, 6, 11, 'readonly', '2021-04-01 13:09:11', '2021-04-01 13:09:11'),
(373, 6, 12, 'readonly', '2021-04-01 13:09:11', '2021-04-01 13:09:11'),
(374, 6, 13, 'readonly', '2021-04-01 13:09:12', '2021-04-01 13:09:12'),
(375, 6, 22, 'readonly', '2021-04-01 13:09:12', '2021-04-01 13:09:12'),
(376, 6, 16, 'readonly', '2021-04-01 13:09:12', '2021-04-01 13:09:12'),
(377, 6, 19, 'readonly', '2021-04-01 13:09:12', '2021-04-01 13:09:12'),
(378, 6, 50, 'readonly', '2021-04-01 13:09:12', '2021-04-01 13:09:12'),
(379, 6, 21, 'readonly', '2021-04-01 13:09:12', '2021-04-01 13:09:12'),
(380, 6, 30, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(381, 6, 33, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(382, 6, 51, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(383, 6, 52, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(384, 6, 35, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(385, 6, 36, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(386, 6, 37, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(387, 6, 38, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(388, 6, 39, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(389, 6, 40, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(390, 6, 41, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(391, 6, 42, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(392, 6, 43, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(393, 6, 44, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(394, 6, 45, 'readonly', '2021-04-01 13:09:13', '2021-04-01 13:09:13'),
(395, 6, 49, 'readonly', '2021-04-01 13:09:15', '2021-04-01 13:09:15'),
(396, 6, 53, 'readonly', '2021-04-01 13:09:15', '2021-04-01 13:09:15'),
(397, 6, 54, 'readonly', '2021-04-01 13:09:15', '2021-04-01 13:09:15'),
(398, 6, 55, 'readonly', '2021-04-01 13:09:16', '2021-04-01 13:09:16'),
(399, 6, 56, 'readonly', '2021-04-01 13:09:16', '2021-04-01 13:09:16'),
(400, 6, 57, 'readonly', '2021-04-01 13:09:16', '2021-04-01 13:09:16'),
(401, 6, 58, 'readonly', '2021-04-01 13:09:16', '2021-04-01 13:09:16'),
(402, 6, 62, 'readonly', '2021-04-01 13:09:16', '2021-04-01 13:09:16'),
(403, 6, 86, 'readonly', '2021-04-01 13:09:16', '2021-04-01 13:09:16'),
(405, 6, 68, 'readonly', '2021-04-01 13:09:16', '2021-04-01 13:09:16'),
(406, 6, 66, 'readonly', '2021-04-01 13:09:16', '2021-04-01 13:09:16'),
(407, 6, 67, 'readonly', '2021-04-01 13:09:16', '2021-04-01 13:09:16'),
(408, 6, 87, 'readonly', '2021-04-01 13:09:16', '2021-04-01 13:09:16'),
(409, 6, 88, 'readonly', '2021-04-01 13:09:16', '2021-04-01 13:09:16'),
(410, 6, 69, 'readonly', '2021-04-01 13:09:16', '2021-04-01 13:09:16'),
(411, 6, 59, 'readonly', '2021-04-01 13:09:17', '2021-04-01 13:09:17'),
(412, 6, 60, 'readonly', '2021-04-01 13:09:17', '2021-04-01 13:09:17'),
(413, 6, 61, 'readonly', '2021-04-01 13:09:17', '2021-04-01 13:09:17'),
(414, 6, 64, 'readonly', '2021-04-01 13:09:18', '2021-04-01 13:09:18'),
(415, 6, 70, 'readonly', '2021-04-01 13:09:18', '2021-04-01 13:09:18'),
(416, 6, 71, 'readonly', '2021-04-01 13:09:18', '2021-04-01 13:09:18'),
(417, 6, 72, 'readonly', '2021-04-01 13:09:18', '2021-04-01 13:09:18'),
(418, 6, 73, 'readonly', '2021-04-01 13:09:18', '2021-04-01 13:09:18'),
(419, 6, 74, 'readonly', '2021-04-01 13:09:18', '2021-04-01 13:09:18'),
(420, 6, 75, 'readonly', '2021-04-01 13:09:18', '2021-04-01 13:09:18'),
(422, 6, 76, 'readonly', '2021-04-01 13:09:18', '2021-04-01 13:09:18'),
(423, 6, 77, 'readonly', '2021-04-01 13:09:19', '2021-04-01 13:09:19'),
(424, 6, 78, 'readonly', '2021-04-01 13:09:19', '2021-04-01 13:09:19'),
(425, 6, 79, 'readonly', '2021-04-01 13:09:19', '2021-04-01 13:09:19'),
(426, 6, 80, 'readonly', '2021-04-01 13:09:19', '2021-04-01 13:09:19'),
(427, 6, 82, 'readonly', '2021-04-01 13:09:20', '2021-04-01 13:09:20'),
(428, 6, 83, 'readonly', '2021-04-01 13:09:20', '2021-04-01 13:09:20'),
(429, 6, 84, 'readonly', '2021-04-01 13:09:20', '2021-04-01 13:09:20'),
(430, 6, 85, 'readonly', '2021-04-01 13:09:20', '2021-04-01 13:09:20'),
(431, 6, 90, 'readonly', '2021-04-01 13:09:21', '2021-04-01 13:09:21'),
(432, 6, 91, 'readonly', '2021-04-01 13:09:21', '2021-04-01 13:09:21'),
(433, 6, 92, 'readonly', '2021-04-01 13:09:21', '2021-04-01 13:09:21'),
(434, 6, 93, 'readonly', '2021-04-01 13:09:21', '2021-04-01 13:09:21'),
(435, 6, 94, 'readonly', '2021-04-01 13:09:21', '2021-04-01 13:09:21'),
(436, 6, 95, 'readonly', '2021-04-01 13:09:21', '2021-04-01 13:09:21'),
(437, 6, 96, 'readonly', '2021-04-01 13:09:21', '2021-04-01 13:09:21'),
(438, 6, 97, 'readonly', '2021-04-01 13:09:21', '2021-04-01 13:09:21'),
(439, 2, 81, 'readonly', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(440, 2, 50, 'invisible', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(441, 2, 51, 'invisible', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(442, 2, 52, 'invisible', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(443, 2, 53, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(444, 2, 54, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(445, 2, 86, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(446, 2, 87, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(447, 2, 88, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(448, 2, 59, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(449, 2, 60, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(450, 2, 61, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(451, 2, 64, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(453, 2, 77, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(454, 2, 78, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(455, 2, 79, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(456, 2, 80, 'readonly', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(457, 2, 82, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(458, 2, 83, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(459, 2, 84, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(460, 2, 85, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(461, 2, 90, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(462, 2, 91, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(463, 2, 92, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(464, 2, 93, 'write', '2021-04-03 15:42:01', '2021-04-03 15:42:01'),
(465, 1, 98, 'write', '2021-04-05 10:20:45', '2021-04-05 10:20:45'),
(466, 2, 98, 'write', '2021-04-05 10:35:52', '2021-04-05 10:35:52'),
(467, 4, 98, 'write', '2021-04-05 10:36:12', '2021-04-05 10:36:12'),
(468, 5, 98, 'write', '2021-04-05 10:36:35', '2021-04-05 10:36:35'),
(469, 1, 99, 'write', '2023-09-03 11:23:25', '2023-09-03 11:23:25'),
(470, 1, 100, 'write', '2023-09-03 11:26:18', '2023-09-03 11:26:18'),
(471, 2, 99, 'invisible', '2023-09-03 11:28:20', '2023-09-03 11:28:20'),
(472, 4, 99, 'invisible', '2023-09-03 11:28:20', '2023-09-03 11:28:20'),
(473, 5, 99, 'invisible', '2023-09-03 11:28:20', '2023-09-03 11:28:20'),
(474, 1, 101, 'write', '2023-09-03 11:33:34', '2023-09-03 11:33:34'),
(475, 1, 102, 'write', '2023-09-03 11:37:25', '2023-09-03 11:37:25'),
(493, 1, 151, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(494, 1, 136, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(495, 1, 137, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(496, 1, 138, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(497, 1, 139, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(498, 1, 140, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(499, 1, 146, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(500, 1, 141, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(501, 1, 144, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(502, 1, 142, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(503, 1, 143, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(504, 1, 148, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(505, 1, 150, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(506, 1, 145, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(507, 1, 149, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(508, 1, 147, 'write', '2023-09-03 12:36:59', '2023-09-03 12:36:59'),
(509, 1, 156, 'write', '2023-09-06 19:39:43', '2023-09-06 19:39:43'),
(510, 1, 157, 'write', '2023-09-06 19:40:49', '2023-09-06 19:40:49'),
(511, 1, 158, 'write', '2023-09-06 19:41:51', '2023-09-06 19:41:51'),
(512, 1, 159, 'write', '2023-09-07 09:58:12', '2023-09-07 09:58:12'),
(513, 1, 160, 'write', '2023-09-07 09:58:56', '2023-09-07 09:58:56'),
(514, 1, 161, 'write', '2023-09-07 12:14:53', '2023-09-07 12:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `targets`
--

CREATE TABLE `targets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `amount_target` decimal(10,2) NOT NULL DEFAULT 0.00,
  `calls_target` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_target_id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `targets`
--

INSERT INTO `targets` (`id`, `employee_id`, `amount_target`, `calls_target`, `created_at`, `updated_at`, `employee_target_id`, `activity_id`) VALUES
(6, 2, '100.00', 200, '2023-09-06 10:58:07', '2023-09-06 10:58:07', 3, 1),
(7, 2, '10000.00', 2, '2023-09-06 10:58:07', '2023-09-06 10:58:07', 3, 2),
(8, 2, '20.00', 20, '2023-09-06 10:58:07', '2023-09-06 10:58:07', 3, 1),
(9, 2, '300.00', 400, '2023-09-06 10:58:07', '2023-09-06 10:58:07', 3, 1),
(10, 2, '200.00', 100, '2023-09-07 10:54:59', '2023-09-07 10:54:59', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `path` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `hash` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `context_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `email` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Employee',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `context_id`, `email`, `password`, `type`, `remember_token`, `deleted_at`, `created_at`, `updated_at`, `active`) VALUES
(1, 'Admin', 1, 'admin@ourcrm.info', '$2y$10$2eoxvdY3gfYgxvtTO7b54.OC.YLLgI0q50ek3Qw1/1GF/pVWvh9SW', 'Employee', NULL, NULL, '2021-02-10 14:10:32', '2023-09-07 08:41:06', 1),
(2, 'Test Employee', 2, 'sales@gmail.com', '$2y$10$1bxwc5YgE6th3XnXyP0cHuAU2cxxLKsnE361Lj0InM643ho/iilkq', 'Employee', NULL, NULL, '2023-09-06 08:25:20', '2023-09-06 08:25:20', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activates`
--
ALTER TABLE `activates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areas_city_id_foreign` (`city_id`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachments_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_city_id_foreign` (`city_id`),
  ADD KEY `contacts_area_id_foreign` (`area_id`),
  ADD KEY `contacts_contact_source_id_foreign` (`contact_source_id`),
  ADD KEY `contacts_created_by_foreign` (`created_by`),
  ADD KEY `contacts_job_title_id_foreign` (`job_title_id`),
  ADD KEY `contacts_industry_id_foreign` (`industry_id`),
  ADD KEY `contacts_major_id_foreign` (`major_id`),
  ADD KEY `contacts_activity_id_foreign` (`activity_id`);

--
-- Indexes for table `contact_categories`
--
ALTER TABLE `contact_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_sources`
--
ALTER TABLE `contact_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_mobile_unique` (`mobile`),
  ADD KEY `customers_job_title_id_foreign` (`job_title_id`),
  ADD KEY `customers_contact_category_id_foreign` (`contact_category_id`),
  ADD KEY `customers_contact_source_id_foreign` (`contact_source_id`),
  ADD KEY `customers_city_id_foreign` (`city_id`),
  ADD KEY `customers_area_id_foreign` (`area_id`),
  ADD KEY `customers_major_id_foreign` (`major_id`),
  ADD KEY `customers_activity_id_foreign` (`activity_id`),
  ADD KEY `customers_created_by_foreign` (`created_by`),
  ADD KEY `customers_industry_id_foreign` (`industry_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD KEY `employees_dept_foreign` (`dept`);

--
-- Indexes for table `employee_targets`
--
ALTER TABLE `employee_targets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_targets_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `industries`
--
ALTER TABLE `industries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interests_activity_id_foreign` (`activity_id`);

--
-- Indexes for table `interest_meeting`
--
ALTER TABLE `interest_meeting`
  ADD PRIMARY KEY (`interest_id`,`meeting_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`);

--
-- Indexes for table `job_titles`
--
ALTER TABLE `job_titles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `la_configs`
--
ALTER TABLE `la_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `la_menus`
--
ALTER TABLE `la_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_cteagories`
--
ALTER TABLE `lead_cteagories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_cteagories_contact_category_id_foreign` (`contact_category_id`),
  ADD KEY `lead_cteagories_contact_id_foreign` (`contact_id`);

--
-- Indexes for table `lead_histories`
--
ALTER TABLE `lead_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `majors`
--
ALTER TABLE `majors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `majors_industry_id_foreign` (`industry_id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meetings_contact_id_foreign` (`contact_id`),
  ADD KEY `meetings_created_by_foreign` (`created_by`);

--
-- Indexes for table `meeting_notes`
--
ALTER TABLE `meeting_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meeting_notes_meeting_id_foreign` (`meeting_id`),
  ADD KEY `meeting_notes_created_by_foreign` (`created_by`);

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
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_fields`
--
ALTER TABLE `module_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_fields_module_foreign` (`module`),
  ADD KEY `module_fields_field_type_foreign` (`field_type`);

--
-- Indexes for table `module_field_types`
--
ALTER TABLE `module_field_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_dept_foreign` (`dept`),
  ADD KEY `notifications_employee_id_foreign` (`employee_id`),
  ADD KEY `notifications_created_by_foreign` (`created_by`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `organizations_name_unique` (`name`),
  ADD UNIQUE KEY `organizations_email_unique` (`email`),
  ADD KEY `organizations_assigned_to_foreign` (`assigned_to`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `role_module`
--
ALTER TABLE `role_module`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_module_role_id_foreign` (`role_id`),
  ADD KEY `role_module_module_id_foreign` (`module_id`);

--
-- Indexes for table `role_module_fields`
--
ALTER TABLE `role_module_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_module_fields_role_id_foreign` (`role_id`),
  ADD KEY `role_module_fields_field_id_foreign` (`field_id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `targets`
--
ALTER TABLE `targets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploads_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activates`
--
ALTER TABLE `activates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_categories`
--
ALTER TABLE `contact_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_sources`
--
ALTER TABLE `contact_sources`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee_targets`
--
ALTER TABLE `employee_targets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `industries`
--
ALTER TABLE `industries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `interests`
--
ALTER TABLE `interests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job_titles`
--
ALTER TABLE `job_titles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `la_configs`
--
ALTER TABLE `la_configs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `la_menus`
--
ALTER TABLE `la_menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `lead_cteagories`
--
ALTER TABLE `lead_cteagories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lead_histories`
--
ALTER TABLE `lead_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `majors`
--
ALTER TABLE `majors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `meeting_notes`
--
ALTER TABLE `meeting_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `module_fields`
--
ALTER TABLE `module_fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `module_field_types`
--
ALTER TABLE `module_field_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role_module`
--
ALTER TABLE `role_module`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_module_fields`
--
ALTER TABLE `role_module_fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=515;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `targets`
--
ALTER TABLE `targets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `areas_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activates` (`id`),
  ADD CONSTRAINT `contacts_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `contacts_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `contacts_contact_source_id_foreign` FOREIGN KEY (`contact_source_id`) REFERENCES `contact_sources` (`id`),
  ADD CONSTRAINT `contacts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `contacts_industry_id_foreign` FOREIGN KEY (`industry_id`) REFERENCES `industries` (`id`),
  ADD CONSTRAINT `contacts_job_title_id_foreign` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`),
  ADD CONSTRAINT `contacts_major_id_foreign` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activates` (`id`),
  ADD CONSTRAINT `customers_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `customers_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `customers_contact_category_id_foreign` FOREIGN KEY (`contact_category_id`) REFERENCES `contact_categories` (`id`),
  ADD CONSTRAINT `customers_contact_source_id_foreign` FOREIGN KEY (`contact_source_id`) REFERENCES `contact_sources` (`id`),
  ADD CONSTRAINT `customers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `customers_industry_id_foreign` FOREIGN KEY (`industry_id`) REFERENCES `industries` (`id`),
  ADD CONSTRAINT `customers_job_title_id_foreign` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`),
  ADD CONSTRAINT `customers_major_id_foreign` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_dept_foreign` FOREIGN KEY (`dept`) REFERENCES `departments` (`id`);

--
-- Constraints for table `employee_targets`
--
ALTER TABLE `employee_targets`
  ADD CONSTRAINT `employee_targets_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `interests`
--
ALTER TABLE `interests`
  ADD CONSTRAINT `interests_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activates` (`id`);

--
-- Constraints for table `lead_cteagories`
--
ALTER TABLE `lead_cteagories`
  ADD CONSTRAINT `lead_cteagories_contact_category_id_foreign` FOREIGN KEY (`contact_category_id`) REFERENCES `contact_categories` (`id`),
  ADD CONSTRAINT `lead_cteagories_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`);

--
-- Constraints for table `majors`
--
ALTER TABLE `majors`
  ADD CONSTRAINT `majors_industry_id_foreign` FOREIGN KEY (`industry_id`) REFERENCES `industries` (`id`);

--
-- Constraints for table `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `meetings_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`),
  ADD CONSTRAINT `meetings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `employees` (`id`);

--
-- Constraints for table `meeting_notes`
--
ALTER TABLE `meeting_notes`
  ADD CONSTRAINT `meeting_notes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `meeting_notes_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`);

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
-- Constraints for table `module_fields`
--
ALTER TABLE `module_fields`
  ADD CONSTRAINT `module_fields_field_type_foreign` FOREIGN KEY (`field_type`) REFERENCES `module_field_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `module_fields_module_foreign` FOREIGN KEY (`module`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `employees` (`id`);

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `organizations_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `employees` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_module`
--
ALTER TABLE `role_module`
  ADD CONSTRAINT `role_module_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_module_fields`
--
ALTER TABLE `role_module_fields`
  ADD CONSTRAINT `role_module_fields_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `module_fields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
